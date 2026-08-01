<?php
/**
 * Template Name: PANONFC — Chantier
 *
 * @package panonfc
 */

get_header();
?>

<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-120px;top:-160px;width:620px;height:620px;border:1px solid rgba(254,132,27,0.14)"></span>
	<span class="page-hero__arc" aria-hidden="true" style="right:40px;top:-60px;width:400px;height:400px;border:1px solid rgba(255,255,255,0.08)"></span>
	<div class="container page-hero__inner">
		<div class="breadcrumb breadcrumb--on-navy">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'Chantier' ),
				)
			);
			?>
		</div>
		<div class="split split--55-45">
			<div>
				<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Promoteurs · Constructeurs · Entreprises BTP</span>
				<h1>Le panneau réglementaire, doublé d'un canal d'information</h1>
				<p class="page-hero__lead measure-sm">Les mentions obligatoires du permis restent imprimées et lisibles depuis la voie publique. Le QR code, lui, ouvre le dossier du programme : plans, planning, commercialisation, contact riverains.</p>
				<div class="page-hero__cta">
					<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
					<a class="btn btn--on-navy btn--lg" href="#usages">Voir les usages</a>
				</div>
			</div>
			<figure class="hero__photo shadow-hero-el">
				<img src="<?php echo esc_url( panonfc_image( 'product-chantier' ) ); ?>" alt="Panneau de chantier réglementaire connecté" width="700" height="340" class="img-cover-340">
			</figure>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="split split--start split--52-48">
			<div>
				<span class="eyebrow">Deux niveaux de lecture</span>
				<h2 class="h2--md">Ce qui doit être affiché, et ce que vous voulez raconter</h2>
				<p class="muted mt-5 mb-8 section-lead">Un panneau de chantier est d'abord une obligation d'affichage. En y ajoutant un identifiant unique, il devient aussi le point d'entrée du programme — sans surcharger le visuel de textes que personne ne lit depuis le trottoir.</p>
				<div class="grid cols-2 grid--gap-sm">
					<div class="card readcard">
						<div class="l">Sur le panneau</div>
						<ul class="marker-list">
							<li><span class="mk mk--navy">—</span>Mentions du permis de construire</li>
							<li><span class="mk mk--navy">—</span>Maître d'ouvrage et intervenants</li>
							<li><span class="mk mk--navy">—</span>Votre identité de marque</li>
						</ul>
					</div>
					<div class="card card--accent readcard">
						<div class="l">Derrière le scan</div>
						<ul class="marker-list">
							<li><span class="mk mk--orange">—</span>Fiche du programme et plans</li>
							<li><span class="mk mk--orange">—</span>Avancement et planning travaux</li>
							<li><span class="mk mk--orange">—</span>Contact riverains ou commercialisation</li>
						</ul>
					</div>
				</div>
			</div>
			<figure class="pdp__gallery-main">
				<img src="<?php echo esc_url( panonfc_image( 'chantier-shot' ) ); ?>" alt="Panneau de chantier PANONFC posé sur site" loading="lazy" class="img-cover-420">
			</figure>
		</div>
	</div>
</section>

<section class="section section--surface section--bordered-top" id="usages">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Usages chantier</span>
			<h2 class="h2">Un identifiant par lot, une information par public</h2>
		</div>
		<div class="grid cols-3 grid--gap">
			<div class="card"><h3 class="card-title-18">Programme neuf</h3><p class="card-text-15">Le riverain scanne et découvre le projet livré : perspectives, nombre de lots, date de livraison, espace de commercialisation.</p></div>
			<div class="card"><h3 class="card-title-18">Chantier en cours</h3><p class="card-text-15">Phases, nuisances annoncées, contact du conducteur de travaux : les questions du voisinage trouvent une réponse sans passer par vos équipes.</p></div>
			<div class="card"><h3 class="card-title-18">Rénovation et copropriété</h3><p class="card-text-15">Un panneau par bâtiment, une destination par copropriété, mise à jour au fil des tranches de travaux.</p></div>
			<div class="card"><h3 class="card-title-18">Entreprise du bâtiment</h3><p class="card-text-15">Le chantier devient une vitrine : réalisations, certifications, formulaire de demande de devis pour les passants.</p></div>
			<div class="card"><h3 class="card-title-18">Déploiement multi-sites</h3><p class="card-text-15">Chaque panneau porte son identifiant. Vous savez lequel est posé sur quel site, et vous les regroupez par opération.</p></div>
			<div class="card"><h3 class="card-title-18">Fin de chantier</h3><p class="card-text-15">Le panneau est déposé, l'identifiant est réaffecté à l'opération suivante. Rien ne se perd.</p></div>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="measure" style="margin-bottom:40px">
			<span class="eyebrow">Fabrication</span>
			<h2 class="h2--md">Conçu pour rester lisible plusieurs saisons</h2>
		</div>
		<div class="spec-cols">
			<div class="spec"><div class="t">Akylux 5 mm</div><p>Support alvéolaire rigide, léger à poser, insensible à l'humidité.</p></div>
			<div class="spec"><div class="t">Impression UV</div><p>Encres polymérisées, tenue des couleurs en extérieur.</p></div>
			<div class="spec"><div class="t">Œillets en option</div><p>Quatre œillets pour fixation sur clôture, palissade ou grillage.</p></div>
			<div class="spec"><div class="t">Grands formats</div><p>Dimensions de chantier sur devis, selon la surface d'affichage requise.</p></div>
		</div>
	</div>
</section>

<?php
$chantier_gallery = array(
	array( 'field' => 'chantier_gallery_1', 'alt' => 'Panneau réglementaire sur palissade' ),
	array( 'field' => 'chantier_gallery_2', 'alt' => 'Riverain scannant le panneau' ),
	array( 'field' => 'chantier_gallery_3', 'alt' => 'Vue d\'ensemble du chantier équipé' ),
);
$has_chantier_gallery = false;
if ( function_exists( 'get_field' ) ) {
	foreach ( $chantier_gallery as $g ) {
		if ( get_field( $g['field'] ) ) { $has_chantier_gallery = true; break; }
	}
}
if ( $has_chantier_gallery ) :
	?>
<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="section-head">
			<div class="section-head__title">
				<span class="eyebrow">En situation</span>
				<h2 class="h2--md">Sur palissade, grillage ou clôture de chantier</h2>
			</div>
			<p class="section-head__aside">Photos d'opérations : programmes neufs, rénovations, chantiers d'entreprise.</p>
		</div>
		<div class="gallery">
			<?php foreach ( $chantier_gallery as $g ) { panonfc_gallery_item( $g['field'], $g['alt'] ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'     => 'Décrivez votre opération, nous chiffrons',
		'lead'      => 'Nombre de sites, formats, mentions à intégrer : envoyez-nous les éléments, vous recevez un devis et une maquette avant production.',
		'primary'   => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'secondary' => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'small'     => true,
	)
);

get_footer();
