<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Query args
$args = array(
	'post_type'      => 'post',
	'posts_per_page' => op_option( 'blog_related_posts_count', 4 ),
	'post__not_in'   => array( get_the_ID() )
);

$related_item_type = op_option( 'blog_related_type', 'category' );

// Filter by tags
if ( 'tag' == $related_item_type ) {
	if ( ! ( $terms = (array) get_the_tags() ) )
		return;

	$args['tag__in'] = wp_list_pluck( $terms, 'term_id' );
}
// Filter by categories
elseif ( 'category' == $related_item_type ) {
	if ( ! ( $terms = (array) get_the_category() ) )
		return;

	$args['category__in'] = wp_list_pluck( $terms, 'term_id' );
}
// Show random items
elseif ( 'random' == $related_item_type ) {
	$args['orderby'] = 'rand';
}
// Show latest items
elseif ( 'recent' == $related_item_type ) {
	$args['order'] = 'DESC';
	$args['orderby'] = 'date';
}

// Create the query instance
$query = new WP_Query( $args );
?>
<section class="box box-related-posts" data-columns="<?php __esc_attr( (string) op_option( 'blog_related_posts_columns', 3 ) ) ?>">
	<div class="box-wrapper">
		<h3 class="box-title"><?php _e( 'Related Posts', 'mountain' ) ?></h3>
		<div class="box-content">
			<?php while ( $query->have_posts() ): $query->the_post(); ?>
				
				<article <?php post_class() ?>>
					<div class="entry-wrapper">
						<div class="entry-date">
							<span class="entry-month">
								<?php __esc_html( get_the_date( 'M' ) ) ?>
							</span>
							<span class="entry-day">
								<?php __esc_html( get_the_date( 'd' ) ) ?>
							</span>
							<span class="entry-year">
								<?php __esc_html( get_the_date( 'Y' ) ) ?>
							</span>
						</div>

						<div class="entry-cover">
							<a href="<?php the_permalink() ?>">
								<?php the_post_thumbnail( 'blog-medium-crop' ) ?>
							</a>
						</div>
							
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
							</h2>
						</header>

						<div class="entry-content" itemprop="text">
							<?php

								$content = get_the_content();
								$content = trim( strip_tags( $content ) );
								$length  = 100;

								if ( mb_strlen( $content ) > $length ) {
									$content = mb_substr( $content, 0, $length );
									$content.= '...';
								}

								echo wp_kses_post( $content );

							?>

							<div class="readmore">
								<a href="<?php the_permalink() ?>"><?php _e( 'Continue Read', 'mountain' ) ?></a>
							</div>
						</div>
						<!-- /entry-content -->
					</div>
					<!-- /.entry-wrapper -->
				</article>

			<?php endwhile ?>
			<?php wp_reset_postdata() ?>
		</div>
	</div>
</section>
