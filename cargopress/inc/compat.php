<?php
/**
 * Compatibility hooks for CargoPress WP theme.
 *
 * For 3rd party plugins/features.
 *
 * @package CargoPress
 */

class CargoPressCompat {

	function __construct() {
		add_action( 'activate_custom-sidebars/customsidebars.php', array( $this, 'cargopress_detect_custom_sidebar_plugin_activation' ) );
	}

	function cargopress_detect_custom_sidebar_plugin_activation() {
		// Get existing sidebars (if any exist)
		$custom_sidebars_options = get_option( 'cs_sidebars', array() );

		// Only add the custom sidebar (Our Services) if the Custom Sidebar plugin option cs_sidebars is empty
		if ( empty( $custom_sidebars_options ) ) {
			update_option( 'cs_sidebars', array(
				array(
					'id'            => 'cs-1',
					'name'          => 'Our Services',
					'description'   => '',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => '',
				),
			) );
		}
	}

}

// Single instance
$cargoress_compat = new CargoPressCompat();