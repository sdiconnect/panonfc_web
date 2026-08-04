<?php
/**
 * Template Name: PANONFC — Contact
 *
 * Light contact form (nom, email, téléphone, message). For the full quote
 * request use the "PANONFC — Demander un devis" template.
 *
 * @package panonfc
 */

get_header();
$notice = panonfc_form_notice();
?>

<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-140px;top:-200px;width:660px;height:660px;border:1px solid rgba(254,132,27,0.14)"></span>
	<div class="container page-hero__inner">
		<div class="breadcrumb breadcrumb--on-navy">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'Contact' ),
				)
			);
			?>
		</div>
		<div class="measure" style="max-width:640px">
			<h1>Nous contacter</h1>
			<p class="page-hero__lead">Une question sur nos panneaux, un conseil sur le bon format ? Écrivez-nous, on vous répond vite. Pour un chiffrage, passez plutôt par <a class="link-strong" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>" style="color:var(--orange-300)">la demande de devis</a>.</p>
		</div>
	</div>
</section>

<section class="section section--surface section--bordered-bottom">
	<div class="container section__inner--tight section__inner">
		<div class="contact-simple">
			<div class="form-card">
				<h2 class="offer-title" style="margin-bottom:6px">Votre message</h2>
				<p class="muted mb-7 card-text-15">Réponse en général sous 24 h ouvrées.</p>

				<?php if ( 'ok' === $notice['status'] ) : ?>
					<div class="form-alert form-alert--ok"><?php echo esc_html( $notice['message'] ); ?></div>
				<?php elseif ( 'error' === $notice['status'] ) : ?>
					<div class="form-alert form-alert--err"><?php echo esc_html( $notice['message'] ); ?></div>
				<?php endif; ?>

				<?php if ( 'ok' !== $notice['status'] ) : ?>
				<form method="post" action="#form" class="panonfc-form" novalidate>
					<?php wp_nonce_field( 'panonfc_form', 'panonfc_form_nonce' ); ?>
					<input type="hidden" name="panonfc_form" value="contact">
					<?php panonfc_antibot_render(); ?>

					<div class="form-grid-2">
						<div>
							<label for="ct-nom">Nom et prénom *</label>
							<input id="ct-nom" name="nom" type="text" placeholder="Camille Roux" value="<?php echo panonfc_old( 'nom' ); ?>" required>
						</div>
						<div>
							<label for="ct-tel">Téléphone</label>
							<input id="ct-tel" name="tel" type="tel" placeholder="06 12 34 56 78" value="<?php echo panonfc_old( 'tel' ); ?>">
						</div>
					</div>

					<div class="form-field">
						<label for="ct-email">Email *</label>
						<input id="ct-email" name="email" type="email" placeholder="camille@exemple.fr" value="<?php echo panonfc_old( 'email' ); ?>" required>
					</div>

					<div class="form-field">
						<label for="ct-message">Votre message *</label>
						<textarea id="ct-message" name="message" rows="5" placeholder="Comment pouvons-nous vous aider ?" required><?php echo esc_textarea( panonfc_old( 'message' ) ); ?></textarea>
					</div>

					<div class="form-consent">
						<input type="checkbox" id="ct-rgpd" name="consent" value="1">
						<label for="ct-rgpd">J'accepte que mes informations soient utilisées pour traiter ma demande. Elles ne sont ni revendues ni utilisées à d'autres fins.</label>
					</div>

					<div class="form-submit-row" id="form">
						<button type="submit" class="btn btn--accent btn--lg">Envoyer le message</button>
						<span class="form-note">Vous préférez un devis chiffré ? <a class="link-strong" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a></span>
					</div>
				</form>
				<?php endif; ?>
			</div>

			<aside class="contact-mini">
				<a class="card contact-mini__item" href="<?php echo esc_attr( panonfc_phone_href() ); ?>">
					<span class="l">Nous appeler</span>
					<b><?php echo esc_html( panonfc_phone_display() ); ?></b>
					<span class="s">Du lundi au vendredi, 9 h – 18 h</span>
				</a>
				<div class="card contact-mini__item">
					<span class="l">Adresse</span>
					<span class="s"><?php echo wp_kses_post( apply_filters( 'panonfc_contact_address', 'PANONFC — Solutions Digitales Intégrées<br>60 rue François 1er<br>75008 Paris' ) ); ?></span>
				</div>
				<a class="card contact-mini__item" href="<?php echo esc_url( panonfc_console_url() ); ?>">
					<span class="l">Déjà client</span>
					<b>Ouvrir ma console</b>
					<span class="s">Activation, redirection, réassort en autonomie.</span>
				</a>
			</aside>
		</div>
	</div>
</section>

<?php
get_footer();
