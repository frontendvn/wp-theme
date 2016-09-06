<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Ignore output sidebar when it is turn off
if ( op_option( 'sidebar_layout' ) == 'no-sidebar' || ! is_active_sidebar( op_option( 'sidebar_default' ) ) ) return;
?>
<div class="sidebars">
	<div class="sidebars-wrap">
		<aside class="sidebar">
			<?php dynamic_sidebar( op_option( 'sidebar_default' ) ) ?>
		</aside>
	</div>
</div>
