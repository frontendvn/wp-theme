( function( $ ) {
	"use strict";

	$.fn['projects'] = function() {
		return this.each( function( index, container ) {
			$( '> .projects-wrap > .projects-items', container ).imagesLoaded( function() {
				$( '> .projects-wrap > .projects-items', container ).isotope( {
					layoutMode: 'packery',
					itemSelector: '.project',
					percentPosition: true
				} );

				$( '> .projects-wrap > .projects-filter li[data-filter] a', container ).on( 'click', function( e ) {
					e.preventDefault();

					$( '> .projects-wrap > .projects-filter li', container ).removeClass( 'active' );
					$( '> .projects-wrap > .projects-items', container ).isotope( {
						filter: $( this ).parent().attr( 'data-filter' )
					} );

					$( this ).parent().addClass( 'active' );
				} );

				$( '.projects-filter-toggler', container ).on( 'click', function( e ) {
					$( '.projects-filter', container ).toggleClass( 'active' );
				} );

				$( '.project', container ).waypoint( function() {
					var maxDuration  = 0.7;
					var minDuration  = 0.4;
					var randDuration = ( Math.random() * ( maxDuration - minDuration ) + minDuration ) + 's';

					$( '> .project-wrap', this )
						.css( 'transition-duration', randDuration )
						.addClass( 'animate' );
				}, {
					offset: '85%'
				} );
			} );
		} );
	};

	$.fn['projectGallery'] = function() {
		return this.each( function( index, container ) {
			$( '.project-gallery-wrap', container ).imagesLoaded( function() {
				$( '> .project-gallery-wrap', container ).isotope( {
					layoutMode: 'packery',
					itemSelector: '.project-media-item',
					percentPosition: true
				} );
			} );
		} );
	};

} )( jQuery );
