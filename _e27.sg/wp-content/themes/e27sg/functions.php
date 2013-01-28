<?php

/* set image size and meta information */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 220, 220 ); // default Post Thumbnail dimensions   

add_image_size( 'std-thumb', 220, 220, TRUE ); // 220x220
add_image_size( 'yml-thumb', 140, 140, TRUE ); // 140x140
add_image_size( 'right-sidebar-thumb', 90, 90, TRUE ); // 90x90

/* 3.4.2 hot fixes */
function fix_custom_fields_in_wp342() {
	global $wp_version, $hook_suffix;

	if ( '3.4.2' == $wp_version && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) : ?>
	<script type="text/javascript">
		jQuery(document).delegate( '#addmetasub, #updatemeta', 'hover focus', function() {
			jQuery(this).attr('id', 'meta-add-submit');
		});
	</script>
	<?php
		endif;
}
add_action( 'admin_print_footer_scripts', 'fix_custom_fields_in_wp342' );

function attachment_image_link_remove_filter( $content ) {
 	
	/*
	$content =
 	
	preg_replace(
 	array('{<a(.*?)(wp-att|wp-content\/uploads)[^>]*><img}',
 	'{ wp-image-[0-9]*" /></a>}'),
 	array('<img','" />'),
 	$content
 	);
	*/
	/*
	<img src="http://e27.wpengine.netdna-cdn.com/wp-content/uploads/2013/01/East-Ventures-2010-2012-investments1-56x300.png" class="attachment-medium" alt="East Ventures 2010-2012 investments" title="East Ventures 2010-2012 investments" />
	*/
	if($_GET['test']||1){
		$matches = array();
		//ob_end_clean();
		//echo $content."\n\n\n\n";
		
		preg_match_all("/<a href='(.*)'.*><img.*class=\"attachment-medium.*\/><\/a>/iUs", $content, $matches);

		//cho "<pre>";
		//print_r($matches);
		//exit();

		foreach($matches[0] as $key=>$value){
			$new = "<img src='".$matches[1][$key]."' />";
			$content = str_replace($value, $new, $content);
		}
	}
	
 	return $content;
}
add_filter( 'the_content', 'attachment_image_link_remove_filter' );




function register_gig_menus() {
	register_nav_menus(
		array(
			'header-topics' => __( 'e27 Topics' ),
			'header-left-menu' => __( 'Header Left Side Menu' ),
			'header-right-menu' => __( 'Header Right Side Menu' ),
			'bottom-left-menu' => __( 'Bottom Left Side Menu' ),
			'bottom-center-menu' => __( 'Bottom Center Side Menu' ),
			'bottom-right-menu' => __( 'Bottom Right Side Menu' ),
			'footer-right-menu' => __( 'Footer Right Side Menu' )
		)
	);
}

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

add_action( 'init', 'register_gig_menus' );
if (function_exists('register_sidebars')) {
    register_sidebars(2, array(
        'before_widget' => '', //<div id="%1$s" class="widget %2$s">
        'after_widget' => '', //</div>
        'before_title' => '<h3><span>',
        'after_title' => '</span></h3>',
    ));
    
    register_sidebars(4, array(
    		'name' => 'Footer %d',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<h3><span>',
    		'after_title' => '</span></h3>',
    ));
}

add_filter('widget_title', 'parse_html_widget_title', 11);
function parse_html_widget_title( $text ) {
	$title_array = split(" ", $text);
	if (count($title_array) > 1)
		$title_array[count($title_array)-1] = '<span class="gray">' . $title_array[count($title_array)-1] . '</span>';
	return join(" ", $title_array);  
}

function widget_greenisgood_search() {}
wp_register_sidebar_widget('gig_search_widget1', __('Search'), 'widget_greenisgood_search');     
    
function add_custom_field_automatically($post_ID) {
   global $wpdb;
   if(!wp_is_post_revision($post_ID)) {
      add_post_meta($post_ID, '_shares_total', '0', true);
   }
}
add_action('publish_page', 'add_custom_field_automatically');
add_action('publish_post', 'add_custom_field_automatically');
if ( !wp_next_scheduled('gig_shares_hook') ) {
    wp_schedule_event(time(), 'hourly', 'gig_shares_hook'); // hourly, daily and twicedaily
}
add_action( 'gig_shares_hook', 'gig_shares_function' );
function gig_shares_function() {
	$myposts = get_posts(array('numberposts' => 25, 'orderby' => 'post_date'));
	foreach( $myposts as $post ) {
		setup_postdata($post);
		$postid = get_the_ID();
		$permalink = get_permalink($postid);
		$data = file_get_contents('http://graph.facebook.com/?id='. $permalink);
		$json = $data;
		$obj = json_decode($json);
		$like_no = $obj->{'shares'} ? $obj->{'shares'} : 0;
		$meta_values = get_post_meta($postid, '_shares_total', true);
		if (empty($meta_values)) {
		   add_post_meta($postid , '_shares_total', $like_no, true);
		   update_post_meta($postid , '_shares_total', $like_no, false);		   
		} 
		elseif ($like_no != 0 && $like_no != $meta_values) {
		   update_post_meta($postid, '_shares_total', $like_no, false);

		}
	}
	wp_reset_postdata();
}

