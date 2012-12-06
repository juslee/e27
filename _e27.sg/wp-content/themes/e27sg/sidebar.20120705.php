				<div id="sidebar" class='grid_1' style="width: 320px; padding-left: 15px; border-left: 1px solid #000000; ">
					<!--  Start Social Block -->
					<div>
						<div id="social-bookmark-container">
							<div class="social-header">
								Be part of E27sg
							</div>
							<div class="social-thumbs">
								<span class="fb"><span class="st_facebook_custom"><img src="<?php bloginfo('template_directory') ?>/img/icon-facebook.png"></span></span>
								<span class="tw"><span class="st_twitter_custom"><img src="<?php bloginfo('template_directory') ?>/img/icon-twitter.png"></span></span>
								<span class="lk"><span class="st_linkedin_custom"><img src="<?php bloginfo('template_directory') ?>/img/icon-linkedin.png"></span> </span>
								<span class="gp"><span class="st_googleplus_custom"><img class="gp" src="<?php bloginfo('template_directory') ?>/img/icon-googleplus.png"></span></span>
								<span class="rss"><span class="st_rss_custom"><img class="gp" src="<?php bloginfo('template_directory') ?>/img/icon-rss.png"></span></span>
								<span class="nw"><img class="nw" src="<?php bloginfo('template_directory') ?>/img/icon-newsletter.png"> </span>
							</div>
							<div class="social-bottom <?php echo (get_option('eg_newsletter_learn_more_link', '') !== false && get_option('eg_newsletter_learn_more_link', '') != '' ? 'nw-learn' : '') ?>">
								<span class="carrot"></span>
								<div class="fb-bottom">
									<div class="fb-like" data-href="http://www.facebook.com/e27sg" data-send="false" data-width="280" data-show-faces="false" data-font="arial"></div>
								</div>
								<div class="tw-bottom hidethisblock">
									<a href="https://twitter.com/e27sg" class="twitter-follow-button" data-show-count="true">Follow @e27sg</a>
								</div>
								<div class="lk-bottom hidethisblock">
									<script type="IN/Share" data-url="http://www.linkedin.com/company/e27-singapore" data-counter="right"></script>
								</div>
								<div class="gp-bottom hidethisblock">								
									<g:plusone href="https://plus.google.com/115156064497501931516" data-counter="right"></g:plusone>
								</div>
								<div class="rss-bottom hidethisblock">
									<a href="http://feeds.feedburner.com/e27/Kabk"><img src="<?php bloginfo('template_directory') ?>/img/feed-icon-14x14.png" style="vertical-align: middle;" /> Subscribe to our RSS feed.</a>
								</div>
								<div class="nw-bottom hidethisblock">
									<form action="http://e27.us1.list-manage.com/subscribe/post" method="POST" target="_blank" class="validate">
										<input type="hidden" name="u" value="5d6bc43500e46f74ebde550e9">
										<input type="hidden" name="id" value="8371d88426">
										<input type="hidden" name="EMAILTYPE" value="html">
										<input type="email" required="" placeholder="Receive E27.sg newsletters" id="" class="email" name="EMAIL" value="">
										<input type="submit" class="nw_button" id="" name="subscribe" value="Subscribe &gt;">
										<?php if (get_option('eg_newsletter_learn_more_link', '') !== false && get_option('eg_newsletter_learn_more_link', '') != '') { ?>
										<a href="<?php echo get_option('eg_newsletter_learn_more_link', '') ?>" target="_blank">Learn More &gt;&gt;</a>
										<?php } ?>										
									</form>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(".social-thumbs span").mouseover(function(){
						        $(".social-bottom > div").addClass("hidethisblock");
						        var whatsocial = $(this).attr("class");
						        $('.' + whatsocial + '-bottom').removeClass("hidethisblock");
							});
							$("span.fb").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "0.15in",
							  }, 100 );
							});
							
							$("span.tw").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "0.65in",
							  }, 100 );
							});
							
							$("span.lk").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "1.12in",
							  }, 100 );
							});
							
							$("span.gp").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "1.62in",
							  }, 100 );
							});
							
							$("span.rss").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "2.15in",
							  }, 100 );
							});
							
							$("span.nw").mouseover(function(){
							  $("span.carrot").animate({
							    marginLeft: "2.64in",
							  }, 100 );
							});
						</script>
					</div>
					<!--  End Social Block -->
					<?php if (function_exists('dynamic_sidebar'))  { ?>
					<div class="container container_2 clearfix sidebar_widget" style="margin-top: 20px;">
						<div class='grid_1' style="width: 100%;">
						<?php dynamic_sidebar(1); ?>
						</div>
					</div>								
					<?php } ?>
					<?php 
					/**
					 * 
								<h1>Submit <span class="gray">a story</span></h1>
								<p>Got a tip, a story our readers should read?</p>
								<p style="margin-top: 5px;"><a href="#" class="green">Tell us about it</a></p>
					 * 
					<div class="container container_2 clearfix" style="margin-top: 20px;">
						<div class='grid_1'>
							<div style="margin-right: 10px;">
								<?php if (function_exists('dynamic_sidebar'))  { 
									dynamic_sidebar(1);
								} else {
									?>
								<h1>Submit <span class="gray">a story</span></h1>
								<p>Got a tip, a story our readers should read?</p>
								<p style="margin-top: 5px;"><a href="#" class="green">Tell us about it</a></p>
									<?php  
								} ?>
							</div>
						</div>
						<div class='grid_1' style="width: 49%; border-left: 1px solid #C8C8C8;">
							<div style="margin-left: 10px;">
								<?php if (function_exists('dynamic_sidebar'))  { 
									dynamic_sidebar(2);
								} else {
									?>
								<h1>Find <span class="gray">work</span></h1>
								<p>Rocket Internet Singapore Pte Ltd is hiring a Senior Manager SEM</p>
									<?php  
								} ?>
							</div>
						</div>
					</div>
					 */
					?>
