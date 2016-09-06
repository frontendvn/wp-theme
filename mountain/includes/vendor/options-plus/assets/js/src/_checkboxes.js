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