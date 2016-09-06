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