function pagination($pages = '', $range = 4) {
     $showitems = ($range * 2)+1; 
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages) {
             $pages = 1;
         }
     }  
     if(1 != $pages) {
     	echo '<div id="pagination" class="page_nav page_nav_last">';
     	echo '	<ul class="clearfix">';
		if($paged > 1 && $showitems < $pages)
			echo '<li class="prev"><a href="'.get_pagenum_link($paged - 1).'">Prev</a></li>'; 
        for ($i=1; $i <= $pages; $i++) {
        	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
            	echo ($paged == $i)? '<li class="active"><span>'.$i.'</span>' : '<li><a title="'.$i.'" class="page" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}
        if ($paged < $pages && $showitems < $pages) 
        	echo '<li class="next"><a href="'.get_pagenum_link($paged + 1).'">Next &rsaquo;</a></li>';
        echo '	</ul>';
  //    	echo '	<span class="right">';
		// echo '		<a href="#top" class="back_to_top">Back to top</a>';
 	// 	echo '	</span>';
     	echo '</div>';
     }
}

function wp_social_media_user_profile_fields( $user ) { ?>
	<h3><?php _e("Social Media"); ?></h3>
    <table class="form-table">
    	<tr>
        	<th><label for="facebook"><?php _e("Facebook"); ?></label></th>
            <td>
            	<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your Facebook URL."); ?></span>
			</td>
		</tr>
		<tr>
        	<th><label for="twitter"><?php _e("Twitter"); ?></label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your Twitter URL."); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="linkedin"><?php _e("LinkedIn"); ?></label></th>
            <td>
            	<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your LinkedIn URL."); ?></span>
			</td>
		</tr>
		<tr>
        	<th><label for="googleplus"><?php _e("Google+"); ?></label></th>
            <td>
            	<input type="text" name="googleplus" id="googleplus" value="<?php echo esc_attr( get_the_author_meta( 'googleplus', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your Google+ URL."); ?></span>
			</td>
		</tr>
	</table>
<?php }
 
add_action( 'show_user_profile', 'wp_social_media_user_profile_fields' );
add_action( 'edit_user_profile', 'wp_social_media_user_profile_fields' );
 
function wp_save_social_media_user_profile_fields( $user_id )
    {
        if ( !current_user_can( 'edit_user', $user_id ) ) { return false; } //User Auth
 
        update_user_meta( $user_id, 'facebook', $_POST['facebook']);
        update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
        update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
        update_user_meta( $user_id, 'googleplus', $_POST['googleplus'] );
    }
 
add_action( 'personal_options_update', 'wp_save_social_media_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wp_save_social_media_user_profile_fields' );

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info
function insert_fb_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
	echo '<meta property="og:title" content="' . get_the_title() . '"/>';
	echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	
	echo '<meta name="twitter:card" content="summary" />';
	echo '<meta name="twitter:url" content="' . get_permalink() . '"/>';
	echo '<meta name="twitter:title" content="' . get_the_title() . '"/>';
	echo '<meta name="twitter:site" content="@e27sg" />';
	echo '<meta name="twitter:site:id" content="15315691" />';
	echo '<meta name="twitter:description" content="'.substr(strip_tags($post->post_content), 0, 200).'" />';
	
    //echo '<meta property="fb:admins" content="e27sg"/>';
	if(has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		echo '<meta name="twitter:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		echo '<link rel="image_src" href="' . esc_attr( $thumbnail_src[0] ) . '" />';
	}
	elseif (get_first_image( $post->ID ) != null) {
		$thumbnail_src = get_first_image( $post->ID );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src ) . '"/>';
		echo '<meta name="twitter:image" content="' . esc_attr( $thumbnail_src ) . '"/>';
		echo '<link rel="image_src" href="' . esc_attr( $thumbnail_src ) . '" />';
	}
	else{
		$default_image = "http://e27.sg/wp-content/themes/greenisgood/img/e27-logo.png"; //replace this with a default image on your server or an image in your media library
		echo '<meta property="og:image" content="' . $default_image . '"/>';
		echo '<meta name="twitter:image" content="' . $default_image . '"/>';
		echo '<link rel="image_src" href="' . $default_image . '" />';
	}
	echo "\n";
}
add_action( 'wp_head', 'insert_fb_in_head', 5);

/**
	FIRST IMAGE
 */

function get_first_image ($postID) {
	if (has_post_thumbnail($postID)) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'single-post-thumbnail' );
		return $image[0];
	}
	else {
		$args = array(
				'numberposts' => 1,
				'order'=> 'ASC',
				'post_mime_type' => 'image',
				'post_parent' => $postID,
				'post_status' => null,
				'post_type' => 'attachment'
		);
		$attachments = get_children( $args );
		if ($attachments) {
			foreach($attachments as $attachment) {
				return wp_get_attachment_thumb_url( $attachment->ID );
			}
		}
	}
	return null;
}

function echo_first_image ($postID, $width = 150) {
	$media_ids = array();
	if (has_post_thumbnail($postID)) {
		$media_ids[] = get_post_thumbnail_id($postID);
	} else {
		$args = array(
				'numberposts' => 1,
				'order'=> 'ASC',
				'post_mime_type' => 'image',
				'post_parent' => $postID,
				'post_status' => null,
				'post_type' => 'attachment'
		);
		
		$attachments = get_children( $args );
		
		if ($attachments) {
			foreach($attachments as $attachment) {
				$media_ids[] = $attachment->ID;
			}
		}
	}

	foreach ($media_ids as $media_id) {
		$image = wp_get_attachment_image_src( $media_id, array($width, $width), FALSE );
		if ( ! $image) {
			continue;
		}
		echo '<img src="'.$image[0].'" class="current" width="'.$width.'"/>';
		break;
	}
}

