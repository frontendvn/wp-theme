<?php if ( op_option( 'offcanvas_enabled', true ) && is_active_sidebar( 'sidebar-offcanvas' ) ): ?>
	<div id="off-canvas">
		<div class="off-canvas-wrap">
			<?php dynamic_sidebar( 'sidebar-offcanvas' ) ?>
		</div>
	</div>
<?php endif ?>
