<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
	<?php if(is_home()) { ?>
		<?php bloginfo('name'); ?>
	<?php } else { ?>
		<?php wp_title(' '); ?>
		&raquo;	<?php bloginfo('name'); ?>
	<?php } ?>
</title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<meta name="alexaVerifyID" content="q6DTsL9X4uvp2ItWWph4PsTteps" />
<meta name="description" content="Community of technology startups in Asia." />
<meta name="keywords" content="e27 unconference echelon startup entrepreneurship venture capital VC angel technology consumer internet consumer web web 2.0 social media social networking marketing Singapore Indonesia China startups" />
 <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/e27_icon.ico">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style>
/*1st sub level menu*/
.NavBar ul.Menu li ul{
left: 0;
position: absolute;
top: 1em; /* no need to change, as true value set by script */
display: block;
visibility: hidden;
}
/*Sub level menu list items (undo style from Top level List Items)*/
.NavBar ul.Menu li ul li{
display: list-item;
float: none;
}
</style>

<script src="<?php bloginfo('template_directory'); ?>/menu.js?rev1" type="text/javascript"></script>

<script language="javascript">

/*
Auto center window script- Eric King (http://redrival.com/eak/index.shtml)
Permission granted to Dynamic Drive to feature script in archive
For full source, usage terms, and 100's more DHTML scripts, visit http://dynamicdrive.com
*/

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}

</script>

<script type="text/javascript">
	var emaildef = 'your email address here';
	var passdef = 'password';
	var searchdef = 'Search';
	
	function fillbox(){
		var emailbox=document.getElementById("username");
		var passbox=document.getElementById("password");
		var searchbox=document.getElementById("s");
		if (emailbox) emailbox.value = emaildef;
		if (searchbox) searchbox.value = searchdef;
		if (passbox) 
		{
			passbox.value = passdef;
			passbox.type = 'text';
		}
	}

	function swapPanel(DivId)
	{
		var getDivID=document.getElementById(DivId);
		var Tab1=document.getElementById("content1");
		var Tab2=document.getElementById("content2");
		var Tab3=document.getElementById("content3");
		Tab1.style.display="none";
		Tab2.style.display="none";
		if(Tab3) Tab3.style.display="none";
		getDivID.style.display="block";
	}

	function clearbox(id){
		var box=document.getElementById(id);
		if(id == 'username') { if(box.value == emaildef){box.value = '';} }
		else if(id == 's') { if(box.value == searchdef){box.value = '';} }
		else if(id == 'password') { 
			if(box.value == passdef){
				box.value = '';
				box.type = 'password';
			}
		}
	}

	function restorehint(id){
		var box=document.getElementById(id);
		if(id == 'username') { if(box.value == ''){box.value = emaildef;} }
		else if(id == 's') { if(box.value == ''){box.value = searchdef;} }
		else if(id == 'password') { 
			if(box.value == ''){
				box.value = passdef;
				box.type = 'text';
			} 
		}
	}
</script>

<script type="text/javascript">

/*Example message arrays for the two demo scrollers*/

<?php $custom_query = new WP_Query('category_name=blog&showposts=10'); ?>
<?php $linkid = 0; ?>
<?php if ($custom_query->have_posts()) : ?>
var tickercontent=new Array()
<?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
tickercontent[<?php echo $linkid ?>]='<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_time('d F Y') ?>: <?php the_title(); ?><?php //the_content_rss('', TRUE, '', 10); ?></a>'
<?php $linkid++; ?>
<?php endwhile; ?>
<?php endif; ?>

</script>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lightbox/css/lightbox.css" type="text/css" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/lightbox/scripts/prototype.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/lightbox/scripts/lightbox.js"></script>

