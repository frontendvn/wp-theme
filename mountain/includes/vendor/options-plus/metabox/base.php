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

/**
 * Metabox base class
 *
 * @package     OptionsPlus
 * @subpackage  Metabox
 */
abstract class Base
{
	/**
	 * The HTML ID of the box
	 * 
	 * @var  string
	 */
	public $id;

	/**
	 * Label for the box
	 * 
	 * @var  string
	 */
	public $label;

	/**
	 * The type of Write screen on which to show the edit screen section
	 * 
	 * @var  array
	 */
	public $post_types;

	/**
	 * The part of the page where the metabox should be shown
	 * 
	 * @var  string
	 */
	public $context;

	/**
	 * The priority within the context where the boxes should show
	 * 
	 * @var  string
	 */
	public $priority;

	/**
	 * The meta key that will be used to store metabox data
	 * 
	 * @var  string
	 */
	public $storage_key;

	/**
	 * The data stored in the database
	 * 
	 * @var  array
	 */
	public $data;

	/**
	 * Box constructor
	 *
	 * @param  string  $id    Box ID
	 * @param  array   $args  Box parameters
	 */
	public function __construct( $id, $args = array() ) {
		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
			if ( isset( $args[ $key ] ) )
				$this->$key = $args[ $key ];
		}

		$this->id = $id;
		$this->setup();
		$this->hooks();
	}

	/**
	 * Register metabox to the system
	 * 
	 * @return  void
	 */
	public function register() {
		$callback = array( $this, 'display' );

		add_meta_box(
			$this->id,
			$this->label,
			$callback,
			$this->post_types,
			$this->context,
			$this->priority
		);
	}

	/**
	 * Enqueue assets files for the box
	 * 
	 * @return  void
	 */
	public function enqueue() {
	}

	/**
	 * Save metabox values to database
	 *
	 * @param   int  $post_id  The post ID
	 * @return  void
	 */
	public function save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
		
		$post_types = is_array( $this->post_types )
			? $this->post_types
			: array( $this->post_types );

		if ( ! in_array( op_current_post_type(), $post_types ) )
			return;

		if ( isset( $_REQUEST ) && isset( $_REQUEST['op-options'] ) ) {
			$data = stripslashes_deep( $_REQUEST['op-options'] );
			$data = $this->sanitize( $data );

			update_post_meta( $post_id, $this->storage_key, $data );
		}
	}

	/**
	 * Apply hooks for the metabox
	 * 
	 * @return  void
	 */
	protected function hooks() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Sanitize the input data
	 * 
	 * @param   array  $data  User input data to be sanitized
	 * @return  array
	 */
	protected function sanitize( $data ) {
		return $data;
	}

	/**
	 * Render the metabox and show it
	 * 
	 * @return  void
	 */
	abstract public function display( $post );

	/**
	 * Setup the box
	 * 
	 * @return  void
	 */
	abstract protected function setup();
}
