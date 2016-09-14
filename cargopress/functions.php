<?php
/**
 * CargoPress functions and definitions
 *
 * @author Primoz Ciger <primoz@proteusnet.com>
 * @author Marko Prelec <marko.prelec@proteusnet.com>
 */

// Display informative message if PHP version is less than 5.3.2
if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
	die( sprintf( 'This theme requires <strong>PHP 5.3.2+</strong> to run. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.<br> Your current version of PHP: <strong>%s</strong>', phpversion() ) );
}


// Composer autoloader
require 'vendor/autoload.php';

/**
 * Define the version variable to assign it to all the assets (css and js)
 */
define( 'CARGOPRESS_WP_VERSION', wp_get_theme()->get( 'Version' ) );


/**
 * Define the development constant
 */
if ( ! defined( 'CARGOPRESS_DEVELOPMENT' ) ) {
	define( 'CARGOPRESS_DEVELOPMENT', false );
}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @see http://developer.wordpress.com/themes/content-width/Enqueue
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}


/**
 * Advanced Custom Fields calls to require the plugin within the theme
 */
locate_template( 'inc/acf.php', true, true );


/**
 * Theme support and thumbnail sizes
 */
if ( ! function_exists( 'cargopress_theme_setup' ) ) {
	function cargopress_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CargoPress, use a find and replace
		 * to change 'cargopress_wp' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'cargopress-pt', get_template_directory() . '/languages' );

		/**
		 * Loads separate textomain for the proteuswidgets which is included with composer.
		 */
		load_theme_textdomain( 'proteuswidgets', get_template_directory() . '/languages/proteuswidgets' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// WooCommerce basic support
		add_theme_support( 'woocommerce' );

		// Title tag support, since 4.1
		add_theme_support( 'title-tag' );

		// Custom Backgrounds
		add_theme_support( 'custom-background', array(
			'default-color' => 'ffffff',
		) );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'cargopress-jumbotron-slider-l', 1920, 600, true );
		add_image_size( 'cargopress-jumbotron-slider-m', 960, 300, true );
		add_image_size( 'cargopress-jumbotron-slider-s', 480, 150, true );
		add_image_size( 'latest-posts', 270, 190, true );
		// add_image_size( 'page-box', 360, 240, true ); //-> this was moved to proteuswidgets plugin

		// Menus
		add_theme_support( 'menus' );
		register_nav_menu( 'main-menu', _x( 'Main Menu', 'backend', 'cargopress-pt' ) );
		register_nav_menu( 'top-bar-menu', _x( 'Top Bar Menu', 'backend', 'cargopress-pt' ) );

		// Add theme support for Semantic Markup
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// add excerpt support for pages
		add_post_type_support( 'page', 'excerpt' );

		// Add CSS for the TinyMCE editor
		add_editor_style();
	}
	add_action( 'after_setup_theme', 'cargopress_theme_setup' );
}


/**
 * Enqueue CSS stylesheets
 */