<script type="text/javascript">
function twitterCallback2(twitters) {
	var statusHTML = [];
	for (var i=0; i<twitters.length; i++){
		var username = twitters[i].user.screen_name;
	    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
	    	return '<a href="'+url+'">'+url+'</a>';
	    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
	      	return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
	    });
	    statusHTML.push('<li><span>'+status+'</span> <a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');
	}
	document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
	$('#tweet_latest_container').show();
}

function relative_time(time_value) {
	  var values = time_value.split(" ");
	  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	  var parsed_date = Date.parse(time_value);
	  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	  delta = delta + (relative_to.getTimezoneOffset() * 60);

	  if (delta < 60) {
	    return 'less than a minute ago';
	  } else if(delta < 120) {
	    return 'about a minute ago';
	  } else if(delta < (60*60)) {
	    return (parseInt(delta / 60)).toString() + ' minutes ago';
	  } else if(delta < (120*60)) {
	    return 'about an hour ago';
	  } else if(delta < (24*60*60)) {
	    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	  } else if(delta < (48*60*60)) {
	    return '1 day ago';
	  } else {
	    return (parseInt(delta / 86400)).toString() + ' days ago';
	  }
}
</script>
					<div id="tweet_latest_container" class="container container_2 clearfix" style="margin-top: 20px; display: none;">
						<div class='grid_1' style="width: 50px;">
							<img src="<?php bloginfo('template_directory') ?>/img/icon-twitter-green-lg.png">
						</div>
						<div id="tweet_latest_content" class='grid_1' style="width: 270px">
							<div style="padding: 5px;"><ul id="twitter_update_list"></ul></div>
						</div>
					</div>
					<div id="tweet_follow_container" style="margin-top: 10px; margin-bottom: 20px;">
						<a class="button white" href="https://twitter.com/e27sg">Follow @E27sg</a>
						<a href="https://twitter.com/e27sg" id="twitter-count" class="triangle-border left" style="display: none;"></a>
						<?php 
						/* <a href="https://twitter.com/e27sg" class="twitter-follow-button" data-show-count="true" data-size="large">Follow @e27sg</a> */
						?>
					</div>
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		$.ajax({
			url: 'http://api.twitter.com/1/users/show.json',
			data: { screen_name: 'e27sg' },
			dataType: 'jsonp',
			success: function(data) {
				$('#twitter-count').html(data.followers_count.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",")+" followers");
				$('#twitter-count').show();
			}
		});
	});
});
</script>					
					<?php if (get_option('eg_ad_side_banner1_enable', false) !== false && get_option('eg_ad_side_banner1_enable', false) == '1') { ?>
					<div class="side advertisement">
						<?php if (get_option('eg_ad_side_banner1_ad_sense', false) !== false && get_option('eg_ad_side_banner1_ad_sense', false) != '') { ?>
							<?php echo get_option('eg_ad_side_banner1_ad_sense', false); ?>
						<?php } else if (get_option('eg_ad_side_banner1_image_location', false) !== false && get_option('eg_ad_side_banner1_image_location', false) != '' && get_option('eg_ad_side_banner1_dest_url', false) !== false && get_option('eg_ad_side_banner1_dest_url', false) != '') { ?>
							<a href="<?php echo get_option('eg_ad_side_banner1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner1_image_location', false); ?>" /></a>
						<?php } ?>
					</div>
					<?php } ?>
					
					<?php if (function_exists('dynamic_sidebar'))  { ?>
					<div class="container container_2 clearfix sidebar_widget" style="margin-top: 20px;">
						<div class='grid_1' style="width: 100%;">
						<?php dynamic_sidebar(2); ?>
						</div>
					</div>
					<?php } ?>
					
					<?php $saved = $wp_query; ?>
					<?php query_posts(array('showposts' => 5, 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => '_shares_total')); ?>
					<?php if (have_posts()) : $count = 0; ?>
					<div id="top_posts_container" class="container container_2 clearfix" style="margin-top: 20px;">
						<h3><span>Top <span class="gray">Posts</span></span></h3>
						<?php while (have_posts()) : the_post(); $count++; ?>		
						<div class="top_posts_story container container_2 clearfix">
							<div class='top_posts_image grid_1' style="width: 30%;">
								<a href="<?php the_permalink() ?>" class="clearfix">
								<?php echo_first_image(get_the_ID(), 80); ?>
								</a>
								<div class="caption"><p><?php echo $count ?></p></div>
							</div>
							<div class='grid_1' style="width: 70%;">
								<div class="top_posts_teaser">
									<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
								</div>
								<div class="top_posts_social">
									<span class="facebook-likes">
										<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
									</span>
									<span class="twitter-tweets">
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
									</span>
								</div>
							</div>
						</div>
						<?php endwhile; ?> 					
					</div>
					<?php endif; $wp_query = $saved; ?>
					
					<?php if (get_option('eg_ad_side_banner2_enable', false) !== false && get_option('eg_ad_side_banner2_enable', false) == '1') { ?>
					<div class="side advertisement">
						<?php if (get_option('eg_ad_side_banner2_ad_sense', false) !== false && get_option('eg_ad_side_banner2_ad_sense', false) != '') { ?>
							<?php echo get_option('eg_ad_side_banner2_ad_sense', false); ?>
						<?php } else if (get_option('eg_ad_side_banner2_image_location', false) !== false && get_option('eg_ad_side_banner2_image_location', false) != '' && get_option('eg_ad_side_banner2_dest_url', false) !== false && get_option('eg_ad_side_banner2_dest_url', false) != '') { ?>
							<a href="<?php echo get_option('eg_ad_side_banner2_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner2_image_location', false); ?>" /></a>
						<?php } ?>
					</div>
					<?php } ?>
					
					<?php $saved = $wp_query; ?>
					<?php
						$todaysDate = date("Y-m-d H:i:s");
						query_posts('showposts=20&category_name=events&meta_key=enddate&meta_compare=>=&meta_value=' . $todaysDate . '&orderby=meta_value&order=ASC');
					?>					
					<?php if (have_posts()) : $count = 0; ?>
					<div id="upcoming_events_container" class="container container_2 clearfix" style="margin-top: 20px;">
						<h3><span>Upcoming <span class="gray">Events</span></span></h3>
						<?php while (have_posts()) : the_post(); $count++; ?>
						<div class="upcoming_event container container_2 clearfix">
							<div class='grid_1' style="width: 70%;">
								<div class="upcoming_event_title">
									<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
								</div>
								<div class="upcoming_event_location"><?php echo get_post_meta(get_the_ID(), 'location', true) ?></div>
							</div>
							<div class='grid_1' style="width: 30%;">
								<div class="upcoming_event_date">
									<?php 
									$start_date = date('M j', strtotime(get_post_meta(get_the_ID(), 'startdate', true)));
									$end_date = date('M j', strtotime(get_post_meta(get_the_ID(), 'enddate', true)));
									$duration = "";
									if ($start_date == $end_date)
										$duration = $start_date;
									else
										$duration = $start_date . " - " . date('j', strtotime(get_post_meta(get_the_ID(), 'enddate', true)));
									?>
									<a href="<?php the_permalink() ?>"><?php echo $duration ?></a>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>
					<?php //remove_filter( 'posts_where', 'date_check_where' ); ?>
					<?php endif; $wp_query = $saved; ?>
					
					<div class="side advertisement">
						<div class="container container_2 clearfix" style="text-align: center;">
							<div class='grid_1'>
							<?php if (get_option('eg_ad_side_banner3_enable', false) !== false && get_option('eg_ad_side_banner3_enable', false) == '1') { ?>
								<?php if (get_option('eg_ad_side_banner3_ad_sense', false) !== false && get_option('eg_ad_side_banner3_ad_sense', false) != '') { ?>
									<?php echo get_option('eg_ad_side_banner3_ad_sense', false); ?>
								<?php } else if (get_option('eg_ad_side_banner3_image_location', false) !== false && get_option('eg_ad_side_banner3_image_location', false) != '' && get_option('eg_ad_side_banner3_dest_url', false) !== false && get_option('eg_ad_side_banner3_dest_url', false) != '') { ?>
									<a href="<?php echo get_option('eg_ad_side_banner3_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner3_image_location', false); ?>" /></a>
								<?php } ?>
							<?php } ?>
							</div>
							<div class='grid_1'>
							<?php if (get_option('eg_ad_side_banner4_enable', false) !== false && get_option('eg_ad_side_banner4_enable', false) == '1') { ?>
								<?php if (get_option('eg_ad_side_banner4_ad_sense', false) !== false && get_option('eg_ad_side_banner4_ad_sense', false) != '') { ?>
									<?php echo get_option('eg_ad_side_banner4_ad_sense', false); ?>
								<?php } else if (get_option('eg_ad_side_banner4_image_location', false) !== false && get_option('eg_ad_side_banner4_image_location', false) != '' && get_option('eg_ad_side_banner4_dest_url', false) !== false && get_option('eg_ad_side_banner4_dest_url', false) != '') { ?>
									<a href="<?php echo get_option('eg_ad_side_banner4_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner4_image_location', false); ?>" /></a>
								<?php } ?>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>