<?php
/**
 * Centered navy CTA section.
 *
 * @package panonfc
 *
 * Args (via get_template_part third param):
 *   title        string
 *   lead         string
 *   primary      array( 'label', 'url' )
 *   secondary    array( 'label', 'url' )  (optional)
 *   reassurance  string (optional)
 *   small        bool   (smaller title)
 *   id           string (optional anchor id)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$a = wp_parse_args(
	$args ?? array(),
	array(
		'title'       => '',
		'lead'        => '',
		'primary'     => array( 'label' => 'Demander un devis', 'url' => panonfc_url( 'devis' ) ),
		'secondary'   => array( 'label' => panonfc_phone_display(), 'url' => panonfc_phone_href() ),
		'reassurance' => '',
		'small'       => false,
		'id'          => '',
	)
);
$title_class = 'cta__title' . ( $a['small'] ? ' cta__title--sm' : '' );
?>
<section class="section cta section--clip"<?php echo $a['id'] ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="arcs" aria-hidden="true">
		<span class="arc arc--center arc--w" style="width:900px;height:900px"></span>
		<span class="arc arc--center arc--o" style="width:620px;height:620px"></span>
	</div>
	<div class="container section__inner cta__inner">
		<?php if ( $a['title'] ) : ?>
			<h2 class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $a['title'] ); ?></h2>
		<?php endif; ?>
		<?php if ( $a['lead'] ) : ?>
			<p class="cta__lead"><?php echo esc_html( $a['lead'] ); ?></p>
		<?php endif; ?>
		<div class="cta__btns">
			<?php if ( ! empty( $a['primary']['label'] ) ) : ?>
				<a class="btn btn--accent btn--hero" href="<?php echo esc_url( $a['primary']['url'] ); ?>"><?php echo esc_html( $a['primary']['label'] ); ?></a>
			<?php endif; ?>
			<?php if ( ! empty( $a['secondary']['label'] ) ) : ?>
				<a class="btn btn--on-navy btn--hero" href="<?php echo esc_attr( $a['secondary']['url'] ); ?>"><?php echo esc_html( $a['secondary']['label'] ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $a['reassurance'] ) : ?>
			<div class="cta__reassurance"><?php echo esc_html( $a['reassurance'] ); ?></div>
		<?php endif; ?>
	</div>
</section>
