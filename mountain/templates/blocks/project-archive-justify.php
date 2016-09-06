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
		<div class="<?php __esc_attr( join( ' ', $classes ) ) ?>">
			<div class="projects-wrap">
				<div class="projects-items flex-images">
					<?php while ( have_posts() ): the_post();
						$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail-medium' );
						?>

						<div class="<?php __esc_attr( join( ' ', get_post_class( 'project item' ) ) ) ?>" itemscope="itemscope" itemtype="http://schema.org/CreativeWork"
							data-w="<?php __esc_attr( $thumbnail[1] ) ?>" data-h="<?php __esc_attr( $thumbnail[2] ) ?>">
							<?php if ( op_option( 'projects_archive_permalink' ) ): ?>
								<a href="<?php the_permalink() ?>">
									<?php the_post_thumbnail( 'thumbnail-medium', array( 'itemprop' => 'image' ) ) ?>
								</a>
							<?php else: ?>
								<a><?php the_post_thumbnail( 'thumbnail-medium', array( 'itemprop' => 'image' ) ) ?></a>
							<?php endif ?>

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

					<?php endwhile ?>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'templates/blocks/pagination' ) ?>

<?php else: ?>
	<!-- Show empty message -->
<?php endif ?>
