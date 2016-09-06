<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

$controls = array();

/**
 * General controls
 */
$controls['siteinfo_heading'] = array(
	'type'        => 'heading',
	'title'       => __( 'Site Information', 'mountain' ),
	'description' => __( 'This section have basic information of your site, just change it to match with you need.', 'mountain' ),
	'section'     => 'general',
	'class'       => 'no-border'
);

$controls['site_name'] = array(
	'type'     => 'text',
	'label'    => __( 'Site Name', 'mountain' ),
	'section'  => 'general',
	'settings' => 'blogname'
);

$controls['site_desc'] = array(
	'type'     => 'text',
	'label'    => __( 'Site Tagline', 'mountain' ),
	'section'  => 'general',
	'settings' => 'blogdescription'
);

$controls['static_frontpage_heading'] = array(
	'type'        => 'heading',
	'section'     => 'general',
	'class'       => 'no-border',
	'title'       => __( 'Static Front Page', 'mountain' ),
	'description' => __( 'Switch this option to use static page or posts page on the home', 'mountain' )
);

$controls['static_frontpage_enabled'] = array(
	'type'     => 'radio-buttons',
	'section'  => 'general',
	'settings' => 'show_on_front',
	'choices'  => array(
		'posts' => __( 'Posts', 'mountain' ),
		'page'  => __( 'Static Page', 'mountain' )
	)
);

$controls['static_frontpage'] = array(
	'type'     => 'dropdown-pages',
	'section'  => 'general',
	'label'    => __( 'Front Page', 'mountain' ),
	'settings' => 'page_on_front'
);

$controls['posts_page'] = array(
	'type'     => 'dropdown-pages',
	'section'  => 'general',
	'label'    => __( 'Posts Page', 'mountain' ),
	'settings' => 'page_for_posts'
);

$controls['general_misc_heading'] = array(
	'type'        => 'heading',
	'section'     => 'general',
	'class'       => 'no-border',
	'title'       => __( 'Misc', 'mountain' ),
	'description' => __( 'This section have options that allow to adding bookmark icon, social icons, ...', 'mountain' )
);

$controls['gotop_enabed'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Go Top Button', 'mountain' ),
	'section' => 'general',
	'default' => true
);

$controls['social_links'] = array(
	'type'    => 'social-icons',
	'label'   => __( 'Social Links', 'mountain' ),
	'section' => 'general',
	'default' => array(
		'facebook' => 'https://facebook.com/thelinethemes',
		'twitter'  => 'https://twitter.com/linethemes'
	)
);

/**
 * Styles
 */
$controls['body_font_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'typography',
	'title'       => __( 'Body Font', 'mountain' ),
	'description' => __( 'You can modify the font family, size, color, ... for global content.', 'mountain' )
);

$controls['body_font'] = array(
	'type'    => 'typography',
	'section' => 'typography',
	'default' => array(
		'family'      => 'Raleway',
		'size'        => 14,
		'style'       => 400,
		'color'       => '#333333'
	)
);

$controls['heading_font_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'typography',
	'title'       => __( 'Heading Font', 'mountain' ),
	'description' => __( 'You can modify the font options for your headings. h1, h2, h3, h4, ...', 'mountain' )
);

$controls['heading_font'] = array(
	'type'    => 'typography',
	'section' => 'typography',
	'fields'  => array( 'family', 'style' ),
	'default' => array(
		'family'      => 'Montserrat',
		'style'       => 400,
		'color'       => '#333333'
	)
);

$controls['heading_fontsize'] = array(
	'type'    => 'dimension',
	'section' => 'typography',
	'class'   => 'no-label',
	'fields' => array(
		'h1' => __( 'H1 Font Size (px)', 'mountain' ),
		'h2' => __( 'H2 Font Size (px)', 'mountain' ),
		'h3' => __( 'H3 Font Size (px)', 'mountain' ),
		'h4' => __( 'H4 Font Size (px)', 'mountain' ),
		'h5' => __( 'H5 Font Size (px)', 'mountain' ),
		'h6' => __( 'H6 Font Size (px)', 'mountain' ),
	),
	'default' => array(
		0, 0, 0, 0, 0, 0
	)
);

$controls['menu_font_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'typography',
	'title'       => __( 'Menu Font', 'mountain' ),
	'description' => __( 'Select your custom font options for your main navigation menu.', 'mountain' )
);

