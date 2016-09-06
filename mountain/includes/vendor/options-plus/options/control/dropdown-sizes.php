<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Options\Control;

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();


/**
 * Select control
 */
class DropdownSizes extends \OptionsPlus\Options\Control\Dropdown
{
	public $has_custom = false;

	public function __construct( $id, $args = array() ) {
		parent::__construct( $id, $args );

		$this->choices = array_combine( get_intermediate_image_sizes(), get_intermediate_image_sizes() );

		if ( $this->has_custom )
			$this->choices['custom'] = 'custom';
	}
}
