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
class ImagePicker extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'image-picker';

	/**
	 * Enqueue control scripts
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-plupload' );
		wp_enqueue_media();
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-image-picker-' . $this->id;
		$value = $this->value();
		
		if ( is_array( $value ) ) $value = array( 'id' => '', 'thumbnail' => '' );
		if ( ! isset( $value['id'] ) ) $value['id'] = '';
		if ( ! isset( $value['thumbnail'] ) ) $value['thumbnail'] = '';
		?>
			<div class="options-control-inputs">
				<div class="upload-dropzone">
					<span class="upload-message">
						<?php _e( 'Drop a file here or', 'options-plus' ) ?>
						<a href="#" class="browse-media"><?php _e( 'select a file', 'options-plus' ) ?></a>
						<a href="#" class="upload"></a>
					</span>
					<span class="upload-preview"></span>
				</div>
				<a href="#" class="button remove"><?php _e( 'Remove Image', 'options-plus' ) ?></a>
			</div>
			<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>][id]" data-property="id" value="<?php __esc_attr( $value['id'] ) ?>" />
			<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>][thumbnail]" data-property="thumbnail" value="<?php __esc_attr( $value['thumbnail'] ) ?>" />
		<?php
	}
}
