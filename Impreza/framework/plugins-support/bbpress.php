<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * bbPress Support
 *
 * @link https://bbpress.org/
 */

if ( ! class_exists( 'bbPress' ) ) {
	return;
}

add_action( 'wp_enqueue_scripts', 'us_bbpress_enqueue_styles' );
function us_bbpress_enqueue_styles( $styles ) {
	global $us_template_directory_uri;
	wp_dequeue_style( 'bbp-default' );
	wp_enqueue_style( 'us-bbpress', $us_template_directory_uri . '/css/us.bbpress.css', array(), US_THEMEVERSION, 'all' );
}

// Add own sidebar
add_filter( 'us_config_sidebars', 'us_bbpress_config_sidebars' );
function us_bbpress_config_sidebars( $sidebars ) {
	$sidebars['bbpress_sidebar'] = array(
		'name' => __( 'bbPress Sidebar', 'us' ),
		'id' => 'bbpress_sidebar',
		'description' => __( 'This sidebar is used for forum pages.', 'us' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	);

	return $sidebars;
}

// Remove Forum summaries
add_filter( 'bbp_get_single_forum_description', '__return_false', 10, 2 );
add_filter( 'bbp_get_single_topic_description', '__return_false', 10, 2 );
