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
 * This class will be present an dimension control
 */
class Dimension extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'dimension';

	public $fields = array();
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-dimension-' . $this->id;
		$values = $this->value();
		$fields = $this->fields;

		if ( ! is_array( $values ) )
			$values = explode( ',', $this->value() );

		$field_index = 0;
		?>
		<div class="options-control-inputs">
			<?php foreach ( $fields as $id => $title ): ?>
				<label for="<?php __esc_attr( $name . '_' . $id ) ?>">
					<span><?php __esc_html( $title ) ?></span>
					<input type="text" name="op-options[<?php __esc_attr( $this->id ) ?>][]"
						   value="<?php __esc_attr( $values[$field_index++] ) ?>"
						   id="<?php __esc_attr( $name . '_' . $id ) ?>" />
				</label>
			<?php endforeach ?>
		</div>
		<?php
	}
}