if ( ! function_exists( 'cargopress_enqueue_styles' ) ) {
	function cargopress_enqueue_styles() {
		// custom WooCommerce CSS (enqueue it only if the WooCommerce plugin is active)
		if ( CargoPressHelpers::is_woocommerce_active() ) {
			wp_enqueue_style( 'cargopress-woocommerce', get_template_directory_uri() . '/woocommerce.css' , array() , CARGOPRESS_WP_VERSION );
		}

		wp_enqueue_style( 'cargopress-main', get_stylesheet_uri(), array(), CARGOPRESS_WP_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'cargopress_enqueue_styles' );
}

/**
 * Enqueue Google Web Fonts.
 */
if ( ! function_exists( 'cargopress_enqueue_google_web_fonts' ) ) {
	function cargopress_enqueue_google_web_fonts() {
		wp_enqueue_style( 'google-fonts', CargoPressHelpers::google_web_fonts_url(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'cargopress_enqueue_google_web_fonts' );
}


/**
 * Enqueue JS scripts
 */
if ( ! function_exists( 'cargopress_enqueue_scripts' ) ) {
	function cargopress_enqueue_scripts() {
		// modernizr for the frontend feature detection
		wp_enqueue_script( 'cargopress-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.24530.js', array(), null );

		// picturefill for the support of the <picture> element today
		wp_enqueue_script( 'cargopress-picturefill', get_template_directory_uri() . '/bower_components/picturefill/dist/picturefill.min.js', array( 'cargopress-modernizr' ), '1.2.0' );

		// google maps
		wp_register_script( 'cargopress-gmaps', '//maps.google.com/maps/api/js', array(), null, true );

		// requirejs
		wp_register_script( 'requirejs', get_template_directory_uri() . '/bower_components/requirejs/require.js', array(), null, true );

		// array for main.js dependencies
		$main_deps = array( 'jquery', 'underscore' );

		// check for the google maps, only enqueue if needed
		if ( is_active_widget( false, false, 'pw_google_map' ) || defined( 'WPB_VC_VERSION' ) ) {
			$main_deps[] = 'cargopress-gmaps';
		}

		// main JS file, conditionally
		if ( true === CARGOPRESS_DEVELOPMENT ) {
			$main_deps[] = 'requirejs';
			wp_enqueue_script( 'cargopress-main', get_template_directory_uri() . '/assets/js/main.js', $main_deps, CARGOPRESS_WP_VERSION, true );
		}
		else {
			wp_enqueue_script( 'cargopress-main', get_template_directory_uri() . '/assets/js/main.min.js', $main_deps, CARGOPRESS_WP_VERSION, true );
		}

		// Pass data to the main script
		wp_localize_script( 'cargopress-main', 'CargoPressVars', array(
			'pathToTheme'  => get_template_directory_uri(),
		) );

		// for nested comments
		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'cargopress_enqueue_scripts' );
}


/**
 * Register admin JS scripts
 */
if ( ! function_exists( 'cargopress_admin_enqueue_scripts' ) ) {
	function cargopress_admin_enqueue_scripts() {
		// mustache for ProteusWidgets
		wp_register_script( 'mustache.js', get_template_directory_uri() . '/bower_components/mustache/mustache.min.js' );

		// enqueue admin utils js
		wp_enqueue_script( 'cargopress-admin-utils', get_template_directory_uri() . '/assets/admin/js/admin.js', array( 'jquery', 'underscore', 'backbone', 'mustache.js' ) );

		// register fa CSS
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/bower_components/font-awesome/css/font-awesome.min.css', array(), '4.3.0' );

	}
	add_action( 'admin_enqueue_scripts', 'cargopress_admin_enqueue_scripts' );
}


/**
 * Require the files in the folder /inc/
 */
$cargopress_files_to_require = array(
	'helpers',
	'theme-widgets',
	'theme-vc-include',
	'theme-sidebars',
	'filters',
	'compat',
	'shortcodes',
	'theme-customizer',
	'custom-comments',
	'woocommerce',
);

// Conditionally require the includes files, based if they exist in the child theme or not
foreach ( $cargopress_files_to_require as $file ) {
	locate_template( sprintf( 'inc/%s.php', $file ), true, true );
}


/**
 * WIA-ARIA nav walker and accompanying JS file
 */

if ( ! function_exists( 'cargopress_wai_aria_js' ) ) {
	function cargopress_wai_aria_js() {
		wp_enqueue_script( 'wp-wai-aria', get_template_directory_uri() . '/vendor/proteusthemes/wai-aria-walker-nav-menu/wai-aria.js', array( 'jquery' ), null, true );
	}
	add_action( 'wp_enqueue_scripts', 'cargopress_wai_aria_js' );
}

/**
 * Require some files only when in admin
 */
if ( is_admin() ) {
	// other files
	$cargopress_admin_files_to_require = array(
		// custom code
		'inc/tgm-plugin-activation',
		'inc/documentation-link',
	);

	foreach ( $cargopress_admin_files_to_require as $file ) {
		locate_template( $file . '.php' , true, true );
	}
}
