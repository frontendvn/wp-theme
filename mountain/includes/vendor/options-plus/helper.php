<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */

// Prevent direct access to this file
defined( 'ABSPATH' ) or die();

/**
 * Return the version number of this library
 * 
 * @return  string
 */
function op_version() {
	return '1.0.0';
}



/**
 * Return the path to options-plus directory
 * 
 * @return  string
 */
function op_directory_path() {
	static $path;

	if ( empty( $path ) )
		$path = apply_filters( 'op/directory_path', __DIR__ );

	return $path;
}



/**
 * Return the URI that pointed to options-plus directory
 * 
 * @return  string
 */
function op_directory_uri() {
	static $uri;

	if ( empty( $uri ) )
		$uri = apply_filters( 'op/directory_uri', '' );

	return $uri;
}



/**
 * Retrieve specific option value that determined by
 * name
 * 
 * @param   string  $name     Option name
 * @param   mixed   $default  Default value
 * 
 * @return  mixed
 */
function op_option( $name, $default = null ) {
	global $_op_options;

	if ( empty( $_op_options ) ) {
		$_op_options = apply_filters( 'op/prepare_options', get_theme_mods() );
	}

	if ( ! isset( $_op_options[$name] ) )
		return $default;

	return apply_filters( "op_option_{$name}", $_op_options[$name] );
}



/**
 * Retrieve option from specific post
 * 
 * @param   string  $name     Option name
 * @param   mixed   $default  Default value
 * @param   int     $post_id  Post ID
 * 
 * @return  mixed
 */
function op_post_option( $name, $default = null, $post_id = null ) {
	global $_op_post_options;

	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	if ( ! is_array( $_op_post_options ) )
		$_op_post_options = array();

	if ( ! isset( $_op_post_options[$post_id] ) )
		$_op_post_options[$post_id] = apply_filters( 'op/post_options',
			get_post_meta( $post_id, '_post_options', true ), $post_id );

	return isset( $_op_post_options[$post_id][$name] )
		? $_op_post_options[$post_id][$name]
		: $default;
}



/**
 * Return currently post type
 * 
 * @return  strings
 */
function op_current_post_type() {
	global $post, $typenow, $current_screen;
	
	//we have a post so we can just get the post type from that
	if ( true == isset( $post ) && true == isset( $post->post_type ) )
		return $post->post_type;

	//check the global $typenow - set in admin.php
	elseif ( true == isset( $typenow ) )
		return $typenow;

	//check the global $current_screen object - set in sceen.php
	elseif ( true == isset( $current_screen ) && true == isset( $current_screen->post_type ) )
		return $current_screen->post_type;

	//lastly check the post_type querystring
	elseif ( true == isset( $_REQUEST['post_type'] ) )
		return sanitize_key( $_REQUEST['post_type'] );
	
	//we do not know the post type!
	return null;
}


/**
 * Shortcut function to create new instance for attributes class
 * 
 * @param   array   $attributes  Existed attributes
 * @param   string  $filter      Filter name to be applied
 * 
 * @return  \OptionsPlus\Markup\Attributes
 */
function op_attributes( $attributes = array(), $filter = null ) {
	return new \OptionsPlus\Markup\Attributes( $attributes, $filter );
}


/**
 * Shortcut function to create new instance of class \OptionsPlus\Markup\Classes
 * 
 * @param   array   $classes  Existed classes
 * @param   string  $filter   Filter name to be applied
 * 
 * @return  \OptionsPlus\Markup\Classes
 */
function op_classes( $classes = array(), $filter = null ) {
	return new \OptionsPlus\Markup\Classes( $classes, $filter );
}


/**
 * Helper function to generate dynamic css code from an array
 *
 * @param   array  $styles  Styles in array format that will be generated
 * @return  string
 */
function op_generate_styles( $styles ) {
	if ( ! is_array( $styles ) )
		return;

	$buffer = array();

	foreach( $styles as $selector => $params ) {
		$buffer[] = sprintf( '%s {', $selector );

		if ( is_array( $params ) )
			foreach ( $params as $name => $value )
				$buffer[] = sprintf( "\t%s: %s;", $name, $value );
		else
			$buffer[] = $params;

		$buffer[] = '}';
	}

	return implode( "\r\n", $buffer );
}


/**
 * Generate custom styles for background options
 * 
 * @param   array  $patterns            Available background patterns
 * @param   array  $background_options  Background options
 * 
 * @return  array
 */
function op_background_styles( $patterns, $background_options ) {
	$styles = array( 'background-color' => $background_options['color'] );

	if ( $background_options['type'] == 'patterns' ) {
		if ( isset( $patterns[$background_options['pattern']] ) ) {
			$styles['background-image'] = sprintf( 'url(%s)', $patterns[$background_options['pattern']] );
			$styles['background-repeat'] = 'repeat';
		}
	}
	elseif ( $background_options['type'] == 'custom' ) {
		if ( ! empty( $background_options['image'] ) ) {
			$styles['background-image'] = sprintf( 'url(%s)', $background_options['image'] );
			$styles['background-position'] = str_replace( '-', ' ', $background_options['position'] );
			$styles['background-repeat'] = $background_options['repeat'];

			if ( $background_options['style'] == 'fixed' ) {
				$styles['background-attachment'] = 'fixed';
				$styles['background-size'] = '100% 100%';
			}
			elseif ( $background_options['style'] == 'scroll' ) {
				$styles['background-attachment'] = 'scroll';
			}
			else {
				$styles['background-size'] = 'cover';
			}
		}
	}

	return $styles;
}


