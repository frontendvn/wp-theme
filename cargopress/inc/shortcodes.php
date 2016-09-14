<?php
/**
 * Shortcodes for CargoPress WP theme defined
 *
 * @package CargoPress
 */


/**
 * Shortcode for Font Awesome
 * @param  array $atts
 * @return string HTML
 */
if ( ! function_exists( 'cargopress_fa_shortcode' ) ) {
	function cargopress_fa_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'icon'   => 'fa-home',
			'style'  => '',
			'href'   => '',
			'target' => '_self',
		), $atts ) );

		if ( empty( $href ) ) {
			return '<span class="icon-container' . ( empty( $style ) ? '' : '  icon-container--' ) . esc_attr( strtolower( $style ) ) . '"><span class="fa ' . esc_attr( strtolower( $icon ) ) . '"></span></span>';
		}
		else if ( 'fa-envelope' === $icon || 'fa-envelope-o' === $icon || 'fa-envelope-square' === $icon ) {
			return '<a class="icon-container' . ( empty( $style ) ? '' : '  icon-container--' ) . esc_attr( strtolower( $style ) ) . '" href="mailto:' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '"><span class="fa ' . esc_attr( strtolower( $icon ) ) . '"></span></a>';
		}
		else {
			return '<a class="icon-container' . ( empty( $style ) ? '' : '  icon-container--' ) . esc_attr( strtolower( $style ) ) . '" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '"><span class="fa ' . esc_attr( strtolower( $icon ) ) . '"></span></a>';
		}
	}
	add_shortcode( 'fa', 'cargopress_fa_shortcode' );
}


/**
 * Shortcode for Buttons
 * @param  array $atts
 * @return string HTML
 */
if ( ! function_exists( 'cargopress_button_shortcode' ) ) {
	function cargopress_button_shortcode( $atts, $content = '' ) {
		extract( shortcode_atts( array(
			'style'   => 'primary',
			'href'    => '#',
			'target'  => '_self',
			'corners' => '',
			'fa'      => null,
			'fullwidth'   => false,
		), $atts ) );

		return '<a class="btn  ' . ( 'rounded' == $corners  ? 'btn-rounded' : '' ) . '  btn-' . esc_attr( strtolower( $style ) ) . ( 'true' == $fullwidth  ? '  fullwidth' : '' ) . '" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '">' . ( isset( $fa )  ? '<i class="fa ' . $fa . '"></i> ' : '') . $content . '</a>';
	}
	add_shortcode( 'button', 'cargopress_button_shortcode' );
}