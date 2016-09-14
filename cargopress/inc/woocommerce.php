<?php
/**
 * Functions for the basic WooCommerce implementation
 *
 * @package CargoPress
 */

if ( CargoPressHelpers::is_woocommerce_active() ) {

	// remove all the woocommerce CSS
	// add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	/**
	 * Theme compatibility
	 *
	 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	/**
	 * Missing HTML markup before and after the shop items
	 */
	add_action( 'woocommerce_before_main_content', 'cargopress_theme_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'cargopress_theme_wrapper_end', 10 );

	function cargopress_theme_wrapper_start() {
		$sidebar = cargopress_get_shop_sidebar();

		get_template_part( 'part-main-title' );
		get_template_part( 'part-breadcrumbs' );

		?>

	<div class="container">
		<div class="row">
			<main class="col-xs-12<?php echo 'left' === $sidebar ? '  col-md-9  col-md-push-3' : ''; echo 'right' === $sidebar ? '  col-md-9' : ''; ?>" role="main">
				<?php
				}

				function cargopress_theme_wrapper_end() {
					$sidebar = cargopress_get_shop_sidebar();
				?>
			</main>
			<?php if ( 'none' !== $sidebar ) : ?>
				<div class="col-xs-12  col-md-3<?php echo 'left' === $sidebar ? '  col-md-pull-9' : ''; ?>">
					<div class="sidebar" role="complementary">
						<?php
							if ( is_active_sidebar( 'shop-sidebar' ) ) {
								dynamic_sidebar( 'shop-sidebar' );
							}
						?>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
	<?php
	}

	/**
	 * Removes the confusing body.woocommerce so it is easier and more
	 * reliable to target the elements within WooCommerce implementation
	 *
	 * @param  array $classes
	 * @return array
	 */
	function cargopress_woo_body_class( $classes ) {
		$classes = (array) $classes;

		if ( is_shop() ) {
			$classes[] = 'woocommerce-shop-page';
		}

		return $classes;
	}
	add_filter( 'body_class', 'cargopress_woo_body_class', 11 );

	// Display custom number of products per page
	function cargopress_custom_number_of_products_per_page( $cols ) {
		return absint( get_theme_mod( 'products_per_page', $cols ) );
	}
	add_filter( 'loop_shop_per_page', 'cargopress_custom_number_of_products_per_page', 20 );

	// remove the title, because we show it elsewhere
	add_filter( 'woocommerce_show_page_title', '__return_false' );
	add_filter( 'woocommerce_get_sidebar', '__return_false' );

	// remove breadcrumbs, we have our own
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	// remove rating from the single page
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 3 );

	/**
	 * Change number of related columns/products for single product page.
	 *
	 * @param  array $args
	 * @return array
	 */
	function cargopress_output_related_products_args( $args ) {
		$args['posts_per_page'] = 3;
		$args['columns']        = 3;

		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'cargopress_output_related_products_args' );

	/**
	 * Get the position of the sidebar for the shop pages, conditionally for the single product
	 */
	function cargopress_get_shop_sidebar() {
		if ( is_product() ) {
			return get_theme_mod( 'single_product_sidebar', 'left' );
		} else {
			return get_field( 'sidebar', (int) get_option( 'woocommerce_shop_page_id' ) );
		}
	}

	/**
	 * Change number or products per row to 3
	 */
	if ( ! function_exists( 'cargopress_loop_columns' ) ) {
		function cargopress_loop_columns() {
			return 3; // 3 products per row
		}
	}
	add_filter( 'loop_shop_columns', 'cargopress_loop_columns' );

	// Disable automatic redirect after WooCommerce plugin activation
	add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

	/**
	 * Change smallscreen breakpoint.
	 */
	function repairpress_smallscreen_breakpoint() {
		return '767px';
	}
	add_filter( 'woocommerce_style_smallscreen_breakpoint', 'repairpress_smallscreen_breakpoint' );
}