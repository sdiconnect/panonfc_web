<?php
/**
 * Header: utility bar + sticky nav + mobile drawer.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Aller au contenu', 'panonfc' ); ?></a>

<div class="topbar">
	<div class="container topbar__inner">
		<div class="topbar__left">
			<span class="topbar__item"><span class="dot"></span><?php echo esc_html( apply_filters( 'panonfc_topbar_left_1', 'Fabrication et impression UV en France' ) ); ?></span>
			<span class="topbar__item"><?php echo esc_html( apply_filters( 'panonfc_topbar_left_2', 'Livraison 48 à 72 h après validation du BAT' ) ); ?></span>
		</div>
		<div class="topbar__right">
			<a class="topbar__phone" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a>
			<a class="topbar__link" href="<?php echo esc_url( panonfc_console_url() ); ?>"><?php esc_html_e( 'Espace client', 'panonfc' ); ?></a>
		</div>
	</div>
</div>

<header class="site-header">
	<div class="container site-header__inner">
		<?php panonfc_logo(); ?>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Menu principal', 'panonfc' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'depth'          => 1,
					'fallback_cb'    => 'panonfc_primary_fallback',
				)
			);
			?>
		</nav>

		<div class="site-header__actions">
			<a class="btn btn--secondary btn--sm" href="<?php echo esc_url( panonfc_console_url() ); ?>"><?php esc_html_e( 'Ma console', 'panonfc' ); ?></a>
			<a class="btn btn--accent btn--sm" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>"><?php esc_html_e( 'Demander un devis', 'panonfc' ); ?></a>
			<button class="burger" type="button" data-burger aria-expanded="false" aria-controls="panonfc-mobile-nav" aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'panonfc' ); ?>">
				<span></span>
			</button>
		</div>
	</div>
</header>

<div class="mobile-nav" id="panonfc-mobile-nav" data-mobile-nav aria-hidden="true">
	<div class="mobile-nav__top">
		<img src="<?php echo esc_url( panonfc_asset( 'assets/img/panonfc-logo.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<button class="mobile-nav__close" type="button" data-mobile-close aria-label="<?php esc_attr_e( 'Fermer le menu', 'panonfc' ); ?>">&times;</button>
	</div>
	<?php panonfc_mobile_menu(); ?>
	<div class="mobile-nav__actions">
		<a class="btn btn--on-navy btn--lg btn--block" href="<?php echo esc_url( panonfc_console_url() ); ?>"><?php esc_html_e( 'Ma console', 'panonfc' ); ?></a>
		<a class="btn btn--accent btn--lg btn--block" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>"><?php esc_html_e( 'Demander un devis', 'panonfc' ); ?></a>
	</div>
</div>

<main id="content" class="site-main">
