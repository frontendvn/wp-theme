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
 * This class will be present an text control
 */
class Textarea extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'textarea';
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-textarea-' . $this->id;
		?>
		<div class="options-control-inputs">
			<textarea name="op-options[<?php __esc_attr( $this->id ) ?>]" id="<?php __esc_attr( $name ) ?>"><?php __esc_html( $this->value() ) ?></textarea>
		</div>
		<?php
	}
}
