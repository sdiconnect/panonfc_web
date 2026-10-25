<?php
/**
 * Front-end forms: simple Contact + full Devis (quote).
 *
 * Reliability model (important on a heavily-cached site):
 *   - POST is processed on `template_redirect`, BEFORE the (slow, uncached)
 *     page renders. On success we send mail non-blocking and 302-redirect to
 *     ?envoi=ok (Post/Redirect/Get) — the POST never re-renders the page, and
 *     the success state survives as a URL param (reliable for GTM).
 *   - Anti-bot: honeypot + signed time-trap + nonce. Because a cached page
 *     bakes the nonce and the time token, both would go stale; a tiny REST
 *     endpoint + forms.js refresh them client-side so cached pages still work.
 *     The time-trap no longer hard-rejects "old" tokens (that silently dropped
 *     submissions from long-cached pages).
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-request result of a submission (validation errors are shown inline so
 * fields can be repopulated; success is shown after the PRG redirect).
 *
 * @return array{status:string,errors:array,message:string,form:string}
 */
function &panonfc_form_state() {
	static $state = array(
		'status'  => '',
		'errors'  => array(),
		'message' => '',
		'form'    => '',
	);
	return $state;
}

/**
 * Recipient address for form submissions (Contact + Devis).
 * Uses the WordPress admin email; override with the filter if needed.
 */
function panonfc_contact_recipient() {
	return apply_filters( 'panonfc_contact_recipient', get_option( 'admin_email' ) );
}

/* ============================================================
   Anti-bot: honeypot + signed time-trap (cache-safe)
   ============================================================ */

/**
 * A fresh signed time token "unixtime:hmac".
 */
function panonfc_time_token() {
	$t = time();
	return $t . ':' . hash_hmac( 'sha256', (string) $t, wp_salt( 'auth' ) );
}

/**
 * Output the hidden anti-bot fields inside a form.
 */
function panonfc_antibot_render() {
	echo '<div class="form-hp" aria-hidden="true">';
	echo '<label for="panonfc_website">' . esc_html__( 'Ne pas remplir ce champ', 'panonfc' ) . '</label>';
	echo '<input type="text" id="panonfc_website" name="panonfc_website" tabindex="-1" autocomplete="off">';
	echo '</div>';
	printf( '<input type="hidden" name="panonfc_t" value="%s">', esc_attr( panonfc_time_token() ) );
}

/**
 * Whether the current POST looks like a bot.
 *
 * @return bool
 */
