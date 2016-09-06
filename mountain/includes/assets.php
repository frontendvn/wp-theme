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
 * Assets management class
 */
class Mountain_Assets
{
	/**
	 * Class instance handler
	 * 
	 * @var  Mountain_Advanced
	 */
	private static $instance;

	/**
	 * Initialize advanced theme settings section
	 * 
	 * @return  void
	 */
	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
			self::$instance->hooks();
		}

		return self::$instance;
	}

	/**
	 * Method to register actions/filters hooks
	 * 
	 * @return  void
	 */
	private function hooks() {
		add_action( 'init',                 array( $this, 'register' ), 5 );
		add_action( 'wp_enqueue_scripts',   array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts',   array( $this, 'enqueue_fonts' ) );
		add_action( 'wp_footer',            array( $this, 'print_custom_script' ) );
		add_action( 'customize_save_after', array( $this, 'compile_scheme_styles' ) );

		// Register filters
		add_filter( 'content_width', array( $this, 'content_width' ) );
		add_filter( 'image_size_names_choose', array( $this, 'image_size_chooser' ) );
	}

	/**
	 * Register assets
	 * 
	 * @return  void
	 */
	public function register() {
		wp_register_style( 'mountain-3rd', get_template_directory_uri() . '/assets/css/third-party.css', array(), Mountain::VERSION );
		wp_register_style( 'mountain-fontawesome', get_template_directory_uri() . '/assets/3rd/font-awesome/css/font-awesome.min.css', array(), Mountain::VERSION );
		wp_register_style( 'mountain-sidebars', get_template_directory_uri() . '/assets/admin/css/sidebars.css', array(), Mountain::VERSION );
		wp_register_style( 'mountain-widgets', get_template_directory_uri() . '/assets/admin/css/widgets.css', array(), Mountain::VERSION );
		wp_register_style( 'mountain-sample-data', get_template_directory_uri() . '/assets/admin/css/sample-data.css', array(), Mountain::VERSION );
		wp_register_style( 'mountain', get_template_directory_uri() . '/assets/css/style.css', array( 'mountain-3rd', 'mountain-fontawesome' ), Mountain::VERSION );

		wp_register_script( 'mountain-page-options', get_template_directory_uri() . '/assets/admin/js/page-options.js', array( 'jquery', 'op-options-controls' ), Mountain::VERSION, true );
		wp_register_script( 'mountain-project-settings', get_template_directory_uri() . '/assets/admin/js/project-settings.js', array( 'jquery', 'op-options-controls' ), Mountain::VERSION, true );
		wp_register_script( 'mountain-sidebars', get_template_directory_uri() . '/assets/admin/js/sidebars.js', array( 'jquery' ), Mountain::VERSION, true );
		wp_register_script( 'mountain-customizer-controls', get_template_directory_uri() . '/assets/admin/js/customizer-controls.js', array( 'jquery', 'op-options-controls', 'customize-base' ), Mountain::VERSION, true );
		wp_register_script( 'mountain-customizer-preview', get_template_directory_uri() . '/assets/admin/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), Mountain::VERSION, true );
		wp_register_script( 'mountain-sample-data', get_template_directory_uri() . '/assets/admin/js/sample-data.js', array( 'jquery' ), Mountain::VERSION, true );
		
		wp_register_script( 'mountain-3rd', get_template_directory_uri() . '/assets/js/theme-3rd.js', array( 'jquery' ), Mountain::VERSION, true );
		wp_register_script( 'mountain', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery', 'mountain-3rd' ), Mountain::VERSION, true );
	}

	/**
	 * Enqueue assets
	 * 
	 * @return  void
	 */
	public function enqueue() {
		global $wp_customize;

		/**
		 * Theme stylesheets
		 */
		wp_enqueue_style( 'mountain' );

		// Enqueue child theme stylesheet
		if ( is_child_theme() ) {
			wp_enqueue_style( 'mountain-child', get_stylesheet_uri() );
		}

		/**
		 * Theme scripts
		 */
		if ( op_option( 'blog_archive_layout' ) == 'masonry' ) {
			wp_enqueue_script( 'masonry' );
		}

		wp_enqueue_script( 'mountain' );
		wp_localize_script( 'mountain', '_themeConfig', $this->javascript_theme_config() );

		/**
		 * Comment script
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		/**
		 * Generate inline styles for theme
		 */
		$inline_styles = $this->dynamic_styles();
		$inline_styles.= op_option( 'scheme_styles' );
		$inline_styles.= op_option( 'custom_css' );

		wp_add_inline_style( 'mountain', $inline_styles );
	}

	/**
	 * Enqueue the google fonts
	 * 
	 * @return  void
	 */
	public function enqueue_fonts() {
		wp_enqueue_style( 'mountain-fonts', $this->google_fonts_url(), array(), Mountain::VERSION );
	}

	public function google_fonts_url() {
		global $_options_plus_fonts;

		$body_font    = op_option( 'body_font' );
		$heading_font = op_option( 'heading_font' );
		$menu_font    = op_option( 'menu_font' );
		$google_fonts = $_options_plus_fonts['google'];

		if ( isset( $google_fonts[$body_font['family']] ) ||
			 isset( $google_fonts[$heading_font['family']] ) ||
			 isset( $google_fonts[$menu_font['family']] ) ) {

			$fonts   = array();
			$subsets = array( 'latin' );

			if ( isset( $google_fonts[$body_font['family']] ) ) {
				$fonts[] = sprintf( '%s:%s',
					$google_fonts[$body_font['family']]['family'],
					str_replace( ', ', ',', $google_fonts[$body_font['family']]['variants'] )
				);
			}

			if ( isset( $google_fonts[$heading_font['family']] ) ) {
				$fonts[] = sprintf( '%s:%s',
					$google_fonts[$heading_font['family']]['family'],
					str_replace( ', ', ',', $google_fonts[$heading_font['family']]['variants'] )
				);
			}

			if ( isset( $google_fonts[$menu_font['family']] ) ) {
				$fonts[] = sprintf( '%s:%s',
					$google_fonts[$menu_font['family']]['family'],
					str_replace( ', ', ',', $google_fonts[$menu_font['family']]['variants'] )
				);
			}

			// Load subsets
			if ( op_option( 'cyrillic_subsets_enabled' ) )
				$subsets[] = 'cyrillic';
			if ( op_option( 'cyrillic_ext_subsets_enabled' ) )
				$subsets[] = 'cyrillic-ext';
			if ( op_option( 'greek_subsets_enabled' ) )
				$subsets[] = 'greek';
			if ( op_option( 'greek_ext_subsets_enabled' ) )
				$subsets[] = 'greek-ext';
			if ( op_option( 'vietnamese_subsets_enabled' ) )
				$subsets[] = 'vietnamese';
			if ( op_option( 'latin_ext_subsets_enabled' ) )
				$subsets[] = 'latin-ext';
			if ( op_option( 'devanagari_subsets_enabled' ) )
				$subsets[] = 'devanagari';

			return add_query_arg( array(
					'family'  => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( implode( '|', $subsets ) )
				), '//fonts.googleapis.com/css' );
		}
	}

	/**
	 * Remove unusable assets
	 * 
	 * @return  void
	 */
	public function remove_unuse_assets() {
		wp_dequeue_style( 'prettyphoto' );
		wp_dequeue_script( 'prettyphoto' );
	}

	/**
	 * Print the custom script
	 * 
	 * @return  void
	 */
	public function print_custom_script() {
		$script = op_option( 'custom_js' );

		if ( ! empty( $script ) )
			printf( '<script type="text/javascript">%s</script>', $script );
	}

	/**
	 * Return the content width number
	 * 
	 * @return  int
	 */
	public function content_width() {
		return (int) op_option( 'content_width', 1110 );
	}

	/**
	 * Generate custom styles based on theme options
	 * 
	 * @return  string
	 */
	function dynamic_styles() {
		global $_options_plus_fonts;

		$styles = array();

		// Typography
		$heading_fontsize = op_option( 'heading_fontsize' );
		$heading_fontstyle = op_option( 'heading_font' );

		if ( isset( $heading_fontstyle['color'] ) )
			unset( $heading_fontstyle['color'] );

		$styles['body'] = op_typography_styles( op_option( 'body_font' ) );
		$styles['h1, h2, h3, h4, h5, h6'] = op_typography_styles( $heading_fontstyle );

		if ( is_array( $heading_fontsize ) ) {
			foreach ( $heading_fontsize as $index => $size ) {
				if ( $size == 0 ) continue;
				$styles['h' . ( $index + 1 )]['font-size'] = $size . 'px';
			}
		}

		// Menu Font
		$styles['#site-header #site-navigator .menu > li a'] = op_typography_styles( op_option( 'menu_font' ) );
		$styles['#site-header #site-navigator-mobile .menu li a'] = op_typography_styles( op_option( 'menu_font' ) );

		// Logo
		list( $logo_margin_top, $logo_margin_bottom ) = op_option( 'logo_margin', array( 0, 0 ) );
		$styles['#masthead .brand'] = array(
			'margin-top'    => sprintf( '%dpx', (int) $logo_margin_top ),
			'margin-bottom' => sprintf( '%dpx', (int) $logo_margin_bottom )
		);

		// Topbar styles
		$styles['#headerbar'] = array(
			'background-color' => op_option( 'topbar_bgcolor' ),
			'color' => op_option( 'topbar_textcolor' )
		);

		$predefined_patterns = predefined_background_patterns();

		$styles['#site-header'] = op_background_styles( $predefined_patterns, op_option( 'header_background' ) );

		// Boxed Style
		$styles['body.layout-boxed'] = op_background_styles( $predefined_patterns, op_option( 'boxed_background' ) );

		// Off-Canvas
		$styles['#off-canvas .off-canvas-wrap'] = op_background_styles( $predefined_patterns, op_option( 'offcanvas_background' ) );

		// Page Header
		$styles['#site-content #page-header'] = op_background_styles( $predefined_patterns, op_option( 'pagetitle_background' ) );
		$pagetitle_font = op_option( 'pagetitle_font' );
		
		if ( is_page() ) {
			$page_options = get_post_meta( get_the_ID(), '_page_options', true );
			
			if ( ! empty( $page_options['pagetitle_textcolor'] ) )
				$pagetitle_font['color'] = $page_options['pagetitle_textcolor'];
		}

		$pagetitle_padding = op_option( 'pagetitle_padding', array( 50, 50 ) );
		$styles['#site-content #page-header']['padding-top'] = sprintf( '%dpx', (int) $pagetitle_padding[0] );
		$styles['#site-content #page-header']['padding-bottom'] = sprintf( '%dpx', (int) $pagetitle_padding[1] );

		if ( isset( $pagetitle_font['color'] ) ) {
			$styles['#site-content #page-header,
					 #site-content #page-header a'] = array(
				'color' => $pagetitle_font['color']
			);
		}

		$styles['#site-content #page-header .page-title .title'] = op_typography_styles( $pagetitle_font );

		// Page Callout
		$styles['#site-content #page-callout'] = array( 'background-color' => op_option( 'page_callout_background' ) );
		$styles['#site-content #page-callout .callout-content'] = array( 'color' => op_option( 'page_callout_textcolor' ) );

		// Page Footer
		$styles['#site-footer'] = op_background_styles( $predefined_patterns, op_option( 'footer_widgets_background' ) );
		$styles['#site-footer']['color'] = op_option( 'footer_widgets_textcolor' );

		// Layout Width
		$selector = '.wrapper,' .
					'.page-fullwidth #page-body .wrapper .content-wrap .content .vc_row_wrap,' .
					'.page-fullwidth #page-body #respond,' .
					'.page-fullwidth #page-body .nocomments';

		$content_width = (int) op_option( 'content_width', 1110 );
		$styles[$selector] = array(
			'width' => "{$content_width}px"
		);

		$selector = 'body.layout-boxed #site-wrapper,' .
					'body.layout-boxed #site-wrapper #masthead-sticky,' .
					'body.layout-boxed #site-wrapper #masthead.header-v7';

		$masthead_width = $content_width + 100;
		$styles[$selector] = array(
			'width' => "{$masthead_width}px"
		);

		$selector = 'body.layout-boxed #site-wrapper,' .
					'body.layout-boxed #site-wrapper #masthead-sticky,' .
					'body.layout-boxed #site-wrapper #masthead.header-v7';

		$wrapper_width = $content_width + 250;
		$styles['.side-menu.layout-boxed #site-wrapper'] = array(
			'width' => "{$wrapper_width}px"
		);

		// Featured Image for Header
		if ( is_single() && current_post_type_is( 'post' ) && op_option( 'blog_post_header_background', true ) ) {
			$post_thumbnail_id = get_post_meta( get_the_ID(), '_thumbnail_id', true );

			if ( is_numeric( $post_thumbnail_id ) ) {
				list( $thumbnail_src, $width, $height ) = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$styles['#site-content #page-header'] = array(
					'background-image' => sprintf( 'url(%s)', $thumbnail_src )
				);
			}
		}

		if ( is_single() && current_post_type_is( 'nproject' ) && op_option( 'projects_single_header_background', true ) ) {
			$post_thumbnail_id = get_post_meta( get_the_ID(), '_thumbnail_id', true );

			if ( is_numeric( $post_thumbnail_id ) ) {
				list( $thumbnail_src, $width, $height ) = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$styles['#site-content #page-header'] = array(
					'background-image' => sprintf( 'url(%s)', $thumbnail_src )
				);
			}
		}

		/**
		 * Custom Logo size
		 */
		list( $logo_width, $logo_height ) = op_option( 'logo_size', array( '', '' ) );
		$styles['#site-logo .logo img'] = array();

		if ( is_numeric( $logo_width ) && $logo_width > 0 )
			$styles['#site-logo .logo img']['width'] = sprintf( '%dpx', $logo_width );

		if ( is_numeric( $logo_height ) && $logo_height > 0 )
			$styles['#site-logo .logo img']['height'] = sprintf( '%dpx', $logo_height );

		return str_replace(
				array( "\t", "\r\n", "\n" ),
				array( ' ', ' ', ' ' ),
				op_generate_styles( $styles )
			);
	}

	/**
	 * Generate the custom styles for scheme color
	 * 
	 * @param   string  $color  Color string that will be generated
	 * @return  string
	 */
	function compile_color_styles( $color ) {
		global $wp_filesystem;
		
		if ( ! empty( $color ) ) {
			require_once get_template_directory() . '/includes/vendor/less.php';

			$less = new \Lessc();
			$less->setImportDir( get_template_directory() . '/assets/less' );
			$less->setVariables( array( 'scheme' => $color ) );
			$less->setFormatter( 'compressed' );
			
			return $less->compileFile( get_template_directory() . '/assets/less/color.less' );
		}
	}

	/**
	 * Return the config parameters that will accessible by
	 * javascript
	 * 
	 * @return  array
	 */
	function javascript_theme_config() {
		$params = array(
			'stickyHeader'    => op_option( 'header_sticky' ),
			'responsiveMenu'  => true,
			'blogLayout'      => op_option( 'blog_archive_layout' ),

			// Pagination config
			'pagingStyle'     => op_option( 'blog_archive_pagination_style' ),
			'pagingContainer' => '#main-content > .main-content-wrap > .content-inner',
			'pagingNavigator' => '.navigation.paging-navigation.loadmore',

			// Off-Canvas
			'offCanvas'       => is_active_sidebar( 'sidebar-offcanvas' )
		);

		// Pagination container for search results page
		if ( is_search() ) {
			$params['pagingContainer'] = '#main-content > .main-content-wrap > .content-inner > .search-results';
		}

		if ( is_page() ) {
			$page_options = get_post_meta( get_the_ID(), '_page_options', true );

			if ( is_array( $page_options ) && isset( $page_options['onepage_nav_script'] ) && $page_options['onepage_nav_script'] == true ) {
				$params['onepageNavigator'] = true;
			}
		}

		return apply_filters( 'mountain/javascript_theme_config', $params );
	}

	/**
	 * Handler for customize_save action, we will compile scheme styles
	 * at this point
	 * 
	 * @param   WP_Customize_Manager  $customize  Customize object
	 * @return  void
	 */
	function compile_scheme_styles( $customize ) {
		set_theme_mod( 'scheme_styles',
			$this->compile_color_styles( $customize->get_setting( 'scheme_color' )->value() )
		);
	}

	public function image_size_chooser( $sizes ) {
		return array_merge( $sizes, array(
			'thumbnail-medium-crop' => __( 'Medium Cropped', 'mountain' ),
			'thumbnail-large-crop'  => __( 'Large Cropped', 'mountain' )
		) );
	}
}

/**
 * Initialize assets management
 */
Mountain_Assets::instance();
