<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Customize;

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

use \OptionsPlus\Options\Helper as OP_Options_Helper;

/**
 * Control wrapper class
 *
 * @package     OptionsPlus
 * @subpackage  Customize
 */
class Control extends \WP_Customize_Control
{
	/**
	 * Additional class for the control
	 * 
	 * @var  array
	 */
	public $class;

	/**
	 * Instance of the options control
	 * that linked to this wrapper
	 * 
	 * @var  \OptionsPlus\Control
	 */
	public $control;

	/**
	 * Override constructor method of customize control
	 * to create instance for options control
	 * 
	 * @param   WP_Customize_Manager  $wp_customize  Instance of customize manager
	 * @param   string                $id            ID of the control
	 * @param   array                 $args          Control params
	 */
	public function __construct( $wp_customize, $id, $args = array() ) {
		$params = $args;

		if ( isset( $args['type'] ) )
			unset( $args['type'] );

		parent::__construct( $wp_customize, $id, $args );

		// Create new instance for options control
		if ( isset( $params['type'] ) ) {
			$class = OP_Options_Helper::recognize_control_class( $params['type'] );

			if ( class_exists( $class ) ) {
				unset( $params['type'] );

				$this->control = new $class( $id, $params );
				$this->control->link = $this->settings['default']->id;
				$this->control->value = $this->value();
			}
		}
	}

	public function is_valid() {
		return is_a( $this->control, '\OptionsPlus\Options\Control' );
	}

	public function enqueue() {
		$this->control->enqueue();
	}

	/**
	 * Render the control
	 * 
	 * @return  void
	 */
	protected function render() {
		$this->control->render();
	}
}
