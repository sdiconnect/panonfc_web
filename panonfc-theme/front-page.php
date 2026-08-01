<?php
/**
 * Home page (Accueil).
 *
 * @package panonfc
 */

get_header();
?>

<?php /* 1. HERO ------------------------------------------------------------ */ ?>
<section class="section hero section--clip">
	<span class="hero__arc hero__arc--1" aria-hidden="true"></span>
	<span class="hero__arc hero__arc--2" aria-hidden="true"></span>
	<span class="hero__arc hero__arc--3" aria-hidden="true"></span>
	<div class="container hero__inner">
		<div class="hero__body">
			<span class="eyebrow eyebrow--boxed"><span class="dot"></span>NFC + QR code · Immobilier &amp; chantier</span>
			<h1 class="hero__title">Le panneau reste sur le terrain.<br>L'information, elle, suit le prospect.</h1>
			<p class="hero__lead">Nous produisons vos panneaux immobiliers et de chantier en Akylux 5 mm, chacun doté d'un identifiant unique, d'un QR code et d'une puce NFC. Le passant scanne, il accède à la bonne information ; vous pilotez le contenu depuis votre console, sans réimprimer.</p>
			<div class="hero__cta">
				<a class="btn btn--accent btn--hero" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
				<a class="btn btn--on-navy btn--hero" href="#gamme">Voir la gamme</a>
			</div>
			<div class="proof-row">
				<div><div class="proof__value">Akylux 5 mm</div><div class="proof__label">Impression UV</div></div>
				<div><div class="proof__value">BAT validé</div><div class="proof__label">Avant production</div></div>
				<div><div class="proof__value">48 à 72 h</div><div class="proof__label">Délai de livraison</div></div>
				<div><div class="proof__value">Dès 14,40 €</div><div class="proof__label">HT l'unité, dégressif</div></div>
			</div>
		</div>
		<div class="hero__media">
			<figure class="hero__photo">
				<img src="<?php echo esc_url( panonfc_image( 'hero-home' ) ); ?>" alt="Panneau en V connecté PANONFC installé devant un bien" width="920" height="460" fetchpriority="high">
			</figure>
			<div class="floatcard">
				<div class="floatcard__head">
					<span class="floatcard__ref">Panneau nº PN-4821</span>
					<span class="badge badge--success"><span class="dot"></span>Actif</span>
				</div>
				<div class="floatcard__title">Maison 5 pièces — Vertou</div>
				<div class="floatcard__meta">Destination : fiche du bien · réf. 21-04</div>
				<div class="floatcard__foot">
					<span class="chip chip--navy">NFC</span>
					<span class="chip chip--navy">QR code</span>
					<span class="subtle">Lien modifiable</span>
				</div>
			</div>
		</div>
	</div>
</section>

<?php /* 2. TRUST LOGOS ----------------------------------------------------- */ ?>
<section class="section section--white section--bordered-bottom">
	<div class="container trust__inner">
		<div class="trust__label">Agences et réseaux équipés</div>
		<div class="trust__logos">
			<?php foreach ( panonfc_client_logos() as $logo ) : ?>
				<img src="<?php echo esc_url( $logo['src'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" loading="lazy" style="height:<?php echo (int) $logo['h']; ?>px">
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php /* 3. LE PRINCIPE ----------------------------------------------------- */ ?>
<section class="section section--white" id="solution">
	<div class="container section__inner">
		<div class="split split--45-55 split--start">
			<div>
				<span class="eyebrow">Le principe</span>
				<h2 class="h2">Un panneau, un identifiant, un contenu que vous gardez sous contrôle</h2>
				<p class="lead--sm muted mt-5">Chaque panneau produit par PANONFC porte un identifiant unique imprimé et une puce NFC associée. Il est administrable seul, depuis votre console, à tout moment — y compris une fois posé.</p>
			</div>
			<div class="feature-grid">
				<div class="card feature">
					<div class="feature__icon feature__icon--navy">ID</div>
					<h3>Un identifiant par panneau</h3>
					<p>Chaque support est traçable individuellement : vous savez lequel est posé où, et vous l'activez d'un geste.</p>
				</div>
				<div class="card feature">
					<div class="feature__icon feature__icon--orange">↻</div>
					<h3>Un contenu modifiable</h3>
					<p>Bien vendu, prix révisé, nouveau programme : vous changez la destination du panneau sans le réimprimer.</p>
				</div>
				<div class="card feature">
					<div class="feature__icon feature__icon--navy">0</div>
					<h3>Aucune application</h3>
					<p>Le QR code se scanne avec l'appareil photo, le NFC par simple approche du téléphone. Rien à installer.</p>
				</div>
				<div class="card feature">
					<div class="feature__icon feature__icon--navy">BAT</div>
					<h3>Votre charte, reprise</h3>
					<p>Nous adaptons votre visuel pour intégrer proprement QR code et identifiant. Rien n'est produit sans votre validation.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php /* 4. PARCOURS DU SCAN (navy) ----------------------------------------- */ ?>
