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
 * The class for template wrapper
 *
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
final class Mountain_Wrapper extends Mountain_Base
{
	// Stores the full path to the main template file
	public static $main_template;

	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	public static $base;

	public function __construct( $template = 'templates/layout.php' ) {
		$this->slug = basename( $template, '.php' );
		$this->templates = array( $template );

		array_unshift( $this->templates, sprintf( 'templates/layout-%s.php', op_option( 'header_style' ) ) );

		if ( self::$base ) {
			$str = substr( $template, 0, -4 );
			array_unshift( $this->templates, sprintf( $str . '-%s.php', self::$base ) );
			array_unshift( $this->templates, sprintf( $str . '-%s-%s.php', self::$base, op_option( 'header_style' ) ) );
		}
	}

	public function __toString() {
		$this->templates = apply_filters( 'mountain/wrapper', $this->templates, $this->slug );
		return locate_template( $this->templates );
	}

	public static function wrap( $main ) {
		self::$main_template = $main;
		self::$base = basename( self::$main_template, '.php' );
		
		if ( self::$base === 'index' )
			self::$base = false;
		
		return new self();
	}
}

/**
 * This helper function will return the path
 * to main template file
 * 
 * @return  string
 */
function mountain_template_path() {
	return Mountain_Wrapper::$main_template;
}
