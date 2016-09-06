<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Markup;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

/**
 * Helper class to manipulation attributes list for
 * an html element
 * 
 * @package     OptionsPlus
 * @subpackage  Markup
 */
class Attributes
{
	/**
	 * Attributes list
	 * 
	 * @var  array
	 */
	protected $attributes;

	/**
	 * Filter name
	 * 
	 * @var  string
	 */
	protected $filter;

	/**
	 * @param   array   $attributes  List of the attributes
	 * @param   string  $filter      The filter name will be applied when convert
	 *                               the attributes to a string
	 */
	public function __construct( $attributes = array(), $filter = null ) {
		$this->attributes = $attributes;
		$this->filter = $filter;

		if ( isset( $attributes['class'] ) && ! is_a( $attributes['class'], '\\OptionsPlus\\Markup\\Classes' ) ) {
			$classes = op_classes();
			$classes->add( $attributes['class'] );

			$this->attributes['class'] = $classes;
		}
	}

	/**
	 * Set the value for an attribute
	 * 
	 * @param   string  $name   Attribute name
	 * @param   string  $value  Attribute value
	 * @return  void
	 */
	public function set( $name, $value ) {
		$this->attributes[$this->format_name( $_name )] = $value;
	}

	/**
	 * Get the value for an attribute
	 * 
	 * @param   string  $name   Attribute name
	 * @return  void
	 */
	public function get( $name ) {
		$_name = $this->format_name( $name );

		if ( isset( $this->attributes[$_name] ) )
			return $this->attributes[$_name];

		return null;
	}

	/**
	 * Remove an existing attribute
	 * 
	 * @param   string  $name  Attribute name
	 * @return  void
	 */
	public function remove( $name ) {
		if ( is_array( $name ) ) {
			foreach( $name as $_name )
				$this->remove( $_name );

			return;
		}

		$name = $this->format_name( $_name );

		if ( isset( $this->attributes[$name] ) )
			unset( $this->attributes[$name] );
	}

	/**
	 * Check the name of an attribute is existed
	 * in this list
	 * 
	 * @param   string  $name  Attribute name
	 * @return  boolean
	 */
	public function exists( $name ) {
		return isset( $this->attributes[$this->format_name( $_name )] );
	}

	/**
	 * Build this list to string
	 * 
	 * @return  string
	 */
	public function __toString() {
		$attributes = $this->build_string();

		if ( ! empty( $attributes ) )
			$attributes = sprintf( ' %s', $attributes );

		return $attributes;
	}

	/**
	 * Convert a string to valid with rule of html attribute name
	 * 
	 * @param   string  $name  String to be converted
	 * @return  string
	 */
	protected function format_name( $name ) {
		$_name = str_replace( ' ', '-', strtolower( $name ) );
		$_name = trim( $_name, '-' );

		return $_name;
	}

	/**
	 * Build this attribute list to html string
	 * 
	 * @return  string
	 */
	protected function build_string() {
		if ( ! empty( $this->filter ) )
			do_action( $this->filter, $this );

		$buffer = array();
		$attributes = $this->attributes;

		// Loop through each attribute to convert it into string
		foreach( $this->attributes as $name => $value ) {
			$escaped_value = trim( esc_attr( $value ) );

			if ( empty( $escaped_value ) )
				continue;
			
			$buffer[] = sprintf( '%s="%s"', $name, esc_attr( $value ) );
		}

		return implode( ' ', $buffer );
	}
}
