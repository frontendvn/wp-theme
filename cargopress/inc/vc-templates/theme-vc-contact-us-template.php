<?php

/*
 * CargoPress Contact Us page Template for Visual Composer
 */

add_action( 'vc_load_default_templates_action','cargopress_contact_us_template_for_vc' );

function cargopress_contact_us_template_for_vc() {
	$data               = array();
	$data['name']       = _x( 'CargoPress: Contact Us', 'backend' , 'cargopress-pt' );
	$data['weight']     = 0;
	$data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/assets/images/pt.svg' );
	$data['custom_class'] = 'cargopress_contact_us_template_for_vc_custom_template';
	$data['content']    = <<<CONTENT
		[vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1459336553377{margin-top: -60px !important;}"][vc_column][pt_vc_container_google_map zoom="7" height="380"][pt_vc_location custompinimage="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/pin.png"][/pt_vc_container_google_map][/vc_column][/vc_row][vc_row css=".vc_custom_1459337149136{margin-bottom: 0px !important;}"][vc_column width="1/4"][vc_column_text el_class="featured-widget"]
		<h3 class="widget-title"><span class="widget-title__inline">OLD FASHIONED CONTACT</span></h3>
		<strong>CargoPress, Itd.</strong>
		227 Marion Street
		Columbia, SC 29201

		1-888-123-4567
		1-888-123-4568
		<a href="mailto:info@cargopress.com">info@cargopress.com</a>[/vc_column_text][pt_vc_opening_time days_hours="opened|8:00|16:00
		opened|11:00|19:00
		opened|8:00|16:00
		opened|8:00|16:00
		opened|11:00|19:00
		opened|8:00|16:00
		closed" title="OPENING TIME"][/vc_column][vc_column width="3/4"][vc_column_text]
		<h3 class="widget-title"><span class="widget-title__inline">SEND US AN EMAIL, OR THREE</span></h3>
		But i must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and i will give you a complete count of the system, and expound the actual things of the great explorer idea announcing.

		[contact-form-7 id="122" title="Contact Us"][/vc_column_text][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates( $data );
}