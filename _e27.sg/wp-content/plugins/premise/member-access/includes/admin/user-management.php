<?php
/*
Description: Advanced member management for Premise.
*/

add_action( 'personal_options', 'premise_member_remove_profile_fields' );

function premise_member_remove_profile_fields( $user_id ) {

	if ( user_can( $user_id, 'read' ) || ! user_can( $user_id, 'access_membership' ) )
		return;

	// unhook Genesis
	$hook = get_current_user_id() == $user_id ? 'edit_user_profile' : 'show_user_profile';
	remove_action( $hook, 'genesis_user_options_fields' );
	remove_action( $hook, 'genesis_user_archive_fields' );
	remove_action( $hook, 'genesis_user_seo_fields' );
	remove_action( $hook, 'genesis_user_layout_fields' );

	// hide unneeded profile fields
?>
<script type="text/javascript">
jQuery(document).ready(function() {
       jQuery('#profile-page table.form-table tr:has(#description, #rich_editing, #admin_color_classic, #comment_shortcuts, #admin_bar_front, #url, #aim, #yim, #jabber)').hide();
});
</script>
<?php
}

add_action( 'admin_menu', 'premise_member_add_member_menu_item', 999 );

function premise_member_add_member_menu_item() {

	global $submenu;

	$submenu['premise-member'][] = array( 'Members', 'manage_options', 'users.php?role=premise_member' );

}

add_filter( 'pre_user_query', 'premise_member_user_query' );

function premise_member_user_query( $q ) {
	
	global $wpdb;
	
	if ( empty( $q->query_where ) || ! preg_match( '|user_login LIKE \'([^\']+)\'|', $q->query_where, $m ) )
		return $q;
	
	$extra = $wpdb->prepare( "ID in (SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key IN ('first_name','last_name') AND meta_value LIKE %s) OR user_email LIKE %s OR ", $m[1], $m[1] );
	$q->query_where = preg_replace( '|(user_login LIKE \')|', $extra . '$1', $q->query_where );
	
	return $q;
}

add_filter( 'parse_query', 'premise_member_order_search_filter' );

function premise_member_order_search_filter( &$q ) {

	if ( $q->get( 'post_type' ) != 'acp-orders' )
		return $q;

	$field = '';
	foreach( array( 'member', 'product', 'coupon' ) as $key ) {
	
		$value = isset( $_GET[$key] ) ? (int) $_GET[$key] : 0;
		if ( $value ) {

			$field = $key;
			break;

		}
	}

	if ( ! $value )
		return $q;

	$q->set( 'meta_key', "_acp_order_{$field}_id" );
	$q->set( 'meta_value', $value );

	return $q;

}

add_filter( 'user_row_actions', 'premise_member_user_order_row_actions', 10, 2 );

function premise_member_user_order_row_actions( $actions, $user ) {

	$actions['member_orders'] = sprintf( '<a href="%s">%s</a>', add_query_arg( array( 'post_type' => 'acp-orders', 'member' => $user->ID ), admin_url( 'edit.php' ) ), __( 'Orders', 'premise' ) );
	return $actions;

}

add_filter( 'post_row_actions', 'premise_member_post_row_actions', 10, 2 );

function premise_member_post_row_actions( $actions, $post ) {

	if ( ! in_array( $post->post_type, array( 'acp-products', 'acp-coupons' ) ) )
		return $actions;

	$actions[$post->post_type . '_orders'] = sprintf( '<a href="%s">%s</a>', add_query_arg( array( 'post_type' => 'acp-orders', substr( $post->post_type, 4, -1 ) => $post->ID ), admin_url( 'edit.php' ) ), __( 'Orders', 'premise' ) );
	return $actions;

}
