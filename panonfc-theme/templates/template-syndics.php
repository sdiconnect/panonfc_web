<?php
/**
 * Template Name: PANONFC — Syndics et copropriétés
 *
 * @package panonfc
 */

panonfc_habitat_topbar();
get_header();
?>

<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-140px;top:-180px;width:660px;height:660px;border:1px solid rgba(254,132,27,0.14)"></span>
	<div class="container page-hero__inner">
		<div class="breadcrumb breadcrumb--on-navy">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'Syndics et copropriétés' ),
				)
			);
			?>
		</div>
		<div class="measure" style="max-width:760px">
			<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Syndics · Gestionnaires · Conseils syndicaux</span>
			<h1>Un QR code par équipement de la copropriété</h1>
			<p class="page-hero__lead">Ascenseur, porte de parking, hall d'entrée : les occupants signalent ce qui ne va pas et donnent leur avis en un scan. Le gestionnaire est prévenu, l'historique reste attaché à l'équipement.</p>
			<div class="page-hero__cta">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'demo' ) ); ?>">Demander une démo</a>
				<a class="btn btn--on-navy btn--lg" href="<?php echo esc_url( panonfc_url( 'plaques' ) ); ?>">Voir les plaques</a>
			</div>
		</div>
	</div>
</section>

<section class="section section--white section--bordered-bottom">
	<div class="container" style="padding-top:56px;padding-bottom:56px">
		<div class="arg-strip">
			<div class="arg"><h3>Moins d'appels, mieux qualifiés</h3><p>Le signalement arrive rattaché à l'immeuble et à l'équipement concernés, sans ressaisie.</p></div>
			<div class="arg"><h3>Un historique par équipement</h3><p>Utile en conseil syndical comme avec le prestataire de maintenance.</p></div>
			<div class="arg"><h3>Rien à installer</h3><p>Ni application pour les occupants, ni matériel électrique : une plaque adhésive et un téléphone suffisent.</p></div>
		</div>
	</div>
</section>

<section class="section section--surface">
	<div class="container section__inner--internal section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">Pour les gestionnaires</span>
				<h2 class="h2--md">Tout le portefeuille dans un seul espace</h2>
				<p class="muted mt-4 section-lead">Chaque immeuble est une résidence, rattachée au gestionnaire ou à l'agence qui le suit. Les droits se règlent par agence.</p>
				<a class="arrow-link mt-6" style="display:inline-block" href="<?php echo esc_url( panonfc_url( 'avis' ) ); ?>">Découvrir Avis Résidents →</a>
			</div>
			<div class="usecases">
				<div class="usecase"><div class="t">Ascenseurs</div><p>Fonctionnement, propreté, pannes signalées.</p></div>
				<div class="usecase"><div class="t">Portes de parking</div><p>Ouverture, sécurité, télécommandes.</p></div>
				<div class="usecase"><div class="t">Halls d'entrée</div><p>Propreté, éclairage, interphone.</p></div>
				<div class="usecase"><div class="t">Locaux communs</div><p>Vélos, poubelles, caves.</p></div>
			</div>
		</div>
	</div>
</section>

<?php
panonfc_faq_section( 'syndics', 'Les questions des syndics' );

get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'       => 'Combien d\'immeubles à équiper ?',
		'lead'        => 'Indiquez le nombre d\'immeubles et d\'équipements : nous vous proposons une démonstration et un chiffrage.',
		'primary'     => array( 'label' => 'Demander une démo', 'url' => panonfc_url( 'demo' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'small'       => true,
	)
);

get_footer();
