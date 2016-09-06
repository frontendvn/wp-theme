<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/assets.php';
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/fonts.php';

/**
 * Register auto loader
 */
spl_autoload_register( __NAMESPACE__ . '\Loader::load' );

/**
 * Class loader for OptionsPlus library
 *
 * @package   OptionsPlus
 * @category  Library
 */
final class Loader
{
	public static function load( $class ) {
		$class = trim( $class, '\\' );

		// Has namespace
		if ( strpos( $class, 'OptionsPlus\\' ) === 0 ) {
			$segments  = array_slice( explode( '\\', $class ), 1 );
			$classname = array_pop( $segments );
			$filename  = preg_replace( '/([A-Z])/', '-\\1', $classname );
			$filename  = trim( strtolower( $filename ), '-' );
			$path      = strtolower( implode( '/', $segments ) );
			$file      = op_directory_path() . '/' . $path . '/' . $filename . '.php';

			if ( is_file( $file ) ) {
				require_once $file;
			}
		}
	}
}
