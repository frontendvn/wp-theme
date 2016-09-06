<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();


if ( ! function_exists( 'mountain_style_switcher_settings' ) ) {
	add_filter( 'style-switcher/settings', 'mountain_style_switcher_settings' );

	function mountain_style_switcher_settings( $settings ) {
		$settings['scheme'] = op_option( 'scheme_color' );
		$settings['colors'] = array(
			'#374046', '#f44336', '#e91e63', '#9c27b0', '#673ab7',
			'#3f51b5', '#2196f3', '#03a9f4', '#00bcd4', '#009688',
			'#4caf50', '#8bc34a', '#ff5722', '#795548', '#9e9e9e',
			'#607d8b', '#58c5c0'
		);

		return $settings;
	}
}


function mountain_request_filesystem_api( $url = '', $action = -1, $name = '_wpnonce' ) {
	if ( ! function_exists( 'request_filesystem_credentials' ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
	}

	if ( ! $url ) {
		$url = $_SERVER['REQUEST_URI'];
	}
	// okay, let's see about getting credentials
	$url = wp_nonce_url( $url, $action, $name );
	$method = '';

	if ( false === ($creds = request_filesystem_credentials( $url, $method, false, false, null ) ) ) {
		$method = 'ftp';

		if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, null ) ) ) {
			// if we get here, then we don't have credentials yet,
			// but have just produced a form for the user to fill in,
			// so stop processing for now
			return false; // stop the normal page form from displaying
		}
	}
	
	// now we have some credentials, try to get the wp_filesystem running
	if ( ! WP_Filesystem( $creds ) ) {
		// our credentials were no good, ask the user for them again
		request_filesystem_credentials( $url, $method, true, false, null );
		return false;
	}
	
	return true;
}


/**
 * Return the predefined background patterns
 * 
 * @return  array
 */
function predefined_background_patterns() {
	static $patterns;

	if ( empty( $patterns ) || ! is_array( $patterns ) ) {
		$patterns = array();
		$template_directory = get_template_directory();
		$stylesheet_directory = get_stylesheet_directory();

		// Find background pattern from template's assets
		foreach( glob( $template_directory . '/assets/img/patterns/*' ) as $file ) {
			if ( is_dir( $file ) )
				continue;

			$patterns['parent_' . basename($file)] = get_template_directory_uri() . '/assets/img/patterns/' . basename($file);
		}

		if ( $template_directory != $stylesheet_directory ) {
			// Find background patterns from child theme's assets
			foreach( glob( $stylesheet_directory . '/assets/img/patterns/*' ) as $file ) {
				if ( is_dir( $file ) )
					continue;

				$patterns['child_' . basename($file)] = get_stylesheet_directory_uri() . '/assets/img/patterns/' . basename($file);
			}
		}

		$patterns = apply_filters( 'mountain/predefined_background_patterns', $patterns );
	}

	return $patterns;
}



/**
 * Return currently post type
 * 
 * @return  strings
 */
function current_post_type_is( $post_type ) {
	return op_current_post_type() == $post_type;
}



/**
 * Retrieve all options for a post
 *
 * @param   int  $post_id  The post ID
 * @return  array
 */
function get_post_options( $post_id = null ) {
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	return get_post_meta( $post_id, '_post_options', true );
}



/**
 * Retrieve all options for a page
 *
 * @param   int  $page_id  The page ID
 * @return  array
 */
function get_page_options( $page_id = null ) {
	if ( empty( $page_id ) )
		$page_id = get_the_ID();

	return get_post_meta( $page_id, '_page_options', true );
}



if ( ! function_exists( 'mountain_upload_mimes' ) ) {
	add_filter( 'upload_mimes', 'mountain_upload_mimes' );

	/**
	 * Register custom mime types for the theme
	 * 
	 * @param   array  $mimes  List of mime types
	 * @return  array
	 */
	function mountain_upload_mimes( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		$mimes['ico'] = 'image/x-icon';

		return $mimes;
	}
}



if ( ! function_exists( 'mountain_under_construction_mode' ) ) {
	add_action( 'wp', 'mountain_under_construction_mode' );

	/**
	 * This function will be check user permission and redirect to
	 * under construction page then under construction mode is turnned on
	 * 
	 * @return  void
	 */
	function mountain_under_construction_mode() {
		// We not check user permission in admin page
		if ( is_admin() ) return;

		// Check under construction is enabled and it is associated
		// to a page
		if ( op_option( 'under_construction_enabled', false ) && ( $page_id = op_option( 'under_construction_page_id', false ) ) ) {
			$allow_groups = op_option( 'under_construction_allowed', array() );
			$page_permalink = get_permalink( $page_id );

			// Force view permission for administrator
			if ( ! in_array( 'administrator', $allow_groups ) ) {
				array_unshift( $allow_groups, 'administrator' );
			}

			// Just do nothing if current page is assigned as under construction page
			if ( is_page( $page_id ) )
				return;

			// If user not logged in
			if ( ! is_user_logged_in() ) {
				wp_redirect( $page_permalink );
				exit;
			}

			// For logged in user
			else {
				$user = wp_get_current_user();
				$user_can_view = false;

				foreach ( $user->roles as $role ) {
					if ( in_array( $role, $allow_groups ) ) {
						$user_can_view = true;
						break;
					}
				}

				if ( ! $user_can_view ) {
					wp_redirect( $page_permalink );
					exit;
				}
			}
		}
	}
}



if ( ! function_exists( 'mountain_custom_shortcodes_class' ) ) {
	/**
	 * Helper function to append custom css class that
	 * generated from VisualComposer for shortcode
	 * 
	 * @param   array  $classes  Shortcode classes
	 * @param   array  $atts     Shortcode attributes
	 * @param   string $tag      Shortcode tag name
	 * 
	 * @return  array
	 */
	function mountain_custom_shortcodes_class( $classes, $atts = array(), $tag = '' ) {
		if ( function_exists( 'vc_shortcode_custom_css_class' ) && ! empty( $atts['css'] ) ) {
			$classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		}

		return $classes;
	}
}



if ( ! function_exists( '__esc_attr' ) ) {
	function __esc_attr() {
		echo call_user_func_array( 'esc_attr', func_get_args() );
	}
}



if ( ! function_exists( '__esc_html' ) ) {
	function __esc_html() {
		echo call_user_func_array( 'esc_html', func_get_args() );
	}
}



if ( ! function_exists( '__esc_url' ) ) {
	function __esc_url() {
		echo call_user_func_array( 'esc_url', func_get_args() );
	}
}
