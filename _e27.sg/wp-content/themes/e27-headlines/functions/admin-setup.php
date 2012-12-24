<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Show Options Panel after activate
- Admin Backend
	- Tweaked the message on theme activate
- Theme Header ouput - wp_head()
	- Styles
	- Favicon
	- Localization
	- Date Format
	- woo_head_css
- Output CSS from standarized options
	- Text title
	- Custom.css
- Post Images from WP2.9+ integration
- Enqueue comment reply script 

-----------------------------------------------------------------------------------*/

define('THEME_FRAMEWORK','woothemes');

/*-----------------------------------------------------------------------------------*/
/* Add default options and show Options Panel after activate  */
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

	//Call action that sets
	add_action('admin_head','woo_option_setup');
	
	//Do redirect
	header( 'Location: '.admin_url().'admin.php?page=woothemes' ) ;
	
}

function woo_option_setup(){

	//Update EMPTY options
	$woo_array = array();
	add_option('woo_options',$woo_array);

	$template = get_option('woo_template');
	$saved_options = get_option('woo_options');
	
	foreach($template as $option) {
		if($option['type'] != 'heading'){
			$id = $option['id'];
			$std = $option['std'];
			$db_option = get_option($id);
			if(empty($db_option)){
				if(is_array($option['type'])) {
					foreach($option['type'] as $child){
						$c_id = $child['id'];
						$c_std = $child['std'];
						$db_option = get_option($c_id);
						if(!empty($db_option)){
							update_option($c_id,$db_option);
							$woo_array[$id] = $db_option;
						} else {
							$woo_array[$c_id] = $c_std; 
						}
					}
				} else {
					update_option($id,$std);
					$woo_array[$id] = $std;
				}
			}
			else { //So just store the old values over again.
				$woo_array[$id] = $db_option;
			}
		}
	}
	update_option('woo_options',$woo_array);
}

/*-----------------------------------------------------------------------------------*/
/* Admin Backend */
/*-----------------------------------------------------------------------------------*/
function woothemes_admin_head() { 
	
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This <strong>WooTheme</strong> comes with a <a href="<?php echo admin_url('admin.php?page=woothemes'); ?>">comprehensive options panel</a>. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
    
    //Setup Custom Navigation Menu
	if (function_exists('woo_custom_navigation_setup')) {
		woo_custom_navigation_setup();
	}
	
}

add_action('admin_head', 'woothemes_admin_head'); 


/*-----------------------------------------------------------------------------------*/
/* Theme Header output - wp_head() */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woothemes_wp_head')) {
	function woothemes_wp_head() { 
	    
		//Styles
		 if(!isset($_REQUEST['style']))
		 	$style = ''; 
		 else 
	     	$style = $_REQUEST['style'];
	     if ($style != '') {
			  $GLOBALS['stylesheet'] = $style;
	          echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] . '.css" rel="stylesheet" type="text/css" />'."\n"; 
	     } else { 
	          $GLOBALS['stylesheet'] = get_option('woo_alt_stylesheet');
	          if($GLOBALS['stylesheet'] != '')
	               echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] .'" rel="stylesheet" type="text/css" />'."\n";         
	          else
	               echo '<link href="'. get_bloginfo('template_directory') .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
	     } 
	     
		// Favicon
		if(get_option('woo_custom_favicon') != '') {
	        echo '<link rel="shortcut icon" href="'.  get_option('woo_custom_favicon')  .'"/>'."\n";
	    }    
	            	
		// Localization
		load_theme_textdomain('woothemes');	

		// Date format (woodate not in use in new themes)
		$GLOBALS['woodate'] = get_option('date_format');	

		// Output CSS from standarized options
		woo_head_css();	
		
		// Output shortcodes stylesheet
		if ( function_exists("woo_shortcode_stylesheet") && get_option('framework_woo_disable_shortcodes') <> "true" )
			woo_shortcode_stylesheet();

		// Custom.css insert
		echo '<link href="'. get_bloginfo('template_directory') .'/custom.css" rel="stylesheet" type="text/css" />'."\n";   
	}
}
add_action('wp_head', 'woothemes_wp_head');


/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woo_head_css')) {
	function woo_head_css() {
	
		$output = '';
		$text_title = get_option('woo_texttitle');
	    $custom_css = get_option('woo_custom_css');
	
		$template = get_option('woo_template');
		foreach($template as $option){
			if(isset($option['id'])){
				if($option['id'] == 'woo_texttitle') {
					// Add CSS to output
					if ($text_title == "true") {
						$output .= '#logo img { display:none; }' . "\n";
						$output .= '#logo .site-title, #logo .site-description { display:block; } ' . "\n";
					} 
				}
			}
		}
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Woo Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
	
	}
}

/*-----------------------------------------------------------------------------------*/
/* Post Images from WP2.9+ integration /*
/*-----------------------------------------------------------------------------------*/
if(function_exists('add_theme_support')){
	if(get_option('woo_post_image_support') == 'true'){
		add_theme_support( 'post-thumbnails' );
		$thumb_width = get_option('woo_thumb_w');
		$thumb_height = get_option('woo_thumb_h');
		$single_width = get_option('woo_single_w');
		$single_height = get_option('woo_single_h');
		$hard_crop = get_option('woo_pis_hard_crop');
		if($hard_crop == 'true') {$hard_crop = true; } else { $hard_crop = false;}
		
		set_post_thumbnail_size($thumb_width,$thumb_height, $hard_crop); // Normal post thumbnails
		add_image_size( 'single-post-thumbnail', $single_width, $single_height, $hard_crop );
	}
}


/*-----------------------------------------------------------------------------------*/
/* Enqueue comment reply script */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woo_comment_reply')) {
	function woo_comment_reply() {
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
}
add_action('get_header', 'woo_comment_reply');


?>