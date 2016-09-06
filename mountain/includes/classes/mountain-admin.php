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
class Mountain_Admin extends Mountain_Base
{
	public function __construct() {
		if ( is_admin() ) {
			Mountain_PostOptions::instance();
			Mountain_PageOptions::instance();

			/**
			 * Initialize theme advanced settings
			 */
			Mountain_Advanced::instance();

			/**
			 * Initialize sample data installer
			 */
			Mountain_SampleData::instance();
		}
	}
}