<section class="section section--navy-deep section--clip">
	<div class="container section__inner">
		<div class="split split--60-40">
			<div>
				<span class="eyebrow eyebrow--on-navy">Sur le terrain</span>
				<h2 class="h2 mb-11">Du trottoir à la prise de contact, en trois secondes</h2>
				<ul class="steps-list">
					<li class="step-item">
						<span class="step-item__num">01</span>
						<div>
							<div class="step-item__title">Le passant approche son téléphone</div>
							<p>Il scanne le QR code ou touche la zone NFC du panneau. Aucun téléchargement, aucun compte.</p>
						</div>
					</li>
					<li class="step-item">
						<span class="step-item__num">02</span>
						<div>
							<div class="step-item__title">La bonne page s'ouvre immédiatement</div>
							<p>Fiche du bien, programme, formulaire, coordonnées de l'agence : vous décidez de la destination.</p>
						</div>
					</li>
					<li class="step-item">
						<span class="step-item__num">03</span>
						<div>
							<div class="step-item__title">Le contact arrive chez vous</div>
							<p>Le prospect appelle ou laisse ses coordonnées depuis son téléphone, sans passer par l'agence.</p>
						</div>
					</li>
				</ul>
				<a class="arrow-link" href="<?php echo esc_url( panonfc_url( 'solution' ) ); ?>">Voir comment ça marche →</a>
			</div>
			<div class="phone-wrap">
				<span class="arc arc--o" style="width:420px;height:420px" aria-hidden="true"></span>
				<span class="arc arc--o" style="width:300px;height:300px;border-color:rgba(254,132,27,0.2)" aria-hidden="true"></span>
				<div class="phone">
					<div class="phone__screen">
						<div class="phone__notch"><span></span></div>
						<div class="phone__photo">
							<img src="<?php echo esc_url( panonfc_image( 'phone-listing' ) ); ?>" alt="Fiche d'un bien immobilier ouverte après un scan" loading="lazy">
							<span class="phone__tag">Scanné à l'instant</span>
						</div>
						<div class="phone__body">
							<div class="phone__agency">
								<img src="<?php echo esc_url( panonfc_asset( 'assets/img/panonfc-square.svg' ) ); ?>" alt="">
								<span>Agence Rivière Immobilier</span>
							</div>
							<div class="phone__listing">Maison 5 pièces · 128 m²</div>
							<div class="phone__loc">Vertou (44120) · Jardin 420 m²</div>
							<div class="phone__price"><b>449 000 €</b><span>Honoraires inclus</span></div>
							<div class="phone__btns">
								<div class="phone__btn phone__btn--accent">Être rappelé</div>
								<div class="phone__btn phone__btn--ghost">Voir les 14 photos</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php /* 5. LA GAMME -------------------------------------------------------- */ ?>
