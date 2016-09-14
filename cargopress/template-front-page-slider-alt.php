<?php
/*
Template Name: Front Page With Layer/Revolution Slider
*/

get_header();

// slider
$type = get_field( 'slider_type' );

if ( 'layer' === $type && function_exists( 'layerslider' ) ) { // layer slider
	layerslider( (int) get_field( 'layerslider_id' ) );
}
else if ( 'revolution' === $type && function_exists( 'putRevSlider' ) ) { // revolution slider
	putRevSlider( get_field( 'revolution_slider_alias' ) );
}

?>

<div class="container" role="main">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	?>
</div>

<?php get_footer(); ?>