$controls['menu_font'] = array(
	'type'    => 'typography',
	'section' => 'typography',
	'default' => array(
		'family' => 'Montserrat',
		'size'   => 14,
		'style'  => 400,
		'color'  => '#333333'
	)
);

$controls['pagetitle_font_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'typography',
	'title'       => __( 'Page Title Font', 'mountain' ),
	'description' => __( 'Select your custom font options for your page title.', 'mountain' )
);

$controls['pagetitle_font'] = array(
	'type'    => 'typography',
	'section' => 'typography',
	'default' => array(
		'family' => 'Montserrat',
		'style'  => 400,
		'color'  => '#333333',
		'size'   => 20
	)
);

$controls['font_subsets_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'typography',
	'title'       => __( 'Font Subsets', 'mountain' ),
	'description' => __( 'Sometime you need to load extra font subsets for another languages, this options will allow to do it.', 'mountain' )
);

$controls['cyrillic_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Cyrillic', 'mountain' ),
	'default' => false
);

$controls['cyrillic_ext_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Cyrillic Extended', 'mountain' ),
	'default' => false
);

$controls['greek_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Greek', 'mountain' ),
	'default' => false
);
$controls['greek_ext_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Greek Extended', 'mountain' ),
	'default' => false
);

$controls['vietnamese_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Vietnamese', 'mountain' ),
	'default' => false
);

$controls['latin_ext_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Latin Extended', 'mountain' ),
	'default' => false
);

$controls['devanagari_subsets_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'typography',
	'label'   => __( 'Devanagari', 'mountain' ),
	'default' => false
);

/**
 * Layout controls
 */
$controls['scheme_color_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'layout',
	'title'       => __( 'Scheme Color', 'mountain' ),
	'description' => __( 'Select the color that will be used for theme color.', 'mountain' )
);

$controls['scheme_color'] = array(
	'type'    => 'color-picker',
	'label'   => __( 'Scheme Color', 'mountain' ),
	'section' => 'layout',
	'default' => '#a0ce4e'
);

$controls['layout_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'layout',
	'title'       => __( 'Layout', 'mountain' ),
	'description' => __( 'Choose between a full or a boxed layout to set how your website\'s layout will look like.', 'mountain' )
);

$controls['layout_mode'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Display Style', 'mountain' ),
	'section' => 'layout',
	'choices' => array(
		'layout-wide'  => array(
			'src'     => op_directory_uri() . '/assets/img/layout-wide.png',
			'tooltip' => __( 'Wide', 'mountain' )
		),

		'layout-boxed'  => array(
			'src'     => op_directory_uri() . '/assets/img/layout-boxed.png',
			'tooltip' => __( 'Boxed', 'mountain' )
		),
	),
	'default' => 'layout-wide'
);

$controls['boxed_background'] = array(
	'type'     => 'background',
	'label'    => __( 'Boxed Background', 'mountain' ),
	'section'  => 'layout',
	'patterns' => predefined_background_patterns(),
	'default'  => array(
		'type'     => 'none',
		'pattern'  => 'none',
		'color'    => '#fff',
		'image'    => '',
		'repeat'   => 'repeat',
		'position' => 'top-left',
		'style'    => 'scroll'
	)
);

$controls['content_width'] = array(
	'type'    => 'text',
	'label'   => __( 'Content Width', 'mountain' ),
	'section' => 'layout',
	'default' => '1110px'
);

$controls['sidebar_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'layout',
	'title'       => __( 'Sidebar', 'mountain' ),
	'description' => __( 'Select the position of sidebar that you wish to display.', 'mountain' )
);
$controls['sidebar_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Sidebar Position', 'mountain' ),
	'section' => 'layout',
	'choices' => array(
		'no-sidebar' => array(
			'src' => op_directory_uri() . '/assets/img/no-sidebar.png',
			'tooltip' => __( 'No Sidebar', 'mountain' )
		),
		'sidebar-left' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-left.png',
			'tooltip' => __( 'Sidebar Left', 'mountain' )
		),
		'sidebar-right' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-right.png',
			'tooltip' => __( 'Sidebar Right', 'mountain' )
		)
	),
	'default' => 'no-sidebar'
);

$controls['sidebar_default'] = array(
	'type'    => 'dropdown-sidebars',
	'label'   => __( 'Default Sidebar', 'mountain' ),
	'section' => 'layout',
	'default' => 'sidebar-primary'
);
// End layout
	
