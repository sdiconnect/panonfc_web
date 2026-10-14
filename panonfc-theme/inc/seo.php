<?php
/**
 * Lightweight built-in SEO: document title, meta description, canonical,
 * Open Graph / Twitter tags and JSON-LD (Organization, WebPage, FAQPage).
 *
 * Everything steps aside automatically when Yoast SEO, Rank Math or
 * SEOPress is active, so installing one of them later never duplicates tags.
 *
 * Per-page overrides (no plugin needed): custom fields
 *   _panonfc_seo_title  — full <title>
 *   _panonfc_seo_desc   — meta description
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is a dedicated SEO plugin handling the head?
 *
 * @return bool
 */
function panonfc_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/**
 * Brand name as written everywhere on the front end.
 *
 * @return string
 */
function panonfc_brand() {
	return apply_filters( 'panonfc_brand', 'PanoNFC' );
}

/**
 * Default SEO copy, keyed by page template file (or 'front' / 'blog').
 * Titles stay under ~60 characters, descriptions under ~155.
 *
 * @return array
 */
function panonfc_seo_defaults() {
	return apply_filters(
		'panonfc_seo_defaults',
		array(
			'front'                                 => array(
				'title' => 'Panneaux connectés QR code et NFC | PanoNFC',
				'desc'  => 'Panneaux immobiliers et de chantier connectés, plaques QR code / NFC pour équipements et plateforme de suivi. Design inclus, lien modifiable après la pose.',
				'faq'   => '',
			),
			'templates/template-immobilier.php'     => array(
				'title' => 'Panneau immobilier connecté QR code et NFC | PanoNFC',
				'desc'  => 'Panneaux « À vendre » et « À louer » connectés : le passant scanne et consulte l\'annonce, les photos et vos coordonnées. À partir de 21,90 € HT.',
				'faq'   => '',
			),
			'templates/template-chantier.php'       => array(
				'title' => 'Panneau de chantier connecté QR code et NFC | PanoNFC',
				'desc'  => 'Panneaux de chantier connectés : informations du programme, permis et contacts accessibles en un scan. Contenu modifiable pendant toute la durée du chantier.',
				'faq'   => '',
			),
			'templates/template-solution.php'       => array(
				'title' => 'Comment fonctionne un panneau connecté | PanoNFC',
				'desc'  => 'De la commande à la pose : maquette, BAT, production, activation et pilotage de vos panneaux connectés depuis la console web PanoNFC.',
				'faq'   => '',
			),
			'templates/template-tarifs.php'         => array(
				'title' => 'Tarifs panneaux connectés et Compte Entreprise | PanoNFC',
				'desc'  => 'Prix des panneaux connectés dégressifs selon le volume, Compte Entreprise multi-agences et offres pour les bailleurs et syndics.',
				'faq'   => '',
			),
			'templates/template-avis-residents.php' => array(
				'title' => 'Avis Résidents : satisfaction locataires par QR code | PanoNFC',
				'desc'  => 'Questionnaire de satisfaction par QR code et NFC sur chaque ascenseur, porte de garage ou hall. Avis anonymes, alertes par agence, tableau de bord.',
				'faq'   => 'avis',
			),
			'templates/template-bailleurs.php'      => array(
				'title' => 'Satisfaction des locataires pour bailleurs sociaux | PanoNFC',
				'desc'  => 'Mesurez en continu la satisfaction des locataires sur les ascenseurs, portes de garage et parties communes, agence par agence. Démo et pilote possibles.',
				'faq'   => 'bailleurs',
			),
			'templates/template-syndics.php'        => array(
				'title' => 'QR code pour copropriété et syndic | PanoNFC',
				'desc'  => 'Un QR code par équipement de la copropriété : signalements et avis des occupants rattachés à l\'immeuble et à l\'équipement, sans application.',
				'faq'   => 'syndics',
			),
			'templates/template-plaques.php'        => array(
				'title' => 'Plaque QR code et NFC anti-métal pour équipements | PanoNFC',
				'desc'  => 'Plaques PETG 8 × 8 cm, QR code et puce NFC anti-métal verrouillée, adhésif 3M, identifiant unique et lien modifiable. Pour ascenseurs et portes.',
				'faq'   => 'plaques',
			),
			'templates/template-compte-entreprise.php' => array(
				'title' => 'Compte Entreprise multi-agences | PanoNFC',
				'desc'  => 'Gérez les panneaux connectés de tout votre réseau : agences, collaborateurs illimités, droits par agence et statistiques consolidées. 490 € HT / an.',
				'faq'   => 'entreprise',
			),
		)
	);
}

/**
 * SEO entry for the current request, or null.
 *
 * @return array|null
 */
function panonfc_seo_current() {
	$map = panonfc_seo_defaults();
	$key = '';

	if ( is_front_page() ) {
		$key = 'front';
	} elseif ( is_page() ) {
		$key = get_page_template_slug( get_queried_object_id() );
	}

	$entry = ( $key && isset( $map[ $key ] ) ) ? $map[ $key ] : null;

	if ( is_singular() ) {
		$id    = get_queried_object_id();
		$title = trim( (string) get_post_meta( $id, '_panonfc_seo_title', true ) );
		$desc  = trim( (string) get_post_meta( $id, '_panonfc_seo_desc', true ) );
		if ( $title || $desc ) {
			$entry          = $entry ? $entry : array( 'title' => '', 'desc' => '', 'faq' => '' );
			$entry['title'] = $title ? $title : $entry['title'];
			$entry['desc']  = $desc ? $desc : $entry['desc'];
		}
	}

	return $entry;
}

