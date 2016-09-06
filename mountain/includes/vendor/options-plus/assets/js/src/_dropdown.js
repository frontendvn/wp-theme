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