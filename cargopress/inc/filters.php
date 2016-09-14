<?php
/**
 * Filters for CargoPress WP theme
 *
 * @package CargoPress
 */

class CargoPressFilters {

	function __construct() {
		// Add shortcodes in widgets
		add_filter( 'widget_text', 'do_shortcode' );

		// ProteusWidgets
		add_filter( 'pw/widget_views_path', array( $this, 'set_widgets_view_path' ) );
		add_filter( 'pw/testimonial_widget', array( $this, 'set_testimonial_settings' ) );
		add_filter( 'pw/number_counter_widget', array( $this, 'set_number_counter_settings' ) );
		add_filter( 'pw/google_map_skins', array( $this, 'set_google_maps_skins' ) );
		add_filter( 'pw/featured_page_widget_page_box_image_size', array( $this, 'set_page_box_image_size' ) );
		add_filter( 'pw/featured_page_widget_inline_image_size', array( $this, 'set_inline_image_size' ) );

		// Custom tag font size
		add_filter( 'widget_tag_cloud_args', array( $this, 'set_tag_cloud_sizes' ) );

		// Custom text after excerpt
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

		// Footer widgets with dynamic layouts
		add_filter( 'dynamic_sidebar_params', array( $this, 'footer_widgets_params' ), 9, 1 );

		// Google fonts
		add_filter( 'pre_google_web_fonts', array( $this, 'additional_fonts' ) );
		add_filter( 'subsets_google_web_fonts', array( $this, 'subsets_google_web_fonts' ) );

		// Page builder
		add_filter( 'siteorigin_panels_widget_style_fields', array( $this, 'add_fields_to_pagebuilder_widget_panel' ) );
		add_filter( 'siteorigin_panels_widget_style_attributes', array( $this, 'add_attributes_to_pagebuilder_widget_panel' ), 10, 2 );
		add_filter( 'siteorigin_panels_settings_defaults', array( $this, 'siteorigin_panels_settings_defaults' ) );

		// Breadcrumbs NavXT
		add_filter( 'bcn_settings_init', array( $this, 'breadcrumbs_navxt_settings_defaults' ) );

		// Embeds
		add_filter( 'embed_oembed_html', array( $this, 'embed_oembed_html' ), 10, 1 );

		// Protocols
		add_filter( 'kses_allowed_protocols', array( $this, 'kses_allowed_protocols' ) );

		// Filter the text in the footer
		foreach ( array( 'cargopress/footer_left_txt', 'cargopress/footer_right_txt' ) as $cargopress_filter ) {
			add_filter( $cargopress_filter, 'wptexturize' );
			add_filter( $cargopress_filter, 'convert_chars' );
			add_filter( $cargopress_filter, 'capital_P_dangit' );
		}

		// One Click Demo Import plugin
		add_filter( 'pt-ocdi/import_files', array( $this, 'ocdi_import_files' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'ocdi_after_import_setup' ) );
		add_filter( 'pt-ocdi/message_after_file_fetching_error', array( $this, 'ocdi_message_after_file_fetching_error' ) );
	}


	/**
	* Filter the Testimonial widget fields that the CargoPress theme will need from ProteusWidgets - Testimonial widget
	*/
	function set_testimonial_settings( $attr ) {
		$attr['number_of_testimonial_per_slide'] = 2;
		$attr['rating']                          = false;
		$attr['author_description']              = true;
		return $attr;
	}


	/**
	* Filter the Number Counter widget settings that the CargoPress theme will need from ProteusWidgets - Number Counter widget
	*/
	function set_number_counter_settings( $attr ) {
		$attr['icon'] = true;
		return $attr;
	}


	/**
	 * Custom tag font size
	 */
	function set_tag_cloud_sizes($args) {
		$args['smallest'] = 8;
		$args['largest']  = 12;
		return $args;
	}


	/**
	 * Custom text after excerpt
	 */
	function excerpt_more( $more ) {
		return _x( ' &hellip;', 'custom read more text after the post excerpts' , 'cargopress-pt' );
	}


