<?php
/**
 * WARNING: This file is part of the AnyCar Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();
?>
<div id="masthead">
	<div class="wrapper">
		<div id="site-brand">
			<?php get_template_part( 'templates/blocks/header/brand' ) ?>
		</div>
		<nav id="site-navigator" class="navigator" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
			
			<?php

				/**
				 * Call actions before display primary menu
				 */
				do_action( 'mountain/before_primary_menu', array( 'env' => 'desktop' ) );

				/**
				 * Display the primary menu
				 */
				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_class'      => 'menu',
					'fallback_cb'     => false,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 0
				) );

				/**
				 * Call actions after display primary menu
				 */
				do_action( 'mountain/after_primary_menu', array( 'env' => 'desktop' ) );

			?>

		</nav>
	</div>

	<?php get_template_part( 'templates/blocks/header/navigator', 'mobile' ) ?>
</div>
