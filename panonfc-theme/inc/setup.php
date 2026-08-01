<?php
/**
 * Theme setup: supports, menus, image sizes, Elementor cleanup.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core theme supports.
 */
function panonfc_setup() {
	load_theme_textdomain( 'panonfc', PANONFC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	// Custom logo (falls back to the bundled SVG when unset).
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 32,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// WooCommerce.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary'         => __( 'Menu principal', 'panonfc' ),
			'footer-products' => __( 'Pied de page — Produits', 'panonfc' ),
			'footer-resources'=> __( 'Pied de page — Ressources', 'panonfc' ),
		)
	);
}
add_action( 'after_setup_theme', 'panonfc_setup' );

/**
 * Content width.
 */
function panonfc_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'panonfc_content_width', 0 );

/**
 * Trim WordPress head of noise for a leaner, more "serious" front-end.
 */
function panonfc_clean_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	// Disable emoji script/style — not used in this design.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'panonfc_clean_head' );

/**
 * Elementor migration helper.
 *
 * The brief requires removing Elementor. When Elementor is deactivated, some
 * pages may still carry leftover `[elementor-*]` shortcodes in post_content.
 * This strips them from front-end output so no raw shortcode text is shown
 * while the client cleans the content up. It never modifies the stored data.
 */
function panonfc_strip_elementor_shortcodes( $content ) {
	if ( false === strpos( $content, 'elementor' ) ) {
		return $content;
	}
	// Remove [elementor-template ...], [elementor-tag ...] and similar leftovers.
	$content = preg_replace( '#\[/?elementor[^\]]*\]#i', '', $content );
	return $content;
}
add_filter( 'the_content', 'panonfc_strip_elementor_shortcodes', 5 );

/**
 * Add the `panonfc` class to <body> so our styles stay scoped.
 */
function panonfc_body_class( $classes ) {
	$classes[] = 'panonfc';
	return $classes;
}
add_filter( 'body_class', 'panonfc_body_class' );

/**
 * Register the illustrated-steps image size (la solution) — 1000x700, no crop.
 */
function panonfc_image_sizes() {
	add_image_size( 'panonfc-step', 1000, 700, false );
	add_image_size( 'panonfc-card', 640, 420, true );
	add_image_size( 'panonfc-hero', 920, 920, false );
}
add_action( 'after_setup_theme', 'panonfc_image_sizes' );
