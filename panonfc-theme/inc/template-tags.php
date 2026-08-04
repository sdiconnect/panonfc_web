<?php
/**
 * Template helpers.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full URI to a theme asset.
 *
 * @param string $path Relative path inside the theme.
 * @return string
 */
function panonfc_asset( $path ) {
	return PANONFC_URI . '/' . ltrim( $path, '/' );
}

/**
 * Resolve an editorial image URL by key.
 *
 * Order of resolution:
 *   1. `panonfc_image_{key}` filter (per-key override).
 *   2. Default map below (existing panonfc.com media, so the site renders
 *      correctly out of the box on production).
 *
 * Editors who want to swap a photo can either upload with the same URL,
 * or hook the filter, or (recommended long term) wire ACF fields.
 *
 * @param string $key         Logical image key.
 * @param string $fallback    Optional fallback URL.
 * @return string
 */
function panonfc_image( $key, $fallback = '' ) {
	$map = array(
		'hero-home'        => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_008-scaled.jpg',
		'product-plat'     => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_001.jpg',
		'product-v'        => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_008-scaled.jpg',
		'product-chantier' => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_009-scaled.jpg',
		'immo-hero'        => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_002.jpg',
		'phone-listing'    => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_002.jpg',
		'console-shot'     => 'https://panonfc.com/wp-content/uploads/2026/05/application-pano-nfc.jpg',
		'immo-identity'    => 'https://panonfc.com/wp-content/uploads/2026/05/identite-graphique.jpg',
		'chantier-shot'    => 'https://panonfc.com/wp-content/uploads/2026/05/chantier-pano-nfc.jpg',
		'pdp-main'         => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_001.jpg',
		'pdp-thumb-1'      => 'https://panonfc.com/wp-content/uploads/2026/03/thomasud.jpg',
		'pdp-thumb-2'      => 'https://panonfc.com/wp-content/uploads/2026/04/panonfc_image_003.jpg',
		'pdp-thumb-3'      => 'https://panonfc.com/wp-content/uploads/2026/04/qr-scan-maison.webp',
	);

	$url = isset( $map[ $key ] ) ? $map[ $key ] : $fallback;

	/**
	 * Filter an editorial image URL.
	 *
	 * @param string $url The resolved URL.
	 * @param string $key The image key.
	 */
	return apply_filters( "panonfc_image_{$key}", apply_filters( 'panonfc_image', $url, $key ), $key );
}

/**
 * Client logo list for the trust row. Filterable so the client can swap
 * these for media-library IDs later.
 *
 * @return array Array of array( 'src' => , 'alt' => , 'h' => px ).
 */
function panonfc_client_logos() {
	$logos = array(
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/orpi-logo.png', 'alt' => 'Orpi', 'h' => 30 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/laforet.png', 'alt' => 'Laforêt', 'h' => 30 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/iad.png', 'alt' => 'iad', 'h' => 28 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/era-immobilier-logo.png', 'alt' => 'ERA Immobilier', 'h' => 30 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/stephane-plaza-logo.png', 'alt' => 'Stéphane Plaza Immobilier', 'h' => 32 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/safti-logo.png', 'alt' => 'Safti', 'h' => 26 ),
		array( 'src' => 'https://panonfc.com/wp-content/uploads/2026/03/city-a-immobilier.png', 'alt' => 'City A Immobilier', 'h' => 30 ),
	);
	return apply_filters( 'panonfc_client_logos', $logos );
}

/**
 * Header logo markup — custom logo if set, otherwise the bundled SVG lockup.
 */
function panonfc_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a href="%1$s" class="site-header__logo" rel="home"><img src="%2$s" alt="%3$s" width="140" height="32"></a>',
		esc_url( home_url( '/' ) ),
		esc_url( panonfc_asset( 'assets/img/panonfc-logo.svg' ) ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}

/**
 * Get an editorial field: ACF if available, otherwise the provided default.
 * Lets the theme render prototype copy out of the box while remaining
 * fully editable once ACF fields are added.
 *
 * @param string $name    Field name.
 * @param mixed  $default Default value.
 * @param int    $post_id Optional post ID.
 * @return mixed
 */
function panonfc_field( $name, $default = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $name, $post_id );
		if ( null !== $val && '' !== $val && false !== $val ) {
			return $val;
		}
	}
	return $default;
}

/**
 * Format a price the French way: narrow no-break thousands separator,
 * comma decimals, no-break space before the euro sign. e.g. 4 303,44 €.
 *
 * @param float $value Amount.
 * @return string
 */
