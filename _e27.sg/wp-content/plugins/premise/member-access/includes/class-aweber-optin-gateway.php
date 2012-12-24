<?php
/**
 * Optin gateway class to configure and process Optin gateways.
 *
 * This class allows payment via optin.
 *
 * @since 0.1.0
 */
class MemberAccess_AWeber_Optin_Gateway extends MemberAccess_Gateway {
	/**
	 * The user data submitted with the optin form.
	 *
	 * @since 0.1.0
	 *
	 * @var array of user data
	 */
	private $_user_data;

	/**
	 * The Premise meta for the current landing page.
	 *
	 * @since 0.1.0
	 *
	 * @var array of landing page meta
	 */
	private $_premise_meta;

	/**
	 * Class constructor.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

	 	$this->create( 'aweber' );

	}
	/**
	 * Initialize the payment gateway.
	 *
	 * @since 0.1.0
	 */
	public function configure() {

		add_action( 'premise_optin_signup_extra_fields', array( $this, 'optin_extra_fields' ) );
		add_filter( 'premise_optin_extra_fields_errors', array( $this, 'validate_optin_extra_fields' ) );
		add_filter( 'premise_optin_subscribe_user', array( $this, 'register_user' ), 10, 3 );
		add_action( 'premise_optin_complete_order', array( $this, 'complete_order' ) );
		add_action( 'premise_membership_create_order', array( $this, 'subscribe_customer' ), 10, 2 );
		add_action( 'premise_cancel_subscription', array( $this, 'unsubscribe_customer' ), 10, 3 );

		// product post type hooks
		add_filter( 'memberaccess_default_product_meta', array( $this, 'add_default_product_meta' ) );

		add_action( 'admin_menu', array( $this, 'add_metabox' ) );

		// never show this gateway on the checkout form
		return false;

	}

	function add_metabox() {

		add_meta_box( 'accesspress-product-aweber-metabox', __( 'AWeber', 'premise' ), array( $this, 'product_metabox' ), 'acp-products', 'normal', 'low' );

	}

	function product_metabox() {

		global $Premise;
		$lists = $Premise->getAweberLists();

		if ( empty( $lists ) ) {
			_e( 'No AWeber lists found.', 'premise' );
			return;
		}
		?>
		<p>
			<label for="accesspress_product_meta[_acp_product_aweber_list]"><strong><?php _e( 'AWeber List', 'premise' ); ?></strong>:
			<select name="accesspress_product_meta[_acp_product_aweber_list]">
				<option value=""><?php _e( 'None', 'premise' ); ?></option>
		<?php

		foreach( $lists as $list )
			printf( '<option value="%s" %s>%s</option>', $list['id'], selected( accesspress_get_custom_field( '_acp_product_aweber_list' ), $list['id'], false ), $list['name'] );

		?>
			</select>
		</p>
		<?php
	}

	public function optin_extra_fields( $type = '' ) {

		global $premise_base, $post;
		$meta = $premise_base->get_premise_meta( $post->ID );

		if ( empty( $meta['member-product'] ) )
			return;

		if ( ! empty( $meta['member-product'] ) ) {

			printf( '<input type="hidden" name="premise-product-id" value="%d" />', $meta['member-product'] );
			printf( '<input type="hidden" name="premise-landing-id" value="%d" />', $post->ID );
			printf( '<input type="hidden" name="premise-product-key" value="%s" />', wp_create_nonce( 'premise-product-key-' . $meta['member-product'] . '-' . $post->ID ) );

		}
	}
	function validate_optin_extra_fields( $errors ) {

		global $premise_base;

		if ( empty( $_POST['premise-product-id'] ) || empty( $_POST['premise-product-key'] ) || empty( $_POST['premise-landing-id'] ) )
			return;

		if ( ! wp_verify_nonce( $_POST['premise-product-key'], 'premise-product-key-' . $_POST['premise-product-id'] . '-' . $_POST['premise-landing-id'] ) )
			return;

		$this->_product_id = (int) $_POST['premise-product-id'];

		$errors = array();
		$args = empty( $_POST['accesspress-checkout'] ) ? array() : $_POST['accesspress-checkout'];
		$args = wp_parse_args( $args, array(
				'username' => '',
				'first-name' => '',
				'last-name' => '',
				'password' => '',
				'password-repeat' => '',
			)
		);

		$this->_premise_meta = $premise_base->get_premise_meta( $_POST['premise-landing-id'] );

		if ( ( empty( $this->_premise_meta['member-merge-first-name'] ) && ! $args['first-name'] ) || ( empty( $this->_premise_meta['member-merge-last-name'] ) && ! $args['last-name'] ) || ! $args['username'] || ! $args['password'] || ! $args['password-repeat']  )
			$errors[] = __( 'The account information was not filled out.', 'premise' );

		/** If passwords do not match */
		if ( $args['password'] !== $args['password-repeat'] )
			$errors[] = __( 'The passwords do not match.', 'premise' );

		if ( empty( $errors ) )
			$this->_member_args = $args;

		return $errors;

	}

