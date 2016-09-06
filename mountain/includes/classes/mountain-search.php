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
class Mountain_Search extends Mountain_Base
{
	protected function __construct() {
		// add_filter( 'pre_get_posts', array( $this, 'exclude_pages' ) );
	}

	/**
	 * This filter will remove post type "page" from
	 * search query
	 * 
	 * @param   WP_Query  $query  Search query object
	 * @return  WP_Query
	 */
	public function exclude_pages( $query ) {
		if ( ! is_admin() && is_search() && $query->is_search ) {
			$post_types = get_post_types( array( 'public' => true ) );

			// Remove post type "page" from search
			unset( $post_types['page'] );

			// Set post type for search query
			$query->set( 'post_type', array_values( $post_types ) );
		}
		
		return $query;
	}
}
