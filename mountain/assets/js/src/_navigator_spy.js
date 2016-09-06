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