add_action('admin_init', 'eg_settings_api_init');
function eg_settings_api_init() {
	add_settings_section('eg_setting_general_section', 'Theme Options', 'eg_setting_general_section_cb', 'general');
	add_settings_field('eg_newsletter_learn_more_link', 'Newsletter Learn More Link', 'eg_setting_learn_more_cb', 'general', 'eg_setting_general_section');
	register_setting('general', 'eg_newsletter_learn_more_link');
	
	add_settings_section('eg_setting_section', 'Ads - Top Banner Ad (728 x 90)', 'eg_setting_section_callback_function', 'media');
	add_settings_field('eg_ad_460x60_top_banner_enable', 'Enable the ad space', 'eg_setting_callback_function', 'media', 'eg_setting_section');
	register_setting('media', 'eg_ad_460x60_top_banner_enable');
	add_settings_field('eg_ad_460x60_top_banner_ad_sense', 'Adsense code', 'eg_setting_ad_sense_callback_function', 'media', 'eg_setting_section');
	register_setting('media', 'eg_ad_460x60_top_banner_ad_sense');
	add_settings_field('eg_ad_460x60_top_banner_image_location', 'Image location', 'eg_setting_image_location_callback_function', 'media', 'eg_setting_section');
	register_setting('media', 'eg_ad_460x60_top_banner_image_location');
	add_settings_field('eg_ad_460x60_top_banner_dest_url', 'Destination URL', 'eg_setting_dest_url_callback_function', 'media', 'eg_setting_section');
	register_setting('media', 'eg_ad_460x60_top_banner_dest_url');
	
	add_settings_section('eg_setting_section1', 'Ads - Side Banner 1 (300x250)', 'eg_setting_section1_callback_function', 'media');
	add_settings_field('eg_ad_side_banner1_enable', 'Side Banner Ad 1', 'eg_setting_callback_function1', 'media', 'eg_setting_section1');
	register_setting('media', 'eg_ad_side_banner1_enable');
	add_settings_field('eg_ad_side_banner1_ad_sense', 'Adsense code', 'eg_ad_side_banner1_ad_sense_callback_function', 'media', 'eg_setting_section1');
	register_setting('media', 'eg_ad_side_banner1_ad_sense');
	add_settings_field('eg_ad_side_banner1_image_location', 'Image location', 'eg_ad_side_banner1_image_location_callback_function', 'media', 'eg_setting_section1');
	register_setting('media', 'eg_ad_side_banner1_image_location');
	add_settings_field('eg_ad_side_banner1_dest_url', 'Destination URL', 'eg_ad_side_banner1_dest_url_callback_function', 'media', 'eg_setting_section1');
	register_setting('media', 'eg_ad_side_banner1_dest_url');
	
	
	//jairus
	add_settings_section('eg_setting_section1_1', 'Ads - Side Banner 2 (300x250)', 'eg_setting_section1_1_callback_function', 'media');
	add_settings_field('eg_ad_side_banner1_1_enable', 'Side Banner Ad 2', 'eg_setting_callback_function1_1', 'media', 'eg_setting_section1_1');
	register_setting('media', 'eg_ad_side_banner1_1_enable');
	add_settings_field('eg_ad_side_banner1_1_ad_sense', 'Adsense code', 'eg_ad_side_banner1_1_ad_sense_callback_function', 'media', 'eg_setting_section1_1');
	register_setting('media', 'eg_ad_side_banner1_1_ad_sense');
	add_settings_field('eg_ad_side_banner1_1_image_location', 'Image location', 'eg_ad_side_banner1_1_image_location_callback_function', 'media', 'eg_setting_section1_1');
	register_setting('media', 'eg_ad_side_banner1_1_image_location');
	add_settings_field('eg_ad_side_banner1_1_dest_url', 'Destination URL', 'eg_ad_side_banner1_1_dest_url_callback_function', 'media', 'eg_setting_section1_1');
	register_setting('media', 'eg_ad_side_banner1_1_dest_url');
	
	
	
	/*
	add_settings_section('eg_setting_section2', 'Ads - Side Banner 2 (300x250)', 'eg_setting_section2_callback_function', 'media');
	add_settings_field('eg_ad_side_banner2_enable', 'Side Banner Ad 2', 'eg_setting_callback_function2', 'media', 'eg_setting_section2');
	register_setting('media', 'eg_ad_side_banner2_enable');
	add_settings_field('eg_ad_side_banner2_ad_sense', 'Adsense code', 'eg_ad_side_banner2_ad_sense_callback_function', 'media', 'eg_setting_section2');
	register_setting('media', 'eg_ad_side_banner2_ad_sense');
	add_settings_field('eg_ad_side_banner2_image_location', 'Image location', 'eg_ad_side_banner2_image_location_callback_function', 'media', 'eg_setting_section2');
	register_setting('media', 'eg_ad_side_banner2_image_location');
	add_settings_field('eg_ad_side_banner2_dest_url', 'Destination URL', 'eg_ad_side_banner2_dest_url_callback_function', 'media', 'eg_setting_section2');
	register_setting('media', 'eg_ad_side_banner2_dest_url');
	*/
	
	add_settings_section('eg_setting_section3', 'Ads - Side Banner 3 (125x125)', 'eg_setting_section3_callback_function', 'media');
	add_settings_field('eg_ad_side_banner3_enable', 'Side Banner Ad 3', 'eg_setting_callback_function3', 'media', 'eg_setting_section3');
	register_setting('media', 'eg_ad_side_banner3_enable');
	add_settings_field('eg_ad_side_banner3_ad_sense', 'Adsense code', 'eg_ad_side_banner3_ad_sense_callback_function', 'media', 'eg_setting_section3');
	register_setting('media', 'eg_ad_side_banner3_ad_sense');
	add_settings_field('eg_ad_side_banner3_image_location', 'Image location', 'eg_ad_side_banner3_image_location_callback_function', 'media', 'eg_setting_section3');
	register_setting('media', 'eg_ad_side_banner3_image_location');
	add_settings_field('eg_ad_side_banner3_dest_url', 'Destination URL', 'eg_ad_side_banner3_dest_url_callback_function', 'media', 'eg_setting_section3');
	register_setting('media', 'eg_ad_side_banner3_dest_url');
	
	//jairus
	add_settings_section('eg_setting_section3_1', 'Ads - Side Banner 4 (125x125)', 'eg_setting_section3_1_callback_function', 'media');
	add_settings_field('eg_ad_side_banner3_1_enable', 'Side Banner Ad 4', 'eg_setting_callback_function3_1', 'media', 'eg_setting_section3_1');
	register_setting('media', 'eg_ad_side_banner3_1_enable');
	add_settings_field('eg_ad_side_banner3_1_ad_sense', 'Adsense code', 'eg_ad_side_banner3_1_ad_sense_callback_function', 'media', 'eg_setting_section3_1');
	register_setting('media', 'eg_ad_side_banner3_1_ad_sense');
	add_settings_field('eg_ad_side_banner3_1_image_location', 'Image location', 'eg_ad_side_banner3_1_image_location_callback_function', 'media', 'eg_setting_section3_1');
	register_setting('media', 'eg_ad_side_banner3_1_image_location');
	add_settings_field('eg_ad_side_banner3_1_dest_url', 'Destination URL', 'eg_ad_side_banner3_1_dest_url_callback_function', 'media', 'eg_setting_section3_1');
	register_setting('media', 'eg_ad_side_banner3_1_dest_url');
	
	add_settings_section('eg_setting_section4', 'Ads - Side Banner 5 (125x125)', 'eg_setting_section4_callback_function', 'media');
	add_settings_field('eg_ad_side_banner4_enable', 'Side Banner Ad 5', 'eg_setting_callback_function4', 'media', 'eg_setting_section4');
	register_setting('media', 'eg_ad_side_banner4_enable');
	add_settings_field('eg_ad_side_banner4_ad_sense', 'Adsense code', 'eg_ad_side_banner4_ad_sense_callback_function', 'media', 'eg_setting_section4');
	register_setting('media', 'eg_ad_side_banner4_ad_sense');
	add_settings_field('eg_ad_side_banner4_image_location', 'Image location', 'eg_ad_side_banner4_image_location_callback_function', 'media', 'eg_setting_section4');
	register_setting('media', 'eg_ad_side_banner4_image_location');
	add_settings_field('eg_ad_side_banner4_dest_url', 'Destination URL', 'eg_ad_side_banner4_dest_url_callback_function', 'media', 'eg_setting_section4');
	register_setting('media', 'eg_ad_side_banner4_dest_url');
	
	//jairus
	add_settings_section('eg_setting_section4_1', 'Ads - Side Banner 6 (125x125)', 'eg_setting_section4_1_callback_function', 'media');
	add_settings_field('eg_ad_side_banner4_1_enable', 'Side Banner Ad 6', 'eg_setting_callback_function4_1', 'media', 'eg_setting_section4_1');
	register_setting('media', 'eg_ad_side_banner4_1_enable');
	add_settings_field('eg_ad_side_banner4_1_ad_sense', 'Adsense code', 'eg_ad_side_banner4_1_ad_sense_callback_function', 'media', 'eg_setting_section4_1');
	register_setting('media', 'eg_ad_side_banner4_1_ad_sense');
	add_settings_field('eg_ad_side_banner4_1_image_location', 'Image location', 'eg_ad_side_banner4_1_image_location_callback_function', 'media', 'eg_setting_section4_1');
	register_setting('media', 'eg_ad_side_banner4_1_image_location');
	add_settings_field('eg_ad_side_banner4_1_dest_url', 'Destination URL', 'eg_ad_side_banner4_1_dest_url_callback_function', 'media', 'eg_setting_section4_1');
	register_setting('media', 'eg_ad_side_banner4_1_dest_url');
	
	add_settings_section('eg_setting_section5', 'Ads - Center Posts', 'eg_setting_section5_callback_function', 'media');
	add_settings_field('eg_ad_center_banner_enable', 'Center Ads', 'eg_setting_callback_function5', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_banner_enable');
	add_settings_field('eg_ad_center_ad1_image_location', 'Image location', 'eg_ad_center_ad1_image_location_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad1_image_location');
	add_settings_field('eg_ad_center_ad1_dest_url', 'Destination URL', 'eg_ad_center_ad1_dest_url_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad1_dest_url');
	
	add_settings_field('eg_ad_center_ad2_image_location', 'Image location', 'eg_ad_center_ad2_image_location_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad2_image_location');
	add_settings_field('eg_ad_center_ad2_dest_url', 'Destination URL', 'eg_ad_center_ad2_dest_url_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad2_dest_url');
	
	add_settings_field('eg_ad_center_ad3_image_location', 'Image location', 'eg_ad_center_ad3_image_location_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad3_image_location');
	add_settings_field('eg_ad_center_ad3_dest_url', 'Destination URL', 'eg_ad_center_ad3_dest_url_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad3_dest_url');
	
	add_settings_field('eg_ad_center_ad4_image_location', 'Image location', 'eg_ad_center_ad4_image_location_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad4_image_location');
	add_settings_field('eg_ad_center_ad4_dest_url', 'Destination URL', 'eg_ad_center_ad4_dest_url_callback_function', 'media', 'eg_setting_section5');
	register_setting('media', 'eg_ad_center_ad4_dest_url');
}

function eg_setting_general_section_cb() {
	echo '<p>Theme specific options</p>';
}

function eg_setting_learn_more_cb() {
	echo '<input name="eg_newsletter_learn_more_link" id="gv_eg_newsletter_learn_more_link" type="text" value="'.get_option('eg_newsletter_learn_more_link').'" />';
}

// eg_ad_460x60_top_banner_enable
function eg_setting_section_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function() {
	echo '<input name="eg_ad_460x60_top_banner_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_460x60_top_banner_enable'), false ) . ' /> Enable';
}

