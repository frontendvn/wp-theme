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
 * Register class autoloader for Breadcrumb Trail
 */
Mountain_AutoLoad::map_class( 'Breadcrumb_Trail', get_template_directory() . '/includes/vendor/breadcrumb-trail.php' );

/**
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain_Breadcrumb extends Mountain_Base
{
	protected function __construct() {
		if ( class_exists( 'Breadcrumb_Trail' ) ):
			
			/**
			 * Add breadcrumb item when post title is empty
			 */
			add_filter( 'breadcrumb_trail_items', array( $this, 'empty_title_item' ), 10, 2 );

		endif;
	}

	/**
	 * Add breadcrumb item when post title is empty
	 * 
	 * @param   array  $items  Breadcrumb items
	 * @param   array  $args   Arguments
	 * @return  array
	 */
	public function empty_title_item( $items, $args ) {
		if ( is_singular() ) {
			if ( current_post_type_is( 'post' ) ) {
				$post = get_post();
				
				if ( empty( $post->post_title ) ) {
					$items[] = get_the_title();
				}
			}
			elseif ( current_post_type_is( 'nproject' ) ) {
				$permalink_base = get_theme_mod( 'projects_permalink_base' );
				$archive_page = get_post( get_theme_mod( 'projects_archive_page' ) );

				foreach ( $items as $index => $value ) {
					$items[ $index ] = str_replace( sprintf( '/%s/', $permalink_base ), sprintf( '/%s/', $archive_page->post_name ), $value );
				}
			}
		}

		return $items;
	}
}
