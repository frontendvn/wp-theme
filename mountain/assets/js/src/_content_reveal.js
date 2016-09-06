( function( $ ) {
	"use strict";

	var _defaults = {
		duration: 500,
		easing: 'swing',
		offset: 0,
		complete: function() {}
	};

	function ContentReveal( element, options ) {
		this.root = $( element );
		this.opts = $.extend( _defaults, options );

		if ( element.hash.length > 1 ) {
			var target = $( element.hash );

			if ( target.length > 0 ) {
				this.target = target;
				this.root.on( 'click', this.reveal.bind( this ) );
			}
		}
	};

	ContentReveal.prototype = {
		reveal: function( evt ) {
			evt.preventDefault();

			$("html, body").animate({
				scrollTop: this.target.offset().top - this.opts.offset
			}, 500, ( function( evt ) {
				if ( $.isFunction( this.opts.complete ) )
					this.opts.complete.call( this, evt );
			} ).bind( this ) );
		}
	};

	$.fn.contentReveal = function( options ) {
		return this.each( function() {
			$( this ).data( '_contentReveal', new ContentReveal( this, options ) );
		} );
	}

} ).call( this, jQuery );