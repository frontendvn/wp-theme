( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var ImagePicker = ( function() {
		function ImagePicker( element ) {
			var self = this;

			this.root           = $( element );
			this.settingLink    = this.root.attr( 'data-customizer-link' );
			this.idInput        = $( 'input[data-property="id"]', this.root );
			this.thumbnailInput = $( 'input[data-property="thumbnail"]', this.root );
			this.preview        = $( '.upload-preview', this.root );
			this.selected       = {
				id: this.idInput.val(),
				thumbnail: this.thumbnailInput.val()
			};

			$( 'a.browse-media', this.root ).on( 'click', this.browse.bind( this ) );
			$( 'a.remove', this.root ).on('click', this.remove.bind( this ) );

			this.thumbnailInput.on( 'change', ( function() {
				this.preview.empty();

				if ( this.selected.thumbnail != '' ) {
					this.root.addClass( 'has-image' );
					this.preview.append( $( '<img />', { src: this.selected.thumbnail } ) );
				}
				else {
					this.root.removeClass( 'has-image' );
				}

				if ( wp.customize && settingLink )
					wp.customize.instance( this.settingLink ).set( this.selected );
			} ).bind( this ) ).trigger( 'change' );
		};

		ImagePicker.prototype = {
			initUploader: function() {
				var self = this;
				var root = this.root;

				// Initialize the drag to upload plugin
				new wp.Uploader($.extend({
					container: root,
					browser:   root.find( '.upload' ),
					dropzone:  root.find( '.upload-dropzone' ),
					success:   function( attachment ) {
						root.removeClass( 'has-error' );
						self.select( attachment );
					},
					error: function( message ) {
						root.addClass( 'has-error' );
						root.find( '.options-control-message' ).remove();
						root.find( '.options-control-inputs' ).append(
							$( '<p />', { 'class': 'options-control-message options-control-error' } ).text( message )
						);
					},
					progress: function( attachment ) {},
					plupload:  {},
					params:    {}
				}, {} ));
			},

			browse: function( e ) {
				var self = this, mediaManager;

				e.preventDefault();

				// Create media manager instance
				mediaManager = wp.media.frames.file_frame = wp.media({
					title: 'Choose Image',
					button: { text: 'Choose Image' },
					multiple: false,
					library: { type: 'image' }
				});

				// Register select event to update value
				mediaManager.on('select', function() {
					var
					attachment = mediaManager.state().get('selection').first();
					self.select( attachment );
				});

				mediaManager.open();
			},

			select: function( attachment ) {
				var thumbnail = {};

				// Find the smallest thumbnail
				$.map( attachment.get( 'sizes' ), function( value ) {
					if ( thumbnail.width === undefined || thumbnail.width > value.width )
						thumbnail = value;
				} );

				this.selected = { id: attachment.get( 'id' ), thumbnail: thumbnail.url };
				this.idInput.val( this.selected.id ).trigger( 'change' );
				console.log( this.idInput.val() );
				this.thumbnailInput.val( this.selected.thumbnail ).trigger( 'change' );
			},

			remove: function( e ) {
				e.preventDefault();

				this.selected = { id: '', thumbnail: '' };
				this.idInput.val( '' ).trigger( 'change' );
				this.thumbnailInput.val( '' ).trigger( 'change' );
			}
		};

		return ImagePicker;
	} )();

	$.fn.op_imagePicker = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new ImagePicker( this ) );
		} );
	};

} ).call( this, jQuery );