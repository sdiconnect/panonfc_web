<?php
/**
 * Default page template (for pages that don't use a custom template).
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
					<h1><?php the_title(); ?></h1>
				</header>
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
		</div>
	</section>
	<?php
endwhile;

get_footer();
