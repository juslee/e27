
<div class="row-fluid socials add-bot" >
	<div class="span4" >
	  <div <?php /* onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'Facebook']);" */ ?> class="fb-like" data-href="http://www.facebook.com/e27" data-send="false" data-width="280" data-show-faces="true" data-font="arial"></div>
	</div>
	<div class="span4" >
		<div>
		<a <?php /* onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'Twitter']);" */ ?> href="https://twitter.com/e27sg" class="twitter-follow-button" data-show-count="true">Follow @e27sg</a> 
		</div>
		<!--
		<div class="twitter-feed">
		  <p>Call for startup pitch! hurry up for the life time experience!<br/><em>6 hours ago by <span class="text-success">e27</span></em></p>  
		</div>
		<div class="twitter-feed">
		  <p>Call for startup pitch! hurry up for the life time experience!<br/><em>6 hours ago by <span class="text-success">e27</span></em></p>  
		</div>
		-->
	</div>
	<div class="span4" >
	  <div class="subscribe add-left-med">
		<h3>Subscribe for <br/>Echelon Newsletter</h3>
		<!--
		<input type="text" placeholder="Your Email"/>
		<a class="btn btn-success subscribe" data-toggle="modal" href="#signupModal">Subscribe</a>
		-->
		
		<form style="display: inline;"  action="http://e27.us1.list-manage2.com/subscribe/post?u=5d6bc43500e46f74ebde550e9&id=304859caf2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
			<!-- <label for="mce-EMAIL">Receive e27 newsletters</label> -->
			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter you email:" required>
			<input type="submit" value="Subscribe &gt;" name="subscribe" id="mc-embedded-subscribe" class="btn btn-success subscribe">
			<p class="txt-small">Don't worry! we hate spam too!</p>
		</form>
	  </div>            
	</div>
  </div>
</div>
<div class="footer-extras">
  <div class="container">
	<div class="row">
	  <div class="span3-ftr-cnter  logo-e27"><a href="" alt="e27 Web Innovation Asia" title="e27 Web Innovation Asia">e27 logo</a></div>
	  <div class="span7 about-small">
		<!--
		<h3>Your event organizer, e27</h3>
		<p>Founded in 2007, e27 is a media organization focused on the Asian technology startup industry.
		  We believe in building the community of technology innovators across Asia by reporting on the latest,
		  breaking news relevant to technology startups, technology companies as well as investors on the  while
		  keeping our ears to the ground by connecting with our readers </p>
		-->
		
		<h3><?php echo get_option("echelon_fphead_3"); ?></h3>
		<?php echo stripslashes(html_entity_decode(get_option("echelon_fptext_3"))); ?>
	  </div>
	  <div class="span2 social-footer pull-right">
		<h3>Stay Connected</h3>
		<div class="inner-social-footer">
		  <ul class="social-icons-footer clearfix">
			<li>
			  <span class="twitter"></span>
			  <a href="">Twitter</a>
			</li>
			<li>
			  <span class="facebook"></span>                  
			  <a href="">Facebook</a>
			</li>
			<li>
			  <span class="google"></span>
			  <a href="">Google+</a>
			</li>   
			<li>
			  <span class="linkedin"></span>  
			  <a href="">LinkedIn</a></li>
		  </ul>
		</div>
	  </div>
	</div>      
  </div>
</div>
<footer class="footer">
  <div class="container add-top-small c-text">
	<div class="pull-left">&copy;2012 Echelon | e27 Web Innovation Asia</div>
	<div class="pull-right"><a href="/about">About</a> | <a href="/contact">Contact</a> | <a href="/register">Register</a></div>  
  </div>    
</footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

 
<?php wp_footer(); ?> 
  </body>
</html>
