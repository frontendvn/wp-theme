( function( $ ) {
	"use strict";

	var _defaults = { speed: 4 },
		_win      = $( window );

	var requestAnimFrame = ( function() {
		return  window.requestAnimationFrame       ||
				window.webkitRequestAnimationFrame ||
				window.mozRequestAnimationFrame    ||
				function( callback ) {
					window.setTimeout( callback, 1000 / 60 );
				};
	} )();

	function Parallax( element, options ) {
		this.root = $( element );
		this.opts = $.extend( _defaults, options );

		if ( this.root.attr( 'data-parallax-speed' ) !== undefined )
			this.opts.speed = parseInt( this.root.attr( 'data-parallax-speed' ) );

		// Cache the Y offset and the speed of each sprite
		this.root.data( 'offsetY', parseInt( this.root.attr( 'data-parallax-y' ) ) );
		this.root.data( 'positionX', this.root.attr( 'data-parallax-x' ) );
		this.root.data( 'speed', this.root.attr('data-parallax-speed' ));
		this.rootOffset = this.root.offset();

		requestAnimFrame( this.update.bind( this ) );

		// _win.on( 'scroll', this.update.bind( this ) );
	};

	Parallax.prototype = {
		update: function() {
			// If this section is in view
			// if ( ( _win.scrollTop() + _win.height() ) > this.rootOffset.top &&
			// 	 ( ( this.rootOffset.top + this.root.height() ) > _win.scrollTop() ) ) {
	
				// Scroll the background at var speed
				// the yPos is a negative value because we're scrolling it UP!								
				var yPos = -( _win.scrollTop() / this.root.data( 'speed' ) ); 
				
				// If this element has a Y offset then add it on
				if ( this.root.data( 'offsetY' ) ) {
					yPos += this.root.data( 'offsetY' );
				}

				this.root.css( 'background-position', '50% '+ yPos + 'px' );
			// };

			requestAnimFrame( this.update.bind( this ) );
		}
	};

	$.fn.parallax = function( options ) {
		return this.each( function() {
			$( this ).data( '_parallax', new Parallax( this, options ) );
		} );
	}

} ).call( this, jQuery );