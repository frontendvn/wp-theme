<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

$site_name     = get_bloginfo( 'name' );
$site_desc     = get_bloginfo( 'description' );
$home_url      = home_url( '/' );
$brand_classes = array( 'brand' );

if ( op_option( 'logo_image' ) == true ) {
	$brand_classes[] = 'has-logo';
	$logo_attrs  = array();
	$logo_attrs['alt'] = $site_name;

	$site_name = sprintf( '<img src="%s" %s>',
		esc_url( op_option( 'logo_src' ) ),
		op_attributes( $logo_attrs )
	);
}

if ( op_option( 'show_tagline', false ) ) {
	$brand_classes[] = 'has-tagline';
}

// Open .brand
printf( '<div%s>', op_attributes( array( 'id' => 'site-logo', 'class' => $brand_classes ), 'mountain_brand_attrs' ) );

	// Open .brand > .logo
	printf( '<h1%s>', op_attributes( array( 'class' => 'logo', 'itemprop' => 'headline' ) ) );

		// Display the logo
		printf( '<a href="%s">%s</a>', esc_url( $home_url ), $site_name );

	// Close .brand > .logo
	print( '</h1>' );

	// Open .brand > .tagline
	if ( op_option( 'show_tagline', false ) )
		printf( '<p class="tagline" itemprop="description">%s</p>', esc_html( $site_desc ) );

// Close .brand
print( '</div>' );
