<?php
/**
 * Search form.
 *
 * @package panonfc
 */
?>
<form role="search" method="get" class="row gap-14" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_html_e( 'Rechercher', 'panonfc' ); ?></label>
	<input type="search" id="s" name="s" placeholder="<?php esc_attr_e( 'Rechercher…', 'panonfc' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" style="max-width:320px">
	<button type="submit" class="btn btn--navy"><?php esc_html_e( 'Rechercher', 'panonfc' ); ?></button>
</form>
