( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var MediaPicker = ( function() {
		function MediaPicker( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link'),
				input = root.find('input[type="hidden"]'),
				preview = root.find('.upload-preview');

			// Initialize the drag to upload plugin
			new wp.Uploader($.extend({
				container: root,
				browser:   root.find('.upload'),
				dropzone:  root.find('.upload-dropzone'),
				success:   function(attachment) {
					root.removeClass( 'has-error' );
					input.val(attachment.get('url'))
						.trigger('change');
				},
				error: function( message ) {
					root.addClass( 'has-error' );
					root.find( '.options-control-message' ).remove();
					root.find( '.options-control-inputs' ).append(
						$( '<p />', { 'class': 'options-control-message options-control-error' } ).text( message )
					);
				},
				progress: function( attachment ) {
					// console.log( attachment.get('percent') );
				},
				plupload:  {},
				params:    {}
			}, {} ));

			$('a.browse-media', root).on('click', function(e) {
				e.preventDefault();
				// Create media manager instance
				var mediaManager = wp.media.frames.file_frame = wp.media({
						title: 'Choose Image',
						button: { text: 'Choose Image' },
						multiple: false,
						library: {
							type: 'image'
						}
					});

				// Register select event to update value
				mediaManager.on('select', function() {
					var
					attachment = mediaManager.state().get('selection').first();
					input.val(attachment.get( 'url' ))
						.trigger('change');
				});

				mediaManager.open();
			});

			$('a.remove', root).on('click', function(e) {
				e.preventDefault();
				input.val('').trigger('change');
			});

			input.on('change', function() {
				preview.empty();

				if (this.value.trim() != '') {
					root.addClass('has-image');
					preview.append($('<img />', { src: this.value }));
				}
				else root.removeClass('has-image');

				if ( wp.customize && settingLink )
					wp.customize.instance(settingLink).set(this.value);
			}).trigger('change');
		};

		return MediaPicker;
	} )();

	$.fn.op_mediaPicker = function() {
		return this.each(function () {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new MediaPicker( this ) );
		});
	};

} ).call( this, jQuery );