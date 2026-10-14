<?php
/**
 * Template Name: PANONFC — Plaques QR / NFC équipements
 *
 * Page produit du support physique pour équipements (ascenseurs, portes…).
 *
 * @package panonfc
 */

panonfc_habitat_topbar();
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
					array( 'label' => 'Plaques QR code / NFC pour équipements' ),
				)
			);
			?>
		</div>
		<div class="split split--55-45">
			<div>
			<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Ascenseurs · Portes · Équipements techniques</span>
			<h1>Plaques QR code et NFC anti-métal pour vos équipements</h1>
			<p class="page-hero__lead measure-sm">Une plaque par équipement, un identifiant unique, un lien que vous pilotez. Conçue pour les parties communes et les surfaces métalliques, livrée à vos couleurs et prête à poser.</p>
			<div class="page-hero__cta">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
				<a class="btn btn--on-navy btn--lg" href="#caracteristiques">Caractéristiques</a>
			</div>
		</div>
			<figure class="hero__photo shadow-hero-el">
				<?php panonfc_img( 'hab-plaque-studio', 'Plaque blanche avec QR code, identifiant unique à six caractères et pictogramme NFC', '', 1400, 788, false ); ?>
			</figure>
		</div>
	</div>
</section>

<section class="section section--white" id="caracteristiques">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Caractéristiques</span>
			<h2 class="h2">Deux versions, un même standard</h2>
		</div>
		<div class="grid cols-2 grid--gap-lg">
			<article class="card card--accent stack">
				<div class="product-card__cat">Recommandée sur métal</div>
				<h3 class="offer-title">Plaque QR code + NFC anti-métal</h3>
				<p class="muted mb-6 card-text-15">Pour les ascenseurs, portails et portes métalliques : la puce reste lisible là où une puce classique échoue.</p>
				<ul class="marker-list">
					<li><span class="mk mk--orange">✓</span>PETG résistant, format 8 × 8 cm</li>
					<li><span class="mk mk--orange">✓</span>Impression UV, adhésif 3M</li>
					<li><span class="mk mk--orange">✓</span>Puce NFC anti-métal, verrouillée après encodage</li>
					<li><span class="mk mk--orange">✓</span>QR code et puce sur le même lien dynamique</li>
				</ul>
			</article>
			<article class="card stack">
				<div class="product-card__cat">Économique</div>
				<h3 class="offer-title">Plaque QR code seul</h3>
				<p class="muted mb-6 card-text-15">Mêmes matériaux et même identifiant unique, sans puce NFC. Pour les supports non métalliques ou les budgets serrés.</p>
				<ul class="marker-list">
					<li><span class="mk mk--orange">✓</span>PETG résistant, format 8 × 8 cm</li>
					<li><span class="mk mk--orange">✓</span>Impression UV, adhésif 3M</li>
					<li><span class="mk mk--orange">✓</span>QR code unique par équipement</li>
					<li><span class="mk mk--orange">✓</span>Lien modifiable après la pose</li>
				</ul>
			</article>
		</div>
	</div>
</section>

<?php
panonfc_photo_grid(
	array(
		'eyebrow' => 'En situation',
		'title'   => 'Faites pour les parties communes',
		'items'   => array(
			array( 'key' => 'hab-cabine', 'alt' => "Plaque QR code et NFC près des boutons d'une cabine d'ascenseur en inox", 'caption' => "Sur l'inox d'une cabine d'ascenseur : la puce NFC anti-métal reste lisible." ),
			array( 'key' => 'hab-garage', 'alt' => "Plaque QR code et NFC près du boîtier d'une porte de garage automatique", 'caption' => "Près du boîtier d'une porte de garage, en intérieur comme en extérieur." ),
			array( 'key' => 'hab-lot-plaques', 'alt' => 'Douze plaques aux couleurs de quatre bailleurs, chacune avec son QR code et son identifiant', 'caption' => 'Livrées à vos couleurs, chaque plaque avec son identifiant unique.' ),
		),
	)
);
?>

<section class="section section--surface">
	<div class="container section__inner--internal section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">De la maquette à la pose</span>
				<h2 class="h2--md">Votre charte, notre production, vos équipes</h2>
				<p class="muted mt-4 section-lead">Nous préparons la maquette à vos couleurs et vous soumettons un BAT. Les plaques sont livrées en une fois au siège ; vos équipes les posent et les associent à chaque équipement depuis la plateforme.</p>
			</div>
			<div class="usecases">
				<div class="usecase"><div class="t">Identifiant unique</div><p>Chaque plaque est traçable et réaffectable individuellement.</p></div>
				<div class="usecase"><div class="t">Lien dynamique</div><p>La destination se change depuis la plateforme, sans remplacer la plaque.</p></div>
				<div class="usecase"><div class="t">Puce verrouillée</div><p>Son contenu ne peut pas être réécrit par un tiers.</p></div>
				<div class="usecase"><div class="t">Remplacement simple</div><p>Une plaque abîmée est remplacée sans perdre l'historique de l'équipement.</p></div>
			</div>
		</div>
	</div>
</section>

<section class="section section--navy-deep">
	<div class="container section__inner">
		<div class="measure" style="max-width:760px">
			<div>
				<span class="eyebrow eyebrow--on-navy">Et derrière la plaque</span>
				<h2 class="h2--md">Recueillir l'avis des résidents, équipement par équipement</h2>
				<p class="on-navy-dim mt-5 mb-7 section-lead">Associées au module Avis Résidents, les plaques ouvrent un questionnaire propre à chaque équipement et alimentent un tableau de bord par résidence et par agence.</p>
				<a class="arrow-link" href="<?php echo esc_url( panonfc_url( 'avis' ) ); ?>">Découvrir Avis Résidents →</a>
			</div>
		</div>
	</div>
</section>

<?php
panonfc_faq_section( 'plaques', 'Les plaques en questions' );

get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'   => 'Combien d\'équipements à identifier ?',
		'lead'    => 'Indiquez le nombre de plaques et la version souhaitée : nous chiffrons et vous envoyons une maquette avant tout engagement.',
		'primary' => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'small'   => true,
	)
);

get_footer();
