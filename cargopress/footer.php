<?php
/**
 * Footer
 *
 * @package CargoPress
 */

$footer_widgets_layout = CargoPressHelpers::footer_widgets_layout_array();

?>

	<footer class="footer" role="contentinfo">
		<?php if ( ! empty( $footer_widgets_layout ) && is_active_sidebar( 'footer-widgets' ) ) : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer-widgets' ); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom__left">
					<?php echo apply_filters( 'cargopress/footer_left_txt', get_theme_mod( 'footer_left_txt', 'CargoPress Theme Made by <a href="https://www.proteusthemes.com/">ProteusThemes</a>.' ) ); ?>
				</div>
				<div class="footer-bottom__right">
					<?php echo apply_filters( 'cargopress/footer_right_txt', get_theme_mod( 'footer_right_txt', 'Copyright &copy; 2009–2015 CargoPress. All rights reserved.' ) ); ?>
				</div>
			</div>
		</div>
	</footer>
	</div><!-- end of .boxed-container -->

	<?php wp_footer(); ?>
	</body>
</html>