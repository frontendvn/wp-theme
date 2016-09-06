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
<?php if ( have_posts() ): ?>
	<div class="content-inner">
		<?php while ( have_posts() ): the_post(); ?>
			<?php get_template_part( 'templates/blocks/post', get_post_format() ) ?>
		<?php endwhile ?>
	</div>
	<?php get_template_part( 'templates/blocks/pagination' ) ?>
<?php else: ?>
	<div class="content-inner">
		<?php get_template_part( 'templates/blocks/post/empty' ) ?>
	</div>
<?php endif ?>
