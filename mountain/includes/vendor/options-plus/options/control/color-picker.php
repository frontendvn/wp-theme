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
 * This class will be present an colorpicker control
 */
class ColorPicker extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'color-picker';

	/**
	 * Enqueue assets for this control
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_style( 'op-colpick' );
		wp_enqueue_script( 'op-colpick' );
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-control-color-picker-' . $this->id;
		$default = $this->default;
		?>
			<div class="options-control-inputs">
				<input type="text" id="<?php __esc_attr( $name ) ?>" name="op-options[<?php __esc_attr( $this->id ) ?>]" value="<?php __esc_attr( $this->value() ); ?>" />
				<button type="button" class="options-control-preview" style="background-color: <?php __esc_attr( $this->value() ) ?>;"></button>
				<div class="colorpicker-panel"></div>
			</div>
		<?php
	}
}
