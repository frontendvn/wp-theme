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
 * Select control
 */
class Dropdown extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'dropdown';

	public $choices = array();

	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		if ( empty( $this->choices ) || ( ! is_array( $this->choices ) && ! is_callable( $this->choices ) ) )
			return;

		if ( is_callable( $this->choices ) )
			$choices = call_user_func( $this->choices );
		else
			$choices = $this->choices;

		$name = '_options-dropdown-' . $this->id;
		?>
		<div class="options-control-inputs">
			<label>
				<span class="options-control-preview"></span>
				<select name="op-options[<?php __esc_attr( $this->id ) ?>]" id="<?php __esc_attr( $name ) ?>">
					<?php
					foreach ( $choices as $value => $label ):
						if ( is_array( $label ) && isset( $label['label'] ) && isset( $label['items'] ) && is_array( $label['items'] ) ): ?>
							<optgroup label="<?php __esc_attr( $label['label'] ) ?>">';

							<?php foreach( $label['items'] as $item_value => $item_text ): ?>

								<option value="<?php __esc_attr( $item_value ) ?>"<?php selected( $this->value(), $item_value ) ?>><?php __esc_html( $item_text ) ?></option>
								
							<?php endforeach ?>

							</optgroup>

							<?php continue; ?>
						<?php endif; ?>
						
						<option value="<?php __esc_attr( $value ) ?>" <?php selected( $this->value(), $value ) ?>><?php __esc_html( $label ) ?></option>
					<?php endforeach ?>
				</select>
			</label>
		</div><?php
	}
}
