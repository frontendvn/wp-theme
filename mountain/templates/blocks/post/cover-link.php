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

$post_link = $_post_options['post_link'];

if ( empty( $post_link ) || ! filter_var( $post_link, FILTER_VALIDATE_URL ) )
	$post_link = get_permalink();

if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
	if ( is_singular() ):
		?>

			<div class="entry-cover">
				<?php the_post_thumbnail() ?>
			</div>

		<?php
	else:
		?>

			<div class="entry-cover">
				<a href="<?php __esc_url( $post_link ) ?>">
					<?php the_post_thumbnail( get_the_ID(), $_post_thumbnail_size ) ?>
				</a>
			</div>

		<?php
	endif;
}
