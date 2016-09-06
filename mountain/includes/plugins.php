<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Register action to declare required plugins
add_action( 'tgmpa_register', 'mountain_plugins' );

/**
 * Register third-party plugins
 *
 * @return  void
 */
function mountain_plugins() {
	$plugins = array(
		// This is an example of how to include a plugin pre-packaged with a theme.
		array(
			'name'               => 'nProjects By LineThemes',
			'slug'               => 'nprojects',
			'source'             => 'http://demo.linethemes.com/plugins.php?id=nprojects',
			'version'            => '1.0.5'
		),

		array(
			'name'               => 'Shortcodes for Mountain',
			'slug'               => 'mountain-shortcodes',
			'source'             => get_template_directory() . '/plugins/mountain-shortcodes.zip',
			'version'            => '1.0.2',
			'required'           => false
		),

		array(
			'name'               => 'LayerSlider WP',
			'slug'               => 'LayerSlider',
			'source'             => 'http://demo.linethemes.com/plugins.php?id=layerslider',
			'version'            => '5.6.7',
			'required'           => false
		),

		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7'
		),
		
		array(
			'name'               => 'WooCommerce',
			'slug'               => 'woocommerce'
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'mountain' ),
			'menu_title'                      => __( 'Install Plugins', 'mountain' ),
			'installing'                      => __( 'Installing Plugin: %s', 'mountain' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'mountain' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'mountain' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'mountain' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'mountain' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'mountain' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'mountain' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'mountain' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'mountain' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'mountain' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'mountain' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'mountain' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'mountain' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'mountain' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'mountain' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}
