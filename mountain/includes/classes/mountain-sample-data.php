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
 * Sample data installer class
 */
class Mountain_SampleData extends Mountain_Base
{
	private $data_tables = array();
	private $truncated_tables = array();
	private $table_prefix;

	/**
	 * [__construct description]
	 */
	protected function __construct() {
		if ( ! is_admin() )
			return;
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_ajax_sample_data', array( $this, 'invoke' ) );

		add_filter( 'mountain/install_sample_data', array( $this, 'import_content' ), 10, 2 );
		add_filter( 'mountain/install_sample_data', array( $this, 'update_metadata' ), 10, 2 );
		add_filter( 'mountain/install_sample_data', array( $this, 'download_attachment' ), 10, 2 );
	}

	/**
	 * [admin_menu description]
	 * @return [type] [description]
	 */
	public function admin_menu() {
		add_theme_page( __( 'Sample Data Installation', 'mountain' ),
						__( 'Sample Data', 'mountain' ),
						'edit_theme_options', 'sample-data', array( $this, 'admin_page' ) );
	}

	/**
	 * [admin_page description]
	 * @return [type] [description]
	 */
	public function admin_page() {
		?>

			<div id="sample-data-installer">
				<h1><?php _e( 'Sample Data Installation', 'mountain' ) ?></h1>

				<div class="start-screen">
					<p><?php _e( 'There is following tasks will be run for install sample data:', 'mountain' ) ?></p>
					<ol class="tasks">
						<li><?php _e( 'Import sample content', 'mountain' ) ?></li>
						<li><?php _e( 'Download media files', 'mountain' ) ?></li>
					</ol>

					<p>
						<button type="button" id="install-sample-data" class="button-primary"><?php _e( 'Install Sample Data', 'mountain' ) ?></button>
					</p>
				</div>

				<div class="running-screen">
					<ol class="tasks">
						<li data-task="import-content">
							<span><?php _e( 'Import sample content', 'mountain' ) ?></span>
							<span class="spinner-text"></span>
						</li>
						<li data-task="download-attachments">
							<span><?php _e( 'Download media files', 'mountain' ) ?></span>
							<span class="progress-text"></span>
							<span class="spinner-text"></span>
						</li>
					</ol>

					<p class="finish-actions">
						<span><?php _e( 'Congratulation! Sample data has been installed successfully', 'mountain' ) ?></span>
					</p>
				</div>
			</div>

		<?php
	}

	/**
	 * Enqueue script for sample data installation page
	 * 
	 * @return  void
	 */
	public function enqueue( $page ) {
		if ( $page == 'appearance_page_sample-data' ) {
			wp_enqueue_style( 'mountain-sample-data' );
			wp_enqueue_script( 'mountain-sample-data' );

			wp_localize_script( 'mountain-sample-data', '_sampleDataLocalization', array(
				'confirm_installation' => __( 'Attention!!! Your existing data will be removed when install sample data. Are you sure you want to install sample data?', 'mountain' )
			) );

			wp_localize_script( 'mountain-sample-data', '_sampleDataInfo', array(
				'siteURL' => site_url(),
				'nonce'   => wp_create_nonce( 'sample_data_installation' )
			) );
		}
	}

	/**
	 * [invoke description]
	 * @return [type] [description]
	 */
	public function invoke() {
		global $wpdb;

		if ( isset( $_POST['step'] ) &&
			 isset( $_POST['nonce'] ) ) {

			// Preparing tables information
			$this->table_prefix = $wpdb->get_blog_prefix();

			// Fetch all tables in the database
			foreach ( $wpdb->get_results( "SHOW TABLES", ARRAY_A ) as $table )
				$this->data_tables[] = end( $table );

			try {
				$response = apply_filters( 'mountain/install_sample_data', array( 'status' => 'success' ), $_POST );

				// Send action results to client
				echo json_encode( $response );
			}
			catch ( Exception $ex ) {
				echo json_encode( array(
						'status' => 'error',
						'message' => $ex->getMessage()
					) );
			}
			exit;
		}
	}

