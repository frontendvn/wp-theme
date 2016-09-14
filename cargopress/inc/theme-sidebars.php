<?php
/**
 * Register sidebars for CargoPress
 *
 * @package CargoPress
 */

function cargopress_sidebars() {
	// Blog Sidebar
	register_sidebar(
		array(
			'name'          => _x( 'Blog Sidebar', 'backend', 'cargopress-pt' ),
			'id'            => 'blog-sidebar',
			'description'   => _x( 'Sidebar on the blog layout.', 'backend', 'cargopress-pt' ),
			'class'         => 'blog  sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// Regular Page Sidebar
	register_sidebar(
		array(
			'name'          => _x( 'Regular Page Sidebar', 'backend', 'cargopress-pt' ),
			'id'            => 'regular-page-sidebar',
			'description'   => _x( 'Sidebar on the regular page.', 'backend', 'cargopress-pt' ),
			'class'         => 'sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// woocommerce shop sidebar
	if ( CargoPressHelpers::is_woocommerce_active() ) {
		register_sidebar(
			array(
				'name'          => _x( 'Shop Sidebar', 'backend' , 'cargopress-pt' ),
				'id'            => 'shop-sidebar',
				'description'   => _x( 'Sidebar for the shop page', 'backend' , 'cargopress-pt' ),
				'class'         => 'sidebar',
				'before_widget' => '<div class="widget  %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="sidebar__headings">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Header
	register_sidebar(
		array(
			'name'          => _x( 'Header', 'backend', 'cargopress-pt' ),
			'id'            => 'header-widgets',
			'description'   => _x( 'Header area for Icon Box and Social Icons widgets.', 'backend', 'cargopress-pt' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Navigation
	register_sidebar(
		array(
			'name'          => _x( 'Navigation', 'backend', 'cargopress-pt' ),
			'id'            => 'navigation-widgets',
			'description'   => _x( 'Navigation area for Social Icons widgets.', 'backend', 'cargopress-pt' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Footer
	$footer_widgets_num = count( CargoPressHelpers::footer_widgets_layout_array() );

	// only register if not 0
	if ( $footer_widgets_num > 0 ) {
		register_sidebar(
			array(
				'name'          => _x( 'Footer', 'backend', 'cargopress-pt' ),
				'id'            => 'footer-widgets',
				'description'   => sprintf( _x( 'Footer area works best with %d widgets. This number can be changed in the Appearance &rarr; Customize &rarr; Theme Options &rarr; Footer.', 'backend', 'cargopress-pt' ), $footer_widgets_num ),
				'before_widget' => '<div class="col-xs-12  col-md-__col-num__"><div class="widget  %2$s">', // __col-num__ is replaced dynamically in filter 'dynamic_sidebar_params'
				'after_widget'  => '</div></div>',
				'before_title'  => '<h6 class="footer-top__headings">',
				'after_title'   => '</h6>',
			)
		);
	}
}
add_action( 'widgets_init', 'cargopress_sidebars' );