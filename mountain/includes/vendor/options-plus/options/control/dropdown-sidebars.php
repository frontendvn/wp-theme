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
class DropdownSidebars extends \OptionsPlus\Options\Control\Dropdown
{
	public $type = 'dropdown';
	
	public function __construct( $id, $args = array() ) {
		parent::__construct( $id, $args );

		$this->choices = array( $this, 'sidebars' );
	}

	public function sidebars() {
		global $wp_registered_sidebars;

		$sidebars = array();
		$sidebars['0'] = __( '&mdash; Select &mdash;', 'options-plus' );

		foreach ( $wp_registered_sidebars as $sidebar ) {
			if ( $sidebar['id'] == 'wp_inactive_widgets' || strpos( $sidebar['id'], 'orphaned_widgets' ) !== false )
				continue;
			
			$sidebars[$sidebar['id']] = $sidebar['name'];
		}

		return $sidebars;
	}
}
