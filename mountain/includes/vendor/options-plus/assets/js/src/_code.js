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