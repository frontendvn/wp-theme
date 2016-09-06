<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

/**
 * Register actions
 */
add_action( 'init', __NAMESPACE__ . '\\register_assets', 5 );
add_action( 'admin_init', __NAMESPACE__ . '\\register_assets', 5 );

/**
 * Action handler to be used for register assets
 * to the system
 * 
 * @return  void
 */
function register_assets() {
	/**
	 * 3rd Library
	 */
	// Font-Awesome
	wp_register_style( 'op-fontawesome', op_directory_uri() . '/assets/3rd/font-awesome/css/font-awesome.css', array(), op_version() );
	
	// Chosen
	wp_register_style( 'op-chosen', op_directory_uri() . '/assets/3rd/chosen/chosen.min.css', array(), op_version() );
	wp_register_script( 'op-chosen', op_directory_uri() . '/assets/3rd/chosen/chosen.jquery.min.js', array( 'jquery' ), op_version(), true );
	
	// Colpick
	wp_register_style( 'op-colpick', op_directory_uri() . '/assets/3rd/colpick/css/colpick.css', array(), op_version() );
	wp_register_script( 'op-colpick', op_directory_uri() . '/assets/3rd/colpick/js/colpick.js', array( 'jquery' ), op_version(), true );

	// Serialize Form
	wp_register_script( 'op-serialize-form', op_directory_uri() . '/assets/3rd/serialize-form.js', array( 'jquery' ), op_version(), true );
	wp_register_script( 'op-populate', op_directory_uri() . '/assets/3rd/populate.js', array( 'jquery' ), op_version(), true );

	// Code mirror
	wp_register_style( 'op-codemirror', op_directory_uri() . '/assets/3rd/codemirror/codemirror.css', array(), op_version() );
	wp_register_script( 'op-codemirror', op_directory_uri() . '/assets/3rd/codemirror/codemirror.js', array( 'jquery' ), op_version(), true );

	/**
	 * Core stylesheets
	 */
	wp_register_style( 'op-options-controls', op_directory_uri() . '/assets/css/options-controls.css', array( 'op-fontawesome' ), op_version() );
	wp_register_style( 'op-customizer', op_directory_uri() . '/assets/css/customizer.css', array( 'op-fontawesome' ), op_version() );

	/**
	 * Core scripts
	 */
	wp_register_script( 'op-options-controls', op_directory_uri() . '/assets/js/options-controls.js', array(
		'jquery-ui-sortable',
		'jquery-ui-resizable',
		'jquery-ui-tabs',
		'jquery-ui-dialog',
		'op-serialize-form',
		'op-populate',
		'op-colpick',
		'op-chosen'
	), op_version(), true);
}
