(function($) {
	"use strict";

	var api = wp.customize,
		doc = $( document ),
		win = $( window );

	/**
	 * This function will be used to update the
	 * state of the options control
	 *
	 * @return  void
	 */
	var refreshState = function() {
		/**
		 * Site frontpage options
		 */
		$.opControlVisible( [
				'static_frontpage',
				'posts_page'
			],
			api.instance( 'show_on_front' ).get() == 'page'
		);
		
		/**
		 * Logo options
		 */
		$.opControlVisible( [
				'logo_src',
				'logo_size',
				'logo_margin',
				'logo_sticky_src'
			],
			api.instance( 'logo_image' ).get()
		);
		
		/**
		 * Topbar options
		 */
		// $.opControlVisible( [
		// 		'topbar_bgcolor',
		// 		'topbar_textcolor',
		// 		'topbar_content',
		// 		'topbar_social_links_enabled'
		// 	],
		// 	api.instance( 'topbar_enabled' ).get()
		// );

		/**
		 * Footer Widgets
		 */
		$.opControlVisible( [
				'footer_widgets_layout',
				'footer_widgets_background',
				'footer_widgets_textcolor'
			],
			api.instance( 'footer_widgets_enabled' ).get()
		);

		/**
		 * Layout
		 */
		$.opControlVisible( ['boxed_background'], api.instance( 'layout_mode' ).get() == 'layout-boxed' );
		$.opControlVisible( ['sidebar_default'], api.instance( 'sidebar_layout' ).get() != 'no-sidebar' );
		$.opControlVisible( ['pagetitle_background', 'pagetitle_textcolor'],
			api.instance( 'pagetitle_enabled' ).get()
		);

		$.opControlVisible( ['breadcrumb_prefix', 'breadcrumb_separator'],
			api.instance( 'breadcrumb_enabled' ).get()
		);

		/**
		 * Blog
		 */
		$.opControlVisible( [
			'blog_archive_post_excepts_length',
			'blog_archive_post_excepts_striphtml'
			],
			api.instance( 'blog_archive_post_excepts' ).get()
		);
		$.opControlVisible( ['blog_archive_readmore_text'], api.instance( 'blog_archive_readmore' ).get() );
		$.opControlVisible( ['blog_related_posts_style', 'blog_related_posts_count'], api.instance( 'blog_related_box_enabled' ).get() );
		$.opControlVisible( ['blog_related_posts_columns'],
			api.instance( 'blog_related_posts_style' ).get() != 'list' &&
			api.instance( 'blog_related_box_enabled' ).get()
		);

		$.opControlVisible( ['blog_archive_sidebar'], api.instance( 'blog_archive_sidebar_layout' ).get() != 'no-sidebar' );
		$.opControlVisible( ['blog_single_sidebar'], api.instance( 'blog_single_sidebar_layout' ).get() != 'no-sidebar' );

		/**
		 * Projects
		 */
		if ( $( '#accordion-section-projects' ).size() > 0 ) {
			$.opControlVisible( [ 'projects_archive_sidebar' ], api.instance( 'projects_archive_sidebar_layout' ).get() != 'no-sidebar' );
			$.opControlVisible( [ 'projects_single_sidebar' ], api.instance( 'projects_single_sidebar_layout' ).get() != 'no-sidebar' );
			$.opControlVisible( [ 'projects_single_gallery_columns' ], api.instance( 'projects_single_gallery_type' ).get() == 'grid' );
			$.opControlVisible( [ 'projects_single_content_sticky' ], api.instance( 'projects_single_content_position' ).get() != 'fullwidth' );
			$.opControlVisible( [
					'projects_related_title',
					'projects_related_type',
					'projects_related_style',
					'projects_related_columns_count',
					'projects_related_posts_count'
				],
				api.instance( 'projects_related_box_enabled' ).get()
			);
		}

		/**
		 * Woocommerce
		 */
		if ( $( '#accordion-section-woocommerce' ).size() > 0 ) {
			$.opControlVisible( [ 'woocommerce_archive_sidebar' ], api.instance( 'woocommerce_archive_sidebar_layout' ).get() != 'no-sidebar' );
			$.opControlVisible( [ 'woocommerce_single_sidebar' ], api.instance( 'woocommerce_single_sidebar_layout' ).get() != 'no-sidebar' );
			$.opControlVisible( [ 'woocommerce_related_products_count' ], api.instance( 'woocommerce_related_box_enabled' ).get() );
		}

		/**
		 * Members
		 */
		if ( $( '#accordion-section-team-members' ).size() > 0 ) {
			$.opControlVisible( ['members_archive_sidebar'], api.instance( 'members_archive_sidebar_layout' ).get() != 'no-sidebar' );
			$.opControlVisible( ['members_single_sidebar'], api.instance( 'members_single_sidebar_layout' ).get() != 'no-sidebar' );
		}
		
		/**
		 * Under Construction
		 */
		$.opControlVisible( ['under_construction_page_id', 'under_construction_allowed'], api.instance( 'under_construction_enabled' ).get() );
	};

	// Implement the DOMReady event
	$(function() {
		// Register change event for all options
		api.bind( 'change', refreshState );
		win.on( 'load', refreshState );
	});
}).call(this, jQuery);
