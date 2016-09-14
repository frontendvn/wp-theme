<?php
/**
 * Main Page Page
 *
 * @package CargoPress
 */

get_header();

$sidebar = get_field( 'sidebar' );

if ( ! $sidebar ) {
	$sidebar = 'left';
}

get_template_part( 'part-main-title' );
get_template_part( 'part-breadcrumbs' );

?>

	<div class="container">
		<div class="row">
			<main class="col-xs-12<?php echo 'left' === $sidebar ? '  col-md-9  col-md-push-3' : ''; echo 'right' === $sidebar ? '  col-md-9' : ''; ?>" role="main">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
				?>

				<article <?php post_class( 'clearfix' ); ?>>
					<div class="hentry__content">
						<?php the_content(); ?>
					</div>
					<?php
					if ( comments_open( get_the_ID() ) ) {
						comments_template( '', true );
					}
					?>
				</article>

				<?php
						endwhile;
					endif;
				?>

			</main>

			<?php if ( 'none' !== $sidebar ) : ?>
				<div class="col-xs-12  col-md-3<?php echo 'left' === $sidebar ? '  col-md-pull-9' : ''; ?>">
					<div class="sidebar" role="complementary">
						<?php
							if ( is_active_sidebar( 'regular-page-sidebar' ) ) {
								dynamic_sidebar( 'regular-page-sidebar' );
							}
						?>
					</div>
				</div>
			<?php endif ?>

		</div>
	</div>

<?php get_footer(); ?>