/**
 * Meta description for any request (falls back to the excerpt).
 *
 * @return string
 */
function panonfc_seo_description() {
	$entry = panonfc_seo_current();
	if ( $entry && ! empty( $entry['desc'] ) ) {
		return $entry['desc'];
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		$text = trim( preg_replace( '/\s+/', ' ', $text ) );
		if ( $text ) {
			return wp_html_excerpt( $text, 155, '…' );
		}
	}
	return get_bloginfo( 'description' );
}

/**
 * Full <title>.
 */
function panonfc_seo_document_title( $title ) {
	if ( panonfc_seo_plugin_active() ) {
		return $title;
	}
	$entry = panonfc_seo_current();
	if ( $entry && ! empty( $entry['title'] ) ) {
		return $entry['title'];
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'panonfc_seo_document_title', 20 );

/**
 * Brand-correct site name in generated titles ("Page – PanoNFC").
 */
function panonfc_seo_title_parts( $parts ) {
	if ( panonfc_seo_plugin_active() ) {
		return $parts;
	}
	if ( isset( $parts['site'] ) ) {
		$parts['site'] = panonfc_brand();
	}
	if ( isset( $parts['title'] ) && is_front_page() ) {
		$parts['title'] = panonfc_brand();
	}
	return $parts;
}
add_filter( 'document_title_parts', 'panonfc_seo_title_parts' );

/**
 * Meta tags + JSON-LD.
 */
function panonfc_seo_head() {
	if ( panonfc_seo_plugin_active() ) {
		return;
	}

	$desc  = panonfc_seo_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink( get_queried_object_id() ) : home_url( add_query_arg( array() ) );
	if ( is_front_page() ) {
		$url = home_url( '/' );
	}

	$image = '';
	if ( is_singular() && has_post_thumbnail( get_queried_object_id() ) ) {
		$image = get_the_post_thumbnail_url( get_queried_object_id(), 'large' );
	}
	if ( ! $image ) {
		$image = panonfc_image( 'hero-home' );
	}

	echo "\n<!-- PanoNFC SEO -->\n";
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	if ( is_search() || is_404() ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	}
	printf( '<meta property="og:locale" content="fr_FR">' . "\n" );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( panonfc_brand() ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	// JSON-LD graph.
	$graph   = array();
	$org_id  = home_url( '/#organization' );
	$graph[] = array(
		'@type'     => 'Organization',
		'@id'       => $org_id,
		'name'      => panonfc_brand(),
		'legalName' => 'Solutions Digitales Intégrées',
		'url'       => home_url( '/' ),
		'logo'      => panonfc_asset( 'assets/img/panonfc-square.svg' ),
		'telephone' => '+33' . ltrim( preg_replace( '/\D/', '', panonfc_phone_display() ), '0' ),
		'address'   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '60 rue François 1er',
			'postalCode'      => '75008',
			'addressLocality' => 'Paris',
			'addressCountry'  => 'FR',
		),
	);

	if ( is_singular() || is_front_page() ) {
		$graph[] = array(
			'@type'       => 'WebPage',
			'@id'         => $url . '#webpage',
			'url'         => $url,
			'name'        => $title,
			'description' => $desc,
			'inLanguage'  => 'fr-FR',
			'isPartOf'    => array( '@id' => home_url( '/#website' ) ),
			'publisher'   => array( '@id' => $org_id ),
		);
	}
	if ( is_front_page() ) {
		$graph[] = array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/#website' ),
			'url'       => home_url( '/' ),
			'name'      => panonfc_brand(),
			'publisher' => array( '@id' => $org_id ),
		);
	}

	$entry = panonfc_seo_current();
	if ( $entry && ! empty( $entry['faq'] ) && function_exists( 'panonfc_faqs' ) ) {
		$items = array();
		foreach ( panonfc_faqs( $entry['faq'] ) as $faq ) {
			$items[] = array(
				'@type'          => 'Question',
				'name'           => $faq['q'],
				'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['a'] ),
			);
		}
		if ( $items ) {
			$graph[] = array( '@type' => 'FAQPage', 'mainEntity' => $items );
		}
	}

	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	echo "<!-- /PanoNFC SEO -->\n";
}
add_action( 'wp_head', 'panonfc_seo_head', 2 );

/**
 * Let editors set the SEO fields from the page editor (Custom Fields panel)
 * without exposing them as "protected" underscore meta.
 */
function panonfc_seo_register_meta() {
	foreach ( array( 'page', 'post' ) as $type ) {
		foreach ( array( '_panonfc_seo_title', '_panonfc_seo_desc' ) as $key ) {
			register_post_meta(
				$type,
				$key,
				array(
					'type'          => 'string',
					'single'        => true,
					'show_in_rest'  => true,
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}
add_action( 'init', 'panonfc_seo_register_meta' );
