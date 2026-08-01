<?php
/**
 * Template Name: PANONFC — Contact / Devis
 *
 * @package panonfc
 */

get_header();
$state = panonfc_form_state();
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
		<div class="measure" style="max-width:700px">
			<h1>Demander un devis</h1>
			<p class="page-hero__lead">Décrivez votre besoin en une minute. Un interlocuteur unique vous répond sous 24 h ouvrées avec un chiffrage et, si vous le souhaitez, une première maquette.</p>
		</div>
	</div>
</section>

<section class="section section--surface section--bordered-bottom">
	<div class="container section__inner--tight section__inner">
		<div class="split split--start split--62-38" style="gap:48px">
			<div class="form-card">
				<h2 class="offer-title" style="margin-bottom:6px">Votre projet</h2>
				<p class="muted mb-7" style="font-size:14.5px;line-height:1.6">Les champs marqués d'un astérisque sont nécessaires au chiffrage.</p>

				<?php if ( 'ok' === $state['status'] ) : ?>
					<div class="form-alert form-alert--ok"><?php echo esc_html( $state['message'] ); ?></div>
				<?php elseif ( 'error' === $state['status'] ) : ?>
					<div class="form-alert form-alert--err"><?php echo esc_html( $state['message'] ); ?></div>
				<?php endif; ?>

				<?php if ( 'ok' !== $state['status'] ) : ?>
				<form method="post" action="#form" novalidate>
					<?php wp_nonce_field( 'panonfc_contact', 'panonfc_contact_nonce' ); ?>
					<input type="hidden" name="panonfc_contact" value="1">
					<div class="form-hp" aria-hidden="true">
						<label for="panonfc_website">Ne pas remplir</label>
						<input type="text" id="panonfc_website" name="panonfc_website" tabindex="-1" autocomplete="off">
					</div>

					<div class="form-grid-2">
						<div>
							<label for="c-nom">Nom et prénom *</label>
							<input id="c-nom" name="nom" type="text" placeholder="Camille Roux" value="<?php echo panonfc_old( 'nom' ); ?>" required>
						</div>
						<div>
							<label for="c-societe">Société / agence *</label>
							<input id="c-societe" name="societe" type="text" placeholder="Rivière Immobilier" value="<?php echo panonfc_old( 'societe' ); ?>" required>
						</div>
						<div>
							<label for="c-email">Email professionnel *</label>
							<input id="c-email" name="email" type="email" placeholder="camille@riviere-immo.fr" value="<?php echo panonfc_old( 'email' ); ?>" required>
						</div>
						<div>
							<label for="c-tel">Téléphone</label>
							<input id="c-tel" name="tel" type="tel" placeholder="06 12 34 56 78" value="<?php echo panonfc_old( 'tel' ); ?>">
						</div>
					</div>

					<div class="form-grid-3">
						<div>
							<label for="c-activite">Activité *</label>
							<select id="c-activite" name="activite">
								<option>Agence immobilière</option>
								<option>Réseau / franchise</option>
								<option>Mandataire indépendant</option>
								<option>Promoteur / constructeur</option>
								<option>Entreprise BTP</option>
								<option>Autre</option>
							</select>
						</div>
						<div>
							<label for="c-produit">Type de panneau *</label>
							<select id="c-produit" name="produit">
								<option>Panneau plat connecté</option>
								<option>Panneau en V connecté</option>
								<option>Panneau de chantier réglementaire</option>
								<option>Je ne sais pas encore</option>
							</select>
						</div>
						<div>
							<label for="c-volume">Volume estimé *</label>
							<select id="c-volume" name="volume">
								<option>1 à 4 panneaux</option>
								<option>5 à 24 panneaux</option>
								<option>25 à 99 panneaux</option>
								<option>100 panneaux et plus</option>
							</select>
						</div>
					</div>

					<div class="form-field">
						<label for="c-message">Votre besoin</label>
						<textarea id="c-message" name="message" rows="5" placeholder="Formats souhaités, échéance, nombre d'agences ou de sites, contraintes de pose…"><?php echo esc_textarea( panonfc_old( 'message' ) ); ?></textarea>
					</div>

					<div class="form-upload">
						<div class="t">Éléments graphiques (facultatif)</div>
						<p>Logo, charte ou photo d'un panneau existant — cela nous permet de joindre une maquette au devis. Envoyez-les en réponse à notre accusé de réception. Formats acceptés : AI, PDF, EPS, PNG, JPG.</p>
					</div>

					<div class="form-consent">
						<input type="checkbox" id="c-rgpd" name="consent" value="1"<?php echo ( 'error' === $state['status'] && ! empty( $_POST['consent'] ) ) ? ' checked' : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>>
						<label for="c-rgpd">J'accepte que mes informations soient utilisées pour traiter ma demande. Elles ne sont ni revendues ni utilisées à d'autres fins.</label>
					</div>

					<div class="form-submit-row" id="form">
						<button type="submit" class="btn btn--accent btn--lg">Envoyer ma demande</button>
						<span class="form-note">Réponse sous 24 h ouvrées · Devis gratuit et sans engagement</span>
					</div>
				</form>
				<?php endif; ?>
			</div>

			<aside class="contact-aside">
				<div class="card">
					<div class="l">Nous appeler</div>
					<a class="contact-aside__phone" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a>
					<p class="muted card-text-15">Du lundi au vendredi, 9 h – 18 h. Appel non surtaxé.</p>
				</div>
				<div class="card">
					<div class="l">Adresse</div>
					<p style="font-size:15px;line-height:1.65"><?php echo wp_kses_post( apply_filters( 'panonfc_contact_address', 'PANONFC — Solutions Digitales Intégrées<br>60 rue François 1er<br>75008 Paris' ) ); ?></p>
				</div>
				<?php
				if ( function_exists( 'get_field' ) && get_field( 'contact_photo' ) ) {
					echo '<div class="card--flush card">';
					panonfc_gallery_item( 'contact_photo', 'Équipe PANONFC ou atelier' );
					echo '</div>';
				}
				?>
				<div class="contact-aside__navy">
					<div class="l">Déjà client</div>
					<h3>Une question sur un panneau existant ?</h3>
					<p>Activation, redirection, réassort : la plupart des demandes se règlent directement depuis votre console.</p>
					<a class="btn btn--on-navy btn--sm" href="<?php echo esc_url( panonfc_console_url() ); ?>">Ouvrir ma console</a>
				</div>
			</aside>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--tight section__inner">
		<div class="measure" style="margin-bottom:36px">
			<span class="eyebrow">Ce qui se passe ensuite</span>
			<h2 class="h2--sm">Trois échanges, et vos panneaux partent en production</h2>
		</div>
		<div class="grid cols-3 grid--gap-lg">
			<div class="spec"><div class="deroule-num">01</div><h3 class="mini-card-h">Nous vous rappelons</h3><p class="mini-card-p">Sous 24 h ouvrées, pour cadrer les formats, le volume et l'échéance.</p></div>
			<div class="spec"><div class="deroule-num">02</div><h3 class="mini-card-h">Vous recevez devis et maquette</h3><p class="mini-card-p">Un tarif ferme, et le visuel de votre panneau avec QR code et identifiant intégrés.</p></div>
			<div class="spec"><div class="deroule-num">03</div><h3 class="mini-card-h">Vous validez le BAT</h3><p class="mini-card-p">Production lancée, livraison sous 48 à 72 h, activation depuis votre console.</p></div>
		</div>
	</div>
</section>

<?php
get_footer();
