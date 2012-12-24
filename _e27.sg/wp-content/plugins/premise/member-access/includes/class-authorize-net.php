<?php
/**
 * Authorize.net gateway class to configure and process payment gateways.
 *
 * This class uses the CIM api.
 *
 * @since 0.1.0
 */
class MemberAccess_AuthorizeNet_Gateway extends MemberAccess_Gateway {
	/**
	 * The Authorize.net merchant authentication block.
	 *
	 * @since 0.1.0
	 *
	 * @var string XML CIM merchant authentication block
	 */
	private $_merchant_login;

	/**
	 * The Authorize.net gateway URI.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	private $_gateway_uri;

	/**
	 * The Authorize.net gateway mode.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	private $_gateway_mode;

	/**
	 * Class constructor.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

	 	$this->create( 'cc', __( 'Credit Card', 'premise' ) );

	}
	/**
	 * Initialize the payment gateway.
	 *
	 * @since 0.1.0
	 */
	public function configure() {

		$api_login = accesspress_get_option( 'authorize_net_id' );
		$transaction_key = accesspress_get_option( 'authorize_net_key' );

		// we need both an id & key to use the gateway
		if ( empty( $api_login ) || empty( $transaction_key ) )
			return false;

		$this->_gateway_uri = 'https://' . ( '1' == $this->mode( 'gateway_live_mode_authorize_net' ) ? 'api' : 'apitest' ) . '.authorize.net/xml/v1/request.api';
//		$this->_gateway_mode = '<validationMode>' . ( '1' == accesspress_get_option( 'gateway_live_mode' ) ? 'live' : 'test' ) . 'Mode</validationMode>';
		$this->_gateway_mode = '<validationMode>testMode</validationMode>';
		$this->_merchant_login = sprintf( '<merchantAuthentication><name>%s</name><transactionKey>%s</transactionKey></merchantAuthentication>', $api_login, $transaction_key );

		return true;

	}

	/**
	 * Handle the postback of the payment gateway form.
	 *
	 * @since 0.1.0
	 */
	public function _process_order( $args ) {

		// create local user
		$user_id = $args['order_details']['_acp_order_member_id'];
		$memberaccess_cc_profile_id = isset( $args['cc_profile_id'] ) ? $args['cc_profile_id'] : 0;
		$memberaccess_cc_payment_profile_id = isset( $args['cc_payment_profile_id'] ) ? $args['cc_payment_profile_id'] : 0;

		if ( empty( $memberaccess_cc_profile_id ) && is_user_logged_in() )
			$memberaccess_cc_profile_id = get_user_option( 'memberaccess_cc_profile_id' );

		/** for initial payment attempts only */
		if ( ! $memberaccess_cc_profile_id ) {

			if ( is_user_logged_in() && empty( $args['first-name'] ) && empty( $args['last-name'] ) ) {

				$user = get_user_by( 'id', $user_id );
				$args['first-name'] = $user->first_name;
				$args['last-name'] = $user->last_name;
				$args['email'] = $user->user_email;

			}

			// create member profile
			$customer_info = sprintf( '<merchantCustomerId>%d</merchantCustomerId><description>%s</description><email>%s</email>',
				$user_id,
				trim( $args['first-name'] . ' ' . $args['last-name'] ),
				$args['email']
			);

			if ( !( $response = $this->_send_request( 'createCustomerProfileRequest', '<profile>' . $customer_info . '</profile>' ) ) )
				return $this->response;

			$this->customer_response = $response;
			$memberaccess_cc_profile_id = (string)$response->customerProfileId;

		}

		$customer = sprintf( '<customerProfileId>%d</customerProfileId>', $memberaccess_cc_profile_id );
		/** for new subscriptions only */
		if ( ! $memberaccess_cc_payment_profile_id ) {

			// profile created now send billing info
			$bill_to = sprintf( '<billTo><firstName>%s</firstName><lastName>%s</lastName><zip>%s</zip><country>%s</country></billTo>',
				esc_html( $args['first-name'] ),
				esc_html( $args['last-name'] ),
				$args['card-postal'],
				$args['card-country']
			);
			$payment = sprintf( '<payment><creditCard><cardNumber>%s</cardNumber><expirationDate>%04d-%02d</expirationDate><cardCode>%s</cardCode></creditCard></payment>',
				$args['card-number'],
				$args['card-year'],
				$args['card-month'],
				$args['card-security']
			);
			$profile = '<paymentProfile>' . $bill_to . $payment . '</paymentProfile>';

			if ( !( $response = $this->_send_request( 'createCustomerPaymentProfileRequest', $customer . $profile . $this->_gateway_mode ) ) )
				return $this->response;

			$this->profile_response = $repsonse;
			$memberaccess_cc_payment_profile_id = (string)$response->customerPaymentProfileId;

		}

		// payment profile created now charge the account
		$product_post = get_post( $args['product_id'] );
		$args['order_details']['_acp_order_coupon_id'] = MemberAccess_Coupons::get_product_coupon( $args['product_id'] );
		$args['order_details']['_acp_order_price'] = AccessPress_Products::get_product_price( $args['product_id'], $args['order_details']['_acp_order_coupon_id'] );

		if ( empty( $args['order_details']['_acp_order_renewal_time'] ) ) {

			$trial_amount = AccessPress_Products::get_product_trial_price( $args['product_id'], $args['order_details']['_acp_order_coupon_id'] );
			if ( $trial_amount )
				$amount = sprintf( '<amount>%.2f</amount>', $trial_amount );

			$duration = $trial_duration = $this->_get_trial_duration( $args['product_id'] );

		}

		if ( empty( $amount ) || empty( $duration ) ) {

			$amount = sprintf( '<amount>%.2f</amount>', $args['order_details']['_acp_order_price'] );
			$duration = $this->get_subscription_duration( $args['product_id'] );

		}

		$recurring = $duration ? 'true' : 'false';
		$args['order_details']['order_title'] = time() . '-' . $user_id;
		$product_description = $product_post->post_title . ' (' . $args['order_details']['order_title'] . ')';
		$payment_profile = sprintf( '<customerPaymentProfileId>%d</customerPaymentProfileId><recurringBilling>%s</recurringBilling>', $memberaccess_cc_payment_profile_id, $recurring );
		$item = sprintf( '<lineItems><itemId>%s</itemId><name>%s</name><description>%s</description><quantity>1</quantity><unitPrice>%.2f</unitPrice><taxable>false</taxable></lineItems>',
			$args['product_id'] . '-' . time(),
			substr( $product_post->post_name, 0, 31 ),
			esc_html( $product_description ),
			! empty( $trial_amount ) && ! empty( $trial_duration ) ? $trial_amount : $args['order_details']['_acp_order_price']
		);

		if ( ! $duration || $trial_amount ) {

			$transaction = '<transaction><profileTransAuthCapture>' . $amount . $item . $customer . $payment_profile . '</profileTransAuthCapture></transaction>';
			if ( !( $response = $this->_send_request( 'createCustomerProfileTransactionRequest', $transaction ) ) )
				return $this->response;

		}

		// we made it - update the user meta
		if ( ! is_user_logged_in() )
			update_user_option( $user_id, 'memberaccess_cc_profile_id', $memberaccess_cc_profile_id );

		if ( $duration ) {

			$args['order_details']['_acp_order_renewal_time'] = ( ! empty( $args['order_details']['_acp_order_renewal_time'] ) ? $args['order_details']['_acp_order_renewal_time'] : $args['order_details']['_acp_order_time'] ) + ( $duration * 86400 );
			$args['order_details']['_acp_order_status'] = 'active';
			update_user_option( $user_id, 'memberaccess_cc_payment_' . $args['product_id'], $memberaccess_cc_payment_profile_id );

			$number_payments = get_post_meta( $args['product_id'], '_acp_product_number_payments', true );
			if ( (int) $number_payments )
				$args['order_details']['_acp_order_payments'] = $trial_amount ? array( $args['order_details']['_acp_order_time'] => $args['order_details']['_acp_order_price'] ) : array();

		}

		$direct_response = explode( ',', $response->directResponse );
		$sale_meta = $args['order_details'];
		$sale_meta['_acp_order_anet_transaction_id'] = $direct_response[6];

		return $sale_meta;

	}

