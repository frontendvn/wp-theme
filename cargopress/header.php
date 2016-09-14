<?php
/**
 * The Header for CargoPress Theme
 *
 * @package CargoPress
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php wp_head(); ?>
	</head>

	<body <?php body_class( CargoPressHelpers::add_body_class() ); ?>>
	<div class="boxed-container">

	<?php if ( 'no' !== get_theme_mod( 'top_bar_visibility', 'yes' ) ) : ?>
		<div class="top">
			<div class="container">
				<!-- Top Tagline from WordPress -->
				<div class="top__tagline">
					<?php bloginfo( 'description' ); ?>
				</div>
				<!-- Top Menu -->
				<nav class="top__menu" role="navigation" aria-label="<?php _e( 'Top Menu', 'cargopress-pt' ); ?>">
					<?php
					if ( has_nav_menu( 'top-bar-menu' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'top-bar-menu',
							'container'      => false,
							'menu_class'     => 'top-navigation  js-dropdown',
							'walker'         => new Aria_Walker_Nav_Menu(),
							'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
						) );
					}
					?>
				</nav>
			</div>
		</div>
	<?php endif; ?>

	<div class="header__container">
		<div class="container">
			<header class="header" role="banner">
				<div class="header__logo">
					<a href="<?php echo esc_url( home_url() ); ?>">
					<?php
						$logo              = get_theme_mod( 'logo_img', false );
						$logo2x            = get_theme_mod( 'logo2x_img', false );
						$logo_width_height = CargoPressHelpers::get_logo_dimensions();

						if ( ! empty( $logo ) ) :
						?>
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_attr( $logo ); ?><?php echo empty ( $logo2x ) ? '' : ', ' . esc_url( $logo2x ) . ' 2x'; ?>" class="img-responsive" <?php echo $logo_width_height; ?> />
						<?php
						else :
						?>
							<h1><?php bloginfo( 'name' ); ?></h1>
						<?php
						endif;
					?>
					</a>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cargopress-navbar-collapse">
						<span class="navbar-toggle__text"><?php _e( 'MENU', 'cargopress-pt' ); ?></span>
						<span class="navbar-toggle__icon-bar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</span>
					</button>
				</div>
				<div class="header__navigation  js-sticky-offset">
					<nav class="collapse  navbar-collapse" role="navigation" aria-label="<?php _e( 'Main Menu', 'cargopress-pt' ); ?>" id="cargopress-navbar-collapse">
						<?php
						if ( has_nav_menu( 'main-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'main-menu',
								'container'      => false,
								'menu_class'     => 'main-navigation  js-main-nav  js-dropdown',
								'walker'         => new Aria_Walker_Nav_Menu(),
								'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
							) );
						}
						?>
					</nav>
				</div>
				<div class="header__widgets">
				<?php
					if ( is_active_sidebar( 'header-widgets' ) ) {
						dynamic_sidebar( 'header-widgets' );
					}
				?>
				</div>
				<?php if ( is_active_sidebar( 'navigation-widgets' ) ) : ?>
				<div class="header__navigation-widgets">
					<?php dynamic_sidebar( 'navigation-widgets' ); ?>
				</div>
				<?php endif; ?>
			</header>
		</div>
	</div>