<div id="sidebar" class="col-<?php if ( get_option('woo_left_sidebar') == "true" ) echo 'left'; else echo 'right'; ?>">

	<!-- Widgetized Sidebar -->	
	<?php woo_sidebar('sidebar-top'); ?>

	
	<!-- Custom Sidebar -->
	<div id="side-follow"  class="widget">
		<div class="side-box">
			
			<div id="email-subscribe">
			<h3><em>Follow</em> our updates.</h3>
				<form action="http://e27.us1.list-manage.com/subscribe/post" method="POST">
				<input type="hidden" name="u" value="5d6bc43500e46f74ebde550e9">
				<input type="hidden" name="id" value="8371d88426">
				    <label for="MERGE0"><strong>Email Address</strong> <em>*</em></label>
	
				    <input type="text" name="MERGE0" id="MERGE0" size="25" value="email" onfocus="if (this.value == 'email') this.value = '';" onblur="if (this.value == '') this.value = 'email';" >.
				        <fieldset>
					        <input type="radio" name="EMAILTYPE" id="EMAILTYPE_HTML" value="html" checked><label for="EMAILTYPE_HTML">HTML</label>&nbsp; &nbsp;
					        <input type="radio" name="EMAILTYPE" id="EMAILTYPE_TEXT" value="text" ><label for="EMAILTYPE_TEXT">Text</label>&nbsp; &nbsp;
					        <input type="radio" name="EMAILTYPE" id="EMAILTYPE_MOBILE" value="mobile" ><label for="EMAILTYPE_MOBILE">Mobile</label>
				        </fieldset>
				<input class="button" type="submit" value="Subscribe">			
				</form>			
			</div> 	<!-- end email subscribe -->
			
			<div id="sidebar-social">
				<ul>
					<li id="icon-facebook"><a href="http://www.facebook.com/e27sg">Facebook</a></li>
					<li id="icon-twitter"><a href="http://twitter.com/e27sg">Twitter</a></li>
					<li id="icon-flickr"><a href="http://www.flickr.com/photos/e27sg">Flickr</a></li>
					<li id="icon-rss"><a href="http://feeds.feedburner.com/e27/Kabk">RSS</a></li>
					<li id="icon-slideshare"><a href="http://www.slideshare.net/e27sg">Slideshare</a></li>
				</ul>
			</div><!-- end social icons -->
		</div>
	</div>	


	<!-- TABS STARTS --> 
	<?php if (get_option('woo_tabs') == "true") { ?>
	<div id="tabs">
		
		<ul class="wooTabs tabs">
			<li><a href="#pop"><?php _e('Popular', 'woothemes'); ?></a></li>
			<li><a href="#feat"><?php _e('Latest', 'woothemes'); ?></a></li>
            <li><a href="#comm"><?php _e('Comments', 'woothemes'); ?></a></li>
			<li><a href="#tagcloud"><?php _e('Tags', 'woothemes'); ?></a></li>
		</ul>	
		
		<div class="fix"></div>
		
		<div class="inside">
		 <div id="pop">
			<ul>
			<?php include(TEMPLATEPATH . '/includes/popular.php' ); ?>                    
			</ul>
           </div>
           
         <div id="feat"> 
	        <ul>
			<?php include(TEMPLATEPATH . '/includes/latest.php' ); ?>                    
			</ul>
          </div>
          <div id="comm">  
			<ul>
			<?php include(TEMPLATEPATH . '/includes/comments.php' ); ?>                    
			</ul>
	      </div>
			<div id="tagcloud">
			    <?php wp_tag_cloud('smallest=12&largest=20'); ?>
			</div>
		
	</div><!-- INSIDE END -->
	
	</div><!-- TABS END -->
	
	<div class="fix" style="height:25px !important;"></div>
	
	<?php } ?>  
	<!-- TABS END -->    
    
	<!-- Widgetized Sidebar -->	
	<?php woo_sidebar('sidebar'); ?>		
    <?php woo_sidebar('sidebar-bottom'); ?>         
	
</div><!-- /#sidebar -->