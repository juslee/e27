<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  ?>
					<?php $exclude_ids = array(); ?>
					<?php global $query_string; ?>
					<?php if ($paged == 1) { ?>
					<div id="featured" class="clearfix">
						<div class="prel">
							<h1><span>FEATURED STORY FOR <span class="gray"><?php echo single_tag_title( '', false ) ?></span></span></h1>
							<?php $saved = $wp_query; ?>		
							<?php query_posts( $query_string . '&showposts=1' ); ?>
							<?php if (have_posts()) : $count = 0; ?>					
								<?php while (have_posts()) : the_post(); $count++; ?>
								<?php $exclude_ids[] = get_the_ID(); ?>
							<div id="featured_story_container">
								<div id="featured_story_image">
									<?php echo_first_image(get_the_ID(), 400); ?>
								</div>
							</div>
							<div id="featured_story_meta" style="margin: 10px 0 10px 0;">
								<div class="container container_2 clearfix">
									<div class='grid_1' style="width: 25%; padding-top: 5px;">
										<?php 
											$categories = get_the_category();
											if (is_array($categories) && count($categories) > 0) {
												$category = $categories[0]->name;
												?>
												<span class="post_category"><a href="<?php echo get_category_link($categories[0]->cat_ID) ?>"><?php echo $category ?></a></span>
												<?php
											}
										?>
									</div>
									<div class='social grid_1' style="width: 75%; text-align: right;">
										<div class="facebook-likes">
											<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
										</div>
										<div class="twitter-tweets">
											<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
										</div>
										<div class="google_plus-likes">
											<g:plusone href="<?php the_permalink() ?>" size="medium"></g:plusone>											
										</div>
									</div>
								</div>
							</div>						
							<div id="featured_story_teaser" style="background-color: #1F2120; color: #FFFFFF; padding: 10px; opacity: 0.85;">
								<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
								<?php 
									$content = get_the_content();
									$content = strip_tags($content);
									$content = strip_shortcodes($content);
									$content = preg_replace ("/\[(\S+)\]/e", "", $content);
									$content = substr($content, 0, 300);
								?>
								<p><?php echo $content ?>...<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><span class="post_more">More</span></a></p>
							</div>
								
								<?php endwhile; ?> 
							<?php endif; $wp_query = $saved; ?>  
						</div>
						<div class="prer">
							<h2><span>More Stories</span></h2>
							<div id="more_stories_container" class="clearfix">
					<?php $saved = $wp_query; ?>
					<?php query_posts($query_string . "&offset=1&showposts=4"); ?>
					<?php if (have_posts()) : $count = 0; ?>					
						<?php while (have_posts()) : the_post(); $count++; ?>
							<?php $exclude_ids[] = get_the_ID(); ?>
								<div class="more_stories_story container container_2 clearfix">
									<div class='more_stories_image grid_1' style="width: 35%;">
									<?php echo_first_image(get_the_ID(), 80); ?>
									</div>
									<div class='grid_1' style="width: 65%;">
										<div class="more_stories_teaser">
											<p><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
										</div>
										<div class="more_stories_social">
											<div class="facebook-likes">
												<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
											</div>
											<div class="twitter-tweets">
												<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
											</div>
										</div>
									</div>
								</div>
						<?php endwhile; ?> 
					<?php endif; $wp_query = $saved; ?>
							</div>
							<?php 
							/**
							<h2><span>Most Shared</span></h2>
							<div id="most_shared_container">
								<ul>
								<?php $saved = $wp_query; ?>
								<?php query_posts(array('showposts' => 5, 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => '_shares_total')); ?>
								<?php while (have_posts()) : the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>    
								<?php endwhile; ?>
								<?php $wp_query = $saved; ?>
								</ul>
							</div>
							 */
							?>
						</div>
					</div>
					<?php } ?>
					<div id="author_about_stories">
						<h1><span>ALL STORIES ON <span class="gray"><?php echo single_tag_title( '', false ) ?></span></span></h1>
					<div id="posts">
					<?php $saved = $wp_query; ?>
					<?php 
					$show_posts = ($paged == 1 ? 5 : 10);
					?>
					<?php query_posts($query_string.'&offset=5&showposts='.$show_posts.'&paged='.$paged); ?>
					<?php if (have_posts()) : $count = 0; ?>					
					<?php while (have_posts()) : the_post(); $count++; ?>
						<div class="post">
							<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
							<div class="container container_2 clearfix">
								<div class='grid_1 image' style="width: 180px;">
									<?php echo_first_image(get_the_ID(), 150); ?>
								</div>
								<div class='grid_1 preview' style="width: 400px;">
									<div class="post_info">
										By <span class="author_name"><?php the_author_posts_link(); ?></span> | <?php the_time('F j, Y'); ?> | 
										<?php 
											$categories = get_the_category();
											if (is_array($categories) && count($categories) > 0) {
												$category = $categories[0]->name;
												?>
												<span class="post_category"><a href="<?php echo get_category_link($categories[0]->cat_ID) ?>"><?php echo $category ?></a></span>
												<?php
											}
										?>
									</div>
									<div class="post_preview">										
										<?php 
											/*
											$content = get_the_content();
											$content = strip_tags($content);
											$content = strip_shortcodes($content);
											$content = preg_replace ("/\[(\S+)\]/e", "", $content);
											$content = substr($content, 0, 300);
											<?php echo $content ?>...
											*/
										?>
										<?php echo get_the_content_first_paragraph(); ?><span class="post_read_more"><a href="<?php the_permalink() ?>">Read More &gt;&gt;</a></span>
									</div>
								</div>
								<div class='grid_1 social' style="width: 130px; border-left: 1px solid #000000; padding-left: 5px;">
									<div class="facebook-likes">
										<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
									</div>
									<div class="twitter-tweets">
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
									</div>
									<div class="google_plus-likes">
										<g:plusone href="<?php the_permalink() ?>" size="medium"></g:plusone>
									</div>
									<div class="linkedin-share">
										<script type="IN/Share" data-url="<?php the_permalink() ?>" data-counter="right"></script>										
									</div>
								</div>
							</div>
						</div>	
						<?php if ($count == ($show_posts == 10 ? 5 : 2)) : ?>
					    	<?php include( TEMPLATEPATH . '/includes/ads-2x300.php' ); ?>
				        <?php endif; ?>							
					<?php endwhile; ?> 
					<?php endif; $wp_query = $saved; ?>
					</div>
					</div>
					<?php
						pagination($wp_query->max_num_pages); 
					?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>