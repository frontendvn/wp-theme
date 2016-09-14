<?php

// Only require these files, if the Visual Composer plugin is activated
if ( defined( 'WPB_VC_VERSION' ) ) {

	// Require Visual Composer classes
	require_once( get_template_directory() . '/vendor/proteusthemes/visual-composer-elements/vc-shortcodes/class-vc-shortcode.php' );
	require_once( get_template_directory() . '/vendor/proteusthemes/visual-composer-elements/vc-shortcodes/class-vc-custom-param-types.php' );
	require_once( get_template_directory() . '/vendor/proteusthemes/visual-composer-elements/vc-shortcodes/class-vc-helpers.php' );

	// Require Visual Composer CargoPress templates
	require_once( get_template_directory() . '/inc/vc-templates/theme-vc-home-page-template.php' );
	require_once( get_template_directory() . '/inc/vc-templates/theme-vc-our-services-template.php' );
	require_once( get_template_directory() . '/inc/vc-templates/theme-vc-about-us-template.php' );
	require_once( get_template_directory() . '/inc/vc-templates/theme-vc-contact-us-template.php' );

	// Custom visual composer shortcodes for the theme
	$cargopress_custom_vc_shortcodes = array(
		'call-to-action',
		'brochure-box',
		'facebook',
		'featured-page',
		'icon-box',
		'latest-news',
		'skype',
		'opening-time',
		'social-icon',
		'container-social-icons',
		'location',
		'container-google-maps',
		'counter',
		'container-number-counter',
		'testimonial',
		'container-testimonials',
	);

	foreach ( $cargopress_custom_vc_shortcodes as $file ) {
		require_once( sprintf( '%s/vendor/proteusthemes/visual-composer-elements/vc-shortcodes/shortcodes/vc-%s.php', get_template_directory(), $file ) );
	}
}