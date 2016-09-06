<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Markup;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

/**
 * This class will be used to store a css classes
 * for an html element
 *
 * @package     OptionsPlus
 * @subpackage  Markup
 */
class Classes
{
	/**
	 * List of classes that will be
	 * handled
	 * 
	 * @var  array
	 */
	protected $classes;

	/**
	 * Filter name
	 * 
	 * @var  string
	 */
	protected $filter;

	/**
	 * @param   array   $classes  List of the classes
	 * @param   string  $filter   The filter name will be applied when convert
	 *                            the classes to a string
	 */
	public function __construct( $classes = array(), $filter = null ) {
		$this->add( $classes );
		$this->filter = $filter;
	}

	/**
	 * Add the class name
	 * 
	 * @param   string  $class  Class name
	 * @return  void
	 */
	public function add( $class ) {
		if ( is_array( $class ) ) {
			foreach( $class as $_class )
				$this->add( $_class );

			return;
		}
		
		if ( strpos( $class, ' ' ) !== false ) {
			return $this->add( explode( ' ', $class ) );
		}

		$class = $this->format_class( $class );
		$this->classes[$class] = $class;
	}

	/**
	 * Remove an existing class name
	 * 
	 * @param   string  $class  Class name
	 * @return  void
	 */
	public function remove( $class ) {
		if ( is_array( $class ) ) {
			foreach( $class as $_class )
				$this->remove( $_class );

			return;
		}
		elseif ( strpos( $class, ' ' ) !== false ) {
			return $this->remove( explode( ' ', $class ) );
		}

		$class = $this->format_class( $class );

		if ( isset( $this->classes[$class] ) )
			unset( $this->classes[$class] );
	}

	/**
	 * Check the class name is existed in this list
	 * 
	 * @param   string  $class  Class name
	 * @return  boolean
	 */
	public function exists( $class ) {
		return isset( $this->classes[$this->format_class( $class )] );
	}

	/**
	 * Convert the class list to a string
	 * 
	 * @return  string
	 */
	public function __toString() {
		if ( empty( $this->classes ) )
			$this->classes = array();
		
		if ( ! empty( $this->filter ) )
			do_action( $this->filter, $this );

		return implode( ' ', array_values( $this->classes ) );
	}

	/**
	 * Helper method to format class name to ensure
	 * it is valid with the rule of html class name
	 * 
	 * @param   string  $class  Class name
	 * @return  void
	 */
	protected function format_class( $class ) {
		return trim( $class );
	}
}
