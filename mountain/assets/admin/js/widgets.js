( function( $ ) {
	"use strict";

	$( function() {
		$( document ).on( 'widget-added widget-updated', function( e, data ) {
			$.opInitControls( data[0] );
		} );

		$( document ).on( 'change', '.widgets-sortables.ui-sortable .widget form', function() {
			var form        = $( this ),
				container   = form.closest( '.widget' ),
				hiddenField = $( '.op-encoded-options', container ),
				formData    = form.serializeForm();

			if ( hiddenField.length > 0 && formData['op-options'] !== undefined ) {
				hiddenField.val( JSON.stringify( formData['op-options'] ) );
			}
		} );
	} );

} ).call( this, jQuery );