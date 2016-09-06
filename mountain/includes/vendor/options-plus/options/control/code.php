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
class Code extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'code';

	/**
	 * Code editor highlight mode
	 * 
	 * @var  string
	 */
	public $mode = 'htmlmixed';

	/**
	 * Enqueue assets for this control
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_style( 'op-codemirror' );
		wp_enqueue_script( 'op-codemirror' );
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-control-code-' . $this->id;
		?>
			<div class="options-control-inputs">
				<textarea name="op-options[<?php __esc_attr( $this->id ) ?>]" id="<?php __esc_attr( $name ) ?>" data-mode="<?php __esc_attr( $this->mode ) ?>"><?php __esc_html( $this->value() ) ?></textarea>
			</div>
		<?php
	}
}
