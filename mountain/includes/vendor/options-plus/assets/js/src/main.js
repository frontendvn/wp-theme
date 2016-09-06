// @koala-prepend "./_background.js"
// @koala-prepend "./_checkboxes.js"
// @koala-prepend "./_color_picker.js"
// @koala-prepend "./_dimension.js"
// @koala-prepend "./_dropdown.js"
// @koala-prepend "./_image_picker.js"
// @koala-prepend "./_images_gallery.js"
// @koala-prepend "./_media_input.js"
// @koala-prepend "./_media_list.js"
// @koala-prepend "./_media_picker.js"
// @koala-prepend "./_radio.js"
// @koala-prepend "./_social_icons.js"
// @koala-prepend "./_spinner.js"
// @koala-prepend "./_switcher.js"
// @koala-prepend "./_textarea.js"
// @koala-prepend "./_typography.js"
// @koala-prepend "./_widget_layout.js"
// @koala-prepend "./_code.js"

( function( $ ) {
	"use strict";

	/**
	 * Helper function to change visibility state
	 * for a list of the controls
	 *
	 * @param   array    controls  The controls list
	 * @param   boolean  visible   Visibility state
	 *
	 * @return  void
	 */
	$.opControlVisible = function( controls, visible ) {
		var _controls = controls || [],
			_visible  = visible  || false;

		if ( $.isArray( _controls ) ) {
			$.each( _controls, function( index, value ) {
				_visible
					? $( 'li[data-option="' + value + '"]' ).removeClass( 'hide' )
					: $( 'li[data-option="' + value + '"]' ).addClass( 'hide' )
			} );
		}
	};

	$.opInitControls = function( container ) {
		$( '.options-control-media-picker', container ).op_mediaPicker();
		$( '.options-control-color-picker', container ).op_colorPicker();
		$( '.options-control-dropdown, .options-control-dropdown-sidebars', container ).op_dropdown();
		$( '.options-control-dimension', container ).op_dimension();
		$( '.options-control-social-icons', container ).op_socialIcons();
		$( '.options-control-switcher', container ).op_switcher();
		$( '.options-control-widgets-layout', container ).op_widgetLayout();
		$( '.options-control-background', container ).op_background();
		$( '.options-control-typography', container ).op_typography();
		$( '.options-control-radio-images, .options-control-radio-buttons', container ).op_radio();
		$( '.options-control-textarea, .options-control-text', container ).op_textarea();
		$( '.options-control-spinner', container ).op_spinner();
		$( '.options-control-images-gallery', container ).op_imagesGallery();
		$( '.options-control-media-list', container ).op_mediaList();
		$( '.options-control-media-input', container ).op_mediaInput();
		$( '.options-control-image-picker', container ).op_imagePicker();
		$( '.options-control-checkboxes', container ).op_checkboxes();
		$( '.options-control-code', container ).op_code();
		// $( '.options-control-install-sample-data', container ).installSampleData();

		// Initialize container
		$( '.options-container.options-container-tabs', container ).tabs();
	};

	$( function() {
		$.opInitControls( $( 'body' ) );
	} )

} ).call( this, jQuery );