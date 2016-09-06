( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var Typography = ( function() {
		function Typography( element, options ) {
			var root = $( element ),
				settingLink = root.attr('data-customizer-link');

			root.find('.typography-font select').chosen({
				disable_search_threshold: 10,
				width: "100%"
			});

			root.find('.typography-font select').on('change', function() {
				var variants = $('option:selected', this).attr('data-variants'),
					fontWeight = root.find('.typography-style select'),
					currentVariant = fontWeight.val();

				fontWeight.empty();

				if (variants !== undefined) {
					$.each(variants.split(','), function(index, value) {
						value = value.trim();
						fontWeight.append($('<option />', { value: value }).text(
							_opFontWeights[value] !== undefined ? _opFontWeights[value] : value
						));
					});
				}

				fontWeight.val(currentVariant)
					.trigger('change');
			}).trigger('change');

			root.on('change', 'select, input', function() {
				if (wp.customize && settingLink) {
					wp.customize.instance(settingLink).set({
						family: root.find('.typography-font select').val(),
						size: root.find('.typography-size input').val(),
						line_height: root.find('.typography-line-height input').val(),
						style: root.find('.typography-style select').val(),
						color: root.find('.typography-color input').val()
					});
				}
			});
		};

		return Typography;
	} )();

	$.fn.op_typography = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new Typography( this ) );
		} );
	};

} ).call( this, jQuery );