<section class="section section--surface" id="gamme">
	<div class="container section__inner">
		<div class="section-head">
			<div class="section-head__title">
				<span class="eyebrow">La gamme</span>
				<h2 class="h2">Trois supports, un même standard de fabrication</h2>
			</div>
			<p class="section-head__aside">Akylux 5 mm, impression UV haute qualité, œillets en option, recto ou recto-verso. QR code seul, NFC seul ou les deux.</p>
		</div>
		<div class="product-cards">
			<article class="product-card product-card--accent" id="immobilier">
				<img class="product-card__img" src="<?php echo esc_url( panonfc_image( 'product-plat' ) ); ?>" alt="Panneau plat connecté" loading="lazy">
				<div class="product-card__body">
					<div class="product-card__cat">Immobilier</div>
					<h3>Panneau plat connecté</h3>
					<p class="product-card__desc">Le format attendu du marché, en façade, sur portail ou clôture. La base des commandes récurrentes agence.</p>
					<ul class="marker-list">
						<li><span class="mk mk--orange">—</span>40×60, 60×80 et 80×120 cm</li>
						<li><span class="mk mk--orange">—</span>Recto seul ou recto-verso</li>
						<li><span class="mk mk--orange">—</span>Avec ou sans 4 œillets</li>
					</ul>
					<div class="product-card__foot">
						<div>
							<div class="product-card__pricelabel">À partir de</div>
							<div class="product-card__price">21,90 € <span class="ht">HT</span></div>
						</div>
						<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( panonfc_url( 'produit' ) ); ?>">Configurer</a>
					</div>
				</div>
			</article>

			<article class="product-card">
				<img class="product-card__img" src="<?php echo esc_url( panonfc_image( 'product-v' ) ); ?>" alt="Panneau en V connecté" loading="lazy">
				<div class="product-card__body">
					<div class="product-card__cat">Immobilier</div>
					<h3>Panneau en V connecté</h3>
					<p class="product-card__desc">Double face, visible des deux sens de circulation. Pour les biens en angle ou sur axe passant.</p>
					<ul class="marker-list">
						<li><span class="mk mk--orange">—</span>Lecture recto-verso</li>
						<li><span class="mk mk--orange">—</span>Pose sur mât ou clôture</li>
						<li><span class="mk mk--orange">—</span>Identifiant unique par face</li>
					</ul>
					<div class="product-card__foot">
						<div>
							<div class="product-card__pricelabel">Tarif</div>
							<div class="product-card__price">Sur devis</div>
						</div>
						<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander</a>
					</div>
				</div>
			</article>

			<article class="product-card" id="chantier">
				<img class="product-card__img" src="<?php echo esc_url( panonfc_image( 'product-chantier' ) ); ?>" alt="Panneau de chantier réglementaire connecté" loading="lazy">
				<div class="product-card__body">
					<div class="product-card__cat">Chantier</div>
					<h3>Panneau de chantier réglementaire</h3>
					<p class="product-card__desc">Les mentions obligatoires du permis, plus un accès direct au dossier du programme pour les riverains.</p>
					<ul class="marker-list">
						<li><span class="mk mk--orange">—</span>Mentions du permis intégrées</li>
						<li><span class="mk mk--orange">—</span>Contenu chantier mis à jour</li>
						<li><span class="mk mk--orange">—</span>Déploiement multi-lots</li>
					</ul>
					<div class="product-card__foot">
						<div>
							<div class="product-card__pricelabel">Tarif</div>
							<div class="product-card__price">Sur devis</div>
						</div>
						<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander</a>
					</div>
				</div>
			</article>
		</div>
	</div>
</section>