$controls['pagetitle_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'layout',
	'title'       => __( 'Page Title', 'mountain' ),
	'description' => __( 'In this section you can turn on/off or modify style for the Page Title.', 'mountain' )
);
$controls['pagetitle_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Page Title', 'mountain' ),
	'section' => 'layout',
	'default' => true
);

$controls['pagetitle_background'] = array(
	'type'     => 'background',
	'section'  => 'layout',
	'label'    => __( 'Background', 'mountain' ),
	'patterns' => predefined_background_patterns(),
	'default'  => array(
		'type'     => 'none',
		'pattern'  => 'none',
		'color'    => '#f2f2f2',
		'image'    => '',
		'repeat'   => 'repeat',
		'position' => 'top-left',
		'style'    => 'scroll'
	)
);

$controls['pagetitle_padding'] = array(
	'type'    => 'dimension',
	'label'   => __( 'Padding', 'mountain' ),
	'section' => 'layout',
	'default' => array( 50, 50 ),
	'fields'  => array(
		'top'    => __( 'Top', 'mountain' ),
		'bottom' => __( 'Bottom', 'mountain' )
	)
);

$controls['pagetitle_parallax'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Parallax Effect', 'mountain' ),
	'section' => 'layout',
	'default' => false
);

$controls['breadcrumb_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'layout',
	'title'       => __( 'Breadcrumb', 'mountain' ),
	'description' => __( 'Change settings for the breadcrumb.', 'mountain' )
);
$controls['breadcrumb_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Breadcrumbs', 'mountain' ),
	'section' => 'layout',
	'default' => true
);

$controls['breadcrumb_prefix'] = array(
	'type'    => 'text',
	'label'   => __( 'Breadcrumb Prefix', 'mountain' ),
	'section' => 'layout',
	'default' => __( 'You are here:', 'mountain' )
);

$controls['breadcrumb_separator'] = array(
	'type'    => 'text',
	'label'   => __( 'Breadcrumb Separator', 'mountain' ),
	'section' => 'layout',
	'default' => '/'
);

/**
 * Logo options
 */
$controls['logo_image'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Use Logo Image', 'mountain' ),
	'section' => 'header_brand',
	'default' => true
);

$controls['show_tagline'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Display Site Tagline', 'mountain' ),
	'section' => 'header_brand',
	'default' => false
);

$controls['logo_src'] = array(
	'type'    => 'media-picker',
	'label'   => __( 'Logo', 'mountain' ),
	'section' => 'header_brand',
	'default' => get_template_directory_uri() . '/assets/img/logo.png'
);

$controls['logo_size'] = array(
	'type'    => 'dimension',
	'label'   => __( 'Logo Size', 'mountain' ),
	'section' => 'header_brand',
	'fields'  => array(
		'width'  => __( 'Width (px)', 'mountain' ),
		'height' => __( 'Height (px)', 'mountain' )
	),
	'default' => array( 0, 0 )
);

$controls['logo_margin'] = array(
	'type'    => 'dimension',
	'label'   => __( 'Logo Margin', 'mountain' ),
	'section' => 'header_brand',
	'fields'  => array(
		'top'    => __( 'Top (px)', 'mountain' ),
		'bottom' => __( 'Bottom (px)', 'mountain' )
	),
	'default' => array( 25, 25 )
);

/**
 * Navigation
 */
$menus     = wp_get_nav_menus();
$locations = get_registered_nav_menus();

$choices = array( 0 => __( '-- Select --', 'mountain' ) );

if ( $menus ) {
	foreach ( $menus as $menu ) {
		$choices[ $menu->term_id ] = wp_html_excerpt( $menu->name, 40, '&hellip;' );
	}
}

foreach ( $locations as $location => $description ) {
	$menu_setting_id = "nav_menu_locations[{$location}]";

	$controls["menu_location_{$location}"] = array(
		'label'    => $description,
		'section'  => 'header_nav',
		'type'     => 'dropdown',
		'choices'  => $choices,
		'settings' => $menu_setting_id
	);
}

/**
 * Header Styles
 */
// $controls['header_background'] = array(
// 	'type'     => 'background',
// 	'section'  => 'header_style',
// 	'label'    => __( 'Header Background', 'mountain' ),
// 	'patterns' => predefined_background_patterns()
// );

// $controls['header_opacity'] = array(
// 	'type'     => 'text',
// 	'section'  => 'header_style',
// 	'label'    => __( 'Header Transparent', 'mountain' ),
// 	'default'  => 90
// );

/**
 * Header Features
 */
