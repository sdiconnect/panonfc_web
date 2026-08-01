<?php
/**
 * Template Name: PANONFC — Tarifs
 *
 * @package panonfc
 */

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
					array( 'label' => 'Tarifs' ),
				)
			);
			?>
		</div>
		<div class="measure" style="max-width:700px">
			<h1>Un prix par panneau. Rien d'autre.</h1>
			<p class="page-hero__lead">Le design, l'identifiant unique, la puce NFC et l'accès à la console sont compris dans le prix du support. Pas de frais de mise en service, pas d'abonnement mensuel.</p>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--tight section__inner">
		<div class="grid cols-3 grid--gap-lg">
			<article class="card card--accent stack">
				<div class="product-card__cat">Immobilier</div>
				<h2 class="offer-title">Panneau plat connecté</h2>
				<p class="muted mb-6 card-text-15">40×60, 60×80 ou 80×120 cm. Recto ou recto-verso, œillets en option.</p>
				<div class="offer-price-row">
					<span class="subtle" style="font-size:13px">à partir de</span>
					<span class="offer-price">21,90 €</span>
					<span class="subtle" style="font-size:13px">HT</span>
				</div>
				<ul class="marker-list mb-7">
					<li><span class="mk mk--orange">✓</span>Design repris et BAT inclus</li>
					<li><span class="mk mk--orange">✓</span>QR code, NFC ou les deux</li>
					<li><span class="mk mk--orange">✓</span>Commande en ligne immédiate</li>
				</ul>
				<a class="btn btn--navy btn--block mt-auto" href="<?php echo esc_url( panonfc_url( 'produit' ) ); ?>">Configurer et commander</a>
			</article>

			<article class="card stack">
				<div class="product-card__cat">Immobilier</div>
				<h2 class="offer-title">Panneau en V connecté</h2>
				<p class="muted mb-6 card-text-15">Double face, pour les biens en angle ou en bord d'axe passant.</p>
				<div class="offer-price-row">
					<span class="offer-price">Sur devis</span>
				</div>
				<ul class="marker-list mb-7">
					<li><span class="mk mk--orange">✓</span>Identifiant unique par face</li>
					<li><span class="mk mk--orange">✓</span>Même standard Akylux 5 mm</li>
					<li><span class="mk mk--orange">✓</span>Chiffrage sous 24 h</li>
				</ul>
				<a class="btn btn--secondary btn--block mt-auto" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
			</article>

			<article class="card stack">
				<div class="product-card__cat">Chantier</div>
				<h2 class="offer-title">Panneau réglementaire</h2>
				<p class="muted mb-6 card-text-15">Mentions du permis intégrées, formats de chantier, déploiement multi-sites.</p>
				<div class="offer-price-row">
					<span class="offer-price">Sur devis</span>
				</div>
				<ul class="marker-list mb-7">
					<li><span class="mk mk--orange">✓</span>Grands formats disponibles</li>
					<li><span class="mk mk--orange">✓</span>Un identifiant par site ou par lot</li>
					<li><span class="mk mk--orange">✓</span>Facturation par opération</li>
				</ul>
				<a class="btn btn--secondary btn--block mt-auto" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
			</article>
		</div>
	</div>
</section>

<section class="section section--surface section--bordered-top">
	<div class="container section__inner">
		<div class="split split--40-60">
			<div>
				<span class="eyebrow">Dégressivité</span>
				<h2 class="h2--sm">Le prix unitaire baisse dès la cinquième pièce</h2>
				<p class="muted mt-4 mb-6 section-lead">Remises appliquées automatiquement au panier sur le panneau plat 40 × 60 recto. Elles valent aussi pour les réassorts : le gabarit est déjà validé, seule la quantité change.</p>
				<a class="btn btn--accent" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Chiffrer un volume supérieur</a>
			</div>
			<?php panonfc_pricing_table(); ?>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--tight section__inner">
		<?php
		if ( function_exists( 'get_field' ) && get_field( 'tarifs_atelier' ) ) {
			echo '<div class="mb-13">';
			panonfc_gallery_item( 'tarifs_atelier', 'Atelier et impression UV — production PANONFC' );
			echo '</div>';
		}
		?>
		<div class="grid cols-2 grid--gap-56">
			<div>
				<h2 class="block-title-28">Compris dans le prix</h2>
				<ul class="marker-list" style="gap:12px">
					<li><span class="mk mk--success">✓</span>Reprise ou adaptation de votre visuel</li>
					<li><span class="mk mk--success">✓</span>Intégration du QR code et de l'identifiant unique</li>
					<li><span class="mk mk--success">✓</span>BAT et cycle de validation</li>
					<li><span class="mk mk--success">✓</span>Puce NFC intégrée en production</li>
					<li><span class="mk mk--success">✓</span>Impression UV sur Akylux 5 mm</li>
					<li><span class="mk mk--success">✓</span>Compte et console de gestion, sans abonnement</li>
				</ul>
			</div>
			<div>
				<h2 class="block-title-28">Questions tarifaires</h2>
				<div class="stack" style="gap:20px">
					<div class="faq"><h3>Y a-t-il des frais de création ?</h3><p>Non pour une reprise de visuel ou de charte. Une création graphique complète se chiffre au devis.</p></div>
					<div class="faq"><h3>Les prix sont-ils HT ?</h3><p>Oui, tous les tarifs affichés sont hors taxes, hors frais de livraison.</p></div>
					<div class="faq"><h3>Peut-on être facturé par agence ?</h3><p>Oui. Pour les réseaux, la facturation peut être centralisée ou ventilée par point de vente.</p></div>
					<div class="faq"><h3>La remise vaut-elle sur plusieurs formats ?</h3><p>Sur devis, oui : nous consolidons les quantités d'une même commande, tous formats confondus.</p></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'     => 'Un chiffrage précis en 24 h',
		'lead'      => 'Volume, formats, nombre d\'agences ou de sites : donnez-nous le cadre, nous revenons avec un tarif ferme.',
		'primary'   => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'secondary' => array( 'label' => '', 'url' => '' ),
		'small'     => true,
	)
);

get_footer();
