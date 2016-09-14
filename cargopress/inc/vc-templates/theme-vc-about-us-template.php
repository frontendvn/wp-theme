<?php

/*
 * CargoPress About Us page Template for Visual Composer
 */

add_action( 'vc_load_default_templates_action','cargopress_about_us_template_for_vc' );

function cargopress_about_us_template_for_vc() {
	$data               = array();
	$data['name']       = _x( 'CargoPress: About Us', 'backend' , 'cargopress-pt' );
	$data['weight']     = 0;
	$data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/assets/images/pt.svg' );
	$data['custom_class'] = 'cargopress_about_us_template_for_vc_custom_template';
	$data['content']    = <<<CONTENT
		[vc_row css=".vc_custom_1459336051078{margin-bottom: 86px !important;}"][vc_column width="1/2"][vc_column_text]We take pride in being regarded as one of the most reliable and affordable logistic and warehousing service providers in the country. As a third party logistic service provider, we excel at a range of logistic services, which includes trucking services, warehousing services, logistic services, and a range of other ancillary services. We have years of experience in the business of logistics, warehousing, distribution, trucking and supply chain management services, and aim to provide our clients with convenience, reliability and affordability through our premium logistic services.

		Our team of experts at all levels of our services have years of experience backing them, which adds the credibility of an expert workforce. This also helps us in cutting down response time, and providing punctual delivery and services at all times, whether it is trucking service or warehousing services. Our goal is to make a positive difference in your business through our services, and build long term relationship with you. Our commitment to our clients can be seen by the amount of emphasis we lay on team work, customer support services and making technological upgrades in our logistic process and equipment from time to time.

		Our experience in all the fields we serve in, and the range of services we provide, makes us one of the most comprehensive logistic service providers in the nation. And, with the help of continuous support and trust of our clients, we aim to stay at the top of the game, and humbly so. Our sophisticated systems, neatly designed logistic process, state of the art logistic tools and equipment, most advanced carriers, custom tailored services, and dedication to keep the costs low for end users, help us to provide logistic solution that aligns well with our clients’ requirements. We welcome you to our site, and request you to consult with our logistic experts for your logistic needs, and rest assured of getting done.

		We have years of experience in the business of logistics, warehousing, distribution, trucking and supply chain management services, and aim to provide our clients with convenience, reliability and affordability through our premium logistic services.[/vc_column_text][/vc_column][vc_column width="1/2"][vc_column_text]<a href="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/5.jpg"><img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/5.jpg" alt="5" width="848" height="480" /></a>

		<a href="http://xml-io.demo.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/34.jpg"><img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/04/34.jpg" alt="34" width="848" height="480" /></a>[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1459336111399{margin-bottom: 64px !important;}"][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_5.jpg" alt="about-us_5" width="848" height="480" />
		<h3 style="text-align: left;">GEORGE QUICK</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">CEO AND BOARD MEMBER</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_1.jpg" alt="about-us_1" width="848" height="480" />
		<h3 style="text-align: left;">MARGARET BUTLER</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">COO AND CONSULTANT</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_3.jpg" alt="about-us_3" width="848" height="480" />
		<h3 style="text-align: left;">JEREMY CONTRERAS</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">HUMAN RESOURCES</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1459336129357{margin-bottom: 0px !important;}"][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full wp-image-241" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_4.jpg" alt="about-us_4" width="848" height="480" />
		<h3 style="text-align: left;">MARRY COOPER</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">CHEF ACCOUNTANT</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_2.jpg" alt="about-us_2" width="848" height="480" />
		<h3 style="text-align: left;">BRUCE WOOD</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">CHIEF MECHANIC OPERATOR</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][vc_column width="1/3"][vc_column_text]<img class="alignnone size-full" src="http://xml-io.proteusthemes.com/cargopress/wp-content/uploads/sites/24/2015/05/about-us_6.jpg" alt="about-us_6" width="848" height="480" />
		<h3 style="text-align: left;">REBECCA JACOBS</h3>
		<h4 style="text-align: left;"><span style="color: #bbbbbb;">BOARD MEMBER</span></h4>
		<p style="text-align: left;">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so sense.</p>
		[/vc_column_text][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates( $data );
}