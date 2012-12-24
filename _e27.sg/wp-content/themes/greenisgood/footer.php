		<div id="footer" class="clearfix">
			<div class="container container_2 clearfix" style="margin-top: 20px; padding-bottom: 20px; text-align: left;">
				<div class='grid_1' style="width: 545px;">
					<?php if (function_exists('dynamic_sidebar'))  { 
						dynamic_sidebar(3);
					} else {
						?>
					<h1>Exploring <span class="gray">e27</span></h1>
					<p>e27 covers the companies, people and technologies that are changing Asia's web and mobile ecosystem.</p>
					<p>e27 is managed by Optimatic Pte Ltd, a community-centric media company. </p>
					<h1 style="margin-top: 20px;">Our <span class="gray">Partners</span></h1>
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
					<h1>Our <span class="gray">Company</span></h1>
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
					<h1>Our <span class="gray">Sites</span></h1>
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
					<h1>Connect <span class="gray">With Us</span></h1>
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
		</div>
	</div>
	<div id="bottombar" class="clearfix">
		<div class="content clearfix" style="">
			<div class="container container_2 clearfix">
				<div class='grid_1'>
					<p>Copyright &copy; 2012 e27 - Web Innovation in Asia. All Rights Reserved.</p>
					<p class="fine_print">Use of this site is subject to terms of use, which prohibit commercial use of this site. By continuing past this page, you agree to abide by these terms.</p>
				</div>
				<div class='grid_1' style="text-align: right;">
					<?php 
						wp_nav_menu(array('theme_location' => 'footer-right-menu', 'container' => false, 'menu_class' => 'right'));
						/*
					<ul>
						<li><a href="#">Advertising</a></li>
						<li><a href="#">Jobs</a></li>
						<li class="last"><a href="#">Legal</a></li>
					</ul>
						 */
					?>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function (e) {
		$('.search-box.expand a:first').bind('click', function (e) {
			$('.search-body.expanded').slideToggle();
			return false;
		});
		$('#edit-search').bind('focus', function (e) {
			var currentvalue = $(this).val();
			if (currentvalue == 'SEARCH') {
				$(this).val('');
			}
		});
		$('#edit-search').bind('blur', function (e) {
			$('.search-body.expanded').hide('slow');
		});
	});
	</script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/e27sg.json?callback=twitterCallback2&count=1"></script>
	
	<!-- Quantcast Tag -->
	<script type="text/javascript">
	var _qevents = _qevents || [];
	
	(function() {
	var elem = document.createElement('script');
	elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
	elem.async = true;
	elem.type = "text/javascript";
	var scpt = document.getElementsByTagName('script')[0];
	scpt.parentNode.insertBefore(elem, scpt);
	})();
	
	_qevents.push({
	qacct:"p-W0DvzLULBJ-FW"
	});
	</script>
	
	<noscript>
	<div style="display:none;">
	<img src="//pixel.quantserve.com/pixel/p-W0DvzLULBJ-FW.gif" border="0" height="1" width="1" alt="Quantcast"/>
	</div>
	</noscript>
	<!-- End Quantcast tag -->

	<!-- CrazyEgg Tag -->
	<script type="text/javascript">
	setTimeout(function(){var a=document.createElement("script");
	var b=document.getElementsByTagName("script")[0];
	a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0010/6428.js?"+Math.floor(new Date().getTime()/3600000);
	a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>
	<!-- End CrazyEgg tag -->
	
	<!-- Clickheat Tag -->
	<script type="text/javascript" src="http://www.e27.sg/clickheat/js/clickheat.js"></script>
	<noscript><p><a href="http://www.dugwood.com/index.html">Heatmap plugin</a></p></noscript>
	<script type="text/javascript"><!--
	clickHeatSite = 'e27.sg';
	clickHeatGroup = encodeURIComponent(window.location.pathname+window.location.search);
	clickHeatServer = 'http://www.e27.sg/clickheat/click.php';
	initClickHeat(); //-->
	</script>
	<!-- End Clickheat tag -->
	
	<!-- ASM script begin -->
	<div id="cX-root" style="display:none"></div>
	<script type="text/javascript">
	  var cX = cX || {}; cX.callQueue = cX.callQueue || [];
	  cX.callQueue.push(['setAccountId', '9222288788306660903']);
	  cX.callQueue.push(['setSiteId', '9222288788306660904']);
	  cX.callQueue.push(['sendPageViewEvent']);
	</script>
	<script type="text/javascript">
	  (function() { try { var scriptEl = document.createElement('script'); scriptEl.type = 'text/javascript'; scriptEl.async = 'async';
	  scriptEl.src = ('https:' == document.location.protocol) ? 'https://scdn.cxense.com/cx.js' : 'http://cdn.cxense.com/cx.js';
	  var targetEl = document.getElementsByTagName('script')[0]; targetEl.parentNode.insertBefore(scriptEl, targetEl); } catch (e) {};} ());
	</script>
	<!-- ASM script end -->
	
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-230825-12']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
</body>
</html>