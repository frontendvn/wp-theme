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