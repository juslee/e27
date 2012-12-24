<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?php bloginfo('name'); ?> <?php wp_title('-'); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/reset.css" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/grid.css" type="text/css" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	<!--[if IE]>
	<style type="text/css">
	  .clearfix {
	    zoom: 1;
	    }  
	 #content {display:table;height:100%}
	</style>
	<![endif]-->
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
	<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
	<a name="top"></a>
	<div id="topbar" class="clearfix">
		<div class="content">
			<?php 
				wp_nav_menu(array('theme_location' => 'header-left-menu', 'container' => false, 'menu_class' => 'left'));
				/*
			<ul class="left">
				<li><a href="#" class="selected">HOME</a></li>
				<li><a href="#">ECHELON 2012</a></li>
				<li><a href="#">STARTUP LIST</a></li>
			</ul>
				 */ 
			?>
			<?php 
				wp_nav_menu(array('theme_location' => 'header-right-menu', 'container' => false, 'menu_class' => 'right'));
				/*
			<ul class="right">
				<li class="search-box expand">
					<a href="#">SEARCH <img src="<?php bloginfo('template_directory') ?>/img/icon-search.png" style="vertical-align: middle;"></a>
					<div class="search-body expanded" style="display: none;">
						<div class="clear-block block block-fc_helper" id="block-fc_helper-fc_search">				
							<h2><span><none></none></span></h2>
							<div class="content">
								<form id="fc-helper-search-form" method="get" accept-charset="UTF-8" action="<?php echo home_url( '/' ) ?>">
								<div>
									<div id="edit-search-wrapper" class="form-item">
										<input type="text" class="form-text" value="<?php echo (get_search_query() ? get_search_query() : 'SEARCH') ?>" size="60" id="edit-search" name="s" maxlength="128" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
									</div>
					 			</div>
					 			</form>
					 		</div>
					 	</div>
					 </div>
				</li>
				<li><a href="#">ABOUT</a></li>
				<li><a href="#">CONTACT</a></li>
			</ul> 
				 */
			?>
		</div>
	</div>

	<div id="content" class="clearfix" style="">
		<div id="header">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 25%;">
					<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/e27-logo.png" alt="<?php bloginfo('name'); ?>" /></a>
				</div>
				<div class='grid_1' style="width: 75%; text-align: right;">
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
		</div>
		<div class="separator"></div>