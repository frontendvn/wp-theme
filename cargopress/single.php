<?php
/**
 * Single Post Page
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
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>
					<?php endif; ?>
					<?php get_template_part( 'part-meta-data' ); ?>
					<h1 class="hentry__title"><?php the_title(); ?></h1>
					<div class="hentry__content">
						<?php the_content(); ?>
					</div>

					<!-- Multi Page in One Post -->
						<?php
							$args = array(
								'before'      => '<div class="multi-page  clearfix">' . /* translators: after that comes pagination like 1, 2, 3 ... 10 */ __( 'Pages:', 'cargopress-pt' ) . ' &nbsp; ',
								'after'       => '</div>',
								'link_before' => '<span class="btn  btn-info">',
								'link_after'  => '</span>',
								'echo'        => 1,
							);
							wp_link_pages( $args );
						?>
						<?php comments_template( '', true ); ?>
				</article>

				<?php
					endwhile;
				else :
				?>

				<h4><?php _e( 'Sorry, no results found.', 'cargopress-pt' ); ?></h4>

				<?php
				endif;
				?>

			</main>

			<?php if ( 'none' !== $sidebar ) : ?>
				<div class="col-xs-12  col-md-3<?php echo 'left' === $sidebar ? '  col-md-pull-9' : ''; ?>">
					<div class="sidebar" role="complementary">
						<?php
							if ( is_active_sidebar( 'blog-sidebar' ) ) {
								dynamic_sidebar( 'blog-sidebar' );
							}
						?>
					</div>
				</div>
			<?php endif ?>

		</div>
	</div>

<?php get_footer(); ?>