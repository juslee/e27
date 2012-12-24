<?php 

/*-----------------------------------------------------------------------------------*/
/* WooThemes Framework Version & Theme Version */
/*-----------------------------------------------------------------------------------*/
function woo_version_init(){

    $woo_framework_version = '3.0.03';
    update_option('woo_framework_version',$woo_framework_version);
	
}
add_action('init','woo_version_init');

function woo_version(){
    
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
    $woo_framework_version = get_option('woo_framework_version');

    echo '<meta name="generator" content="'. get_option('woo_themename').' '. $theme_version .'" />' ."\n";
    echo '<meta name="generator" content="Woo Framework Version '. $woo_framework_version .'" />' ."\n";
   
}
// Add or remove Generator meta tags
if ( get_option('framework_woo_disable_generator') == "true" )
	remove_action('wp_head', 'wp_generator');
else 
	add_action('wp_head','woo_version');

/*-----------------------------------------------------------------------------------*/
/* Load the required Framework Files */
/*-----------------------------------------------------------------------------------*/

$functions_path = TEMPLATEPATH . '/functions/';

require_once ($functions_path . 'admin-setup.php');			// Options panel variables and functions
require_once ($functions_path . 'admin-functions.php');		// Custom functions and plugins
require_once ($functions_path . 'admin-custom.php');		// Custom fields 
require_once ($functions_path . 'admin-theme-page.php');	// Buy More Themes Page
require_once ($functions_path . 'admin-interface.php');		// Admin Interfaces (options,framework, seo)
require_once ($functions_path . 'admin-hooks.php');			// Definition of WooHooks
require_once ($functions_path . 'admin-custom-nav.php');	// Woo Custom Navigation
require_once ($functions_path . 'admin-shortcodes.php');	// Woo Shortcodes

?>