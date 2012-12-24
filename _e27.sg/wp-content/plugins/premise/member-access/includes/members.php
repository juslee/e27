<?php
/**
 * This file controls the member access control system in AccessPress.
 *
 * MemberAccess uses a custom user Role to segregate members from other users.
 * The custom role is assigned to members upon successful signup, and an access
 * level is assigned to their user meta, depending on what product they purchased.
 *
 * @package Premise
 */


/**
 * Add our master role, "Premise Member".
 *
 * @since 0.1.0
 */
function accesspress_create_role() {

	if ( get_role( 'premise_member' ) )
		return;

	add_role(
		'premise_member',
		__( 'Premise Member', 'premise' ),
		array(
			'access_membership' => true
		) 
	);
	
}

/**
 * Helper function to insert user into the Users table.
 *
 * Accepts same arguments as the WordPress function wp_insert_user()
 * @link http://xref.yoast.com/trunk/_functions/wp_insert_user.html
 *
 * @since 0.1.0
 *
 */
function accesspress_create_member( $userdata = array() ) {
	
	$userdata['role'] = 'premise_member';
	if ( ! isset( $userdata['show_admin_bar_front'] ) )
		$userdata['show_admin_bar_front'] = 'false';
	
	$result = wp_insert_user( $userdata );
	
	do_action( 'premise_create_member', $result, $userdata );
	
	return $result;
	
}

function memberaccess_checkout_css() {
?>
<style type="text/css">
.premise-checkout-wrap .accesspress-checkout-form-account,
.premise-checkout-wrap .accesspress-checkout-form-payment-method,
.premise-checkout-wrap .accesspress-checkout-form-cc {
	margin-bottom: 40px;
}
.premise-checkout-wrap .accesspress-checkout-form-row {
	clear: both;
}
.premise-checkout-wrap .checkout-text-label {
	display: block;
	float: left;
	padding: 6px 0;
	width: 135px;
}
.premise-checkout-wrap .accesspress-checkout-form-row {
	margin-bottom: 10px;
}
.premise-checkout-wrap .input-text {
	background: #f5f5f5;
	border: 1px solid #ddd;
	padding: 5px;
}
.premise-checkout-wrap .checkout-radio {
	margin-left: 140px;
}
.accesspress-checkout-form-payment-method input[type=radio] {
	vertical-align: top;
}
.premise-checkout-wrap .input-submit {
	background-color: #666;
	border: 0;
	color: #fff;
	cursor: pointer;
	padding: 8px 10px;
}
.premise-checkout-wrap .input-submit:hover {
	background-color: #333;
}
.premise-checkout-lookup {
	clear: left;
}
</style>
<?php
}

/** from wp-login.php */
function memberaccess_ssl_redirect() {

	if ( 0 === strpos( $_SERVER['REQUEST_URI'], 'http' ) )
		wp_redirect( preg_replace( '|^http://|', 'https://', $_SERVER['REQUEST_URI'] ) );
	else
		wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

	exit();

}

function memberaccess_is_page( $page_id ) {

	global $premise_base;

	if ( is_page( $page_id ) )
		return true;

	if ( ! $premise_base->is_premise_post_type() )
		return false;

	return in_array( get_queried_object_id(), (array) $page_id );

}

add_action( 'wp', 'accesspress_process_link' );
/**
 * 
 */
function accesspress_process_link() {
	
	if ( ! isset( $_REQUEST['download_id'] ) )
		return;
	
	$links = get_posts( array( 'post_type' => 'acp-links', 'meta_key' => '_acp_link_id', 'meta_value' => $_REQUEST['download_id'] ) );
	
	/** If invalid link ID, die. */
	if ( ! $links )
		die( 'Not a valid Download ID.' );
	
	/** If user isn't logged in, redirect to login page */
	if ( ! is_user_logged_in() ) {

		$redirect_back_to = esc_url_raw( home_url( sprintf( '/?download_id=%s', $_REQUEST['download_id'] ) ) );
		$redirect = add_query_arg( 'redirect_to', $redirect_back_to, get_permalink( accesspress_get_option( 'login_page' ) ) );
		wp_redirect( $redirect );
		exit;

	}
	
	/** First link in the array */	
	$link = $links[0];
	
	/** Get all access levels assigned to this link */
	$access_levels = wp_get_post_terms( $link->ID, 'acp-access-level' );
	
	/** Start with determining if they are a site admin */
	$access = current_user_can( 'manage_options' );
	
	foreach ( (array) $access_levels as $access_level ) {
		if ( member_has_access_level( $access_level->slug, 0, get_post_meta( $link->ID, '_acp_link_delay', true ) ) )
			$access = true;
	}
	
	/** If they don't have access, deny. */
	if ( ! $access ) {
		header('HTTP/1.1 403 Forbidden');
		die('You do not have access to that file.');
	}
	
	/** Upload directory location */
	$upload_dir = wp_upload_dir();
	
	/** Build the full path to the file */
	$file = trailingslashit( $upload_dir['basedir'] . '/' . trim( accesspress_get_option( 'uploads_dir' ), '/' ) ) . get_post_meta( $link->ID, '_acp_link_filename', true );

	/** If file doesn't exist, die */
	if ( ! file_exists( $file ) )
		die( 'File not found' );
	
	/** Deliver the file */	
	header( 'Content-Type: application/octet-stream' );
	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename="' . basename( $file ) . '"' );
	readfile( $file );
	exit;
	
}

