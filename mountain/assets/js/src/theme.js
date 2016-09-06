( function( $ ) {
	"use strict";
	
	var _initComponents = function( container ) {
		if ( $.fn.fitVids ) $( '.fitVids', container ).fitVids();
		if ( $.fn.flexslider ) {
			$( '.flexslider:not(.wpb_flexslider)', container ).each( function() {
				var slider = $( this ),
					config = {
						animation: 'slide',
						smoothHeight: true
					};

				try { config = $.extend( config, JSON.parse( '{' + slider.attr( 'data-slider-config' ) + '}' ) ); }
				catch( e ) {}

				slider.flexslider( config );
			} );
		}

		// Nivo Lightbox
		$( '.gallery.gallery-has-lightbox a', container ).nivoLightbox( {
			theme: 'default',
			effect: 'fade'
		} );

		// Related posts carousel
		$( '.box-related-posts.box-related-posts-carousel' ).each( function() {
			var root = $( this );

			$( '.box-content-wrap', root ).owlCarousel( {
				items: root.attr( 'data-columns' ) || 3,
				itemsDesktop: [991, root.attr( 'data-columns' ) || 3],
				itemsTablet: [990, 2],
				itemsMobile: [568,1],
				autoHeight: true,
				scrollPerPage: false,
				navigation: true
			} );
		} );

		// Initialize projects layout
		$( '.projects:not(.projects-justify)' ).projects();
		$( '.project-gallery.project-gallery-grid' ).projectGallery();

		$( '.projects.projects-justify > .projects-wrap > .projects-items' ).imagesLoaded( function() {
			$( '.projects.projects-justify > .projects-wrap > .projects-items' ).flexImages( {
				container: '.project',
				object: 'img',
				rowHeight: 360
			} );
		} );

		// Initialize project single
		$( '.project-single.project-content-left.project-content-sticky,\
			.project-single.project-content-right.project-content-sticky' ).sticky_content( {
			item: '.project-content',
			additionOffset: function() {
				return $( '#wpadminbar' ).height() + $( '#site-navigator.stick' ).height() + 20;
			}
		} );
	};

	$( function() {
		var body = $( 'body' );

		// Initialize header toggler
		$( '.header-v3 .menu-toggler a' ).on( 'click', function( e ) {
			e.stopPropagation();
			$( '#site-navigator' ).toggleClass( 'active' );
		} );

		// Initialize header sticky feature
		if ( _themeConfig.stickyHeader ) {
			var placeholder = $( '<div class="masthead-placeholder"/>' );

			$( window ).on( 'scroll', function() {
				if ( $( window ).scrollTop() > 0 ) {
					$( 'body' ).addClass( 'header-sticked' );
					$( '#masthead' ).after( placeholder );

					placeholder.height( $( '#masthead' ).height() );
				}
				else {
					$( 'body' ).removeClass( 'header-sticked' );
					placeholder.detach();
				}
			} );
		}

		// Collapsible menu for mobile views
		if ( _themeConfig.responsiveMenu ) {
			$('.navigator-mobile').menuCollapse();
		}

		// Modal content
		if ( _themeConfig.offCanvas ) {
			$( document ).on( 'click', '.navigator .off-canvas > a, .navigator-mobile .off-canvas > a', function( e ) {
				e.preventDefault();
				$( 'body' ).toggleClass( 'off-canvas-active' );
			} );

			$( document ).on( 'click', '#off-canvas .close', function( e ) {
				e.preventDefault();
				$( 'body' ).removeClass( 'off-canvas-active' );
			} );
		}

		// Onepage Navigator
		if ( _themeConfig.onepageNavigator ) {
			$( '#site-header .navigator a, #site-header .navigator-mobile a' ).contentReveal( {
				offset: $( '#wpadminbar' ).height(),
				complete: function( evt ) {
					$( window ).trigger( 'scroll' );
				}
			} );

			$( '#site-header .navigator, #site-header .navigator-mobile' ).navigatorSpy( {
				offset: $( '#masthead-sticky' ).height() + $( '#wpadminbar' ).height()
			} );
		}

		// Ajax pagination
		if ( _themeConfig.pagingStyle == 'loadmore' ) {
			$( '.navigation.paging-navigation.loadmore' ).pagination( {
				paginator: _themeConfig.pagingNavigator,
				container: _themeConfig.pagingContainer,
				infiniteScroll: false,
				success: function() {
					_initComponents( $( '#main-content > .main-content-wrap > .content-inner' ) );
				}
			} );
		}

		// Nivo Lightbox
		if ( $.fn.nivoLightbox ) {
			$( 'a[data-lightbox="nivoLightbox"]' ).nivoLightbox( {
				theme: 'default',
				effect: 'fade'
			} );
		}

		$( 'a.content-reveal' ).contentReveal();
		$( '.navigator .search-box' ).navSearch();

		body.imagesLoaded( function() {
			// Global components
			_initComponents( body );

			// Blog masonry layout
			if ( body.hasClass( 'blog-grid' ) ) {
				$( '.main-content-wrap' ).masonryLayout();
			}
		} );
	} );

	/**
	 * Initialize gotop button
	 *
	 * @return void
	 */
	$( function() {
		var gotop = $( '.goto-top' );

		$( 'body' ).imagesLoaded( function() {
			$.stellar({ horizontalScrolling: false });
		} );

		$( document ).on( 'woocommerce-cart-changed', function( e, data ) {
			if ( parseInt( data.items_count ) > 0 ) {
				$( '.shopping-cart-items-count' )
					.text( data.items_count )
					.removeClass( 'no-items' );
			}
			else {
				$( '.shopping-cart-items-count' )
					.empty()
					.addClass( 'no-items' );
			}
		} );

		// Goto Top button
		$( 'a', gotop ).on( 'click', function( e ) {
			e.preventDefault();

			$( 'html, body' ).animate( {
				scrollTop: 0
			} );
		} );

		$( window ).on( 'scroll', function() {
			if ( $( window ).scrollTop() > 0 ) $( '.goto-top' ).addClass( 'active' );
			else $( '.goto-top' ).removeClass( 'active' );
		} ).on( 'load', function() {
			$( window ).trigger( 'scroll' );
		} );
	} );
} ).call( this, jQuery );
