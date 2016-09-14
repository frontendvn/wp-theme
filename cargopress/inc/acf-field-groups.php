<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_front-page-slider',
		'title' => 'Front page slider',
		'fields' => array (
			array (
				'key' => 'field_5548717a1b3e4',
				'label' => 'Slider content',
				'name' => 'slider_content',
				'type' => 'radio',
				'instructions' => 'Choose \'Slider with captions\' to add title and text over the slides or choose \'Slider with links\' to apply links to slides.',
				'required' => 1,
				'choices' => array (
					'caption' => 'Slider with captions',
					'link' => 'Slider with links',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'caption',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_554871d21b3e5',
				'label' => 'Slides',
				'name' => 'slides',
				'type' => 'repeater',
				'instructions' => 'You can add multiple slides to this page.',
				'sub_fields' => array (
					array (
						'key' => 'field_554871fa1b3e6',
						'label' => 'Slide image',
						'name' => 'slide_image',
						'type' => 'image',
						'required' => 1,
						'column_width' => '',
						'save_format' => 'id',
						'preview_size' => 'full',
						'library' => 'all',
					),
					array (
						'key' => 'field_554872321b3e7',
						'label' => 'Slide title',
						'name' => 'slide_title',
						'type' => 'text',
						'required' => 1,
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5548717a1b3e4',
									'operator' => '==',
									'value' => 'caption',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5548743d56847',
						'label' => 'Slide text',
						'name' => 'slide_text',
						'type' => 'wysiwyg',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5548717a1b3e4',
									'operator' => '==',
									'value' => 'caption',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'basic',
						'media_upload' => 'no',
					),
					array (
						'key' => 'field_5548728d88d0a',
						'label' => 'Slide link',
						'name' => 'slide_link',
						'type' => 'text',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5548717a1b3e4',
									'operator' => '==',
									'value' => 'link',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_554872b588d0b',
						'label' => 'Slide open link in new window/tab',
						'name' => 'slide_open_link_in_new_window',
						'type' => 'true_false',
						'instructions' => 'Open link in new window/tab',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5548717a1b3e4',
									'operator' => '==',
									'value' => 'link',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => '',
						'message' => '',
						'default_value' => 1,
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Another Slide',
			),
			array (
				'key' => 'field_55487307bdff8',
				'label' => 'Auto cycle',
				'name' => 'auto_cycle',
				'type' => 'true_false',
				'instructions' => 'Automatically cycle over the slides on the page load.',
				'message' => 'Automatically cycle the slides',
				'default_value' => 1,
			),
			array (
				'key' => 'field_55487335bdff9',
				'label' => 'Cycle interval',
				'name' => 'cycle_interval',
				'type' => 'number',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55487307bdff8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 5000,
				'placeholder' => '',
				'prepend' => '',
				'append' => 'ms',
				'min' => 0,
				'max' => '',
				'step' => 1000,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-front-page-slider.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_main-title-area-background',
		'title' => 'Main title area background',
		'fields' => array (
			array (
				'key' => 'field_5538c999ec7c2',
				'label' => 'Background image',
				'name' => 'background_image',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5538c9daec7c3',
				'label' => 'Background image horizontal position',
				'name' => 'background_image_horizontal_position',
				'type' => 'radio',
				'choices' => array (
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'center',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5538ca0cec7c4',
				'label' => 'Background image vertical position',
				'name' => 'background_image_vertical_position',
				'type' => 'radio',
				'choices' => array (
					'top' => 'Top',
					'center' => 'Center',
					'bottom' => 'Bottom',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'center',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5538ca44ec7c5',
				'label' => 'Background image repeat',
				'name' => 'background_image_repeat',
				'type' => 'radio',
				'choices' => array (
					'no-repeat' => 'No Repeat',
					'repeat' => 'Tile',
					'repeat-x' => 'Tile Horizontally',
					'repeat-y' => 'Tile Vertically',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'repeat',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5538ca6cec7c6',
				'label' => 'Background image attachment',
				'name' => 'background_image_attachment',
				'type' => 'radio',
				'choices' => array (
					'scroll' => 'Scroll',
					'fixed' => 'Fixed',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'scroll',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5538caa9ec7c7',
				'label' => 'Background color',
				'name' => 'background_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_page-slider',
		'title' => 'Page Slider',
		'fields' => array (
			array (
				'key' => 'field_555b2e9360dfb',
				'label' => 'Slider Type',
				'name' => 'slider_type',
				'type' => 'radio',
				'required' => 1,
				'choices' => array (
					'layer' => 'LayerSlider',
					'revolution' => 'Revolution Slider',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_555b2edc60dfc',
				'label' => 'LayerSlider ID',
				'name' => 'layerslider_id',
				'type' => 'number',
				'instructions' => 'LayerSlider can be used as alternative slider and doesn\'t come with the theme for free. You can buy it <a href="http://codecanyon.net/item/layerslider-responsive-wordpress-slider-plugin-/1362246?ref=ProteusThemes" target="_blank">here</a>. Paste the ID of the slider you created in the plugin to this box (only ID, not the whole shortcode).',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_555b2e9360dfb',
							'operator' => '==',
							'value' => 'layer',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => 1,
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_555b2f2660dfd',
				'label' => 'Revolution Slider Alias',
				'name' => 'revolution_slider_alias',
				'type' => 'text',
				'instructions' => 'Slider Revolution can be used as alternative slider and doesn\'t come with the theme for free. You can buy it <a href="http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380?ref=ProteusThemes" target="_blank">here</a>. Paste the alias of the slider you created in the plugin to this box (only <a href="https://www.diigo.com/item/image/3rli1/s9bj?size=o" target="_blank">alias</a>, not the whole shortcode).',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_555b2e9360dfb',
							'operator' => '==',
							'value' => 'revolution',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => 'main-slider',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-front-page-slider-alt.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_position-of-the-sidebar',
		'title' => 'Position of the Sidebar',
		'fields' => array (
			array (
				'key' => 'field_5534bcc459d58',
				'label' => '',
				'name' => 'sidebar',
				'type' => 'radio',
				'instructions' => 'Position the sidebar for this particular page: left, right or do not display it at all.',
				'choices' => array (
					'right' => 'Right',
					'left' => 'Left',
					'none' => 'No Sidebar',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'right',
				'layout' => 'horizontal',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_subtitle',
		'title' => 'Subtitle',
		'fields' => array (
			array (
				'key' => 'field_5534998130ef7',
				'label' => '',
				'name' => 'subtitle',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'Subtitle',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
