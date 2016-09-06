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
