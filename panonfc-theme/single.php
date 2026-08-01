<?php
/**
 * Single post.
 *
 * @package panonfc
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="section section--white">
		<div class="container section__inner">
			<article <?php post_class( 'entry' ); ?>>
				<header class="mb-8">
					<div class="entry__meta">
					<?php
					echo esc_html( get_the_date() );
					$cats = get_the_category_list( ', ' );
					if ( $cats ) {
						echo ' · ' . wp_kses_post( $cats );
					}
					?>
				</div>
					<h1><?php the_title(); ?></h1>
				</header>
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="mb-8"><?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?></figure>
				<?php endif; ?>
				<div class="entry__content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before' => '<div class="pagination">',
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</article>
			<?php
			if ( comments_open() || get_comments_number() ) {
				echo '<div class="entry mt-6">';
				comments_template();
				echo '</div>';
			}
			?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
