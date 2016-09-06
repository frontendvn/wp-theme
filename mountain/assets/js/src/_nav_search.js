( function( $ ) {
	"use strict";

	var doc = $( document );
	
	function NavSearch( element ) {
		this.element = $( element );
		this.toggler = $( '> a:first-child', this.element );
		this.input   = $( 'input', this.element );

		doc.on( 'click', this.hide.bind( this ) );
		this.toggler.on( 'click', this.toggle.bind( this ) );
		this.element.on( 'click', function( e ) {
			e.stopPropagation();
		});
		this.element.on( 'keydown', ( function( e ) {
			if ( e.keyCode == 27 )
				this.hide();
		} ).bind( this ) );

		$.each( ['transitionend', 'oTransitionEnd', 'webkitTransitionEnd'], ( function( index, eventName ) {
			$( '> .submenu', this.element ).on( eventName, ( function() {
				if ( this.element.hasClass( 'active' ) )
					this.input.get( 0 ).focus();
			} ).bind( this ) );
		} ).bind( this ) );
	};

	NavSearch.prototype = {
		toggle: function( e ) {
			e.preventDefault();
			e.stopPropagation();

			this.element.toggleClass( 'active' );
		},

		hide: function() {
			this.element.removeClass( 'active' );
		}
	};

	$.fn.navSearch = function( options ) {
		return this.each( function() {
			$( this ).data( '_navSearch', new NavSearch( this, options ) );
		} );
	};
	
} ).call( this, jQuery );