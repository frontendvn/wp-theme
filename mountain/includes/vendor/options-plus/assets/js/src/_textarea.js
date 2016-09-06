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