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
class Mountain_PageOptions extends Mountain_Base
{
	protected function __construct() {
		add_action( 'admin_init', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	public function admin_enqueue_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) && current_post_type_is( 'page' ) ) {
			wp_enqueue_script( 'mountain-page-options' );
		}
	}

	/**
	 * Register page options controls
	 * 
	 * @return  void
	 */
	public function register() {
		global $wp_registered_sidebars;

		$patterns = predefined_background_patterns();
		$options  = array();
		$sidebars = array();

		// Retrieve all registered sidebars
		foreach( $wp_registered_sidebars as $params )
			$sidebars[$params['id']] = $params['name'];

		/**
		 * General
		 */
		$options['layout_heading'] = array(
			'type' => 'heading',
			'section' => 'all',
			'title' => __( 'Sidebar Position', 'mountain' ),
			'description' => __( 'Select the position of sidebar that you wish to display.', 'mountain' )
		);

		$options['sidebar_layout'] = array(
			'type' => 'dropdown',
			'section' => 'all',
			'default' => 'default',
			'choices' => array(
				'default' => __( 'Default Option', 'mountain' ),
				'no-sidebar'   => __( 'No Sidebar', 'mountain' ),
				'sidebar-left'  => __( 'Left Sidebar', 'mountain' ),
				'sidebar-right'  => __( 'Right Sidebar', 'mountain' ),
			)
		);

		$options['sidebar_default'] = array(
			'type'    => 'dropdown-sidebars',
			'label'   => __( 'Custom Sidebar', 'mountain' ),
			'section' => 'all',
			'default' => op_option( 'sidebar_default' )
		);
		
		/**
		 * Page Title
		 */
		$options['pagetitle_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'Page Title', 'mountain' ),
			'description' => __( 'In this section you can turn on/off or modify style for the Page Title.', 'mountain' )
		);

		$options['enable_custom_page_header'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Enable Custom Page Title', 'mountain' ),
			'section' => 'all',
			'default' => false
		);

		$options['pagetitle_enabled'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Display Title Bar On This Page', 'mountain' ),
			'section' => 'all',
			'default' => op_option( 'pagetitle_enabled' )
		);

		$options['pagetitle_background'] = array(
			'type'     => 'background',
			'label'    => __( 'Page Header Background', 'mountain' ),
			'section'  => 'all',
			'patterns' => $patterns,
			'default'  => op_option( 'pagetitle_background' )
		);

		$options['pagetitle_textcolor'] = array(
			'label'   => __( 'Text Color', 'mountain' ),
			'type'    => 'color-picker',
			'section' => 'all',
			'default' => ''
		);

		$options['pagetitle_padding'] = array(
			'label'   => __( 'Padding', 'mountain' ),
			'type'    => 'dimension',
			'section' => 'all',
			'default' => 'default',
			'fields'  => array(
				'top'    => __( 'Top', 'mountain' ),
				'bottom'  => __( 'Bottom', 'mountain' )
			),
			'default' => array( 0, 0 )
		);

		/**
		 * Breadcrumbs
		 */
		$options['breadcrumb_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'Breadcrumbs', 'mountain' ),
			'description' => __( 'In this section you can turn on/off or modify style for the Breadcrumbs.', 'mountain' )
		);

		$options['breadcrumb_enabled'] = array(
			'type' => 'dropdown',
			'section' => 'all',
			'default' => 'default',
			'choices' => array(
				'default' => __( 'Default Option', 'mountain' ),
				'enable'   => __( 'Enabled', 'mountain' ),
				'disable'  => __( 'Disabled', 'mountain' ),
			)
		);

		$options['navigator_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'Navigator', 'mountain' ),
			'description' => __( 'Just select your menu that you wish assign it to the location on the theme.', 'mountain' )
		);

		// Navigator
		$menus     = wp_get_nav_menus();
		$locations = get_registered_nav_menus();

		if ( $menus ) {
			$choices = array( 'default' => __( 'Default Option', 'mountain' ) );
			foreach ( $menus as $menu ) {
				$choices[ $menu->term_id ] = wp_html_excerpt( $menu->name, 40, '&hellip;' );
			}

			$asigned_locations = op_option( 'nav_menu_locations' );

			foreach ( $locations as $location => $description ) {
				$menu_setting_id = "nav_menu_locations[{$location}]";

				$options["menu_location_{$location}"] = array(
					'label'   => $description,
					'section' => 'all',
					'type'    => 'dropdown',
					'choices' => $choices,
					'default' => 'default'
				);
			}
		}

		$options['onepage_nav_script'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Load One Page Navigator Script', 'mountain' ),
			'section' => 'all',
			'default' => false
		);

		new \OptionsPlus\Metabox\Properties( 'page-options', array(
			'label'       => __( 'Page Options', 'mountain' ),
			'post_types'  => 'page',
			'context'     => 'normal',
			'priority'    => 'high',
			'storage_key' => '_page_options',
			'show_tabs'   => false,
			'sections'    => array(
				'all'     => array( 'title' => __( 'General', 'mountain' ) )
			),
			'options'     => $options
		) );
	}
}
