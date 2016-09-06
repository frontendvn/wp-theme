( function( $ ) {
	"use strict";

	/**
	 * Refresh the controls state
	 * 
	 * @return  void
	 */
	var refreshState = function() {
		// Styles
		$.opControlVisible( ['projects_single_gallery_type', 'projects_single_content_position'],
			$( '[data-option="project_settings_enabled"] input' ).is( ':checked' ) );

		$.opControlVisible( ['projects_single_gallery_columns'],
			$( '[data-option="project_settings_enabled"] input' ).is( ':checked' ) &&
			$( '[data-option="projects_single_gallery_type"] input:checked' ).val() == 'grid' );

		$.opControlVisible( ['projects_single_content_sticky'],
			$( '[data-option="project_settings_enabled"] input' ).is( ':checked' ) &&
			$( '[data-option="projects_single_content_position"] input:checked' ).val() != 'fullwidth' );
		// $.opControlVisible( ['sidebar_default'],
		// 	['default', 'no-sidebar'].indexOf( $( '[data-option="sidebar_layout"] select' ).val() ) == -1 );

		// // // Page Title
		// $.opControlVisible( ['pagetitle_breadcrumb_enabled', 'custom_page_title', 'pagetitle_background'],
		// 	$( '[data-option="pagetitle_enabled"] input' ).is( ':checked' ) &&
		// 	$( '[data-option="enable_custom_page_header"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['pagetitle_enabled'],
		// 	$( '[data-option="enable_custom_page_header"] input' ).is( ':checked' ) );
	};

	/**
	 * Implement DOM Ready event
	 */
	$( function() {
		$( window ).on( 'load', refreshState );
		$('#wpbody-content form').on( 'change', refreshState );
	} );

} )( jQuery );
