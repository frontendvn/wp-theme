( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var ImagesGallery = ( function() {
		function ImagesGallery( element ) {
			this.root        = $( element );
			this.setting     = this.root.attr( 'data-customizer-link' );
			this.list        = this.root.find( '.images-list' );
			this.hiddenInput = this.root.find( 'input[type="hidden"]' );
			
			// Initialize sortable plugin
			this.list.sortable( {
				stop: this.change.bind( this ),
				change: this.change.bind( this )
			} );

			// Bind events
			this.root.on( 'click', '.button.button-add-images', this.browse.bind( this ) );
			this.root.on( 'click', '.button.button-remove', this.remove.bind( this ) );
			this.root.on( 'change', this.change.bind( this ) );

			// Restore existing data
			try { this.restore(); }
			catch( e ) { }
		};

		ImagesGallery.prototype = {
			restore: function() {
				var data = JSON.parse( this.hiddenInput.val() ),
					self = this;

				if ( $.isArray( data ) && data !== undefined ) {
					$.each( data, function() {
						self.add( this.id, this.sizes, false );
					} );
				}
			},

			add: function( id, sizes, trigger ) {
				var item = $( '\
					<li id="image-' + id + '" data-pid="' + id + '">\
						<div class="handle"></div>\
						<div class="thumbnail"><img src="' + sizes.thumbnail.url + '" /></div>\
						<div class="actions">\
							<button type="button" class="button button-remove">Remove</button>\
						</div>\
					</li>\
				').data( '_imageData', sizes );
				
				this.list.append( item );

				if ( trigger )
					this.root.trigger( 'change' );
			},

			remove: function( e ) {
				$( e.target ).closest( 'li[data-pid]' ).remove();
				this.root.trigger( 'change' );
			},

			browse: function() {
				var self = this;
				var media = wp.media.frames.file_frame = wp.media({
					title: 'Choose Image',
					button: { text: 'Choose Image' },
					library: {
						type: 'image'
					},
					multiple: true
				});

				media.on( 'select', function() {
					media.state().get('selection').forEach( function( value ) {
						self.add( value.get( 'id' ), value.get( 'sizes' ), true );
					} );
				} );

				media.open();
			},

			change: function() {
				var images = [];
				this.root.find( '.images-list > li[data-pid]' ).each( function() {
					images.push( {
						id: parseInt( $( this ).attr( 'data-pid' ) ),
						sizes: $( this ).data( '_imageData' )
					} );
				} );

				this.hiddenInput.val( JSON.stringify( images ) );
			}
		};

		return ImagesGallery;
	} )();

	$.fn.op_imagesGallery = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new ImagesGallery( this ) );
		} );
	};

} ).call( this, jQuery );