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


/**
 * Control wrapper class
 *
 * @package     OptionsPlus
 * @subpackage  Customize
 */
class Manager
{
	/**
	 * Customizer sections
	 * 
	 * @var  array
	 */
	public $sections = array();

	/**
	 * Customizer controls
	 * 
	 * @var  array
	 */
	public $controls = array();

	/**
	 * Additional scripts
	 * 
	 * @var  array
	 */
	public $scripts = array();

	/**
	 * @var  Customizer
	 */
	private static $instance;


	/**
	 * The constructor
	 */
	public static function init( $args = array() ) {
		if ( self::$instance == null ) {
			self::$instance = new Manager( $args );
			self::$instance->hooks();
		}
	}

	/**
	 * The object constructor
	 * 
	 * @param   array  $args  Construction arguments
	 */
	private function __construct( $args = array() ) {
		foreach( array_keys( get_object_vars( $this ) ) as $key ) {
			if ( isset( $args[$key] ) )
				$this->$key = $args[$key];
		}
	}

	/**
	 * Clear all default sections and controls
	 * 
	 * @param   $wp_customize  An instance of WP_Customize_Manager
	 * @return  void
	 */
	public function clear_defaults( $wp_customize ) {
		$removable_sections = apply_filters( 'op/customize_removable_sections', array() );

		foreach ( $wp_customize->controls() as $control ) {
			if ( in_array( $control->section, $removable_sections ) )
				$wp_customize->remove_control( $control->id );
		}

		foreach ( $wp_customize->sections() as $section ) {
			if ( in_array( $section->id, $removable_sections ) )
				$wp_customize->remove_section( $section->id );
		}
	}

	/**
	 * Register sections for customizer
	 *
	 * @param   $wp_customize  An instance of WP_Customize_Manager
	 * @return  void
	 */
	public function register_sections( $wp_customize ) {
		if ( empty( $this->sections ) ) {
			return;
		}

		$index    = 0;
		$defaults = array(
			'title'       => __( 'Untitled Section', 'options-plus' ),
			'description' => ''
		);

		foreach ($this->sections as $id => $params) {
			$params = array_merge($defaults, $params);
			$params['priority'] = $index++;

			$wp_customize->add_section( new \WP_Customize_Section( $wp_customize, $id, $params ) );
		}
	}

	/**
	 * Register controls for customizer
	 *
	 * @param   $wp_customize  An instance of WP_Customize_Manager
	 * @return  void
	 */
	public function register_controls( $wp_customize ) {
		if ( empty( $this->sections ) || empty( $this->controls ) ) {
			return;
		}

		// Config transport for existing controls
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$index = 0;
		foreach ($this->controls as $id => $params) {
			$default = '';
			$params['priority'] = $index++;

			if ( isset( $params['default'] ) )
				$default = $params['default'];

			if ( !isset( $params['settings'] ) )
				$params['settings'] = $id;

			if ( !isset( $params['transport'] ) )
				$params['transport'] = 'refresh';

			$class = \OptionsPlus\Options\Helper::recognize_control_class( $params['type'] );

			if ( $wp_customize->get_setting( $params['settings'] ) == null ) {
				// Register setting for this control
				$wp_customize->add_setting( $params['settings'], array(
					'default'           => $default,
					'transport'         => $params['transport'],
					'sanitize_callback' => array( $class, 'sanitize' )
				) );
			}

			$control = new Control( $wp_customize, $id, $params );

			if ( $control->is_valid() ) {
				$wp_customize->add_control( $control );
				$this->controls[$id] = $control;
			}
		}
	}

	/**
	 * [enqueue_styles description]
	 * @return [type] [description]
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'op-options-controls' );
		wp_enqueue_style( 'op-customizer' );
	}

	/**
	 * [enqueue_scripts description]
	 * @return [type] [description]
	 */
	public function enqueue_scripts() {
		global $_options_plus_fonts, $wp_scripts;

		wp_enqueue_script( 'op-options-controls' );
		wp_localize_script( 'op-options-controls', '_opFonts', $_options_plus_fonts );

		foreach ( $this->scripts as $id ) {
			wp_enqueue_script( $id );
		}
	}

	protected function hooks() {
		add_action( 'customize_register', array( $this, 'clear_defaults' ) );
		add_action( 'customize_register', array( $this, 'register_sections' ) );
		add_action( 'customize_register', array( $this, 'register_controls' ) );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
}
