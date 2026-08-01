<?php
/**
 * PANONFC theme bootstrap.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Version is read from style.css so it stays the single source of truth.
if ( ! defined( 'PANONFC_VERSION' ) ) {
	$panonfc_theme = wp_get_theme( 'panonfc-theme' );
	define( 'PANONFC_VERSION', $panonfc_theme->exists() ? $panonfc_theme->get( 'Version' ) : '1.0.0' );
}

define( 'PANONFC_DIR', get_template_directory() );
define( 'PANONFC_URI', get_template_directory_uri() );

// GitHub repository used by the self-updater (owner/repo).
if ( ! defined( 'PANONFC_GITHUB_REPO' ) ) {
	define( 'PANONFC_GITHUB_REPO', 'sdiconnect/panonfc_web' );
}

require_once PANONFC_DIR . '/inc/setup.php';
require_once PANONFC_DIR . '/inc/enqueue.php';
require_once PANONFC_DIR . '/inc/template-tags.php';
require_once PANONFC_DIR . '/inc/menus.php';
require_once PANONFC_DIR . '/inc/contact-form.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once PANONFC_DIR . '/inc/woocommerce.php';
}

// Load the self-updater in admin and during cron so WordPress detects new
// GitHub releases both when you open the dashboard and on scheduled checks.
if ( is_admin() || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
	require_once PANONFC_DIR . '/inc/class-github-updater.php';
	Panonfc_GitHub_Updater::init(
		PANONFC_GITHUB_REPO,
		'panonfc-theme',
		PANONFC_VERSION
	);
}
