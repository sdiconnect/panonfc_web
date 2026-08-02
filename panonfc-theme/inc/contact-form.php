<?php
/**
 * Front-end forms: simple Contact + full Devis (quote).
 *
 * Both are self-processing (POST to the same URL) with:
 *   - a WordPress nonce,
 *   - a honeypot field (must stay empty),
 *   - a signed time-trap (form must take >= 3s and < 1h to submit),
 *   - required RGPD consent.
 * No external service, no reCAPTCHA — privacy-friendly and dependency-free.
 * The same anti-bot check also guards the WordPress comment form.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-request result of a submission.
 *
 * @return array{status:string,errors:array,message:string,form:string}
 */
function &panonfc_form_state() {
	static $state = array(
		'status'  => '', // '', 'ok', 'error'.
		'errors'  => array(),
		'message' => '',
		'form'    => '',
	);
	return $state;
}

/**
 * Recipient address for form submissions (Contact + Devis).
 *
 * Uses the WordPress admin email (Réglages → Général). Override with the
 * `panonfc_contact_recipient` filter if you ever need a different address.
 */
function panonfc_contact_recipient() {
	return apply_filters( 'panonfc_contact_recipient', get_option( 'admin_email' ) );
}

/* ============================================================
   Anti-bot: honeypot + signed time-trap (shared by all forms)
   ============================================================ */

/**
 * Output the hidden anti-bot fields inside a form.
 */
function panonfc_antibot_render() {
	$t   = time();
	$sig = hash_hmac( 'sha256', (string) $t, wp_salt( 'auth' ) );
	echo '<div class="form-hp" aria-hidden="true">';
	echo '<label for="panonfc_website">' . esc_html__( 'Ne pas remplir ce champ', 'panonfc' ) . '</label>';
	echo '<input type="text" id="panonfc_website" name="panonfc_website" tabindex="-1" autocomplete="off">';
	echo '</div>';
	printf( '<input type="hidden" name="panonfc_t" value="%s">', esc_attr( $t . ':' . $sig ) );
}

/**
 * Decide whether the current POST looks like a bot.
 *
 * @return bool True if it should be treated as a bot.
 */
function panonfc_is_bot() {
	// 1. Honeypot must be empty.
	if ( ! empty( $_POST['panonfc_website'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return true;
	}

	// 2. Signed time-trap.
	$raw = isset( $_POST['panonfc_t'] ) ? sanitize_text_field( wp_unslash( $_POST['panonfc_t'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === $raw || false === strpos( $raw, ':' ) ) {
		return true;
	}
	list( $t, $sig ) = explode( ':', $raw, 2 );
	if ( ! ctype_digit( $t ) ) {
		return true;
	}
	$expected = hash_hmac( 'sha256', $t, wp_salt( 'auth' ) );
	if ( ! hash_equals( $expected, $sig ) ) {
		return true;
	}
	$elapsed = time() - (int) $t;
	if ( $elapsed < 3 || $elapsed > HOUR_IN_SECONDS ) {
		return true;
	}

	return false;
}

/* ============================================================
   Contact + Devis handler
   ============================================================ */

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

	// Anti-bot — silently accept (pretend success) so bots get no feedback.
	if ( panonfc_is_bot() ) {
		$state['status']  = 'ok';
		$state['message'] = __( 'Merci, votre message a bien été envoyé.', 'panonfc' );
		return;
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

	if ( $sent ) {
		wp_mail(
			$fields['email'],
			__( 'Votre message a bien été reçu — PANONFC', 'panonfc' ),
			sprintf( "Bonjour %s,\n\nMerci de votre message, nous vous répondons rapidement.\n\nL'équipe PANONFC\n%s", $fields['nom'], home_url( '/' ) ),
			array( 'Content-Type: text/plain; charset=UTF-8' )
		);
		$state['status']  = 'ok';
		$state['message'] = __( 'Merci, votre message a bien été envoyé. Nous vous répondons rapidement.', 'panonfc' );
	} else {
		$state['status']  = 'error';
		$state['message'] = __( 'L\'envoi a échoué. Merci de nous appeler ou de réessayer.', 'panonfc' );
	}
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

	if ( $sent ) {
		wp_mail(
			$fields['email'],
			__( 'Votre demande de devis PANONFC', 'panonfc' ),
			sprintf( "Bonjour %s,\n\nNous avons bien reçu votre demande et revenons vers vous sous 24 h ouvrées avec un chiffrage.\n\nL'équipe PANONFC\n%s", $fields['nom'], home_url( '/' ) ),
			array( 'Content-Type: text/plain; charset=UTF-8' )
		);
		$state['status']  = 'ok';
		$state['message'] = __( 'Merci, votre demande a bien été envoyée. Nous revenons vers vous sous 24 h ouvrées.', 'panonfc' );
	} else {
		$state['status']  = 'error';
		$state['message'] = __( 'L\'envoi a échoué. Merci de nous appeler ou de réessayer.', 'panonfc' );
	}
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

/* ============================================================
   Comment form protection (same anti-bot)
   ============================================================ */

add_action( 'comment_form_after_fields', 'panonfc_antibot_render' );
add_action( 'comment_form_logged_in_after', 'panonfc_antibot_render' );

/**
 * Reject spam comments that fail the honeypot / time-trap.
 */
function panonfc_comment_antibot( $commentdata ) {
	// Only guard front-end submissions (skip programmatic/admin creation).
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