<?php /* 6. LA CONSOLE ------------------------------------------------------ */ ?>
<section class="section section--white">
	<div class="container section__inner">
		<div class="split split--65-35">
			<div>
				<span class="eyebrow">La console</span>
				<h2 class="h2">Vos panneaux se pilotent depuis un seul écran</h2>
				<p class="lead--sm muted mt-5 mb-7">La création de compte est gratuite. Vous ajoutez un panneau avec son identifiant, vous le nommez, vous définissez la redirection de son QR code ou de son tag NFC — et vous la changez quand le bien évolue.</p>
				<ul class="marker-list gap-14 mb-8">
					<li><span class="mk mk--orange">✓</span>Ajout d'un panneau par identifiant unique</li>
					<li><span class="mk mk--orange">✓</span>Redirection QR code et NFC modifiable à tout moment</li>
					<li><span class="mk mk--orange">✓</span>Panneaux actifs ou en attente, en un coup d'œil</li>
					<li><span class="mk mk--orange">✓</span>Organisation par groupes (agence, programme, chantier)</li>
				</ul>
				<a class="btn btn--navy" href="<?php echo esc_url( panonfc_console_url() ); ?>">Accéder à la console</a>
			</div>
			<div class="browser">
				<div class="browser__bar">
					<span class="browser__dot"></span><span class="browser__dot"></span><span class="browser__dot"></span>
					<span class="browser__url">app.panonfc.com</span>
				</div>
				<div class="console">
					<div class="console__side">
						<img class="console__logo" src="<?php echo esc_url( panonfc_asset( 'assets/img/panonfc-square.svg' ) ); ?>" alt="">
						<div class="console__nav">Ajouter un panneau</div>
						<div class="console__nav console__nav--active">Mes panneaux</div>
						<div class="console__nav">Mes groupes</div>
						<div class="console__nav">Mon compte</div>
						<div class="console__account">Rivière Immobilier</div>
					</div>
					<div class="console__main">
						<div class="console__head">
							<div>
								<div class="console__h">Mes panneaux</div>
								<div class="console__sub">18 panneaux · 4 groupes</div>
							</div>
							<div class="console__cta">Nouveau panneau</div>
						</div>
						<div class="console__stats">
							<div class="console__stat"><div class="l">Panneaux actifs</div><div class="v">15</div></div>
							<div class="console__stat"><div class="l">En attente</div><div class="v">3</div></div>
							<div class="console__stat"><div class="l">Groupes</div><div class="v">4</div></div>
						</div>
						<div class="console__table">
							<div class="console__tr console__tr--head"><span>ID</span><span>Destination</span><span class="right">Statut</span></div>
							<div class="console__tr"><span class="id">PN-4821</span><span class="dest">Maison 5 p. — Vertou</span><span class="badge badge--success">Actif</span></div>
							<div class="console__tr"><span class="id">PN-4822</span><span class="dest">T3 Nantes centre</span><span class="badge badge--success">Actif</span></div>
							<div class="console__tr"><span class="id">PN-4823</span><span class="dest is-empty">Non définie</span><span class="badge badge--warning">En attente</span></div>
							<div class="console__tr"><span class="id">PN-4824</span><span class="dest">Chantier Les Hauts — lot 2</span><span class="badge badge--success">Actif</span></div>
						</div>
						<div class="console__note">Aperçu de la console — données d'exemple.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php /* 7. GALERIE PHOTO --------------------------------------------------- */ ?>
<?php
$home_gallery = array(
	array( 'field' => 'home_gallery_1', 'alt' => 'Panneau posé sur un portail' ),
	array( 'field' => 'home_gallery_2', 'alt' => 'Détail du QR code et de la zone NFC' ),
	array( 'field' => 'home_gallery_3', 'alt' => 'Panneau de chantier en situation' ),
);
$has_home_gallery = false;
if ( function_exists( 'get_field' ) ) {
	foreach ( $home_gallery as $g ) {
		if ( get_field( $g['field'] ) ) {
			$has_home_gallery = true;
			break;
		}
	}
}
if ( $has_home_gallery ) :
	?>
