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
 * for theme optionsr
 */
class Heading extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'heading';

	public $title;
	public $description;
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		printf( '<h3>%s</h3>', $this->title );
		printf( '<p>%s</p>', $this->description );
	}
}
