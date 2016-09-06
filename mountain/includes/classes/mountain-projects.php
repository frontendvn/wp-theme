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
 * This class will implement support for the plugin Projects
 *
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain_Projects extends Mountain_Feature
{
	/**
	 * Modify the project post type settings
	 *
	 * @return  void
	 */
	public function post_type_args( $args ) {
		$archive_page = get_post( get_theme_mod( 'projects_archive_page' ) );

		if ( $archive_page != null ) {
			$args['has_archive'] = $archive_page->post_name;
			$args['rewrite']     = array(
				'slug'       => get_theme_mod( 'projects_permalink_base' ),
				'with_front' => false
			);

			if ( ! is_admin() ) {
				$args['labels']['name'] = $archive_page->post_title;
				$args['labels']['singular_name'] = $archive_page->post_title;
			}
		}

		return $args;
	}

	/**
	 * Modify the projects category settings
	 *
	 * @param   array  $args  Category taxonomy arguments
	 * @return  array
	 */
	public function taxonomy_category_args( $args ) {
		$args['rewrite'] = array(
			'slug' => get_theme_mod( 'projects_category_permalink_base', 'nproject-category' )
		);

		return $args;
	}

	/**
	 * Modify the projects tag settings
	 *
	 * @param   array  $args  Tag taxonomy arguments
	 * @return  array
	 */
	public function taxonomy_tag_args( $args ) {
		$args['rewrite'] = array(
			'slug' => get_theme_mod( 'projects_tag_permalink_base', 'nproject-tag' )
		);

		return $args;
	}

	/**
	 * Register panel for Projects
	 *
	 * @param   array  $sections  List of sections
	 * @return  array
	 */
	public function customize_panels( $sections ) {
		$sections[ 'projects' ] = array(
			'title'       => __( 'Projects', 'mountain' ),
			'description' => '',
			'priority'    => 9
		);

		return $sections;
	}

	/**
	 * Register section for Projects
	 *
	 * @param   array  $sections  List of sections
	 * @return  array
	 */
	public function customize_sections( $sections ) {
		$sections[ 'projects-general' ] = array(
			'title'       => __( 'General', 'mountain' ),
			'description' => '',
			'panel'       => 'projects'
		);

		$sections[ 'projects-archive' ] = array(
			'title'       => __( 'Project Archive', 'mountain' ),
			'description' => '',
			'panel'       => 'projects'
		);

		$sections[ 'projects-single' ] = array(
			'title'       => __( 'Project Single', 'mountain' ),
			'description' => '',
			'panel'       => 'projects'
		);

		$sections[ 'projects-related' ] = array(
			'title'       => __( 'Related Projects', 'mountain' ),
			'description' => '',
			'panel'       => 'projects'
		);

		return $sections;
	}

	/**
	 * Register controls for Projects
	 *
	 * @param   array  $controls  List of controls
	 * @return  array
	 */
	public function customize_controls( $controls ) {
		/**
		 * General section
		 */
		$controls['projects_archive_page'] = array(
			'type'    => 'dropdown-pages',
			'label'   => __( 'Projects Page', 'mountain' ),
			'section' => 'projects-general'
		);

		$controls['projects_permalink_base'] = array(
			'type'    => 'text',
			'label'   => __( 'Permalink Base', 'mountain' ),
			'section' => 'projects-general',
			'default' => 'project'
		);

		$controls['projects_category_permalink_base'] = array(
			'type'    => 'text',
			'label'   => __( 'Category Permalink Base', 'mountain' ),
			'section' => 'projects-general',
			'default' => 'nproject-category'
		);

		$controls['projects_tag_permalink_base'] = array(
			'type'    => 'text',
			'label'   => __( 'Tag Permalink Base', 'mountain' ),
			'section' => 'projects-general',
			'default' => 'nproject-tag'
		);

		/**
		 * Archive section
		 */
		$controls['projects_archive_sidebar_layout'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'List Sidebar Position', 'mountain' ),
			'section' => 'projects-archive',
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

		$controls['projects_archive_sidebar'] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'projects-archive',
			'label'   => __( 'Project List Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		$controls['projects_archive_layout'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'List Layout', 'mountain' ),
			'section' => 'projects-archive',
			'choices' => array(
				'grid' => array(
					'src' => op_directory_uri() . '/assets/img/blog-grid.png',
					'tooltip' => __( 'Grid', 'mountain' )
				),
				'masonry' => array(
					'src' => op_directory_uri() . '/assets/img/blog-masonry.png',
					'tooltip' => __( 'Masonry Grid', 'mountain' )
				),
				'gallery' => array(
					'src' => op_directory_uri() . '/assets/img/portfolio-no-margin.png',
					'tooltip' => __( 'Gallery', 'mountain' )
				),
				'justify' => array(
					'src' => op_directory_uri() . '/assets/img/portfolio-justify.png',
					'tooltip' => __( 'Justified Grid', 'mountain' )
				)
			),
			'default' => 'grid'
		);

		$controls['projects_grid_columns'] = array(
			'type'    => 'dropdown',
			'section' => 'projects-archive',
			'label'   => __( 'Grid Columns', 'mountain' ),
			'default' => 3,
			'choices' => array(
				2 => __( '2 Columns', 'mountain' ),
				3 => __( '3 Columns', 'mountain' ),
				4 => __( '4 Columns', 'mountain' ),
				5 => __( '5 Columns', 'mountain' ),
			)
		);

		$controls['projects_archive_filter'] = array(
			'type'    => 'switcher',
			'section' => 'projects-archive',
			'label'   => __( 'Show Items Filter', 'mountain' ),
			'default' => true
		);
		$controls['projects_archive_permalink'] = array(
			'type'    => 'switcher',
			'section' => 'projects-archive',
			'label'   => __( 'Enable Permalinks On Items', 'mountain' ),
			'default' => true
		);

		$controls['projects_archive_category_enabled'] = array(
			'type'    => 'switcher',
			'section' => 'projects-archive',
			'label'   => __( 'Show Project Categories', 'mountain' ),
			'default' => true
		);
		$controls['projects_archive_category_permalink'] = array(
			'type'    => 'switcher',
			'section' => 'projects-archive',
			'label'   => __( 'Enable Permalinks On Categories', 'mountain' ),
			'default' => true
		);

		$controls['projects_archive_pagination_style'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'Pagination Style', 'mountain' ),
			'section' => 'projects-archive',
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
				)
			)
		);

		$controls['projects_posts_per_page'] = array(
			'type'     => 'spinner',
			'section'  => 'projects-archive',
			'label'    => __( 'Posts Per Page', 'mountain' ),
			'default'  => get_option( 'posts_per_page' )
		);

		/**
		 * Project Single
		 */
		$controls['projects_single_sidebar_layout'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'Single Sidebar Position', 'mountain' ),
			'section' => 'projects-single',
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

		$controls['projects_single_sidebar'] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'projects-single',
			'label'   => __( 'Single Project Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		$controls['projects_single_gallery_type'] = array(
			'type'    => 'radio-images',
			'section' => 'projects-single',
			'label'   => __( 'Gallery Type', 'mountain' ),
			'default' => 'grid',
			'choices' => array(
				'list'   => array(
					'src'     => op_directory_uri() . '/assets/img/list.png',
					'tooltip' => __( 'List', 'mountain' )
				),
				'grid'   => array(
					'src'     => op_directory_uri() . '/assets/img/portfolio-no-margin.png',
					'tooltip' => __( 'Grid', 'mountain' )
				)
			)
		);

		$controls['projects_single_gallery_columns'] = array(
			'type'    => 'dropdown',
			'section' => 'projects-single',
			'label'   => __( 'Gallery Columns', 'mountain' ),
			'default' => 3,
			'choices' => array(
				2 => __( '2 Columns', 'mountain' ),
				3 => __( '3 Columns', 'mountain' ),
				4 => __( '4 Columns', 'mountain' ),
				5 => __( '5 Columns', 'mountain' ),
			)
		);

		$controls['projects_single_header_background'] = array(
			'type'    => 'switcher',
			'section' => 'projects-single',
			'label'   => __( 'Show Featured Image In Header', 'mountain' ),
			'default' => true
		);

		$controls['projects_single_navigator_enabled'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Project Navigator', 'mountain' ),
			'section' => 'projects-single',
			'default' => true
		);
		$controls['projects_single_categories_enabled'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Project Categories', 'mountain' ),
			'section' => 'projects-single',
			'default' => true
		);
		$controls['projects_single_tags_enabled'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Project Tags', 'mountain' ),
			'section' => 'projects-single',
			'default' => true
		);

		/**
		 * Project Related
		 */
		$controls['projects_related_box_enabled'] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Related Projects', 'mountain' ),
			'section' => 'projects-related',
			'default' => true
		);

		$controls['projects_related_title'] = array(
			'type'    => 'text',
			'label'   => __( 'Widget Title', 'mountain' ),
			'section' => 'projects-related',
			'default' => __( 'Related Projects', 'mountain' )
		);

		$controls['projects_related_type'] = array(
			'type' => 'dropdown',
			'section' => 'projects-related',
			'label' => __( 'Show Related Items Based On', 'mountain' ),
			'default' => 'tag',
			'choices' => array(
				'tag'      => __( 'Tag', 'mountain' ),
				'category' => __( 'Category', 'mountain' ),
				'random'   => __( 'Random', 'mountain' ),
				'recent'   => __( 'Recent', 'mountain' )
			)
		);

		$controls['projects_related_style'] = array(
			'type'    => 'dropdown',
			'section' => 'projects-related',
			'label'   => __( 'Related Project Style', 'mountain' ),
			'default' => 'grid',
			'choices' => array(
				'grid'      => __( 'Grid', 'mountain' ),
				'masonry'   => __( 'Grid Masonry', 'mountain' ),
				'no-margin' => __( 'Grid No Margin', 'mountain' )
			)
		);

		$controls['projects_related_columns_count'] = array(
			'type'    => 'dropdown',
			'section' => 'projects-related',
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

		$controls['projects_related_posts_count'] = array(
			'type'    => 'spinner',
			'section' => 'projects-related',
			'label'   => __( 'Number Of Related Projects', 'mountain' ),
			'min'     => 1,
			'default' => 4
		);

		return $controls;
	}

	/**
	 * Override theme options for Projects
	 *
	 * @param   array  $options  Theme options
	 * @return  array
	 */
	public function override_options( $options ) {
		if ( ! $this->enabled() || is_admin() ) return $options;

		if ( is_post_type_archive( nProjects::TYPE_NAME ) ||
			 is_tax( nProjects::TYPE_CATEGORY ) ||
			 is_tax( nProjects::TYPE_TAG ) ||
			 is_page_template( 'templates/template-projects.php' ) ) {
			$options['sidebar_layout']  = isset( $options['projects_archive_sidebar_layout'] )
				? $options['projects_archive_sidebar_layout']
				: $options['sidebar_layout'];

			$options['sidebar_default']  = isset( $options['projects_archive_sidebar'] )
				? $options['projects_archive_sidebar']
				: $options['sidebar_default'];

			$options['blog_archive_pagination_style'] = isset( $options['projects_archive_pagination_style'] )
				? $options['projects_archive_pagination_style']
				: $options['blog_archive_pagination_style'];
		}
		elseif ( is_singular( nProjects::TYPE_NAME ) ) {
			$project_settings = get_post_meta( get_the_ID(), '_project_settings', true );
			$project_settings = is_array( $project_settings ) ? $project_settings : array();

			if ( isset( $project_settings['project_settings_enabled'] ) && $project_settings['project_settings_enabled'] == true ) {
				foreach ( $project_settings as $name => $value )
					if ( isset( $options[$name] ) )
						$options[$name] = $value;
			}

			$options['sidebar_layout']  = isset( $options['projects_single_sidebar_layout'] )
				? $options['projects_single_sidebar_layout']
				: $options['sidebar_layout'];

			$options['sidebar_default']  = isset( $options['projects_single_sidebar'] )
				? $options['projects_single_sidebar']
				: $options['sidebar_default'];

			$options['blog_post_header_background'] = isset( $options['projects_single_header_background'] )
				? $options['projects_single_header_background']
				: $options['blog_post_header_background'];
		}

		return $options;
	}

	/**
	 * Return the classes for archive wrapper tag
	 *
	 * @param   array  $classes  The archive classes
	 * @return  array
	 */
	public function archive_class( $classes ) {
		$classes[] = sprintf( 'projects-%s', op_option( 'projects_archive_layout', 'grid' ) );
		$classes[] = op_option( 'projects_archive_filter', true ) ? 'projects-has-filter' : 'projects-no-filter';

		return $classes;
	}

	/**
	 * Return the name that identify thumbnail size
	 * for project listing page
	 *
	 * @param   string  $size  The thumbnail size name
	 * @return  string
	 */
	public function archive_thumbnail_size( $size ) {
		if ( op_option( 'projects_archive_layout', 'grid' ) == 'masonry' )
			$size = 'thumbnail-medium';
		else
			$size = 'thumbnail-medium-crop';

		return $size;
	}

	/**
	 * Return the number to limit items can be shown
	 * on the archive page
	 *
	 * @param   int  $value  The number of items
	 * @return  int
	 */
	public function posts_per_page( $value ) {
		if ( is_post_type_archive( nProjects::TYPE_NAME ) ||
			 is_tax( nProjects::TYPE_CATEGORY ) ||
			 is_tax( nProjects::TYPE_TAG ) ) {

			$value = op_option( 'projects_posts_per_page', 10 );
		}

		return $value;
	}

	/**
	 * Register metabox
	 *
	 * @return  void
	 */
	public function add_metabox() {
		add_meta_box( 'projects-options', __( 'Project Settings', 'mountain' ),
			array( $this, 'display_metabox' ),
			nProjects::TYPE_NAME,
			'normal',
			'high'
		);
	}

	/**
	 * Display the metabox that associated with an post
	 * object
	 *
	 * @param   object  $post  The given post object
	 * @return  void
	 */
	public function display_metabox( $post ) {
		if ( nProjects_Helper::current_post_type() == nProjects::TYPE_NAME ):

			$project_settings = get_post_meta( $post->ID, '_project_settings', true );
			$project_settings = is_array( $project_settings ) ? $project_settings : array();

			$project_settings_container= new \OptionsPlus\Options\Container( array(
				'show_tabs' => false,
				'sections'  => array( 'all' => array( 'title', 'all' ) ),
				'controls'  => array(
					'project_settings_enabled' => array(
						'type'    => 'switcher',
						'label'   => __( 'Enable Custom Settings', 'mountain' ),
						'section' => 'all',
						'default' => false
					),

					'projects_single_gallery_type' => array(
						'type'    => 'radio-images',
						'section' => 'all',
						'label'   => __( 'Gallery Type', 'mountain' ),
						'default' => op_option( 'projects_single_gallery_type', 'list' ),
						'choices' => array(
							'list'   => array(
								'src'     => op_directory_uri() . '/assets/img/list.png',
								'tooltip' => __( 'List', 'mountain' )
							),
							'grid'   => array(
								'src'     => op_directory_uri() . '/assets/img/portfolio-no-margin.png',
								'tooltip' => __( 'Grid', 'mountain' )
							)
						)
					),

					'projects_single_gallery_columns' => array(
						'type'    => 'dropdown',
						'section' => 'all',
						'label'   => __( 'Gallery Columns', 'mountain' ),
						'default' => op_option( 'projects_single_gallery_columns', 3 ),
						'choices' => array(
							2 => __( '2 Columns', 'mountain' ),
							3 => __( '3 Columns', 'mountain' ),
							4 => __( '4 Columns', 'mountain' ),
							5 => __( '5 Columns', 'mountain' ),
						)
					)
				)
			) );

			$project_settings_container->bind( $project_settings );
			$project_settings_container->render();
		endif;
	}

	/**
	 * Save the settings for individual project
	 *
	 * @param   int  $post_id  The post ID
	 * @return  void
	 */
	public function save_project_settings( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || nProjects_Helper::current_post_type() != nProjects::TYPE_NAME )
			return;

		if ( isset( $_REQUEST ) && isset( $_REQUEST['op-options'] ) ) {
			$data = stripslashes_deep( $_REQUEST['op-options'] );
			$data['project_settings_enabled']       = isset( $data['project_settings_enabled'] );
			$data['projects_single_content_sticky'] = isset( $data['projects_single_content_sticky'] );

			update_post_meta( $post_id, '_project_settings', $data );
		}
	}

	/**
	 * Enqueue assets for the administrator panel
	 *
	 * @return  void
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			wp_enqueue_script( 'mountain-project-settings' );
		}
	}

	/**
	 * Return the template location of the shortcode
	 *
	 * @return  string
	 */
	public function shortcode_template() {
		return 'templates/shortcodes/projects.php';
	}

	/**
	 * Return an array that definition parameters
	 * for shortcode on Visual Composer
	 *
	 * @param   array  $params  Shortcode parameters
	 * @return  array
	 */
	public function shortcode_parameters( $params ) {
		// General tab
		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Widget Title', 'mountain' ),
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'mountain' ),
			'param_name'  => 'widget_title'
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Categories', 'mountain' ),
			'description' => __( 'If you want to narrow output, enter category names here. Note: Only listed categories will be included.', 'mountain' ),
			'param_name'  => 'categories'
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Tags', 'mountain' ),
			'description' => __( 'If you want to narrow output, enter tag names here. Note: Only listed tags will be included.', 'mountain' ),
			'param_name'  => 'tags'
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Display Mode', 'mountain' ),
			'param_name' => 'mode',
			'std'        => 3,
			'value'      => array(
				__( 'Grid Classic', 'mountain' )   => 'grid',
				__( 'Grid Masonry', 'mountain' )   => 'masonry',
				__( 'Grid No Margin', 'mountain' ) => 'no-margin',
				__( 'Carousel', 'mountain' )       => 'carousel'
			)
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Columns', 'mountain' ),
			'description' => __( 'The number of columns will be shown', 'mountain' ),
			'param_name'  => 'columns',
			'std'         => 3,
			'value'       => array(
				__( '1 Column', 'mountain' )  => 1,
				__( '2 Columns', 'mountain' ) => 2,
				__( '3 Columns', 'mountain' ) => 3,
				__( '4 Columns', 'mountain' ) => 4,
				__( '5 Columns', 'mountain' ) => 5,
			)
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Show Items Filter', 'mountain' ),
			'param_name' => 'filter',
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' )  => 'no'
			)
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Filter By', 'mountain' ),
			'param_name' => 'filter_by',
			'std'        => 'category',
			'value'      => array(
				__( 'Categories', 'mountain' ) => 'category',
				__( 'Tags', 'mountain' )       => 'tag'
			)
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Limit', 'mountain' ),
			'description' => __( 'The number of posts will be shown', 'mountain' ),
			'param_name'  => 'limit',
			'value'       => 9
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Offset', 'mountain' ),
			'description' => __( 'The number of posts to pass over', 'mountain' ),
			'param_name'  => 'offset',
			'value'       => 0
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Thumbnail Size', 'mountain' ),
			'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'mountain' ),
			'param_name'  => 'thumbnail_size'
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Order By', 'mountain' ),
			'description' => __( 'Select how to sort retrieved posts.', 'mountain' ),
			'param_name'  => 'order',
			'std'         => 'date',
			'value'       => array(
				__( 'Date', 'mountain' )          => 'date',
				__( 'ID', 'mountain' )            => 'ID',
				__( 'Author', 'mountain' )        => 'author',
				__( 'Title', 'mountain' )         => 'title',
				__( 'Modified', 'mountain' )      => 'modified',
				__( 'Random', 'mountain' )        => 'rand',
				__( 'Comment count', 'mountain' ) => 'comment_count',
				__( 'Menu order', 'mountain' )    => 'menu_order'
			)
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Order Direction', 'mountain' ),
			'description' => __( 'Designates the ascending or descending order.', 'mountain' ),
			'param_name'  => 'direction',
			'std'         => 'DESC',
			'value'       => array(
				__( 'Ascending', 'mountain' )          => 'ASC',
				__( 'Descending', 'mountain' )            => 'DESC'
			)
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra Class', 'mountain' ),
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mountain' ),
			'param_name'  => 'class'
		);

		// Carousel Options
		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Autoplay?', 'mountain' ),
			'param_name' => 'autoplay',
			'group'      => __( 'Carousel Options', 'mountain' ),
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Stop On Hover?', 'mountain' ),
			'description' => __( 'Rewind speed in milliseconds', 'mountain' ),
			'param_name'  => 'hover_stop',
			'group'       => __( 'Carousel Options', 'mountain' ),
			'std'         => 'yes',
			'value'       => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		$params[] = array(
			'type'        => 'checkbox',
			'heading'     => __( 'Slider Controls', 'mountain' ),
			'param_name'  => 'controls',
			'group'       => __( 'Carousel Options', 'mountain' ),
			'std'         => 'navigation,rewind-navigation,pagination,pagination-numbers',
			'value'       => array(
				__( 'Navigation', 'mountain' )         => 'navigation',
				__( 'Rewind Navigation', 'mountain' )  => 'rewind-navigation',
				__( 'Pagination', 'mountain' )         => 'pagination',
				__( 'Pagination Numbers', 'mountain' ) => 'pagination-numbers'
			)
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Scroll Per Page?', 'mountain' ),
			'param_name' => 'scroll_page',
			'group'       => __( 'Carousel Options', 'mountain' ),
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Allow Mouse Drag?', 'mountain' ),
			'param_name' => 'mouse_drag',
			'group'      => __( 'Carousel Options', 'mountain' ),
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Allow Touch Drag?', 'mountain' ),
			'param_name' => 'touch_drag',
			'group'      => __( 'Carousel Options', 'mountain' ),
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		// Speed
		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Autoplay Speed', 'mountain' ),
			'description' => __( 'Autoplay speed in milliseconds', 'mountain' ),
			'param_name'  => 'autoplay_speed',
			'group'       => __( 'Speed', 'mountain' ),
			'value'       => 5000
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Slide Speed', 'mountain' ),
			'description' => __( 'Slide speed in milliseconds', 'mountain' ),
			'param_name'  => 'slide_speed',
			'group' => __( 'Speed', 'mountain' ),
			'value'       => 200
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Pagination Speed', 'mountain' ),
			'description' => __( 'Pagination speed in milliseconds', 'mountain' ),
			'param_name'  => 'pagination_speed',
			'group' => __( 'Speed', 'mountain' ),
			'value'       => 200
		);

		$params[] = array(
			'type'        => 'textfield',
			'heading'     => __( 'Rewind Speed', 'mountain' ),
			'description' => __( 'Rewind speed in milliseconds', 'mountain' ),
			'param_name'  => 'rewind_speed',
			'group' => __( 'Speed', 'mountain' ),
			'value'       => 200
		);

		// Responsive
		$params[] = array(
			'type'       => 'dropdown',
			'heading'    => __( 'Enable Responsive?', 'mountain' ),
			'param_name' => 'responsive',
			'group'      => __( 'Responsive', 'mountain' ),
			'std'        => 'yes',
			'value'      => array(
				__( 'Yes', 'mountain' ) => 'yes',
				__( 'No', 'mountain' ) => 'no'
			)
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items On Tablet', 'mountain' ),
			'description' => __( 'The maximum amount of items displayed at a time on tablet device', 'mountain' ),
			'param_name'  => 'tablet_items',
			'group'       => __( 'Responsive', 'mountain' ),
			'value'       => array_combine( range( 1, 6 ), range( 1, 6 ) ),
			'std'         => 2
		);

		$params[] = array(
			'type'        => 'dropdown',
			'heading'     => __( 'Items On Mobile', 'mountain' ),
			'description' => __( 'The maximum amount of items displayed at a time on mobile device', 'mountain' ),
			'param_name'  => 'mobile_items',
			'group'       => __( 'Responsive', 'mountain' ),
			'value'       => array_combine( range( 1, 6 ), range( 1, 6 ) ),
			'std'         => 1
		);

		$params[] = array(
			'type' => 'css_editor',
			'param_name' => 'css',
			'group' => __( 'Design Options', 'mountain' )
		);
		return $params;
	}

	/**
	 * Setting up the projects support
	 *
	 * @return  void
	 */
	protected function setup() {
		/**
		 * Add template for projects shortcode
		 */
		add_filter( 'nprojects/shortcode_template', array( $this, 'shortcode_template' ) );

		add_filter( 'nprojects/shortcode_parameters', array( $this, 'shortcode_parameters' ) );

		/**
		 * Change project post type settings
		 */
		add_filter( 'nprojects/post_type_args', array( $this, 'post_type_args' ) );

		/**
		 * Change project category settings
		 */
		add_filter( 'nprojects/taxonomy_category_args', array( $this, 'taxonomy_category_args' ) );

		/**
		 * Change project tag settings
		 */
		add_filter( 'nprojects/taxonomy_tag_args', array( $this, 'taxonomy_tag_args' ) );

		/**
		 * Override the theme options
		 */
		add_filter( 'op/prepare_options', array( $this, 'override_options' ) );

		/**
		 * Register filter to adding specific classes for projects archive
		 */
		add_filter( 'projects/archive-class', array( $this, 'archive_class' ) );

		/**
		 * Return the thumbnail size name
		 */
		add_filter( 'projects/archive-thumbnail-size', array( $this, 'archive_thumbnail_size' ) );

		/**
		 * Pagination option
		 */
		add_filter( 'option_posts_per_page', array( $this, 'posts_per_page' ) );

		/**
		 * Register theme customize panels
		 */
		add_action( 'mountain/customize-panels', array( $this, 'customize_panels' ) );

		/**
		 * Register theme customize sections
		 */
		add_action( 'mountain/customize-sections', array( $this, 'customize_sections' ) );

		/**
		 * Register theme customize controls
		 */
		add_action( 'mountain/customize-controls', array( $this, 'customize_controls' ) );

		/**
		 * Register project metabox
		 */
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );

		/**
		 * Register action for save project settings
		 */
		add_action( 'save_post', array( $this, 'save_project_settings' ) );

		/**
		 * Register action to enqueue admin assets
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Return the flag that allow to initialize
	 * this feature
	 *
	 * @return  boolean
	 */
	protected function enabled() {
		return class_exists( 'nProjects' );
	}
}