<section class="section section--white">
	<div class="container section__inner">
		<div class="section-head">
			<div class="section-head__title">
				<span class="eyebrow">Sur le terrain</span>
				<h2 class="h2--md">Nos panneaux, chez nos clients</h2>
			</div>
			<p class="section-head__aside">Photos de pose réelles : façades, portails, chantiers, vitrines d'agence.</p>
		</div>
		<div class="gallery">
			<?php foreach ( $home_gallery as $g ) : ?>
				<?php panonfc_gallery_item( $g['field'], $g['alt'] ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php /* 8. LE DÉROULÉ ------------------------------------------------------ */ ?>
<section class="section section--surface section--bordered-top">
	<div class="container section__inner">
		<div class="measure" style="margin-bottom:52px">
			<span class="eyebrow">Le déroulé</span>
			<h2 class="h2">De la commande au panneau posé, en quatre étapes</h2>
		</div>
		<div class="grid cols-4 grid--gap">
			<div class="card"><div class="deroule-num">01</div><h3 class="mini-card-h">Commande ou devis</h3><p class="mini-card-p">En ligne pour les formats standards, sur devis pour les déploiements réseau et les panneaux de chantier.</p></div>
			<div class="card"><div class="deroule-num">02</div><h3 class="mini-card-h">Votre identité graphique</h3><p class="mini-card-p">Vous transmettez logo, charte ou modèle existant. Nous reprenons le design et intégrons QR code et ID.</p></div>
			<div class="card"><div class="deroule-num">03</div><h3 class="mini-card-h">Validation du BAT</h3><p class="mini-card-p">Rien ne part en production avant votre accord écrit sur la maquette finale.</p></div>
			<div class="card"><div class="deroule-num">04</div><h3 class="mini-card-h">Livraison et activation</h3><p class="mini-card-p">Panneaux livrés sous 48 à 72 h, puis activés en quelques minutes depuis votre console.</p></div>
		</div>
	</div>
</section>

<?php /* 9. TARIFS ---------------------------------------------------------- */ ?>
<section class="section section--white" id="tarifs">
	<div class="container section__inner">
		<div class="split split--45-55">
			<div>
				<span class="eyebrow">Tarifs</span>
				<h2 class="h2">Un prix unitaire qui baisse avec le volume</h2>
				<p class="lead--sm muted mt-5 mb-7">Le design, l'intégration du QR code, l'identifiant unique et l'accès à la console sont compris dans le prix du panneau. Pas d'abonnement pour gérer vos supports.</p>
				<div class="btn-row">
					<a class="btn btn--accent" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis volume</a>
					<a class="btn btn--secondary" href="<?php echo esc_url( panonfc_url( 'produit' ) ); ?>">Commander en ligne</a>
				</div>
			</div>
			<?php
			panonfc_pricing_table(
				'Panneau plat connecté',
				'Prix unitaire HT · dégressif par quantité',
				'Tarifs indicatifs pour le format standard. Autres dimensions, panneaux en V et chantier : sur devis.',
				'Design inclus'
			);
			?>
		</div>
	</div>
</section>

<?php /* 10. FAQ ------------------------------------------------------------ */ ?>
<section class="section section--surface section--bordered-top">
	<div class="container section__inner">
		<div class="split split--75-25 split--start">
			<div>
				<span class="eyebrow">Questions fréquentes</span>
				<h2 class="h2--sm">Les réponses avant l'appel</h2>
				<p class="muted mt-4" style="font-size:15px;line-height:1.6">Une question qui ne figure pas ici ? Appelez-nous au <a class="link-strong" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a>.</p>
			</div>
			<div class="faq-grid">
				<div class="faq"><h3>Faut-il une application pour scanner ?</h3><p>Non. Le QR code se lit avec l'appareil photo du téléphone et le NFC par simple approche, sur iOS comme sur Android.</p></div>
				<div class="faq"><h3>Puis-je changer le lien après la pose ?</h3><p>Oui, autant de fois que nécessaire, depuis la console. Le panneau reste en place, seule sa destination change.</p></div>
				<div class="faq"><h3>Le design est-il vraiment inclus ?</h3><p>Oui. Nous reprenons votre visuel ou votre charte pour intégrer le QR code et l'identifiant, avec BAT avant production.</p></div>
				<div class="faq"><h3>Quels délais de livraison ?</h3><p>48 à 72 heures après validation du BAT, pour les commandes standards comme pour les réassorts.</p></div>
				<div class="faq"><h3>Et pour un réseau multi-agences ?</h3><p>Vos panneaux s'organisent en groupes — par agence, programme ou chantier — avec un gabarit commun décliné à chaque point de vente.</p></div>
				<div class="faq"><h3>La console est-elle payante ?</h3><p>Non. La création de compte et la gestion de vos panneaux sont comprises dans le prix des panneaux, sans abonnement.</p></div>
			</div>
		</div>
	</div>
</section>

<?php /* 11. CTA FINAL ------------------------------------------------------ */ ?>
<?php
get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'id'          => 'devis',
		'title'       => 'Décrivez votre besoin, nous chiffrons sous 24 h',
		'lead'        => 'Un bien, un programme ou un parc de plusieurs centaines de panneaux : dites-nous le volume et les formats, nous revenons avec une recommandation claire.',
		'primary'     => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'reassurance' => 'Réponse par un interlocuteur unique · Devis gratuit et sans engagement',
	)
);
?>

<?php
get_footer();
