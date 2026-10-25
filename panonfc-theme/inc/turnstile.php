<?php
/**
 * Cloudflare Turnstile on the Contact / Devis forms.
 *
 * - Keys: Réglages → Anti-spam (options), or constants in wp-config.php
 *   (PANONFC_TURNSTILE_SITE_KEY / PANONFC_TURNSTILE_SECRET_KEY), which win.
 * - Without both keys the forms work as before (honeypot, time-trap,
 *   content filter and rate limit still apply).
 * - With keys, a submission without a valid Turnstile token sends no mail
 *   and shows an inline message so a real visitor can retry.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public site key.
 */
function panonfc_turnstile_site_key() {
	if ( defined( 'PANONFC_TURNSTILE_SITE_KEY' ) && PANONFC_TURNSTILE_SITE_KEY ) {
		return (string) PANONFC_TURNSTILE_SITE_KEY;
	}
	return trim( (string) get_option( 'panonfc_turnstile_site_key', '' ) );
}

/**
 * Secret key (never printed).
 */
function panonfc_turnstile_secret_key() {
	if ( defined( 'PANONFC_TURNSTILE_SECRET_KEY' ) && PANONFC_TURNSTILE_SECRET_KEY ) {
		return (string) PANONFC_TURNSTILE_SECRET_KEY;
	}
	return trim( (string) get_option( 'panonfc_turnstile_secret_key', '' ) );
}

/**
 * Whether Turnstile is configured.
 */
function panonfc_turnstile_enabled() {
	return '' !== panonfc_turnstile_site_key() && '' !== panonfc_turnstile_secret_key();
}

/**
 * Print the widget inside a form (called by panonfc_antibot_render()).
 */
function panonfc_turnstile_render() {
	if ( ! panonfc_turnstile_enabled() ) {
		return;
	}
	wp_enqueue_script( 'cf-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	printf(
		'<div class="form-turnstile cf-turnstile" data-sitekey="%s" data-language="fr" data-appearance="interaction-only"></div>',
		esc_attr( panonfc_turnstile_site_key() )
	);
}

/**
 * Load the Turnstile script with async/defer.
 */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle ) {
		if ( 'cf-turnstile' === $handle && false === strpos( $tag, ' async' ) ) {
			$tag = str_replace( ' src=', ' async defer src=', $tag );
		}
		return $tag;
	},
	10,
	2
);

/**
 * Verify the submitted Turnstile token.
 *
 * @return true|string True if OK (or Turnstile disabled), else an error message for the visitor.
 */
function panonfc_turnstile_verify() {
	if ( ! panonfc_turnstile_enabled() ) {
		return true;
	}

	$token = isset( $_POST['cf-turnstile-response'] ) ? sanitize_text_field( wp_unslash( $_POST['cf-turnstile-response'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === $token ) {
		return __( 'Merci de patienter une seconde que la vérification anti-robot se termine, puis de renvoyer le formulaire.', 'panonfc' );
	}

	$response = wp_remote_post(
		'https://challenges.cloudflare.com/turnstile/v0/siteverify',
		array(
			'timeout' => 8,
			'body'    => array(
				'secret'   => panonfc_turnstile_secret_key(),
				'response' => $token,
				'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
			),
		)
	);

	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return __( 'La vérification anti-robot est momentanément indisponible. Merci de réessayer dans un instant ou de nous appeler.', 'panonfc' );
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $data['success'] ) ) {
		return __( 'La vérification anti-robot a échoué. Merci de renvoyer le formulaire.', 'panonfc' );
	}

	return true;
}

/* ============================================================
   Settings page: Réglages → Anti-spam
   ============================================================ */

add_action(
	'admin_init',
	function () {
		register_setting(
			'panonfc_antispam',
			'panonfc_turnstile_site_key',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '',
			)
		);
		register_setting(
			'panonfc_antispam',
			'panonfc_turnstile_secret_key',
			array(
				'type'              => 'string',
				'default'           => '',
				// Empty field = keep the stored secret (it is never printed back).
				'sanitize_callback' => function ( $value ) {
					$value = trim( sanitize_text_field( (string) $value ) );
					if ( '' === $value ) {
						return (string) get_option( 'panonfc_turnstile_secret_key', '' );
					}
					return '-' === $value ? '' : $value;
				},
			)
		);
	}
);

add_action(
	'admin_menu',
	function () {
		add_options_page(
			__( 'Anti-spam des formulaires', 'panonfc' ),
			__( 'Anti-spam', 'panonfc' ),
			'manage_options',
			'panonfc-antispam',
			'panonfc_antispam_page'
		);
	}
);

/**
 * Render the settings page.
 */
function panonfc_antispam_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$site_const   = defined( 'PANONFC_TURNSTILE_SITE_KEY' ) && PANONFC_TURNSTILE_SITE_KEY;
	$secret_const = defined( 'PANONFC_TURNSTILE_SECRET_KEY' ) && PANONFC_TURNSTILE_SECRET_KEY;
	$has_secret   = '' !== panonfc_turnstile_secret_key();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Anti-spam des formulaires (Cloudflare Turnstile)', 'panonfc' ); ?></h1>
		<p>
			<?php esc_html_e( 'Protège les formulaires Contact et Devis du thème. Clés à créer gratuitement dans Cloudflare → Turnstile → Add widget (domaine panonfc.com, mode « Managed »).', 'panonfc' ); ?>
		</p>
		<p>
			<strong><?php esc_html_e( 'État :', 'panonfc' ); ?></strong>
			<?php
			echo panonfc_turnstile_enabled()
				? '<span style="color:#008a20;font-weight:600">' . esc_html__( 'ACTIF', 'panonfc' ) . '</span>'
				: '<span style="color:#b32d2e;font-weight:600">' . esc_html__( 'inactif — renseignez les deux clés', 'panonfc' ) . '</span>';
			?>
		</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'panonfc_antispam' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="panonfc_turnstile_site_key"><?php esc_html_e( 'Clé du site (Site Key)', 'panonfc' ); ?></label></th>
					<td>
						<?php if ( $site_const ) : ?>
							<em><?php esc_html_e( 'Définie dans wp-config.php.', 'panonfc' ); ?></em>
						<?php else : ?>
							<input type="text" class="regular-text code" id="panonfc_turnstile_site_key" name="panonfc_turnstile_site_key" value="<?php echo esc_attr( get_option( 'panonfc_turnstile_site_key', '' ) ); ?>" autocomplete="off">
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="panonfc_turnstile_secret_key"><?php esc_html_e( 'Clé secrète (Secret Key)', 'panonfc' ); ?></label></th>
					<td>
						<?php if ( $secret_const ) : ?>
							<em><?php esc_html_e( 'Définie dans wp-config.php.', 'panonfc' ); ?></em>
						<?php else : ?>
							<input type="password" class="regular-text code" id="panonfc_turnstile_secret_key" name="panonfc_turnstile_secret_key" value="" autocomplete="new-password" placeholder="<?php echo $has_secret ? esc_attr__( '•••••••• enregistrée — laisser vide pour la conserver', 'panonfc' ) : ''; ?>">
							<p class="description"><?php esc_html_e( 'Jamais réaffichée. Laisser vide pour conserver la clé enregistrée ; saisir un tiret « - » pour l\'effacer.', 'panonfc' ); ?></p>
						<?php endif; ?>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
