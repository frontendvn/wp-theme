<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme's demo-import settings
 *
 * @filter us_config_demo-import
 */
global $us_template_directory, $us_template_directory_uri;
return array(
	'main' => array(
		'title' => 'Main Demo',
		'image' => $us_template_directory_uri . '/demo-import/main/preview.jpg',
		'preview_url' => 'http://impreza.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/main/content.xml',
		'options' => $us_template_directory . '/demo-import/main/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Header Menu',
			'us_footer_menu' => 'Footer Menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/main/slider-home1.zip',
			$us_template_directory . '/demo-import/main/slider-home2.zip',
			$us_template_directory . '/demo-import/main/slider-home3.zip',
			$us_template_directory . '/demo-import/main/slider-portfolio.zip',
		),
	),
	'onepage' => array(
		'title' => 'One Page Demo',
		'image' => $us_template_directory_uri . '/demo-import/onepage/preview.jpg',
		'preview_url' => 'http://impreza2.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/onepage/content.xml',
		'options' => $us_template_directory . '/demo-import/onepage/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Header Menu',
			'us_footer_menu' => '',
		),
		'front_page' => 'Home',
	),
	'creative' => array(
		'title' => 'Creative Demo',
		'image' => $us_template_directory_uri . '/demo-import/creative/preview.jpg',
		'preview_url' => 'http://impreza3.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/creative/content.xml',
		'options' => $us_template_directory . '/demo-import/creative/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Header Menu',
			'us_footer_menu' => 'Footer Menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/creative/slider-main.zip',
		),
	),
	'portfolio' => array(
		'title' => 'Portfolio Demo',
		'image' => $us_template_directory_uri . '/demo-import/portfolio/preview.jpg',
		'preview_url' => 'http://impreza4.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/portfolio/content.xml',
		'options' => $us_template_directory . '/demo-import/portfolio/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Main',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/portfolio/slider-home.zip',
			$us_template_directory . '/demo-import/portfolio/slider-instagram.zip',
			$us_template_directory . '/demo-import/portfolio/slider-portfolio-1.zip',
			$us_template_directory . '/demo-import/portfolio/slider-portfolio-2.zip',
			$us_template_directory . '/demo-import/portfolio/slider-portfolio-3.zip',
			$us_template_directory . '/demo-import/portfolio/slider-portfolio-4.zip',
		),
	),
	'blog' => array(
		'title' => 'Blog Demo',
		'image' => $us_template_directory_uri . '/demo-import/blog/preview.jpg',
		'preview_url' => 'http://impreza5.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/blog/content.xml',
		'options' => $us_template_directory . '/demo-import/blog/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Header Menu',
			'us_footer_menu' => 'Footer Menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/blog/slider-popular-posts.zip',
			$us_template_directory . '/demo-import/blog/slider-posts-carousel.zip',
			$us_template_directory . '/demo-import/blog/slider-recent_posts.zip',
			$us_template_directory . '/demo-import/blog/slider-recent-posts-2.zip',
		),
	),
	'restaurant' => array(
		'title' => 'Restaurant Demo',
		'image' => $us_template_directory_uri . '/demo-import/restaurant/preview.jpg',
		'preview_url' => 'http://impreza6.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/restaurant/content.xml',
		'options' => $us_template_directory . '/demo-import/restaurant/theme-options.json',
		'nav_menu_locations' => array(
			'us_main_menu' => 'Main',
			'us_footer_menu' => 'Main',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/restaurant/slider-home.zip',
		),
	),
);
