/* global Modernizr */

// config
require.config( {
	paths: {
		jquery:              'assets/js/fix.jquery',
		underscore:          'assets/js/fix.underscore',
		bootstrapAffix:      'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/affix',
		bootstrapAlert:      'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/alert',
		bootstrapButton:     'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/button',
		bootstrapCarousel:   'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/carousel',
		bootstrapCollapse:   'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/collapse',
		bootstrapDropdown:   'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/dropdown',
		bootstrapModal:      'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/modal',
		bootstrapPopover:    'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/popover',
		bootstrapScrollspy:  'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/scrollspy',
		bootstrapTab:        'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/tab',
		bootstrapTooltip:    'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/tooltip',
		bootstrapTransition: 'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap/transition',
	},
	shim: {
		bootstrapAffix: {
			deps: [
				'jquery'
			]
		},
		bootstrapAlert: {
			deps: [
				'jquery'
			]
		},
		bootstrapButton: {
			deps: [
				'jquery'
			]
		},
		bootstrapCarousel: {
			deps: [
				'jquery'
			]
		},
		bootstrapCollapse: {
			deps: [
				'jquery',
				'bootstrapTransition'
			]
		},
		bootstrapDropdown: {
			deps: [
				'jquery'
			]
		},
		bootstrapPopover: {
			deps: [
				'jquery'
			]
		},
		bootstrapScrollspy: {
			deps: [
				'jquery'
			]
		},
		bootstrapTab: {
			deps: [
				'jquery'
			]
		},
		bootstrapTooltip: {
			deps: [
				'jquery'
			]
		},
		bootstrapTransition: {
			deps: [
				'jquery'
			]
		},
		jqueryVimeoEmbed: {
			deps: [
				'jquery'
			]
		}
	}
} );

require.config( {
	baseUrl: CargoPressVars.pathToTheme
} );

require( [
		'jquery',
		'underscore',
		'assets/js/SimpleMap',
		'vendor/proteusthemes/proteuswidgets/assets/js/NumberCounter',
		'assets/js/WidgetLine',
		'assets/js/StickyNavbar',
		'assets/js/TouchDropdown',
		'bootstrapCarousel',
		'bootstrapCollapse',
		'bootstrapTooltip',
], function ( $, _, SimpleMap, NumberCounter, WidgetLine ) {
	'use strict';

	/**
	 * remove the attributes and classes from collapsible navbar when the window is resized
	 */
	$( window ).on( 'resize', _.debounce( function () {
		if ( Modernizr.mq( '(min-width: 992px)' ) ) {
			$( '#cargopress-navbar-collapse' )
				.removeAttr( 'style' )
				.removeClass( 'in' );
		}
	}, 500 ) );

	/**
	 * Maps
	 */
	$( '.js-where-we-are' ).each( function () {
		new SimpleMap( $( this ), {
			latLng:  $( this ).data( 'latlng' ),
			markers: $( this ).data( 'markers' ),
			zoom:    $( this ).data( 'zoom' ),
			type:    $( this ).data( 'type' ),
			styles:  $( this ).data( 'style' ),
		}).renderMap();
	} );

	/**
	 * Footer widgets fix
	 */
	$( '.col-md-__col-num__' ).removeClass( 'col-md-__col-num__' ).addClass( 'col-md-3' );


	/**
	 * Number Counter Widget JS code
	 */
	// Get all number counter widgets
	var $counterWidgets = $( '.widget-number-counters' );

	if ( $counterWidgets.length ) {

		// jQuery easing function: easeInOutQuad, for use in NumberCounter
		$.extend( $.easing, {
			easeInOutQuad: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) {
					return c/2*t*t + b;
				}
				return -c/2 * ((--t)*(t-2) - 1) + b;
			}
		});

		$counterWidgets.each( function () {
			new NumberCounter( $( this ) );
		} );
	}


	/**
	 * Widget lines, the length is relative to the amount of text
	 */
	$( '.widget-title--big .widget-title' ).each( function () {
		new WidgetLine( $( this ) );
	} );


	/**
	 * Menu height on large screens, break point
	 */
	(function () {
		$( 'head' ).append( '<style type="text/css" id="main-nav-css"></style>' );

		var $menu = $( '.js-main-nav' ),
			$css = $( '#main-nav-css' );

		if ( ! $menu || ! $css ) {
			return;
		}

		var isMultilineMenu = function () {
			return $menu.height() > 45;
		};

		var updateMenuStyle = function () {
			if ( Modernizr.mq( '(min-width: 1200px)' ) && isMultilineMenu() ) {
				var lines = Math.round( $menu.height() / 60 );
				$css.text( '@media (min-width: 1200px) { .header__container::before { bottom: ' + (lines * 60 - 30) + 'px; } .header__container::after { bottom: ' + (lines * 60 ) + 'px; } }' );
			}
			else if ( Modernizr.mq( '(min-width: 992px)' ) && isMultilineMenu() ) {
				$css.text( '@media (min-width: 992px) { .header__container::before, .header__container::after { bottom: ' + $menu.height() + 'px; } }' );
			}
			else {
				$css.text( '' );
			}
		};

		updateMenuStyle();
		$( window ).on( 'resize', _.debounce( updateMenuStyle, 250 ) );
		$( window ).on( 'load', updateMenuStyle );
	})();

} );