	public function import_content( $response, $context ) {
		global $wpdb, $wp_filesystem;

		if ( $context['step'] == 'import-content' && wp_verify_nonce( $context['nonce'], 'sample_data_installation' ) ) {
			@set_time_limit( 90 );

			$sample_data_path = trailingslashit( get_template_directory() ) . '/sample-data.json';
			$upload_dir       = wp_upload_dir();

			if ( ! is_file( $sample_data_path ) )
				throw new Exception( sprintf( __( 'Sample data file not found: %s', 'mountain' ), $sample_data_path ) );

			if ( ! WP_FileSystem() )
				throw new Exception( __( 'Cannot request permision for FileSystem API', 'mountain' ) );

			$data = $wp_filesystem->get_contents( $sample_data_path );
			$data_rows = explode( "\n", $data );

			// Read the first line for parse manifest
			$manifest = (array) json_decode( array_shift( $data_rows ), true );

			// Read the second line for sidebars settings
			$sidebars = (array) json_decode( array_shift( $data_rows ), true );

			// Read the third line for the theme options
			$options  = (array) json_decode( array_shift( $data_rows ), true );

			$post_types = get_post_types();
			$allowed_groups = array( 'content' );

			if ( isset( $post_types['portfolio'] ) )
				array_push( $allowed_groups, 'portfolio' );

			if ( isset( $post_types['nproject'] ) )
				array_push( $allowed_groups, 'nproject' );

			if ( isset( $post_types['templatify'] ) )
				array_push( $allowed_groups, 'templatify' );

			if ( isset( $post_types['member'] ) )
				array_push( $allowed_groups, 'member' );

			if ( isset( $post_types['product'] ) )
				array_push( $allowed_groups, 'woocommerce' );

			if ( isset( $post_types['easy-pricing-table'] ) )
				array_push( $allowed_groups, 'easy_pricing_table' );

			if ( isset( $post_types['wpcf7_contact_form'] ) )
				array_push( $allowed_groups, 'contact_form_7' );

			if ( in_array( "{$this->table_prefix}layerslider", $this->data_tables ) )
				array_push( $allowed_groups, 'layerslider' );

			if ( in_array( "{$this->table_prefix}revslider_slides", $this->data_tables ) )
				array_push( $allowed_groups, 'revslider' );

			// Update theme options
			$this->theme_options( $options, $manifest['info'] );

			// Update widgets settings
			$this->widgets_settings( $sidebars['data'], $manifest['info'] );

			// Start importing data
			while ( ! empty( $data_rows ) ) {
				$record = (array) json_decode( array_shift( $data_rows ), true );

				// Skip process when cannot decode row data
				if ( empty( $record ) )
					continue;

				// Import data for built-in post type
				if ( in_array( $record['group'], $allowed_groups ) ) {
					if ( $record['table'] == 'attachments' )
						$record['table'] = 'posts';

					$table = $this->table_prefix . $record['table'];
					$row   = $record['data'];

					if ( $record['table'] != 'options' && ! in_array( $table, $this->truncated_tables ) ) {
						$wpdb->query( "TRUNCATE TABLE {$table}" );
						$this->truncated_tables[] = $table;
					}

					// Try to insert or replace row data
					// to the table
					$wpdb->replace( $table, $row );
				}
			}

			/**
			 * Regenerate nonce
			 */
			$response['nonce'] = wp_create_nonce( 'sample_data_update_metadata' );
			$response['manifest'] = $manifest;
		}

		return $response;
	}

