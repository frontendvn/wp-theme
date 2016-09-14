<?php

/*
 * CargoPress Home Page Template for Visual Composer
 */

add_action( 'vc_load_default_templates_action','cargopress_home_page_template_for_vc' );

function cargopress_home_page_template_for_vc() {
	$data               = array();
	$data['name']       = _x( 'CargoPress: Front Page', 'backend' , 'cargopress-pt' );
	$data['weight']     = 0;
	$data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/assets/images/pt.svg' );
	$data['custom_class'] = 'cargopress_home_page_template_for_vc_custom_template';
	$data['content']    = <<<CONTENT
		[vc_row el_class="jumbotron-overlap" css=".vc_custom_1437564890651{margin-bottom: 81px !important;}"][vc_column width="1/4"][vc_column_text el_class="featured-widget" css=".vc_custom_1437564468445{padding-top: 30px !important;padding-right: 30px !important;padding-bottom: 30px !important;padding-left: 30px !important;}"]
<h3>HELLO THERE AND WELCOME</h3>
Our warehousing services are known nationwide to be one of the most reliable, safe and affordable, because we take pride in delivering the best of warehousing services, at the most reasonable prices. Our own warehouses, as well as our partner’s warehouses are located at strategic locations to ensure that there is no additional cost.

<a class="read-more" href="#">MORE ABOUT US</a>[/vc_column_text][/vc_column][vc_column width="1/4"][pt_vc_featured_page page="99" layout="block" read_more_text="Read more"][/vc_column][vc_column width="1/4"][pt_vc_featured_page page="95" layout="block" read_more_text="Read more"][/vc_column][vc_column width="1/4"][pt_vc_featured_page page="78" layout="block" read_more_text="Read more"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][vc_column_text]
<div class="widget-title--big">
<h3 class="widget-title"><span class="widget-title__inline">OUR SERVICES</span></h3>
</div>
[/vc_column_text][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-dropbox" title="PACKAGING AND STORAGE" text="We can package and store your things." link="#" new_tab=""][/vc_column][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-truck" title="CARGO" text="Let us transport your things from point A to point B fast and securely. " link="#" new_tab=""][/vc_column][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-globe" title="WORLDWIDE TRANSPORT" text="We can transport your things anywhere in the world." link="#" new_tab=""][/vc_column][/vc_row][vc_row css=".vc_custom_1437561700462{margin-bottom: 80px !important;}"][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-archive" title="WAREHOUSING" text="We have top notch security and loads of space. Store your stuff at our warehouse." link="#" new_tab=""][/vc_column][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-home" title="DOOR-TO-DOOR DELIVERY" text="Do you need something delivered? We are what you are looking for! " link="#" new_tab=""][/vc_column][vc_column width="1/3"][pt_vc_icon_box icon="fa fa-road" title="GROUND TRANSPORT" text="Transport your things with our super moving vans." link="#" new_tab=""][/vc_column][/vc_row][vc_row css=".vc_custom_1437481741000{margin-bottom: 0px !important;background-color: #f5f5f5 !important;}" full_width="stretch_row"][vc_column width="1/1"][pt_vc_call_to_action title="Not sure which solution fits your business needs?"][button href="http://themeforest.net/item/cargopress-logistic-warehouse-transport-wp/11601531?ref=proteusthemes" target="_blank"]CONTACT OUR SALES TEAM[/button][/pt_vc_call_to_action][/vc_column][/vc_row][vc_row css=".vc_custom_1437481771824{margin-top: 0px !important;margin-bottom: 0px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/blured.jpg) !important;}" full_width="stretch_row"][vc_column width="1/3"][pt_vc_latest_news layout="block" order_number="1" order_number_from="1" order_number_to="3" show_more_link=""][/vc_column][vc_column width="1/3"][pt_vc_latest_news layout="block" order_number="2" order_number_from="1" order_number_to="3" show_more_link=""][/vc_column][vc_column width="1/3"][pt_vc_latest_news layout="inline" order_number="1" order_number_from="3" order_number_to="5" show_more_link="true"][/vc_column][/vc_row][vc_row css=".vc_custom_1437562720866{margin-bottom: 60px !important;padding-top: 60px !important;padding-bottom: 73px !important;background-image: url(http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/core_values_bg.jpg) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" full_width="stretch_row"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][vc_column_text]
<h3 style="text-align: center; font-size: 44px;">OUR CORE VALUES</h3>
<p style="text-align: center;"><span style="color: #4ab9cf;"><strong>WRITTEN BY CARGOPRESS CEO</strong></span></p>


<hr class="hr-quote" />
<p style="text-align: center;">Core values are the fundamental beliefs of a person or organization. The core values are the guiding principles that t dictate behavior and action. Core values can help people to know what is right from wrong, they can help companies to determine if they are on the right path and fulfilling their business goals; and they create an unwavering and unchanging guide. There are many different types of core values and many different examples of core values depending upon the context.</p>
<p style="text-align: center;"><a href="http://sandbox.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/signature.png"><img class=" size-full wp-image-344 aligncenter" src="http://sandbox.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/signature.png" alt="signature" width="232" height="58" /></a></p>

[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row css=".vc_custom_1437563644549{margin-bottom: 60px !important;}"][vc_column width="1/2"][vc_column_text]
<div class="widget-title--big">
<h3 class="widget-title"><span class="widget-title__inline">ABOUT US</span></h3>
</div>
But i must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete count of the system, and expound the actual teaings of the great explorer idea announcing. But i must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete count of the system, and expound the actual teaings of the great explorer idea announcing.

But i must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and i will give you a complete count of the system, and expound the actual teaings of the great explorer idea announcing.

<a class="read-more" href="#">READ MORE</a>[/vc_column_text][/vc_column][vc_column width="1/2"][vc_column_text el_class="featured-widget"]
<h3>REQUEST A QUICK QUOTE</h3>
But i must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete count.

&nbsp;

[contact-form-7 id="313" title="Request a Quick Quote"][/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1437563732625{margin-bottom: 77px !important;}"][vc_column width="1/2"][vc_column_text]
<div class="widget-title--big">
<h3 class="widget-title"><span class="widget-title__inline">FLEET GALLERY</span></h3>
</div>
Add a WordPress gallery here...[/vc_column_text][/vc_column][vc_column width="1/2"][vc_column_text]
<div class="widget-title--big">
<h3 class="widget-title"><span class="widget-title__inline">FAQ</span></h3>
</div>
<h4></h4>
<h4><a class="dark-link" href="http://sandbox.proteusthemes.com/cargopress/frequently-asked-questions/" target="_blank">HOW MANY TIMES DO I HAVE TO TELL YOU A FEW DIFFERENT WAYS?</a></h4>

<hr />

<h4><a class="dark-link" href="http://sandbox.proteusthemes.com/cargopress/frequently-asked-questions/" target="_blank">WHAT IS DO I HAVE TO TELL YOU A FEW LOREM?</a></h4>

<hr />

<h4><a class="dark-link" href="http://sandbox.proteusthemes.com/cargopress/frequently-asked-questions/" target="_blank">HOW MANY DO I HAVE TO TELL YOU HAVE A?</a></h4>

<hr />

<a class="read-more" href="http://sandbox.proteusthemes.com/cargopress/frequently-asked-questions">MORE QUESTIONS</a>[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1437564044777{margin-top: 60px !important;margin-bottom: 0px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #eeeeee !important;}" full_width="stretch_row"][vc_column width="1/1"][pt_vc_container_testimonials title="TESTIMONIALS" autocycle="no" interval="5000"][pt_vc_testimonial quote="But I must explain to you how all this mistakn idea of denouncing pleasure and praising pain was born and I will give you a complete of the system, and expound the actual teaings of the great explorer idea." author="Frank Martin" author_description="Transporter"][pt_vc_testimonial quote="But I must explain to you how all this mistakn idea of denouncing pleasure and praising pain was born and I will give you a complete of the system, and expound the actual teaings of the great explorer idea." author="Frank Martin" author_description="Transporter"][pt_vc_testimonial quote="But I must explain to you how all this mistakn idea of denouncing pleasure and praising pain was born and I will give you a complete of the system, and expound the actual teaings of the great explorer idea." author="Frank Martin" author_description="Transporter"][pt_vc_testimonial quote="But I must explain to you how all this mistakn idea of denouncing pleasure and praising pain was born and I will give you a complete of the system, and expound the actual teaings of the great explorer idea." author="Frank Martin" author_description="Transporter"][/pt_vc_container_testimonials][/vc_column][/vc_row][vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1437564199684{margin-bottom: 80px !important;}"][vc_column width="1/1"][pt_vc_container_google_map lat_long="51.422144,-3.278289" zoom="7" type="roadmap" style="CargoPress" height="380"][pt_vc_location title="London" locationlatlng="51.507331,-0.127668" custompinimage="http://sandbox.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/pin.png"][/pt_vc_container_google_map][/vc_column][/vc_row][vc_row css=".vc_custom_1437564275785{margin-bottom: 90px !important;}"][vc_column width="1/1"][vc_column_text]
<div class="widget-title--big">
<h3 class="widget-title"><span class="widget-title__inline">OUR PARTNERS</span></h3>
</div>
<div class="logo-panel">
<div class="row">
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_1.png" alt="Client" /></div>
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_2.png" alt="Client" /></div>
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_3.png" alt="Client" /></div>
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_4.png" alt="Client" /></div>
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_5.png" alt="Client" /></div>
<div class="col-xs-12  col-sm-2"><img src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/logo_6.png" alt="Client" /></div>
</div>
</div>
[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1437551173198{margin-top: 80px !important;margin-bottom: 0px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-image: url(http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/counter_bg.jpg) !important;}" full_width="stretch_row"][vc_column width="1/1"][pt_vc_container_number_counter speed="1000"][pt_vc_counter icon="fa fa-building-o" title="Offices Worldwide" number="15"][pt_vc_counter icon="fa fa-users" title="Hardworking People" number="97"][pt_vc_counter icon="fa fa-globe" title="Countries Covered" number="12"][pt_vc_counter icon="fa fa-users" title="Years of Experiences" number="25"][/pt_vc_container_number_counter][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates( $data );
}