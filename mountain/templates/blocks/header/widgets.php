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
<div class="header-widgets">
	<?php if ( is_active_sidebar( 'header-widgets' ) ): ?>
		<?php dynamic_sidebar('header-widgets' ) ?>
	<?php endif ?>
</div>
