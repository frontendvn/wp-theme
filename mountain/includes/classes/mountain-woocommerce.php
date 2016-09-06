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
class Mountain_Woocommerce extends Mountain_Feature
{
	/**
	 * Return custom arguments to turn on/off related
	 * products section
	 * 
	 * @param   array  $args  Arguments
	 * @return  array
	 */
	public function related_products_args( $args ) {
		if ( op_option( 'woocommerce_related_box_enabled' ) == false )
			return array();

		return $args;
	}

	/**
	 * Modify the number of products that will be appeared
	 * in related products section
	 * 
	 * @param   array  $args  Arguments
	 * @return  array
	 */
	public function output_related_products_args( $args ) {
		$args['posts_per_page'] = op_option( 'woocommerce_related_products_count' );
		
		return $args;
	}

	/**
	 * Deregister all prettyPhoto styles and scripts
	 * 
	 * @return  void
	 */
	public function remove_lightbox() {
		// Styles
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

		// Scripts
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'fancybox' );
		wp_dequeue_script( 'enable-lightbox' );
	}

	/**
	 * @param   string  $html  HTML markup to be replaced
	 * @return  string
	 */
	public function single_product_image_html( $html ) {
		if ( preg_match( '/(.*)data-rel="([^\"]+)"(.*)/i', $html, $matches ) ) {
			if ( strtolower( $matches[2] ) == 'prettyphoto[product-gallery]' )
				$html = $matches[1] . 'data-lightbox="nivoLightbox" data-lightbox-gallery="product-gallery"' . $matches[3];
			else
				$html = $matches[1] . 'data-lightbox="nivoLightbox"' . $matches[3];
		}

		return $html;
	}

	/**
	 * Return the number of how many products that will be
	 * displayed on archive page
	 * 
	 * @return  int
	 */
	public function products_per_page() {
		return op_option( 'woocommerce_products_per_page', 10 );
	}

	/**
	 * Register fragment markup that will respond in ajax request when add
	 * a product to cart
	 * 
	 * @param   array  $fragments  Fragments content
	 * @return  array
	 */
	public function cart_fragments( $fragments ) {
		$cart_items = \WooCommerce::instance()->cart->get_cart_contents_count();
		$fragments['script#shopping-cart-items-updater'] = sprintf( '
				<script id="shopping-cart-items-updater" type="text/javascript">
					( function( $ ) {
						"use strict";

						$( document ).trigger( \'woocommerce-cart-changed\', { items_count: %d } );
					} ).call( this, jQuery );
				</script>
			', $cart_items );

		return $fragments;
	}

	/**
	 * Print markup that will be used as placeholder
	 * for update cart items
	 * 
	 * @return  void
	 */
	public function cart_fragments_placeholder() {
		echo '<script id="shopping-cart-items-updater" type="text/javascript"></script>';
	}

	/**
	 * Return the image size for the shop thumbnail
	 * 
	 * @param   array  $size  Image size declaration
	 * @return  array
	 */
	public function thumbnail_image_size( $size ) {
		$size['width'] = 180;
		$size['height'] = 180;
		$size['crop']   = true;

		return $size;
	}

	/**
	 * Return the image size for the catalog page
	 * 
	 * @param   array  $size  Image size declaration
	 * @return  array
	 */
	public function catalog_image_size( $size ) {
		$size['width']  = 600;
		$size['height'] = 600;
		$size['crop']   = true;

		return $size;
	}

	/**
	 * Return the image size for the single product page
	 * 
	 * @param   array  $size  Image size declaration
	 * @return  array
	 */
	public function single_image_size( $size ) {
		$size['width'] = 600;
		$size['height'] = 600;
		$size['crop']   = true;

		return $size;
	}

	/**
	 * Register section for WooCommerce
	 * 
	 * @param   array  $sections  List of sections
	 * @return  array
	 */
	public function customize_sections( $sections ) {
		$sections[ 'woocommerce' ] = array(
			'title'       => __( 'WooCommerce', 'mountain' ),
			'description' => '',
			'priority'    => 10
		);

		return $sections;
	}

	/**
	 * Register controls for WooCommerce
	 * 
	 * @param   array  $controls  List of controls
	 * @return  array
	 */
	public function customize_controls( $controls ) {
		$controls[ 'woocommerce_archive_heading' ] = array(
			'type'        => 'heading',
			'section'     => 'woocommerce',
			'title'       => __( 'Products Listing', 'mountain' ),
			'description' => __( 'This section is designed for only Woocommerce, it will be applied for page that listing all products.', 'mountain' )
		);

		$controls[ 'woocommerce_archive_sidebar_layout' ] = array(
			'type'    => 'radio-images',
			'label'   => __( 'Sidebar Position', 'mountain' ),
			'section' => 'woocommerce',
			'default' => 'no-sidebar',
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
			)
		);

		$controls[ 'woocommerce_archive_sidebar' ] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'woocommerce',
			'label'   => __( 'Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		$controls[ 'woocommerce_products_per_page' ] = array(
			'type'    => 'spinner',
			'section' => 'woocommerce',
			'label'   => __( 'Products Per Page', 'mountain' ),
			'default' => 10,
			'min'     => 1
		);

		$controls[ 'woocommerce_details_heading' ] = array(
			'type'        => 'heading',
			'section'     => 'woocommerce',
			'title'       => __( 'Product Details', 'mountain' ),
			'description' => __( 'Like "Blog Single" section, you can change style for product details page.', 'mountain' )
		);

		$controls[ 'woocommerce_single_sidebar_layout' ] = array(
			'type'           => 'radio-images',
			'label'          => __( 'Sidebar Position', 'mountain' ),
			'section'        => 'woocommerce',
			'choices'        => array(
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
			)
		);

		$controls[ 'woocommerce_single_sidebar' ] = array(
			'type'    => 'dropdown-sidebars',
			'section' => 'woocommerce',
			'label'   => __( 'Sidebar', 'mountain' ),
			'default' => 'sidebar-primary'
		);

		$controls[ 'woocommerce_product_navigator_enabled' ] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Product Navigator', 'mountain' ),
			'section' => 'woocommerce',
			'default' => true
		);

		$controls[ 'woocommerce_related_box_enabled' ] = array(
			'type'    => 'switcher',
			'label'   => __( 'Show Related Products', 'mountain' ),
			'section' => 'woocommerce',
			'default' => true
		);

		$controls[ 'woocommerce_related_products_count' ] = array(
			'type'    => 'spinner',
			'section' => 'woocommerce',
			'label'   => __( 'Number Of Related Products', 'mountain' ),
			'min'     => 1,
			'default' => 4
		);

		return $controls;
	}

	/**
	 * Override theme options for WooCommerce
	 * 
	 * @param   array  $options  Theme options
	 * @return  array
	 */
	public function override_options( $options ) {
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( is_shop() ) {
				$page_id = get_option( 'woocommerce_shop_page_id' );
				$page_options_defaults = array(
					'sidebar_layout'            => 'default',
					'enable_custom_page_header' => false,
					'breadcrumb_enabled'        => 'default',
					'topbar_enabled'            => 'default',
				);
				$page_options = array_merge(
					$page_options_defaults, (array) get_post_meta( $page_id, '_page_options', true ) );

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
			elseif ( is_archive() ) {
				$options['sidebar_layout']  = isset( $options['woocommerce_archive_sidebar_layout'] )
					? $options['woocommerce_archive_sidebar_layout']
					: $options['sidebar_layout'];

				$options['sidebar_default']  = isset( $options['woocommerce_archive_sidebar'] )
					? $options['woocommerce_archive_sidebar']
					: $options['sidebar_layout'];
			}
			else {
				$options['sidebar_layout']  = isset( $options['woocommerce_single_sidebar_layout'] )
					? $options['woocommerce_single_sidebar_layout']
					: $options['sidebar_layout'];

				$options['sidebar_default']  = isset( $options['woocommerce_single_sidebar'] )
					? $options['woocommerce_single_sidebar']
					: $options['sidebar_layout'];
			}
		}

		return $options;
	}

	/**
	 * Update the images size for the products
	 * 
	 * @return  void
	 */
	public function update_images_dimension() {
		global $pagenow;

		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}
		
		$catalog = array(
			'width'  => '400',	// px
			'height' => '400',	// px
			'crop'   => 1 		// true
		);

		$single = array(
			'width'  => '600',	// px
			'height' => '600',	// px
			'crop'   => 1 		// true
		);

		$thumbnail = array(
			'width'  => '120',	// px
			'height' => '120',	// px
			'crop'   => 0 		// false
		);
		
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail );
	}

	/**
	 * Setting up the woocommerce support
	 * 
	 * @return  void
	 */
	protected function setup() {
		/**
		 * Disable woocommerce style
		 */
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

		/**
		 * Remove woocommerce page title
		 */
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		/**
		 * Related products options
		 */
		add_filter( 'woocommerce_related_products_args', array( $this, 'related_products_args' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'output_related_products_args' ) );

		/**
		 * Override output of product image
		 */
		add_filter( 'woocommerce_single_product_image_html', array( $this, 'single_product_image_html' ), 99, 1);
		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'single_product_image_html' ), 99, 1);
		
		/**
		 * Custom products per page
		 */
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ), 20 );

		/**
		 * Send custom script to update the number of items in cart
		 */
		add_filter( 'add_to_cart_fragments', array( $this, 'cart_fragments' ) );
		
		/**
		 * Register product's image sizes
		 */
		add_filter( 'woocommerce_get_image_size_shop_thumbnail', array( $this, 'thumbnail_image_size' ) );
		add_filter( 'woocommerce_get_image_size_shop_catalog', array( $this, 'catalog_image_size' ) );
		add_filter( 'woocommerce_get_image_size_shop_single', array( $this, 'single_image_size' ) );

		/**
		 * Override the theme options
		 */
		add_filter( 'op/prepare_options', array( $this, 'override_options' ) );

		/**
		 * Disable woocommerce lightbox
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'remove_lightbox' ), 99 );

		/**
		 * Output the script placeholder for cart updater
		 */
		add_action( 'wp_footer', array( $this, 'cart_fragments_placeholder' ) );

		/**
		 * Register theme customize sections
		 */
		add_action( 'mountain/customize-sections', array( $this, 'customize_sections' ) );

		/**
		 * Register theme customize controls
		 */
		add_action( 'mountain/customize-controls', array( $this, 'customize_controls' ) );

		/**
		 * Update option for image dimensions
		 */
		add_action( 'after_switch_theme', array( $this, 'update_images_dimension' ) );
	}

	/**
	 * Return the flag that allow to initialize
	 * this feature
	 * 
	 * @return  boolean
	 */
	protected function enabled() {
		return current_theme_supports( 'woocommerce' ) && function_exists( 'is_woocommerce' );
	}
}
