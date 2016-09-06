<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Metabox;

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

use \OptionsPlus\Options\Container as OP_Options_Container,
	\OptionsPlus\Options\Control\Switcher as OP_Options_Control_Switcher;

class Properties extends Base
{
	/**
	 * Options container
	 * 
	 * @var  \OptionsPlus\Options\Container
	 */
	public $container;

	/**
	 * List of options group
	 * 
	 * @var  array
	 */
	public $sections;

	/**
	 * Options controls
	 * 
	 * @var  array
	 */
	public $options;

	/**
	 * Additional scripts for this box
	 * 
	 * @var  array
	 */
	public $scripts = array();

	/**
	 * Flag to show/hide options tabs
	 * 
	 * @var  boolean
	 */
	public $show_tabs = true;

	/**
	 * Enqueue the needed assets
	 * 
	 * @return  void
	 */
	public function enqueue() {
		$this->container->enqueue();

		foreach ( $this->scripts as $id ) {
			wp_enqueue_script( $id );
		}
	}

	protected function sanitize( $data ) {
		foreach( $this->container->sections as $section ) {
			foreach( $section->controls as $id => $control )
				if ( $control instanceOf OP_Options_Control_Switcher )
					$data[$id] = isset( $data[$id] );
		}

		return $data;
	}


	public function setup() {
		$this->container = new OP_Options_Container( array(
			'sections'  => $this->sections,
			'controls'  => $this->options,
			'show_tabs' => $this->show_tabs
		) );
	}

	public function display( $post ) {
		$this->container->bind( get_post_meta( $post->ID, $this->storage_key, true ) );
		$this->container->render( array( 'output' => true ) );

		// Render nonce field
		// wp_nonce_field( __FILE__, '_op_properties_box' );
	}
}
