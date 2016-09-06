( function( $ ) {
	"use strict";

	var api = wp.customize,
		doc = $(document);

	var WidgetLayout = ( function() {
		function WidgetLayout( element, options ) {
			var root = $( element );
			var initResize, doResize, getMaxWidth, getLayouts, serialize, parentWidth, stepWidth, increase, decrease, resizeHolder;
			var settingLink = root.attr('data-customizer-link');

			initResize = function(event, ui) {
				resizeHolder = $(event.srcElement);
				parentWidth = ui.element.parent().width();
				stepWidth = Math.floor(parentWidth / 12);
			};

			getMaxWidth = function(element) {
				var prevWidth = 0;
				
				element.prevAll().each(function() {
					prevWidth += parseInt($(this).attr('data-width'));
				});

				return (12 - prevWidth) - (element.nextAll().length * 2);
			};

			getLayouts = function() {
				var layout = [];

				$('.options-control-layouts > div', root).each(function() {
					var columns = [];

					$('.widgetslayout-column', this).each(function() {
						columns.push($(this).attr('data-width'));
					});

					layout.push(columns);
				});

				return layout;
			};

			decrease = function(element, width, invert) {
				var currentWidth = parseInt(element.attr('data-width')),
					isInvert = invert || false,
					newWidth = currentWidth - width;

				if (newWidth < 2) {
					decrease(isInvert ? element.prev() : element.next(), width, isInvert);
				}
				else {
					element.attr('data-width', newWidth);
					element.find('span').text(newWidth);
				}
			};

			increase = function(element, width) {
				var currentWidth = parseInt(element.attr('data-width')),
					newWidth = currentWidth + width;

				element.attr('data-width', newWidth);
				element.find('span').text(newWidth);
			};

			doResize = function(event, ui) {
				var newWidth = Math.round(ui.size.width / stepWidth),
					currentWidth = parseInt(ui.element.attr('data-width')),
					maxWidth = getMaxWidth(ui.element);

				if (newWidth < 2) newWidth = 2;
				if (newWidth > maxWidth) newWidth = maxWidth;

				if (newWidth > currentWidth)
					decrease(ui.element.next(), newWidth - currentWidth);
				else
					increase(ui.element.next(), currentWidth - newWidth);

				ui.element.attr('data-width', newWidth);
				ui.element.removeAttr('style');
				ui.element.find('span').text(newWidth);
			};

			serialize = function() {
				var data = {
					active: $('.options-control-inputs input[type="radio"]:checked', root).val(),
					layout: getLayouts()
				};

				$('input[type="hidden"]', root)
					.val(JSON.stringify(data))
					.trigger('change');
			};

			$('.options-control-inputs input[type="radio"]', root).on('change', function() {
				var index = $('.options-control-inputs input[type="radio"]:checked', root).val();

				$('.options-control-layouts > div', root).removeClass('active')
				$('.options-control-layouts > div:eq(' + index + ')', root).addClass('active');

				serialize();
			});

			$('.widgetslayout-column:not(:last-child)', root).resizable({
				handles: 'e',
				start: initResize,
				resize: doResize,
				stop: serialize
			});

			$('input[type="hidden"]', root).on('change', function() {
				if (wp.customize && settingLink)
					wp.customize.instance(settingLink).set(JSON.parse(this.value));
			});
		};

		return WidgetLayout;
	} )();

	$.fn.op_widgetLayout = function() {
		return this.each( function() {
			if ( $( this ).data( '_controlInstance' ) === undefined )
				$( this ).data( '_controlInstance', new WidgetLayout( this ) );
		} );
	};

} ).call( this, jQuery );