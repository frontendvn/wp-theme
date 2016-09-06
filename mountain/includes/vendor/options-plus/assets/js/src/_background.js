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