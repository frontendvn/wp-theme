<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if ( op_current_post_type() == 'post' && ! op_option( 'blog_post_navigator_enabled' ) ) return;
if ( ! get_next_post_link() && ! get_previous_post_link() ) return;
?>

<nav class="navigation post-navigation" role="navigation">
	<ul class="nav-links">
		<?php
		if ( is_attachment() ) :
			previous_post_link( '<li>%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', __( 'Published In', 'mountain' ) ) );
		else :
			previous_post_link( '<li class="previous-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', __( 'Previous Post', 'mountain' ) ) );
			next_post_link( '<li class="next-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', __( 'Next Post', 'mountain' ) ) );
		endif;
		?>
	</ul><!-- .nav-links -->
</nav><!-- .navigation -->
