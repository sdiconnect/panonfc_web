<?php
/**
 * Asset loading. tokens.css is always loaded first (design-system variables),
 * then main.css. Poppins is self-hosted inside tokens.css.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end styles & scripts.
 */
function panonfc_enqueue_assets() {
	// 1. Tokens first — variables + @font-face.
	wp_enqueue_style(
		'panonfc-tokens',
		PANONFC_URI . '/assets/css/tokens.css',
		array(),
		PANONFC_VERSION
	);

	// 2. Main stylesheet (depends on tokens).
	wp_enqueue_style(
		'panonfc-main',
		PANONFC_URI . '/assets/css/main.css',
		array( 'panonfc-tokens' ),
		PANONFC_VERSION
	);

	// Preload the two most-used font weights for a faster first paint.
	add_action( 'wp_head', 'panonfc_preload_fonts', 1 );

	// Interaction JS (burger menu, smooth anchors).
	wp_enqueue_script(
		'panonfc-main',
		PANONFC_URI . '/assets/js/main.js',
		array(),
		PANONFC_VERSION,
		true
	);

	// Product configurator estimator (single product only).
	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script(
			'panonfc-configurator',
			PANONFC_URI . '/assets/js/configurator.js',
			array(),
			PANONFC_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'panonfc_enqueue_assets' );

/**
 * Preload the woff2 files that appear above the fold.
 */
function panonfc_preload_fonts() {
	$fonts = array( 'poppins-400.woff2', 'poppins-600.woff2', 'poppins-800.woff2' );
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( PANONFC_URI . '/assets/fonts/' . $font )
		);
	}
}

/**
 * Editor: load tokens so block colors/fonts roughly match the front-end.
 */
function panonfc_editor_assets() {
	add_editor_style( array( 'assets/css/tokens.css', 'assets/css/editor.css' ) );
}
add_action( 'after_setup_theme', 'panonfc_editor_assets' );