	function add_default_product_meta( $defaults ) {

		$defaults['_acp_product_mailchimp_email'] = '';
		$defaults['_acp_product_mailchimp_first-name'] = '';
		$defaults['_acp_product_mailchimp_last-name'] = '';
		$defaults['_acp_product_mailchimp_list'] = '';
		return $defaults;

	}

	public function register_user( $setting, $args, $optin_gateway = null ) {

		if ( empty( $this->_product_id ) || ! $this->_product_id || $optin_gateway != 'aweber' )
			return;

		$product = get_post( $this->_product_id );
		if ( ! $product || empty( $product->post_type ) || $product->post_type != 'acp-products' )
			return new WP_Error( 'product_missing', __( 'Product information missing', 'premise' ) );

		// eliminate case mismatches
		$userdata = array(
			'first_name' => empty( $this->_premise_meta['member-merge-first-name'] ) ? $this->_member_args['first-name'] : $optin_vars[strtolower( $this->_premise_meta['member-merge-first-name'] )],
			'last_name'  => empty( $this->_premise_meta['member-merge-last-name'] ) ? $this->_member_args['last-name'] : $optin_vars[strtolower( $this->_premise_meta['member-merge-last-name'] )],
			'user_email' => empty( $this->_premise_meta['member-merge-email'] ) ? '' : $optin_vars[strtolower( $this->_premise_meta['member-merge-email'] )],
			'user_login' => $this->_member_args['username'],
			'user_pass'  => $this->_member_args['password'],
		);

		return accesspress_create_member( $userdata );

	}
	public function complete_order( $member ) {

		if ( empty( $this->_product_id ) || ! $member )
			return;

		$order_details = array(
			'_acp_order_time'       => time(),
			'_acp_order_status'     => 'complete',
			'_acp_order_product_id' => $this->_product_id,
			'_acp_order_member_id' => $member,
		);
		accesspress_create_order( $member, $order_details );

	}
	public function _process_order( $args ) {}
	/**
	 * Member can cancel flag.
	 *
	 * MailChimp isn't for subscriptions
	 *
	 * @return bool false
	 * @since 2.1
	 */
	public function member_can_cancel() {

		return false;

	}

	function subscribe_customer( $member, $order_details ) {

		$product_id = isset( $order_details['_acp_order_product_id'] ) ? $order_details['_acp_order_product_id'] : 0;
		$user = get_user_by( 'id', $member );
		if ( ! $product_id || ! $user )
			return;

		$list_id = get_post_meta( $product_id, '_acp_product_mailchimp_list', true );
		if ( ! $list_id )
			return;

		$merge_vars = array();
		foreach( array( 'email' => 'user_email', 'first-name' => 'first_name', 'last-name' => 'last_name' ) as $field => $user_field ) {

			$merge_field = get_post_meta( $product_id, '_acp_product_mailchimp_' . $field, true );
			if ( ! $merge_field )
				continue;

			if ( $field == 'email' )
				$merge_vars[$merge_field] = $user->$user_field;
			else
				$merge_vars[$merge_field] = get_user_meta( $user->ID, $user_field, true );

		}

		if ( empty( $merge_vars ) )
			return;

		require_once( PREMISE_LIB_DIR . 'theme/class-theme.php' );
		Premise_Theme::signup_mailchimp_user( $merge_vars, $list_id );

	}

	function unsubscribe_customer( $order_id, $product_id, $member ) {

		$user = get_user_by( 'id', $member );
		if ( ! $product_id || ! $user )
			return;

		$list_id = get_post_meta( $product_id, '_acp_product_mailchimp_list', true );
		if ( ! $list_id )
			return;

		require_once( PREMISE_LIB_DIR . 'theme/class-theme.php' );
		$x = Premise_Theme::unsubscribe_mailchimp_user( $user->user_email, $list_id );

	}
}

add_action( 'memberaccess_setup', 'premise_register_aweber_optin_gateway' );

function premise_register_aweber_optin_gateway() {

	memberaccess_register_payment_gateway( 'MemberAccess_AWeber_Optin_Gateway' );

}
