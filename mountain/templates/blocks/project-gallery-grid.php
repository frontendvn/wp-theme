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

$classes = apply_filters( 'projects/gallery-class', array( 'project-gallery', 'project-gallery-grid' ) );
$classes = array_filter( $classes );
$classes = array_unique( $classes );

$gallery_type = op_option( 'projects_single_gallery_type' );
$gallery_image_size = 'full';

if ( $gallery_type == 'grid' ) {
	$image_sizes = array(
		2 => 'thumbnail-medium',
		3 => 'thumbnail-medium',
		4 => 'thumbnail-small',
		5 => 'thumbnail-small'
	);

	$gallery_image_size = $image_sizes[ op_option( 'projects_single_gallery_columns' ) ];
}
?>

<div id="project-gallery" class="<?php __esc_attr( join( ' ', $classes ) ) ?>" data-columns="<?php __esc_attr( op_option( 'projects_single_gallery_columns', 4 ) ) ?>">
	<div class="project-gallery-wrap">
		<?php foreach ( $project_media_items as $item ): ?>
			
			<div class="project-media-item">
				<?php

					$attachment_image = wp_get_attachment_image_src( $item['id'], 'full' );
					$attachment_image_src = $attachment_image[0];

				?>
				<a href="<?php __esc_url( $attachment_image_src ) ?>" title="<?php echo esc_attr( $item['desc'] ) ?>" data-lightbox="nivoLightbox" data-lightbox-gallery="<?php __esc_attr( get_the_ID() ) ?>">
					<?php echo wp_get_attachment_image( $item['id'], $gallery_image_size ) ?>
				</a>
			</div>

		<?php endforeach ?>
	</div>
</div>
