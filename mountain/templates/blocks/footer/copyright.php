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
<div class="copyright">
	<div class="copyright-content">
		<?php echo wp_kses_post( op_option( 'footer_copyright' ) ) ?>
	</div>
	<!-- /.copyright-content -->
</div>
<!-- /.copyright -->
