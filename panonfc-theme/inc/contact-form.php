<?php
/**
 * Quote / contact form handling.
 *
 * Self-processing (POST to the same URL) with nonce, honeypot and required
 * RGPD consent. Sends to the commercial address and an auto-acknowledgement
 * to the prospect. No external dependency.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Holds the result of a submission for the current request.
 *
 * @return array{status:string,errors:array,message:string}
 */
function &panonfc_form_state() {
	static $state = array(
		'status'  => '', // '', 'ok', 'error'.
		'errors'  => array(),
		'message' => '',
	);
	return $state;
}

/**
 * Recipient address for quote requests (filterable).
 */
function panonfc_contact_recipient() {
	return apply_filters( 'panonfc_contact_recipient', get_option( 'admin_email' ) );
}

/**
 * Process the submission early, before headers where possible.
 */
function panonfc_handle_contact() {
	if ( empty( $_POST['panonfc_contact'] ) ) {
		return;
	}

	$state = &panonfc_form_state();

	// Nonce.
	if ( empty( $_POST['panonfc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['panonfc_contact_nonce'] ) ), 'panonfc_contact' ) ) {
		$state['status']  = 'error';
		$state['message'] = __( 'La session a expiré. Merci de renvoyer le formulaire.', 'panonfc' );
		return;
	}

	// Honeypot: a hidden field that must stay empty.
	if ( ! empty( $_POST['panonfc_website'] ) ) {
		// Pretend success to bots.
		$state['status']  = 'ok';
		$state['message'] = __( 'Merci, votre demande a bien été envoyée.', 'panonfc' );
		return;
	}

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

	// Build and send the email.
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

	/**
	 * Fires after a quote request is processed (for CRM hooks, etc.).
	 */
	do_action( 'panonfc_contact_submitted', $fields, $sent );

	if ( $sent ) {
		// Auto-acknowledgement to the prospect.
		$ack_subject = __( 'Votre demande de devis PANONFC', 'panonfc' );
		$ack_body    = sprintf(
			"Bonjour %s,\n\nNous avons bien reçu votre demande et revenons vers vous sous 24 h ouvrées avec un chiffrage.\n\nL'équipe PANONFC\n%s",
			$fields['nom'],
			home_url( '/' )
		);
		wp_mail( $fields['email'], $ack_subject, $ack_body, array( 'Content-Type: text/plain; charset=UTF-8' ) );

		$state['status']  = 'ok';
		$state['message'] = __( 'Merci, votre demande a bien été envoyée. Nous revenons vers vous sous 24 h ouvrées.', 'panonfc' );
	} else {
		$state['status']  = 'error';
		$state['message'] = __( 'L\'envoi a échoué. Merci de nous appeler ou de réessayer.', 'panonfc' );
	}
}
add_action( 'template_redirect', 'panonfc_handle_contact' );

/**
 * Helper to re-fill a field after a validation error.
 */
function panonfc_old( $key ) {
	$state = panonfc_form_state();
	if ( 'error' === $state['status'] && isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return esc_attr( sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
	}
	return '';
}
