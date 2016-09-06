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
class Spinner extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'spinner';

	/**
	 * Min value
	 * 
	 * @var  integer
	 */
	public $min = 1;

	/**
	 * Max value
	 * 
	 * @var  integer
	 */
	public $max = null;

	/**
	 * Enqueue control dependencies
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-spinner' );
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-spinner-' . $this->id;
		?>
			
			<div class="options-control-inputs">
				<input type="text" name="op-options[<?php __esc_attr( $this->id ) ?>]"
					id="<?php __esc_attr( $name ) ?>"
					value="<?php __esc_attr( $this->value() ) ?>"
					data-min="<?php echo intval( $this->min ) ?>"

					<?php if ( $this->max != null ): ?>
						data-max="<?php echo intval( $this->max ) ?>"
					<?php endif ?>
				/>
			</div>

		<?php
	}
}
