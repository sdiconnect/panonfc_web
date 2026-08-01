<?php
/**
 * Template Name: PANONFC — Immobilier
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
					array( 'label' => 'Immobilier' ),
				)
			);
			?>
		</div>
		<div class="split split--55-45">
			<div>
				<span class="eyebrow eyebrow--boxed"><span class="dot"></span>Agences · Réseaux · Mandataires</span>
				<h1>Vos panneaux « À vendre » travaillent aussi la nuit</h1>
				<p class="page-hero__lead measure-sm">Le passant qui s'arrête devant le bien n'appelle pas toujours. S'il peut scanner, il consulte la fiche complète, les photos et vos coordonnées dans la seconde — et vous ne perdez plus le contact d'un dimanche soir.</p>
				<div class="page-hero__cta">
					<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
					<a class="btn btn--on-navy btn--lg" href="#produits">Voir les deux formats</a>
				</div>
			</div>
			<figure class="hero__photo shadow-hero-el">
				<img src="<?php echo esc_url( panonfc_image( 'immo-hero' ) ); ?>" alt="Panneau immobilier connecté devant un bien" width="700" height="340" class="img-cover-340">
			</figure>
		</div>
	</div>
</section>

<section class="section section--white section--bordered-bottom">
	<div class="container" style="padding-top:56px;padding-bottom:56px">
		<div class="arg-strip">
			<div class="arg"><h3>Le mandat visible 24 h/24</h3><p>Photos, surface, prix et honoraires accessibles au moment exact où le prospect regarde la façade.</p></div>
			<div class="arg"><h3>Un support qui vous survit au mandat</h3><p>Bien vendu ? Le panneau est réaffecté à un nouveau bien depuis la console, sans réimpression.</p></div>
			<div class="arg"><h3>Une image d'agence tenue</h3><p>Votre charte est reprise par nos soins : même gabarit sur tous les mandats, quel que soit le collaborateur.</p></div>
		</div>
	</div>
</section>

<section class="section section--surface" id="produits">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Deux formats</span>
			<h2 class="h2">Le plat pour la façade, le V pour la circulation</h2>
		</div>
		<div class="grid cols-2 grid--gap-lg">
			<article class="product-card product-card--accent">
				<img class="product-card__img product-card__img--tall" src="<?php echo esc_url( panonfc_image( 'product-plat' ) ); ?>" alt="Panneau plat connecté" loading="lazy">
				<div class="product-card__body product-card__body--lg">
					<h3 class="is-lg">Panneau plat connecté</h3>
					<p class="product-card__desc">Le format de référence : portail, clôture, façade d'agence ou hall de copropriété. Celui qu'on recommande pour équiper un portefeuille entier.</p>
					<ul class="marker-list">
						<li><span class="mk mk--orange">—</span>40×60, 60×80 et 80×120 cm</li>
						<li><span class="mk mk--orange">—</span>Recto seul ou recto-verso</li>
						<li><span class="mk mk--orange">—</span>Avec ou sans 4 œillets</li>
						<li><span class="mk mk--orange">—</span>QR code seul, NFC seul ou les deux</li>
					</ul>
					<div class="product-card__foot">
						<div>
							<div class="product-card__pricelabel">À partir de</div>
							<div class="product-card__price product-card__price--lg">21,90 € <span class="ht">HT</span></div>
						</div>
						<a class="btn btn--navy btn--sm" href="<?php echo esc_url( panonfc_url( 'produit' ) ); ?>">Configurer</a>
					</div>
				</div>
			</article>
			<article class="product-card">
				<img class="product-card__img product-card__img--tall" src="<?php echo esc_url( panonfc_image( 'product-v' ) ); ?>" alt="Panneau en V connecté" loading="lazy">
				<div class="product-card__body product-card__body--lg">
					<h3 class="is-lg">Panneau en V connecté</h3>
					<p class="product-card__desc">Deux faces, deux sens de circulation. Pour les biens en angle, en bord d'axe passant ou en retrait de la voie.</p>
					<ul class="marker-list">
						<li><span class="mk mk--orange">—</span>Lecture des deux côtés</li>
						<li><span class="mk mk--orange">—</span>Pose sur mât, clôture ou piquet</li>
						<li><span class="mk mk--orange">—</span>Identifiant unique par face</li>
						<li><span class="mk mk--orange">—</span>Même standard Akylux 5 mm</li>
					</ul>
					<div class="product-card__foot">
						<div>
							<div class="product-card__pricelabel">Tarif</div>
							<div class="product-card__price product-card__price--lg">Sur devis</div>
						</div>
						<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
					</div>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">Cas d'usage</span>
				<h2 class="h2--md">Là où vos panneaux sont déjà posés</h2>
				<p class="muted mt-4 section-lead">Aucun changement d'habitude : mêmes emplacements, même pose, même format. Seul le contenu accessible change.</p>
			</div>
			<div class="usecases">
				<div class="usecase"><div class="t">Maison individuelle</div><p>Portail ou clôture, vente comme location.</p></div>
				<div class="usecase"><div class="t">Appartement en résidence</div><p>Un panneau par lot, une destination par lot.</p></div>
				<div class="usecase"><div class="t">Vitrine d'agence</div><p>Vers votre portail de biens, hors horaires d'ouverture.</p></div>
				<div class="usecase"><div class="t">Terrain sur axe passant</div><p>Le format V, lisible dans les deux sens.</p></div>
				<div class="usecase"><div class="t">Réseau multi-agences</div><p>Un gabarit commun, un groupe par point de vente.</p></div>
				<div class="usecase"><div class="t">Mandataire indépendant</div><p>Petites séries, réassort à l'unité.</p></div>
			</div>
		</div>
	</div>
</section>

<?php
$immo_gallery = array(
	array( 'field' => 'immo_gallery_1', 'alt' => 'Panneau « À vendre » sur un portail' ),
	array( 'field' => 'immo_gallery_2', 'alt' => 'Panneau en V au bord d\'une route' ),
	array( 'field' => 'immo_gallery_3', 'alt' => 'Panneau en vitrine d\'agence' ),
);
$has_immo_gallery = false;
if ( function_exists( 'get_field' ) ) {
	foreach ( $immo_gallery as $g ) {
		if ( get_field( $g['field'] ) ) { $has_immo_gallery = true; break; }
	}
}
if ( $has_immo_gallery ) :
	?>
<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="section-head">
			<div class="section-head__title">
				<span class="eyebrow">En situation</span>
				<h2 class="h2--md">Le même panneau, tous vos mandats</h2>
			</div>
			<p class="section-head__aside">Maison, appartement, terrain, vitrine : un gabarit d'agence décliné sur chaque bien.</p>
		</div>
		<div class="gallery">
			<?php foreach ( $immo_gallery as $g ) { panonfc_gallery_item( $g['field'], $g['alt'] ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section section--navy-deep">
	<div class="container section__inner">
		<div class="split split--60-40">
			<div>
				<span class="eyebrow eyebrow--on-navy">Équiper un portefeuille</span>
				<h2 class="h2--md">Un gabarit validé une fois, décliné sur tous vos mandats</h2>
				<p class="on-navy-dim mt-5 mb-7 section-lead">Nous produisons votre maquette d'agence, vous la validez une seule fois, puis chaque réassort reprend le même gabarit avec de nouveaux identifiants. Les commandes suivantes se résument à une quantité.</p>
				<a class="arrow-link" href="<?php echo esc_url( panonfc_url( 'tarifs' ) ); ?>">Voir la dégressivité par volume →</a>
			</div>
			<figure class="console-band__media">
				<img src="<?php echo esc_url( panonfc_image( 'immo-identity' ) ); ?>" alt="Reprise de l'identité graphique de l'agence" loading="lazy" class="img-cover-300">
			</figure>
		</div>
	</div>
</section>

<?php
get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'     => 'Combien de mandats à équiper ?',
		'lead'      => 'Donnez-nous le volume et les formats : nous chiffrons sous 24 h et vous envoyons une maquette avant tout engagement.',
		'primary'   => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'secondary' => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'small'     => true,
	)
);

get_footer();
