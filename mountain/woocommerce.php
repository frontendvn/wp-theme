<?php
/**
 * WARNING: This file is part of the Konstruct theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();
?>
<div class="content-inner">
	<?php if ( is_active_sidebar( 'woocommerce-content-top' ) ): ?>
		<div class="woocommerce-content-top">
			<div class="woocommerce-content-top-wrap">
				<?php dynamic_sidebar( 'woocommerce-content-top' ) ?>
			</div>
		</div>
	<?php endif ?>
	
	<?php woocommerce_content() ?>
</div>