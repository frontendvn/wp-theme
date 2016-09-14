<?php
/**
 * Add the link to documentation under Appearance in the wp-admin
 */

if ( ! function_exists( 'cargopress_add_docs_page' ) ) {
	function cargopress_add_docs_page() {
		add_theme_page(
			_x( 'Documentation', 'backend', 'cargopress-pt' ),
			_x( 'Documentation', 'backend', 'cargopress-pt' ),
			'',
			'proteusthemes-theme-docs',
			'cargopress_docs_page_output'
		);
	}
	add_action( 'admin_menu', 'cargopress_add_docs_page' );

	function cargopress_docs_page_output() {
		?>
		<div class="wrap">
			<h2><?php _ex( 'Documentation', 'backend', 'cargopress-pt' ); ?></h2>

			<p>
				<strong><a href="https://www.proteusthemes.com/docs/cargopress-pt/" class="button button-primary " target="_blank"><?php _ex( 'Click here to see online documentation of the theme!', 'backend', 'cargopress-pt' ); ?></a></strong>
			</p>
		</div>
		<?php
	}
}