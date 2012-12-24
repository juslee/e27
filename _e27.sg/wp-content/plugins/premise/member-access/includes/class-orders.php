<?php
/**
 * AccessPress Orders registration and management.
 *
 * @package AccessPress
 */

/**
 * Handles the registration and management of orders.
 *
 * This class handles the registration of the 'acp-orders' Custom Post Type, which stores
 * all orders made with AccessPress. It also allows you to manage, edit, and (if need be) delete
 * orders made through AccessPress.
 *
 * It uses the post meta API (custom fields) to store most of the order information, such as:
 * - Order date/time
 * - Expiration Date (gets updated when renewed)
 * - Renewals
 * - Order status
 * - Product(s) purchased (by product ID)
 * - Purchaser information (by member ID)
 * - Authorize.net transaction ID
 * - PayPal transaction ID
 * - Price paid
 * - Coupons used
 *
 * The Order Name is the post title.
 * The Order ID is the numerical post ID.
 *
 * @since 0.1.0
 */
class AccessPress_Orders {
	
	/** Constructor */
	function __construct() {
		
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'save_post', array( $this, 'metabox_save' ), 1, 2 );
		add_filter( 'manage_edit-acp-orders_columns', array( $this, 'columns_filter' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		
	}
	/**
	 * Initialize the class
	 */
	function init() {

		$this->register_post_type();

		if ( ! isset( $_GET['action'] ) || 'renew' != $_GET['action'] )
			return;

		if ( ! isset( $_GET['subscription'] ) || ! isset( $_GET['key'] ) || ! wp_verify_nonce( $_GET['key'], 'renew-subscription-' . $_GET['subscription'] ) )
			return;

		$this->renew_subscription( $_GET['subscription'] );

	}
	/**
	 * Register the Orders post type
	 */
	function register_post_type() {
		
			$labels = array(
				'name'=> __( 'Orders', 'premise' ),
				'singular_name'      => __( 'Order', 'premise' ),
				'add_new'            => '',
				'add_new_item'       => '',
				'edit'               => __( 'View Order', 'premise' ),
				'edit_item'          => __( 'View Order', 'premise' ),
				'new_item'           => '',
				'view'               => '',
				'view_item'          => '',
				'search_items'       => __( 'Search Orders', 'premise' ),
				'not_found'          => __( 'No Orders found', 'premise' ),
				'not_found_in_trash' => __( 'No Orders found in Trash', 'premise' )
			);

		if ( current_user_can( 'manage_options' ) ) {

			register_post_type( 'acp-orders',
				array(
					'labels' => $labels,
					'exclude_from_search'  => true,
					'public'               => false,
					'publicly_queryable'   => false,
					'query_var'            => true,
					'register_meta_box_cb' => array( &$this, 'metaboxes' ),
					'rewrite'              => false,
					'show_in_menu'         => 'premise-member',
					'show_ui'              => true,
					'supports'             => array( '' ),
				)
			);

		} else {

			register_post_type( 'acp-orders',
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
	 * Check for subscription renewal
	 */
	function renew_subscription( $order_id, $die = true ) {

		$product_id = get_post_meta( $order_id, '_acp_order_product_id', true );
		if ( ! $product_id )
			return false;

		$coupon_id = get_post_meta( $order_id, '_acp_order_member_id', true );
		$order_details = array(
			'_acp_order_member_id' => get_post_meta( $order_id, '_acp_order_member_id', true ),
			'_acp_order_product_id' => $product_id,
			'_acp_order_price' => AccessPress_Products::get_product_price( $product_id, $coupon_id ),
			'_acp_order_time' => get_post_meta( $order_id, '_acp_order_time', true ),
			'_acp_order_renewal_time' => get_post_meta( $order_id, '_acp_order_renewal_time', true ),
		);

		$gateway = self::find_gateway( $order_id );
		if ( ! $gateway )
			return new WP_Error( 'no_gateway', __( 'No gateway configured for order', 'premise' ) );

		$args = array(
			'product_id' => $product_id,
			'order_details' => $order_details,
			'cc_profile_id' => get_user_option( "memberaccess_{$gateway->payment_method}_profile_id", $order_details['_acp_order_member_id'] ),
			'cc_payment_profile_id' => get_user_option( "memberaccess_{$gateway->payment_method}_payment_{$product_id}", $order_details['_acp_order_member_id'] ),
		);

		$result = $gateway->process_order( $args );

		if ( is_wp_error( $result ) ) {

			if ( $die )
				wp_die( $result->get_error_message() );

			return $result;

		}

		// update payment list on limited recurring payments
		$number_payments = get_post_meta( $product_id, '_acp_product_number_payments', true );
		if ( $number_payments ) {

			$payments = get_post_meta( $order_id, '_acp_order_payments', true );
			if ( empty( $payments ) )
				$payments = array();

			$payments[time()] = $order_details['_acp_order_price'];
			$result['_acp_order_payments'] = $payments;

			if ( count( $payments ) >= $number_payments )
				unset( $result['_acp_order_renewal_time'] );
		}

		foreach( array( '_acp_order_price', '_acp_order_renewal_time', '_acp_order_anet_transaction_id', '_acp_order_payments' ) as $key ) {

			if ( isset( $result[$key] ) )
				update_post_meta( $order_id, $key, $result[$key] );
			else
				delete_post_meta( $order_id, $key );

		}

		/** this is ugly but it's in a new window, so user still has original window */
		if ( $die )
			die( __( 'Subscription renewed. You can close the window.', 'premise' ) );

		return $args;

	}
	/**
	 * Check for subscription renewal
	 */
	function cancel_subscription( $order_id, $die = true ) {

		$product_id = get_post_meta( $order_id, '_acp_order_product_id', true );
		$member_id = get_post_meta( $order_id, '_acp_order_member_id', true );
		if ( ! $product_id || ! $member_id )
			return false;

		$gateway = self::find_gateway( $order_id );
		if ( ! $gateway )
			return new WP_Error( 'no_gateway', __( 'No gateway configured for order', 'premise' ) );

		if ( ! $gateway->member_can_cancel() )
			return false;

		$result = $gateway->cancel( compact( 'order_id', 'member_id', 'product_id' ) );

		if ( is_wp_error( $result ) ) {

			if ( $die )
				wp_die( $result->get_error_message() );

		}

		do_action( 'premise_cancel_subscription', $order_id, $product_id, $member_id, $result );

		return $result;

	}
	/**
	 * Register the metaboxes
	 */
	function metaboxes() {
		
		add_meta_box( 'accesspress-order-details-metabox', __( 'Order Details', 'premise' ), array( $this, 'details_metabox' ), 'acp-orders', 'normal' );
		add_meta_box( 'accesspress-order-status-metabox', __( 'Status', 'premise' ), 'premise_custom_post_status_metabox', 'acp-orders', 'side', 'high' );
		remove_meta_box( 'submitdiv', null, 'side' );
		
	}
	
	function details_metabox( $post ) {

		wp_nonce_field( plugin_basename( __FILE__ ), 'accesspress-orders-nonce' );

		/** check for comp order & populate */
		if ( empty( $post->post_name ) && isset( $_GET['member'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce(  $_GET['_wpnonce'], 'comp-product-' .  $_GET['member'] ) ) {

			$anet_id = '';
			$product_id = '';
			$member_id = (int) $_GET['member'];
			$order_time = time();
			$renewal_time = '';
			$status = __( 'complimentary', 'premise' );

			/** add hidden fields */
			foreach( array(
				'post_title' => $order_time,
				'accesspress_order_meta[_acp_order_time]' => $order_time,
				'accesspress_order_meta[_acp_order_member_id]' => $member_id,
				'accesspress_order_meta[_acp_order_status]' => $status,
				'accesspress_order_meta[_acp_order_complimentary]' => '1'
			) as $name => $value ) {

				printf( '<input type="hidden" name="%s" value="%s" />', esc_attr( $name ), esc_attr( $value ) );

			}
		} else {

			$anet_id = accesspress_get_custom_field( '_acp_order_anet_transaction_id' );
			$member_id = accesspress_get_custom_field( '_acp_order_member_id' );
			$product_id = accesspress_get_custom_field( '_acp_order_product_id' );
			$order_time = accesspress_get_custom_field( '_acp_order_time' );
			$renewal_time = accesspress_get_custom_field( '_acp_order_renewal_time' );
			$status = accesspress_get_custom_field( '_acp_order_status' );
			$product = get_post( $product_id );

		}

		printf( '<p><b>%s</b>: %s</p>', __( 'Order Date', 'premise' ), date_i18n( 'F j, Y', $order_time ) );
		printf( '<p><b>%s</b>: %s</p>', __( 'Order Time', 'premise' ), date_i18n( 'G:i A', $order_time ) );
		printf( '<p><b>%s</b>: %s</p>', __( 'Renewal Date', 'premise' ), $renewal_time ? date_i18n( 'F j, Y', $renewal_time ) : __( 'N/A', 'premise' ) );
		printf( '<p><b>%s</b>: %s</p>', __( 'Status', 'premise' ), $status );

		$member = get_user_by( 'id', $member_id );
		$cancel_status = __( 'cancel', 'premise' );
		$gateway = self::find_gateway( $post->ID );

		if ( $gateway && $gateway->member_can_cancel() && $renewal_time && $status != $cancel_status ) {
?>
		<p>
			<input type="checkbox" name="accesspress_order_meta[_acp_order_status]" id="accesspress_order_meta[_acp_order_status]" value="<?php echo $cancel_status; ?>" />
			<label for="accesspress_order_meta[_acp_order_status]"><b><?php _e( 'Cancel subscription', 'premise' ); ?></b></label>
			<br />
			<span class="description"><?php _e( 'Once a subscription is cancelled, it can only be recreated by your member.', 'premise' ); ?></span>
		</p>
<?php
		}

		if ( $product_id )
			printf( '<p><b>%s</b>: <a href="%s">%s</a></p>', __( 'Product', 'premise' ), add_query_arg( array( 'post' => $product->ID, 'action' => 'edit' ), admin_url( 'post.php' ) ), $product->post_title );
		else
			printf( '<p><b>%s</b>: %s</p>', __( 'Product', 'premise' ), __( 'None', 'premise' ) );
?>
		<p>
			<label for="accesspress_order_meta[_acp_order_product_id]"><b><?php _e( 'Change Product', 'premise' ); ?></b>:
			</label><input type="text" name="accesspress_order_meta[_acp_order_product_id]" id="accesspress_order_meta[_acp_order_product_id]" value="" />
			<br />
			<span class="description"><?php _e( 'Enter a Product ID or Product Name to change the product the member has access to.', 'premise' ); ?></span>
		</p>
<?php
		printf( '<p><b>%s</b>: <a href="%s">%s - %s %s</a></p>', __( 'Member', 'premise' ), add_query_arg( array( 'user_id' => $member->ID ), admin_url( 'user-edit.php' ) ), $member->user_login, $member->first_name, $member->last_name );

		if ( $gateway )
			$gateway->show_order_transaction_meta( $post->ID );

		printf( '<p><b>%s</b>: $%s</p>', __( 'Price', 'premise' ), accesspress_get_custom_field( '_acp_order_price' ) );
	}

	
	/**
	 * Save the form data from the metaboxes
	 */
	function metabox_save( $post_id, $post ) {

		global $memberaccess_products_object;
		
		/**	Verify the nonce */
		if ( ! isset( $_POST['accesspress-orders-nonce'] ) || ! wp_verify_nonce( $_POST['accesspress-orders-nonce'], plugin_basename( __FILE__ ) ) )
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

		/** Merge defaults with user submission */
		$values = wp_parse_args( $_POST['accesspress_order_meta'], array(
			'_acp_order_time'			=> '',
			'_acp_order_status'			=> '',
			'_acp_order_product_id'			=> '',
			'_acp_order_member_id'			=> '',
			'_acp_order_complimentary'		=> '',
#			'_acp_order_coupon_id'                => '' /** not yet */
		) );

		if ( $values['_acp_order_product_id'] ) {

			if ( (int) $values['_acp_order_product_id'] ) {

				$product = get_post( $values['_acp_order_product_id'] );
				if ( empty( $product ) || 'acp-products' != $product->post_type )
					$product = false;

			}

			if ( ! $product ) {

				$products = new WP_query( array( 'post_type' => 'acp-products', 'name' => $values['_acp_order_product_id'] ) );
				if ( $products->have_posts() ) {

					$products->the_post();
					$values['_acp_order_product_id'] = get_the_ID();

				} else {

					$values['_acp_order_product_id'] = '';

				}
				wp_reset_query();
			}
		}

		/** Sanitize */
		$values = $this->sanitize( $values );

		/** simulate checkout on comp order */
		if ( $values['_acp_order_complimentary'] ) {

			$user = get_user_by( 'id', $values['_acp_order_member_id'] );
			if ( ! empty( $user ) ) {

				$user_data = get_object_vars( $user->data );
				do_action( 'premise_create_member', $values['_acp_order_member_id'], $user_data );

				// don't send the comp'ed user a receipt
				remove_action( 'premise_membership_create_order', array( $memberaccess_products_object, 'email_purchase_notification' ), 10, 2 );
				do_action( 'premise_membership_create_order', $values['_acp_order_member_id'], $values, false );

			}

		}

		unset( $values['_acp_order_complimentary'] );

		/** Check for admin cancel */
		if ( $values['_acp_order_status'] == __( 'cancel', 'premise' ) )
			$result = self::cancel_subscription( $post_id /*, false */ );
//@todo: add error handling

		/** Loop through values, update post meta */
		$meta_update = false;
		foreach ( (array) $values as $key => $value ) {

			if ( $value ) {

				update_post_meta( $post->ID, $key, $value );
				$meta_update = true;

			}

		}

		if ( $meta_update )
			memberaccess_add_order_to_member ( $values['_acp_order_member_id'], $post->ID );

		
	}

	/**
	 * Filter the columns in the "Orders" screen, define our own.
	 */
	function columns_filter ( $columns ) {

		$date_column = array( 'date' => $columns['date'] );
		unset( $columns['date'] );
		$new_columns = array(
			'member_name'		=> __( 'Member', 'premise' ),
			'member_product'	=> __( 'Product', 'premise' ),
			'member_discount'	=> __( 'Discount', 'premise' ),
			'access_level'		=> __( 'Access Levels', 'premise' )
		);

		return array_merge( $columns, $new_columns, $date_column );

	}

	/**
	 * Filter the data that shows up in the columns in the "Orders" screen, define our own.
	 */
	function columns_data( $column ) {

		global $post;

		if ( 'acp-orders' != $post->post_type )
			return;

		switch( $column ) {
			case 'member_name':
				$member_id = accesspress_get_custom_field( '_acp_order_member_id' );
				$member = get_user_by( 'id', $member_id );
				if ( ! $member )
					break;

				printf( __( '<p><a href="%s">%s - %s %s</a></p>', 'premise' ), add_query_arg( array( 'user_id' => $member->ID ), admin_url( 'user-edit.php' ) ), $member->user_login, $member->first_name, $member->last_name );
				break;
			case 'member_product':
				$product_id = accesspress_get_custom_field( '_acp_order_product_id' );
				$product = get_post( $product_id );
				if ( ! $product )
					break;

				printf( __( '<p><a href="%s">%s</a></p>', 'premise' ), add_query_arg( array( 'post' => $product->ID, 'action' => 'edit' ), admin_url( 'post.php' ) ), $product->post_title );
				break;
			case 'member_discount':
				$coupon_id = accesspress_get_custom_field( '_acp_order_coupon_id' );
				$coupon = get_post( $coupon_id );
				if ( ! $coupon )
					break;

				$percentage = 'percent' == get_post_meta( $coupon_id, '_acp_coupon_type', true );
				$format = $percentage ? __( '%d%%', 'premise' ) : __( '$ %.2f', 'premise' );
				$discount = get_post_meta( $coupon_id, $percentage ? '_acp_coupon_percent' : '_acp_coupon_flat', true );

				printf( __( '<p><a href="%s">' . $format . '</a></p>', 'premise' ), add_query_arg( array( 'post' => $coupon->ID, 'action' => 'edit' ), admin_url( 'post.php' ) ), $discount );
				break;
			case 'access_level':
				$product_id = accesspress_get_custom_field( '_acp_order_product_id' );
				$product = get_post( $product_id );
				if ( ! $product )
					break;

				echo memberaccess_get_accesslevel_list( $product->ID );
				break;
		}

	}
	/**
	 * custom messages for the coupon post type
	 *
	 * @since 2.2.0
	 *
	 * @returns array
	 */
	function post_updated_messages( $messages ) {
		$messages['acp-orders'] = array(
			 1 => __( 'Order updated.', 'premise' ),
			 4 => __('Order updated.', 'premise' ),
			 6 => __( 'Order published.', 'premise' ),
			 7 => __( 'Order saved.', 'premise' ),
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

	function find_gateway( $order_id ) {

		global $memberaccess_payment_gateways;

		foreach( $memberaccess_payment_gateways as $gateway ) {

			if ( $gateway->has_transaction_meta( $order_id ) )
				return $gateway;

		}
		return null;
	}
}