add_action( 'init', 'premise_admin_redirect_member' );

function premise_admin_redirect_member() {

	if ( is_admin() && is_user_logged_in() && ! current_user_can( 'read' ) ) {
		wp_redirect( home_url() );
		exit;
	}

}

add_filter( 'manage_users_columns', 'memberaccess_manage_users_columns' );

function memberaccess_manage_users_columns( $columns ) {

	$columns['member-access'] = __( 'Access Levels', 'premise' );
	return $columns;

}

add_filter( 'manage_users_custom_column', 'memberaccess_manage_users_custom_column', 1, 3 );

function memberaccess_manage_users_custom_column( $content, $column_name, $user_id ) {

	if( $column_name != 'member-access' )
		return;

	$terms = get_terms( 'acp-access-level', array( 'hide_empty' => false ) );

	if ( ! $terms )
		return '';

	$output = '';

	foreach ( (array) $terms as $term ) {

		if ( ! member_has_access_level( $term->term_id, $user_id ) )
			continue;

		$output .= esc_html( $term->name ) . '<br />';

	}

	return $output;

}

add_action( 'template_redirect', 'memberaccess_location_check', 1 );

function memberaccess_location_check() {

	$checkout_page = accesspress_get_option( 'checkout_page' );
	/** check for ssl */
	if ( ! is_ssl() ) {

		if ( accesspress_get_option( 'ssl_everywhere' ) )
			memberaccess_ssl_redirect();

		if ( $checkout_page && accesspress_get_option( 'ssl_checkout' ) && memberaccess_is_page( $checkout_page ) )
			memberaccess_ssl_redirect();

		$login_page = accesspress_get_option( 'login_page' );
		if ( $login_page && force_ssl_login() && memberaccess_is_page( $login_page ) )
			memberaccess_ssl_redirect();

	}

	$member_page = accesspress_get_option( 'member_page' );
	if ( ! $checkout_page && ! $member_page )
		return;

	if ( memberaccess_is_page( array( $checkout_page, $member_page ) ) )
		add_action( 'wp_head', 'memberaccess_checkout_css', 99 );

}

add_filter( 'user_row_actions', 'memberaccess_user_row_actions', 10, 2 );

function memberaccess_user_row_actions( $actions, $user ) {

	$actions['member_comp'] = sprintf( '<br /><a href="%s">%s</a>', wp_nonce_url( add_query_arg( array( 'post_type' => 'acp-orders', 'member' => $user->ID ), admin_url( 'post-new.php' ) ), 'comp-product-' . $user->ID, true, false ), __( 'Complimentary Product', 'premise' ) );
	return $actions;

}
add_action( 'init', 'memberaccess_profile_update' );

function memberaccess_profile_update() {

	$user = wp_get_current_user();
	$nonce_key = 'premise-member-profile-' . $user->ID;

	if ( empty( $_POST['accesspress-checkout']['member-key'] ) || ! wp_verify_nonce( $_POST['accesspress-checkout']['member-key'], $nonce_key ) )
		return;

	$user_data = stripslashes_deep( $_POST['accesspress-checkout'] );
	$user_changes = array( 'ID' => $user->ID );

	if ( $user_data['first-name'] != $user->first_name )
		$user_changes['first_name'] = $user_data['first-name'];

	if ( $user_data['last-name'] != $user->last_name )
		$user_changes['last_name'] = $user_data['last-name'];

	if ( ! empty( $user_data['password'] ) ) {

		if ( empty( $user_data['password-repeat'] ) || $user_data['password'] != $user_data['password-repeat'] )
			_e( '<strong>Passwords did not match. Your password was not changed.</strong>', 'premise' );
		else
			$user_changes['user_pass'] = $user_data['password'];

	}

	if ( ! empty( $user_data['email'] ) && is_email( $user_data['email'] ) )
		$user_changes['user_email'] = $user_data['email'];


	if ( count( $user_changes ) > 1 )
		wp_update_user( $user_changes );

	// if we change the password the user needs to log in again
	if ( isset( $user_changes['user_pass'] ) ) {

		wp_redirect( add_query_arg( array( 'password-changed' => 'true' ), get_permalink( accesspress_get_option( 'member_page' ) ) ) );
		exit;

	}

}

add_filter( 'upload_dir', 'memberaccess_ssl_upload_dir' );

function memberaccess_ssl_upload_dir( $uploads ) {

	$ssl_checkout = accesspress_get_option( 'ssl_checkout' ) && memberaccess_is_page( accesspress_get_option( 'checkout_page' ) );
	if ( ! $ssl_checkout && ! accesspress_get_option( 'ssl_everywhere' ) )
		return $uploads;

	foreach( array( 'url', 'baseurl' ) as $key )
		$uploads[$key] = preg_replace( '|^http://|', 'https://', $uploads[$key] );

	return $uploads;
}

add_action( 'wp_ajax_nopriv_premise_checkout_lookup', 'memberaccess_checkout_lookup' );

function memberaccess_checkout_lookup() {

	$args = wp_parse_args( $_POST, array(
		'username' => '',
		'email' =>  '',
		'product' =>  '',
		'auth' =>  ''

	) );

	if ( ! wp_verify_nonce( $args['auth'], 'checkout-lookup-' . $args['product'] ) || get_user_by( 'login', $args['username'] ) || get_user_by( 'email', $args['email'] ) )
		echo '1';
	else
		echo '0';

	exit;

}