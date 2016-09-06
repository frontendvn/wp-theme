<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

global $_post_thumbnail_size;

if ( post_password_required() || is_attachment() || ! has_post_thumbnail() )
	return;
?>

<div class="entry-cover">
	<?php if ( is_singular() ): ?>
		<?php the_post_thumbnail() ?>
	<?php else: ?>
		<a href="<?php the_permalink() ?>">
			<?php the_post_thumbnail( $_post_thumbnail_size ) ?>
		</a>
	<?php endif ?>
</div>
