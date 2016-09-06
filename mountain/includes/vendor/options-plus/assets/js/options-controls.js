( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Background = ( function() {
		function Background( element, options ) {
			var root = $( element ),
				settingLink = root.attr( 'data-customizer-link' );

			if ( wp.customize && settingLink ) {
				root.on( 'change', 'input', function() {
					wp.customize.instance( settingLink ).set( {
						color: root.find( '.background-color input' ).val(),
						type: root.find( '.background-type input:checked' ).val(),
						pattern: root.find( '.background-patterns input:checked' ).val(),
						image: root.find( '.background-image input' ).val(),
						repeat: root.find( '.background-repeat input:checked' ).val(),
						position: root.find( '.background-position input:checked' ).val(),
						style: root.find( '.background-style input:checked' ).val()
					} );
				} )
			}

			$('.background-type input[type="radio"]', root).on('change', function() {
				var id = $('.background-type input[type="radio"]:checked', root).val();
				var panel = $('.background-' + id, root);

				$('.background-patterns, .background-custom', root).removeClass('active');
				$('.background-' + id, root).addClass('active');
			});
		};

		return Background;
	} )();

	$.fn.op_background = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Background( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Checkboxes = ( function() {
		function Checkboxes( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			root.on('change', 'input[type="checkbox"]', function() {
				if (wp.customize && settingLink) {
					var checked = [];
					root.find('input[type="checkbox"]:checked').each( function() {
						checked.push( this.value );
					} );

					wp.customize.instance(settingLink).set( checked );
				}
			});
		};

		return Checkboxes;
	} )();

	$.fn.op_checkboxes = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Checkboxes( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var ColorPicker = ( function() {
		function ColorPicker( element, options ) {
			var elm         = $( element ),
				input       = $( 'input', element ),
				preview     = $( 'button', element ),
				settingLink = elm.attr( 'data-customizer-link' ),
				panel       = $( '.colorpicker-panel', elm );

			panel.colpick( {
				flat: true,
				layout: 'hex',
				submit: false,
				color: input.val().substring( 1 ),
				height: 185,

				onChange: function( hsb, hex, rgb, el, bySetColor ) {
					if ( ! bySetColor )
						input.val( '#' + hex )
							.trigger( 'change' );
				}
			});

			preview.on('click', function(e) {
				elm.toggleClass('active');
			});
			elm.find('.colorpicker-panel, button').on('click', function(e) {
				e.stopPropagation();
			});
			doc.on('click', function() {
				elm.removeClass('active');
			});

			input.on('keyup', function() { input.trigger('change'); });
			input.on('change', function() {
				preview.css('background-color', this.value);
				panel.colpickSetColor(this.value);
				
				if ( wp.customize && settingLink )
					wp.customize.instance(settingLink).set(this.value);
			});
		};

		return ColorPicker;
	} )();

	$.fn.op_colorPicker = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new ColorPicker( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Dimension = ( function() {
		function Dimension( element, options ) {
			var root = $( element ),
				inputs = $( 'input[type="text"]', root ),
				settingLink = root.attr( 'data-customizer-link' );

			inputs.on( 'keyup', function() {
				var values = [];
				
				inputs.each( function() {
					values.push( this.value );
				} );

				if ( wp.customize && settingLink )
					wp.customize.instance( settingLink ).set( values );
			} );
		};

		return Dimension;
	} )();
	
	$.fn.op_dimension = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Dimension( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Dropdown = ( function() {
		function Dropdown( element, options ) {
			var root = $( element ),
				select = $( 'select', root ),
				preview = $( '.options-control-preview', root ),
				settingLink = root.attr( 'data-customizer-link' );

			preview.text( $( 'option:selected', select ).text() );
			select.on( 'change', function() {
				preview.text( $( 'option:selected', this ).text() );

				if ( wp.customize && settingLink )
					wp.customize.instance( settingLink ).set( select.val() );
			});
		};

		return Dropdown;
	} )();

	$.fn.op_dropdown = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Dropdown( this ) );
		} );
	};

} ).call( this, jQuery );

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

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Radio = ( function() {
		function Radio( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			root.on('change', 'input[type="radio"]', function() {
				if (wp.customize && settingLink)
					wp.customize.instance(settingLink).set(
						root.find('input[type="radio"]:checked').val()
					);
			});
		};

		return Radio;
	} )();

	$.fn.op_radio = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Radio( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var SocialIcons = ( function() {
		function SocialIcons( element, options ) {
			var root = $( element ),
				list = $( '.icons', root ),
				properties  = $( '.item-properties', root ),
				settingLink = root.attr( 'data-customizer-link' ),
				hiddenInput = $( 'input[type="hidden"]', root );

			var columnIndex = function( li ) {
				var index = li.prevAll( '.item' ).length + 1;
				while( index > 5 ) index = index - 5;
				return index;
			};

			var updateOption = function() {
				var ordering = [],
					icons = {};

				list.find( '> li[data-id]' ).each( function() {
					ordering.push( $( this ).attr( 'data-id' ) );

					if ( $( this ).attr( 'data-link' ) !== undefined )
						icons[$( this ).attr( 'data-id' )] = $( this ).attr( 'data-link' );
				});

				icons['__icons_ordering__'] = ordering;
				hiddenInput.val( JSON.stringify( icons ) );

				if ( wp.customize && settingLink )
					wp.customize.instance( settingLink ).set( icons );
			};

			var toggleEdit = function() {
				var li = $( this ),
					liIndex = columnIndex( li ),
					liNextItems = li.nextAll( '.item' ),
					liIndexRemain = 5 - liIndex,
					rightItems = $.makeArray( liNextItems ).slice( 0, liIndexRemain );

				if ( li.hasClass( 'active' ) ) {
					confirmChange();
					return;
				}

				list.sortable( 'disable' );
				list.addClass( 'active-properties' );
				list.children().removeClass( 'active' );
				li.addClass( 'active' );

				if ( rightItems.length == 0 ) li.after( properties );
				else $( rightItems.pop() ).after( properties );

				properties.find( '.input-title' ).text( li.attr( 'data-title' ) );
				properties.find( '.input-field' ).val( li.attr( 'data-link' ) );
				properties.find( '.input-field' ).get( 0 ).focus();
			};

			var cancelEdit = function() {
				list.sortable( 'enable' );
				list.removeClass( 'active-properties' );
				list.children().removeClass( 'active' );
			};

			var confirmChange = function() {
				if ( properties.find( '.input-field' ).val().trim() != '' )
					list.find( 'li.active' ).attr( 'data-link', properties.find( '.input-field' ).val() );
				else
					list.find( 'li.active' ).removeAttr( 'data-link' );
				
				updateOption();
				cancelEdit();
			};

			properties.on( 'click', 'button.cancel', cancelEdit );
			properties.on( 'click', 'button.confirm', confirmChange );

			properties.on( 'keydown', 'input.input-field', function(e) {
				if ( e.keyCode == 13 ) {
					e.preventDefault();
					confirmChange();
				}

				if ( e.keyCode == 27 ) {
					e.preventDefault();
					cancelEdit();
				}
			} );

			list.on( 'click', 'li.item', toggleEdit );
			list.sortable( {
				items: 'li',
				stop: updateOption
			} );
		};

		return SocialIcons;
	} )();

	$.fn.op_socialIcons = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new SocialIcons( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Spinner = ( function() {
		function Spinner( element ) {
			this.root    = $( element );
			this.setting = this.root.attr( 'data-customizer-link' );
			this.field   = this.root.find( 'input[type="text"]' );

			// Initialize spinner ui
			this.field.spinner( {
				min: this.field.attr( 'data-min' ) || 0,
				max: this.field.attr( 'data-max' ) || 99999999,
				stop: this.stop.bind( this )
			} );
		};

		Spinner.prototype = {
			stop: function( event, ui ) {
				if ( wp.customize && this.setting ) {
					wp.customize.instance( this.setting ).set( this.field.val() );
				}
			}
		};

		return Spinner;
	} )();

	$.fn.op_spinner = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Spinner( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Switcher = ( function() {
		function Switcher( element, options ) {
			var root = $( element ),
				input = $( 'input[type="checkbox"]', element ),
				settingLink = root.attr( 'data-customizer-link' );

			input.on( 'change', function() {
				if ( this.checked )
					root.addClass( 'active' );
				else
					root.removeClass( 'active' );

				if ( wp.customize && settingLink )
					wp.customize.instance( settingLink ).set( this.checked );
			} );
		};

		return Switcher;
	} )();

	$.fn.op_switcher = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Switcher( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Textarea = ( function() {
		function Textarea( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			root.find('textarea, input[type="text"]')
				.on('keyup', function() {
					$(this).trigger('change');
				})
				.on('change', function() {
					if (wp.customize && settingLink)
						wp.customize.instance(settingLink).set($(this).val());
				});
		};

		return Textarea;
	} )();

	$.fn.op_textarea = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Textarea( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Typography = ( function() {
		function Typography( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			root.find('.typography-font select').chosen({
				disable_search_threshold: 10,
				width: "100%"
			});

			root.find('.typography-font select').on('change', function() {
				var variants = $('option:selected', this).attr('data-variants'),
					fontWeight = root.find('.typography-style select'),
					currentVariant = fontWeight.val();

				fontWeight.empty();

				if (variants !== undefined) {
					$.each(variants.split(','), function(index, value) {
						value = value.trim();
						fontWeight.append($('<option />', { value: value }).text(
							_opFontWeights[value] !== undefined ? _opFontWeights[value] : value
						));
					});
				}

				fontWeight.val(currentVariant)
					.trigger('change');
			}).trigger('change');

			root.on('change', 'select, input', function() {
				if (wp.customize && settingLink) {
					wp.customize.instance(settingLink).set({
						family: root.find('.typography-font select').val(),
						size: root.find('.typography-size input').val(),
						line_height: root.find('.typography-line-height input').val(),
						style: root.find('.typography-style select').val(),
						color: root.find('.typography-color input').val()
					});
				}
			});
		};

		return Typography;
	} )();

	$.fn.op_typography = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Typography( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var WidgetLayout = ( function() {
		function WidgetLayout( element, options ) {
			var root = $( element );
			var initResize, doResize, getMaxWidth, getLayouts, serialize, parentWidth, stepWidth, increase, decrease, resizeHolder;
			var settingLink = root.attr('data-customizer-link');

			initResize = function(event, ui) {
				resizeHolder = $(event.srcElement);
				parentWidth = ui.element.parent().width();
				stepWidth = Math.floor(parentWidth / 12);
			};

			getMaxWidth = function(element) {
				var prevWidth = 0;
				
				element.prevAll().each(function() {
					prevWidth += parseInt($(this).attr('data-width'));
				});

				return (12 - prevWidth) - (element.nextAll().length * 2);
			};

			getLayouts = function() {
				var layout = [];

				$('.options-control-layouts > div', root).each(function() {
					var columns = [];

					$('.widgetslayout-column', this).each(function() {
						columns.push($(this).attr('data-width'));
					});

					layout.push(columns);
				});

				return layout;
			};

			decrease = function(element, width, invert) {
				var currentWidth = parseInt(element.attr('data-width')),
					isInvert = invert || false,
					newWidth = currentWidth - width;

				if (newWidth < 2) {
					decrease(isInvert ? element.prev() : element.next(), width, isInvert);
				}
				else {
					element.attr('data-width', newWidth);
					element.find('span').text(newWidth);
				}
			};

			increase = function(element, width) {
				var currentWidth = parseInt(element.attr('data-width')),
					newWidth = currentWidth + width;

				element.attr('data-width', newWidth);
				element.find('span').text(newWidth);
			};

			doResize = function(event, ui) {
				var newWidth = Math.round(ui.size.width / stepWidth),
					currentWidth = parseInt(ui.element.attr('data-width')),
					maxWidth = getMaxWidth(ui.element);

				if (newWidth < 2) newWidth = 2;
				if (newWidth > maxWidth) newWidth = maxWidth;

				if (newWidth > currentWidth)
					decrease(ui.element.next(), newWidth - currentWidth);
				else
					increase(ui.element.next(), currentWidth - newWidth);

				ui.element.attr('data-width', newWidth);
				ui.element.removeAttr('style');
				ui.element.find('span').text(newWidth);
			};

			serialize = function() {
				var data = {
					active: $('.options-control-inputs input[type="radio"]:checked', root).val(),
					layout: getLayouts()
				};

				$('input[type="hidden"]', root)
					.val(JSON.stringify(data))
					.trigger('change');
			};

			$('.options-control-inputs input[type="radio"]', root).on('change', function() {
				var index = $('.options-control-inputs input[type="radio"]:checked', root).val();

				$('.options-control-layouts > div', root).removeClass('active')
				$('.options-control-layouts > div:eq(' + index + ')', root).addClass('active');

				serialize();
			});

			$('.widgetslayout-column:not(:last-child)', root).resizable({
				handles: 'e',
				start: initResize,
				resize: doResize,
				stop: serialize
			});

			$('input[type="hidden"]', root).on('change', function() {
				if (wp.customize && settingLink)
					wp.customize.instance(settingLink).set(JSON.parse(this.value));
			});
		};

		return WidgetLayout;
	} )();

	$.fn.op_widgetLayout = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new WidgetLayout( this ) );
		} );
	};

} ).call( this, jQuery );

( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Code = ( function() {
		function Code( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			this.textarea = root.find( 'textarea' );
			this.editor = CodeMirror.fromTextArea( this.textarea.get( 0 ), {
				lineNumbers: true,
				mode: this.textarea.attr( 'data-mode' )
			} );
		};

		return Code;
	} )();

	$.fn.op_code = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Code( this ) );
		} );
	};

} ).call( this, jQuery );

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