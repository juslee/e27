<?php
/**
 * AccessPress Products registration and management.
 *
 * @package AccessPress
 */


/**
 * Handles the registration and management of products.
 *
 * This class handles the registration of the 'acp-products' Custom Post Type, which stores
 * all products created with AccessPress. It also allows you to manage, edit, and (if need be) delete
 * products.
 *
 * It uses the post meta API (custom fields) to store most of the product information, such as:
 * - Product Price
 * - Product Description
 * - Product Payment method(s)
 * - Product duration (length of time, in days, purchaser has access to this product)
 * - Product receipt email subject line
 * - Product receipt email intro text
 *
 * The Product Name is the post title.
 * The Product ID is the numerical post ID.
 * The Access Level(s) this product grants are stored as a custom taxonomy. Each Access Level is a term.
 *
 * @since 0.1.0
 *
 */
class AccessPress_Products {


	/** Constructor */
	function __construct() {

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		
		add_action( 'admin_menu', array( $this, 'add_accesslevel_menu_item' ) );
		add_filter( 'manage_edit-acp-products_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
		add_action( 'save_post', array( $this, 'metabox_save' ), 1, 2 );
		add_action( 'premise_membership_create_order', array( $this, 'email_purchase_notification' ), 10, 4 );
		add_action( 'after-acp-access-level-table', array( $this, 'add_expand_menu_script' ) );
		add_action( 'acp-access-level_edit_form_fields', array( $this, 'add_expand_menu_script' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		// enqueue CSS
		add_action( 'load-edit-tags.php', array( $this, 'enqueue_admin_css' ) );
		add_action( 'load-edit.php', array( $this, 'enqueue_admin_css' ) );
		add_action( 'load-post.php', array( $this, 'enqueue_admin_css' ) );
		add_action( 'load-post-new.php', array( $this, 'enqueue_admin_css' ) );

	}

	/**
	 * Register the Products post type
	 */
	function register_post_type() {

			$labels = array(
				'name'               => __( 'Products', 'premise' ),
				'singular_name'      => __( 'Product', 'premise' ),
				'add_new'            => __( 'Create New Product', 'premise' ),
				'add_new_item'       => __( 'Create New Product', 'premise' ),
				'edit'               => __( 'Edit Product', 'premise' ),
				'edit_item'          => __( 'Edit Product', 'premise' ),
				'new_item'           => __( 'New Product', 'premise' ),
				'view'               => __( 'View Product', 'premise' ),
				'view_item'          => __( 'View Product', 'premise' ),
				'search_items'       => __( 'Search Products', 'premise' ),
				'not_found'          => __( 'No Products found', 'premise' ),
				'not_found_in_trash' => __( 'No Products found in Trash', 'premise' )
			);

		if ( current_user_can( 'manage_options' ) ) {

			register_post_type( 'acp-products',
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

			register_post_type( 'acp-products',
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
	
	function register_taxonomy() {

		register_taxonomy( 'acp-access-level', array( 'acp-products' ), array(
			'label'        => __( 'Access Levels', 'premise' ),
			'labels'       => array(
				'name'                       => __( 'Access Levels', 'premise' ),
				'singular_name'              => __( 'Access Level', 'premise' ),
				'separate_items_with_commas' => __( 'Separate access levels with commas', 'premise' ),
				'choose_from_most_used'      => __( 'Choose from previously used access levels', 'premise' )
			),
			'public'       => false,
			'show_ui'      => true,
			'hierarchical' => false,
			'query_var'    => false,
			'rewrite'      => false
		) );

	}

	function add_accesslevel_menu_item() {

		global $menu, $submenu;

		if ( empty( $submenu['premise-member'] ) ) {

			unset( $menu['56.501'] );
			return;

		}

		$tax = get_taxonomy( 'acp-access-level' );
		$orders_item = array_pop( $submenu['premise-member'] );

		$submenu['premise-member'][] = array( esc_attr( $tax->labels->menu_name ), $tax->cap->manage_terms, "edit-tags.php?taxonomy=$tax->name&amp;post_type=acp-products", esc_attr( $tax->labels->menu_name ) );
		$submenu['premise-member'][] = $orders_item;

	}
	/**
	 * Register the metaboxes
	 */
	function metaboxes() {

		add_meta_box( 'accesspress-product-details-metabox', __( 'Product Details', 'premise' ), array( $this, 'details_metabox' ), 'acp-products', 'normal' );
		add_meta_box( 'accesspress-product-status-metabox', __( 'Status', 'premise' ), 'premise_custom_post_status_metabox', 'acp-products', 'side', 'high' );
		remove_meta_box( 'slugdiv', 'acp-products', 'normal' );
		remove_meta_box( 'submitdiv', null, 'side' );

	}

	function details_metabox( $post ) {

		global $product_post;
		$product_post = $post;

		if ( 'publish' == $post->post_status ) {

			$purchase_link = accesspress_get_checkout_link( $post->ID );
			if ( ! $purchase_link )
				$purchase_link = __( 'Checkout page has not been configured.', 'premise' );
			
			echo '<p><strong>' . __( 'Purchase link:', 'premise' ) . '</strong> ' . $purchase_link . '</p>';

		}
	?>

		<input type="hidden" name="accesspress-products-nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

		<p>
			<label for="accesspress_product_meta[_acp_product_description]"><?php _e( 'Product Description', 'premise' ); ?>:</label>
			<br />
			<textarea class="large-text" rows="4" name="accesspress_product_meta[_acp_product_description]" id="accesspress_product_meta[_acp_product_description]"><?php echo esc_textarea( accesspress_get_custom_field( '_acp_product_description' ) ); ?></textarea>
		</p>

		<p>
			<input type="checkbox" name="accesspress_product_meta[_acp_product_free_product]" id="accesspress_product_meta[_acp_product_free_product]" value="1" <?php checked( '1', accesspress_get_custom_field( '_acp_product_free_product' ) ); ?> />
			<label for="accesspress_product_meta[_acp_product_free_product]"><?php _e( 'This is a free product', 'premise' ); ?></label>
			<script type="text/javascript">
			//<!--
			function premise_toggle_product_pricing(){
				if(jQuery('#accesspress_product_meta\\[_acp_product_free_product\\]').attr('checked')) {
					jQuery('.premise-product-pricing').hide();
					return;
				}

				jQuery('.premise-product-pricing').not('.premise-product-subscription').show();
				if(jQuery('#accesspress_product_meta\\[_acp_product_subscription\\]').attr('checked'))
					jQuery('.premise-product-subscription').show();
				else
					jQuery('.premise-product-subscription').hide();
			}
			jQuery(document).ready(function(){
				jQuery('#accesspress_product_meta\\[_acp_product_free_product\\], #accesspress_product_meta\\[_acp_product_subscription\\]').click(premise_toggle_product_pricing);
				premise_toggle_product_pricing();
				jQuery('.premise-product-receipt-preview').hide();
				jQuery('.premise-product-receipt-preview-identifier').hover(function(){
					jQuery('.premise-product-receipt-preview').show();
				},function(){
					jQuery('.premise-product-receipt-preview').hide();
				});
				jQuery('.premise-product-receipt-shortcodes').hide();
				jQuery('.premise-product-receipt-shortcodes-identifier').click(function(event){
					event.preventDefault();
					jQuery('.premise-product-receipt-shortcodes').toggle();
				});
			});
			//-->
			</script>
		</p>

		<p class="premise-product-pricing">
			<label for="accesspress_product_meta[_acp_product_price]"><?php _e( 'Product Price', 'premise' ); ?>:
			<br />
			$</label><input class="small-text" type="text" name="accesspress_product_meta[_acp_product_price]" id="accesspress_product_meta[_acp_product_price]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_price' ) ); ?>" />
		</p>

		<p>
			<label for="accesspress_product_meta[_acp_product_duration]"><?php _e( 'Product Duration', 'premise' ); ?> <span class="description"><?php _e( 'Enter 0 for lifetime', 'premise' ); ?></span>:
			<br />
			</label><input class="small-text" type="text" name="accesspress_product_meta[_acp_product_duration]" id="accesspress_product_meta[_acp_product_duration]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_duration', 0 ) ); ?>" />
			<label for="accesspress_product_meta[_acp_product_duration]"><?php _e( 'days', 'premise' ); ?></label>
		</p>

	<?php
		if ( accesspress_get_option( 'authorize_net_recurring' ) ) {
	?>
		<p class="premise-product-pricing">
			<input type="checkbox" name="accesspress_product_meta[_acp_product_subscription]" id="accesspress_product_meta[_acp_product_subscription]" value="1" <?php checked( '1', accesspress_get_custom_field( '_acp_product_subscription' ) ); ?> />
			<label for="accesspress_product_meta[_acp_product_subscription]"><?php _e( 'This is a subscription', 'premise' ); ?></label>
		</p>
		<p class="premise-product-pricing premise-product-subscription">
			<label for="accesspress_product_meta[_acp_product_number_payments]"><?php _e( 'Number of Payments including Trial Payment below', 'premise' ); ?> <span class="description"><?php _e( 'Leave blank for indefinite', 'premise' ); ?></span>:
			<br />
			</label><input class="small-text" type="text" name="accesspress_product_meta[_acp_product_number_payments]" id="accesspress_product_meta[_acp_product_number_payments]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_number_payments', '' ) ); ?>" />
			<label for="accesspress_product_meta[_acp_product_number_payments]"><?php _e( 'payments', 'premise' ); ?></label>
		</p>
		<p class="premise-product-pricing premise-product-subscription">
			<label for="accesspress_product_meta[_acp_product_trial_price]"><?php _e( 'Trial Price', 'premise' ); ?> <span class="description"><?php _e( 'Leave blank for none', 'premise' ); ?></span>:
			<br />
			$</label><input class="small-text" type="text" name="accesspress_product_meta[_acp_product_trial_price]" id="accesspress_product_meta[_acp_product_trial_price]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_trial_price', '' ) ); ?>" />
		</p>
		<p class="premise-product-pricing premise-product-subscription">
			<label for="accesspress_product_meta[_acp_product_trial_duration]"><?php _e( 'Trial Period', 'premise' ); ?> <span class="description"><?php _e( 'Leave blank for none', 'premise' ); ?></span>:
			<br />
			</label><input class="small-text" type="text" name="accesspress_product_meta[_acp_product_trial_duration]" id="accesspress_product_meta[_acp_product_trial_duration]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_trial_duration', '' ) ); ?>" />
			<label for="accesspress_product_meta[_acp_product_trial_duration]"><?php _e( 'days', 'premise' ); ?></label>
		</p>
	<?php
		}
	?>
		<hr />
		<p>
			<input type="checkbox" name="accesspress_product_meta[_acp_product_email_enabled]" id="accesspress_product_meta[_acp_product_email_enabled]" value="1" <?php checked( '1', accesspress_get_custom_field( '_acp_product_email_enabled' ) ); ?> />
			<label for="accesspress_product_meta[_acp_product_email_enabled]"><strong><?php _e( 'Send an Email Receipt', 'premise' ); ?></strong></label>
			<a href="#" class="premise-product-receipt-preview-identifier"><?php _e( 'Preview Email', 'premise' ); ?></a>
			<?php submit_button( __( 'Update' ), 'primary', 'save', false ); ?>
			<div class="premise-product-receipt-preview">
		<?php
			$email = $this->email_purchase_notification( get_current_user_id(), array( '_acp_order_product_id' => $post->ID ), true );
			printf( '%s: %s<br /><br />%s', __( 'Subject', 'premise' ), $email['email_subject'], str_replace( "\n", '<br />', $email['email_body'] ) );
		?>
			</div>
		</p>

		<p>
			<label for="accesspress_product_meta[_acp_product_email_receipt_subject]"><?php _e( 'Email Receipt Subject Line', 'premise' ); ?>:
			<br />
			</label><input class="large-text" type="text" name="accesspress_product_meta[_acp_product_email_receipt_subject]" id="accesspress_product_meta[_acp_product_email_receipt_subject]" value="<?php echo esc_attr( accesspress_get_custom_field( '_acp_product_email_receipt_subject', sprintf( __( 'Receipt for purchase at %s', 'premise' ), get_bloginfo( 'name' ) ) ) ); ?>" />
		</p>

		<p>
			<label for="accesspress_product_meta[_acp_product_email_receipt_intro]"><?php _e( 'Email Receipt Message Text', 'premise' ); ?></label> <span class="description"><?php _e( 'This message will also be displayed when checkout is complete', 'premise' ); ?></span>:
			<br />
			<textarea class="large-text" rows="4" name="accesspress_product_meta[_acp_product_email_receipt_intro]" id="accesspress_product_meta[_acp_product_email_receipt_intro]"><?php echo esc_textarea( accesspress_get_custom_field( '_acp_product_email_receipt_intro' ) ); ?></textarea>
		</p>
		<p>
			<a href="#" class="premise-product-receipt-shortcodes-identifier"><?php _e( 'Available Shortcodes', 'premise' ); ?></a>
			<ul class="premise-product-receipt-shortcodes">
				<li>[member-first-name]</li>
				<li>[member-last-name]</li>
				<li>[product-title]</li>
				<li>[product-description]</li>
				<li>[product-price]</li>
				<li>[order-transaction-id]</li>
			</ul>
		</p>

	<?php
	}
	/**
	 * Save the form data from the metaboxes
	 */
	function metabox_save( $post_id, $post ) {

		/**	Verify the nonce */
		if ( ! isset( $_POST['accesspress-products-nonce'] ) || ! wp_verify_nonce( $_POST['accesspress-products-nonce'], plugin_basename( __FILE__ ) ) )
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
		$defaults = apply_filters( 'memberaccess_default_product_meta', array(
			'_acp_product_price'			=> 0,
			'_acp_product_description'		=> '',
			'_acp_product_free_product'		=> 0,
			'_acp_product_payment_authorize_net'	=> 0,
			'_acp_product_subscription'		=> 0,
			'_acp_product_number_payments'		=> '',
			'_acp_product_payment_paypal'		=> 0,
			'_acp_product_payment_dummycc'		=> 0,
			'_acp_product_duration'			=> 0,
			'_acp_product_email_enabled'		=> 0,
			'_acp_product_email_receipt_subject'	=> '',
			'_acp_product_email_receipt_intro'	=> '',
		) );

		$values = wp_parse_args( $_POST['accesspress_product_meta'], $defaults );

		/** Sanitize */
		$values = $this->sanitize( $values );

		/** don't allow a single payment subscription */
		if ( (int) $values['_acp_product_number_payments'] < 2 )
			$values['_acp_product_number_payments'] = false;

		/** Loop through values, to potentially store or delete as custom field */
		foreach ( (array) $values as $key => $value ) {
			/** Save, or delete if the value is empty */
			if ( $value )
				update_post_meta( $post->ID, $key, $value );
			else
				delete_post_meta( $post->ID, $key );
		}

	}

	function email_purchase_notification( $member, $order_details, $skip_email = false, $order_id = 0 ) {

		global $product_post, $product_member, $checkout_order;

		if ( empty( $order_details['_acp_order_product_id'] ) || $skip_email || ! accesspress_get_custom_field( '_acp_product_email_enabled', '', $order_details['_acp_order_product_id'] ) )
			return;

		$product_member = get_user_by( 'id', $member );
		if ( ! $product_member || ! is_email( $product_member->user_email ) )
			return;

		$product_post = get_post( $order_details['_acp_order_product_id'] );
		if ( empty( $product_post ) )
			return;

		$checkout_order = get_post( $order_id );
		$email_subject = get_post_meta( $product_post->ID, '_acp_product_email_receipt_subject', true );
		$email_subject = apply_filters( 'premise_purchase_notification_subject', $email_subject, $order_details );
		if( ! empty( $email_subject ) )
			$email_subject = do_shortcode( $email_subject );

		$email_body = get_post_meta( $product_post->ID, '_acp_product_email_receipt_intro', true );
		$email_body = apply_filters( 'premise_purchase_notification_body', $email_body, $order_details );
		if( ! empty( $email_body ) )
			$email_body = do_shortcode( $email_body );

		if ( $skip_email )
			return compact( 'email_subject', 'email_body' );

		$email_from = memberaccess_get_email_receipt_address();
		$from_description = accesspress_get_option( 'email_receipt_name' );

		wp_mail( $product_member->user_email, $email_subject, $email_body, "From: \"{$from_description}\" <{$email_from}>" );

	}

	/**
	 * Filter the columns in the "Orders" screen, define our own.
	 */
	function columns_filter ( $columns ) {

		$date_column = array( 'date' => $columns['date'] );
		unset( $columns['date'] );
		$new_columns = array(
			'product_price'		=> __( 'Price', 'premise' ),
			'access_level'		=> __( 'Access Levels', 'premise' )
		);

		return array_merge( $columns, $new_columns, $date_column );

	}

	/**
	 * Filter the data that shows up in the columns in the "Orders" screen, define our own.
	 */
	function columns_data( $column ) {

		global $post;

		if ( 'acp-products' != $post->post_type )
			return;

		switch( $column ) {
			case "product_price":
				$free = accesspress_get_custom_field( '_acp_product_free_product' );
				if ( $free ) {

					_e( '<p>Free Product</p>', 'premise' );
					break;

				}

				$price = accesspress_get_custom_field( '_acp_product_price' );
				if ( ! $price )
					break;

				printf( __( '<p>%.2f</p>', 'premise' ), $price );
				break;
			case "access_level":
				echo memberaccess_get_accesslevel_list( $post->ID );
				break;
		}

	}
	/**
	 * Get the product price.
	 *
	 * @since 2.2.0
	 */
	public function get_product_price( $product_id, $coupon_id = null ) {

		$price = get_post_meta( $product_id, '_acp_product_price', true );
		$subscription = get_post_meta( $product_id, '_acp_product_subscription', true );

		// pass the original price to all filters
		return apply_filters( 'premise_product_price', $price, $coupon_id, $subscription, $price );	

	}
	/**
	 * Get the product trial price.
	 *
	 * @since 2.2.0
	 */
	public function get_product_trial_price( $product_id, $coupon_id = null ) {

		$price = get_post_meta( $product_id, '_acp_product_trial_price', true );

		// pass the original price to all filters
		return apply_filters( 'premise_product_trial_price', $price, $coupon_id, true, $price );	

	}
	/**
	 * Add script to expand the member access menu.
	 *
	 * @since 2.2.0
	 */
	function add_expand_menu_script() {
		?>
<script type="text/javascript">
//<!--
jQuery(document).ready(function() {
	jQuery('#toplevel_page_premise-member, #toplevel_page_premise-member > a').removeClass('wp-not-current-submenu menu-top-last').addClass('wp-has-current-submenu wp-menu-open menu-top');
});
//-->
</script>
		<?php
	}
	function enqueue_admin_css() {

		global $typenow;

		if( $typenow == 'acp-products' )
			wp_enqueue_style( 'premise-admin', PREMISE_RESOURCES_URL . 'premise-admin.css', array( 'thickbox' ), PREMISE_VERSION );

	}
	/**
	 * custom messages for the product post type
	 *
	 * @since 2.2.0
	 *
	 * @returns array
	 */
	function post_updated_messages( $messages ) {
		$messages['acp-products'] = array(
			 1 => __( 'Product updated.', 'premise' ),
			 4 => __('Product updated.', 'premise' ),
			 6 => __( 'Product published.', 'premise' ),
			 7 => __( 'Product saved.', 'premise' ),
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