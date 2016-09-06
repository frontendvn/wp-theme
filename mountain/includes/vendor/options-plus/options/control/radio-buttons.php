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
class RadioButtons extends \OptionsPlus\Options\Control
{
	public $type = 'radio-buttons';
	public $choices = array();

	public function render_content() {
		if ( empty( $this->choices ) )
			return;

		$name = '_options-buttonset-' . $this->id;
		?>

			<div class="options-control-inputs">
				<?php foreach ( $this->choices as $value => $label ): ?>
				
					<label>
						<input type="radio" value="<?php __esc_attr( $value ) ?>" name="op-options[<?php __esc_attr( $this->id ) ?>]" <?php checked( $this->value(), $value ) ?> />
						<span><?php __esc_html( $label ) ?></span>
					</label>

				<?php endforeach ?>

			</div>

		<?php
	}
}
