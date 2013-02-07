				<div id="sidebar" class='grid_1'>
					<!--  Start Social Block -->
					<div>
						<?php 
						if (get_option('eg_ad_side_banner1_enable', false) !== false && get_option('eg_ad_side_banner1_enable', false) == '1') { 
							?>
							<div class="side advertisement" style='padding-bottom:10px'>
								<?php if (get_option('eg_ad_side_banner1_ad_sense', false) !== false && get_option('eg_ad_side_banner1_ad_sense', false) != '') { ?>
									<?php echo get_option('eg_ad_side_banner1_ad_sense', false); ?>
								<?php } else if (get_option('eg_ad_side_banner1_image_location', false) !== false && get_option('eg_ad_side_banner1_image_location', false) != '' && get_option('eg_ad_side_banner1_dest_url', false) !== false && get_option('eg_ad_side_banner1_dest_url', false) != '') { ?>
									<a href="<?php echo get_option('eg_ad_side_banner1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner1_image_location', false); ?>" /></a>
								<?php } ?>
							</div>
							<?php 
						} 
						?>
						<div id="top_posts_container" class="section f container container_2 clearfix">
						  <h3><span>Subscribe To e27</span></h3>
						  <div id="follow-e27-f">    
						    <div class="fb-like-box">

						      <div onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'Facebook']);" class="fb-like" data-href="http://www.facebook.com/e27" data-send="false" data-width="280" data-show-faces="false" data-font="arial"></div>

						    </div>
						    <div class="gplusone">
						      <g:plusone href="https://plus.google.com/115156064497501931516" annotation="inline" width="300" onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'Google Plus']);"></g:plusone>
						    </div>
						    <div class="twitter-follow">
						      <a onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'Twitter']);" href="https://twitter.com/e27co" class="twitter-follow-button" data-show-count="true">Follow @e27co</a> 
						    <div class="follow-options">
						      <ul class="social">
						        <li class="linkedin">
						          <a onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Social Links', 'LinkedIn']);"rel="nofollow external" title="LinkedIn" href="http://www.linkedin.com/company/404308" target="_blank">LinkedIn</a>
						        </li>
						        <li class="youtube">
						          <a rel="nofollow external" title="YouTube" href="http://www.youtube.com/e27singapore" target="_blank">YouTube</a>
						        </li>
						        <li class="stumbleupon">
						          <a rel="nofollow external" title="StumbleUpon" href="http://www.stumbleupon.com/stumbler/E27sg" target="_blank">Stumble</a>
						        </li>
						        <li class="rss">
						          <a rel="nofollow external" title="RSS Feed" href="http://feeds.feedburner.com/e27/Kabk" class="tooltip-anchor" target="_blank">RSS </a>
									<div class="tooltip"><p><strong>RSS Feed</strong><br>591,312+ Subscribers</p></div>
						         </li>
						      </ul>

						      
						      <div class="newsletter">
						      	<span class="nw"><img class="nw" src="<?php bloginfo('template_directory') ?>/img/icon-newsletter.png" style="vertical-align: middle;" height="22"></span>      	
							
							<form style="display: inline;"  action="http://e27.us1.list-manage2.com/subscribe/post?u=5d6bc43500e46f74ebde550e9&id=304859caf2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
									<!-- <label for="mce-EMAIL">Receive e27 newsletters</label> -->
									<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter you email:" required>
									<input type="submit" value="Subscribe &gt;" name="subscribe" id="mc-embedded-subscribe" class="nw_button">
								</form>
						      </div>
						      
						    </div>
						    <div class="more_subscription_options">
						      <!-- <span><a rel="nofollow" href="http://bit.ly/w2Fl4j">Get our weekly digest >></a></span> -->
						    </div>
						  </div>
						</div>
						</div>
					</div>

					
					<a href="mailto:writers@e27.sg?Subject=Tips" class="e27button" onClick="_gaq.push(['_trackEvent', 'Button Clicks', 'Email Links', 'Got A Tip button on sidebar']);">Got a tip? Tell Us!</a>


					<!--  End Social Block -->
					<?php if (function_exists('dynamic_sidebar'))  { ?>
					<div class="container container_2 clearfix sidebar_widget" style="margin-top: 20px;">
						<div class='grid_1' style="width: 100%;">
						<?php dynamic_sidebar(1); ?>
						</div>
					</div>								
					<?php } ?>	


					<div id="tweet_latest_container" class="container container_2 clearfix" style="margin-top: 20px; display: none;">
						<div class='grid_1' style="width: 50px;">
							<img src="<?php bloginfo('template_directory') ?>/img/icon-twitter-green-lg.png">
						</div>
						<div id="tweet_latest_content" class='grid_1' style="width: 270px">
							<div style="padding: 5px;"><ul id="twitter_update_list"></ul></div>
						</div>
					</div>			
					
					
					<?php
					if($_GET['related']){
						
						$tags = wp_get_post_tags(get_the_ID());
						/*
						echo "<pre>";
						print_r($tags);
						echo "</pre>";
						*/
						$tags = wp_get_post_tags(get_the_ID(), array( 'fields' => 'ids' ));
						
						if ($tags) {
							/*$args = array(
								'tag__in' => $tags,
								'post__not_in' => array(get_the_ID()),
								'showposts'=> 4,
								'ignore_sticky_posts'=>1
							);
							
							echo "<pre>";
							print_r($args);
							echo "</pre>";
							$my_query = new WP_Query($args);
							if(!$my_query->have_posts()) {
								$my_query = new WP_Query(array('post__not_in' => array(get_the_ID()), 'posts_per_page' => 4, 'orderby' => 'rand' ));
							}
							*/
							$tags = wp_get_post_tags(get_the_ID());
							if($tags) {
								$tagslugs = array();
								foreach($tags as $t) {
									array_push($tagslugs, str_replace(" ", "_", $t->name));
								}
								
							}
							if($_GET['tags']){
								$tagslugs = explode(",", $_GET['tags']);
							}
							$args = array(
								'posts_per_page' => 10,
								'tag_slug__in' => $tagslugs,
								'post__not_in' => array(get_the_ID()),
								'orderby' => 'date', 
								'order' => 'DESC'
							);
							query_posts( $args );
							?>
							<?php if (have_posts()) : $count = 0; ?>
							<div id="top_posts_container" class="container container_2 clearfix">
								<h3><span>Related Posts</span></h3>
								<?php while (have_posts()) : the_post(); $count++; ?>		
								<div class="top_posts_story container container_2 clearfix">
									<div class='top_posts_image grid_1' style="width: 30%; display:none">
										
										<a href="<?php the_permalink() ?>" class="clearfix">
										<?php echo_first_image(get_the_ID(), 90); ?>
										</a>
										
									</div>
									<div class='grid_1' style="width: 100%;">
										<div class="top_posts_teaser">
											<p> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_time('M j, Y'); ?> - <?php the_title(); ?></a></p>
										</div>
									</div>
								</div>
								<?php endwhile; ?> 					
							</div>
							<?php endif; 
							wp_reset_query();
						}
					}
					?>

					
					<?php $saved = $wp_query; ?>
					<?php 
						$current_year = date('Y');
						$current_month = date('m');
						//query_posts(array('showposts' => 10, 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => '_shares_total', 'year' => $current_year, 'monthnum' => $current_month, 'w' => $week));
						
						function filter_where( $where = '' ) {
							// posts in the last 30 days
							$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
							return $where;
						}
						
						add_filter( 'posts_where', 'filter_where' );

						query_posts(array('showposts' => 10, 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => '_shares_total')); 
						
						remove_filter( 'posts_where', 'filter_where' );
						?>
					<?php if (have_posts()) : $count = 0; ?>
					<div id="top_posts_container" class="container container_2 clearfix">
						<h3><span>Popular Posts</span></h3>
						<?php while (have_posts()) : the_post(); $count++; ?>		
						<div class="top_posts_story container container_2 clearfix">
							<div class='top_posts_image grid_1' style="width: 30%;">
								<a href="<?php the_permalink() ?>" class="clearfix">
								<?php echo_first_image(get_the_ID(), 90); ?>
								</a>
							</div>
							<div class='grid_1' style="width: 70%;">
								<div class="top_posts_teaser">
									<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
								</div>
							</div>
						</div>
						<?php endwhile; ?> 					
					</div>
					<?php endif; $wp_query = $saved; ?>

					
					
					<?php
					if (get_option('eg_ad_side_banner1_1_enable', false) !== false && get_option('eg_ad_side_banner1_1_enable', false) == '1') { 
						?>
						<div class="side advertisement">
							<?php if (get_option('eg_ad_side_banner1_1_ad_sense', false) !== false && get_option('eg_ad_side_banner1_1_ad_sense', false) != '') { ?>
								<?php echo get_option('eg_ad_side_banner1_1_ad_sense', false); ?>
							<?php } else if (get_option('eg_ad_side_banner1_1_image_location', false) !== false && get_option('eg_ad_side_banner1_1_image_location', false) != '' && get_option('eg_ad_side_banner1_1_dest_url', false) !== false && get_option('eg_ad_side_banner1_1_dest_url', false) != '') { ?>
								<a href="<?php echo get_option('eg_ad_side_banner1_1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner1_1_image_location', false); ?>" /></a>
							<?php } ?>
						</div>
						<?php 
					} 
					?>
					
					
								
					<?php $saved = $wp_query; ?>

					<?php
						$todaysDate = date("Y-m-d H:i:s");
						//query_posts('showposts=10&category_name=events&meta_key=enddate&meta_compare=&meta_value=' . $todaysDate . '&orderby=meta_value&order=ASC');
						$wp_args = array(
								'posts_per_page' => '10',
								'category_name' => 'events',
								'meta_query' => array(
									array (
										'key' => 'enddate',
										'value' => $todaysDate,
										'compare' => '>=',
										'type' => 'DATETIME'
									)
								),
								'meta_key' => 'startdate',
								'orderby' => 'meta_value',
								'order' => 'ASC'
						);
						query_posts($wp_args);
					?>					
					<?php if (have_posts()) : $count = 0; ?>
					<?php //if ($the_query->have_posts()) : $count = 0; ?>
					<div id="upcoming_events_container" class="container container_2 clearfix" style="margin-top: 20px;">
						<h3><span>Upcoming Events (<a style='font-size:11px; color: #21913E; text-transform: none' href='/submit-an-event'>Add Your Own Event</a>)</span></h3>
						<?php while (have_posts()) : the_post(); $count++; ?>
						<div class="upcoming_event container container_2 clearfix">
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
							<div class='grid_1' style="width: 70%;">
								<div class="upcoming_event_title">
									<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
								</div>
								<div class="upcoming_event_location"><?php echo get_post_meta(get_the_ID(), 'location', true) ?></div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>



					<?php //remove_filter( 'posts_where', 'date_check_where' ); ?>
					<?php endif; $wp_query = $saved; ?>

					
					<?php if (get_option('eg_ad_side_banner2_enable', false) !== false && get_option('eg_ad_side_banner2_enable', false) == '1') { ?>
					<div class="side advertisement ads2">
						<?php if (get_option('eg_ad_side_banner2_ad_sense', false) !== false && get_option('eg_ad_side_banner2_ad_sense', false) != '') { ?>
							<?php echo get_option('eg_ad_side_banner2_ad_sense', false); ?>
						<?php } else if (get_option('eg_ad_side_banner2_image_location', false) !== false && get_option('eg_ad_side_banner2_image_location', false) != '' && get_option('eg_ad_side_banner2_dest_url', false) !== false && get_option('eg_ad_side_banner2_dest_url', false) != '') { ?>
							<a href="<?php echo get_option('eg_ad_side_banner2_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner2_image_location', false); ?>" /></a>
						<?php } ?>
					</div>
					<?php } ?>	

					<div class="side advertisement" '>
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
						
						<?php
						//jairus
						?>
						<div class="container container_2 clearfix" style="text-align: center;">
							<div class='grid_1' style='padding-top:20px'>
							<?php if (get_option('eg_ad_side_banner3_1_enable', false) !== false && get_option('eg_ad_side_banner3_1_enable', false) == '1') { ?>
								<?php if (get_option('eg_ad_side_banner3_1_ad_sense', false) !== false && get_option('eg_ad_side_banner3_1_ad_sense', false) != '') { ?>
									<?php echo get_option('eg_ad_side_banner3_1_ad_sense', false); ?>
								<?php } else if (get_option('eg_ad_side_banner3_1_image_location', false) !== false && get_option('eg_ad_side_banner3_1_image_location', false) != '' && get_option('eg_ad_side_banner3_1_dest_url', false) !== false && get_option('eg_ad_side_banner3_1_dest_url', false) != '') { ?>
									<a href="<?php echo get_option('eg_ad_side_banner3_1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner3_1_image_location', false); ?>" /></a>
								<?php } ?>
							<?php } ?>
							</div>
							<div class='grid_1' style='padding-top:20px'>
							<?php if (get_option('eg_ad_side_banner4_1_enable', false) !== false && get_option('eg_ad_side_banner4_1_enable', false) == '1') { ?>
								<?php if (get_option('eg_ad_side_banner4_1_ad_sense', false) !== false && get_option('eg_ad_side_banner4_1_ad_sense', false) != '') { ?>
									<?php echo get_option('eg_ad_side_banner4_1_ad_sense', false); ?>
								<?php } else if (get_option('eg_ad_side_banner4_1_image_location', false) !== false && get_option('eg_ad_side_banner4_1_image_location', false) != '' && get_option('eg_ad_side_banner4_1_dest_url', false) !== false && get_option('eg_ad_side_banner4_1_dest_url', false) != '') { ?>
									<a href="<?php echo get_option('eg_ad_side_banner4_1_dest_url', false); ?>"><img src="<?php echo get_option('eg_ad_side_banner4_1_image_location', false); ?>" /></a>
								<?php } ?>
							<?php } ?>
							</div>

						</div>
						
						<?php 
						if (function_exists('dynamic_sidebar'))  { 
							?>
							<div class="container container_2 clearfix sidebar_widget" style="margin-top: 20px;">
								<div class='grid_1' style="width: 100%;">
								<?php dynamic_sidebar(2); ?>
								</div>
							</div>
							<?php 
						} ?>

					<!--  End Social Block -->
						
						
						<!--  sidebarads -->



					</div>
				</div>