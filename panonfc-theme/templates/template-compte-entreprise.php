<?php
/**
 * Template Name: PANONFC — Compte Entreprise
 *
 * Offre réseaux multi-agences : agences, collaborateurs, droits, statistiques.
 *
 * @package panonfc
 */

get_header();
?>

<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-120px;top:-160px;width:620px;height:620px;border:1px solid rgba(254,132,27,0.14)"></span>
	<div class="container page-hero__inner">
		<div class="breadcrumb breadcrumb--on-navy">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'Compte Entreprise' ),
				)
			);
			?>
		</div>
		<div class="split split--55-45">
			<div>
				<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Réseaux d'agences · Franchises · Groupes</span>
				<h1>Tous vos panneaux, toutes vos agences, un seul tableau de bord</h1>
				<p class="page-hero__lead measure-sm">Le Compte Entreprise regroupe vos panneaux connectés par agence, donne à chaque collaborateur les droits qui lui reviennent et consolide les statistiques de scan de tout le réseau.</p>
				<div class="page-hero__cta">
					<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'demo' ) ); ?>">Demander un accès démo</a>
					<a class="btn btn--on-navy btn--lg" href="#offre">Voir l'offre</a>
				</div>
			</div>
			<div class="hero__media">
				<figure class="hero__photo">
					<?php panonfc_img( 'hab-tableau-bord', 'Une responsable d\'agence consulte un tableau de bord sur son ordinateur', '', 1400, 788, false ); ?>
				</figure>
				<div class="floatcard" aria-hidden="true">
				<div class="floatcard__head">
					<span class="floatcard__ref">Réseau · 12 agences</span>
					<span class="badge badge--success">Actif</span>
				</div>
				<div class="floatcard__title">Scans du mois, par agence</div>
				<div class="floatcard__meta">QR code et NFC · comparaison avec le mois précédent · panneaux sans scan signalés</div>
				<div class="floatcard__foot">Rapport mensuel envoyé à la direction</div>
			</div>
			</div>
		</div>
	</div>
</section>

<section class="section section--white section--bordered-bottom">
	<div class="container" style="padding-top:56px;padding-bottom:56px">
		<div class="arg-strip">
			<div class="arg"><h3>Organisé par agence</h3><p>Chaque panneau est rangé dans le groupe de l'agence qui l'utilise. La direction garde la vue d'ensemble.</p></div>
			<div class="arg"><h3>Des droits par collaborateur</h3><p>Responsable d'agence, collaborateur, lecture seule : chacun agit sur son périmètre, sans risque pour le reste du réseau.</p></div>
			<div class="arg"><h3>Des statistiques consolidées</h3><p>Scans par agence, par panneau, QR code ou NFC, et repérage des panneaux qui ne sont plus scannés.</p></div>
		</div>
	</div>
</section>

<?php
panonfc_capture_band(
	array(
		'eyebrow' => 'Statistiques',
		'title'   => 'Les scans de tout le réseau, agence par agence',
		'lead'    => 'Scans QR code et NFC, évolution quotidienne, panneaux muets : la direction compare, chaque agence suit les siens. Capture réelle du compte de démonstration, données fictives.',
		'key'     => 'bo-scans-qr-nfc',
		'alt'     => 'Statistiques des scans QR code et NFC et évolution quotidienne',
		'w'       => 1150,
		'h'       => 741,
	)
);
?>

<section class="section section--surface" id="offre">
	<div class="container section__inner--internal section__inner">
		<div class="split split--55-45 split--start">
			<div>
				<span class="eyebrow">L'offre</span>
				<h2 class="h2">Une option annuelle, sans toucher à vos panneaux</h2>
				<p class="muted mt-4 section-lead">La console standard reste incluse dans le prix des panneaux. Le Compte Entreprise s'y ajoute pour les organisations qui gèrent plusieurs agences et plusieurs collaborateurs.</p>
				<ul class="marker-list mt-6">
					<li><span class="mk mk--orange">✓</span>Agences et collaborateurs illimités</li>
					<li><span class="mk mk--orange">✓</span>Rôles et droits par agence</li>
					<li><span class="mk mk--orange">✓</span>Statistiques consolidées et export</li>
					<li><span class="mk mk--orange">✓</span>Alertes sur les panneaux sans scan</li>
					<li><span class="mk mk--orange">✓</span>Rapport mensuel</li>
				</ul>
			</div>
			<article class="card card--accent stack">
				<div class="product-card__cat">Compte Entreprise</div>
				<h3 class="offer-title">Jusqu'à 100 panneaux</h3>
				<div class="offer-price-row">
					<span class="offer-price"><?php echo esc_html( apply_filters( 'panonfc_entreprise_price', '490 €' ) ); ?></span>
					<span class="subtle" style="font-size:13px">HT / an</span>
				</div>
				<p class="muted mb-6 card-text-15"><?php echo esc_html( apply_filters( 'panonfc_entreprise_price_note', 'Au-delà de 100 panneaux : tarif selon la taille du réseau, sur devis.' ) ); ?></p>
				<a class="btn btn--navy btn--block mt-auto" href="<?php echo esc_url( panonfc_url( 'demo' ) ); ?>">Demander un accès démo</a>
			</article>
		</div>
	</div>
</section>

<?php
panonfc_faq_section( 'entreprise', 'Le Compte Entreprise en questions' );

get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'       => 'Testez-le sur un réseau fictif',
		'lead'        => 'Nous vous ouvrons un espace de démonstration complet : agences, collaborateurs, panneaux et statistiques.',
		'primary'     => array( 'label' => 'Demander un accès démo', 'url' => panonfc_url( 'demo' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'reassurance' => 'Accès démo gratuit · Sans engagement',
	)
);

get_footer();
