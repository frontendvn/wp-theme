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