<?php
/**
 * Call to Action Widget
 */

if ( ! class_exists( 'PW_Call_To_Action' ) ) {
	class PW_Call_To_Action extends WP_Widget {

		// Basic widget settings
		function widget_id_base() { return 'call_to_action'; }
		function widget_name() { return __( 'Call to Action', 'cargopress-pt' ); }
		function widget_description() { return __( 'Call to Action widget for Page Builder.', 'cargopress-pt' ); }
		function widget_class() { return 'widget-call-to-action'; }

		public function __construct() {
			parent::__construct(
				'pw_' . $this->widget_id_base(),
				sprintf( 'ProteusThemes: %s', $this->widget_name() ), // Name
				array(
					'description' => $this->widget_description(),
					'classname'   => $this->widget_class(),
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$instance['text']  = do_shortcode( $instance['text'] );
			$instance['button_text'] = do_shortcode( $instance['button_text'] );

			echo $args['before_widget'];
			?>
				<div class="call-to-action">
					<div class="call-to-action__text">
						<?php echo $instance['text']; ?>
					</div>
					<div class="call-to-action__button">
						<?php echo $instance['button_text']; ?>
					</div>
				</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['text'] = wp_kses_post( $new_instance['text'] );
			$instance['button_text'] = wp_kses_post( $new_instance['button_text'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _ex( 'Text:', 'backend', 'cargopress-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php _ex( 'Button Area:', 'backend', 'cargopress-pt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" /><br><br>
				<span class="button-shortcodes">
					For adding buttons you must use button shortcode which looks like that: <b>[button]Text[/button]</b>.<br>
					There is more option with different attributes - <b>text</b>, <b>style</b>, <b>href</b>, <b>target</b>.<br>
					<b>Text</b>: You can change the text of the button. Example: <b>[button]New Text[/button]</b>.<br>
					<b>Style</b>: You can choose betwen few styles - <b>primary</b>, <b>default</b>, <b>success</b>, <b>info</b>, <b>warning</b> or <b>danger</b>. Example: <b>[button style="default"]Text[/button]</b>.<br>
					<b>Href</b>: You can add any URL to the button. Example: <b>[button href="http://www.proteusthemes.com"]Text[/button]</b>.<br>
					<b>Target</b>: You can choose if you want to open link in same (<b>_self</b>) or new (<b>_blank</b>) window. Example: <b>[button target="_blank"]Text[/button]</b>.<br>
				</span>
			</p>

			<?php
		}

	}
	register_widget( 'PW_Call_To_Action' );
}