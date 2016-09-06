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
class Background extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'background';

	/**
	 * List of predefined background patterns
	 * 
	 * @var  array
	 */
	public $patterns;

	/**
	 * Enqueue assets for this control
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_style( 'op-colpick' );
		wp_enqueue_script( 'op-colpick' );
		wp_enqueue_script( 'wp-plupload' );
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-control-background-' . $this->id;
		$values = $this->value();
		$default = array(
			'type'     => 'none',
			'pattern'  => 'none',
			'color'    => '#fff',
			'image'    => '',
			'repeat'   => 'repeat',
			'position' => 'top-left',
			'style'    => 'scroll'
		);

		if ( ! is_array( $values ) )
			$values = $default;
		else
			$values = array_merge( $default, $values );
		?>
			<div class="options-control-inputs">
				<div class="background-color">
					<div class="options-control-color-picker">
						<div class="options-control-inputs">
							<input type="text" id="<?php __esc_attr( $name ) ?>-color" name="op-options[<?php __esc_attr( $this->id ) ?>][color]" value="<?php __esc_attr( $values['color'] ) ?>" />
							<button type="button" class="options-control-preview" style="background-color: <?php __esc_attr( $values['color'] ) ?>;"></button>
							<div class="colorpicker-panel"></div>
						</div>
					</div>
				</div>

				<div class="background-type">
					<label>
						<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][type]" value="none" <?php checked( $values['type'], 'none' ) ?> />
						<span><?php _e( 'None', 'options-plus' ) ?></span>
					</label>
					<label>
						<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][type]" value="patterns" <?php checked( $values['type'], 'patterns' ) ?> />
						<span><?php _e( 'Patterns', 'options-plus' ) ?></span>
					</label>
					<label>
						<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][type]" value="custom" <?php checked( $values['type'], 'custom' ) ?> />
						<span><?php _e( 'Custom', 'options-plus' ) ?></span>
					</label>
				</div>
				
				<div class="background-patterns">
					<label>
						<input type="radio" value="none" name="op-options[<?php __esc_attr( $this->id ) ?>][pattern]" <?php checked( $values['pattern'], 'none' ) ?> />
						<span> </span>
					</label>

					<?php foreach ( $this->patterns as $id => $url ): ?>
					<label>
						<input type="radio" value="<?php __esc_attr( $id ) ?>" name="op-options[<?php __esc_attr( $this->id ) ?>][pattern]" <?php checked( $values['pattern'], $id ) ?> />
						<span style="background: url(<?php __esc_url( $url ) ?>)"> </span>
					</label>
					<?php endforeach ?>
				</div>

				<div class="background-custom">
					<div class="options-control-media-picker background-image">
						<div class="options-control-title"><?php _e( 'Background Image', 'options-plus' ) ?></div>
						<div class="options-control-inputs">
							<div class="upload-dropzone">
								<span class="upload-message">
									<?php _e( 'Drop a file here or', 'options-plus' ) ?>
									<a href="#" class="browse-media"><?php _e( 'select a file', 'options-plus' ) ?></a>
									<a href="#" class="upload"></a>
								</span>
								<span class="upload-preview"></span>
							</div>
							<a href="#" class="button remove"><?php _e( 'Remove', 'options-plus' ) ?></a>
						</div>
						<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>][image]" value="<?php __esc_attr( $values['image'] ) ?>" />
					</div>

					<div class="options-control-radio-images background-repeat">
						<div class="options-control-title"><?php _e( 'Background Repeat', 'options-plus' ) ?></div>
						<div class="options-control-inputs">
							<label class="background-no-repeat">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][repeat]" value="no-repeat" <?php checked( $values['repeat'], 'no-repeat' ) ?> />
								<span data-title="<?php __esc_attr( 'No Repeat', 'options-plus' ) ?>"><?php _e( 'No Repeat', 'options-plus' ) ?></span>
							</label>
							<label class="background-repeat-x">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][repeat]" value="repeat-x" <?php checked( $values['repeat'], 'repeat-x' ) ?> />
								<span data-title="<?php __esc_attr( 'Repeat X', 'options-plus' ) ?>"><?php _e( 'Repeat X', 'options-plus' ) ?></span>
							</label>
							<label class="background-repeat-y">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][repeat]" value="repeat-y" <?php checked( $values['repeat'], 'repeat-y' ) ?> />
								<span data-title="<?php __esc_attr( 'Repeat Y', 'options-plus' ) ?>"><?php _e( 'Repeat Y', 'options-plus' ) ?></span>
							</label>
							<label class="background-repeat-all">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][repeat]" value="repeat" <?php checked( $values['repeat'], 'repeat' ) ?> />
								<span data-title="<?php __esc_attr( 'Repeat All', 'options-plus' ) ?>"><?php _e( 'Repeat All', 'options-plus' ) ?></span>
							</label>
						</div>
					</div>

					<div class="options-control-radio-images background-position">
						<div class="options-control-title"><?php _e( 'Background Position', 'options-plus' ) ?></div>
						<div class="options-control-inputs">
							<label class="background-top-left">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="top-left" <?php checked( $values['position'], 'top-left' ) ?> />
								<span data-title="<?php __esc_attr( 'Top Left', 'options-plus' ) ?>"><?php _e( 'Top Left', 'options-plus' ) ?></span>
							</label>
							<label class="background-top-center">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="top-center" <?php checked( $values['position'], 'top-center' ) ?> />
								<span data-title="<?php __esc_attr( 'Top Center', 'options-plus' ) ?>"><?php _e( 'Top Center', 'options-plus' ) ?></span>
							</label>
							<label class="background-top-right">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="top-right" <?php checked( $values['position'], 'top-right' ) ?> />
								<span data-title="<?php __esc_attr( 'Top Right', 'options-plus' ) ?>"><?php _e( 'Top Right', 'options-plus' ) ?></span>
							</label>

							<label class="background-middle-left">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="center-left" <?php checked( $values['position'], 'center-left' ) ?> />
								<span data-title="<?php __esc_attr( 'Middle Left', 'options-plus' ) ?>"><?php _e( 'Middle Left', 'options-plus' ) ?></span>
							</label>
							<label class="background-middle-center">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="center-center" <?php checked( $values['position'], 'center-center' ) ?> />
								<span data-title="<?php __esc_attr( 'Middle Center', 'options-plus' ) ?>"><?php _e( 'Middle Center', 'options-plus' ) ?></span>
							</label>
							<label class="background-middle-right">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="center-right" <?php checked( $values['position'], 'center-right' ) ?> />
								<span data-title="<?php __esc_attr( 'Middle Right', 'options-plus' ) ?>"><?php _e( 'Middle Right', 'options-plus' ) ?></span>
							</label>

							<label class="background-bottom-left">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="bottom-left" <?php checked( $values['position'], 'bottom-left' ) ?> />
								<span data-title="<?php __esc_attr( 'Bottom Left', 'options-plus' ) ?>"><?php _e( 'Bottom Left', 'options-plus' ) ?></span>
							</label>
							<label class="background-bottom-center">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="bottom-center" <?php checked( $values['position'], 'bottom-center' ) ?> />
								<span data-title="<?php __esc_attr( 'Bottom Center', 'options-plus' ) ?>"><?php _e( 'Bottom Center', 'options-plus' ) ?></span>
							</label>
							<label class="background-bottom-right">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][position]" value="bottom-right" <?php checked( $values['position'], 'bottom-right' ) ?> />
								<span data-title="<?php __esc_attr( 'Bottom Right', 'options-plus' ) ?>"><?php _e( 'Bottom Right', 'options-plus' ) ?></span>
							</label>
						</div>
					</div>

					<div class="options-control-radio-images background-style">
						<div class="options-control-title"><?php _e( 'Background Style', 'options-plus' ) ?></div>
						<div class="options-control-inputs">
							<label class="background-fixed">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][style]" value="fixed" <?php checked( $values['style'], 'fixed' ) ?> />
								<span data-title="<?php __esc_attr( 'Fixed', 'options-plus' ) ?>"><?php _e( 'Fixed', 'options-plus' ) ?></span>
							</label>
							<label class="background-scroll">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][style]" value="scroll" <?php checked( $values['style'], 'scroll' ) ?> />
								<span data-title="<?php __esc_attr( 'Scroll', 'options-plus' ) ?>"><?php _e( 'Scroll', 'options-plus' ) ?></span>
							</label>
							<label class="background-cover">
								<input type="radio" name="op-options[<?php __esc_attr( $this->id ) ?>][style]" value="cover" <?php checked( $values['style'], 'cover' ) ?> />
								<span data-title="<?php __esc_attr( 'Cover', 'options-plus' ) ?>"><?php _e( 'Cover', 'options-plus' ) ?></span>
							</label>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
}
