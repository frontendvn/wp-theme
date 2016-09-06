<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

global $wp_query;

$title = '';
$subtitle = '';

if ( is_singular() ) {
	$title = get_the_title();
	$subtitle = get_post_meta( get_the_ID(), '_subtitle', true );
}
elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
	if ( is_shop() ) {
		$title = get_page( get_option( 'woocommerce_shop_page_id' ) )->post_title;
	}
	elseif ( is_tax() ) {
		$title = get_queried_object()->name;
	}
}
elseif ( is_tax() || is_category() || is_tag() ) {
	$prefix = __( 'Archive for: ', 'mountain' );

	if ( is_category() )
		$prefix = __( 'Archive for category: ', 'mountain' );
	
	if ( is_tag() )
		$prefix = __( 'Archive for tag: ', 'mountain' );
	
	$title = $prefix . get_queried_object()->name;
}
elseif ( is_year() ) {
	$title = sprintf( __( 'Archive for year: %s', 'mountain' ), get_the_time( 'Y' ) );
}
elseif ( is_month() ) {
	$title = sprintf( __( 'Archive for month: %s', 'mountain' ), get_the_time( 'F, Y' ) );
}
elseif ( is_day() || is_time() ) {
	$title = sprintf( __( 'Archive for date: %s', 'mountain' ), get_the_time( 'F d, Y' ) );
}
elseif ( is_home() ) {
	if ( get_option( 'show_on_front' ) == 'page' )
		$title = get_page( get_option( 'page_for_posts' ) )->post_title;
	else
		$title = op_option( 'blog_page_title' );
}
elseif ( is_author() ) {
	$title = sprintf( __( 'Archive for author: %s', 'mountain' ), get_user_option( 'display_name', get_query_var( 'author' ) ) );
}
elseif ( is_search() ) {
	$keyword = get_query_var( 's' );
	$post_count = $wp_query->found_posts;
	
	if ( $post_count <= 1 )
		$title = sprintf( __( '%d search result for "%s"', 'mountain' ), $post_count, $keyword );
	else
		$title = sprintf( __( '%d search results for "%s"', 'mountain' ), $post_count, $keyword );
}
elseif ( is_post_type_archive() ) {
	$post_type        = op_current_post_type();
	$post_type_object = get_post_type_object( $post_type );
	$title            = $post_type_object->labels->singular_name;

	if ( $post_type == 'postfolio' ) {
		$title = op_option( 'portfolio_page_title', $post_type_object->labels->singular_name );
	}
}
elseif ( is_404() ) {
	$title = __( '404 - Page Not Found', 'mountain' );
}
?>

<div class="page-title">
	<h2 class="title"><?php __esc_html( $title ) ?></h2>

	<?php if ( ! empty( $subtitle ) ): ?>
		<p class="subtitle"><?php __esc_html( $subtitle ) ?></p>
	<?php endif ?>
</div>
