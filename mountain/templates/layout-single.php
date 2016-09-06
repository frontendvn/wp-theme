<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

if( ! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
	  strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest' ) {
    
    return include mountain_template_path();
}
?>
<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

		<?php if ( version_compare( get_bloginfo( 'version' ), '4.1', '<' ) ): ?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php endif ?>

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />

		<?php wp_head() ?>
	</head>
	<body <?php body_class() ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
		<?php do_action( 'get_header' ) ?>
		<?php do_action( 'mountain/above_site_wrapper' ) ?>

		<div id="site-wrapper">
			<?php do_action( 'mountain/above_site_header' ) ?>

			<div id="site-header">
				<?php get_template_part( 'templates/blocks/header/masthead', op_option( 'header_style' ) ) ?>
			</div>
			<!-- /#site-header -->

			<?php do_action( 'mountain/below_site_header' ) ?>
			<?php do_action( 'mountain/above_site_content' ) ?>
			
			<div id="site-content">
				<?php while ( have_posts() ): the_post(); ?>
					<?php get_template_part( 'templates/blocks/content/header' ) ?>
				<?php endwhile ?>
				<?php rewind_posts(); ?>
				
				<?php do_action( 'mountain/above_page_body' ) ?>

				<div id="page-body">
					<div class="wrapper">
						<?php do_action( 'mountain/above_content_wrap' ) ?>

						<div class="content-wrap">
							<?php do_action( 'mountain/above_main_content' ) ?>
						
							<main id="main-content" class="content" role="main" itemprop="mainContentOfPage">
								<div class="main-content-wrap">
									<?php include mountain_template_path() ?>
								</div>
							</main>
							<!-- /#main-content -->
						
							<?php do_action( 'mountain/below_main_content' ) ?>
							<?php get_sidebar() ?>
						</div>
						<!-- /.content-wrap -->

						<?php if ( op_option( 'blog_related_box_enabled' ) ): ?>
							<!-- Related Posts -->
							<?php get_template_part( 'templates/blocks/post-related', op_option( 'blog_related_posts_style', 'grid' ) ) ?>
						<?php endif ?>
						
						<?php do_action( 'mountain/below_content_wrap' ) ?>
					</div>
					<!-- /.wrapper -->
				</div>
				<!-- /#page-body -->

				<?php do_action( 'mountain/below_page_body' ) ?>
			</div>
			<!-- /#site-content -->
			
			<?php do_action( 'mountain/below_site_content' ) ?>
			<?php do_action( 'mountain/above_site_footer' ) ?>
			<div id="site-footer">
				<?php get_template_part( 'templates/blocks/footer/widgets' ) ?>

				<div id="footer-content">
					<div class="wrapper">
						<?php get_template_part( 'templates/blocks/footer/social-links' ) ?>
						<?php get_template_part( 'templates/blocks/footer/copyright' ) ?>
					</div>
				</div>
				<!-- /.wrapper -->
			</div>
			<!-- /#site-footer -->
		</div>
		<!-- /#site-wrapper -->

		<?php do_action( 'mountain/below_site_wrapper' ) ?>
		<?php get_template_part( 'templates/blocks/off-canvas' ) ?>
		
		<?php if ( op_option( 'gotop_enabed' ) ): ?>
			<div class="goto-top"><a href="#top"><?php _e( 'Goto Top', 'mountain' ) ?></a></div>
		<?php endif ?>

		<?php wp_footer() ?>
	</body>
</html>
