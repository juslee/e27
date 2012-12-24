    <!-- Footer Widget Area Starts -->
	<div id="footer-widgets">
		<div class="container col-full">
            <div class="block">
                <?php woo_sidebar('footer-1'); ?>		           
            </div>
            <div class="block">
                <?php woo_sidebar('footer-2'); ?>		           
            </div>
            <div class="block last">
                <?php woo_sidebar('footer-3'); ?>		           
            </div>
   			<div class="fix"></div>
		</div>    
    </div>
    <!-- Footer Widget Area Ends -->

	<div id="footer">
		<div class="col-full">
            <div id="copyright" class="col-left">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>. <?php _e('All Rights Reserved.', 'e27') ?></p>
                <p>Use of this site is subject to terms of use, which prohibit commercial use of this site. 
                By continuing past this page, you agree to abide by these terms.</p>
            </div>
		</div>
	</div>
	<!-- footer Ends -->
	
</div><!-- /#container -->

<?php wp_footer(); ?>

<?php if ( get_option('woo_twitter') && get_option('woo_ad_top') <> "true") { ?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo get_option('woo_twitter'); ?>.json?callback=twitterCallback2&amp;count=1"></script>
<?php } ?>

<script type="text/javascript">
setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0010/6428.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>


</body>
</html>