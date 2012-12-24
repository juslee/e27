<?php
/**
 * Premise Member Access Link Manager
 *
 * @package Premise
 */


/**
 * Handles the registration and management of links for the Link Manager.
 *
 * This class handles the registration of the 'acp-links' Custom Post Type, which stores
 * all links. It also allows you to manage, edit, and (if need be) delete links.
 *
 * It uses the Access Level taxonomy to restrict access to links.
 *
 * The Link Name is the post title.
 * The Product ID is the numerical post ID.
 * The Access Level(s) this link requires are stored as a custom taxonomy. Each Access Level is a term.
 *
 * @since 2.2.0
 *
 */
class Premise_Member_Access_Links {


	/** Constructor */
	function __construct() {

		add_action( 'init', array( $this, 'register_post_type' ) );
		
		add_filter( 'manage_edit-acp-links_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
		add_action( 'save_post', array( $this, 'metabox_save' ), 1, 2 );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		// enqueue CSS
		add_action( 'load-edit.php', array( $this, 'enqueue_admin_css' ) );
		add_action( 'load-post.php', array( $this, 'enqueue_admin_css' ) );
		add_action( 'load-post-new.php', array( $this, 'enqueue_admin_css' ) );

	}

	/**
	 * Register the Products post type
	 */
	function register_post_type() {

			$labels = array(
				'name'               => __( 'Links', 'premise' ),
				'singular_name'      => __( 'Link', 'premise' ),
				'add_new'            => __( 'Create New Link', 'premise' ),
				'add_new_item'       => __( 'Create New Link', 'premise' ),
				'edit'               => __( 'Edit Link', 'premise' ),
				'edit_item'          => __( 'Edit Link', 'premise' ),
				'new_item'           => __( 'New Link', 'premise' ),
				'view'               => __( 'View Link', 'premise' ),
				'view_item'          => __( 'View Link', 'premise' ),
				'search_items'       => __( 'Search Links', 'premise' ),
				'not_found'          => __( 'No Links found', 'premise' ),
				'not_found_in_trash' => __( 'No Links found in Trash', 'premise' ),
				'menu_name'          => __( 'Link Manager', 'premise' ),
			);

		if ( current_user_can( 'manage_options' ) ) {

			register_post_type( 'acp-links',
				array(
					'labels' => $labels,
					'show_in_menu'         => 'premise-member',
					'supports'             => array( 'title' ),
					'taxonomies'           => array( 'acp-access-level' ),
					'register_meta_box_cb' => array( $this, 'metaboxes' ),
					'public'               => false,
					'show_ui'              => true,
					'rewrite'              => false,
					'query_var'            => false
				)
			);

		} else {

			register_post_type( 'acp-links',
				array(
					'labels' => $labels,
					'public'               => false,
					'show_ui'              => false,
					'rewrite'              => false,
					'query_var'            => false
				)
			);

		}

	}

	/**
	 * Register the metaboxes
	 */
	function metaboxes() {

		add_meta_box( 'accesspress-product-details-metabox', __( 'Link Details', 'premise' ), array( $this, 'details_metabox' ), 'acp-links', 'normal' );
		add_meta_box( 'accesspress-product-status-metabox', __( 'Status', 'premise' ), 'premise_custom_post_status_metabox', 'acp-links', 'side', 'high' );
		
		remove_meta_box( 'slugdiv', 'acp-links', 'normal' );
		remove_meta_box( 'submitdiv', null, 'side' );

	}

	function details_metabox( $post ) {
	?>

		<input type="hidden" name="accesspress-link-nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

		<table class="form-table">
		<tbody>
			
			<tr>
				<th scope="row"><p><?php _e( 'Link URI', 'premise' ); ?></p></th>
				
				<td>
					<?php if ( ! accesspress_get_custom_field( '_acp_link_id' ) ) : ?>
					<p class="description"><?php _e( 'Save link to generate URI', 'premise' ); ?></p>
					<?php else : ?>
					<input type="hidden" name="accesspress_link_meta[_acp_link_id]" value="<?php accesspress_custom_field( '_acp_link_id' ); ?>" />
					<p class="description"><?php echo esc_url( sprintf( home_url( '/?download_id=%s' ), accesspress_get_custom_field( '_acp_link_id' ) ) ); ?></p>
					<?php endif; ?>
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<label for="accesspress_link_meta[_acp_link_filename]"><?php _e( 'Filename', 'premise' ); ?></label>
				</th>
				
				<td>
					<input type="text" placeholder="" id="accesspress_link_meta[_acp_link_filename]" autocomplete="off" name="accesspress_link_meta[_acp_link_filename]" value="<?php accesspress_custom_field( '_acp_link_filename' ); ?>" class="large-text ui-autocomplete-input" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>
					<p><span class="description"><?php _e( 'Type the filename (file must exist) you wish to link to.', 'premise' ); ?></span></p>
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<label for="accesspress_link_meta[_acp_link_delay]"><?php _e( 'Delay Access', 'premise' ); ?></label>
				</th>
				
				<td>
					<input type="text" placeholder="" id="accesspress_link_meta[_acp_link_delay]" autocomplete="off" name="accesspress_link_meta[_acp_link_delay]" value="<?php accesspress_custom_field( '_acp_link_delay' ); ?>" class="small-text ui-autocomplete-input" role="textbox" aria-autocomplete="list" aria-haspopup="true"/> <?php _e( 'Days', 'premise' ); ?>
					<p><span class="description"><?php _e( 'Delay access to this file by X days after signup.', 'premise' ); ?></span></p>
				</td>
			</tr>
			
			<?php do_action( 'premise_memberaccess_link_details_metabox_rows' ); ?>
			
		</tbody>
		</table>

	<?php
	}
	/**
	 * Save the form data from the metaboxes
	 */
	function metabox_save( $post_id, $post ) {

		/**	Verify the nonce */
		if ( ! isset( $_POST['accesspress-link-nonce'] ) || ! wp_verify_nonce( $_POST['accesspress-link-nonce'], plugin_basename( __FILE__ ) ) )
			return $post->ID;

		/**	Don't try to save the data under autosave, ajax, or future post */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			return;
		if ( defined( 'DOING_CRON' ) && DOING_CRON )
			return;

		/**	Check if user is allowed to edit this */
		if ( ! current_user_can( 'edit_post', $post->ID ) )
			return $post->ID;

		/** Don't try to store data during revision save */
		if ( 'revision' == $post->post_type )
			return;

		/** Merge defaults with user submission */
		$defaults = apply_filters( 'premise_memberaccess_default_link_meta', array(
			'_acp_link_id'       => md5( time() ),
			'_acp_link_filename' => '',
			'_acp_link_delay'    => 0,
		) );

		$values = wp_parse_args( $_POST['accesspress_link_meta'], $defaults );

		/** Sanitize */
		$values = $this->sanitize( $values );

		/** Loop through values, to potentially store or delete as custom field */
		foreach ( (array) $values as $key => $value ) {
			/** Save, or delete if the value is empty */
			if ( $value )
				update_post_meta( $post->ID, $key, $value );
			else
				delete_post_meta( $post->ID, $key );
		}

	}

	/**
	 * Filter the columns in the "Orders" screen, define our own.
	 */
	function columns_filter ( $columns ) {

		unset( $columns['date'] );
		$new_columns = array(
			'filename'     => __( 'Filename', 'premise' ),
			'access_level' => __( 'Access Levels', 'premise' ),
			'uri'          => __( 'Link URI' )
		);

		return array_merge( $columns, $new_columns );

	}

	/**
	 * Filter the data that shows up in the columns in the "Orders" screen, define our own.
	 */
	function columns_data( $column ) {

		global $post;

		if ( 'acp-links' != $post->post_type )
			return;

		switch( $column ) {
			case 'filename':
				echo get_post_meta( $post->ID, '_acp_link_filename', true );
				break;
			case 'uri' :
				echo make_clickable( esc_url_raw( sprintf( home_url( '/?download_id=%s' ), get_post_meta( $post->ID, '_acp_link_id', true ) ) ) );
				break;
			case "access_level":
				echo memberaccess_get_accesslevel_list( $post->ID );
				break;
		}

	}
	function enqueue_admin_css() {

		global $typenow;

		if( $typenow == 'acp-links' )
			wp_enqueue_style( 'premise-admin', PREMISE_RESOURCES_URL . 'premise-admin.css', array( 'thickbox' ), PREMISE_VERSION );

	}
	/**
	 * custom messages for the coupon post type
	 *
	 * @since 2.2.0
	 *
	 * @returns array
	 */
	function post_updated_messages( $messages ) {
		$messages['acp-links'] = array(
			 1 => __( 'Link updated.', 'premise' ),
			 4 => __('Link updated.', 'premise' ),
			 6 => __( 'Link published.', 'premise' ),
			 7 => __( 'Link saved.', 'premise' ),
		);
		return $messages;
	}
	/**
	 * Use this function to sanitize an array of values before storing.
	 *
	 * @todo a bit more thorough sanitization
	 */
	function sanitize( $values = array() ) {

		return (array) $values;

	}
	
}