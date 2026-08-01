<?php
/**
 * Fallback index — blog listing.
 *
 * @package panonfc
 */

get_header();
?>
<section class="section section--white">
	<div class="container section__inner">
		<?php if ( have_posts() ) : ?>
			<header class="measure mb-11">
				<span class="eyebrow"><?php is_home() ? esc_html_e( 'Le blog', 'panonfc' ) : esc_html_e( 'Résultats', 'panonfc' ); ?></span>
				<h1 class="h2"><?php echo esc_html( get_the_archive_title() ? wp_strip_all_tags( get_the_archive_title() ) : get_bloginfo( 'name' ) ); ?></h1>
			</header>
			<div class="grid cols-3 grid--gap-lg">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'product-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'panonfc-card', array( 'class' => 'product-card__img', 'loading' => 'lazy' ) ); ?></a>
						<?php endif; ?>
						<div class="product-card__body">
							<div class="product-card__cat"><?php echo esc_html( get_the_date() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="product-card__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<a class="arrow-link" style="color:var(--pano-navy)" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Lire la suite', 'panonfc' ); ?> →</a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<div class="pagination"><?php echo wp_kses_post( paginate_links() ); ?></div>
		<?php else : ?>
			<div class="measure">
				<h1 class="h2"><?php esc_html_e( 'Rien à afficher pour le moment', 'panonfc' ); ?></h1>
				<p class="muted mt-4"><?php esc_html_e( 'Aucun contenu ne correspond à votre recherche.', 'panonfc' ); ?></p>
				<a class="btn btn--accent mt-6" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Retour à l\'accueil', 'panonfc' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
