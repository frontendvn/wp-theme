<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

global $_post_options, $_post_thumbnail_size;

if ( ! post_password_required() && ! is_attachment() && ! empty( $_post_options['post_images'] ) ):
	$post_images = json_decode( $_post_options['post_images'], true );

	if ( ! empty( $post_images ) ):
	?>
	
		<div class="entry-cover flexslider">
			<ul class="slides">
				<?php foreach ( $post_images as $image ): ?>
					<li>
						<?php list( $src, $width, $height ) = wp_get_attachment_image_src( $image['id'], 'full' ); ?>
						<?php list( $thumb_src, $thumb_width, $thumb_height ) = wp_get_attachment_image_src( $image['id'], $_post_thumbnail_size ); ?>

						<a href="<?php __esc_url( $src ) ?>" data-lightbox="nivoLightbox" data-lightbox-gallery="entry-<?php __esc_attr( get_the_ID() ) ?>">
							<img src="<?php __esc_url( $thumb_src ) ?>" width="<?php __esc_attr( $thumb_width ) ?>" height="<?php __esc_attr( $thumb_height ) ?>" alt="<?php __esc_attr( get_the_title() ) ?>" />
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>

	<?php endif ?>

<?php endif ?>
