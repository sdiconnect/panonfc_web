<?php
/**
 * Bespoke single product template (PANONFC).
 *
 * Overrides WooCommerce's single-product.php. WooCommerce remains the checkout
 * funnel. The approved pill configurator is a progressive enhancement of the
 * NATIVE variations form: configurator.js turns the real variation selects
 * into pills and reads each variation's REAL price from WooCommerce's
 * `found_variation` event — no hardcoded prices, it adapts to whatever
 * attributes the product defines (dimensions, technologie, œillets, …). The
 * quantity stepper drives the real qty input and the real add-to-cart button
 * handles purchasing, so the final price + degressive discounts are computed
 * by WooCommerce at cart. The synthesis card shows a live estimate.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! panonfc_use_custom_pdp() ) {
	// Fall back to WooCommerce's standard single-product output for
	// opted-out products (meta _panonfc_default_layout = yes).
	get_header( 'shop' );
	do_action( 'woocommerce_before_main_content' );
	while ( have_posts() ) {
		the_post();
		wc_get_template_part( 'content', 'single-product' );
	}
	do_action( 'woocommerce_after_main_content' );
	get_footer( 'shop' );
	return;
}

get_header( 'shop' );

while ( have_posts() ) :
	the_post();
	global $product;
	if ( ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_the_ID() );
	}

	// Gallery image URLs (featured + gallery), with theme fallbacks.
	$main_img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : panonfc_image( 'pdp-main' );
	$gallery_ids = $product ? $product->get_gallery_image_ids() : array();
	$thumbs = array();
	foreach ( array_slice( $gallery_ids, 0, 3 ) as $gid ) {
		$thumbs[] = wp_get_attachment_image_url( $gid, 'woocommerce_thumbnail' );
	}
	if ( count( $thumbs ) < 3 ) {
		$fallback_thumbs = array( panonfc_image( 'pdp-thumb-1' ), panonfc_image( 'pdp-thumb-2' ), panonfc_image( 'pdp-thumb-3' ) );
		$thumbs = array_slice( array_merge( $thumbs, $fallback_thumbs ), 0, 3 );
	}

	$cats = wc_get_product_category_list( get_the_ID(), ', ' );
	?>

	<div class="breadcrumb">
		<div class="container">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'Immobilier', 'url' => panonfc_url( 'immobilier' ) ),
					array( 'label' => get_the_title() ),
				)
			);
			?>
		</div>
	</div>

	<section class="section section--white">
		<div class="container section__inner--tight section__inner">
			<div class="pdp">
				<?php /* LEFT — gallery + guarantees */ ?>
				<div>
					<figure class="pdp__gallery-main">
						<img src="<?php echo esc_url( $main_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="640" height="420">
					</figure>
					<div class="pdp__thumbs">
						<?php foreach ( $thumbs as $t ) : ?>
							<?php if ( $t ) : ?><img src="<?php echo esc_url( $t ); ?>" alt="" loading="lazy"><?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="pdp__guarantees">
						<div class="spec spec--sm"><div class="t">Akylux 5 mm</div><p>Support standardisé, rigide et durable.</p></div>
						<div class="spec spec--sm"><div class="t">Design inclus</div><p>Votre visuel repris ou ajusté par nos soins.</p></div>
						<div class="spec spec--sm"><div class="t">Validation BAT</div><p>Aucune production sans votre accord.</p></div>
					</div>
				</div>

				<?php /* RIGHT — summary, configurator (estimator), native add-to-cart */ ?>
				<div>
					<div class="pdp__cat"><?php echo $cats ? wp_kses_post( wp_strip_all_tags( $cats ) ) : esc_html__( 'Immobilier · Panneau connecté', 'panonfc' ); ?></div>
					<h1><?php the_title(); ?></h1>
					<div class="pdp__desc"><?php echo wp_kses_post( $product ? apply_filters( 'woocommerce_short_description', $product->get_short_description() ) : '' ); ?>
						<?php if ( ! $product || ! $product->get_short_description() ) : ?>
							Panneau immobilier en Akylux 5 mm avec QR code et/ou puce NFC, identifiant unique et design inclus. Le format attendu du marché, rendu administrable depuis votre console.
						<?php endif; ?>
					</div>

					<?php if ( $product ) : ?>
						<div class="pdp__range">
							<span class="from">Prix</span>
							<span class="val"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
						</div>
					<?php endif; ?>

					<?php
					/*
					 * Live configurator driven by the REAL WooCommerce variations.
					 * The native variations form is rendered here; configurator.js
					 * turns its selects into design pills, reads each variation's
					 * real price on `found_variation`, and fills the synthesis card.
					 * The quantity stepper + synthesis card are injected into the
					 * native form via hooks (see inc/woocommerce.php) so the real
					 * add-to-cart keeps working and prices stay accurate.
					 */
					$panonfc_variable = $product && $product->is_type( 'variable' );
					if ( $panonfc_variable ) {
						add_action( 'woocommerce_after_variations_table', 'panonfc_render_cfg_qty', 10 );
						add_action( 'woocommerce_after_variations_table', 'panonfc_render_cfg_synth', 20 );
					}
					?>
					<div class="configurator" data-configurator>
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>
					<?php
					if ( $panonfc_variable ) {
						remove_action( 'woocommerce_after_variations_table', 'panonfc_render_cfg_qty', 10 );
						remove_action( 'woocommerce_after_variations_table', 'panonfc_render_cfg_synth', 20 );
					}
					?>
					<div class="synth__actions">
						<a class="btn btn--secondary" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Devis volume</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php /* Situation photos (ACF, optional) */ ?>
	<?php
	if ( function_exists( 'get_field' ) && ( get_field( 'pdp_situation_1' ) || get_field( 'pdp_situation_2' ) ) ) :
		?>
	<section class="section section--white">
		<div class="container section__inner--tight section__inner" style="padding-bottom:0">
			<div class="gallery gallery--duo">
				<?php
				panonfc_gallery_item( 'pdp_situation_1', 'Panneau plat posé sur un portail' );
				panonfc_gallery_item( 'pdp_situation_2', 'Prospect scannant le panneau' );
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php /* Descending price table */ ?>
	<section class="section section--surface section--bordered-top">
		<div class="container section__inner--tight section__inner">
			<div class="split split--40-60 split--start">
				<div>
					<span class="eyebrow">Tarif dégressif</span>
					<h2 class="h2--sm">Plus le volume monte, plus l'unité baisse</h2>
					<p class="muted mt-4 section-lead">Remises appliquées automatiquement au panier, sur le format 40 × 60 recto. Au-delà de 100 pièces ou pour un déploiement réseau, demandez un devis.</p>
				</div>
				<?php panonfc_pricing_table(); ?>
			</div>
		</div>
	</section>

	<?php /* Arguments + FAQ */ ?>
	<section class="section section--white">
		<div class="container section__inner">
			<div class="grid cols-2 grid--gap-64">
				<div>
					<h2 class="block-title-30">Pourquoi ce panneau tient sur le terrain</h2>
					<ul class="marker-list" style="gap:14px">
						<li><span class="mk mk--orange">✓</span>Format standard, immédiat à comprendre et à commander</li>
						<li><span class="mk mk--orange">✓</span>Image plus moderne qu'un panneau classique, sans surcoût de pose</li>
						<li><span class="mk mk--orange">✓</span>Accès direct à l'information depuis le trottoir</li>
						<li><span class="mk mk--orange">✓</span>Design repris et validé avant production</li>
						<li><span class="mk mk--orange">✓</span>Base idéale pour les commandes récurrentes d'agence</li>
					</ul>
				</div>
				<div>
					<h2 class="block-title-30">Questions fréquentes</h2>
					<div class="stack" style="gap:20px">
						<div class="faq"><h3>Le design est-il inclus ?</h3><p>Oui. Nous adaptons ou reprenons le visuel fourni pour intégrer proprement l'identifiant unique et le QR code, avec BAT avant production.</p></div>
						<div class="faq"><h3>Puis-je commander en QR code seul ?</h3><p>Oui : QR code seul, NFC seul ou les deux, selon les habitudes de votre clientèle.</p></div>
						<div class="faq"><h3>Les œillets sont-ils obligatoires ?</h3><p>Non. Le panneau se commande avec ou sans 4 œillets, selon le mode de pose prévu.</p></div>
						<div class="faq"><h3>Quel délai après validation ?</h3><p>48 à 72 heures pour la production et la livraison, une fois le BAT validé.</p></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Keep WooCommerce hooks (related products, structured data, tabs are
	// intentionally omitted from this bespoke layout, but the schema output
	// on the page footer via wc structured data remains).
	do_action( 'woocommerce_after_single_product' );
endwhile;

get_footer( 'shop' );
