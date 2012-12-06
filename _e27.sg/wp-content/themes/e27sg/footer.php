	</div>
	<div id="bottombar" class="clearfix">
		<div id="footer" class="clearfix">
			<div class="container container_2 clearfix" style="margin-top: 20px; padding-bottom: 20px; text-align: left;">
				<div class='grid_1' style="width: 545px;">
					<?php if (function_exists('dynamic_sidebar'))  { 
						dynamic_sidebar(3);
					} else {
						?>
					<h3>Exploring e27</h3>
					<p>e27 covers the companies, people and technologies that are changing Asia's web and mobile ecosystem.</p>
					<p>e27 is managed by Optimatic Pte Ltd, a community-centric media company. </p>
					<h1 style="margin-top: 20px;">Our Partners</h1>
					<p>
						<img src="<?php bloginfo('template_directory') ?>/img/partners.png" />
					</p>
						<?php  
					} ?>
				</div>
				<div class='grid_1' style="width: 175px;">
					<?php if (function_exists('dynamic_sidebar'))  { 
						dynamic_sidebar(4);
					} else {
						?>
					<h3>Our Company</h3>
					<ul>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Contact Us</a></li>
						<li><a href="#">Announcements</a></li>
						<li><a href="#">Submit Stories</a></li>
						<li><a href="#">Advertise</a></li>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Legal</a></li>
					</ul>
						<?php  
					} ?>
				</div>
				<div class='grid_1' style="width: 175px;">
					<?php if (function_exists('dynamic_sidebar'))  { 
						dynamic_sidebar(5);
					} else {
						?>
					<h3>Our Sites</h3>
					<ul>
						<li><a href="#">Echelon 2012</a></li>
						<li><a href="#">Startup List</a></li>
					</ul>
						<?php  
					} ?>
				</div>
				<div class='grid_1' style="width: 175px;">
					<?php if (function_exists('dynamic_sidebar'))  { 
						dynamic_sidebar(6);
					} else {
						?>
					<h3>Connect With Us</h3>
					<div class="facebook-like">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/img/facebook-like.png" /></a>
					</div>
					<div class="twitter-follow">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/img/twitter-follow.png" /></a>
					</div>
					<div class="rss-subscribe">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/img/rss-subscribe.png" /></a>
					</div>
					<div class="newsletter-get">
						<a href="#"><img src="<?php bloginfo('template_directory') ?>/img/newsletter-get.png" /></a>
					</div>
						<?php  
					} ?>
				</div>
			</div>
			<p>Copyright &copy; 2012 e27 - Web Innovation in Asia. All Rights Reserved. Use of this site is subject to terms of use, which prohibit commercial use of this site. By continuing past this page, you agree to abide by these terms.</p>
		</div><!-- #footer -->
	</div><!-- #bottombar -->
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/e27sg.json?callback=twitterCallback2&count=1"></script>

	<script type="text/javascript">
  (function() {
    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
    li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
  })();
</script>
</body>
</html>