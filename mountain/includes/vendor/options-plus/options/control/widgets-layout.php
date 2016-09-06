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
 * This class will be present an widgets layout control
 */
class WidgetsLayout extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'widgets-layout';

	public $max = 4;
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name           = '_options-widgets-layout-' . $this->id;
		$values         = $this->value();

		if ( ! is_array( $values ) )
			$values = json_decode( $values, true );

		$columns_count  = $values['active'];
		$columns_layout = $values['layout'];
		$max            = $this->max;
		?>
		<div class="options-control-inputs">
			<div class="columns-count">
				<?php foreach ( range(0, $max - 1) as $index ): ?>
				<label>
					<input type="radio" name="<?php __esc_attr( $name ) ?>" value="<?php __esc_attr( $index ) ?>" <?php checked( $columns_count, $index ) ?> />
					<span><?php echo $index + 1 ?></span>
				</label>
				<?php endforeach ?>
			</div>

			<div class="options-control-layouts">
				<?php foreach ( range(0, $max - 1) as $index ):
					if ( ! isset( $columns_layout[$index] ) || ! is_array( $columns_layout[$index] ) )
						continue;

					$columns = $columns_layout[$index];
					?>
					<div id="<?php __esc_attr( $name . '-' . $index ) ?>" class="<?php if ( $index == $columns_count ) echo 'active' ?>">
						<div class="widgetslayout-row">
							<?php foreach ( $columns as $width ): ?>
							<div class="widgetslayout-column" data-width="<?php __esc_attr( $width ) ?>">
								<span><?php __esc_html( $width ) ?></span>
							</div>
							<?php endforeach ?>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>]" value="<?php __esc_attr( json_encode( $values ) ) ?>" />
		<?php
	}
}
