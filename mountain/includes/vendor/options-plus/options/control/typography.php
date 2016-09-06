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
class Typography extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'typography';
	public $fields = array(
		'family', 'size', 'style', 'color'
	);

	private $titles;
	private static $localize_enqueued = false;

	public function __construct( $id, $args = array() ) {
		parent::__construct( $id, $args );

		$this->titles = array(
			'100'        => __( 'Thin 100', 'options-plus' ),
			'100italic'  => __( 'Thin 100 italic', 'options-plus' ),
			'200'        => __( 'Extra-light 200', 'options-plus' ),
			'200italic'  => __( 'Extra-light 200 italic', 'options-plus' ),
			'300'        => __( 'Light 300', 'options-plus' ),
			'300italic'  => __( 'Light 300 italic', 'options-plus' ),
			'400'        => __( 'Normal 400', 'options-plus' ),
			'400italic'  => __( 'Normal 400 italic', 'options-plus' ),
			'500'        => __( 'Medium 500', 'options-plus' ),
			'500italic'  => __( 'Medium 500 italic', 'options-plus' ),
			'600'        => __( 'Semi-bold 600', 'options-plus' ),
			'600italic'  => __( 'Semi-bold 600 italic', 'options-plus' ),
			'700'        => __( 'Bold 700', 'options-plus' ),
			'700italic'  => __( 'Bold 700 italic', 'options-plus' ),
			'800'        => __( 'Extra-bold 800', 'options-plus' ),
			'800italic'  => __( 'Extra-bold 800 italic', 'options-plus' ),
			'900'        => __( 'Ultra-bold 900', 'options-plus' ),
			'900itallic' => __( 'Ultra-bold 900 italic', 'options-plus' )
		);
	}

	/**
	 * Enqueue assets for this control
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_style( 'op-colpick' );
		wp_enqueue_style( 'op-chosen' );

		wp_enqueue_script( 'op-colpick' );
		wp_enqueue_script( 'op-chosen' );

		if ( ! self::$localize_enqueued ) {
			wp_localize_script( 'op-options-controls', '_opFontWeights', $this->titles );
			self::$localize_enqueued = true;
		}
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		global $_options_plus_fonts;

		$name = '_options-control-typography-' . $this->id;
		$values = $this->value();

		if ( isset( $_options_plus_fonts['system'][ $values['family'] ] ) )
			$font_weights = array_map( 'trim', explode( ',', $_options_plus_fonts['system'][$values['family']]['variants'] ) );
		elseif ( isset( $_options_plus_fonts['google'][ $values['family'] ] ) )
			$font_weights = array_map( 'trim', explode( ',', $_options_plus_fonts['google'][$values['family']]['variants'] ) );
		elseif ( isset( $_options_plus_fonts['custom'][ $values['family'] ] ) )
			$font_weights = array_map( 'trim', explode( ',', $_options_plus_fonts['custom'][$values['family']]['variants'] ) );
		else
			$font_weights = array();
		?>
			<div class="options-control-inputs">
				<?php if ( in_array( 'family', $this->fields ) ): ?>
				<div class="options-control-chosen typography-font">
					<div class="options-control-title">
						<label for="<?php __esc_attr( $name ) ?>-family"><?php _e( 'Font Family', 'options-plus' ) ?></label>
					</div>
					<div class="options-control-inputs">
						<select name="op-options[<?php esc_attr_e( $this->id ) ?>][family]" id="<?php esc_attr_e( $name ) ?>-family">
							<?php if ( isset( $_options_plus_fonts['custom'] ) ): ?>
							<optgroup label="<?php __esc_attr( 'User Fonts', 'options-plus' ) ?>">
								<?php foreach ( $_options_plus_fonts['custom'] as $id => $font ): ?>
								<option value="<?php __esc_attr( $id ) ?>" data-variants="<?php __esc_attr( $font['variants'] ) ?>" <?php selected( $id, $values['family'] ) ?> ><?php __esc_html( $font['caption'] ) ?></option>
								<?php endforeach ?>
							</optgroup>
							<?php endif ?>

							<optgroup label="<?php esc_attr_e( 'System Fonts', 'options-plus' ) ?>">
								<?php foreach ( $_options_plus_fonts['system'] as $id => $font ): ?>
								<option value="<?php esc_attr_e( $id ) ?>" data-variants="<?php esc_attr_e( $font['variants'] ) ?>" <?php selected( $id, $values['family'] ) ?> ><?php esc_html_e( $font['caption'] ) ?></option>
								<?php endforeach ?>
							</optgroup>
							<optgroup label="<?php esc_attr_e( 'Google Fonts', 'options-plus' ) ?>">
								<?php foreach ( $_options_plus_fonts['google'] as $id => $font ): ?>
								<option value="<?php esc_attr_e( $id ) ?>" data-variants="<?php esc_attr_e( $font['variants'] ) ?>" <?php selected( $id, $values['family'] ) ?> ><?php esc_html_e( $font['caption'] ) ?></option>
								<?php endforeach ?>
							</optgroup>
						</select>
					</div>
				</div>
				<!-- /family -->
				<?php endif ?>

				<?php if ( in_array( 'size', $this->fields ) ): ?>
				<div class="typography-size">
					<div class="options-control-title">
						<label for="<?php esc_attr_e( $name ) ?>-size"><?php _e( 'Font Size (px)', 'options-plus' ) ?></label>
					</div>
					<div class="options-control-inputs">
						<input type="text" name="op-options[<?php esc_attr_e( $this->id ) ?>][size]" value="<?php esc_attr_e( $values['size'] ) ?>" id="<?php esc_attr_e( $name ) ?>-size" />
					</div>
				</div>
				<!-- /size -->
				<?php endif ?>

				<?php if ( in_array( 'style', $this->fields ) ): ?>
				<div class="options-control-dropdown typography-style">
					<div class="options-control-title">
						<label><?php _e( 'Font Weight & Style', 'options-plus' ) ?></label>
					</div>
					<div class="options-control-inputs">
						<label>
							<span class="options-control-preview"></span>
							<select name="op-options[<?php esc_attr_e( $this->id ) ?>][style]" id="<?php esc_attr_e( $name ) ?>-style">
								<?php foreach ( $font_weights as $font_weight ): ?>
								<option value="<?php esc_attr_e( $font_weight ) ?>" <?php selected( $font_weight, $values['style'] ) ?> >
									<?php
										if ( isset( $this->titles[$font_weight] ) )
											esc_html_e( $this->titles[$font_weight] );
										else
											esc_html_e( $font_weight );
									?>
								</option>
								<?php endforeach ?>
							</select>
						</label>
					</div>
				</div>
				<!-- /font-weight -->
				<?php endif ?>

				<?php if ( in_array( 'color', $this->fields ) ): ?>
				<div class="options-control-color-picker typography-color">
					<div class="options-control-title">
						<label><?php _e( 'Font Color', 'options-plus' ) ?></label>
					</div>
					<div class="options-control-inputs">
						<input type="text" id="<?php esc_attr_e( $name ) ?>-color" name="op-options[<?php esc_attr_e( $this->id ) ?>][color]" value="<?php esc_attr_e( $values['color'] ) ?>" />
						<button type="button" class="options-control-preview" style="background-color: <?php esc_attr_e( $values['color'] ) ?>;"></button>
						<div class="colorpicker-panel"></div>
					</div>
				</div>
				<?php endif ?>
			</div>
		
		<?php
	}
}
