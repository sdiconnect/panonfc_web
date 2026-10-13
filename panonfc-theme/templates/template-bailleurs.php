<?php
/**
 * Template Name: PANONFC — Bailleurs sociaux
 *
 * Page métier « Bailleurs sociaux » : porte d'entrée de l'univers Habitat.
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
					array( 'label' => 'Bailleurs sociaux' ),
				)
			);
			?>
		</div>
		<div class="measure" style="max-width:760px">
			<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Bailleurs sociaux · ESH · OPH</span>
			<h1>Mesurez la satisfaction de vos locataires là où elle se joue</h1>
			<p class="page-hero__lead">Ascenseurs, portes de garage, halls : la qualité de service se juge sur les équipements du quotidien. PanoNFC équipe chacun d'une plaque QR code et NFC et vous donne, agence par agence, une mesure continue de ce que vivent vos locataires.</p>
			<div class="page-hero__cta">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'demo' ) ); ?>">Demander une démo</a>
				<a class="btn btn--on-navy btn--lg" href="<?php echo esc_url( panonfc_url( 'avis' ) ); ?>">Découvrir Avis Résidents</a>
			</div>
		</div>
	</div>
</section>

<section class="section section--white section--bordered-bottom">
	<div class="container" style="padding-top:56px;padding-bottom:56px">
		<div class="arg-strip">
			<div class="arg"><h3>Une mesure continue</h3><p>Au lieu d'une enquête ponctuelle, des avis au fil de l'eau, rattachés à un équipement et à une date.</p></div>
			<div class="arg"><h3>Un pilotage par agence</h3><p>Chaque agence suit ses résidences ; la direction compare et repère les équipements qui décrochent.</p></div>
			<div class="arg"><h3>Un levier sur vos prestataires</h3><p>Des notes par ascenseur et par porte, datées et exportables, pour objectiver les échanges avec la maintenance.</p></div>
		</div>
	</div>
</section>

<section class="section section--surface">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Ce que vous équipez</span>
			<h2 class="h2">Les équipements qui font la qualité de service</h2>
		</div>
		<div class="grid cols-2 grid--gap-lg">
			<article class="card card--accent stack">
				<div class="product-card__cat">Ascenseurs</div>
				<h3 class="offer-title">Fonctionnement, propreté, pannes</h3>
				<p class="muted card-text-15">Le résident indique si l'ascenseur fonctionnait, note son état et signale le problème rencontré. Un avis négatif alerte l'agence.</p>
			</article>
			<article class="card stack">
				<div class="product-card__cat">Portes de garage</div>
				<h3 class="offer-title">Ouverture, sécurité, télécommandes</h3>
				<p class="muted card-text-15">Questionnaire dédié aux portes automatiques, en intérieur comme en extérieur, avec plaque adaptée aux surfaces métalliques.</p>
			</article>
			<article class="card stack">
				<div class="product-card__cat">Halls et parties communes</div>
				<h3 class="offer-title">Propreté, éclairage, accès</h3>
				<p class="muted card-text-15">Un retour simple sur l'entretien des parties communes, résidence par résidence.</p>
			</article>
			<article class="card stack">
				<div class="product-card__cat">Locaux techniques et annexes</div>
				<h3 class="offer-title">Selon vos priorités</h3>
				<p class="muted card-text-15">Locaux vélos, poubelles, caves : chaque type d'équipement peut avoir son propre questionnaire.</p>
			</article>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">Déploiement</span>
				<h2 class="h2--md">Un pilote, puis tout le parc</h2>
				<p class="muted mt-4 section-lead">Nous démarrons par quelques résidences pour valider les questionnaires et les circuits d'alerte, puis nous déployons au rythme de vos agences.</p>
			</div>
			<div class="usecases">
				<div class="usecase"><div class="t">1. Démonstration</div><p>Un espace à vos couleurs, avec des résidences et des avis fictifs.</p></div>
				<div class="usecase"><div class="t">2. Paramétrage</div><p>Questionnaires par type d'équipement, agences, destinataires des alertes.</p></div>
				<div class="usecase"><div class="t">3. Pilote</div><p>Quelques résidences équipées pendant trois mois, export des réponses inclus.</p></div>
				<div class="usecase"><div class="t">4. Plaques à vos couleurs</div><p>Maquette, BAT, production et livraison groupée au siège.</p></div>
				<div class="usecase"><div class="t">5. Import du parc</div><p>Résidences, équipements et agences importés à partir de votre fichier.</p></div>
				<div class="usecase"><div class="t">6. Pose et association</div><p>Vos équipes posent et associent chaque plaque à son équipement.</p></div>
			</div>
		</div>
	</div>
</section>

<?php
panonfc_faq_section( 'bailleurs', 'Les questions des bailleurs' );

get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'       => 'Combien d\'équipements à suivre ?',
		'lead'        => 'Donnez-nous le nombre d\'ascenseurs, de portes et de résidences : nous vous proposons une démonstration et un chiffrage pour un pilote puis pour le parc complet.',
		'primary'     => array( 'label' => 'Demander une démo', 'url' => panonfc_url( 'demo' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'reassurance' => 'Réponse par un interlocuteur unique · Démonstration gratuite',
	)
);

get_footer();
