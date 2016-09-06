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
abstract class Mountain_Base
{
	/**
	 * This property will hold all instances
	 * of sub-classes.
	 * 
	 * @var  array
	 */
	private static $instances = array();

	/**
	 * Create new instance of sub-class if it's doesn't created before and
	 * store it to memory. Return the stored instance if it is created
	 * 
	 * @return  mixed
	 */
	public static function instance() {
		$class = get_called_class();

		if ( ! isset( self::$instances[ $class ] ) )
			self::$instances[ $class ] = new $class();

		return self::$instances[ $class ];
	}
}
