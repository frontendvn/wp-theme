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

$_post_options = get_post_meta( get_the_ID(), '_post_options', true );
$_post_thumbnail_size = 'full';
?>
<article <?php post_class() ?>>
	<div class="entry-wrapper">
		<?php if ( ! op_option( 'blog_post_header_background', true ) || ! is_single() ): ?>
			<div class="entry-date">
				<span class="entry-month">
					<?php __esc_html( get_the_date( 'M' ) ) ?>
				</span>
				<span class="entry-day">
					<?php __esc_html( get_the_date( 'd' ) ) ?>
				</span>
				<span class="entry-year">
					<?php __esc_html( get_the_date( 'Y' ) ) ?>
				</span>
			</div>

			<?php get_template_part( 'templates/blocks/post/cover', get_post_format() ) ?>
			
			<?php if ( op_current_post_type() != 'page' ): ?>

				<header class="entry-header">
					<?php mountain_post_title() ?>
					<?php mountain_post_meta() ?>
				</header>

			<?php endif ?>
		<?php endif ?>

		<div class="entry-content" itemprop="text">
			
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			}
			else {
				mountain_post_content();
			}
			
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mountain' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>

		</div>
		<!-- /entry-content -->

		<?php if ( is_single() && get_the_tags() ): ?>
			<div class="entry-footer">
				<div class="entry-tags">
					<?php the_tags( '', ' ' ); ?>
				</div>
			</div>
			<!-- /.entry-footer -->
		<?php endif ?>
	</div>
	<!-- /.entry-wrapper -->
</article>
<!-- /#post-<?php echo get_the_ID() ?> -->
