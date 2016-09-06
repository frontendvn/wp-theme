<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();
?>

<div class="content-inner">
	<?php while( have_posts() ): the_post(); ?>
		<?php

			$classes = apply_filters( 'projects/single-class', array( 'project-single' ) );
			$classes[] = sprintf( 'project-content-%s', op_option( 'projects_single_content_position', 'fullwidth' ) );

			if ( op_option( 'projects_single_content_sticky', true ) )
				$classes[] = 'project-content-sticky';

			$classes = array_filter( $classes );
			$classes = array_unique( $classes );

		?>

		<div class="<?php __esc_attr( join( ' ', $classes ) ) ?>">
			<div class="project-single-wrap">
				<div class="project-content">
					<div class="project-content-wrap">
						<?php if ( op_option( 'projects_single_categories_enabled', true ) && get_the_terms( get_the_ID(), nProjects::TYPE_CATEGORY ) ): ?>
							<div class="project-categories">
								<span><?php _e( 'Category:', 'mountain' ) ?></span>
								<?php echo get_the_term_list( get_the_ID(), nProjects::TYPE_CATEGORY, '', '<span class="separator">, </span>' ); ?>
							</div>
						<?php endif ?>
						
						<?php the_content() ?>

						<?php if ( op_option( 'projects_single_tags_enabled', true ) && get_the_terms( get_the_ID(), nProjects::TYPE_TAG ) ): ?>
							<div class="project-tags">
								<?php echo get_the_term_list( get_the_ID(), nProjects::TYPE_TAG ); ?>
							</div>
						<?php endif ?>
					</div>
				</div>

				<?php get_template_part( 'templates/blocks/project-gallery', op_option( 'projects_single_gallery_type', 'list' ) ); ?>
			</div>
		</div>

		<?php if ( op_option( 'projects_single_navigator_enabled', true ) ): ?>
			<?php get_template_part( 'templates/blocks/project-navigator' ) ?>
		<?php endif ?>

		<?php get_template_part( 'templates/blocks/project-related' ) ?>

	<?php endwhile ?>
</div>
