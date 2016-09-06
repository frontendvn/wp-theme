<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Options;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();


abstract class Helper
{
	public static function recognize_control_class( $name ) {
		$segments = explode( '-', $name );
		$segments = array_map( 'ucfirst', $segments );
		
		return '\\OptionsPlus\\Options\\Control\\' . implode( '', $segments );
	}
}
