<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();
?>
<div class="content-inner">
	<div class="heading-404">
		<img src="<?php __esc_attr( trailingslashit( get_template_directory_uri() ) ) ?>assets/img/404.png" alt="404" />
		<?php // _e( '404', 'mountain' ) ?>
	</div>
	<div class="content-404">
		<h3><?php _e( 'Looks Like Something Went Wrong!', 'mountain' ) ?></h3>
		<p><?php _e( 'The page you were looking for is not here. Maybe you want to perform a search?', 'mountain' ); ?></p>

		<?php get_search_form(); ?>

	</div>
</div>
<!-- /.content-inner -->
