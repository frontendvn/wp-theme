( function( $ ) {
	"use strict";

	function MasonryLayout( element ) {
		this.container = $( element );
		this.gridContainer = $( '.content-inner', element );

		this.container.on( 'content-appended', ( function( e, data ) {
			data.items.imagesLoaded( ( function() {
				this.gridContainer.masonry( 'layout' );
				// var frames = data.items.find( 'iframe' );
				// var frameLoaded = 0;
				
				// frames.on( 'load', ( function() {
				// 	frameLoaded++;

				// 	if ( frameLoaded == frames.length ) {
						
				// 	}
				// } ).bind( this ) );

				data.items.css( 'visibility', 'visible' );
				this.gridContainer.masonry( 'appended', data.items );
			} ).bind( this ) );
		} ).bind( this ) );

		setTimeout( ( function() {
			this.gridContainer.masonry( {
				itemSelector: '.hentry'
			} );
		} ).bind( this ), 500 );
		
		$( window ).smartresize( this.update.bind( this ) );
	};

	MasonryLayout.prototype = {
		update: function() {
			this.gridContainer.masonry( 'layout' );
		}
	}

	$.fn.masonryLayout = function( options ) {
		return this.each( function() {
			$( this ).data( '_masonryLayout', new MasonryLayout( this, options ) );
		} );
	};

} ).call( this, jQuery );