<style type="text/css" media="screen">
</style>
<style type="text/css">
.zg_div {margin:0px 10px 10px 0px; width:300px;}
.zg_div_inner {border: solid 1px #000000; background-color: #ffffff;  color:#666666; text-align:center; font-family:arial, helvetica; font-size:11px; width: 200px;}
.zg_div a, .zg_div a:hover, .zg_div a:visited {color:#3993ff; background:inherit !important; text-decoration:none !important;}
</style>
<style type="text/css">
#flickr_badge_source_txt {padding:0; font: 11px Arial, Helvetica, Sans serif; color:#666666;}
#flickr_badge_icon {display:block !important; margin:0 !important; border: 1px solid rgb(0, 0, 0) !important;}
#flickr_icon_td {padding:0 5px 0 0 !important;}
.flickr_badge_image {text-align:center !important; width:190px;}
.flickr_badge_image img {border: 1px solid black !important; width:200px;margin:3;}
#flickr_badge_uber_wrapper {width:150px;}
#flickr_www {display:block; text-align:center; padding:0 10px 0 10px !important; font: 11px Arial, Helvetica, Sans serif !important; color:#3993ff !important;}
#flickr_badge_uber_wrapper a:hover,
#flickr_badge_uber_wrapper a:link,
#flickr_badge_uber_wrapper a:active,
#flickr_badge_uber_wrapper a:visited {text-decoration:none !important; background:inherit !important;color:#3993ff;}
#flickr_badge_wrapper {background-color:#ffffff;border: solid 1px #000000}
#flickr_badge_source {padding:0 !important; font: 11px Arial, Helvetica, Sans serif !important; color:#666666 !important;}
</style>
<?php wp_head(); ?>
<?php /*useful global declares*/
	$post_obj = $wp_query->get_queried_object();
	$post_ID = $post_obj->ID;
	$post_title = $post_obj->post_title;
	$post_name = $post_obj->post_name;
	
function get_page_id($page_title) {
	global $wpdb;
	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='page'", $page_title ));
	return $page;
}

function wt_get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}

?>
</head>

<body onload="fillbox()">
<!--[if IE]>  <div id="IEroot">  <![endif]-->
<!-- START OF WRAPPER -->
<div class="Wrapper">

	<div class="Top_bar">
	<p align="right" style="color:#fff;">About &nbsp;&nbsp; Team &nbsp;&nbsp; Business &nbsp;&nbsp;Press &nbsp;&nbsp;Partner &nbsp;&nbsp;Contact Us</p>
	<!-- DON'T DELETE --></div>
    
    <!-- START OF MIBBLE BAR -->
    <div class="Mid_bar">
    
    	<!-- START OF HEADER -->
        <div class="Header">
        
        	<div class="Logo"><a href="<?php bloginfo('url'); ?>"><img src="http://www.e27.sg/blog/wp-content/uploads/2010/04/e27_logo.png" id="e27_logo" width="215" height="100"/></a> &nbsp;&nbsp;
        	</div>

            
<a href="" onclick="FB.Connect.requireSession(); return false;" class="CFBox right fbc_hide_on_login" style="position:relative;"><img src="<?php bloginfo('template_directory'); ?>/images/Homepage_connect_facebook.gif" alt="facebook" /></a>

            <div class="Legend Smallbox">


<!-- facebook connect test -->
			<!--<?php 
			//do_action('fbc_display_login_state') 
			?> -->
<!-- /end -->


             <!--   <div class="Facebook">
                	<img src="<?php bloginfo('template_directory'); ?>/images/facebook_pic.gif" class="right" />
                    <span style="margin-top:10px;" class="right">
                    <?php global $user_ID, $user_identity, $user_level ?>
					<?php if ( $user_ID ) : ?>
                    <b>Welcome, <?php echo $user_identity ?></b><br />
                    <?php endif // $user_level >= 1 ?>
                	<a href="">Account Settings</a> | <a href="">Logout of Facebook</a>
                    </span><br class="clear">
                </div> -->
                
          <!--  <div class="Bannerad">
         <a href="http://www.innovfest.sg/"><img src="http://www.e27.sg/blog/wp-content/uploads/2010/02/Innovfest.jpg" alt="Innovfest" height= "60" width="500" align="left"/></a>
            </div> -->
            
            </div>
            
            <div class="clear"><!-- DON'T DELETE --></div>
            
            <div class="NavBar">
            
                <!-- START OF MENU -->
                <ul class="Menu" id="treemenu1">
                    <?php if (is_home()) {  ?>
                	<li><a href="<?php bloginfo('url'); ?>" class="activated">Home</a></li>
                    <?php } else {  ?>
					<li class="home_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>
                    <?php } ?>
		    <?php
			$companies_id = get_page_id('Companies');
			$corpnews_id = get_page_id('Corporate News');
			$service_id = get_page_id('Service Provider Directory');		
			$contact_id = get_page_id('Contact Us'); 
			$ad_id = get_page_id('Advertise'); ?>
			<?php wp_list_pages('title_li=&sort_column=menu_order&exclude='.$contact_id.','.$ad_id.','.$companies_id.','
																	.$corpnews_id.','.$service_id); ?>
				<li><a href="mailto:suggest@e27.sg">Tip Us</a></li>
                </ul>
                <!-- END OF MENU -->
                <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
            	<div class="SearchBox">
                	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="txtinput" /> 
                    <input type="submit" class="Search_btn" id="searchsubmit" value=""/>
                </div>
                </form>
                <div class="clear"><!-- DON'T DELETE --></div>
            
            </div>
        
        </div>
        <!-- END OF HEADER -->
