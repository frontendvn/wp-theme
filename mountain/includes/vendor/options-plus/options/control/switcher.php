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
 * This class will be present an switch control
 */
class Switcher extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'switcher';

	/**
	 * Render the control
	 * 
	 * @return  string
	 */
	public function render() {
		$id    = 'options-control-' . $this->id;
		$class = 'options-control options-control-' . $this->type;

		if ( $this->value() )
			$this->class = 'active';

		if ( ! empty( $this->class ) )
			$class .= " {$this->class}";

		if ( empty( $this->label ) )
			$class .= ' no-label';

		?><li id="<?php __esc_attr( $id ); ?>" class="<?php __esc_attr( $class ) ?>" data-option="<?php __esc_attr( $this->id ) ?>" data-customizer-link="<?php __esc_attr( $this->link ) ?>">
			<?php $this->render_content(); ?>
		</li><?php
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-switcher-' . $this->id;
		?>
		<label id="<?php __esc_attr( $name ) ?>">
			<?php if ( ! empty( $this->label ) ): ?>
				<span class="options-control-title"><?php __esc_html( $this->label ) ?></span>
			<?php endif ?>

			<input type="checkbox" value="true" name="op-options[<?php __esc_attr( $this->id ) ?>]" <?php checked( $this->value() ) ?> />
			<span class="options-control-indicator">
				<span></span>
			</span>
		</label>
		<?php
	}
}
