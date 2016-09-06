<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Migrate theme options after switched theme
add_action( 'after_switch_theme', 'mountain_migrate_theme_options' );

// Override theme options for specific page
add_filter( 'op/prepare_options', 'mountain_override_theme_options' );

/**
 * Callback function to migrate theme options
 * 
 * @return  void
 */
function mountain_migrate_theme_options() {
	$default_options = mountain_customize_default_options();
	$options = get_theme_mods();
	
	foreach ( $default_options as $id => $value ) {
		if ( ! isset( $options[$id] ) )
			set_theme_mod( $id, $value );
	}
}



/**
 * Return an array that declare the default options
 * for the theme
 * 
 * @return  array
 */
function mountain_customize_default_options() {
	return array(
		'data_version'  => '1.0',
		'gotop_enabed'  => true,
		'bookmark_icon' => 'http://build.linethemes.com/mountain/wp-content/themes/mountain/assets/img/favicon.ico',
		'social_links'  => array(
			'twitter'   => 'https://twitter.com/linethemes',
			'facebook'  => 'https://facebook.com/thelinethemes',
			'instagram' => '#',
			'behance'   => '#',
			'rss'       => '#'
		),
		'body_font' => array(
			'family' => 'Karla',
			'size'   => '15',
			'style'  => '400',
			'color'  => '#555'
		),
		'heading_font' => array(
			'family' => 'Josefin+Sans',
			'style'  => '400',
		),
		'heading_fontsize' => array( 48, 36, 30, 24, 18, 14 ),
		'menu_font'        =>  array(
			'family' => 'Montserrat',
			'size'   => '12',
			'style'  => '400',
			'color'  => '#333',
		),
		'cyrillic_subsets_enabled'     => false,
		'cyrillic_ext_subsets_enabled' => false,
		'greek_subsets_enabled'        => false,
		'greek_ext_subsets_enabled'    => false,
		'vietnamese_subsets_enabled'   => false,
		'latin_ext_subsets_enabled'    => false,
		'devanagari_subsets_enabled'   => false,
		'scheme_color'                 => '#00c365',
		'layout_mode'                  => 'layout-wide',
		'boxed_background'             => array(
			'type'     => 'none',
			'pattern'  => 'none',
			'color'    => '#fff',
			'image'    => '',
			'repeat'   => 'repeat',
			'position' => 'top-left',
			'style'    => 'scroll'
		),
		'sidebar_layout'       => 'no-sidebar',
		'sidebar_default'      => 'sidebar-primary',
		'pagetitle_enabled'    => true,
		'pagetitle_background' => array(
			'color'    => '#fff',
			'type'     => 'custom',
			'pattern'  => 'none',
			'image'    => '',
			'repeat'   => 'no-repeat',
			'position' => 'center-center',
			'style'    => 'cover'
		),
		'pagetitle_textcolor'         => '#fff',
		'breadcrumb_prefix'           => '',
		'breadcrumb_separator'        => '',
		'logo_image'                  => true,
		'show_tagline'                => false,
		'logo_src'                    => 'http://build.linethemes.com/mountain/wp-content/uploads/2015/08/logo-1.svg',
		'logo_margin'                 => array( 50, '' ),
		'header_sticky'               => true,
		'header_searchbox'            => true,
		'topbar_enabled'              => true,
		'topbar_content'              => '<i class="fa fa-clock-o"></i>We\'are Open: Monday - Saturday, 8:00 Am - 18:00 Pm',
		'topbar_social_links_enabled' => true,
		'footer_widgets_enabled'      => true,
		'footer_widgets_layout'       => array(
			'active' => '0',
			'layout' => array(
				array( 12 ),
				array( 6, 6 ),
				array( 4, 4, 4 ),
				array( 6, 2, 2, 2 ),
			),
		),
		'footer_widgets_background' => array(
			'color'    => '#ebebeb',
			'type'     => 'custom',
			'pattern'  => 'none',
			'image'    => 'http://build.linethemes.com/mountain/wp-content/uploads/2015/06/bg-footer.png',
			'repeat'   => 'repeat-x',
			'position' => 'top-center',
			'style'    => 'cover',
		),
		'footer_widgets_textcolor'           => '#222',
		'footer_social_links_enabled'        => true,
		'footer_copyright'                   => '© Mountain 2015   <span>•</span>   15 Nicholson Street, New York   <span>•</span>   Tel: 1-888-345-6789<br/>
		<span>Copyright © 2015 <a href       ="http://linethemes.com/" target="_blank">Linethemes</a>, Inc.</span>',
		'blog_archive_sidebar_layout'        => 'sidebar-right',
		'blog_archive_sidebar'               => 'sidebar-primary',
		'blog_archive_post_excepts'          => true,
		'blog_archive_post_excepts_length'   => '150',
		'blog_archive_show_post_meta'        => false,
		'blog_archive_readmore'              => true,
		'blog_archive_readmore_text'         => 'Read More',
		'blog_archive_pagination_style'      => 'pager',
		'blog_posts_per_page'                => '9',
		'blog_single_sidebar_layout'         => 'no-sidebar',
		'blog_single_sidebar'                => 'sidebar-primary',
		'blog_post_navigator_enabled'        => true,
		'blog_author_box_enabled'            => false,
		'blog_related_box_enabled'           => true,
		'blog_related_posts_style'           => 'carousel',
		'blog_related_posts_count'           => '6',
		'blog_related_posts_columns'         => 3,
		'content_width'                      => '1200px',
		'pagetitle_parallax'                 => true,
		'members_archive_sidebar_layout'     => 'no-sidebar',
		'members_archive_sidebar'            => 0,
		'members_single_sidebar'             => 'sidebar-0',
		'members_posts_per_page'             => 10,
		'members_single_sidebar_layout'      => 'sidebar-right',
		'woocommerce_single_sidebar_layout'  => 'no-sidebar',
		'woocommerce_single_sidebar'         => 'sidebar-2',
		'woocommerce_products_per_page'      => 12,
		'woocommerce_related_products_count' => 3,
		'woocommerce_archive_sidebar_layout' => 'no-sidebar',
		'woocommerce_archive_sidebar'        => 'sidebar-primary',
		'woocommerce_related_box_enabled'    => true,
		'projects_permalink_base'            => 'gallery',
		'projects_category_permalink_base'   => 'gallery-category',
		'projects_tag_permalink_base'        => 'gallery-tag',
		'projects_grid_columns'              => '3',
		'projects_archive_sidebar_layout'    => 'no-sidebar',
		'projects_single_content_position'   => 'right',
		'projects_single_content_sticky'     => false,
		'projects_related_type'              => 'recent',
		'projects_related_columns_count'     => '3',
		'projects_related_posts_count'       => '3',
		'projects_single_sidebar_layout'     => 'no-sidebar',
		'projects_single_sidebar'            => 'sidebar-primary',
		'projects_single_gallery_type'       => 'grid',
		'projects_posts_per_page'            => '12',
		'projects_archive_layout'            => 'masonry',
		'projects_related_title'             => 'Related Projects',
		'projects_single_gallery_columns'    => '2',
		'header_cart_menu'                   => true,
		'header_style'                       => 'header-v2',
		'pagetitle_font'                     => array(
			'family' => 'Josefin+Sans',
			'size'   => '96',
			'style'  => '700',
			'color'  => '#333333',
		),
		'blog_archive_layout'  => 'large',
		'offcanvas_background' => array(
			'color'    => '#1a1a1a',
			'type'     => 'custom',
			'pattern'  => 'none',
			'image'    => 'http://build.linethemes.com/mountain/wp-content/uploads/2015/06/bg_off-canvas.jpg',
			'repeat'   => 'no-repeat',
			'position' => 'top-center',
			'style'    => 'cover',
		),
		'blog_grid_columns'                 => '3',
		'blog_post_header_background'       => true,
		'projects_archive_pagination_style' => 'pager',
		'projects_related_box_enabled'      => false,
		'projects_single_header_background' => true,
		'custom_css'                        => '.fix-margin {
		margin-bottom:-98px;
		}',
		'custom_js'                         => '',
		'header_background'                 => array(
			'color'    => '#fff',
			'type'     => 'none',
			'pattern'  => 'parent_8.png',
			'image'    => 'http://build.linethemes.com/mountain/wp-content/uploads/2015/07/44.jpg',
			'repeat'   => 'no-repeat',
			'position' => 'top-center',
			'style'    => 'cover',
		),
		'projects_archive_page' => '331',
	);
}



