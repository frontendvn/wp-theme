( function( $ ) {
	"use strict";

	function MenuCollapse(element) {
		this.element   = $(element);
		this.menuItems = $('.menu-item-has-children > a', this.element);

		// Append the toggler for menu items
		this.menuItems.after(
			$('<span class="toggler" />')
		);

		this.element.on('click', '> .navigator-toggle', this.toggle.bind(this));
		this.element.on('click', '.menu-item-has-children > .toggler', this.toggleItem.bind(this));
	};

	MenuCollapse.prototype = {
		toggle: function(e) {
			e.preventDefault();
			this.element.toggleClass('active');
		},

		toggleItem: function(e) {
			e.preventDefault();
			$(e.target).closest('li').toggleClass('active');
		}
	};

	$.fn.menuCollapse = function() {
		return this.each( function() {
			$( this ).data( '_menuCollapse', new MenuCollapse( this ) );
		} );
	};

} ).call( this, jQuery );