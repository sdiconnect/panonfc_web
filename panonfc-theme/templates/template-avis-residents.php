<?php
/**
 * Template Name: PANONFC — Avis Résidents
 *
 * Page produit du module « Avis Résidents » (bailleurs, syndics, gestionnaires).
 *
 * @package panonfc
 */

panonfc_habitat_topbar();
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
					array( 'label' => 'Bailleurs & syndics', 'url' => panonfc_url( 'bailleurs' ) ),
					array( 'label' => 'Avis Résidents' ),
				)
			);
			?>
		</div>
		<div class="split split--55-45">
			<div>
				<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Bailleurs · Syndics · Gestionnaires de patrimoine</span>
				<h1>L'avis des résidents, équipement par équipement</h1>
				<p class="page-hero__lead measure-sm">Une plaque QR code et NFC sur chaque ascenseur, porte de garage ou hall. Le résident scanne, répond en trente secondes, anonymement. Vous suivez la satisfaction par équipement, résidence et agence, et vous êtes alerté dès qu'un avis est négatif.</p>
				<div class="page-hero__cta">
					<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'demo' ) ); ?>">Demander une démo</a>
					<a class="btn btn--on-navy btn--lg" href="#fonctionnement">Voir le fonctionnement</a>
				</div>
			</div>
			<div class="floatcard floatcard--static" aria-hidden="true">
				<div class="floatcard__head">
					<span class="floatcard__ref">Ascenseur bât. A</span>
					<span class="badge badge--warning">Avis à surveiller</span>
				</div>
				<div class="floatcard__title">Résidence Les Sources</div>
				<div class="floatcard__meta">Note moyenne 90 jours : 3,4 / 5 · 128 avis · 2 avis négatifs cette semaine</div>
				<div class="floatcard__foot">Alerte envoyée à l'agence Marseille Nord</div>
			</div>
		</div>
	</div>
</section>

<section class="section section--white section--bordered-bottom">
	<div class="container" style="padding-top:56px;padding-bottom:56px">
		<div class="arg-strip">
			<div class="arg"><h3>Trente secondes, sans application</h3><p>Le résident scanne le QR code ou approche son téléphone de la puce NFC : le questionnaire de l'équipement s'ouvre directement.</p></div>
			<div class="arg"><h3>Anonyme par conception</h3><p>Aucune donnée personnelle demandée ni conservée. Seuls l'avis, l'équipement et la date sont enregistrés.</p></div>
			<div class="arg"><h3>Une alerte, pas un rapport annuel</h3><p>Un avis négatif prévient l'agence concernée par e-mail : le problème est traité avant de devenir une réclamation.</p></div>
		</div>
	</div>
</section>

<section class="section section--surface" id="fonctionnement">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Fonctionnement</span>
			<h2 class="h2">Du scan au tableau de bord, sans ressaisie</h2>
		</div>
		<div class="feature-grid">
			<div class="card feature">
				<div class="feature__icon feature__icon--navy">1</div>
				<h3>Une plaque par équipement</h3>
				<p>Chaque plaque porte un identifiant unique, associé à un équipement précis d'une résidence. Le résident n'a rien à saisir.</p>
			</div>
			<div class="card feature">
				<div class="feature__icon feature__icon--orange">2</div>
				<h3>Un questionnaire adapté</h3>
				<p>Questions propres à chaque type d'équipement : notes, oui / non, choix et commentaire libre, aux couleurs de votre organisme.</p>
			</div>
			<div class="card feature">
				<div class="feature__icon feature__icon--navy">3</div>
				<h3>Des alertes ciblées</h3>
				<p>Seuil réglable, destinataires par agence, adresses supplémentaires : la bonne personne est prévenue, pas toute l'organisation.</p>
			</div>
			<div class="card feature">
				<div class="feature__icon feature__icon--navy">4</div>
				<h3>Un suivi consolidé</h3>
				<p>Notes, avis négatifs et taux de réponse par équipement, résidence et agence, sur 7 jours à 12 mois, avec export compatible Excel.</p>
			</div>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">Gestion du parc</span>
				<h2 class="h2--md">Votre patrimoine, organisé comme vous travaillez</h2>
				<p class="muted mt-4 section-lead">Résidences, équipements et agences sont structurés dans la plateforme. Chaque collaborateur voit son périmètre, la direction voit l'ensemble.</p>
			</div>
			<div class="usecases">
				<div class="usecase"><div class="t">Import du parc</div><p>Toutes vos résidences et tous vos équipements en une fois, à partir d'un fichier.</p></div>
				<div class="usecase"><div class="t">Association à la pose</div><p>Chaque plaque de votre stock est rattachée à son équipement au moment où elle est posée.</p></div>
				<div class="usecase"><div class="t">Remplacement de plaque</div><p>Plaque abîmée ? Une nouvelle prend le relais, l'historique de l'équipement est conservé.</p></div>
				<div class="usecase"><div class="t">Droits par agence</div><p>Direction, responsable d'agence, lecture seule : chacun accède à ce qui le concerne.</p></div>
				<div class="usecase"><div class="t">Équipements à surveiller</div><p>Classement automatique des équipements et résidences dont la note se dégrade.</p></div>
				<div class="usecase"><div class="t">Export des réponses</div><p>Pour vos comités, vos prestataires de maintenance ou vos enquêtes réglementaires.</p></div>
			</div>
		</div>
	</div>
</section>

<section class="section section--navy-deep">
	<div class="container section__inner">
		<div class="split split--60-40">
			<div>
				<span class="eyebrow eyebrow--on-navy">Le support physique</span>
				<h2 class="h2--md">Une plaque faite pour les parties communes</h2>
				<p class="on-navy-dim mt-5 mb-7 section-lead">PETG résistant, impression UV, adhésif 3M et puce NFC anti-métal, lisible sur une porte d'ascenseur ou un portail. QR code et puce à identifiant unique, puce verrouillée, lien modifiable à tout moment.</p>
				<a class="arrow-link" href="<?php echo esc_url( panonfc_url( 'plaques' ) ); ?>">Voir les plaques QR code / NFC →</a>
			</div>
			<ul class="marker-list marker-list--on-navy">
				<li><span class="mk mk--orange">—</span>Format 8 × 8 cm, à vos couleurs</li>
				<li><span class="mk mk--orange">—</span>QR code seul ou QR code + NFC</li>
				<li><span class="mk mk--orange">—</span>BAT soumis avant production</li>
				<li><span class="mk mk--orange">—</span>Livraison groupée au siège</li>
			</ul>
		</div>
	</div>
</section>

<?php
panonfc_faq_section( 'avis', 'Avis Résidents en questions' );

get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'       => 'Voyez-le sur votre propre parc',
		'lead'        => 'Nous ouvrons un espace de démonstration à vos couleurs, avec des résidences et des avis fictifs, puis nous vous proposons un pilote sur quelques résidences.',
		'primary'     => array( 'label' => 'Demander une démo', 'url' => panonfc_url( 'demo' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'reassurance' => 'Démonstration gratuite · Pilote possible avant tout déploiement',
	)
);

get_footer();
