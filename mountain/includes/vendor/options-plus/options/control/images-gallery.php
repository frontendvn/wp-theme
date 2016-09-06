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
 * This class will be present an mediapicker control
 */
class ImagesGallery extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'images-gallery';

	/**
	 * Accepted types
	 * 
	 * @var  array
	 */
	public $types;

	/**
	 * Enqueue control scripts
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_media();
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name  = '_options-images-gallery-' . $this->id;
		$value = $this->value();

		if ( ! is_array( $value ) )
			$value = json_decode( $value, true );
		?>
			<div class="options-control-inputs">
				<ul class="images-list">
					
				</ul>
				<button type="button" class="button button-add-images"><?php _e( 'Add Files', 'options-plus' ) ?></button>
			</div>
			<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>]" value="<?php __esc_attr( json_encode( $value ) ) ?>" />
		<?php
	}
}
