<?php

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="follow, all" />
	<link rel="shortcut icon" href="<?php bloginfo('template_directory') ?>/favicon.ico" />
	<title><?php wp_title(' '); ?></title>


	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/reset.css?ver=1" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?ver=2" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/grid.css" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/post.css?ver=1" type="text/css" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,700,500' rel='stylesheet' type='text/css'>
	<!--wp_head()-->
	<?php 
	//this is the fix for bug with double title when sharing to google plus
	ob_start();
	wp_head(); 
	$c = ob_get_contents();
	ob_end_clean();
	
	$matches = array();
	preg_match_all("/<meta([^>]*)og:title([^>]*)\/>/iUs", $c, $matches);
	$c = preg_replace("/<meta([^>]*)og:title([^>]*)\/>/iUs", "", $c);
	echo $matches[0][0];
	echo $c;
	?>
	<!--/wp_head()-->
	
	<!--[if IE]>
	<style type="text/css">
	  .clearfix {
	    zoom: 1;
	    }  
	 #content {display:table;height:100%}
	</style>
	<![endif]-->

	<script type="text/javascript">var p="http",d="static";if(document.location.protocol=="https:"){p+="s";d="engine";}var z=document.createElement("script");z.type="text/javascript";z.async=true;z.src=p+"://"+d+".adzerk.net/ados.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(z,s);</script>
<script type="text/javascript">
var ados = ados || {};
ados.run = ados.run || [];
ados.run.push(function() {
/* load placement for account: e27, site: e27, size: 728x90 - Leaderboard, zone: Leaderboard Zone*/
ados_add_placement(4158, 20013, "azk96828", 4).setZone(14085);
/* load placement for account: e27, site: e27, size: 300x250 - Medium Rectangle, zone: Medium Rectangle Zone 1*/
ados_add_placement(4158, 20013, "azk55225", 5).setZone(14087);
ados_load();
});</script>
<style>
sup{
text-transform: uppercase;
}
</style>


</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	<a name="top"></a>
	<div id="topbar" class="clearfix">
		<div class="content">
			<?php 
				wp_nav_menu(array('theme_location' => 'header-left-menu', 'container' => false, 'menu_class' => 'left'));
			?>

			<?php 
				wp_nav_menu(array('theme_location' => 'header-right-menu', 'container' => false, 'menu_class' => 'right'));	
			?>
			<div id="searchbox2" class="right">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
		</div>
	</div>


	<div id="header">
		<div class="container container_2 clearfix">
			<div id="logo" class='grid_1' style="width: 25%;">
				<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/e27-logo.png" alt="<?php bloginfo('name'); ?>" /></a>
			</div>
			<div id="e27topads">
				<?php if (get_option('eg_ad_460x60_top_banner_enable', false) !== false && get_option('eg_ad_460x60_top_banner_enable', false) == '1') { ?>
					<?php if (get_option('eg_ad_460x60_top_banner_ad_sense', false) !== false && get_option('eg_ad_460x60_top_banner_ad_sense', false) != '') { ?>
						<?php echo get_option('eg_ad_460x60_top_banner_ad_sense', false); ?>
					<?php } else if (get_option('eg_ad_460x60_top_banner_image_location', false) !== false && get_option('eg_ad_460x60_top_banner_image_location', false) != '' && get_option('eg_ad_460x60_top_banner_dest_url', false) !== false && get_option('eg_ad_460x60_top_banner_dest_url', false) != '') { ?>
						<a href="<?php echo get_option('eg_ad_460x60_top_banner_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_460x60_top_banner_image_location', false); ?>" /></a>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div><!-- #header -->
	<div id="e27topics">
		<div class="container container_2 clearfix">
			<?php 
				wp_nav_menu(array('theme_location' => 'header-topics', 'container' => false, 'menu_class' => 'e27topics'));
			?>
		</div>
	</div><!-- e27topics -->
	<div id="content" class="clearfix" style="">