$controls['header_sticky'] = array(
	'type'    => 'switcher',
	'section' => 'header_misc',
	'label'   => __( 'Enable Sticky Header', 'mountain' )
);

$controls['header_searchbox'] = array(
	'type'    => 'switcher',
	'section' => 'header_misc',
	'label'   => __( 'Show Search Menu', 'mountain' ),
	'default' => true
);

$controls['header_cart_menu'] = array(
	'type'    => 'switcher',
	'section' => 'header_misc',
	'label'   => __( 'Show Cart Menu', 'mountain' ),
	'default' => true
);

/**
 * Off-Canvas
 */
$controls['offcanvas_enabled'] = array(
	'type'     => 'switcher',
	'label'    => __( 'Enable Off-Canvas Area', 'mountain' ),
	'section'  => 'header_offcanvas',
	'default'  => true
);

$controls['offcanvas_sidebar'] = array(
	'type'    => 'dropdown-sidebars',
	'label'   => __( 'Sidebar', 'mountain' ),
	'section' => 'header_offcanvas',
	'default' => 'sidebar-offcanvas'
);

$controls['offcanvas_background'] = array(
	'type'     => 'background',
	'label'    => __( 'Background', 'mountain' ),
	'section'  => 'header_offcanvas',
	'patterns' => predefined_background_patterns(),
	'default'  => array(
		'type'     => 'none',
		'pattern'  => 'none',
		'color'    => '#1a1a1a',
		'image'    => '',
		'repeat'   => 'repeat',
		'position' => 'top-left',
		'style'    => 'scroll'
	)
);

/**
 * Footer
 */
$controls['footer_widgets_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'footer',
	'title'       => __( 'Footer Widgets', 'mountain' ),
	'description' => __( 'This section allow to change the layout and styles of footer widgets to match as you need.', 'mountain' )
);
$controls['footer_widgets_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Footer Widgets', 'mountain' ),
	'section' => 'footer',
	'default' => true
);

$controls['footer_widgets_layout'] = array(
	'type'    => 'widgets-layout',
	'label'   => __( 'Widgets Layout', 'mountain' ),
	'max'     => 4,
	'section' => 'footer',
	'default' => array(
		'active' => 3,
		'layout' => array(
			array( 12 ),
			array( 6, 6 ),
			array( 4, 4, 4 ),
			array( 3, 3, 3, 3 )
		)
	)
);

$controls['footer_widgets_background'] = array(
	'type'     => 'background',
	'section'  => 'footer',
	'label'    => __( 'Widgets Background', 'mountain' ),
	'patterns' => predefined_background_patterns(),
	'default'  => array(
		'type'     => 'none',
		'pattern'  => 'none',
		'color'    => '#1a1a1a',
		'image'    => '',
		'repeat'   => 'repeat',
		'position' => 'top-left',
		'style'    => 'scroll'
	)
);

$controls['footer_widgets_textcolor'] = array(
	'type'    => 'color-picker',
	'section' => 'footer',
	'label'   => __( 'Text Color', 'mountain' ),
	'default' => '#666666'
);

$controls['footer_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'footer',
	'title'       => __( 'Custom Footer', 'mountain' ),
	'description' => __( 'You can change the copyright text, show/hide the social icons on the footer.', 'mountain' )
);

$controls['footer_social_links_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Social Links', 'mountain' ),
	'section' => 'footer',
	'default' => true
);

$controls['footer_copyright'] = array(
	'type'    => 'textarea',
	'label'   => __( 'Copyright', 'mountain' ),
	'section' => 'footer'
);

/**
 * Blog
 */
$controls['blog_list_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'blog',
	'title'       => __( 'Blog List', 'mountain' ),
	'description' => __( 'All options in this section will be used to make style for blog page.', 'mountain' )
);

$controls['blog_archive_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'List Layout', 'mountain' ),
	'section' => 'blog',
	'choices' => array(
		'large' => array(
			'src' => op_directory_uri() . '/assets/img/blog-large.png',
			'tooltip' => __( 'List Large', 'mountain' )
		),
		'grid' => array(
			'src' => op_directory_uri() . '/assets/img/blog-grid.png',
			'tooltip' => __( 'Grid', 'mountain' )
		)
	),
	'default' => 'large'
);

$controls['blog_grid_columns'] = array(
	'type'    => 'dropdown',
	'section' => 'blog',
	'label'   => __( 'Grid Columns', 'mountain' ),
	'default' => 3,
	'choices' => array(
		2 => __( '2 Columns', 'mountain' ),
		3 => __( '3 Columns', 'mountain' ),
		4 => __( '4 Columns', 'mountain' )
	)
);

