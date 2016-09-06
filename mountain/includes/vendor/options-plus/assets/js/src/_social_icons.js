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