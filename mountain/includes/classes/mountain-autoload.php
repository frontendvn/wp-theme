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
 * Theme classes autoloader
 *
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain_AutoLoad
{
	private static $prefixes = array();
	private static $classes = array();
	
	/**
	 * Register the classes autoloader
	 * 
	 * @return  void
	 */
	public static function register() {
		spl_autoload_register( 'Mountain_AutoLoad::autoload' );
	}

	/**
	 * Add an class prefix that associated with the path
	 * 
	 * @param   string  $prefix    Class prefix
	 * @param   string  $path      Path to directory
	 * 
	 * @return  void
	 */
	public static function map( $prefix, $path ) {
		self::$prefixes[ self::_normalize_name( $prefix ) ] = $path;
	}

	/**
	 * Map an class to the file
	 *
	 * @param   string  $class  Class name to be mapped
	 * @param   string  $path   Path to the class file
	 * 
	 * @return  void
	 */
	public static function map_class( $class, $path ) {
		self::$classes[ self::_normalize_name( $class ) ] = $path;
	}

	/**
	 * Autoload classes
	 * 
	 * @param   string  $classname  Class name that will be loaded
	 * @return  void
	 */
	public static function autoload( $classname ) {
		// Normalize the classname
		$normalized_name = self::_normalize_name( $classname );

		// Load the mapped class
		if ( isset( self::$classes[ $normalized_name ] ) ) {
			require_once self::$classes[ $normalized_name ];
		}

		// Load class that mapped by the prefix
		else {
			uksort( self::$prefixes, function( $a, $b ) {
				return $a != $b ? strlen( $a ) > strlen( $b ) ? -1 : 1 : 0;
			} );

			foreach ( self::$prefixes as $prefix => $path ) {
				// If class name was started with the prefix
				if ( strpos( $normalized_name, $prefix ) === 0 ) {
					$classfile = str_replace( '_', '-', $classname ) . '.php';
					$classfile = preg_replace( '/([a-z])([A-Z])/', '\\1-\\2', $classfile );
					$classfile = strtolower( $classfile );
					$classfile = trim( $classfile, '-' );
					
					if ( is_file( $path . $classfile ) ) {
						require_once $path . $classfile;
						break;
					}
				}
			}
		}
	}

	/**
	 * Helper method to normalize the classname
	 * 
	 * @param   string  $classname  The class name to be normalized
	 * @return  string
	 */
	private static function _normalize_name( $classname ) {
		$normalized_name = trim( $classname, '\\' );
		$normalized_name = strtolower( $classname );

		return $normalized_name;
	}
}

/**
 * Initialize classes loader
 */
Mountain_AutoLoad::register();