	/**
	 * Filter the dynamic sidebars and alter the BS col classes for the footer wigets
	 * @param  array $params
	 * @return array
	 */
	function footer_widgets_params( $params ) {
		static $counter              = 0;
		static $first_row            = true;
		$footer_widgets_layout_array = CargoPressHelpers::footer_widgets_layout_array();

		if ( 'footer-widgets' === $params[0]['id'] ) {
			// 'before_widget' contains __col-num__, see inc/theme-sidebars.php
			$params[0]['before_widget'] = str_replace( '__col-num__', $footer_widgets_layout_array[ $counter ], $params[0]['before_widget'] );

			// first widget in the any non-first row
			if ( false === $first_row && 0 === $counter ) {
				$params[0]['before_widget'] = '</div><div class="row">' . $params[0]['before_widget'];
			}

			$counter++;
		}

		end( $footer_widgets_layout_array );
		if ( $counter > key( $footer_widgets_layout_array ) ) {
			$counter   = 0;
			$first_row = false;
		}

		return $params;
	}


	/**
	 * Filter for CargoPress skin of google maps widget (ProteusWidgets)
	 * @param  array $skins
	 * @return array
	 */
	function set_google_maps_skins( $skins ) {
		if ( ! isset( $skins['CargoPress'] ) ) {
			$skins['CargoPress'] = '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#eeeeee"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"color":"#dddddd"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry.fill","stylers":[{"color":"#dddddd"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#1f425d"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#979797"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"weight":"0.01"}]}]';
		}

		return $skins;
	}


	/**
	 * Filter setting ProteusWidgets mustache widget views path for CargoPress
	 */
	function set_widgets_view_path() {
		return get_template_directory() . '/inc/widgets-views';
	}


	/**
	* Filter the Featured page widget pw-page-box image size for CargoPress (ProteusWidgets)
	*/
	function set_page_box_image_size( $image ) {
		$image['width']  = 360;
		$image['height'] = 240;
		return $image;
	}


	/**
	* Filter the Featured page widget pw-inline image size for CargoPress (ProteusWidgets)
	*/
	function set_inline_image_size( $image ) {
		$image['width']  = 100;
		$image['height'] = 70;
		return $image;
	}


	/**
	 * Return Google fonts and sizes
	 *
	 * @see https://github.com/grappler/wp-standard-handles/blob/master/functions.php
	 * @return array Google fonts and sizes.
	 */
	function additional_fonts( $fonts ) {

		/* translators: If there are characters in your language that are not supported by Noto Serif, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'cargopress-pt' ) ) {
			$fonts['Roboto'] = array(
				'400' => '400',
				'700' => '700',
			);
			$fonts['Source Sans Pro'] = array(
				'700' => '700',
				'900' => '900',
			);
		}

		return $fonts;
	}


	/**
	 * Add subsets from customizer, if needed.
	 *
	 * @return array
	 */
	function subsets_google_web_fonts( $subsets ) {
		$additional_subset = get_theme_mod( 'charset_setting', 'latin' );

		array_push( $subsets, $additional_subset );

		return $subsets;
	}


	/**
	 * Add the "featured widget" checkbox to the PageBuilder widget panel under Design section.
	 * @link https://siteorigin.com/docs/page-builder/hooks/custom-row-settings/
	 * @param $fields Array of all existing (default) PageBuilder widget settings fields
	 * @return array
	 */
	function add_fields_to_pagebuilder_widget_panel( $fields ) {
		$fields['featured_widgets'] = array(
			'name'     => _x( 'Widget Style', 'backend', 'cargopress-pt' ),
			'type'     => 'checkbox',
			'label'    => _x( 'Set a box around the widget', 'backend', 'cargopress-pt' ),
			'group'    => 'design',
			'priority' => 17,
		);

		$fields['bigger_title'] = array(
			'name'     => _x( 'Widget Title', 'backend', 'cargopress-pt' ),
			'type'     => 'checkbox',
			'label'    => _x( 'Exposed title (bigger font, thin line)', 'backend', 'cargopress-pt' ),
			'group'    => 'design',
			'priority' => 18,
		);

		return $fields;
	}


	/**
	 * Add the functionality of the above "featured widget" checkbox
	 * @link https://siteorigin.com/docs/page-builder/hooks/custom-row-settings/
	 * @param $attributes Array of all attributes that get applied to the widget on front-end
	 * @param $args Array of all settings from the widget panel
	 * @return array
	 */
	function add_attributes_to_pagebuilder_widget_panel( $attributes, $args ) {
		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = array();
		}

		if ( ! empty( $args['featured_widgets'] ) ) {
			$attributes['class'][] = 'featured-widget';
		}

		if ( ! empty( $args['bigger_title'] ) ) {
			$attributes['class'][] = 'widget-title--big';
		}

		return $attributes;
	}


