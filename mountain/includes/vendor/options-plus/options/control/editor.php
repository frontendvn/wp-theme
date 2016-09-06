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
 * This class will be present an text control
 */
class Editor extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'editor';
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name = '_options-editor-' . $this->id;
		?>
		<div class="options-control-inputs">
			<?php wp_editor( $this->value(), $name, array( 'textarea_name' => "op-options[{$this->id}]", 'drag_drop_upload' => true ) ) ?>
		</div>
		<?php
	}
}
