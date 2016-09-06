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
	<?php while ( have_posts() ): the_post(); ?>
		<div class="content-inner">
			<?php get_template_part( 'templates/blocks/post-single', get_post_format() ) ?>
		</div>

		<?php
		get_template_part( 'templates/blocks/post/navigator' );
		get_template_part( 'templates/blocks/post/author' );
		
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) comments_template();
		?>
	<?php endwhile ?>
<?php endif ?>
