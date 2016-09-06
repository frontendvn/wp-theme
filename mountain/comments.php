<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// We will hide comments for password protected posts
if ( post_password_required() ) return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h2 class="comments-title">
		<?php
			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'mountain' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'mountain' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'mountain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'mountain' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 60,
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'mountain' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'mountain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'mountain' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'mountain' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		comment_form( array(
			'comment_notes_after' => '',
			'fields' => array(
				'author' =>
					'<div class="comment-info"><p class="comment-form-author"><label for="author">' . __( 'Name', 'mountain' ) . '</label> ' .
					'<input id="author" name="author" type="text" placeholder="' . esc_attr( __( 'Name', 'mountain' ) ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' /></p>',

				'email' =>
					'<p class="comment-form-email"><label for="email">' . __( 'Email', 'mountain' ) . '</label> ' .
					'<input id="email" name="email" type="text" placeholder="' . esc_attr( __( 'Email', 'mountain' ) ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' /></p>',

				'url' =>
					'<p class="comment-form-url"><label for="url">' . __( 'Website', 'mountain' ) . '</label>' .
					'<input id="url" name="url" type="text" placeholder="' . esc_attr( __( 'Website', 'mountain' ) ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" /></p></div>',
			)
		) );

	?>

</div><!-- #comments -->
