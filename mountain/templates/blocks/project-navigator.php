<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

$archive_page = op_option( 'projects_archive_page' );
$archive_link = get_page_link( $archive_page );
?>

<nav class="navigation project-navigation" role="navigation">
	<ul class="nav-links">
		<?php if ( get_previous_post_link() ): ?>
			<?php previous_post_link( '<li class="previous-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', __( 'Previous Post', 'mountain' ) ) ) ?>
		<?php else: ?>
			<li class="previous-post disabled">
				<span><?php _e( 'Previous Project', 'mountain' ) ?></span>
			</li>
		<?php endif ?>

		<li class="project-home">
			<a href="<?php __esc_url( $archive_link ) ?>">
				<span><?php _e( 'Project Home', 'mountain' ) ?></span>
			</a>
		</li>

		<?php if ( get_next_post_link() ): ?>
			<?php next_post_link( '<li class="next-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', __( 'Next Post', 'mountain' ) ) ) ?>
		<?php else: ?>
			<li class="next-post disabled">
				<span><?php _e( 'Next Project', 'mountain' ) ?></span>
			</li>
		<?php endif ?>
	</ul><!-- .nav-links -->
</nav><!-- .navigation -->
