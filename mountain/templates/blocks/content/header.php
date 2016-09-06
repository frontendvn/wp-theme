<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if ( op_option( 'pagetitle_enabled', true ) == false )
	return;

$parallax_attr = ! op_option( 'pagetitle_parallax', false ) ? '' : 'data-stellar-background-ratio="0.2"';
?>
<div id="page-header" <?php echo $parallax_attr ?> >
	<div class="overlay"></div>
	<div class="wrapper">
		<?php if ( is_single() && current_post_type_is( 'post' ) && op_option( 'blog_post_header_background', true ) ): ?>
			<?php mountain_post_meta() ?>
		<?php endif ?>

		<?php get_template_part( 'templates/blocks/content/header', 'title' ) ?>
		<?php get_template_part( 'templates/blocks/content/breadcrumb' ) ?>
	</div>
	<!-- /.wrapper -->
</div>
<!-- /#page-header -->