$controls['blog_archive_sidebar_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'List Sidebar Position', 'mountain' ),
	'section' => 'blog',
	'choices' => array(
		'no-sidebar' => array(
			'src' => op_directory_uri() . '/assets/img/no-sidebar.png',
			'tooltip' => __( 'No Sidebar', 'mountain' )
		),
		'sidebar-left' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-left.png',
			'tooltip' => __( 'Sidebar Left', 'mountain' )
		),
		'sidebar-right' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-right.png',
			'tooltip' => __( 'Sidebar Right', 'mountain' )
		)
	),
	'default' => 'sidebar-right'
);

$controls['blog_archive_sidebar'] = array(
	'type'    => 'dropdown-sidebars',
	'section' => 'blog',
	'label'   => __( 'Blog List Sidebar', 'mountain' ),
	'default' => 'sidebar-primary'
);

$controls['blog_archive_post_excepts'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Auto Post Excepts', 'mountain' ),
	'section' => 'blog',
	'default' => false
);

$controls['blog_archive_post_excepts_length'] = array(
	'type'    => 'text',
	'label'   => __( 'Post Excepts Length', 'mountain' ),
	'section' => 'blog',
	'default' => 40
);

$controls['blog_archive_show_post_meta'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Post Meta', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_archive_readmore'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Read More', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_archive_readmore_text'] = array(
	'type'    => 'text',
	'label'   => __( 'Read More Text', 'mountain' ),
	'section' => 'blog',
	'default' => __( 'Continue Read &rarr;', 'mountain' )
);

$controls['blog_archive_pagination_style'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Pagination Style', 'mountain' ),
	'section' => 'blog',
	'default' => 'numeric',
	'choices' => array(
		'pager' => array(
			'src' => op_directory_uri() . '/assets/img/paging-pager.png',
			'tooltip' => __( 'Pager', 'mountain' )
		),
		'numeric' => array(
			'src' => op_directory_uri() . '/assets/img/paging-numeric.png',
			'tooltip' => __( 'Numeric', 'mountain' )
		),
		'pager-numeric' => array(
			'src' => op_directory_uri() . '/assets/img/paging-pager-numeric.png',
			'tooltip' => __( 'Pager & Numeric', 'mountain' )
		),
		'loadmore' => array(
			'src' => op_directory_uri() . '/assets/img/paging-loadmore.png',
			'tooltip' => __( 'Load More', 'mountain' )
		)
	)
);

$controls['blog_posts_per_page'] = array(
	'type'     => 'spinner',
	'section'  => 'blog',
	'label'    => __( 'Posts Per Page', 'mountain' )
);

$controls['blog_single_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'blog',
	'title'       => __( 'Blog Single', 'mountain' ),
	'description' => __( 'Also, you can change the style for blog single to make your site unique.', 'mountain' )
);

$controls['blog_single_sidebar_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Single Sidebar Position', 'mountain' ),
	'section' => 'blog',
	'choices' => array(
		'no-sidebar' => array(
			'src' => op_directory_uri() . '/assets/img/no-sidebar.png',
			'tooltip' => __( 'No Sidebar', 'mountain' )
		),
		'sidebar-left' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-left.png',
			'tooltip' => __( 'Sidebar Left', 'mountain' )
		),
		'sidebar-right' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-right.png',
			'tooltip' => __( 'Sidebar Right', 'mountain' )
		)
	),
	'default' => 'sidebar-right'
);

$controls['blog_single_sidebar'] = array(
	'type'    => 'dropdown-sidebars',
	'section' => 'blog',
	'label'   => __( 'Blog Single Sidebar', 'mountain' ),
	'default' => 'sidebar-primary'
);

$controls['blog_post_header_background'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Featured Image In Header', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_post_navigator_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Post Navigator', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_author_box_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Author Box', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_related_box_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Related Posts', 'mountain' ),
	'section' => 'blog',
	'default' => true
);

$controls['blog_related_posts_style'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Related Posts Style', 'mountain' ),
	'section' => 'blog',
	'choices' => array(
		'grid' => array(
			'src' => op_directory_uri() . '/assets/img/blog-grid.png',
			'tooltip' => __( 'Grid', 'mountain' )
		),
		'carousel' => array(
			'src' => op_directory_uri() . '/assets/img/related-slider.png',
			'tooltip' => __( 'Carousel', 'mountain' )
		)
	),
	'default' => 'grid'
);

