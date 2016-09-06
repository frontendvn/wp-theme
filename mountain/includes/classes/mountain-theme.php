<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

/**
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
abstract class Mountain_Theme extends Mountain_Base
{
	/**
	 * Class construction
	 */
	protected function __construct() {
		/**
		 * Initialize the theme wrapper
		 */
		add_action( 'template_include', 'Mountain_Wrapper::wrap' );

		/**
		 * Register action to setup this theme
		 */
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		/**
		 * Register filter that allow using shortcode
		 * in the widget text
		 */
		add_filter( 'widget_text', 'do_shortcode' );

		add_filter( 'nav_menu_css_class', array( $this, 'fix_menu_highlight' ), 10, 2 );

		/**
		 * There was default supported features that required
		 * on all theme
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'quote', 'status', 'video', 'audio' ) );
		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', 'gallery', 'caption' ) );
		add_theme_support( 'post-thumbnails' );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return  void
	 */
	public function setup() {
		/**
		 * Import the theme translation files
		 */
		$this->import_translation_files();

		/**
		 * Adding the theme supports
		 */
		$this->setup_theme_supports();

		/**
		 * Adding the supported image sizes
		 */
		$this->setup_image_sizes();

		/**
		 * Register the theme widget areas
		 */
		$this->setup_sidebars();

		/**
		 * Adding the menu locations
		 */
		$this->setup_menus();

		/**
		 * Load the theme supported features
		 */
		$this->setup_features();
	}

	/**
	 * This method will import the language files
	 * for this theme that make it available for translation
	 * 
	 * @return  void
	 */
	protected function import_translation_files() {
		load_theme_textdomain( 'mountain', get_template_directory() . '/languages' );
	}

	/**
	 * Register all supported features in this theme
	 * 
	 * @return  void
	 */
	protected function setup_theme_supports() {
		// Enable woocommerce support
		add_theme_support( 'woocommerce' );

		// Enable ThemeKit post type support
		add_theme_support( 'themekit-members' );
	}

	/**
	 * Register the theme menu locations
	 * 
	 * @return  void
	 */
	protected function setup_menus() {
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'mountain' ),
			'top'     => __( 'Top Menu', 'mountain' )
		) );
	}

	/**
	 * Register all supported image sizes that
	 * will be used in this theme
	 * 
	 * @return  void
	 */
	protected function setup_image_sizes() {
		add_image_size( 'small', 50, 50, true );
		
		add_image_size( 'thumbnail-small', 300, 0, false );
		add_image_size( 'thumbnail-small-crop', 300, 160, true );

		add_image_size( 'thumbnail-medium', 585, 0, false );
		add_image_size( 'thumbnail-medium-crop', 585, 312, true );

		add_image_size( 'thumbnail-large', 1200, 0, false );
		add_image_size( 'thumbnail-large-crop', 1200, 624, true );
	}

	/**
	 * Register all available sidebars
	 * 
	 * @return  void
	 */
	protected function setup_sidebars() {
		register_sidebar( array(
			'name'          => __( 'Primary Sidebar', 'mountain' ),
			'id'            => 'sidebar-primary',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		// Header Widgets
		register_sidebar( array(
			'name'          => __( 'Header Sidebar', 'mountain' ),
			'id'            => 'header-widgets',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		// Page Title Widgets
		register_sidebar( array(
			'name'          => __( 'Page Title Sidebar', 'mountain' ),
			'id'            => 'pagetitle-widgets',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		// Footer Sidebars
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar #1', 'mountain' ),
			'id'            => 'footer-1',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Sidebar #2', 'mountain' ),
			'id'            => 'footer-2',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Sidebar #3', 'mountain' ),
			'id'            => 'footer-3',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Sidebar #4', 'mountain' ),
			'id'            => 'footer-4',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	public function fix_menu_highlight( $classes, $item ) {
		if ( op_current_post_type() != 'post' ) {
			$is_blog_menu = $item->object == 'page' && get_option( 'page_for_posts' ) == $item->object_id;

			// Remove the menu item highlight for the blog menu
			if ( $is_blog_menu && $index = array_search( 'current_page_parent', $classes ) ) {
				unset( $classes[ $index ] );
			}

			$is_project = current_post_type_is( 'nproject' );
			$is_project_menu = $item->object == 'page' && get_theme_mod( 'projects_archive_page' ) == $item->object_id;

			if ( $is_project && $is_project_menu ) {
				$classes[] = 'current_page_parent';
			}
		}

		return $classes;
	}

	/**
	 * Initialize the theme features
	 * 
	 * @return  void
	 */
	protected function setup_features() {
		/**
		 * Initialize theme customize
		 */
		Mountain_ThemeCustomize::instance();

		/**
		 * Initialize custom sidebars manager
		 */
		Mountain_Sidebars::instance();
		
		/**
		 * Initialize theme breadcrumb
		 */
		Mountain_Breadcrumb::instance();	

		/**
		 * Initialize search feature
		 */
		Mountain_Search::instance();

		/**
		 * Initialize support for WooCommerce
		 */
		Mountain_Woocommerce::instance();

		/**
		 * Initialize support for Team Members
		 */
		Mountain_TeamMembers::instance();

		/**
		 * Initialize support for Projects
		 */
		Mountain_Projects::instance();
	}
}
