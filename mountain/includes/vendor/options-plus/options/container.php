<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Options;

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

use \OptionsPlus\Options\Helper as OP_Options_Helper;

/**
 * This class will be used as an container for options controls
 * 
 * @package     OptionsPlus
 * @subpackage  Options
 */
class Container
{
	/**
	 * @var  array
	 */
	public $sections;

	/**
	 * @var  array
	 */
	public $controls;

	/**
	 * @var  boolean
	 */
	public $show_tabs = true;

	/**
	 * @param   array  $args  Constructor arguments
	 */
	public function __construct( $args = array() ) {
		foreach( array_keys( get_object_vars( $this ) ) as $key ) {
			if ( isset( $args[$key] ) )
				$this->$key = $args[$key];
		}

		$this->sections = array();
		$this->controls = array();

		if ( isset( $args['sections'] ) && is_array( $args['sections'] ) ) {
			foreach ( $args['sections'] as $id => $params )
				$this->sections[$id] = new Section( $id, $params );
		}

		if ( isset( $args['controls'] ) && is_array( $args['controls'] ) ) {
			foreach ( $args['controls'] as $id => $params ) {
				if ( ! isset( $params['type'] ) )
					continue;

				$class = OP_Options_Helper::recognize_control_class( $params['type'] );

				if ( ! isset( $params['section'] ) ||
					 ! isset( $this->sections[$params['section']] ) ||
					 ! class_exists( $class ) )
					continue;

				$control = new $class( $id, $params );
				$section = $this->sections[$params['section']];
				$section->controls[$control->id] = $control;
			}
		}
	}

	/**
	 * Enqueue assets for the panel and children controls
	 * 
	 * @return  void
	 */
	public function enqueue() {
		global $pagenow, $_options_plus_fonts;

		wp_enqueue_style( 'op-options-controls' );
		wp_enqueue_script( 'op-options-controls' );
		wp_localize_script( 'op-options-controls', '_opFonts', $_options_plus_fonts );

		foreach ( $this->sections as $section ) {
			foreach ( $section->controls as $control ) {
				$control->enqueue();
			}
		}
	}

	/**
	 * Binding data to the controls
	 * 
	 * @param   array  $data
	 * @return  void
	 */
	public function bind( $data ) {
		foreach ( $this->sections as $section ) {
			foreach ( $section->controls as $control ) {
				if ( isset( $data[$control->id] ) )
					$control->value = $data[$control->id];
			}
		}
	}

	/**
	 * Render the panel
	 * 
	 * @return  mixed
	 */
	public function render() {
		$class = op_classes( 'options-container' );

		if ( $this->show_tabs )
			$class->add( 'options-container-tabs' );
		?>

			<div class="<?php __esc_attr( (string) $class ) ?>">
				<?php if ( $this->show_tabs ): ?>
					<ul>
						<?php foreach( $this->sections as $section ): ?>
						<li id="options-section-<?php __esc_attr( $section->id ) ?>-nav">
							<a href="#options-section-<?php __esc_attr( $section->id ) ?>"><?php __esc_html( $section->title ) ?></a>
						</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>

				<div class="options-container-content">
					<?php
						foreach( $this->sections as $section )
							$section->render()
					?>
				</div>
			</div>

		<?php
	}
}
