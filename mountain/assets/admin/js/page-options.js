(function( $ ) {
	"use strict";

	/**
	 * Refresh the controls state
	 * 
	 * @return  void
	 */
	var refreshState = function() {
		// Styles
		$.opControlVisible( ['sidebar_default'],
			['default', 'no-sidebar'].indexOf( $( '[data-option="sidebar_layout"] select' ).val() ) == -1 );

		// // Page Title
		$.opControlVisible( ['pagetitle_breadcrumb_enabled', 'custom_page_title', 'pagetitle_background'],
			$( '[data-option="pagetitle_enabled"] input' ).is( ':checked' ) &&
			$( '[data-option="enable_custom_page_header"] input' ).is( ':checked' ) );

		$.opControlVisible( ['pagetitle_enabled'],
			$( '[data-option="enable_custom_page_header"] input' ).is( ':checked' ) );

		// // Topbar
		// $.opControlVisible( ['topbar_bgcolor', 'topbar_textcolor', 'topbar_content', 'topbar_social_links_enabled'],
		// 	$( '[data-option="topbar_enabled"] input' ).is( ':checked' ) &&
		// 	$( '[data-option="enable_custom_topbar"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['topbar_enabled'],
		// 	$( '[data-option="enable_custom_topbar"] input' ).is( ':checked' ) );

		// // Header sticky
		// $.opControlVisible( ['header_style', 'header_dark_style', 'header_sticky', 'header_stick_dark_style', 'header_searchbox', 'header_cart_menu', 'header_overlay_content'],
		// 	$( '[data-option="enable_custom_header_style"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['header_stick_dark_style'],
		// 	$( '[data-option="enable_custom_header_style"] input' ).is( ':checked' ) &&
		// 	$( '[data-option="header_sticky"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['header_show_offcanvas'],
		// 		$( '[data-option="enable_custom_header_style"] input' ).is( ':checked' )
		// 	);

		// // Logo
		// $.opControlVisible( ['logo_src', 'logo_sticky_src', 'logo_size', 'logo_margin'],
		// 	$( '[data-option="enable_custom_logo"] input' ).is( ':checked' ) );

		// // Navigator
		// var navigator_controls = ['onepage_nav_script'];
		// $( '[data-option^="menu_location_"]' ).each( function() {
		// 	navigator_controls.push( $( this ).attr( 'data-option' ) );
		// } );

		// $.opControlVisible( navigator_controls,
		// 	$( '[data-option="enable_custom_navigator"] input' ).is( ':checked' ) );

		// // Page Callout
		// $.opControlVisible( ['page_callout_content', 'page_callout_button_text', 'page_callout_button_link', 'page_callout_button_target', 'page_callout_button_class', 'page_callout_background', 'page_callout_textcolor'],
		// 	$( '[data-option="page_callout_enabled"] input' ).is( ':checked' ) &&
		// 	$( '[data-option="enable_custom_page_callout"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['page_callout_enabled'],
		// 	$( '[data-option="enable_custom_page_callout"] input' ).is( ':checked' ) );

		// // Footer Widgets
		// $.opControlVisible( ['footer_widgets_layout', 'footer_widgets_background', 'footer_widgets_textcolor'],
		// 	$( '[data-option="footer_widgets_enabled"] input' ).is( ':checked' ) &&
		// 	$( '[data-option="enable_custom_footer_widgets"] input' ).is( ':checked' ) );

		// $.opControlVisible( ['footer_widgets_enabled'],
		// 	$( '[data-option="enable_custom_footer_widgets"] input' ).is( ':checked' ) );

		// // Footer Content
		// $.opControlVisible( ['footer_copyright', 'footer_social_links_enabled'],
		// 	$( '[data-option="enable_custom_footer"] input' ).is( ':checked' ) );

		// // Blog Options
		// $.opControlVisible( ['blog_grid_columns'],
		// 	['grid', 'masonry'].indexOf( $( '[data-option="blog_archive_layout"] input:checked' ).val() ) != -1 );
		// $.opControlVisible( ['blog_archive_post_excepts_length'],
		// 	$( '[data-option="blog_archive_post_excepts"] input' ).is( ':checked' ) );
		// $.opControlVisible( ['blog_archive_readmore_text'],
		// 	$( '[data-option="blog_archive_readmore"] input' ).is( ':checked' ) );
	};

	/**
	 * Implement DOM Ready event
	 */
	$( function() {
		$(window).on( 'load', refreshState );
		$('#wpbody-content form').on( 'change', refreshState );
	} );
}).call(this, jQuery);