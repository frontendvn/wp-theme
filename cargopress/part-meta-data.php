<div class="meta-data">
	<time datetime="<?php the_time( 'c' ); ?>" class="meta-data__date"><?php echo get_the_date(); ?></time>
	<span class="meta-data__separator">/</span>
	<span class="meta-data__author"><?php _e( 'By' , 'cargopress-pt' ); ?> <?php the_author(); ?></span>
	<span class="meta-data__separator">/</span>
	<?php if ( has_category() ) { ?><span class="meta-data__categories"><?php _e( '' , 'cargopress-pt' ); ?> <?php the_category( ' &bull; ' ); ?></span><span class="meta-data__separator">/</span><?php } ?>
	<?php if ( has_tag() ) { ?><span class="meta-data__tags"><?php _e( '' , 'cargopress-pt' ); ?> <?php the_tags( '', ' &bull; ' ); ?></span><span class="meta-data__separator">/</span><?php } ?>
	<span class="meta-data__comments"><a href="<?php comments_link(); ?>"><?php CargoPressHelpers::pretty_comments_number(); ?></a></span>
</div>