function eg_setting_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_460x60_top_banner_ad_sense" id="eg_ad_460x60_top_banner_ad_sense">'.get_option('eg_ad_460x60_top_banner_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_setting_image_location_callback_function() {
	echo '<input name="eg_ad_460x60_top_banner_image_location" id="eg_ad_460x60_top_banner_image_location" type="text" value="'.get_option('eg_ad_460x60_top_banner_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_setting_dest_url_callback_function() {
	echo '<input name="eg_ad_460x60_top_banner_dest_url" id="eg_ad_460x60_top_banner_dest_url" type="text" value="'.get_option('eg_ad_460x60_top_banner_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_460x60_top_banner_enable

// eg_ad_side_banner1_enable
function eg_setting_section1_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function1() {
	echo '<input name="eg_ad_side_banner1_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner1_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner1_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner1_ad_sense" id="eg_ad_side_banner1_ad_sense">'.get_option('eg_ad_side_banner1_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner1_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner1_image_location" id="eg_ad_side_banner1_image_location" type="text" value="'.get_option('eg_ad_side_banner1_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner1_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner1_dest_url" id="eg_ad_side_banner1_dest_url" type="text" value="'.get_option('eg_ad_side_banner1_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_side_banner1_enable

//jairus
// eg_ad_side_banner1_1_enable
function eg_setting_section1_1_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function1_1() {
	echo '<input name="eg_ad_side_banner1_1_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner1_1_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner1_1_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner1_1_ad_sense" id="eg_ad_side_banner1_1_ad_sense">'.get_option('eg_ad_side_banner1_1_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner1_1_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner1_1_image_location" id="eg_ad_side_banner1_1_image_location" type="text" value="'.get_option('eg_ad_side_banner1_1_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner1_1_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner1_1_dest_url" id="eg_ad_side_banner1_1_dest_url" type="text" value="'.get_option('eg_ad_side_banner1_1_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_side_banner1_1_enable

// eg_ad_side_banner2_enable
function eg_setting_section2_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function2() {
	echo '<input name="eg_ad_side_banner2_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner2_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner2_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner2_ad_sense" id="eg_ad_side_banner2_ad_sense">'.get_option('eg_ad_side_banner2_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner2_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner2_image_location" id="eg_ad_side_banner2_image_location" type="text" value="'.get_option('eg_ad_side_banner2_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner2_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner2_dest_url" id="eg_ad_side_banner2_dest_url" type="text" value="'.get_option('eg_ad_side_banner2_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_side_banner2_enable

// eg_ad_side_banner3_enable
function eg_setting_section3_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function3() {
	echo '<input name="eg_ad_side_banner3_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner3_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner3_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner3_ad_sense" id="eg_ad_side_banner3_ad_sense">'.get_option('eg_ad_side_banner3_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner3_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner3_image_location" id="eg_ad_side_banner3_image_location" type="text" value="'.get_option('eg_ad_side_banner3_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner3_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner3_dest_url" id="eg_ad_side_banner3_dest_url" type="text" value="'.get_option('eg_ad_side_banner3_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_side_banner3_enable

//jairus
// eg_ad_side_banner3_1_enable
function eg_setting_section3_1_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function3_1() {
	echo '<input name="eg_ad_side_banner3_1_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner3_1_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner3_1_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner3_1_ad_sense" id="eg_ad_side_banner3_1_ad_sense">'.get_option('eg_ad_side_banner3_1_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner3_1_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner3_1_image_location" id="eg_ad_side_banner3_1_image_location" type="text" value="'.get_option('eg_ad_side_banner3_1_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner3_1_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner3_1_dest_url" id="eg_ad_side_banner3_1_dest_url" type="text" value="'.get_option('eg_ad_side_banner3_1_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_ad_side_banner3_1_enable

// eg_setting_section4
function eg_setting_section4_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function4() {
	echo '<input name="eg_ad_side_banner4_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner4_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner4_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner4_ad_sense" id="eg_ad_side_banner4_ad_sense">'.get_option('eg_ad_side_banner4_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner4_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner4_image_location" id="eg_ad_side_banner4_image_location" type="text" value="'.get_option('eg_ad_side_banner4_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner4_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner4_dest_url" id="eg_ad_side_banner4_dest_url" type="text" value="'.get_option('eg_ad_side_banner4_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_setting_section4

//jairus
// eg_setting_section4_1
function eg_setting_section4_1_callback_function() {
	echo '<p>The ads specified below will determine what will show in their corresponding ad sections.</p>';
}

function eg_setting_callback_function4_1() {
	echo '<input name="eg_ad_side_banner4_1_enable" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_side_banner4_1_enable'), false ) . ' /> Enable';
}

function eg_ad_side_banner4_1_ad_sense_callback_function() {
	echo '<textarea name="eg_ad_side_banner4_1_ad_sense" id="eg_ad_side_banner4_1_ad_sense">'.get_option('eg_ad_side_banner4_1_ad_sense', '').'</textarea> Enter your adsense code (or other ad network code) here.';
}

function eg_ad_side_banner4_1_image_location_callback_function() {
	echo '<input name="eg_ad_side_banner4_1_image_location" id="eg_ad_side_banner4_1_image_location" type="text" value="'.get_option('eg_ad_side_banner4_1_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_side_banner4_1_dest_url_callback_function() {
	echo '<input name="eg_ad_side_banner4_1_dest_url" id="eg_ad_side_banner4_1_dest_url" type="text" value="'.get_option('eg_ad_side_banner4_1_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end eg_setting_section4_1

// eg_setting_section 5
function eg_setting_section5_callback_function() {
	echo '<p>The ads specified below will determine what will show in the middle of the posts</p>';
}

function eg_setting_callback_function5() {
	echo '<input name="eg_ad_center_banner_enable" id="eg_ad_center_banner_enable" type="checkbox" value="1" class="code" ' . checked( 1, get_option('eg_ad_center_banner_enable'), false ) . ' /> Enable';
}

function eg_ad_center_ad1_image_location_callback_function() {
	echo '<input name="eg_ad_center_ad1_image_location" id="eg_ad_center_ad1_image_location" type="text" value="'.get_option('eg_ad_center_ad1_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_center_ad1_dest_url_callback_function() {
	echo '<input name="eg_ad_center_ad1_dest_url" id="eg_ad_center_ad1_dest_url" type="text" value="'.get_option('eg_ad_center_ad1_dest_url').'" /> Enter the URL where this banner ad points to.';
}

function eg_ad_center_ad2_image_location_callback_function() {
	echo '<input name="eg_ad_center_ad2_image_location" id="eg_ad_center_ad2_image_location" type="text" value="'.get_option('eg_ad_center_ad2_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_center_ad2_dest_url_callback_function() {
	echo '<input name="eg_ad_center_ad2_dest_url" id="eg_ad_center_ad2_dest_url" type="text" value="'.get_option('eg_ad_center_ad2_dest_url').'" /> Enter the URL where this banner ad points to.';
}

function eg_ad_center_ad3_image_location_callback_function() {
	echo '<input name="eg_ad_center_ad3_image_location" id="eg_ad_center_ad3_image_location" type="text" value="'.get_option('eg_ad_center_ad3_image_location').'" /> Enter the URL to the banner ad image location.';
}

function eg_ad_center_ad3_dest_url_callback_function() {
	echo '<input name="eg_ad_center_ad3_dest_url" id="eg_ad_center_ad3_dest_url" type="text" value="'.get_option('eg_ad_center_ad3_dest_url').'" /> Enter the URL where this banner ad points to.';
}

function eg_ad_center_ad4_image_location_callback_function() {
	echo '<input name="eg_ad_center_ad4_image_location" id="eg_ad_center_ad4_image_location" type="text" value="'.get_option('eg_ad_center_ad4_image_location').'" /> Enter the URL to the banner ad image location.';
}

function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit) {
  array_pop($words);
  //add a ... at last article when more than limit word count
  echo implode(' ', $words)."..."; } else {
  //otherwise
  echo implode(' ', $words); }
}

function eg_ad_center_ad4_dest_url_callback_function() {
	echo '<input name="eg_ad_center_ad4_dest_url" id="eg_ad_center_ad4_dest_url" type="text" value="'.get_option('eg_ad_center_ad4_dest_url').'" /> Enter the URL where this banner ad points to.';
}
// end section 5

if(!function_exists('get_the_content_first_paragraph')) {
	function get_the_content_first_paragraph($sentences = 3) {
		/*
		$content = get_the_content();
		$content = strip_shortcodes($content);
		$content = strip_tags($content, '<a>');
		$content = preg_replace('/\s{2,}/u', ' ', $content);
		$contents = explode(". ", $content);
		if (count($contents) <= $sentences)
			return '<p>'.implode(". ", $contents).'.</p>';
		else {
			$paragraph = array();
			for ($x=0;$x<$sentences;$x++)
				$paragraph[] = $contents[$x];
			return '<p>'.implode(". ", $paragraph).'.</p>';
		}	
		

		$content = get_the_content();
		$content = strip_tags($content);
		$content = strip_shortcodes($content);
		$content = preg_replace ("/\[(\S+)\]/e", "", $content);
		$content = substr($content, 0, 500);
		return '<p>'.$content.'...</p>';
		*/
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = strip_shortcodes($content);
		$content = preg_replace('/<div[^>]+>(.*?)<\/div>/s', "", $content);
		$content = strip_tags($content, '<p><a>');
		$content = str_replace(']]>', ']]&gt;', $content);
		$pattern = "/<p[^>]*>\s{1,}<\\/p[^>]*>/";
		$content = preg_replace($pattern, '', $content);
		$content_explode = explode("</p>", $content);
		$c = 0; $p = count($content_explode); $return_data = "";
		while($c < $p) {
			$test = strip_tags($content_explode[$c]);
			if($test != '') {
				$return_data = $return_data . $content_explode[$c] . "</p>\n";
				break;
			} else {
				$return_data = $return_data . $content_explode[$c] . "</p>\n";
			} $c++;
		}
		return $return_data;
	}
}


function mytheme_tinymce_config( $init ) {
 $valid_iframe = 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]';
 if ( isset( $init['extended_valid_elements'] ) ) {
  $init['extended_valid_elements'] .= ',' . $valid_iframe;
 } else {
  $init['extended_valid_elements'] = $valid_iframe;
 }
 return $init;
}
add_filter('tiny_mce_before_init', 'mytheme_tinymce_config');


global $allowedposttags;
$allowedposttags["iframe"] = array("id" => array(),"class" => array(), "align" => array(),"frameborder" => array(),"title" => array(),"style" => array(),"name" => array(),"scrolling" => array(),"src" => array(),"height" => array(),"width" => array());

if($_GET['allowedposttags']){
	echo "<pre>";
	print_r($allowedposttags);
	echo "</pre>";
}




//27x
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'startuplist_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'startuplist_post_meta_boxes_setup' );

/* Meta box setup function. */
function startuplist_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'startuplist_add_post_meta_boxes' );
	
	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'startuplist_save_post_class_meta', 10, 2 );
}


/* Create one or more meta boxes to be displayed on the post editor screen. */
function startuplist_add_post_meta_boxes() {

	add_meta_box(
		'startuplist-post-class',			// Unique ID
		esc_html__( '27x.co', 'example' ),		// Title
		'startuplist_post_class_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'default'					// Priority
	);
}

if($_GET['companies27x']){
	ob_end_clean();
	$data = file_get_contents("http://27x.co/companies/ajax_search?term=".$_GET['term']);
	echo $data;
	exit();
}
else if($_GET['people27x']){
	ob_end_clean();
	$data = file_get_contents("http://27x.co/people/ajax_search?term=".$_GET['term']);
	echo $data;
	exit();
}
else if($_GET['investment_orgs27x']){
	ob_end_clean();
	$data = file_get_contents("http://27x.co/investment_orgs/ajax_search?term=".$_GET['term']);
	echo $data;
	exit();
}

/* Display the post meta box. */
function startuplist_post_class_meta_box( $object, $box ) { ?>
	<script>
	jQuery(function(){
		jQuery("#startuplist_company_search").autocomplete({
			//define callback to format results
			source: function(req, add){
				//pass request to server
				jQuery.getJSON("/?companies27x=1", req, function(data) {
					//create array for response objects
					var suggestions = [];
					//process response
					jQuery.each(data, function(i, val){								
						suggestions.push(val);
					});
					//pass array to callback
					add(suggestions);
				});
			},
			//define select handler
			select: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_people_search").val("");
				jQuery("#startuplist_companies").append("<div><input class=\"widefat\" type=\"hidden\" name=\"startuplist_companies[]\" value=\""+value+"\" /><a onclick='this.parentElement.outerHTML = \"\"' style='cursor:pointer'>[ x ]</a>&nbsp;<a href='http://27x.co/company/id/"+value+"' target='_blank'>"+label+"</a></div>");
				//self.location = "http://27x.co/companies/edit/"+value;
				return false;
			},
			focus: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_company_search").val(label);
				return false;
			},


		});

		
		jQuery("#startuplist_investment_orgs_search").autocomplete({
			//define callback to format results
			source: function(req, add){
				//pass request to server
				jQuery.getJSON("/?investment_orgs27x=1", req, function(data) {
					//create array for response objects
					var suggestions = [];
					//process response
					jQuery.each(data, function(i, val){								
						suggestions.push(val);
					});
					//pass array to callback
					add(suggestions);
				});
			},
			//define select handler
			select: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_people_search").val("");
				jQuery("#startuplist_investment_orgs").append("<div><input class=\"widefat\" type=\"hidden\" name=\"startuplist_investment_orgs[]\" value=\""+value+"\" /><a onclick='this.parentElement.outerHTML = \"\"' style='cursor:pointer'>[ x ]</a>&nbsp;<a href='http://27x.co/investment_org/id/"+value+"' target='_blank'>"+label+"</a></div>");
				return false;
			},
			focus: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_investment_orgs_search").val(label);
				return false;
			},
		});
		
		jQuery("#startuplist_people_search").autocomplete({
			//define callback to format results
			source: function(req, add){
				//pass request to server
				jQuery.getJSON("/?people27x=1", req, function(data) {
					//create array for response objects
					var suggestions = [];
					//process response
					jQuery.each(data, function(i, val){								
						suggestions.push(val);
					});
					//pass array to callback
					add(suggestions);
				});
			},
			//define select handler
			select: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_people_search").val("");
				jQuery("#startuplist_people").append("<div><input class=\"widefat\" type=\"hidden\" name=\"startuplist_people[]\" value=\""+value+"\" /><a onclick='this.parentElement.outerHTML = \"\"' style='cursor:pointer'>[ x ]</a>&nbsp;<a href='http://27x.co/person/id/"+value+"' target='_blank'>"+label+"</a></div>");
				return false;
			},
			focus: function(e, ui) {
				label = ui.item.label;
				value = ui.item.value;
				jQuery("#startuplist_people_search").val(label);
				return false;
			},
		});
	});
	</script>
	<div class='startuplist'>
	<?php wp_nonce_field( basename( __FILE__ ), 'startuplist_post_class_nonce' ); ?>
	
	<p>
		<label for="startuplist-post-class"><?php _e( "Key in the Company / Person or Investment Organization to add to article", 'example' ); ?></label>
		<br />
		<br />
		<label for="startuplist_companies">Companies</label>
		<?php
		$companies = trim(get_post_meta( $object->ID, 'startuplist_companies', true ));
		//echo $companies;
		?>
		<br />
		<input id="startuplist_company_search" class="form-input-tip" type="text" value="" style='width: 100%;' />
		<div id='startuplist_companies' style='padding:5px;'>
			<?php
			if($companies){
				$companies = json_decode($companies);
				foreach($companies as $value){
					$json = file_get_contents("http://27x.co/company/id~jsonmin/".$value);
					$data27x = @json_decode($json);
					if($data27x->name){
						?>
						<div>
						<input class="widefat" type="hidden" name="startuplist_companies[]" value="<?php echo htmlentities($value); ?>" />
						<a onclick='this.parentElement.outerHTML = ""' style='cursor:pointer'>[ x ]</a>&nbsp;<?php
						echo "<a href='http://27x.co/company/id/".$value."' target='_blank'>".$data27x->name."</a>";
						?>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
		<br />
		<label for="startuplist_investment_orgs">Investment Organizations</label>
		<?php
		$investment_orgs = trim(get_post_meta( $object->ID, 'startuplist_investment_orgs', true ));
		//echo $investment_orgs;
		?>
		<br />
		<input id="startuplist_investment_orgs_search" class="form-input-tip" type="text" value="" style='width: 100%;' />
		<div id='startuplist_investment_orgs' style='padding:5px;'>
			<?php
			if($investment_orgs){
				$investment_orgs = json_decode($investment_orgs);
				foreach($investment_orgs as $value){
					$json = file_get_contents("http://27x.co/investment_org/id~jsonmin/".$value);
					$data27x = @json_decode($json);
					if($data27x->name){
						?>
						<div>
						<input class="widefat" type="hidden" name="startuplist_investment_orgs[]" value="<?php echo htmlentities($value); ?>" />
						<a onclick='this.parentElement.outerHTML = ""' style='cursor:pointer'>[ x ]</a>&nbsp;<?php
							echo "<a href='http://27x.co/investment_org/id/".$value."' target='_blank'>".$data27x->name."</a><br />";
						?>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
		<br />
		<label for="startuplist_people">People</label>
		<?php
		$people = trim(get_post_meta( $object->ID, 'startuplist_people', true ));
		//echo $people;
		?>
		<br />
		<input id="startuplist_people_search" class="form-input-tip" type="text" value="" style='width: 100%;' />
		<div id='startuplist_people' style='padding:5px;'>
			<?php
			if($people){
				$people = json_decode($people);
				foreach($people as $value){
					$json = file_get_contents("http://27x.co/person/id~jsonmin/".$value);
					$data27x = @json_decode($json);
					if($data27x->name){
						?>
						<div>
						<input class="widefat" type="hidden" name="startuplist_people[]" value="<?php echo htmlentities($value); ?>" />
						<a onclick='this.parentElement.outerHTML = ""' style='cursor:pointer'>[ x ]</a>&nbsp;
						<?php
							echo "<a href='http://27x.co/person/id/".$value."' target='_blank'>".$data27x->name."</a><br />";
						?>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
		<br />
	</p>
	</div>
	<?php 
}


/* Save the meta box's post metadata. */
function startuplist_save_post_class_meta( $post_id, $post ) {
	
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['startuplist_post_class_nonce'] ) || !wp_verify_nonce( $_POST['startuplist_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['startuplist_companies'] ) ? json_encode( $_POST['startuplist_companies'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'startuplist_companies';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
		
	//--
	
	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['startuplist_people'] ) ? json_encode( $_POST['startuplist_people'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'startuplist_people';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
		
	//--
	
	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['startuplist_investment_orgs'] ) ? json_encode( $_POST['startuplist_investment_orgs'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'startuplist_investment_orgs';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	
}



?>