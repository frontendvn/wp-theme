<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

/**
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
abstract class Mountain_Feature extends Mountain_Base
{
	protected function __construct() {
		/**
		 * The theme feature will initialize only when
		 * it registered in the theme supports
		 */
		if ( $this->enabled() ):
			$this->setup();
		endif;
	}

	abstract protected function setup();
	abstract protected function enabled();
}
