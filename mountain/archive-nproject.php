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
 * Load the project archive layout
 */
get_template_part( 'templates/blocks/project-archive',
	op_option( 'projects_archive_layout' ) );
