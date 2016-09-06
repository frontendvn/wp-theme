<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

$classes = apply_filters( 'projects/archive-class', array( 'projects' ) );
$classes = array_filter( $classes );
$classes = array_unique( $classes );
?>

<?php if ( have_posts() ): ?>

	<div class="content-inner">
		<div class="<?php __esc_attr( join( ' ', $classes ) ) ?>" data-columns="<?php __esc_attr( op_option( 'projects_grid_columns', 4 ) ) ?>">
			<div class="projects-wrap">
				<?php get_template_part( 'templates/blocks/project', 'filter' ) ?>

				<div class="projects-items">
					<?php while ( have_posts() ): the_post(); ?>

						<div class="<?php __esc_attr( join( ' ', get_post_class( 'project' ) ) ) ?>" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
							<div class="project-wrap">
								<figure class="project-thumbnail">
									<?php if ( op_option( 'projects_archive_permalink' ) ): ?>
										<a href="<?php the_permalink() ?>">
											<?php the_post_thumbnail( apply_filters( 'projects/archive-thumbnail-size', 'thumbnail-medium' ), array( 'itemprop' => 'image' ) ) ?>
										</a>
									<?php else: ?>
										<a><?php the_post_thumbnail( apply_filters( 'projects/archive-thumbnail-size', 'thumbnail-medium' ), array( 'itemprop' => 'image' ) ) ?></a>
									<?php endif ?>
								</figure>

								<div class="project-info">
									<div class="project-info-wrap">
										<?php if ( op_option( 'projects_archive_permalink' ) ): ?>
											<h3 class="project-title" itemprop="name headline">
												<a href="<?php the_permalink() ?>">
													<?php the_title() ?>
												</a>
											</h3>
										<?php else: ?>
											<h3 class="project-title" itemprop="name headline">
												<a><?php the_title() ?></a>
											</h3>
										<?php endif ?>
										
										<?php if ( op_option( 'projects_archive_category_enabled' ) ): ?>
											<ul class="project-categories">
												<?php if ( op_option( 'projects_archive_category_permalink' ) ): ?>
													<?php the_terms( get_the_ID(), nProjects::TYPE_CATEGORY, '<li>', '</li><li>', '</li>' ) ?>
												<?php else: ?>
													<?php foreach ( get_the_terms( get_the_ID(), nProjects::TYPE_CATEGORY ) as $category ): ?>
														<li>
															<a><?php __esc_html( $category->name ) ?></a>
														</li>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>

					<?php endwhile ?>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'templates/blocks/pagination' ) ?>

<?php else: ?>
	<!-- Show empty message -->
<?php endif ?>
