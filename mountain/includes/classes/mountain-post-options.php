<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

/**
 * @package  Mountain
 * @author   Binh Pham Thanh <binhpham@linethemes.com>
 */
class Mountain_PostOptions extends Mountain_Base
{
	protected function __construct() {
		add_action( 'admin_init', array( $this, 'register' ) );
	}

	/**
	 * Register post options controls
	 * 
	 * @return  void
	 */
	public function register() {
		$options = array();
		$options['images_heading'] = array(
			'type'        => 'heading',
			'title'       => __( 'Featured Gallery', 'mountain' ),
			'description' => __( 'Add images to create a slider for this post, post format "Gallery" must be checked.', 'mountain' ),
			'section'     => 'all'
		);

		$options['post_images'] = array(
			'type'        => 'media-list',
			'section'     => 'all',
			'media_types' => array( 'image' ),
			'default'     => array()
		);

		$options['video_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'Video URL', 'mountain' ),
			'description' => __( 'Add an URL that linked to a video, it can be Youtube, Vimeo, ... The added video will be displayed on top of the page.', 'mountain' )
		);

		$options['post_video'] = array(
			'type'    => 'media-input',
			'section' => 'all',
			'library' => 'video',
			'default' => ''
		);

		$options['audio_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'Audio URL', 'mountain' ),
			'description' => __( 'This field will be applied when post format "Audio" is checked. A audio player will be displayed on top of the post.', 'mountain' )
		);

		$options['post_audio'] = array(
			'type'    => 'media-input',
			'section' => 'all',
			'library' => 'audio',
			'default' => ''
		);

		$options['link_heading'] = array(
			'type'        => 'heading',
			'section'     => 'all',
			'title'       => __( 'External Link', 'mountain' ),
			'description' => __( 'When post format "Link" is selected you need provide a link to this field.', 'mountain' )
		);

		$options['post_link'] = array(
			'type'    => 'text',
			'section' => 'all',
			'default' => 'http://'
		);

		new \OptionsPlus\Metabox\Properties( 'post-options', array(
			'label'       => __( 'Post Options', 'mountain' ),
			'post_types'  => 'post',
			'context'     => 'normal',
			'priority'    => 'high',
			'storage_key' => '_post_options',
			'show_tabs'   => false,
			'sections'    => array(
				'all'     => array( 'title' => __( 'Post Options', 'mountain' ) ) 
			),
			'options'     => $options
		) );
	}
}
