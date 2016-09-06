<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Ignore footer widgets when it isn't available
if ( ! op_option( 'footer_widgets_enabled' ) ) return;

$widgets_layout = op_option( 'footer_widgets_layout' );

if ( ! is_array( $widgets_layout ) )
	$widgets_layout = json_decode( $widgets_layout, true );

$columns_count  = $widgets_layout['active'];
$columns_layout = $widgets_layout['layout'];

$footer_sidebars = apply_filters( 'mountain/footer_sidebars', array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' ) );
$active_sidebars = array();

foreach ( $footer_sidebars as $sidebar ) {
	if ( is_active_sidebar( $sidebar ) )
		$active_sidebars[] = $sidebar;
}

$columns = count( $active_sidebars );
$layout = $columns_layout[$columns_count];
?>
<div id="footer-widgets">
	<div class="wrapper">
		<div class="row">
			<?php for ( $index = 0; $index <= $columns_count; $index++ ): $column_width = $layout[$index]; ?>
				<div class="columns columns-<?php __esc_attr( $column_width ) ?>">
					<?php if ( isset( $active_sidebars[$index] ) ) dynamic_sidebar( $active_sidebars[$index] ) ?>
				</div>
			<?php endfor ?>
		</div>
		<!-- /.row -->
		
	</div>
	<!-- /.wrapper -->

</div>
<!-- /#page-footer -->