$controls['blog_related_posts_columns'] = array(
	'type'    => 'dropdown',
	'section' => 'blog',
	'label'   => __( 'Columns Of Related Posts', 'mountain' ),
	'default' => 3,
	'choices' => array(
		2 => __( '2 Columns', 'mountain' ),
		3 => __( '3 Columns', 'mountain' ),
		4 => __( '4 Columns', 'mountain' )
	)
);

$controls['blog_related_posts_count'] = array(
	'type'    => 'spinner',
	'section' => 'blog',
	'label'   => __( 'Number Of Related Posts', 'mountain' ),
	'min'     => 1,
	'default' => 4
);

/**
 * Member
 */
// $controls['members_list_heading'] = array(
// 	'type'        => 'heading',
// 	'class'       => 'no-border',
// 	'section'     => 'members',
// 	'title'       => __( 'Member List', 'mountain' ),
// 	'description' => __( 'Change options in this section to custom style for portfolio listing page.', 'mountain' )
// );

// $controls['members_archive_sidebar_layout'] = array(
// 	'type'    => 'radio-images',
// 	'label'   => __( 'List Sidebar Position', 'mountain' ),
// 	'section' => 'members',
// 	'choices' => array(
// 		'no-sidebar' => array(
// 			'src' => op_directory_uri() . '/assets/img/no-sidebar.png',
// 			'tooltip' => __( 'No Sidebar', 'mountain' )
// 		),
// 		'sidebar-left' => array(
// 			'src' => op_directory_uri() . '/assets/img/sidebar-left.png',
// 			'tooltip' => __( 'Sidebar Left', 'mountain' )
// 		),
// 		'sidebar-right' => array(
// 			'src' => op_directory_uri() . '/assets/img/sidebar-right.png',
// 			'tooltip' => __( 'Sidebar Right', 'mountain' )
// 		)
// 	),
// 	'default' => 'sidebar-right'
// );

// $controls['members_archive_sidebar'] = array(
// 	'type'    => 'dropdown-sidebars',
// 	'section' => 'members',
// 	'label'   => __( 'Member List Sidebar', 'mountain' ),
// 	'default' => 'sidebar-primary'
// );

// $controls['members_archive_pagination_style'] = array(
// 	'type'    => 'radio-images',
// 	'label'   => __( 'Pagination Style', 'mountain' ),
// 	'section' => 'members',
// 	'default' => 'numeric',
// 	'choices' => array(
// 		'pager' => array(
// 			'src'     => op_directory_uri() . '/assets/img/paging-pager.png',
// 			'tooltip' => __( 'Pager', 'mountain' )
// 		),
// 		'numeric' => array(
// 			'src'     => op_directory_uri() . '/assets/img/paging-numeric.png',
// 			'tooltip' => __( 'Numeric', 'mountain' )
// 		),
// 		'pager-numeric' => array(
// 			'src'     => op_directory_uri() . '/assets/img/paging-pager-numeric.png',
// 			'tooltip' => __( 'Pager & Numeric', 'mountain' )
// 		),
// 		'loadmore' => array(
// 			'src'     => op_directory_uri() . '/assets/img/paging-loadmore.png',
// 			'tooltip' => __( 'Load More', 'mountain' )
// 		)
// 	)
// );

// $controls['members_posts_per_page'] = array(
// 	'type'     => 'spinner',
// 	'section'  => 'members',
// 	'label'    => __( 'Posts Per Page', 'mountain' )
// );

// $controls['members_single_heading'] = array(
// 	'type'        => 'heading',
// 	'class'       => 'no-border',
// 	'section'     => 'members',
// 	'title'       => __( 'Single Member', 'mountain' ),
// 	'description' => __( 'Change the layout, sidebar, navigator, ... for the single portfolio page.', 'mountain' )
// );

// $controls['members_single_sidebar_layout'] = array(
// 	'type'    => 'radio-images',
// 	'label'   => __( 'Single Sidebar Position', 'mountain' ),
// 	'section' => 'members',
// 	'choices' => array(
// 		'no-sidebar' => array(
// 			'src'     => op_directory_uri() . '/assets/img/no-sidebar.png',
// 			'tooltip' => __( 'No Sidebar', 'mountain' )
// 		),
// 		'sidebar-left' => array(
// 			'src'     => op_directory_uri() . '/assets/img/sidebar-left.png',
// 			'tooltip' => __( 'Sidebar Left', 'mountain' )
// 		),
// 		'sidebar-right' => array(
// 			'src'     => op_directory_uri() . '/assets/img/sidebar-right.png',
// 			'tooltip' => __( 'Sidebar Right', 'mountain' )
// 		)
// 	),
// 	'default' => 'sidebar-right'
// );

