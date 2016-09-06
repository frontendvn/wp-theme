<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();


if ( ! function_exists( 'mountain_requirement_check' ) ):
	add_action( 'after_switch_theme', 'mountain_requirement_check', 10, 2 );

	/**
	 * Check the theme requirements
	 */
	function mountain_requirement_check( $name, $theme ) {
	    if ( version_compare( PHP_VERSION, '5.3', '<' ) ):
			add_action( 'admin_notices', 'mountain_requirement_notice' );

			function mountain_requirement_notice() {
				printf( '<div class="error"><p>%s</p></div>',
					__( 'Sorry! Your server does not meet the minimum requirements, please upgrade PHP version to 5.3 or higher', 'mountain' ) );
			}

			// Switch back to previous theme
			switch_theme( $theme->stylesheet );
		endif;
	}
endif;



if ( version_compare( PHP_VERSION, '5.3', '>=' ) ):
	// Classes
	require_once get_template_directory() . '/includes/classes/mountain-autoload.php';
	require_once get_template_directory() . '/includes/vendor/plugin-activation.php';
	require_once get_template_directory() . '/includes/vendor/options-plus.php';

	// Functions
	require_once get_template_directory() . '/includes/plugins.php';
	require_once get_template_directory() . '/includes/assets.php';
	require_once get_template_directory() . '/includes/woocommerce.php';
	require_once get_template_directory() . '/includes/functions/helpers.php';
	require_once get_template_directory() . '/includes/functions/template.php';
	require_once get_template_directory() . '/includes/functions/visual-composer.php';
	require_once get_template_directory() . '/includes/functions/structure.php';
	require_once get_template_directory() . '/includes/functions/custom-fonts.php';
	require_once get_template_directory() . '/includes/functions/options-override.php';

	// Register class mapping
	Mountain_AutoLoad::map( 'Mountain_', get_template_directory() . '/includes/classes/' );
	Mountain_AutoLoad::map_class( 'Mountain', get_template_directory() . '/includes/classes/mountain.php' );

	// Initialize the theme
	Mountain::instance();

	// Initialize the theme admin
	Mountain_Admin::instance();
endif;


add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
