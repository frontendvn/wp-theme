<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @package CargoPress
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

class CargoPress_Customizer_Base {
	/**
	 * The singleton manager instance
	 *
	 * @see wp-includes/class-wp-customize-manager.php
	 * @var WP_Customize_Manager
	 */
	protected $wp_customize;

	public function __construct( WP_Customize_Manager $wp_manager ) {
		// set the private propery to instance of wp_manager
		$this->wp_customize = $wp_manager;

		// register the settings/panels/sections/controls, main method
		$this->register();

		/**
		 * Action and filters
		 */

		// render the CSS and cache it to the theme_mod when the setting is saved
		add_action( 'customize_save_after' , array( $this, 'cache_rendered_css' ) );

		// save logo width/height dimensions
		add_action( 'customize_save_logo_img' , array( __CLASS__, 'save_logo_dimensions' ), 10, 1 );

		// flush the rewrite rules after the OT settings are saved
		add_action( 'customize_save_after', 'flush_rewrite_rules' );

		// handle the postMessage transfer method with some dynamically generated JS in the footer of the theme
		add_action( 'wp_footer', array( $this, 'customize_footer_js' ), 30 );
	}

	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	*
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*
	* @see add_action('customize_register',$func)
	*/
	public function register () {
		/**
		 * Settings
		 */

		// branding
		$this->wp_customize->add_setting( 'logo_img' );
		$this->wp_customize->add_setting( 'logo2x_img' );
		$this->wp_customize->add_setting( 'logo_top_margin', array( 'default' => '35' ) );
		$this->wp_customize->add_setting( 'header_logo_width', array( 'default' => '270' ) );

		// header
		$this->wp_customize->add_setting( 'top_bar_visibility', array( 'default' => 'yes' ) );

		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'top_bar_bg', array(
			'default' => '#f5f5f5',
			'css_map' => array(
				'background-color' => array(
					'.top',
					'.top-navigation .sub-menu > li > a',
				),
				'border-bottom-color|darken(3)' => array(
					'.top',
					'.top-navigation .sub-menu > li > a',
				),
				'border-left-color|darken(3)' => array(
					'.top-navigation .sub-menu > li > .sub-menu',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'top_bar_color', array(
			'default' => '#aaaaaa',
			'css_map' => array(
				'color' => array(
					'.top',
					'.top-navigation > li > a',
					'.top-navigation .sub-menu > li > a',
				),
				'color|darken(10)' => array(
					'.top-navigation > li > a:hover',
					'.top-navigation > li > a:focus',
					'.top-navigation .sub-menu > li > a:focus',
					'.top-navigation .sub-menu > li > a:hover',
				),
			)
		) ) );

		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'header_bg', array(
			'default' => '#ffffff',
			'css_map' => array(
				'background-color' => array(
					'.header__widgets',
					'.header__logo',
					'.header__container::before',
					'.header__container::after',
					'.header__logo::after',
					'.header__container|@media (max-width: 991px)',
					'.main-navigation .sub-menu>li>a|@media (max-width: 991px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'header_text', array(
			'default' => '#aaaaaa',
			'css_map' => array(
				'color' => array(
					'.header',
					'.header .icon-box__title',
				),
				'color|darken(39)' => array(
					'.header .icon-box__subtitle',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'breadcrumbs_bg', array(
			'default' => '#ffffff',
			'css_map' => array(
				'background-color' => array(
					'.breadcrumbs',
				),
				'background-color|darken(10)' => array(
					'.breadcrumbs a::before',
					'.breadcrumbs a::after',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'breadcrumbs_color', array(
			'default' => '#444444',
			'css_map' => array(
				'color' => array(
					'.breadcrumbs a',
				),
				'color|darken(5)' => array(
					'.breadcrumbs a:hover',
				),

			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'breadcrumbs_color_active', array(
			'default' => '#aaaaaa',
			'css_map' => array(
				'color' => array(
					'.breadcrumbs',
				),
			)
		) ) );

		// navigation
		$this->wp_customize->add_setting( 'main_navigation_sticky', array( 'default' => 'static' ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_bg', array(
			'default' => '#1f425d',
			'css_map' => array(
				'background-color' => array(
					'.header__container|@media (min-width: 992px)',
					'.is-sticky-nav .header__navigation|@media (min-width: 992px)',
					'.navbar-toggle',
					'.jumbotron',
				),
				'background-color|darken(10)' => array(
					'.navbar-toggle:hover',
				),
				'color' => array(
					'.social-icons__link|@media (min-width: 992px)',
					'.social-icons__link:hover|@media (min-width: 992px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_color', array(
			'default' => '#ffffff',
			'css_map' => array(
				'color' => array(
					'.main-navigation > li > a|@media (min-width: 992px)',
					'.main-navigation .menu-item-has-children::after|@media (min-width: 992px)',
					'.main-navigation > li:hover > a|@media (min-width: 992px)',
					'.main-navigation > li:focus > a|@media (min-width: 992px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_sub_bg', array(
			'default' => '#ffffff',
			'css_map' => array(
				'background-color' => array(
					'.main-navigation .menu-item-has-children:hover > a|@media (min-width: 992px)',
					'.main-navigation .sub-menu > li > a|@media (min-width: 992px)',
					'.main-navigation ul.sub-menu|@media (min-width: 992px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_sub_color', array(
			'default' => '#999999',
			'css_map' => array(
				'color' => array(
					'.main-navigation .sub-menu > li > a|@media (min-width: 992px)',
					'.main-navigation .sub-menu .menu-item-has-children::after|@media (min-width: 992px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_sub_color_hover', array(
			'default' => '#1f425d',
			'css_map' => array(
				'color' => array(
					'.main-navigation .menu-item-has-children:hover > a|@media (min-width: 992px)',
					'.main-navigation .sub-menu > li > a:hover|@media (min-width: 992px)',
					'.main-navigation .menu-item-has-children:hover::after|@media (min-width: 992px)',
					'.main-navigation .sub-menu .menu-item-has-children:hover::after|@media (min-width: 992px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_link_mobile_color', array(
			'default' => '#444444',
			'css_map' => array(
				'color' => array(
					'.main-navigation > li > a|@media (max-width: 991px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_link_mobile_color_hover', array(
			'default' => '#1f425d',
			'css_map' => array(
				'color' => array(
					'.main-navigation > li:hover > a|@media (max-width: 991px)',
					'.main-navigation > li:focus > a|@media (max-width: 991px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_sub_link_mobile_color', array(
			'default' => '#999999',
			'css_map' => array(
				'color' => array(
					'.main-navigation .sub-menu > li > a|@media (max-width: 991px)',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_navigation_sub_link_mobile_color_hover', array(
			'default' => '#1f425d',
			'css_map' => array(
				'color' => array(
					'.main-navigation .sub-menu > li > a:hover|@media (max-width: 991px)',
				),
			)
		) ) );

		// main title area
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_title_bg_img', array(
			'css_map' => array(
				'background-image|url' => array(
					'.main-title',
				),
			)
		) ) );

		$this->wp_customize->add_setting( 'main_title_bg_gradient_setting', array(
			'default' => array(
				'start_color'    => '#f5f5f5',
				'stop_color'     => '#eeeeee',
				'is_gradient'    => true,
				'gradient_angle' => 90,
			),
		) );

		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_title_color', array(
			'default' => '#444444',
			'css_map' => array(
				'color' => array(
					'.main-title h1',
					'.main-title h2',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'main_subtitle_color', array(
			'default' => '#aaaaaa',
			'css_map' => array(
				'color' => array(
					'.main-title h3',
				),
			)
		) ) );

		// typography
		$this->wp_customize->add_setting( 'charset_setting', array( 'default' => 'latin' ) );

		// theme layout & color
		$this->wp_customize->add_setting( 'layout_mode', array( 'default' => 'wide' ) );

		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'text_color', array(
			'default' => '#aaaaaa',
			'css_map' => array(
				'color' => array(
					'body',
					'.widget_pw_icon_box .icon-box__subtitle',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'headings_color', array(
			'default' => '#444444',
			'css_map' => array(
				'color' => array(
					'h1',
					'h2',
					'h3',
					'h4',
					'h5',
					'h6',
					'hentry__title',
					'.hentry__title a',
					'.page-box__title a',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'primary_color', array(
			'default' => '#e21f2f',
			'css_map' => array(
				'color' => array(
					'.header .icon-box .fa',
					'.number-counter__icon',
					'hr.hr-quote::after',
				),
				'background-color' => array(
					'.latest-news__date',
					'.sticky .btn--post',
					'.main-navigation > .current-menu-item > a::after',
					'.main-navigation > li:hover > a::after',
					'.main-navigation > li:focus > a::after',
					'body.woocommerce-page span.onsale',
					'.woocommerce span.onsale',
				),
				'border-top-color|darken(8)' => array(
					'.latest-news__date::after',
				),
				'border-color' => array(
					'.sticky .btn--post',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'primary_button_color', array(
			'default' => '#4ab9cf',
			'css_map' => array(
				'color' => array(),
				'background-color' => array(
					'.btn-info',
					'.btn-primary',
					'.testimonial__quote::before',
					'.widget_search .search-submit',
					'.sidebar .widget_nav_menu ul > li.current-menu-item a',
					'.pagination .current',
					'body.woocommerce-page .widget_shopping_cart_content .buttons .checkout',
					'body.woocommerce-page nav.woocommerce-pagination ul li span.current',
					'body.woocommerce-page button.button.alt',
					'body.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
					'body.woocommerce-page .woocommerce-error a.button',
					'body.woocommerce-page .woocommerce-info a.button',
					'body.woocommerce-page .woocommerce-message a.button',
					'.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
					'body.woocommerce-page #payment #place_order',
					'body.woocommerce-page #review_form #respond input#submit',
					'.woocommerce button.button.alt:disabled',
					'.woocommerce button.button.alt:disabled:hover',
					'.woocommerce button.button.alt:disabled[disabled]',
					'.woocommerce button.button.alt:disabled[disabled]:hover',
					'.widget_calendar caption',
				),
				'border-color' => array(
					'.btn-info',
					'.btn-primary',
					'body.woocommerce-page .widget_shopping_cart_content .buttons .checkout',
				),
				'background-color|darken(5)' => array(
					'.btn-info:hover',
					'.open > .btn-info.dropdown-toggle',
					'.btn-info.active',
					'.btn-info.focus',
					'.btn-info:active',
					'.btn-info:focus',
					'.btn-primary:hover',
					'.btn-primary:focus',
					'.btn-primary:active',
					'.open > .btn-primary.dropdown-toggle',
					'.btn-primary.active',
					'.btn-primary.focus',
					'.widget_search .search-submit:hover',
					'.widget_search .search-submit:focus',
					'body.woocommerce-page .widget_shopping_cart_content .buttons .checkout:hover',
					'body.woocommerce-page button.button.alt:hover',
					'body.woocommerce-page .woocommerce-error a.button:hover',
					'body.woocommerce-page .woocommerce-info a.button:hover',
					'body.woocommerce-page .woocommerce-message a.button:hover',
					'.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover',
					'body.woocommerce-page #payment #place_order:hover',
					'body.woocommerce-page #review_form #respond input#submit:hover',
				),
				'border-color|darken(5)' => array(
					'.btn-info:hover',
					'.open > .btn-info.dropdown-toggle',
					'.btn-info.active',
					'.btn-info.focus',
					'.btn-info:active',
					'.btn-info:focus',
					'.btn-primary:hover',
					'.btn-primary:focus',
					'.btn-primary:active',
					'.open > .btn-primary.dropdown-toggle',
					'.btn-primary.active',
					'.btn-primary.focus',
					'body.woocommerce-page .widget_shopping_cart_content .buttons .checkout:hover',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'link_color', array(
			'default' => '#4ab9cf',
			'css_map' => array(
				'color' => array(
					'a',
					'.latest-news--more-news::after',
					'.widget_pw_icon_box .icon-box:hover .fa',
					'body.woocommerce-page ul.products li.product a:hover img',
					'.woocommerce ul.products li.product a:hover img',
					'body.woocommerce-page ul.products li.product .price',
					'.woocommerce ul.products li.product .price',
					'body.woocommerce-page .star-rating',
					'.woocommerce .star-rating',
					'body.woocommerce-page div.product p.price',
					'body.woocommerce-page p.stars a',
				),
				'color|darken(5)' => array(
					'a:hover',
					'a:focus',
				),
				'border-bottom-color' => array(
					'.widget_pw_icon_box .icon-box:hover',
					'.logo-panel img:hover',
				),
			)
		) ) );

		// shop
		$this->wp_customize->add_setting( 'products_per_page', array( 'default' => 12 ) );
		$this->wp_customize->add_setting( 'single_product_sidebar', array( 'default' => 'left' ) );

		// footer
		$this->wp_customize->add_setting( 'footer_widgets_layout', array( 'default' => '[4,6,8]' ) );

		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_bg_color', array(
			'default' => '#1f425d',
			'css_map' => array(
				'background-color' => array(
					'.footer-top',
					'.footer::before',
					'.footer::after',
					'.footer-top::before',
					'.footer-top::after',
				),
				'color' => array(
					'.footer .icon-container--square',
					'.footer .icon-container--circle',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_title_color', array(
			'default' => '#ffffff',
			'css_map' => array(
				'color' => array(
					'.footer-top__headings',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_text_color', array(
			'default' => '#9eb7cb',
			'css_map' => array(
				'color' => array(
					'.footer-top',
					'.footer-top .textwidget',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_link_color', array(
			'default' => '#9eb7cb',
			'css_map' => array(
				'color' => array(
					'.footer .widget_nav_menu ul > li > a',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_bottom_bg_color', array(
			'default' => '#162f42',
			'css_map' => array(
				'background-color' => array(
					'.footer-bottom',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_bottom_text_color', array(
			'default' => '#577186',
			'css_map' => array(
				'color' => array(
					'.footer-bottom',
				),
			)
		) ) );
		$this->wp_customize->add_setting( new ProteusThemes_Customize_Setting_Dynamic_CSS( $this->wp_customize, 'footer_bottom_link_color', array(
			'default' => '#eeeeee',
			'css_map' => array(
				'color' => array(
					'.footer-bottom a',
				),
				'color|lighten(5)' => array(
					'.footer-bottom a:hover',
				),
			)
		) ) );
		$this->wp_customize->add_setting( 'footer_left_txt', array( 'default' => 'CargoPress Theme Made by <a href="https://www.proteusthemes.com/">ProteusThemes</a>.' ) );
		$this->wp_customize->add_setting( 'footer_right_txt', array( 'default' => 'Copyright &copy; 2009–2015 CargoPress. All rights reserved.' ) );

		// custom code (css/js)
		$this->wp_customize->add_setting( 'custom_css', array( 'default' => '' ) );
		$this->wp_customize->add_setting( 'custom_js_head' );
		$this->wp_customize->add_setting( 'custom_js_footer' );

		// acf
		$this->wp_customize->add_setting( 'show_acf', array( 'default' => 'no' ) );

		/**
		 * Panel and Sections
		 */

		// one ProteusThemes panel to rule them all
		$this->wp_customize->add_panel( 'panel_cargopress', array(
			'title'       => _x( '[PT] Theme Options', 'backend', 'cargopress-pt' ),
			'description' => _x( 'All CargoPress theme specific settings.', 'backend', 'cargopress-pt' ),
			'priority'    => 10,
		) );

		// individual sections

		// Logo
		$logo_section_array = array(
			'title'       => _x( 'Logo', 'backend', 'cargopress-pt' ),
			'description' => _x( 'Logo settings for the CargoPress theme.', 'backend', 'cargopress-pt' ),
			'priority'    => 10,
			'panel'       => 'panel_cargopress',
		);

		// Theme favicon section, which will be phased out, because of WP core favicon integration
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
			$logo_section_array['title']       = _x( 'Logo &amp; Favicon', 'backend', 'cargopress-pt' );
			$logo_section_array['description'] = _x( 'Logo &amp; Favicon for the CargoPress theme.', 'backend', 'cargopress-pt' );
		}

		$this->wp_customize->add_section( 'cargopress_section_logos', $logo_section_array );

		// Header
		$this->wp_customize->add_section( 'cargopress_section_header', array(
			'title'       => _x( 'Header &amp; Breadcrumbs', 'backend', 'cargopress-pt' ),
			'description' => _x( 'All layout and appearance settings for the header and breadcrumbs.', 'backend', 'cargopress-pt' ),
			'priority'    => 20,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'cargopress_section_navigation', array(
			'title'       => _x( 'Navigation', 'backend', 'cargopress-pt' ),
			'description' => _x( 'Navigation for the CargoPress theme.', 'backend', 'cargopress-pt' ),
			'priority'    => 30,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'cargopress_section_main_title', array(
			'title'       => _x( 'Main Title Area', 'backend', 'cargopress-pt' ),
			'description' => _x( 'All layout and appearance settings for the main title area (regular pages).', 'backend', 'cargopress-pt' ),
			'priority'    => 33,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'cargopress_section_typography', array(
			'title'       => _x( 'Typography', 'backend', 'cargopress-pt' ),
			'priority'    => 35,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'cargopress_section_theme_colors', array(
			'title'       => _x( 'Theme Layout &amp; Colors', 'backend', 'cargopress-pt' ),
			'priority'    => 40,
			'panel'       => 'panel_cargopress',
		) );

		if ( CargoPressHelpers::is_woocommerce_active() ) {
			$this->wp_customize->add_section( 'cargopress_section_shop', array(
				'title'       => _x( 'Shop', 'backend', 'cargopress-pt' ),
				'priority'    => 80,
				'panel'       => 'panel_cargopress',
			) );
		}

		$this->wp_customize->add_section( 'section_footer', array(
			'title'       => _x( 'Footer', 'backend', 'cargopress-pt' ),
			'description' => _x( 'All layout and appearance settings for the footer.', 'backend', 'cargopress-pt' ),
			'priority'    => 90,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'section_custom_code', array(
			'title'       => _x( 'Custom Code' , 'backend', 'cargopress-pt' ),
			'priority'    => 100,
			'panel'       => 'panel_cargopress',
		) );

		$this->wp_customize->add_section( 'section_other', array(
			'title'       => _x( 'Other' , 'backend', 'cargopress-pt' ),
			'priority'    => 150,
			'panel'       => 'panel_cargopress',
		) );

		/**
		 * Controls
		 */

		// Section: cargopress_section_logos
		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'logo_img',
			array(
				'label'       => _x( 'Logo Image', 'backend', 'cargopress-pt' ),
				'description' => _x( 'Max height for the logo image is 120px.', 'backend', 'cargopress-pt' ),
				'section'     => 'cargopress_section_logos',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'logo2x_img',
			array(
				'label'       => _x( 'Retina Logo Image', 'backend', 'cargopress-pt' ),
				'description' => _x( '2x logo size, for screens with high DPI.', 'backend', 'cargopress-pt' ),
				'section'     => 'cargopress_section_logos',
			)
		) );
		$this->wp_customize->add_control(
			'logo_top_margin',
			array(
				'type'        => 'number',
				'label'       => _x( 'Logo top margin', 'backend', 'cargopress-pt' ),
				'description' => _x( 'In pixels.', 'backend', 'cargopress-pt' ),
				'section'     => 'cargopress_section_logos',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 120,
					'step' => 10,
				),
			)
		);
		$this->wp_customize->add_control(
			'header_logo_width',
			array(
				'type'        => 'range',
				'label'       => _x( 'Logo width', 'backend', 'cargopress-pt' ),
				'section'     => 'cargopress_section_logos',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 600,
					'step' => 5,
				),
			)
		);

		// Section: header
		$this->wp_customize->add_control( 'top_bar_visibility', array(
			'type'        => 'select',
			'priority'    => 0,
			'label'       => _x( 'Top bar visibility', 'backend', 'cargopress-pt' ),
			'description' => _x( 'Show or hide?', 'backend', 'cargopress-pt' ),
			'section'     => 'cargopress_section_header',
			'choices'     => array(
				'yes' => _x( 'Show', 'backend', 'cargopress-pt' ),
				'no'  => _x( 'Hide', 'backend', 'cargopress-pt' ),
			),
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'top_bar_bg',
			array(
				'priority' => 1,
				'label'    => _x( 'Top bar background color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'top_bar_color',
			array(
				'priority' => 2,
				'label'    => _x( 'Top bar text color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'header_bg',
			array(
				'priority' => 30,
				'label'    => _x( 'Header background color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'header_text',
			array(
				'priority' => 32,
				'label'    => _x( 'Header text color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'breadcrumbs_bg',
			array(
				'priority' => 60,
				'label'    => _x( 'Breadcrumbs background color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'breadcrumbs_color',
			array(
				'priority' => 61,
				'label'    => _x( 'Breadcrumbs text color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'breadcrumbs_color_active',
			array(
				'priority' => 62,
				'label'    => _x( 'Breadcrumbs active text color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_header',
			)
		) );

		// Section: cargopress_section_navigation
		$this->wp_customize->add_control( 'main_navigation_sticky', array(
			'type'        => 'select',
			'priority'    => 110,
			'label'       => _x( 'Static or sticky navbar?', 'backend', 'cargopress-pt' ),
			'section'     => 'cargopress_section_navigation',
			'choices'     => array(
				'static' => _x( 'Static', 'backend', 'cargopress-pt' ),
				'sticky' => _x( 'Sticky', 'backend', 'cargopress-pt' ),
			),
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_bg',
			array(
				'priority' => 120,
				'label'    => _x( 'Main navigation background color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_color',
			array(
				'priority' => 130,
				'label'    => _x( 'Main navigation link color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_bg',
			array(
				'priority' => 160,
				'label'    => _x( 'Main navigation submenu background', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_color',
			array(
				'priority' => 170,
				'label'    => _x( 'Main navigation submenu link color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_color_hover',
			array(
				'priority' => 175,
				'label'    => _x( 'Main navigation submenu link color hover', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_link_mobile_color',
			array(
				'priority' => 180,
				'label'    => _x( 'Main navigation link color (mobile)', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_link_mobile_color_hover',
			array(
				'priority' => 190,
				'label'    => _x( 'Main navigation link hover color (mobile)', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_link_mobile_color',
			array(
				'priority' => 200,
				'label'    => _x( 'Main navigation submenu link color (mobile)', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_navigation_sub_link_mobile_color_hover',
			array(
				'priority' => 210,
				'label'    => _x( 'Main navigation submenu link hover color (mobile)', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_navigation',
			)
		) );

		// section: cargopress_section_main_title
		$this->wp_customize->add_control( new WP_Customize_Gradient_Control(
			$this->wp_customize,
			'main_title_bg_gradient_setting',
			array(
				'priority' => 11,
				'label'    => _x( 'Main title background color', 'backend', 'cargopress-pt' ),
				'description' => _x( 'Select single color or a gradient. You can also change the angle of the gradient with the range control.', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_main_title',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Image_Control(
			$this->wp_customize,
			'main_title_bg_img',
			array(
				'priority' => 20,
				'label'    => _x( 'Main title background pattern', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_main_title',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_title_color',
			array(
				'priority' => 30,
				'label'    => _x( 'Main title color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_main_title',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'main_subtitle_color',
			array(
				'priority' => 31,
				'label'    => _x( 'Main subtitle color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_main_title',
			)
		) );

		// Section: cargopress_section_typography
		$this->wp_customize->add_control( 'charset_setting', array(
			'type'     => 'select',
			'priority' => 0,
			'label'    => _x( 'Character set for Google Fonts', 'backend' , 'cargopress-pt' ),
			'section'  => 'cargopress_section_typography',
			'choices'  => array(
				'latin'        => 'Latin',
				'latin-ext'    => 'Latin Extended',
				'cyrillic'     => 'Cyrillic',
				'cyrillic-ext' => 'Cyrillic Extended',
			)
		) );

		// Section: cargopress_section_theme_colors
		$this->wp_customize->add_control( 'layout_mode', array(
			'type'     => 'select',
			'priority' => 10,
			'label'    => _x( 'Layout', 'backend', 'cargopress-pt' ),
			'section'  => 'cargopress_section_theme_colors',
			'choices'  => array(
				'wide'  => _x( 'Wide', 'backend', 'cargopress-pt' ),
				'boxed' => _x( 'Boxed', 'backend', 'cargopress-pt' ),
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'text_color',
			array(
				'priority' => 30,
				'label'    => _x( 'Text color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_theme_colors',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'headings_color',
			array(
				'priority' => 31,
				'label'    => _x( 'Headings color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_theme_colors',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_color',
			array(
				'priority' => 32,
				'label'    => _x( 'Primary color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_theme_colors',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_button_color',
			array(
				'priority' => 33,
				'label'    => _x( 'Primary Button color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_theme_colors',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'link_color',
			array(
				'priority' => 34,
				'label'    => _x( 'Link color', 'backend', 'cargopress-pt' ),
				'section'  => 'cargopress_section_theme_colors',
			)
		) );

		// Section: cargopress_section_shop
		if ( CargoPressHelpers::is_woocommerce_active() ) {
			$this->wp_customize->add_control( 'products_per_page', array(
					'label'   => _x( 'Number of products per page', 'backend', 'cargopress-pt' ),
					'section' => 'cargopress_section_shop',
				)
			);
			$this->wp_customize->add_control( 'single_product_sidebar', array(
					'label'   => _x( 'Sidebar on single product page', 'backend', 'cargopress-pt' ),
					'section' => 'cargopress_section_shop',
					'type'    => 'select',
					'choices' => array(
						'none'  => _x( 'No sidebar', 'backend', 'cargopress-pt' ),
						'left'  => _x( 'Left', 'backend', 'cargopress-pt' ),
						'right' => _x( 'Right', 'backend', 'cargopress-pt' ),
					)
				)
			);
		}

		// Section: section_footer
		$this->wp_customize->add_control( new WP_Customize_Range_Control(
			$this->wp_customize,
			'footer_widgets_layout',
			array(
				'priority'    => 1,
				'label'       => _x( 'Footer widgets layout', 'backend', 'cargopress-pt' ),
				'description' => _x( 'Select number of widget you want in the footer and then with the slider rearrange the layout', 'backend', 'cargopress-pt' ),
				'section'     => 'section_footer',
				'input_attrs' => array(
					'min'     => 0,
					'max'     => 12,
					'step'    => 1,
					'maxCols' => 6,
				)
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bg_color',
			array(
				'priority' => 10,
				'label'    => _x( 'Footer background color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );
		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_title_color',
			array(
				'priority' => 30,
				'label'    => _x( 'Footer widget title color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_text_color',
			array(
				'priority' => 31,
				'label'    => _x( 'Footer text color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_link_color',
			array(
				'priority' => 32,
				'label'    => _x( 'Footer link color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_bg_color',
			array(
				'priority' => 35,
				'label'    => _x( 'Footer bottom background color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_text_color',
			array(
				'priority' => 36,
				'label'    => _x( 'Footer bottom text color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'footer_bottom_link_color',
			array(
				'priority' => 37,
				'label'    => _x( 'Footer bottom link color', 'backend', 'cargopress-pt' ),
				'section'  => 'section_footer',
			)
		) );

		$this->wp_customize->add_control( 'footer_left_txt', array(
				'type'        => 'text',
				'priority'    => 110,
				'label'       => _x( 'Footer text on left', 'backend', 'cargopress-pt' ),
				'description' => _x( 'Before footer menu. You can use HTML.', 'backend', 'cargopress-pt' ),
				'section'     => 'section_footer',
			) );

		$this->wp_customize->add_control( 'footer_right_txt', array(
			'type'        => 'text',
			'priority'    => 120,
			'label'       => _x( 'Footer text on right', 'backend', 'cargopress-pt' ),
			'description' => _x( 'You can use HTML.', 'backend', 'cargopress-pt' ),
			'section'     => 'section_footer',
		) );

		// Section: section_custom_code
		$this->wp_customize->add_control( 'custom_css', array(
			'type'        => 'textarea',
			'label'       => _x( 'Custom CSS', 'backend', 'cargopress-pt' ),
			'description' => sprintf( _x( '%s How to find CSS classes %s in the theme.', 'backend', 'cargopress-pt' ), '<a href="https://www.youtube.com/watch?v=V2aAEzlvyDc" target="_blank">', '</a>' ),
			'section'     => 'section_custom_code',
		) );

		$this->wp_customize->add_control( 'custom_js_head', array(
			'type'        => 'textarea',
			'label'       => _x( 'Custom JavaScript (head)', 'backend', 'cargopress-pt' ),
			'description' => _x( 'You have to include the &lt;script&gt;&lt;/script&gt; tags as well. Paste your Google Analytics tracking code here.', 'backend', 'cargopress-pt' ),
			'section'     => 'section_custom_code',
		) );

		$this->wp_customize->add_control( 'custom_js_footer', array(
			'type'        => 'textarea',
			'label'       => _x( 'Custom JavaScript (footer)', 'backend', 'cargopress-pt' ),
			'description' => _x( 'You have to include the &lt;script&gt;&lt;/script&gt; tags as well.', 'backend', 'cargopress-pt' ),
			'section'     => 'section_custom_code',
		) );

		// Section: section_other
		$this->wp_customize->add_control( 'show_acf', array(
			'type'        => 'select',
			'label'       => _x( 'Show ACF admin panel?', 'backend', 'cargopress-pt' ),
			'description' => _x( 'If you want to use ACF and need the ACF admin panel set this to <strong>Yes</strong>. Do not change if you do not know what you are doing.', 'backend', 'cargopress-pt' ),
			'section'     => 'section_other',
			'choices'     => array(
				'no'  => _x( 'No', 'backend', 'cargopress-pt' ),
				'yes' => _x( 'Yes', 'backend', 'cargopress-pt' ),
			),
		) );

		// Theme favicon setting and control, which will be phased out, because of WP core favicon integration
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
			$this->wp_customize->add_setting( 'favicon' );

			$this->wp_customize->add_control( new WP_Customize_Image_Control(
				$this->wp_customize,
				'favicon',
				array(
					'label'       => _x( 'Favicon Image', 'backend', 'cargopress-pt' ),
					'description' => _x( 'Recommended dimensions are 32 x 32px.', 'backend', 'cargopress-pt' ),
					'section'     => 'cargopress_section_logos',
				)
			) );
		}
	}

	/**
	 * Cache the rendered CSS after the settings are saved in the DB.
	 * This is purely a performance improvement.
	 *
	 * Used by hook: add_action( 'customize_save_after' , array( $this, 'cache_rendered_css' ) );
	 *
	 * @return void
	 */
	public function cache_rendered_css() {
		set_theme_mod( 'cached_css', $this->render_css() );
	}

	/**
	 * Get the dimensions of the logo image when the setting is saved
	 * This is purely a performance improvement.
	 *
	 * Used by hook: add_action( 'customize_save_logo_img' , array( $this, 'save_logo_dimensions' ), 10, 1 );
	 *
	 * @return void
	 */
	public static function save_logo_dimensions( $setting ) {
		$logo_width_height = array();
		$img_data          = getimagesize( esc_url( $setting->post_value() ) );

		if ( is_array( $img_data ) ) {
			$logo_width_height = array_slice( $img_data, 0, 2 );
			$logo_width_height = array_combine( array( 'width', 'height' ), $logo_width_height );
		}

		set_theme_mod( 'logo_dimensions_array', $logo_width_height );
	}

	/**
	 * Render the CSS from all the settings which are of type `ProteusThemes_Customize_Setting_Dynamic_CSS`
	 *
	 * @return string text/css
	 */
	public function render_css() {
		$out = '';

		foreach ( $this->get_dynamic_css_settings() as $setting ) {
			$out .= $setting->render_css();
		}

		return $out;
	}

	/**
	 * Get only the CSS settings of type `ProteusThemes_Customize_Setting_Dynamic_CSS`.
	 *
	 * @see is_dynamic_css_setting
	 * @return array
	 */
	public function get_dynamic_css_settings() {
		return array_filter( $this->wp_customize->settings(), array( $this, 'is_dynamic_css_setting' ) );
	}

	/**
	 * Helper conditional function for filtering the settings.
	 *
	 * @see
	 * @param  mixed  $setting
	 * @return boolean
	 */
	protected function is_dynamic_css_setting( $setting ) {
		return is_a( $setting, 'ProteusThemes_Customize_Setting_Dynamic_CSS' );
	}

	/**
	 * Dynamically generate the JS for previewing the settings of type `ProteusThemes_Customize_Setting_Dynamic_CSS`.
	 *
	 * This function is better for the UX, since all the color changes are transported to the live
	 * preview frame using the 'postMessage' method. Since the JS is generated on-the-fly and we have a single
	 * entry point of entering settings along with related css properties and classes, we cannnot forget to
	 * include the setting in the customizer itself. Neat, man!
	 *
	 * @return string text/javascript
	 */
	public function customize_footer_js() {
		$settings = $this->get_dynamic_css_settings();

		ob_start();
		?>

			<script type="text/javascript">
				( function( $ ) {
					'use strict';

				<?php
				foreach ( $settings as $key_id => $setting ) :
				?>

					wp.customize( '<?php echo esc_js( $key_id ); ?>', function( value ) {
						value.bind( function( newval ) {

						<?php
						foreach ( $setting->get_css_map() as $css_prop_raw => $css_selectors ) {
							extract( $setting->filter_css_property( $css_prop_raw ) );

							// background image needs a little bit different treatment
							if ( 'background-image' === $css_prop ) {
								echo 'newval = "url(" + newval + ")";' . PHP_EOL;
							}

							printf( '$( "%1$s" ).css( "%2$s", newval );%3$s', $setting->plain_selectors_for_all_groups( $css_prop_raw ), $css_prop, PHP_EOL );
						}
						?>

						} );
					} );

				<?php
				endforeach;
				?>

				} )( jQuery );
			</script>

		<?php

		echo ob_get_clean();
	}
}