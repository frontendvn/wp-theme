( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var MediaInput = ( function() {
		function MediaInput( element ) {
			this.root    = $( element );
			this.setting = this.root.attr( 'data-customizer-link' );
			this.button  = this.root.find( 'button' );
			this.library = this.root.find( '.options-control-inputs' ).attr( 'data-library' ) || '';

			this.button.on( 'click', this.browse.bind( this ) );
		};

		MediaInput.prototype = {
			browse: function() {
				var input = this.root.find( 'input[type="text"]' );
				var mediaManager = wp.media.frames.file_frame = wp.media({
					title: 'Choose Video',
					button: { text: 'Choose Video' },
					multiple: false,
					library: { type: this.library }
				});

				// Register select event to update value
				mediaManager.on('select', function() {
					var
					attachment = mediaManager.state().get('selection').first().toJSON();
					input.val(attachment.url)
						.trigger('change');
				});

				mediaManager.open();
			}
		};

		return MediaInput;
	} )();

	$.fn.op_mediaInput = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new MediaInput( this ) );
		} );
	};

} ).call( this, jQuery );