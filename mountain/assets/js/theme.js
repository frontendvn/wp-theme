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
( function( $ ) {
	"use strict";

	var win = $( window );

	/**
	 * This class will be used for handle
	 * the sticky content
	 */
	var StickyContent = function( container, options ) {
		this.container = $( container );
		this.options = $.extend( {
				item: '.sticky-content',
				additionOffset: 0
			}, options );

		this.content = $( this.options.item, container );

		/**
		 * This function will update the position
		 * of content element
		 * 
		 * @return  void
		 */
		this.update  = function() {
			var winScrollTop = win.scrollTop(),
				winScrollBottom = win.scrollTop() + win.height();

			var containerOffset = this.container.offset(),
				contentOffset = this.content.offset();

			containerOffset.bottom = containerOffset.top + this.container.height();
			contentOffset.bottom = contentOffset.top + this.content.height();

			if ( $.isFunction( this.options.additionOffset ) )
				winScrollTop += this.options.additionOffset.call( this );
			else if ( $.isNumeric( this.options.additionOffset ) )
				winScrollTop += this.options.additionOffset;

			// Initial layout style
			this.container.css( 'position', 'relative' );
			this.content.css( 'position', 'relative' );

			// Stick content to top
			if ( this.content.height() < win.height() ) {
				var top = winScrollTop - containerOffset.top,
					maxTop = this.container.height() - this.content.height();

				if ( top > maxTop )
					top = this.container.height() - this.content.height();
				else if ( top < 0 )
					top = 0;

				this.content.css( 'top', top );
			}

			// Stick content to bottom
			else {
				if ( winScrollBottom > contentOffset.bottom && winScrollBottom < containerOffset.bottom )
					this.content.css( 'top', winScrollBottom - containerOffset.top - this.content.height() );
				else if ( winScrollTop < contentOffset.top && winScrollTop > containerOffset.top )
					this.content.css( 'top', winScrollTop - containerOffset.top );
				else if ( winScrollBottom > containerOffset.bottom )
					this.content.css( 'top', this.container.height() - this.content.height() );
				else if ( winScrollTop < containerOffset.top )
					this.content.css( 'top', 0 );
			}
		};

		/**
		 * Register event to update element
		 * position
		 */
		win.on( 'load resize scroll', this.update.bind( this ) );
	};

	$.fn['sticky_content'] = function( options ) {
		return this.each( function( index, container ) {
			console.log( $( container ).data( '_stickyContentInstance' ) );
			if ( $( container ).data( '_stickyContentInstance' ) === undefined )
				$( container ).data( '_stickyContentInstance', new StickyContent( container, options ) );
		} );
	};

} )( jQuery );

( function( $ ) {
	"use strict";
	
	/**
	 * debouncing function from John Hann
	 * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	 */
	var debounce = function (func, threshold, execAsap) {
		var timeout;

		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap)
					func.apply(obj, args);
				timeout = null;
			};

			if (timeout)
				clearTimeout(timeout);
			else if (execAsap)
				func.apply(obj, args);

			timeout = setTimeout(delayed, threshold || 100);
		};
	};

	/**
	 * Register smartresize plugin
	 */
	$.fn['smartresize'] = function(fn){
		return fn ? this.bind('resize', debounce(fn)) : this.trigger('smartresize');
	};
} ).call( this, jQuery );
( function( $ ) {
	"use strict";

	var _defaults = {},
		_win = $( window ),
		_doc = $( document );

	var _targets = {};

	function NavigatorSpy( element, options ) {
		this.root    = $( element );
		this.opts    = $.extend( _defaults, options );
		this.collectTargets();

		// Register target visible event
		this.root.on( '_navigatorSpy.targetVisible', this.visible.bind( this ) );

		_win.on( 'scroll', this.update.bind( this ) );
		_win.on( 'resize', this.update.bind( this ) );
		_win.on( 'load',   this.update.bind( this ) );
	};

	NavigatorSpy.prototype = {
		/**
		 * This method will handle events scroll, resize, load
		 * of the window object. It will find the visible element
		 * inside window and trigger a custom event for active the associated
		 * menu
		 * 
		 * @return  void
		 */
		update: function( evt ) {
			var self = this;

			// Run through each target and check it is visible
			// in the viewport
			$.each( _targets, function() {
				var offset = this.offset(),
					scrollTop = _win.scrollTop() + self.opts.offset;

				// Calculate the additional offsets
				offset.bottom = offset.top + this.height() + self.opts.offset;
				offset.right = offset.left + this.width();

				// Check the element visible
				if ( offset.top < scrollTop && offset.bottom > scrollTop ) {
					self.root.trigger( '_navigatorSpy.targetVisible', { target: this } );
				}
			} );
		},

		visible: function( evt, data ) {
			$( '.current-menu-item', this.root ).removeClass( 'current-menu-item' );
			$( 'a[data-target="' + data.target.attr( 'id' ) + '"]', this.root ).closest( 'li' ).addClass( 'current-menu-item' );
		},

		/**
		 * Find all targets that linked from the navigator and
		 * push it into monitor list
		 * 
		 * @return  array
		 */
		collectTargets: function() {
			$( 'a', this.root ).each( function() {
				// We accept only link that pointed to current page and have hash segment
				if ( this.href.indexOf( window.location.toString() ) !== false && this.hash != '' ) {
					var target = $( this.hash ),
						targetId = this.hash.substring( 1 );

					// Find the target based on hash
					// and add it to targets list
					if ( target.length > 0 ) {
						if ( _targets[targetId] === undefined )
							_targets[targetId] = target;

						$( this ).attr( 'data-target', targetId );
					}
				}
			} );
		}
	};

	$.fn.navigatorSpy = function( options ) {
		return this.each( function() {
			$( this ).data( '_navigatorSpy', new NavigatorSpy( this, options ) );
		} );
	}

} ).call( this, jQuery );
( function( $ ) {
	"use strict";

	var win = $( window );

	/**
	 * Header sticky module
	 */
	var _defaults = {
		position: 'relative',
		additionOffset: 0,
		updatePosition: function() {},
		onStick: function() {},
		onUnStick: function() {}
	};

	/**
	 * Sticky header class
	 */
	var StickyHeader = function( element, options ) {
		this.nav = $( element );
		this.options = $.extend( _defaults, options );
		this.stickTriggered = false;

		/**
		 * Register the callback function that will
		 * update the navigator position
		 */
		if ( $.isFunction( this.options.updatePosition ) )
			this.nav.on( 'navPosition', this.options.updatePosition.bind( this ) );

		if ( $.isFunction( this.options.onStick ) )
			this.nav.on( 'navSticked', this.options.onStick.bind( this ) );

		if ( $.isFunction( this.options.onUnStick ) )
			this.nav.on( 'navReset', this.options.onUnStick.bind( this ) );

		/**
		 * This method will be called when window is scrolling
		 * for trigger event to make navigator to sticked
		 */
		this.doStick = function() {
			var offsetTop = win.scrollTop();

			/**
			 * Try to retrieve original offset
			 */
			this.navOriginOffset = this.nav.data( 'origin-offset' );

			/**
			 * Store the original offset before
			 * make the navigator to sticked
			 */
			if ( this.navOriginOffset === undefined ) {
				this.navOriginOffset = this.nav.offset();
				this.nav.data( 'origin-offset', this.navOriginOffset );
			}

			/**
			 * Increase scrolltop if admin toolbar is
			 * appearing
			 */
			var additionOffset = $.isFunction( this.options.additionOffset )
				? this.options.additionOffset.call( this )
				: parseInt( this.options.additionOffset );

			if ( $.isNumeric( additionOffset ) && additionOffset > 0 ) {
				offsetTop = offsetTop + additionOffset;
			}

			/**
			 * Update class to make navigator to stick
			 * or not
			 */
			if ( offsetTop > this.navOriginOffset.top ) {
				this.nav.addClass( 'stick' );

				if ( this.stickTriggered == false ) {
					this.stickTriggered = true;
					this.nav.trigger( 'navSticked' );
				}

				this.nav.trigger( 'navPosition', {
					offsetTop: offsetTop
				} );
			}
			else {
				this.nav.removeClass( 'stick' );
				this.nav.removeAttr( 'style' );
				this.nav.trigger( 'navReset' );
			}
		}

		win.on( 'load scroll resize', this.doStick.bind( this ) );
	};

	$.fn['stickyHeader'] = function( options ) {
		return this.each( function() {
			$( this ).data( '_stickyHeader', new StickyHeader( this, options ) );
		} );
	};

} ).call( this, jQuery );


