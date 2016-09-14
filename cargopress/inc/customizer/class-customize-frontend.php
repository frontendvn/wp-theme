<?php
/**
 * Class which handles the output of the WP customizer on the frontend.
 * Meaning that this stuff loads always, no matter if the global $wp_cutomize
 * variable is present or not.
 */

/**
 * Customizer frontend related code
 */
class CargoPress_Customize_Frontent {

	/**
	 * Add actions to load the right staff at the right places (header, footer).
	 */
	function __construct() {
		if ( apply_filters( 'cargopress_output_customizer_css', true ) ) {
			add_action( 'wp_enqueue_scripts' , array( $this, 'customizer_css' ), 20 );
		}
		add_action( 'wp_head' , array( $this, 'head_output' ) );
		add_action( 'wp_footer' , array( $this, 'footer_output' ) );
	}

	/**
	* This will output the custom WordPress settings to the live theme's WP head.
	*
	* Used by hook: 'wp_head'
	*
	* @see add_action( 'wp_head' , array( $this, 'head_output' ) );
	*/
	public static function customizer_css() {
		$css = array();

		$css[] = self::get_customizer_colors_css();
		$css[] = self::get_variable_logo_width_css();
		$css[] = self::get_main_title_background_gradient_css();
		$css[] = self::get_logo_top_margin_css();
		$css[] = self::get_custom_css();

		$css_string = join( PHP_EOL, $css );

		if ( $css_string ) {
			wp_add_inline_style( 'cargopress-main', $css_string );
		}
	}


	/**
	 * Branding CSS, generated dynamically and cached stringifyed in db
	 * @return string CSS
	 */
	public static function get_customizer_colors_css() {
		$out        = '';
		$cached_css = get_theme_mod( 'cached_css', '' );

		$out .= '/* WP Customizer start */' . PHP_EOL;
		$out .= apply_filters( 'pt/cargopress/cached_css', $cached_css );
		$out .= '/* WP Customizer end */';

		return $out;
	}


	/**
	 * Custom CSS, written in customizer
	 * @return string CSS
	 */
	public static function get_custom_css() {
		$out      = '';
		$user_css = get_theme_mod( 'custom_css', '' );

		if ( strlen( $user_css ) ) {
			$out .= PHP_EOL . '/* User custom CSS start */' . PHP_EOL;
			$out .= $user_css . PHP_EOL; // no need to filter this, because it is 100% custom code
			$out .= PHP_EOL . '/* User custom CSS end */' . PHP_EOL;
		}

		return $out;
	}


	/**
	 * Custom logo width CSS, defined with setting "header_logo_width"
	 *
	 * @return string CSS
	 */
	public static function get_variable_logo_width_css() {
		return sprintf( '
			@media (min-width: 992px) {
				.header__logo {
					width: %1$dpx;
				}
				.header__widgets {
					width: calc(100%% - %1$dpx);
				}
				.header__navigation {
					width: %3$s%%;
				}
			}
			@media (min-width: 1200px) {
				.header__navigation {
					width: calc(%4$s%% - %2$dpx);
					margin-left: %2$dpx;
				}
			}',
			absint( get_theme_mod( 'header_logo_width', 270 ) ),
			absint( 30 + (int) get_theme_mod( 'header_logo_width', 270 ) ),
			is_active_sidebar( 'navigation-widgets' ) ? '75' : '100',
			is_active_sidebar( 'navigation-widgets' ) ? '80' : '100'
		);
	}


	/**
	 * Set top margin of the logo
	 *
	 * @return string CSS
	 */
	public static function get_logo_top_margin_css() {
		return sprintf( '
			@media (min-width: 992px){
				.header__logo img {
					margin-top: %dpx;
				}
			}',
			absint( get_theme_mod( 'logo_top_margin', 35 ) )
		);
	}


	/**
	 * Main title background gradient or solid color
	 *
	 * @return string CSS
	 */
	public static function get_main_title_background_gradient_css() {
			// get theme settings for the gradient control
		$main_title_background_settings = get_theme_mod(
			'main_title_bg_gradient_setting',
			array(
				'start_color'    => '#f5f5f5',
				'stop_color'     => '#eeeeee',
				'is_gradient'    => true,
				'gradient_angle' => 90,
			)
		);
		$output_gradient_css = '';

		if ( $main_title_background_settings['is_gradient'] ) {
			$output_gradient_css = sprintf(
				'background: %1$s linear-gradient(%3$sdeg, %1$s, %2$s)',
				$main_title_background_settings['start_color'],
				$main_title_background_settings['stop_color'],
				$main_title_background_settings['gradient_angle']
			);
		}
		else {
			$output_gradient_css = sprintf( 'background-color: %1$s', $main_title_background_settings['start_color'] );
		}

		return sprintf( '.main-title { %1$s }', $output_gradient_css );
	}


	/**
	 * Outputs the code in head of the every page
	 *
	 * Used by hook: add_action( 'wp_head' , array( $this, 'head_output' ) );
	 */
	public static function head_output() {

		// Theme favicon output, which will be phased out, because of WP core favicon integration
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
			// favicon from customizer
			$favicon = get_theme_mod( 'favicon' );

			if ( ! empty( $favicon ) ) {
				printf( '<link rel="shortcut icon" href="%1$s">', esc_attr( $favicon ) );
			}
		}

		// custom JS from the customizer
		$script = get_theme_mod( 'custom_js_head', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}

	}

	/**
	 * Outputs the code in footer of the every page, right before closing </body>
	 *
	 * Used by hook: add_action( 'wp_footer' , array( $this, 'footer_output' ) );
	 */
	public static function footer_output() {
		$script = get_theme_mod( 'custom_js_footer', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}
	}
}