// $controls['members_single_sidebar'] = array(
// 	'type'    => 'dropdown-sidebars',
// 	'section' => 'members',
// 	'label'   => __( 'Single Member Sidebar', 'mountain' ),
// 	'default' => 'sidebar-primary'
// );

/**
 * Portfolio
 */
$controls['portfolio_page_title_enabled'] = array(
	'type'    => 'switcher',
	'section' => 'portfolio',
	'label'   => __( 'Enable Page Title', 'mountain' ),
	'default' => true
);

$controls['portfolio_page_title'] = array(
	'type'    => 'text',
	'section' => 'portfolio',
	'label'   => __( 'Custom Page Title', 'mountain' ),
	'default' => __( 'Portfolio', 'mountain' )
);

$controls['portfolio_list_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'portfolio',
	'title'       => __( 'Portfolio List', 'mountain' ),
	'description' => __( 'Change options in this section to custom style for portfolio listing page.', 'mountain' )
);

$controls['portfolio_archive_sidebar_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'List Sidebar Position', 'mountain' ),
	'section' => 'portfolio',
	'choices' => array(
		'no-sidebar' => array(
			'src' => op_directory_uri() . '/assets/img/no-sidebar.png',
			'tooltip' => __( 'No Sidebar', 'mountain' )
		),
		'sidebar-left' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-left.png',
			'tooltip' => __( 'Sidebar Left', 'mountain' )
		),
		'sidebar-right' => array(
			'src' => op_directory_uri() . '/assets/img/sidebar-right.png',
			'tooltip' => __( 'Sidebar Right', 'mountain' )
		)
	),
	'default' => 'sidebar-right'
);

$controls['portfolio_archive_sidebar'] = array(
	'type'    => 'dropdown-sidebars',
	'section' => 'portfolio',
	'label'   => __( 'Portfolio List Sidebar', 'mountain' ),
	'default' => 'sidebar-primary'
);

$controls['portfolio_archive_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'List Layout', 'mountain' ),
	'section' => 'portfolio',
	'choices' => array(
		'grid' => array(
			'src' => op_directory_uri() . '/assets/img/blog-grid.png',
			'tooltip' => __( 'Grid', 'mountain' )
		),
		'masonry' => array(
			'src' => op_directory_uri() . '/assets/img/blog-masonry.png',
			'tooltip' => __( 'Masonry Grid', 'mountain' )
		),
		'no-margin' => array(
			'src' => op_directory_uri() . '/assets/img/portfolio-no-margin.png',
			'tooltip' => __( 'Grid No Margin', 'mountain' )
		)
	),
	'default' => 'grid'
);

$controls['portfolio_grid_columns'] = array(
	'type'    => 'dropdown',
	'section' => 'portfolio',
	'label'   => __( 'Grid Columns', 'mountain' ),
	'default' => 3,
	'choices' => array(
		2 => __( '2 Columns', 'mountain' ),
		3 => __( '3 Columns', 'mountain' ),
		4 => __( '4 Columns', 'mountain' ),
		5 => __( '5 Columns', 'mountain' ),
	)
);

$controls['portfolio_archive_filter'] = array(
	'type'    => 'switcher',
	'section' => 'portfolio',
	'label'   => __( 'Show Items Filter', 'mountain' ),
	'default' => true
);

$controls['portfolio_archive_pagination_style'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Pagination Style', 'mountain' ),
	'section' => 'portfolio',
	'default' => 'numeric',
	'choices' => array(
		'pager' => array(
			'src'     => op_directory_uri() . '/assets/img/paging-pager.png',
			'tooltip' => __( 'Pager', 'mountain' )
		),
		'numeric' => array(
			'src'     => op_directory_uri() . '/assets/img/paging-numeric.png',
			'tooltip' => __( 'Numeric', 'mountain' )
		),
		'pager-numeric' => array(
			'src'     => op_directory_uri() . '/assets/img/paging-pager-numeric.png',
			'tooltip' => __( 'Pager & Numeric', 'mountain' )
		),
		'loadmore' => array(
			'src'     => op_directory_uri() . '/assets/img/paging-loadmore.png',
			'tooltip' => __( 'Load More', 'mountain' )
		)
	)
);

