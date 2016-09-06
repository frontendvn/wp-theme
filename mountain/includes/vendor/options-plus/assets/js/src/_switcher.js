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