function panonfc_is_bot() {
	// Honeypot must stay empty.
	if ( ! empty( $_POST['panonfc_website'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return true;
	}

	$raw = isset( $_POST['panonfc_t'] ) ? sanitize_text_field( wp_unslash( $_POST['panonfc_t'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === $raw || false === strpos( $raw, ':' ) ) {
		return true;
	}
	list( $t, $sig ) = explode( ':', $raw, 2 );
	if ( ! ctype_digit( $t ) ) {
		return true;
	}
	if ( ! hash_equals( hash_hmac( 'sha256', $t, wp_salt( 'auth' ) ), $sig ) ) {
		return true;
	}
	// Too fast = bot. No upper bound on purpose: a long-cached page keeps an
	// old baked token, and we must not silently drop a real human's submission.
	if ( ( time() - (int) $t ) < 2 ) {
		return true;
	}

	return false;
}

/* ============================================================
   Anti-abuse: content filter + rate limit
   ------------------------------------------------------------
   Octobre 2026 : des robots soumettaient le formulaire en masse avec
   l'adresse e-mail d'un tiers et un lien dans le champ « Nom », pour que
   le site envoie l'accusé de réception (avec leur lien) à ce tiers.
   L'accusé de réception automatique a été supprimé ; les soumissions
   suspectes ou trop nombreuses reçoivent un faux succès, sans e-mail.
   ============================================================ */

/**
 * Whether the submitted fields look like spam.
 *
 * @param array $fields Sanitized fields.
 * @return bool
 */
function panonfc_form_is_spam( $fields ) {
	$url_re = '~(https?:|www\.|://|\.(com|net|org|ru|cn|xyz|top|info|biz|vn|io)\b)~i';

	// Short identity fields must never contain a link.
	foreach ( array( 'nom', 'societe', 'tel' ) as $key ) {
		if ( ! empty( $fields[ $key ] ) && preg_match( $url_re, $fields[ $key ] ) ) {
			return true;
		}
	}
	if ( isset( $fields['nom'] ) && mb_strlen( $fields['nom'] ) > 80 ) {
		return true;
	}
	// A real request rarely carries more than two links.
	if ( ! empty( $fields['message'] ) && preg_match_all( '~(https?://|www\.)~i', $fields['message'] ) > 2 ) {
		return true;
	}

	return (bool) apply_filters( 'panonfc_form_is_spam', false, $fields );
}

/**
 * Count a submission and say whether it is within the limits
 * (per IP: 3 per 15 min and 10 per day; whole site: 30 per hour).
 *
 * @return bool True if the submission may send mail.
 */
function panonfc_form_rate_ok() {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = substr( hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) ), 0, 20 );

	$limits = apply_filters(
		'panonfc_form_rate_limits',
		array(
			'pf_ip15_' . $key => array( 3, 15 * MINUTE_IN_SECONDS ),
			'pf_ipd_' . $key  => array( 10, DAY_IN_SECONDS ),
			'pf_site_h'       => array( 30, HOUR_IN_SECONDS ),
		)
	);

	$ok = true;
	foreach ( $limits as $name => $limit ) {
		list( $max, $ttl ) = $limit;
		$data = get_transient( $name );
		if ( ! is_array( $data ) || empty( $data['exp'] ) || $data['exp'] < time() ) {
			$data = array( 'n' => 0, 'exp' => time() + $ttl );
		}
		++$data['n'];
		set_transient( $name, $data, max( 1, $data['exp'] - time() ) );
		if ( $data['n'] > $max ) {
			$ok = false;
		}
	}

	return $ok;
}

/* ============================================================
   Fresh tokens via REST (so cached form pages still submit)
   ============================================================ */

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'panonfc/v1',
			'/form-token',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => function () {
					$response = new WP_REST_Response(
						array(
							'nonce' => wp_create_nonce( 'panonfc_form' ),
							't'     => panonfc_time_token(),
						)
					);
					$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
					return $response;
				},
			)
		);
	}
);

/* ============================================================
   Handler
   ============================================================ */

/**
 * Build the PRG redirect URL back to the form page.
 *
 * @param string $status ok|error
 */
function panonfc_form_redirect_url( $status ) {
	$base = wp_get_referer();
	if ( ! $base ) {
		$base = home_url( add_query_arg( array() ) );
	}
	$base = remove_query_arg( array( 'envoi' ), $base );
	return add_query_arg( 'envoi', $status, $base ) . '#form';
}

/**
 * Send the response, then (non-blocking) the emails, then stop.
 *
 * @param string   $status   ok|error for the redirect.
 * @param callable $mailer   Optional callback that sends the emails.
 */
function panonfc_form_finish( $status, $mailer = null ) {
	wp_safe_redirect( panonfc_form_redirect_url( $status ) );

	// Flush the redirect to the browser, then keep running to send mail.
	if ( function_exists( 'fastcgi_finish_request' ) ) {
		fastcgi_finish_request();
	}
	if ( is_callable( $mailer ) ) {
		call_user_func( $mailer );
	}
	exit;
}

/**
 * Process a submission early in the request.
 */
