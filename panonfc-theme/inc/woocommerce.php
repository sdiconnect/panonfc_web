<?php
/**
 * WooCommerce integration.
 *
 * WooCommerce stays the checkout funnel. This file only adjusts markup so
 * shop/cart/checkout sit inside the theme container and inherit the design
 * system. The bespoke product layout lives in woocommerce/single-product.php.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replace the default WooCommerce content wrappers with our container.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action(
	'woocommerce_before_main_content',
	function () {
		echo '<section class="section section--white"><div class="container section__inner--tight section__inner"><div class="woocommerce-page-inner">';
	},
	10
);
add_action(
	'woocommerce_after_main_content',
	function () {
		echo '</div></div></section>';
	},
	10
);

// Remove the default sidebar — this is a marketing storefront, not a blog.
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Products per row / per page on shop archives.
 */
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 12; } );

/**
 * Keep WooCommerce's own stylesheet (cart/checkout rely on it) but let our
 * design system win where classes overlap — our CSS is enqueued after.
 */

/**
 * Product Schema.org is emitted by WooCommerce structured data — leave it on.
 * (Do not remove wc structured data; the brief requires keeping Product schema.)
 */

/**
 * Configurator — quantity stepper injected into the native variations form.
 * Controls the real WooCommerce `.qty` input via configurator.js.
 */
function panonfc_render_cfg_qty() {
	?>
	<div class="cfg-field cfg-field--qty">
		<div class="cfg-field__label"><?php esc_html_e( 'Quantité', 'panonfc' ); ?></div>
		<div class="cfg-qty">
			<div class="cfg-stepper">
				<button type="button" data-qty="dec" aria-label="<?php esc_attr_e( 'Diminuer la quantité', 'panonfc' ); ?>">−</button>
				<div class="val" data-out="qty">1</div>
				<button type="button" data-qty="inc" aria-label="<?php esc_attr_e( 'Augmenter la quantité', 'panonfc' ); ?>">+</button>
			</div>
			<div class="cfg-shortcuts">
				<button type="button" data-qty="10">10</button>
				<button type="button" data-qty="25">25</button>
				<button type="button" data-qty="50">50</button>
				<button type="button" data-qty="100">100</button>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Configurator — synthesis card injected into the native variations form.
 * Values are filled from real variation prices by configurator.js.
 */
function panonfc_render_cfg_synth() {
	?>
	<div class="synth" data-synth>
		<div class="synth__top">
			<div>
				<div class="synth__label"><?php esc_html_e( 'Prix unitaire estimé', 'panonfc' ); ?></div>
				<div class="synth__unit">
					<span class="synth__price" data-out="unit">—</span>
					<span class="synth__discount" data-out="discount"></span>
				</div>
			</div>
			<div class="synth__total">
				<div class="synth__label"><?php esc_html_e( 'Total estimé', 'panonfc' ); ?></div>
				<div class="v" data-out="total">—</div>
			</div>
		</div>
		<div class="synth__note"><?php esc_html_e( 'Prix issus de vos variations WooCommerce ; le prix ferme et les remises par quantité sont recalculés au panier. Éléments graphiques à transmettre après la commande — BAT sous 48 h.', 'panonfc' ); ?></div>
	</div>
	<?php
}

/**
 * Helper: does the current single product template want our bespoke layout?
 * The client can opt a product out with the `_panonfc_default_layout` meta.
 */
function panonfc_use_custom_pdp() {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return false;
	}
	$optout = get_post_meta( get_the_ID(), '_panonfc_default_layout', true );
	return apply_filters( 'panonfc_use_custom_pdp', 'yes' !== $optout );
}