( function( $ ) {
	"use strict";

	var _defaults = {
		paginator: '',
		container: 'body',
		infiniteScroll: false,
		success: function() {}
	};

	function Pagination( element, options ) {
		this.opts      = $.extend( _defaults, options );
		this.root      = $( this.opts.paginator );
		this.container = $( this.opts.container );
		this.isLoading = false;

		this.addEvents();
	};

	Pagination.prototype = {
		addEvents: function() {
			var self = this;

			this.root.on( 'click', 'a', function( e ) {
				e.preventDefault();
				self.loadContent( this.href );
			} );
		},

		loadContent: function( url ) {
			if ( this.isLoading == false ) {
				// Set isLoading flag to prevent user send many times
				// click to load more button
				this.isLoading = true;
				this.root.addClass( 'loading' );

				// Send ajax request to server that will retrieved
				// content to be appended to container
				$.get( url, ( function( response ) {
					this.articles  = $( this.opts.container, response ).children();
					this.paginator = $( this.opts.paginator, response );

					var isotope = this.container.data( 'isotope' ),
						masonry = this.container.data( 'masonry' );

					if ( isotope || masonry ) {
						this.articles.css( {
							position: 'absolute',
							visibility: 'hidden'
						} );

						this.container.append( this.articles );
						this.container.imagesLoaded( ( function() {
							isotope
								? this.container.isotope( 'once', 'layoutComplete', this.success.bind( this ) )
								: this.container.masonry( 'once', 'layoutComplete', this.success.bind( this ) );

							this.container.trigger( 'content-appended', {
								'items': this.articles
							} );
						} ).bind( this ) );

						return;
					}

					// Hide articles before append to it own container
					this.container.append( this.articles );
					this.success();
				} ).bind( this ) );
			}
		},

		success: function() {
			this.root.replaceWith( this.paginator );
			this.opts.success();

			this.root = $( this.opts.paginator );
			this.addEvents();

			// Set isLoading back to false that will accept
			// future request from user
			this.isLoading = false;
		}
	};

	$.fn.pagination = function( options ) {
		return this.each( function() {
			$( this ).data( '_pagination', new Pagination( this, options ) );
		} );
	}

} ).call( this, jQuery );
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
					setTimeout( function() {
						$.waypoints( 'refresh' );
						$( window ).trigger( 'scroll' );
						console.log( 'OK' );
					}, 700 );
				} );

				$( '.projects-filter-toggler', container ).on( 'click', function( e ) {
					$( '.projects-filter', container ).toggleClass( 'active' );
				} );

				$( '.project', container ).waypoint( function() {
					var maxDuration  = 0.7;
					var minDuration  = 0.4;
					var randDuration = ( Math.random() * ( maxDuration - minDuration ) + minDuration ) + 's';

					$( '.project-wrap', this )
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