$controls['portfolio_posts_per_page'] = array(
	'type'     => 'spinner',
	'section'  => 'portfolio',
	'label'    => __( 'Posts Per Page', 'mountain' ),
	'default'  => get_option( 'posts_per_page' )
);

$controls['portfolio_single_heading'] = array(
	'type'        => 'heading',
	'class'       => 'no-border',
	'section'     => 'portfolio',
	'title'       => __( 'Single Portfolio', 'mountain' ),
	'description' => __( 'Change the layout, sidebar, navigator, ... for the single portfolio page.', 'mountain' )
);

$controls['portfolio_single_sidebar_layout'] = array(
	'type'    => 'radio-images',
	'label'   => __( 'Single Sidebar Position', 'mountain' ),
	'section' => 'portfolio',
	'choices' => array(
		'no-sidebar' => array(
			'src'     => op_directory_uri() . '/assets/img/no-sidebar.png',
			'tooltip' => __( 'No Sidebar', 'mountain' )
		),
		'sidebar-left' => array(
			'src'     => op_directory_uri() . '/assets/img/sidebar-left.png',
			'tooltip' => __( 'Sidebar Left', 'mountain' )
		),
		'sidebar-right' => array(
			'src'     => op_directory_uri() . '/assets/img/sidebar-right.png',
			'tooltip' => __( 'Sidebar Right', 'mountain' )
		)
	),
	'default' => 'sidebar-right'
);

$controls['portfolio_single_sidebar'] = array(
	'type'    => 'dropdown-sidebars',
	'section' => 'portfolio',
	'label'   => __( 'Single Portfolio Sidebar', 'mountain' ),
	'default' => 'sidebar-primary'
);

$controls['portfolio_post_navigator_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Single Navigator', 'mountain' ),
	'section' => 'portfolio',
	'default' => true
);

$controls['portfolio_post_navigator_sticky'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Single Sticky Navigator', 'mountain' ),
	'section' => 'portfolio',
	'default' => false
);

$controls['portfolio_related_box_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Show Related Portfolios', 'mountain' ),
	'section' => 'portfolio',
	'default' => true
);

$controls['portfolio_related_style'] = array(
	'type'    => 'dropdown',
	'section' => 'portfolio',
	'label'   => __( 'Related Portfolio Style', 'mountain' ),
	'default' => 'grid',
	'choices' => array(
		'grid'      => __( 'Grid', 'mountain' ),
		'masonry'   => __( 'Grid Masonry', 'mountain' ),
		'no-margin' => __( 'Grid No Margin', 'mountain' ),
		'carousel'  => __( 'Carousel', 'mountain' ),
		'carousel-no-margin'  => __( 'Carousel No Margin', 'mountain' )
	)
);

$controls['portfolio_related_columns_count'] = array(
	'type'    => 'dropdown',
	'section' => 'portfolio',
	'label'   => __( 'Columns Count', 'mountain' ),
	'choices' => array(
		1 => __( '1 Column', 'mountain' ),
		2 => __( '2 Columns', 'mountain' ),
		3 => __( '3 Columns', 'mountain' ),
		4 => __( '4 Columns', 'mountain' ),
		5 => __( '5 Columns', 'mountain' )
	),
	'default' => 4
);

$controls['portfolio_related_posts_count'] = array(
	'type'    => 'spinner',
	'section' => 'portfolio',
	'label'   => __( 'Number Of Related Portfolios', 'mountain' ),
	'min'     => 1,
	'default' => 4
);

/**
 * Under Construction
 */
$controls['under_construction_enabled'] = array(
	'type'    => 'switcher',
	'label'   => __( 'Enable Under Construction', 'mountain' ),
	'section' => 'under-construction',
	'default' => false
);

$controls['under_construction_page_id'] = array(
	'type'     => 'dropdown-pages',
	'section'  => 'under-construction',
	'label'    => __( 'Under Construction Page', 'mountain' )
);

$controls['under_construction_allowed'] = array(
	'type'    => 'checkboxes',
	'section' => 'under-construction',
	'label'   => __( 'Role-based Access Permission', 'mountain' ),
	'choices' => function() {
		$choices = array();

		foreach ( get_editable_roles() as $id => $params )
			$choices[$id] = $params['name'];
		
		return $choices;
	},

	'default' => array( 'administrator', 'editor' )
);

return $controls;
