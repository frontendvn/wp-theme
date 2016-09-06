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
 * Template Name: Projects
 */
if ( class_exists( 'nProjects' ) ):
	query_posts( array(
		'post_type'      => nProjects::TYPE_NAME,
		'posts_per_page' => op_option( 'projects_posts_per_page', 10 ),
		'paged'          => max( 1, get_query_var( 'paged' ) )
	) );

	get_template_part( 'archive-nproject' );
	wp_reset_postdata();
endif;