	/**
	 * [update_metadata description]
	 * @param  [type] $response [description]
	 * @param  [type] $context  [description]
	 * @return [type]           [description]
	 */
	public function update_metadata( $response, $context ) {
		global $wpdb, $wp_filesystem;

		if ( $context['step'] == 'update-metadata' && wp_verify_nonce( $context['nonce'], 'sample_data_update_metadata' ) ) {
			@set_time_limit( 90 );

			$manifest = $context['manifest'];

			/**
			 * Update the author
			 */
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_author=%d", get_current_user_id() ) );

			/**
			 * Update link in the post content
			 */
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET guid=REPLACE(guid, %s, %s) WHERE post_type NOT IN( 'attachment' )",
				trailingslashit( $manifest['info']['base'] ),
				trailingslashit( get_site_url() )
			) );

			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content=REPLACE(post_content, %s, %s) WHERE post_type NOT IN( 'attachment' )",
				trailingslashit( $manifest['info']['base'] ),
				trailingslashit( get_site_url() )
			) );

			/**
			 * Update link for custom css data
			 */
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value=REPLACE(meta_value, %s, %s) WHERE meta_key IN( '_wpb_post_custom_css', '_wpb_shortcodes_custom_css', '_menu_item_url' )",
				trailingslashit( $manifest['info']['base'] ),
				trailingslashit( get_site_url() )
			) );

			/**
			 * Update link for layerslider, revolution slider
			 */
			$tables = array(
				'layerslider'       => array( 'data' ),
				'revslider_slides'  => array( 'params', 'layers' ),
				'revslider_sliders' => array( 'params' )
			);

			foreach ( $tables as $name => $fields ) {
				if ( ! in_array( "{$this->table_prefix}{$name}", $this->data_tables ) )
					continue;

				$joined_fields = implode( ', ', $fields );
				$rows = $wpdb->get_results( "SELECT * FROM {$this->table_prefix}{$name}", ARRAY_A );

				foreach ( $rows as $row ) {
					foreach ( $fields as $field )
						$row[$field] = $this->update_meta_content( $row[$field], $manifest['info'] );

					$wpdb->replace( $this->table_prefix . $name, $row );
				}
			}

			/**
			 * Update link in the post meta
			 */
			$postmeta = $wpdb->get_results( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key IN( '_page_options', '_post_options', '_portfolio_options' )" );
			
			foreach ( $postmeta as $row ) {
				$row->meta_value = serialize( $this->update_meta_content( unserialize( $row->meta_value ), $manifest['info'] ) );
				$wpdb->replace( $wpdb->postmeta, get_object_vars( $row ) );
			}

			/**
			 * Fetch the attachment Ids
			 */
			$attachment_ids = array();
			$attachment_query = new \WP_Query( array(
					'post_type'   => 'attachment',
					'post_status' => 'any',
					'nopaging'    => true
				) );

			while ( $attachment_query->have_posts() ) {
				$attachment_query->next_post();
				$attachment_ids[] = $attachment_query->post->ID;
			}

			$response['nonce'] = wp_create_nonce( 'sample_data_download_attachments' );
			$response['attachment_ids'] = $attachment_ids;
		}

		return $response;
	}

	/**
	 * [download_attachment description]
	 * @param  [type] $response [description]
	 * @param  [type] $context  [description]
	 * @return [type]           [description]
	 */
	public function download_attachment( $response, $context ) {
		global $wp_filesystem, $wpdb;

		if ( $context['step'] == 'download-attachment' && wp_verify_nonce( $context['nonce'], 'sample_data_download_attachments' ) ) {
			if ( isset( $context['id'] ) ) {
				@set_time_limit( 90 );

				// Initialize FileSystem API
				WP_FileSystem();

				$attachment = get_post( $context['id'] );
				$upload_dir = wp_upload_dir();
				$manifest   = $context['manifest']['info'];

				if ( strpos( $attachment->guid, get_site_url() ) !== false )
					return $response;

				$attached_file_parts = explode( '/uploads', $attachment->guid );
				$attached_file    = end( $attached_file_parts );
				$destination_path = $upload_dir['basedir'];

				foreach ( explode( '/', dirname( $attached_file ) ) as $part ) {
					$destination_path = trailingslashit( $destination_path ) . $part;
 
					if ( ! $wp_filesystem->is_dir( $destination_path ) )
						$wp_filesystem->mkdir( $destination_path );
				}

				update_post_meta( $attachment->ID, '_wp_attached_file', trim( $attached_file, '/' ) );

				$destination = trailingslashit( $destination_path ) . basename( $attached_file );
				$remote_response = wp_safe_remote_get( $attachment->guid, array(
					'timeout' => 0, 'stream' => true, 'filename' => $destination ) );

				$response_code = wp_remote_retrieve_response_code( $remote_response );

				if ( $response_code != 200 ) {
					if ( is_wp_error( $response_code ) )
						throw new Exception( $response_code->get_error_message() );

					throw new Exception( $remote_response, $response_code );
				}

				$wpdb->update( $wpdb->posts,
					array( 'guid' => $upload_dir['baseurl'] . $attached_file ),
					array( 'ID'   => $attachment->ID )
				);

				$attach_data = wp_generate_attachment_metadata( $attachment->ID, $destination );
				wp_update_attachment_metadata( $attachment->ID, $attach_data );
			}
		}

		return $response;
	}

	/**
	 * [widgets_settings description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function widgets_settings( $data, $manifest ) {
		global $wp_filesystem, $wp_registered_sidebars;

		$data = $this->update_meta_content( $data, $manifest );

		if ( isset( $data['relationship'] ) && isset( $data['sidebars'] ) && isset( $data['instances'] ) ) {
			update_option( 'sidebars_widgets', $data['relationship'] );
			update_option( wp_get_theme()->Template . '_sidebars', $data['sidebars'] );

			foreach ( $data['instances'] as $id => $params ) {
				update_option( $id, $params );
			}
		}
	}

	/**
	 * [theme_options description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function theme_options( $data, $manifest ) {
		global $wp_filesystem;

		if ( isset( $data['mods'] ) && is_array( $data['mods'] ) ) {
			$theme = get_option( 'stylesheet' );

			foreach ( $data['mods'] as $name => $value )
				$data['mods'][$name] = $this->update_meta_content( $value, $manifest );

			update_option( "theme_mods_{$theme}", $data['mods'] );
		}

		if ( isset( $data['core'] ) && is_array( $data['core'] ) ) {
			foreach ( $data['core'] as $name => $value )
				update_option( $name, $value );
		}
	}

	private function update_meta_content( $data, $manifest ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$data[$key] = $this->update_meta_content( $value, $manifest );
			}

			return $data;
		}

		// Try to decode string as json format
		$decoded_string = json_decode( $data, true );

		if ( $decoded_string != null && is_array( $decoded_string ) ) {
			return json_encode( $this->update_meta_content( $decoded_string , $manifest ) );
		}
		
		if ( strpos( $data, $manifest['base'] ) !== false ) {
			return str_replace( trailingslashit( $manifest['base'] ), trailingslashit( get_site_url() ), $data );
		}

		return $data;
	}
}