/**
 * This action will be used to override global theme
 * options as a specific options from page
 * 
 * @param   array  $options  Global options
 * @return  array
 */
function mountain_override_theme_options( $options ) {
	global $post;

	if ( is_admin() ) return $options;

	// Blog options
	if ( is_search() || ( current_post_type_is( 'post' ) && ( is_home() || is_archive() || is_single() ) ) ) {
		if ( is_single() ) {
			$options['sidebar_layout'] = $options['blog_single_sidebar_layout'];
			$options['sidebar_default'] = $options['blog_single_sidebar'];
		}
		else {
			$options['sidebar_layout'] = $options['blog_archive_sidebar_layout'];
			$options['sidebar_default'] = $options['blog_archive_sidebar'];
		}
	}

	// Page options
	elseif ( is_page() ) {
		$page_options_defaults = array(
			'sidebar_layout'            => 'default',
			'enable_custom_page_header' => false,
			'breadcrumb_enabled'        => 'default',
			'topbar_enabled'            => 'default',
		);
		$page_options = array_merge( $page_options_defaults, (array) get_post_meta( get_the_ID(), '_page_options', true ) );

		// Override layout option
		if ( $page_options['sidebar_layout'] !== 'default' ) {
			$options['sidebar_layout']  = $page_options['sidebar_layout'];
			$options['sidebar_default'] = $page_options['sidebar_default'];
		}

		// Override custom page title option
		if ( isset( $page_options['enable_custom_page_header'] ) && $page_options['enable_custom_page_header'] == true ) {
			$options['pagetitle_enabled']    = isset( $page_options['pagetitle_enabled'] ) 
				? $page_options['pagetitle_enabled'] 
				: $options['pagetitle_enabled'];

			$options['pagetitle_background'] = isset( $page_options['pagetitle_background'] ) 
				? $page_options['pagetitle_background'] 
				: $options['pagetitle_background'];

			$options['pagetitle_padding']    = isset( $page_options['pagetitle_padding'] ) 
				? $page_options['pagetitle_padding'] 
				: $options['pagetitle_padding'];
		}

		// Override breadcrumbs options
		if ( $page_options['breadcrumb_enabled'] != 'default' ) {
			$options['breadcrumb_enabled'] = $page_options['breadcrumb_enabled'] == 'enable';
		}

		// Override topbar options
		if ( $page_options['topbar_enabled'] != 'default' ) {
			$options['topbar_enabled'] = $page_options['topbar_enabled'] == 'enable';
		}
	}
	
	return $options;
}
