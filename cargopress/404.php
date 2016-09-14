<?php
/**
 * 404 page
 *
 * @package CargoPress
 */

get_header();

get_template_part( 'part-breadcrumbs' );

?>

<div class="error-404">
	<div class="container">
		<img src="<?php echo esc_attr( get_template_directory_uri() ) . '/assets/images/404.png'; ?>" alt="<?php _e( '404 Picture' , 'cargopress-pt' ); ?>" class="push-down-30">
		<div class="error-404__content">
			<h2 class="alternative-heading--center"><?php _e( 'LOOKS LIKE SOMETHING WENT WRONG!' , 'cargopress-pt' ); ?></h2>
			<p class="error-404__text">
			<?php
				printf(
					/* translators: the first %s for line break, the second and third %s for link to home page wrap */
					__( 'The page you were looking for is not here. %s Go %s Home %s or try to search:' , 'cargopress-pt' ),
					'<br />',
					'<b><a href="' . esc_url( home_url( '/' ) ) . '">',
					'</a></b>'
				);
			?>
			</p>
			<div class="widget_search">
				<?php echo get_search_form(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>