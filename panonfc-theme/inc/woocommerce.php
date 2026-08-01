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