function panonfc_handle_form() {
	if ( empty( $_POST['panonfc_form'] ) ) {
		return;
	}
	$type          = sanitize_key( wp_unslash( $_POST['panonfc_form'] ) );
	$state         = &panonfc_form_state();
	$state['form'] = $type;

	// Nonce.
	if ( empty( $_POST['panonfc_form_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['panonfc_form_nonce'] ) ), 'panonfc_form' ) ) {
		$state['status']  = 'error';
		$state['message'] = __( 'La session a expiré. Merci de renvoyer le formulaire.', 'panonfc' );
		return;
	}

	// Anti-bot — redirect to a fake success (no mail) so bots get no signal.
	if ( panonfc_is_bot() ) {
		panonfc_form_finish( 'ok' );
	}

	if ( 'contact' === $type ) {
		panonfc_process_contact( $state );
	} else {
		panonfc_process_devis( $state );
	}
}
add_action( 'template_redirect', 'panonfc_handle_form' );

/**
 * Simple contact form.
 */
function panonfc_process_contact( &$state ) {
	$fields = array(
		'nom'     => sanitize_text_field( wp_unslash( $_POST['nom'] ?? '' ) ),
		'email'   => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'tel'     => sanitize_text_field( wp_unslash( $_POST['tel'] ?? '' ) ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'consent' => ! empty( $_POST['consent'] ),
	);

	$errors = array();
	if ( '' === $fields['nom'] ) {
		$errors['nom'] = __( 'Votre nom est requis.', 'panonfc' );
	}
	if ( ! is_email( $fields['email'] ) ) {
		$errors['email'] = __( 'Un email valide est requis.', 'panonfc' );
	}
	if ( '' === $fields['message'] ) {
		$errors['message'] = __( 'Merci d\'écrire un message.', 'panonfc' );
	}
	if ( ! $fields['consent'] ) {
		$errors['consent'] = __( 'Merci de cocher la case de consentement.', 'panonfc' );
	}

	if ( $errors ) {
		$state['status']  = 'error';
		$state['errors']  = $errors;
		$state['message'] = __( 'Certains champs nécessitent votre attention.', 'panonfc' );
		return;
	}

	// Spam or flood: fake success, no mail (bots get no signal).
	if ( panonfc_form_is_spam( $fields ) || ! panonfc_form_rate_ok() ) {
		do_action( 'panonfc_form_rejected', $fields );
		panonfc_form_finish( 'ok' );
	}

	panonfc_form_finish(
		'ok',
		function () use ( $fields ) {
			$to      = panonfc_contact_recipient();
			$subject = sprintf( '[Contact panonfc] %s', $fields['nom'] );
			$body    = sprintf(
				"Nouveau message depuis le formulaire de contact panonfc.com\n\nNom : %s\nEmail : %s\nTéléphone : %s\n\nMessage :\n%s\n",
				$fields['nom'],
				$fields['email'],
				$fields['tel'] ? $fields['tel'] : '—',
				$fields['message']
			);
			$headers = array(
				'Content-Type: text/plain; charset=UTF-8',
				'Reply-To: ' . $fields['nom'] . ' <' . $fields['email'] . '>',
			);
			$sent = wp_mail( $to, $subject, $body, $headers );
			do_action( 'panonfc_contact_submitted', $fields, $sent, 'contact' );
		}
	);
}

/**
 * Full quote (devis) form.
 */
function panonfc_process_devis( &$state ) {
	$fields = array(
		'nom'      => sanitize_text_field( wp_unslash( $_POST['nom'] ?? '' ) ),
		'societe'  => sanitize_text_field( wp_unslash( $_POST['societe'] ?? '' ) ),
		'email'    => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'tel'      => sanitize_text_field( wp_unslash( $_POST['tel'] ?? '' ) ),
		'activite' => sanitize_text_field( wp_unslash( $_POST['activite'] ?? '' ) ),
		'produit'  => sanitize_text_field( wp_unslash( $_POST['produit'] ?? '' ) ),
		'volume'   => sanitize_text_field( wp_unslash( $_POST['volume'] ?? '' ) ),
		'message'  => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'consent'  => ! empty( $_POST['consent'] ),
	);

	$errors = array();
	if ( '' === $fields['nom'] ) {
		$errors['nom'] = __( 'Votre nom est requis.', 'panonfc' );
	}
	if ( '' === $fields['societe'] ) {
		$errors['societe'] = __( 'Le nom de la société est requis.', 'panonfc' );
	}
	if ( ! is_email( $fields['email'] ) ) {
		$errors['email'] = __( 'Un email professionnel valide est requis.', 'panonfc' );
	}
	if ( ! $fields['consent'] ) {
		$errors['consent'] = __( 'Merci de cocher la case de consentement.', 'panonfc' );
	}

	if ( $errors ) {
		$state['status']  = 'error';
		$state['errors']  = $errors;
		$state['message'] = __( 'Certains champs nécessitent votre attention.', 'panonfc' );
		return;
	}

	// Spam or flood: fake success, no mail (bots get no signal).
	if ( panonfc_form_is_spam( $fields ) || ! panonfc_form_rate_ok() ) {
		do_action( 'panonfc_form_rejected', $fields );
		panonfc_form_finish( 'ok' );
	}

	panonfc_form_finish(
		'ok',
		function () use ( $fields ) {
			$to      = panonfc_contact_recipient();
			$subject = sprintf( '[Devis panonfc] %s — %s', $fields['nom'], $fields['societe'] );
			$body    = sprintf(
				"Nouvelle demande de devis depuis panonfc.com\n\n" .
				"Nom : %s\nSociété : %s\nEmail : %s\nTéléphone : %s\n" .
				"Activité : %s\nType de panneau : %s\nVolume estimé : %s\n\nMessage :\n%s\n",
				$fields['nom'],
				$fields['societe'],
				$fields['email'],
				$fields['tel'] ? $fields['tel'] : '—',
				$fields['activite'],
				$fields['produit'],
				$fields['volume'],
				$fields['message'] ? $fields['message'] : '—'
			);
			$headers = array(
				'Content-Type: text/plain; charset=UTF-8',
				'Reply-To: ' . $fields['nom'] . ' <' . $fields['email'] . '>',
			);
			$sent = wp_mail( $to, $subject, $body, $headers );
			do_action( 'panonfc_contact_submitted', $fields, $sent, 'devis' );
		}
	);
}

/**
 * Notice to display: inline validation error (POST) or post-redirect success.
 *
 * @return array{status:string,message:string}
 */
function panonfc_form_notice() {
	$state = panonfc_form_state();
	if ( 'error' === $state['status'] ) {
		return array( 'status' => 'error', 'message' => $state['message'] );
	}
	$envoi = isset( $_GET['envoi'] ) ? sanitize_key( wp_unslash( $_GET['envoi'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( 'ok' === $envoi ) {
		return array( 'status' => 'ok', 'message' => __( 'Merci, votre demande a bien été envoyée. Nous revenons vers vous rapidement.', 'panonfc' ) );
	}
	if ( 'error' === $envoi ) {
		return array( 'status' => 'error', 'message' => __( 'L\'envoi a échoué. Merci de nous appeler ou de réessayer.', 'panonfc' ) );
	}
	return array( 'status' => '', 'message' => '' );
}

/**
 * Re-fill a field value after a validation error.
 */
function panonfc_old( $key ) {
	$state = panonfc_form_state();
	if ( 'error' === $state['status'] && isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return esc_attr( sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
	}
	return '';
}

/**
 * Push a generate_lead event to the dataLayer after a successful submission,
 * so GTM / GA4 / Ads can track conversions reliably from the URL param.
 */
function panonfc_lead_datalayer() {
	$envoi = isset( $_GET['envoi'] ) ? sanitize_key( wp_unslash( $_GET['envoi'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( 'ok' !== $envoi ) {
		return;
	}
	echo "<script>window.dataLayer=window.dataLayer||[];window.dataLayer.push({event:'generate_lead',form_location:'panonfc'});</script>\n";
}
add_action( 'wp_footer', 'panonfc_lead_datalayer', 20 );

/* ============================================================
   Comment form protection (same anti-bot)
   ============================================================ */

add_action( 'comment_form_after_fields', 'panonfc_antibot_render' );
add_action( 'comment_form_logged_in_after', 'panonfc_antibot_render' );

function panonfc_comment_antibot( $commentdata ) {
	if ( isset( $_POST['panonfc_t'] ) && panonfc_is_bot() ) { // phpcs:ignore WordPress.Security.NonceVerification
		wp_die(
			esc_html__( 'Votre commentaire a été identifié comme indésirable.', 'panonfc' ),
			esc_html__( 'Erreur', 'panonfc' ),
			array( 'response' => 403, 'back_link' => true )
		);
	}
	return $commentdata;
}
add_filter( 'preprocess_comment', 'panonfc_comment_antibot' );
