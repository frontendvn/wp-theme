<?php
/**
 * WARNING: This file is part of the OptionsPlus library. DO NOT edit
 * this file under any circumstances.
 */
namespace OptionsPlus\Options\Control;

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();


add_action( 'admin_footer', __NAMESPACE__ . '\\MediaList::templates' );

/**
 * This class will be present an mediapicker control
 */
class MediaList extends \OptionsPlus\Options\Control
{
	/**
	 * The control type
	 * 
	 * @var  string
	 */
	public $type = 'media-list';

	/**
	 * Option property to initialize
	 * sortable function for media list
	 * 
	 * @var  boolean
	 */
	public $sortable = true;

	/**
	 * Type of the files that will be listed
	 * on media browse window
	 * 
	 * @var  array
	 */
	public $media_types = array( 'image', 'video' );

	/**
	 * Enqueue control scripts
	 * 
	 * @return  void
	 */
	public function enqueue() {
		wp_enqueue_media();
	}
	
	/**
	 * Render the control markup
	 * 
	 * @return  void
	 */
	public function render_content() {
		$name  = '_options-media-list-' . $this->id;
		$value = $this->value();
		$buttons = array();

		if ( ! is_array( $value ) )
			$value = json_decode( $value, true );

		if ( in_array( 'image', $this->media_types ) )
			$buttons[] = sprintf( '<a href="#" class="add-image">%s</a>', __( 'Insert Image(s)', 'options-plus' ) );

		if ( in_array( 'video', $this->media_types ) )
			$buttons[] = sprintf( '<a href="#" class="add-video">%s</a>', __( 'Insert Video(s)', 'options-plus' ) );
		?>

			<div class="options-control-inputs">
				<ul class="media-items"></ul>
				<?php echo implode( ' / ', $buttons ) ?>
			</div>
			<input type="hidden" name="op-options[<?php __esc_attr( $this->id ) ?>]" value="<?php __esc_attr( json_encode( $value ) ) ?>" />
		
		<?php
	}

	/**
	 * Print the modal templates for this control
	 * 
	 * @return  void
	 */
	public static function templates() {
		$videoPane = new \OptionsPlus\Options\Container( array(
			'show_tabs' => false,
			'sections'  => array(
				'all' => array(
					'title' => __( 'All', 'options-plus' )
				) 
			),
			'controls'  => array(
				'url' => array(
					'type'    => 'media-input',
					'section' => 'all',
					'label'   => __( 'URL', 'options-plus' ),
					'library' => 'video'
				)
			)
		) );

		$videoPane->enqueue();
		?>
			<script type="text/html" id="_mediaListVideoSettings">
				<form>
					<?php $videoPane->render() ?>
				</form>
			</script>
		<?php
	}
}
