<?php
/**
 * Navigation fallbacks — the site renders a correct menu even before the
 * client assigns one under Appearance → Menus.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default primary menu items (used when no menu is assigned to `primary`).
 *
 * @return array
 */
function panonfc_default_primary_items() {
	return apply_filters(
		'panonfc_default_primary_items',
		array(
			array( 'label' => 'Immobilier', 'url' => panonfc_url( 'immobilier' ) ),
			array( 'label' => 'Chantier', 'url' => panonfc_url( 'chantier' ) ),
			array( 'label' => 'La solution', 'url' => panonfc_url( 'solution' ) ),
			array( 'label' => 'Tarifs', 'url' => panonfc_url( 'tarifs' ) ),
			array( 'label' => 'Contact', 'url' => panonfc_url( 'contact' ) ),
		)
	);
}

/**
 * Fallback for the desktop primary nav.
 */
function panonfc_primary_fallback() {
	echo '<ul>';
	foreach ( panonfc_default_primary_items() as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Render the mobile menu links: assigned `primary` menu if present, else the
 * default items.
 */
function panonfc_mobile_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => '',
				'depth'          => 1,
			)
		);
		return;
	}
	echo '<ul>';
	foreach ( panonfc_default_primary_items() as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Footer menu fallbacks.
 */
function panonfc_footer_products_fallback() {
	echo '<ul>';
	echo '<li><a href="' . esc_url( panonfc_url( 'produit' ) ) . '">Panneau plat connecté</a></li>';
	echo '<li><a href="' . esc_url( panonfc_url( 'immobilier' ) ) . '">Panneau en V connecté</a></li>';
	echo '<li><a href="' . esc_url( panonfc_url( 'chantier' ) ) . '">Panneau de chantier</a></li>';
	echo '<li><a href="' . esc_url( panonfc_url( 'tarifs' ) ) . '">Tarifs</a></li>';
	echo '</ul>';
}

function panonfc_footer_resources_fallback() {
	echo '<ul>';
	echo '<li><a href="' . esc_url( panonfc_url( 'solution' ) ) . '">Comment ça marche</a></li>';
	echo '<li><a href="' . esc_url( panonfc_console_url() ) . '">Console client</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a></li>';
	echo '<li><a href="' . esc_url( panonfc_url( 'devis' ) ) . '">Demander un devis</a></li>';
	echo '</ul>';
}
