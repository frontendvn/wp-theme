<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if ( op_option( 'breadcrumb_enabled', true ) == true ): ?>

	<div id="page-breadcrumbs">
		
		<?php

			breadcrumb_trail( array(
				'separator'   => op_option( 'breadcrumb_separator', '/' ),
				'show_browse' => true,
				'labels'      => array(
					'browse'  => op_option( 'breadcrumb_prefix', __( 'You are here:', 'mountain' ) ) 
				)
			) );

		?>

	</div>

<?php endif ?>