function panonfc_eur( $value ) {
	$formatted = number_format( (float) $value, 2, ',', "\xE2\x80\xAF" ); // U+202F narrow no-break space.
	return $formatted . "\xC2\xA0€"; // U+00A0 no-break space before €.
}

/**
 * The theme phone number (single source of truth), filterable.
 */
function panonfc_phone_display() {
	return apply_filters( 'panonfc_phone_display', '09 80 80 62 96' );
}
function panonfc_phone_href() {
	return apply_filters( 'panonfc_phone_href', 'tel:0980806296' );
}
function panonfc_console_url() {
	return apply_filters( 'panonfc_console_url', 'https://app.panonfc.com/' );
}

/**
 * Resolve an internal page URL by its "role", so templates never hardcode
 * slugs. Falls back to home if the page does not exist yet.
 *
 * @param string $role One of: devis, solution, tarifs, immobilier, chantier, produit.
 * @return string
 */
function panonfc_url( $role ) {
	// Resolve each role once per request (avoids repeated get_page_by_path()
	// queries when the same CTA link is used many times on a page).
	static $cache = array();
	if ( isset( $cache[ $role ] ) ) {
		return $cache[ $role ];
	}

	$map = array(
		// Quote page (full form) — prefer a dedicated devis page, fall back to contact.
		'devis'      => array( 'demander-un-devis', 'devis', 'contact' ),
		// Simple contact page.
		'contact'    => array( 'contact', 'nous-contacter', 'demander-un-devis', 'devis' ),
		'solution'   => array( 'la-solution', 'comment-ca-marche', 'solution' ),
		'tarifs'     => array( 'tarifs', 'tarif' ),
		'immobilier' => array( 'immobilier' ),
		'chantier'   => array( 'chantier' ),
		'produit'    => array( 'produit/panneau-plat-connecte', 'panneau-plat-connecte' ),
	);

	$overrides = apply_filters( 'panonfc_url_overrides', array() );
	if ( isset( $overrides[ $role ] ) ) {
		return $cache[ $role ] = $overrides[ $role ];
	}

	if ( isset( $map[ $role ] ) ) {
		foreach ( $map[ $role ] as $slug ) {
			// Pages.
			$page = get_page_by_path( $slug );
			if ( $page ) {
				return $cache[ $role ] = get_permalink( $page );
			}
			// WooCommerce products (for the "produit" role).
			if ( 'produit' === $role && post_type_exists( 'product' ) ) {
				$product_slug = basename( $slug );
				$found        = get_page_by_path( $product_slug, OBJECT, 'product' );
				if ( $found ) {
					return $cache[ $role ] = get_permalink( $found );
				}
			}
		}
	}

	// Sensible last resort for the produit role: the shop page.
	if ( 'produit' === $role && function_exists( 'wc_get_page_id' ) ) {
		$shop = wc_get_page_id( 'shop' );
		if ( $shop > 0 ) {
			return $cache[ $role ] = get_permalink( $shop );
		}
	}

	return $cache[ $role ] = home_url( '/' );
}

/**
 * Numeric quantity-discount tiers used by the front-end estimator.
 * Fractions match the current site's degressive pricing (real data). The
 * final price and discount are always recomputed by WooCommerce at cart —
 * this only powers the live estimate. Filterable so it can be aligned with
 * the exact extension rules per product.
 *
 * @return array List of array( 'min' => int, 'd' => float, 'label' => string ).
 */
function panonfc_discount_tiers() {
	return apply_filters(
		'panonfc_discount_tiers',
		array(
			array( 'min' => 100, 'd' => 0.4098, 'label' => '−41 %' ),
			array( 'min' => 50,  'd' => 0.3607, 'label' => '−36 %' ),
			array( 'min' => 25,  'd' => 0.3115, 'label' => '−31 %' ),
			array( 'min' => 10,  'd' => 0.2213, 'label' => '−22 %' ),
			array( 'min' => 5,   'd' => 0.1311, 'label' => '−13 %' ),
			array( 'min' => 1,   'd' => 0,      'label' => '' ),
		)
	);
}

/**
 * Shared descending price table rows (single source of truth).
 *
 * @return array
 */
