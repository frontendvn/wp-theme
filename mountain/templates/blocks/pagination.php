<?php
/**
 * WARNING: This file is part of the Mountain Theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

// Don't print empty markup if there's only one page.
if ( $GLOBALS['wp_query']->max_num_pages < 2 ) return;

$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
$pagenum_link = html_entity_decode( get_pagenum_link() );
$query_args   = array();
$url_parts    = explode( '?', $pagenum_link );

if ( isset( $url_parts[1] ) ) {
	wp_parse_str( $url_parts[1], $query_args );
}

$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

// Set up paginated links.
$links = paginate_links( array(
	'base'     => $pagenum_link,
	'format'   => $format,
	'total'    => $GLOBALS['wp_query']->max_num_pages,
	'current'  => $paged,
	'mid_size' => 1,
	'add_args' => array_map( 'urlencode', $query_args ),
	'prev_text' => __( '&larr; Previous', 'mountain' ),
	'next_text' => __( 'Next &rarr;', 'mountain' ),
) );

$numeric_links = paginate_links( array(
	'base'     => $pagenum_link,
	'format'   => $format,
	'total'    => $GLOBALS['wp_query']->max_num_pages,
	'current'  => $paged,
	'mid_size' => 1,
	'add_args' => array_map( 'urlencode', $query_args ),
	'prev_next' => false
) );

$next_link = get_next_posts_link( __( 'Next &rarr;', 'mountain' ) );
$prev_link = get_previous_posts_link( __( '&larr; Previous', 'mountain' ) );
$more_link = get_next_posts_link( __( 'Load More', 'mountain' ) );

$paging_style = op_option( 'blog_archive_pagination_style' );
?>

<?php if ( $paging_style == 'pager' && ! ( empty( $next_link ) && empty( $prev_link ) ) ): ?>

	<nav class="navigation paging-navigation pager" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $prev_link ?>
			<?php echo $next_link ?>
		</div>
	</nav>

<?php elseif ( $paging_style == 'numeric' && ! empty( $numeric_links ) ): ?>

	<nav class="navigation paging-navigation numeric" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $numeric_links ?>
		</div>
	</nav>

<?php elseif ( $paging_style == 'loadmore' && ! empty( $next_link ) ): ?>
	
	<nav class="navigation paging-navigation loadmore" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $more_link ?>
		</div>
	</nav>

<?php elseif ( ! empty( $links ) ): ?>

	<nav class="navigation paging-navigation pager-numeric" role="navigation">
		<div class="pagination loop-pagination">
			<?php echo $links ?>
		</div>
	</nav>

<?php endif ?>
