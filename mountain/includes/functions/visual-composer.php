<?php
/**
 * @package     WordPress
 * @subpackage  Themes
 * @author      Binh Pham Thanh <binhpham@linethemes.com>
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'Vc_Manager' ) )
	return;

vc_set_shortcodes_templates_dir( get_template_directory() . '/templates/vc' );

if ( ! function_exists( 'mountain_vs_params' ) ) {
	add_action( 'admin_init', 'mountain_vs_params' );

	/**
	 * This action will register custom parameter for visual composer
	 * shortcodes
	 * 
	 * @return  void
	 */
	function mountain_vs_params() {
		/**
		 * Row params
		 */
		vc_add_param( 'vc_row', array(
			'type'             => 'colorpicker',
			'heading'          => __( 'Font Color', 'mountain' ),
			'param_name'       => 'font_color',
			'description'      => __( 'Select font color', 'mountain' ),
			'edit_field_class' => 'vc_col-md-6 vc_column'
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'textfield',
			'heading'     => __( 'Row ID', 'mountain' ),
			'param_name'  => 'el_id',
			'description' => __( 'Enter custom ID for this row', 'mountain' ),
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'checkbox',
			'heading'     => __( 'Enable Content Width 100%', 'mountain' ),
			'param_name'  => 'width_100',
			'value'       => array(
				__( 'Yes, please', 'mountain' ) => 'yes'
			)
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'checkbox',
			'heading'     => __( 'Enable Background Parallax Effect', 'mountain' ),
			'param_name'  => 'parallax_effect',
			'group'       => __( 'Parallax', 'mountain' ),
			'value'       => array(
				__( 'Yes, please', 'mountain' ) => 'yes'
			)
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'textfield',
			'heading'     => __( 'Parallax Position Ratio', 'mountain' ),
			'param_name'  => 'parallax_speed',
			'group'       => __( 'Parallax', 'mountain' ),
			'value'       => 5
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'textfield',
			'heading'     => __( 'Parallax X Offset', 'mountain' ),
			'param_name'  => 'parallax_x',
			'group'       => __( 'Parallax', 'mountain' ),
			'value'       => 0
		) );

		vc_add_param( 'vc_row', array(
			'type'        => 'textfield',
			'heading'     => __( 'Parallax Y Offset', 'mountain' ),
			'param_name'  => 'parallax_y',
			'group'       => __( 'Parallax', 'mountain' ),
			'value'       => 0
		) );

		/**
		 * Single Image
		 */
		vc_add_param( 'vc_single_image', array(
			'type'        => 'checkbox',
			'heading'     => __( 'Enable Lightbox For This Image', 'mountain' ),
			'param_name'  => 'lightbox',
			'value'       => array(
				__( 'Yes, please', 'mountain' ) => 'yes'
			)
		) );
	}
}



if ( ! function_exists( 'mountain_vc_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'mountain_vc_scripts', 999 );

	/**
	 * Unregister visual composer styles and scripts
	 * 
	 * @return  void
	 */
	function mountain_vc_scripts() {
		wp_deregister_script( 'prettyphoto' );
		wp_deregister_style( 'prettyphoto' );
		wp_deregister_style( 'isotope' );
		wp_deregister_style( 'flexslider' );
		wp_deregister_style( 'waypoints' );
	}
}
