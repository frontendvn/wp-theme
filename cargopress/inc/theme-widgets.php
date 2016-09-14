<?php
/**
 * Load here all the individual widgets
 *
 * @package CargoPress
 */

// ProteusWidgets init
new ProteusWidgets;

// Require the individual widgets
add_action( 'widgets_init', function () {
	// custom widgets in the theme
	$cargopress_custom_widgets = array(
		'widget-call-to-action',
	);

	foreach ( $cargopress_custom_widgets as $file ) {
		require_once( sprintf( '%s/inc/widgets/%s.php', get_template_directory(), $file ) );
	}

	// Relying on composer's autoloader, just provide classes from ProteusWidgets
	register_widget( 'PW_Brochure_Box' );
	register_widget( 'PW_Facebook' );
	register_widget( 'PW_Featured_Page' );
	register_widget( 'PW_Google_Map' );
	register_widget( 'PW_Icon_Box' );
	register_widget( 'PW_Latest_News' );
	register_widget( 'PW_Opening_Time' );
	register_widget( 'PW_Skype' );
	register_widget( 'PW_Social_Icons' );
	register_widget( 'PW_Testimonials' );
	register_widget( 'PW_Number_Counter' );
} );