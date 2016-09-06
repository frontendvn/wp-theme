( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var MediaList = ( function() {
		function MediaList( element ) {
			this.root        = $( element );
			this.setting     = this.root.attr( 'data-customizer-link' );
			this.list        = this.root.find( '.media-items' );
			this.hiddenInput = this.root.find( 'input[type="hidden"]' );
			
			// Initialize sortable plugin
			this.list.sortable( {
				stop: this.change.bind( this ),
				change: this.change.bind( this )
			} );

			// Bind events
			this.root.on( 'click', '.add-image', this.browse.bind( this ) );
			this.root.on( 'click', '.add-video', this.addVideo.bind( this ) );
			this.root.on( 'click', '.button.button-remove', this.remove.bind( this ) );
			this.root.on( 'click', '.video-item .button.button-edit', this.editVideo.bind( this ) );
			this.root.on( 'change', this.change.bind( this ) );

			// Restore existing data
			try { this.restore(); }
			catch( e ) { }
		};

		MediaList.prototype = {
			browse: function( e ) {
				e.preventDefault();

				var self = this;
				var media = wp.media.frames.file_frame = wp.media( {
					title: 'Select Media Files',
					button: { text: 'Select Files' },
					library: { type: 'image' },
					multiple: true
	 			} );

				media.on( 'select', function() {
					media.state().get('selection').forEach( function( value ) {
						var thumbnail = {};

						$.map( value.get( 'sizes' ), function( value ) {
							if ( thumbnail.width === undefined || thumbnail.width > value.width )
								thumbnail = value;
						} );

						self.add( {
							id: value.get( 'id' ),
							thumbnail: thumbnail.url,
							type: 'image',
							caption: value.get( 'caption' ),
							description: value.get( 'description' )
						}, true );
					} );
				} );

				media.open();
			},

			restore: function() {
				var data = JSON.parse( this.hiddenInput.val() ),
					self = this;

				if ( $.isArray( data ) && data !== undefined ) {
					$.each( data, function() {
						self.add( this, false );
					} );
				}
			},

			add: function( item, trigger ) {
				var template = $( '\
					<li class="media-item ' + item.type + '-item">\
						<div class="handle"></div>\
						<div class="thumbnail"></div>\
						<div class="actions">\
							<button type="button" class="button button-edit">Edit</button>\
							<button type="button" class="button button-remove">Remove</button>\
						</div>\
					</li>\
				' );

				if ( item.thumbnail ) {
					template.removeClass( 'no-thumbnail' );
					template.find( '.thumbnail' ).append(
						$( '<img/>', { src: item.thumbnail } )
					);
				}
				else {
					template.addClass( 'no-thumbnail' );
				}
				
				template.data( '_itemData', item )
					.appendTo( this.list );

				if ( trigger )
					this.root.trigger( 'change' );
			},

			addVideo: function( e ) {
				e.preventDefault();

				var self = this;

				this._videoDialog( {}, function() {
					var data = $( this ).serializeForm(),
						options = data['op-options'];

					self.add( $.extend( {
						type: 'video',
						thumbnail: false
					}, options ), true );

					$( this ).dialog( 'close' );
				} );
			},

			editVideo: function( e ) {
				var self = this,
					item = $( e.target ).closest( '.media-item' ),
					data = item.data( '_itemData' );

				this._videoDialog( data, function() {
					var formData = $( this ).serializeForm();

					item.data( '_itemData', $.extend( data, formData['op-options'] ) );

					$( this ).dialog( 'close' );
					self.root.trigger( 'change' );
				} );
			},

			_videoDialog: function( data, callback ) {
				var
				self          = this,
				dialogButtons = [];
				dialogButtons.push( {
					'text': 'Save',
					'click': callback
				} );

				var
				dialogContent = $( $( '#_mediaListVideoSettings' ).html() );
				dialogContent.appendTo( $( 'body' ) );

				dialogContent.dialog( {
					dialogClass: 'op-dialog',

					draggable: false,
					resizable: false,
					modal: true,
					title: 'Insert Video',
					buttons: dialogButtons,
					
					open: function() {
						dialogContent.populate( {
							'op-options': data
						} );

						$.opInitControls( dialogContent );
					},
					close: function() {
						$( this ).dialog( 'destroy' ).remove();
					}
				} );
			},

			_videoOptions: function( form ) {
				var data = form.serializeForm(),
					options = data['op-options'];

				if ( options.cover === undefined )
					options.cover = { id: '', thumbnail: '' }
			},

			remove: function( e ) {
				$( e.target ).closest( '.media-item' ).remove();
				this.root.trigger( 'change' );
			},

			change: function() {
				var media = [];
				this.root.find( '.media-items > .media-item' ).each( function() {
					media.push( $( this ).data( '_itemData' ) );
				} );

				this.hiddenInput.val( JSON.stringify( media ) );
			}
		};

		return MediaList;
	} )();

	$.fn.op_mediaList = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new MediaList( this ) );
		} );
	};

} ).call( this, jQuery );