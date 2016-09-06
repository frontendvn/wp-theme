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
 * Radio buttons control
 */
class Checkboxes extends \OptionsPlus\Options\Control
{
	public $type = 'checkboxes';
	public $choices = array();

	public function render_content() {
		if ( is_callable( $this->choices ) )
			$choices = call_user_func( $this->choices );
		else
			$choices = $this->choices;

		$name = '_options-checkboxes-' . $this->id;
		?>

			<div class="options-control-inputs">
				<?php foreach ( $choices as $value => $label ): ?>

					<label>
						<input type="checkbox" value="<?php __esc_attr( $value ) ?>" name="op-options[<?php __esc_attr( $this->id ) ?>][]" <?php checked( in_array( $value, $this->value() ) ) ?> />
						<span><?php __esc_html( $label ) ?></span>
					</label>

				<?php endforeach ?>

			</div>
		
		<?php
	}

	protected function before_render() {
		if ( is_callable( $this->choices ) )
			$this->choices = call_user_func( $this->choices );

		if ( empty( $this->choices ) || ! is_array( $this->choices ) )
			$this->_prevent_render = true;
	}
}
