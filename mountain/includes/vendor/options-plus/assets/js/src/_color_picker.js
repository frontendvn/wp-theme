( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var ColorPicker = ( function() {
		function ColorPicker( element, options ) {
			var elm         = $( element ),
				input       = $( 'input', element ),
				preview     = $( 'button', element ),
				settingLink = elm.attr( 'data-customizer-link' ),
				panel       = $( '.colorpicker-panel', elm );

			panel.colpick( {
				flat: true,
				layout: 'hex',
				submit: false,
				color: input.val().substring( 1 ),
				height: 185,

				onChange: function( hsb, hex, rgb, el, bySetColor ) {
					if ( ! bySetColor )
						input.val( '#' + hex )
							.trigger( 'change' );
				}
			});

			preview.on('click', function(e) {
				elm.toggleClass('active');
			});
			elm.find('.colorpicker-panel, button').on('click', function(e) {
				e.stopPropagation();
			});
			doc.on('click', function() {
				elm.removeClass('active');
			});

			input.on('keyup', function() { input.trigger('change'); });
			input.on('change', function() {
				preview.css('background-color', this.value);
				panel.colpickSetColor(this.value);
				
				if ( wp.customize && settingLink )
					wp.customize.instance(settingLink).set(this.value);
			});
		};

		return ColorPicker;
	} )();

	$.fn.op_colorPicker = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new ColorPicker( this ) );
		} );
	};

} ).call( this, jQuery );