	/**
	 * Embedded videos and video container around them
	 */
	function embed_oembed_html( $html ) {
		if (
			false !== strstr( $html, 'youtube.com' ) ||
			false !== strstr( $html, 'wordpress.tv' ) ||
			false !== strstr( $html, 'wordpress.com' ) ||
			false !== strstr( $html, 'vimeo.com' )
		) {
			$out = '<div class="embed-responsive  embed-responsive-16by9">' . $html . '</div>';
		} else {
			$out = $html;
		}
		return $out;
	}


	/**
	 * Add more allowed protocols
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_allowed_protocols/
	 */
	static function kses_allowed_protocols( $protocols ) {
		return array_merge( $protocols, array( 'skype' ) );
	}


	/**
	 * Change the default settings for SO
	 * @param  array $settings
	 * @return array
	 */
	function siteorigin_panels_settings_defaults( $settings ) {
		$settings['title-html']           = '<h3 class="widget-title"><span class="widget-title__inline">{{title}}</span></h3>';
		$settings['full-width-container'] = '.boxed-container';
		$settings['mobile-width']         = '991';

		return $settings;
	}


	/**
	 * Change the default settings for Breadcrumbs NavXT plugin
	 * @param  array $settings
	 * @return array
	 */
	function breadcrumbs_navxt_settings_defaults( $settings ) {
		$settings['hseparator'] = '';

		$shop_page = get_page_by_title( 'Shop' );
		if ( ! is_null( $shop_page ) ) {
			$settings['apost_product_root'] = $shop_page->ID;
		}

		return $settings;
	}


	/**
	 * Define demo import files for One Click Demo Import plugin.
	 */
	function ocdi_import_files() {
		return array(
			array(
				'import_file_name'       => 'CargoPress Import',
				'import_file_url'        => 'http://artifacts.proteusthemes.com/xml-exports/cargopress-latest.xml',
				'import_widget_file_url' => 'http://artifacts.proteusthemes.com/json-widgets/cargopress.json'
			),
		);
	}


	/**
	 * After import theme setup for One Click Demo Import plugin.
	 */
	function ocdi_after_import_setup() {

		// Menus to Import and assign - you can remove or add as many as you want
		$top_menu  = get_term_by( 'name', 'Top Menu', 'nav_menu' );
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
				'top-bar-menu' => $top_menu->term_id,
				'main-menu'    => $main_menu->term_id,
			)
		);

		// Set options for front page and blog page
		$front_page_id = get_page_by_title( 'Home' )->ID;
		$blog_page_id  = get_page_by_title( 'News' )->ID;

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id );
		update_option( 'page_for_posts', $blog_page_id );

		// Set options for Breadcrumbs NavXT
		$breadcrumbs_settings = array( 'hseparator' => '' );
		$shop_page = get_page_by_title( 'Shop' );
		if ( ! is_null( $shop_page ) ) {
			$breadcrumbs_settings['apost_product_root'] = $shop_page->ID;
		}
		add_option( 'bcn_options', $breadcrumbs_settings );

		// Set logo in customizer
		set_theme_mod( 'logo_img', get_template_directory_uri() . '/assets/images/logo.png' );
		set_theme_mod( 'logo2x_img', get_template_directory_uri() . '/assets/images/logo@2x.png' );

		_e( 'After import setup ended!', 'cargopress-pt' );
	}


	/**
	 * Message for manual demo import for One Click Demo Import plugin.
	 */
	function ocdi_message_after_file_fetching_error() {
		return sprintf( __( 'Please try to manually import the demo data. Here are instructions on how to do that: %sDocumentation: Import XML File%s', 'cargopress-pt' ), '<a href="https://www.proteusthemes.com/docs/cargopress-pt/#import-xml-file" target="_blank">', '</a>' );
	}
}

// Single instance
$cargoress_filters = new CargoPressFilters();
