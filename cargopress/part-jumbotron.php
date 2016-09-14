<div class="jumbotron  jumbotron--<?php echo 'caption' === get_field( 'slider_content' ) ? 'with-captions' : 'no-catption'; ?>">
	<div class="carousel  slide  js-jumbotron-slider" id="headerCarousel" data-ride="carousel" <?php printf( 'data-interval="%s"', get_field( 'auto_cycle' ) ? get_field( 'cycle_interval' ) : 'false' ); ?>>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">
		<?php
			$i = -1;
			while ( have_rows( 'slides' ) ) :
				the_row();
				$i++;

				$slider_sizes = array( 'cargopress-jumbotron-slider-l', 'cargopress-jumbotron-slider-m', 'cargopress-jumbotron-slider-s' );

				$slide_image_srcset = CargoPressHelpers::get_slide_sizes( get_sub_field( 'slide_image' ), $slider_sizes );
				$slide_link         = get_sub_field( 'slide_link' );

				$slider_src_img = wp_get_attachment_image_src( absint( get_sub_field( 'slide_image' ) ), 'cargopress-jumbotron-slider-s' );
		?>

			<div class="item <?php echo 0 === $i ? ' active' : ''; ?>">
				<?php if ( ! empty( $slide_link ) && 'link' === get_field( 'slider_content' ) ) :?>
					<a href="<?php echo esc_url( $slide_link ); ?>" target="<?php echo ( get_sub_field( 'slide_open_link_in_new_window' ) ) ?  '_blank' : '_self' ?>">
				<?php endif; ?>
				<img src="<?php echo esc_url( $slider_src_img[0] ); ?>" srcset="<?php echo sanitize_text_field( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( get_sub_field( 'slide_title' ) ); ?>">
				<?php if ( ! empty( $slide_link ) && 'link' === get_field( 'slider_content' ) ) :?>
					</a>
				<?php endif; ?>
				<?php if ( 'caption' === get_field( 'slider_content' ) ) : ?>
				<div class="container">
					<div class="jumbotron-content">
					<?php if ( strlen( get_sub_field( 'slide_category' ) ) ) : ?>
					<?php endif; ?>
						<div class="jumbotron-content__title">
							<h1><?php the_sub_field( 'slide_title' ); ?></h1>
						</div>
						<div class="jumbotron-content__description">
							<?php the_sub_field( 'slide_text' ); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>

		<?php
			endwhile;
		?>
		</div>

		<div class="container">
			<!-- Controls -->
			<a class="left  jumbotron__control" href="#headerCarousel" role="button" data-slide="prev">
				<i class="fa  fa-caret-left"></i>
			</a>
			<a class="right  jumbotron__control" href="#headerCarousel" role="button" data-slide="next">
				<i class="fa  fa-caret-right"></i>
			</a>
		</div>

	</div>
</div>