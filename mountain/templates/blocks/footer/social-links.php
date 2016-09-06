<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Ignore output social links on footer when it is disabled
if ( ! op_option( 'footer_social_links_enabled' ) ) return;

$available_icons = op_available_social_icons();
$social_links    = op_option( 'social_links' );

if ( ! isset( $social_links['__icons_ordering__'] ) )
	$social_links['__icons_ordering__'] = $available_icons['__icons_ordering__'];
?>
<div class="social-links">
	<?php

		foreach( $social_links['__icons_ordering__'] as $id ) {
			if ( ! isset( $available_icons[$id] ) || ! isset( $social_links[$id] ) )
				continue;

			$link = $social_links[$id];
			$icon_class = $available_icons[$id]['icon_class'];

			printf( '<a href="%s" target="_blank"><i class="fa %s"></i></a>', $link, $icon_class );
		}
	
	?>
</div>
