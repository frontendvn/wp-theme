<?php
/**
 * Main blog page
 *
 * @package CargoPress
 */

get_header();

$sidebar = get_field( 'sidebar', (int) get_option( 'page_for_posts' ) );

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
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>
						</a>
					<?php endif; ?>
					<?php get_template_part( 'part-meta-data' ); ?>
					<h2 class="hentry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="hentry__content">
						<?php the_content( sprintf( '<span class="btn  btn-default  btn--post">%s</span>', __( 'Read More', 'cargopress-pt' ) ) ); ?>
					</div>
				</article>

				<?php
					endwhile;
				else :
				?>

				<h4><?php _e( 'Sorry, no results found.', 'cargopress-pt' ); ?></h4>

				<?php
				endif;
				?>

				<?php
					the_posts_pagination(
						array(
							'prev_text' => '<i class="fa  fa-caret-left"></i>',
							'next_text' => '<i class="fa  fa-caret-right"></i>',
						) );
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