<?php
/**
 * Search form
 *
 * @package CargoPress
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _e( 'Search for:', 'cargopress-pt' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php _e( 'Search ...', 'cargopress-pt' ); ?>" value="" name="s">
	</label>
	<button type="submit" class="search-submit"><i class="fa  fa-lg  fa-search"></i></button>
</form>