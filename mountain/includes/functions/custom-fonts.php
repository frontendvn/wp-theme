<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */
defined( 'ABSPATH' ) or die();

if ( ! function_exists( 'mountain_register_custom_fonts' ) ):

	function mountain_register_custom_fonts() {
		global $_options_plus_fonts, $wp_filesystem;

		$base  = get_stylesheet_directory() . '/webfonts';
		$base_uri = get_stylesheet_directory_uri() . '/webfonts';
		$fonts = array();

		if ( mountain_request_filesystem_api() ) {
			if ( ! $wp_filesystem->is_dir( $base ) ) {
				$wp_filesystem->mkdir( $base );
			}

			if ( $dirs = glob( "{$base}/*" ) ) {
				foreach ( $dirs as $dir ) {
					if ( $wp_filesystem->is_file( "{$dir}/stylesheet.css" ) ) {
						$content = $wp_filesystem->get_contents( "{$dir}/stylesheet.css" );

						if ( preg_match( '/font-family: \'([^\']+)\';/iUs', $content, $matches ) ) {
							$name = basename( $dir );
							$fonts[ $name ] = array(
								'family'   => esc_html( $matches[1] ),
								'caption'  => esc_html( $name ),
								'variants' => '400, 400italic, 700, 700italic',
								'uri'      => $base_uri . '/' . $name . '/stylesheet.css'
							);
						}
					}
				}
			}
		}

		// Add custom fonts group
		if ( ! isset( $_options_plus_fonts['custom'] ) && ! empty( $fonts ) ) {
			$_options_plus_fonts['custom'] = $fonts;
		}
	}

endif;

add_action( 'init', 'mountain_register_custom_fonts' );
