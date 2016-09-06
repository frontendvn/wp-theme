<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if ( ! op_option( 'header_cart_menu', true ) &&
	 ! op_option( 'header_searchbox', true ) &&
	 ! op_option( 'header_show_offcanvas', true ) )
	return;
?>
<ul class="menu menu-extra">
	<?php if ( class_exists( 'WC_Widget_Cart' ) && op_option( 'header_cart_menu', true ) ): ?>
		<li class="shopping-cart">
			<a href="<?php __esc_url( \WooCommerce::instance()->cart->get_cart_url() ) ?>">
				<i class="fa fa-shopping-cart"></i>

				<?php if ( $items_count = \WooCommerce::instance()->cart->get_cart_contents_count() ): ?>
					<span class="shopping-cart-items-count"><?php __esc_html( $items_count ) ?></span>
				<?php else: ?>
					<span class="shopping-cart-items-count no-items"></span>
				<?php endif ?>
			</a>
			<div class="submenu">
				<div class="widget_shopping_cart_content">
					<?php woocommerce_mini_cart() ?>
				</div>
			</div>
		</li>
	<?php endif ?>

	<?php if ( op_option( 'header_searchbox', true ) ): ?>
		<li class="search-box">
			<a href="#"><i class="fa fa-search"></i></a>
			<div class="submenu"><?php the_widget( 'WP_Widget_Search' ) ?></div>
		</li>
	<?php endif ?>

	<?php if ( op_option( 'offcanvas_enabled', true ) && is_active_sidebar( 'sidebar-offcanvas' ) ): ?>
		<li class="off-canvas">
			<a href="#"><i class="fa fa-bars"></i></a>
		</li>
	<?php endif ?>
</ul>
