<?php
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove results count & products sort
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop_item', 'mountain_before_shop_loop_item' );
add_action( 'mountain_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'mountain_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );


function mountain_before_shop_loop_item() {
  echo '<div class="product-thumbnail">';
  
  do_action( 'mountain_before_shop_loop_item' );
  
  echo '</div>';
  echo '<div class="product-info">
  			<div class="product-info-wrap">';
  
}

add_action( 'woocommerce_after_shop_loop_item', function() {
  echo '</div></div>';
}, 99 );

add_action( 'woocommerce_after_single_product_summary', function() {
	if ( op_option( 'woocommerce_product_navigator_enabled' ) ) {
		get_template_part( 'templates/blocks/post-navigator' );
	}
}, 15 );
