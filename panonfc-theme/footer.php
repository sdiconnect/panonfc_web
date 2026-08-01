<?php
/**
 * Footer: 4-column navy footer + legal bar.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main><!-- #content -->

<footer class="site-footer">
	<div class="container site-footer__inner">
		<div class="site-footer__grid">
			<div class="site-footer__brand">
				<img src="<?php echo esc_url( panonfc_asset( 'assets/img/panonfc-square.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<p class="site-footer__pitch"><?php echo esc_html( apply_filters( 'panonfc_footer_pitch', 'Panneaux immobiliers et de chantier connectés. Fabrication Akylux 5 mm, impression UV, identifiant unique et console de gestion incluse.' ) ); ?></p>
			</div>

			<div class="site-footer__col">
				<div class="site-footer__coltitle"><?php esc_html_e( 'Produits', 'panonfc' ); ?></div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-products',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => 'panonfc_footer_products_fallback',
					)
				);
				?>
			</div>

			<div class="site-footer__col">
				<div class="site-footer__coltitle"><?php esc_html_e( 'Ressources', 'panonfc' ); ?></div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-resources',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => 'panonfc_footer_resources_fallback',
					)
				);
				?>
			</div>

			<div class="site-footer__col">
				<div class="site-footer__coltitle"><?php esc_html_e( 'Contact', 'panonfc' ); ?></div>
				<ul>
					<li><a class="is-strong" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a></li>
					<li><?php echo wp_kses_post( apply_filters( 'panonfc_footer_address', '60 rue François 1er<br>75008 Paris' ) ); ?></li>
					<li><a href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>"><?php esc_html_e( 'Formulaire de contact', 'panonfc' ); ?></a></li>
				</ul>
			</div>
		</div>

		<div class="site-footer__bottom">
			<div><?php esc_html_e( 'Une solution imaginée et développée par', 'panonfc' ); ?> <a class="brandlink" href="https://sdi-connect.com/" rel="noopener">Solutions Digitales Intégrées</a></div>
			<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Liens légaux', 'panonfc' ); ?>">
				<a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>"><?php esc_html_e( 'Mentions légales', 'panonfc' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>"><?php esc_html_e( 'Confidentialité', 'panonfc' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/cookies/' ) ); ?>"><?php esc_html_e( 'Cookies', 'panonfc' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/cgv/' ) ); ?>"><?php esc_html_e( 'CGV', 'panonfc' ); ?></a>
			</nav>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
