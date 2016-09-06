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
 * This class will implement support for the plugin WooCommerce
 *
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain_TeamMembers extends Mountain_Feature
{
	/**
	 * Return the flag that allow to initialize
	 * this feature
	 * 
	 * @return  boolean
	 */
	protected function enabled() {
		return current_theme_supports( 'themekit-members' ) && defined( 'THEMEKIT_VERSION' );
	}

	/**
	 * Setting up the woocommerce support
	 * 
	 * @return  void
	 */
	protected function setup() {
		/**
		 * Override the theme options
		 */
		add_filter( 'op/prepare_options', array( $this, 'override_options' ) );

		/**
		 * Register theme customize sections
		 */
		add_action( 'mountain/customize-sections', array( $this, 'customize_sections' ) );

		/**
		 * Register theme customize controls
		 */
		add_action( 'mountain/customize-controls', array( $this, 'customize_controls' ) );

		/**
		 * Override options to limit posts per page
		 */
		add_filter( 'option_posts_per_page', array( $this, 'posts_per_page' ) );
	}

	/**
	 * Override theme options for Team Members
	 * 
	 * @param   array  $options  Theme options
	 * @return  array
	 */
	public function override_options( $options ) {
		if ( is_admin() ) return $options;

		// Overriding options for archive page
		if ( is_post_type_archive( 'member' ) || is_tax( 'member-category' ) ) {
			$options['sidebar_layout']    = isset( $options['members_archive_sidebar_layout'] )
				? $options['members_archive_sidebar_layout']
				: $options['sidebar_layout'];

			$options['sidebar_default']   = isset( $options['members_archive_sidebar'] )
				? $options['members_archive_sidebar']
				: $options['sidebar_default'];

			$options['blog_archive_pagination_style'] = isset( $options['members_archive_pagination_style'] )
				? $options['members_archive_pagination_style']
				: $options['blog_archive_pagination_style'];

			$options['blog_posts_per_page'] = isset( $options['members_posts_per_page'] )
				? $options['members_posts_per_page']
				: $options['blog_posts_per_page'];
		}
		else if ( is_singular( 'member' ) ) {
			$options['sidebar_layout'] = isset( $options['members_single_sidebar_layout'] )
				? $options['members_single_sidebar_layout']
				: $options['sidebar_layout'];
				
			$options['sidebar_default'] = isset( $options['members_single_sidebar'] )
				? $options['members_single_sidebar']
				: $options['sidebar_default'];
		}

		return $options;
	}

	/**
	 * Limit the number of posts will be shown on the archive
	 * page
	 * 
	 * @param   int  $value  Posts per page
	 * @return  int
	 */
	public function posts_per_page( $value ) {
		if ( is_post_type_archive( 'member' ) || is_tax( 'member-category' ) )
			$value = op_option( 'members_posts_per_page', $value );

		return $value;
	}

	/**
	 * Register section for Team Members
	 * 
	 * @param   array  $sections  List of sections
	 * @return  array
	 */
	public function customize_sections( $sections ) {
		$sections[ 'team-members' ] = array(
			'title'       => __( 'Team Members', 'mountain' ),
			'description' => '',
			'priority'    => 11
		);

		return $sections;
	}

	/**
	 * Register controls for Team Members
	 * 
	 * @param   array  $controls  List of controls
	 * @return  array
	 */
	public function customize_controls( $controls ) {
		$controls['members_list_heading'] = array(
			'type'        => 'heading',
			'class'       => 'no-border',
			'section'     => 'team-members',
			'title'       => __( 'Member List', 'mountain' ),
			'description' => __( 'Change options in this section to custom style for member listing page.', 'mountain' )
		);

		$controls['members_archive_sidebar_layout'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'List Sidebar Position', 'mountain' ),
			'section' => 'team-members',
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

		$controls['members_archive_sidebar'] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'team-members',
			'label'   => __( 'Member List Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		$controls['members_archive_pagination_style'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'Pagination Style', 'mountain' ),
			'section' => 'team-members',
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

		$controls['members_posts_per_page'] = array(
			'type'     => 'spinner',
			'section'  => 'team-members',
			'label'    => __( 'Posts Per Page', 'mountain' )
		);

		$controls['members_single_heading'] = array(
			'type'        => 'heading',
			'class'       => 'no-border',
			'section'     => 'team-members',
			'title'       => __( 'Single Member', 'mountain' ),
			'description' => __( 'Change the layout, sidebar, navigator, ... for the single member page.', 'mountain' )
		);
		
		$controls['members_single_sidebar_layout'] = array(
			'type'    => 'radio-images',
			'label'   => __( 'Single Sidebar Position', 'mountain' ),
			'section' => 'team-members',
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

		$controls['members_single_sidebar'] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'team-members',
			'label'   => __( 'Single Member Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		return $controls;
	}
}