function panonfc_price_tiers() {
	return array(
		array( 'qty' => '1 à 4 pièces', 'disc' => '—', 'price' => '24,40 €', 'highlight' => false, 'disc_class' => 'is-subtle' ),
		array( 'qty' => '5 à 9 pièces', 'disc' => '−13 %', 'price' => '21,20 €', 'highlight' => false, 'disc_class' => 'is-muted' ),
		array( 'qty' => '10 à 24 pièces', 'disc' => '−22 %', 'price' => '19,00 €', 'highlight' => false, 'disc_class' => 'is-muted' ),
		array( 'qty' => '25 à 49 pièces', 'disc' => '−31 %', 'price' => '16,80 €', 'highlight' => false, 'disc_class' => 'is-muted' ),
		array( 'qty' => '50 à 99 pièces', 'disc' => '−36 %', 'price' => '15,60 €', 'highlight' => false, 'disc_class' => 'is-muted' ),
		array( 'qty' => '100 pièces et plus', 'disc' => '−41 %', 'price' => '14,40 €', 'highlight' => true, 'disc_class' => '' ),
	);
}

/**
 * Render a pricing table (compact variant). Reused across pages.
 *
 * @param string $title    Header title (empty to hide the header).
 * @param string $subtitle Header subtitle.
 * @param string $note     Footer note.
 * @param string $chip     Optional chip label.
 */
function panonfc_pricing_table( $title = '', $subtitle = '', $note = '', $chip = '' ) {
	echo '<div class="pricing pricing--compact">';

	if ( $title ) {
		echo '<div class="pricing__head"><div>';
		echo '<div class="t">' . esc_html( $title ) . '</div>';
		if ( $subtitle ) {
			echo '<div class="s">' . esc_html( $subtitle ) . '</div>';
		}
		echo '</div>';
		if ( $chip ) {
			echo '<span class="chip chip--navy chip--pill">' . esc_html( $chip ) . '</span>';
		}
		echo '</div>';
	}

	echo '<div class="pricing__row pricing__row--head"><span>Quantité</span><span class="r">Remise</span><span class="r">Prix unitaire</span></div>';

	foreach ( panonfc_price_tiers() as $row ) {
		$cls = 'pricing__row' . ( $row['highlight'] ? ' pricing__row--highlight' : '' );
		echo '<div class="' . esc_attr( $cls ) . '">';
		echo '<span class="qty">' . esc_html( $row['qty'] ) . '</span>';
		echo '<span class="r ' . esc_attr( $row['disc_class'] ) . '">' . esc_html( $row['disc'] ) . '</span>';
		echo '<span class="price">' . esc_html( $row['price'] ) . '</span>';
		echo '</div>';
	}

	if ( $note ) {
		echo '<div class="pricing__note">' . esc_html( $note ) . '</div>';
	}
	echo '</div>';
}

/**
 * Render a gallery item. Uses an ACF image field if present; otherwise the
 * provided fallback URL; otherwise nothing (never an empty frame in prod).
 *
 * @param string $acf_field ACF field name.
 * @param string $alt       Alt text / brief.
 * @param string $fallback  Fallback image URL.
 */
function panonfc_gallery_item( $acf_field, $alt, $fallback = '' ) {
	$img = '';

	if ( function_exists( 'get_field' ) ) {
		$field = get_field( $acf_field );
		if ( is_array( $field ) && ! empty( $field['url'] ) ) {
			$img = $field['url'];
			if ( ! empty( $field['alt'] ) ) {
				$alt = $field['alt'];
			}
		} elseif ( is_string( $field ) && $field ) {
			$img = $field;
		}
	}

	if ( ! $img && $fallback ) {
		$img = $fallback;
	}

	if ( ! $img ) {
		return; // graceful: render nothing rather than an empty placeholder.
	}

	printf(
		'<div class="gallery__item"><img src="%s" alt="%s" loading="lazy"></div>',
		esc_url( $img ),
		esc_attr( $alt )
	);
}

/**
 * Simple breadcrumb.
 *
 * @param array  $trail   Array of array( 'label' =>, 'url' => ) — url optional for current.
 * @param bool   $on_navy Whether the breadcrumb sits on a navy background.
 */
function panonfc_breadcrumb( $trail, $on_navy = false ) {
	$class = 'breadcrumb__inner';
	echo '<div class="' . esc_attr( $class ) . '">';
	$last = count( $trail ) - 1;
	foreach ( $trail as $i => $item ) {
		if ( ! empty( $item['url'] ) && $i !== $last ) {
			echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		} else {
			echo '<span class="current">' . esc_html( $item['label'] ) . '</span>';
		}
		if ( $i !== $last ) {
			echo '<span class="sep">›</span>';
		}
	}
	echo '</div>';
}
