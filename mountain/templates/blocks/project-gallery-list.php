<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

$project_media_items = get_post_meta( $post->ID, '_project_media', true );
$project_media_items = is_array( $project_media_items ) ? $project_media_items : array();

$classes = apply_filters( 'projects/gallery-class', array( 'project-gallery', 'project-gallery-list' ) );
$classes = array_filter( $classes );
$classes = array_unique( $classes );
?>

<div id="project-gallery" class="<?php __esc_attr( join( ' ', $classes ) ) ?>">
	<div class="project-gallery-wrap">
		<?php foreach ( $project_media_items as $item ): ?>
			
			<div class="project-media-item">
				<?php

					$attachment_image = wp_get_attachment_image_src( $item['id'], 'thumbnail-large' );
					$attachment_image_src = $attachment_image[0];

				?>
				<a href="<?php __esc_url( $attachment_image_src ) ?>" title="<?php echo esc_attr( $item['desc'] ) ?>" data-lightbox="nivoLightbox" data-lightbox-gallery="<?php __esc_attr( get_the_ID() ) ?>">
					<?php echo wp_get_attachment_image( $item['id'], 'full' ) ?>
				</a>
			</div>

		<?php endforeach ?>
	</div>
</div>
