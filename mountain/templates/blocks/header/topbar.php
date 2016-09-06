<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Ignore ouput topbar when it isn't enabled
if ( ! op_option( 'topbar_enabled' ) ) return;

$available_icons = op_available_social_icons();
$social_links    = op_option( 'social_links' );

if ( ! isset( $social_links['__icons_ordering__'] ) ) {
	$social_links['__icons_ordering__'] = $available_icons['__icons_ordering__'];
}
?>
<div id="headerbar">
	<div class="wrapper">
		<div class="custom-info">
			<?php echo wp_kses_post( op_option( 'topbar_content' ) ) ?>
		</div>
		<!-- /.custom-info -->

		<?php if ( op_option( 'topbar_social_links_enabled' ) ): ?>
			
			<div class="social-links">
				<?php foreach ( $social_links['__icons_ordering__'] as $id ):
					if ( ! isset( $available_icons[$id] ) || ! isset( $social_links[$id] ) )
						continue;

					$link = $social_links[$id];
					$icon_class = $available_icons[$id]['icon_class'];
					?>
					<a href="<?php __esc_url( $link ) ?>" target="_blank">
						<i class="fa <?php __esc_attr( $icon_class ) ?>"></i>
					</a>
				<?php endforeach ?>
			</div>
			<!-- /.social-links -->

		<?php endif ?>

		<?php if ( has_nav_menu( 'top' ) ): ?>

			<nav class="top-navigator" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
				
				<?php
				/**
				 * Call actions before display primary menu
				 */
				do_action( 'mountain/before_top_menu' );

				/**
				 * Display the primary menu
				 */
				wp_nav_menu( array(
					'theme_location'  => 'top',
					'container'       => false,
					'menu_class'      => 'menu',
					'fallback_cb'     => false,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 0
				) );

				/**
				 * Call actions after display primary menu
				 */
				do_action( 'mountain/after_top_menu' );
				?>

			</nav>
			<!-- /.top-navigator -->

		<?php endif ?>
	</div>
	<!-- /.wrapper -->
</div>
<!-- /#headerbar -->
