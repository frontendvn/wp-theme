<?php
/**
 * Load the Customizer with some custom extended addons
 *
 * @package CargoPress
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

/**
 * This funtion is only called when the user is actually on the customizer page
 * @param  WP_Customize_Manager $wp_customize
 */
if ( ! function_exists( 'cargopress_customizer' ) ) {
	function cargopress_customizer( $wp_customize ) {
		// add required files
		require_once( get_template_directory() . '/inc/customizer/class-customize-base.php' );

		new CargoPress_Customizer_Base( $wp_customize );
	}
	add_action( 'customize_register', 'cargopress_customizer' );
}


/**
 * Takes care for the frontend output from the customizer and nothing else
 */
if ( ! function_exists( 'cargopress_customizer_frontend' ) && ! class_exists( 'CargoPress_Customize_Frontent' ) ) {
	function cargopress_customizer_frontend() {
		require_once( get_template_directory() . '/inc/customizer/class-customize-frontend.php' );
		$cargopress_customize_frontent = new CargoPress_Customize_Frontent();
	}
	add_action( 'init', 'cargopress_customizer_frontend' );
}
