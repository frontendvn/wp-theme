<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

/**
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain extends Mountain_Theme
{
	/**
	 * The theme version
	 */
	const VERSION = '1.0.0';

	/**
	 * The theme slug that will be used
	 * as text domain in the language files
	 */
	const SLUG = 'mountain';

	/**
	 * Register all supported features in this theme
	 * 
	 * @return  void
	 */
	protected function setup_theme_supports() {
		// Enable woocommerce support
		add_theme_support( 'woocommerce' );
	}

	/**
	 * Register all available sidebars
	 * 
	 * @return  void
	 */
	protected function setup_sidebars() {
		parent::setup_sidebars();

		// Remove page-title sidebar
		unregister_sidebar( 'pagetitle-widgets' );

		// Off-canvas sidebar
		register_sidebar( array(
			'name'          => __( 'Off-Canvas Sidebar', 'mountain' ),
			'id'            => 'sidebar-offcanvas',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		if ( function_exists( 'is_woocommerce' ) ) {
			// Woocommerce content-top
			register_sidebar( array(
				'name'          => __( 'WooCommerce Content Top', 'mountain' ),
				'id'            => 'woocommerce-content-top',
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
	}

	/**
	 * Register the theme menu locations
	 * 
	 * @return  void
	 */
	protected function setup_menus() {
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'mountain' )
		) );
	}

	/**
	 * Initialize the theme features
	 * 
	 * @return  void
	 */
	protected function setup_features() {
		/**
		 * Initialize theme customize
		 */
		Mountain_ThemeCustomize::instance();

		/**
		 * Initialize custom sidebars manager
		 */
		Mountain_Sidebars::instance();
		
		/**
		 * Initialize theme breadcrumb
		 */
		Mountain_Breadcrumb::instance();

		/**
		 * Initialize search feature
		 */
		Mountain_Search::instance();

		/**
		 * Initialize support for WooCommerce
		 */
		Mountain_Woocommerce::instance();

		/**
		 * Initialize support for Projects
		 */
		Mountain_Projects::instance();
	}
}
