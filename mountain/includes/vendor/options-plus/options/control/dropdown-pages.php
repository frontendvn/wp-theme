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
class DropdownPages extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'dropdown';

	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-dropdown-' . $this->id;
		?>
		<div class="options-control-inputs">
			<label>
				<span class="options-control-preview"></span>
				<?php
					wp_dropdown_pages(
						array(
							'name'              => $name,
							'show_option_none'  => __( '&mdash; Select &mdash;', 'options-plus' ),
							'option_none_value' => '0',
							'selected'          => $this->value(),
						)
					);
				?>
			</label>
		</div><?php
	}
}
