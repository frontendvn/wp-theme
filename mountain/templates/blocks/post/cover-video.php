<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

global $_post_options;

if ( ! post_password_required() && ! is_attachment() && ! empty( $_post_options['post_video'] ) ) {
	?>
		
		<div class="entry-cover fitVids">
			<?php echo wp_oembed_get( $_post_options['post_video'] ); ?>
		</div>

	<?php
}
