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
<nav id="site-navigator-mobile" class="navigator-mobile" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

	<a href="#" class="navigator-toggle">
		<i class="fa fa-bars"></i>
	</a>
	<!-- /.navigator-toggle -->
	
	<?php
	/**
	 * Call actions before display primary menu
	 */
	do_action( 'mountain/before_primary_menu', array( 'env' => 'mobile' ) );

	/**
	 * Display the primary menu
	 */
	wp_nav_menu( apply_filters( 'mountain/primary_menu_options', array(
		'theme_location'  => 'primary',
		'container'       => false,
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'fallback_cb'     => false,
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0
	) ) );

	/**
	 * Call actions after display primary menu
	 */
	do_action( 'mountain/after_primary_menu', array( 'env' => 'mobile' ) );
	?>

</nav>