	private function _send_request( $tag, $content ) {

		$request_body = '<?xml version="1.0" encoding="utf-8"?><' . $tag . ' xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">' . $this->_merchant_login . $content . '</' . $tag . '>';
		$response = wp_remote_post( $this->_gateway_uri, array( 'headers' => array( 'content-type' => 'text/xml' ), 'body' => $request_body, 'timeout' => 30 ) );

		if ( is_wp_error( $response ) ) {
			$this->response = $response;
			return false;
		}

		if ( empty( $response['body'] ) ) {
			$this->response = new WP_Error( 'cc-server', __( 'Invalid response from payment processor', 'premise' ) );
			return false;
		}

		$response = simplexml_load_string( $response['body'], 'SimpleXMLElement', LIBXML_NOWARNING );
		if ( $response->messages->resultCode == 'Error' ) {
			$this->response = new WP_Error( 'cc-error', (string) $response->messages->message->text );
			return false;
		}

		return $response;

	}

	function test() {

		return $this->_send_request( 'getCustomerProfileRequest', '<customerProfileId>1000</customerProfileId>' );

	}
	/**
	 * Validate checkout form.
	 *
	 * validate the credit card fields
	 *
	 * @since 2.1
	 */
	public function validate_checkout_form( $args ) {

		if ( ! $args['card-name'] || ! $args['card-number'] || ! $args['card-month'] || ! $args['card-year'] || ! $args['card-security'] || ! $args['card-country'] || ! $args['card-postal'] )
			return new WP_Error( 'credit_card_not_filled_out', 'The credit card info was not completed.' );

		return true;

	}
	/**
	 * show the transaction meta for an order.
	 *
	 * show transaction ID, customer profile ID and payment profile ID
	 *
	 * @since 2.2.0
	 */
	public function show_order_transaction_meta( $order_id ) {

			$member_id = get_post_meta( $order_id, '_acp_order_member_id', true );
			$product_id = get_post_meta( $order_id, '_acp_order_product_id', true );
			printf( '<p><b>%s</b>: %s</p>', __( 'Authorize.net Transaction ID', 'premise' ), get_post_meta( $order_id, '_acp_order_anet_transaction_id', true ) );
			printf( '<p><b>%s</b>: %s</p>', __( 'Authorize.net Profile ID', 'premise' ), get_user_option( 'memberaccess_cc_profile_id', $member_id ) );
			printf( '<p><b>%s</b>: %s</p>', __( 'Authorize.net Payment Profile ID', 'premise' ), get_user_option( 'memberaccess_cc_payment_' . $product_id, $member_id ) );

	}
	/**
	 * has the transaction meta for an order.
	 *
	 * returns bool 
	 *
	 * @since 2.2.0
	 */
	 function has_transaction_meta( $order_id ) {

		return get_post_meta( $order_id, '_acp_order_anet_transaction_id', true );

	}
}

add_action( 'memberaccess_setup', 'premise_register_authorize_net_gateway' );

function premise_register_authorize_net_gateway() {

	memberaccess_register_payment_gateway( 'MemberAccess_AuthorizeNet_Gateway' );

}