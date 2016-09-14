<?php

/*
 * CargoPress Our Services page Template for Visual Composer
 */

add_action( 'vc_load_default_templates_action','cargopress_our_services_template_for_vc' );

function cargopress_our_services_template_for_vc() {
	$data               = array();
	$data['name']       = _x( 'CargoPress: Our Services', 'backend' , 'cargopress-pt' );
	$data['weight']     = 0;
	$data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/assets/images/pt.svg' );
	$data['custom_class'] = 'cargopress_our_services_template_for_vc_custom_template';
	$data['content']    = <<<CONTENT
		[vc_row][vc_column width="1/3"][pt_vc_featured_page page="101"][/vc_column][vc_column width="1/3"][pt_vc_featured_page page="95"][/vc_column][vc_column width="1/3"][pt_vc_featured_page page="93"][/vc_column][/vc_row][vc_row css=".vc_custom_1459335023924{margin-bottom: 0px !important;}"][vc_column width="1/3"][pt_vc_featured_page page="97"][/vc_column][vc_column width="1/3"][pt_vc_featured_page page="99"][/vc_column][vc_column width="1/3"][pt_vc_featured_page page="78"][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates( $data );
}