/**
 * Return the CSS code for typography options
 * 
 * @param   array  $typography_options  Typography options
 * @return  array
 */
function op_typography_styles( $typography_options, $unit = 'px' ) {
	global $_options_plus_fonts;

	$styles = array();
	$system_font_weights = array(
		400 => 'normal',
		700 => 'bold'
	);

	if ( isset( $typography_options['color'] ) )
		$styles['color'] = $typography_options['color'];

	if ( isset( $typography_options['size'] ) )
		$styles['font-size'] = $typography_options['size'] . $unit;

	if ( isset( $typography_options['family'] ) ) {
		if ( isset( $typography_options['style'] ) ) {
			$font_weight = intval( $typography_options['style'] );
			$font_style   = strpos( $typography_options['style'], 'italic' ) !== false ? 'italic' : 'normal';
		}

		$is_custom_font = isset( $_options_plus_fonts['custom'][$typography_options['family']] );
		$is_system_font = isset( $_options_plus_fonts['system'][$typography_options['family']] );
		$is_google_font = isset( $_options_plus_fonts['google'][$typography_options['family']] );
		
		if ( $is_custom_font ) {
			wp_enqueue_style( "font-{$typography_options['family']}", $_options_plus_fonts['custom'][$typography_options['family']]['uri'] );
			
			$font = $_options_plus_fonts['custom'][$typography_options['family']];
			$font_weight = $system_font_weights[$font_weight];
		}
		elseif ( $is_system_font ) {
			$font = $_options_plus_fonts['system'][$typography_options['family']];
			$font_weight = $system_font_weights[$font_weight];
		}
		elseif ( $is_google_font ) {
			$font = $_options_plus_fonts['google'][$typography_options['family']];
		}

		$styles['font-family'] = $font['family'];
		$styles['font-weight'] = $font_weight;
		$styles['font-style']  = $font_style;
	}

	return $styles;
}



/**
 * Return the list of social icons that available in
 * options plus library
 * 
 * @return  array
 */
function op_available_social_icons() {
	$icons = apply_filters( 'op_available_social_icons', array(
		'twitter'        => array( 'icon_class' => 'fa-twitter', 'title' => 'Twitter' ),
		'facebook'       => array( 'icon_class' => 'fa-facebook', 'title' => 'Facebook' ),
		'google-plus'    => array( 'icon_class' => 'fa-google-plus', 'title' => 'Google+' ),
		'pinterest'      => array( 'icon_class' => 'fa-pinterest', 'title' => 'Pinterest' ),
		'instagram'      => array( 'icon_class' => 'fa-instagram', 'title' => 'Instagram' ),
		'youtube'        => array( 'icon_class' => 'fa-youtube-play', 'title' => 'Youtube' ),
		'vimeo'          => array( 'icon_class' => 'fa-vimeo-square', 'title' => 'Vimeo' ),
		'linkedin'       => array( 'icon_class' => 'fa-linkedin', 'title' => 'LinkedIn' ),
		'behance'        => array( 'icon_class' => 'fa-behance', 'title' => 'Behance' ),
		'bitcoin'        => array( 'icon_class' => 'fa-bitcoin', 'title' => 'Bitcoin' ),
		'bitbucket'      => array( 'icon_class' => 'fa-bitbucket', 'title' => 'BitBucket' ),
		'codepen'        => array( 'icon_class' => 'fa-codepen', 'title' => 'Codepen' ),
		'delicious'      => array( 'icon_class' => 'fa-delicious', 'title' => 'Delicious' ),
		'deviantart'     => array( 'icon_class' => 'fa-deviantart', 'title' => 'DeviantArt' ),
		'digg'           => array( 'icon_class' => 'fa-digg', 'title' => 'Digg' ),
		'dribbble'       => array( 'icon_class' => 'fa-dribbble', 'title' => 'Dribbble' ),
		'flickr'         => array( 'icon_class' => 'fa-flickr', 'title' => 'Flickr' ),
		'foursquare'     => array( 'icon_class' => 'fa-foursquare', 'title' => 'Foursquare' ),
		'github'         => array( 'icon_class' => 'fa-github-alt', 'title' => 'Github' ),
		'jsfiddle'       => array( 'icon_class' => 'fa-jsfiddle', 'title' => 'JSFiddle' ),
		'reddit'         => array( 'icon_class' => 'fa-reddit', 'title' => 'Reddit' ),
		'skype'          => array( 'icon_class' => 'fa-skype', 'title' => 'Skype' ),
		'slack'          => array( 'icon_class' => 'fa-slack', 'title' => 'Slack' ),
		'soundcloud'     => array( 'icon_class' => 'fa-soundcloud', 'title' => 'SoundCloud' ),
		'spotify'        => array( 'icon_class' => 'fa-spotify', 'title' => 'Spotify' ),
		'stack-exchange' => array( 'icon_class' => 'fa-stack-exchange', 'title' => 'Stack Exchange' ),
		'stack-overflow' => array( 'icon_class' => 'fa-stack-overflow', 'title' => 'Stach Overflow' ),
		'steam'          => array( 'icon_class' => 'fa-steam', 'title' => 'Steam' ),
		'stumbleupon'    => array( 'icon_class' => 'fa-stumbleupon', 'title' => 'Stumbleupon' ),
		'tumblr'         => array( 'icon_class' => 'fa-tumblr', 'title' => 'Tumblr' ),
		'rss'            => array( 'icon_class' => 'fa-rss', 'title' => 'RSS' )
	) );

	$icons['__icons_ordering__'] = array_keys( $icons );

	return $icons;
}

