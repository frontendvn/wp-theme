<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if ( ! op_option( 'blog_author_box_enabled' ) ) return;
if ( ! ( $author_id = get_the_author_meta( 'ID' ) ) )
	$author_id = get_query_var( 'author' );
?>
<section class="box author-box" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
	<div class="box-wrapper">
		<h3 class="box-title author-name">
			<span><?php _e( 'About', 'mountain' ) ?></span>
			<a href="<?php __esc_url( get_author_posts_url( $author_id ) ) ?>" itemprop="name">
				<?php echo wp_kses_post( get_user_option( 'display_name', $author_id ) ) ?>
			</a>
		</h3>
		<div class="box-content">
			<?php if ( get_option( 'show_avatars' ) ): ?>
				<div class="author-avatar">
					<?php echo wp_kses_post( get_avatar( $author_id ) ) ?>
				</div>
			<?php endif ?>

			<div class="author-description">
				<?php echo wp_kses_post( get_the_author_meta( 'description', $author_id ) ) ?>
			</div>
		</div>
	</div>
</section>
