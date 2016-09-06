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