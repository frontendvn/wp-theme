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
 * Return an array that declaration theme customize sections
 */
return array(
	'general'    => array(
		'title' => __( 'General', 'mountain' )
	),

	// Header group
	'header_brand' => array(
		'title'       => __( 'Logo', 'mountain' ),
		'description' => __( 'In this section You can upload your own custom logo, change the way your logo can be displayed', 'mountain' ),
		'panel'       => 'header'
	),
	'header_nav' => array(
		'title'       => __( 'Navigation', 'mountain' ),
		'description' => __( 'Manage the menu that will be assigned to the location on the theme', 'mountain' ),
		'panel'       => 'header'
	),
	'header_offcanvas' => array(
		'title' => __( 'Off-Canvas', 'mountain' ),
		'description' => __( 'Change the style for the off-canvas area', 'mountain' ),
		'panel' => 'header'
	),
	'header_misc' => array(
		'title'       => __( 'Misc', 'mountain' ),
		'description' => __( '', 'mountain' ),
		'panel'       => 'header'
	),

	// 'header'     => array( 'title' => __( 'Header', 'mountain' ) ),
	
	'footer'     => array( 'title' => __( 'Footer', 'mountain' ) ),
	'layout'     => array( 'title' => __( 'Layout & Styles', 'mountain' ) ),
	'typography' => array( 'title' => __( 'Typography', 'mountain' ) ),
	'blog'       => array( 'title' => __( 'Blog', 'mountain' ) )
);
