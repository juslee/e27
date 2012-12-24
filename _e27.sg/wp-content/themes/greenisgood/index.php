<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  ?>
					<?php $exclude_ids = array(); ?>
					<?php if ($paged == 1) { ?>
					<div id="featured" class="clearfix">
						<div class="prel">
							<h1><span>Featured Story</span></h1>
					<?php $saved = $wp_query; ?>		
					<?php query_posts('showposts=1&meta_key=is_featured&order=DESC'); ?>
					<?php if (!have_posts()) : ?>
					<?php query_posts(array('showposts' => 1)); ?>
					<?php endif; ?>
					<?php if (have_posts()) : $count = 0; ?>					
						<?php while (have_posts()) : the_post(); $count++; ?>
							<?php $exclude_ids[] = get_the_ID(); ?>
							<div id="featured_story_container">
								<div id="featured_story_image">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
									<?php echo_first_image(get_the_ID(), 400); ?>
									</a>
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
											<?php 
											/*
											 * <div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="arial"></div> 
											 */
											?>
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
									/*
									$content = get_the_content();
									$content = strip_tags($content);
									$content = strip_shortcodes($content);
									$content = preg_replace ("/\[(\S+)\]/e", "", $content);
									$content = substr($content, 0, 500);
									<p><?php echo $content ?>...</p>
									*/
									echo get_the_content_first_paragraph();
								?>
								<?php //<span class="post_more">More</span> ?>
							</div>
						<?php endwhile; ?> 
					<?php endif; $wp_query = $saved; ?>   
						</div>
						<div class="prer">
							<h2><span>More Stories</span></h2>
							<div id="more_stories_container" class="clearfix">
					<?php $saved = $wp_query; ?>
					<?php query_posts(array('post__not_in' => $exclude_ids, 'showposts' => 4, 'meta_key' => 'is_featured', 'order' => 'DESC')); ?>
					<?php if (!have_posts()) : ?>
					<?php query_posts(array('post__not_in' => $exclude_ids, 'showposts' => 4)); ?>
					<?php endif; ?>
					<?php if (have_posts()) : $count = 0; ?>					
						<?php while (have_posts()) : the_post(); $count++; ?>
							<?php $exclude_ids[] = get_the_ID(); ?>
								<div class="more_stories_story container container_2 clearfix">
									<div class='more_stories_image grid_1' style="width: 35%;">
										<a href="<?php the_permalink() ?>">
									<?php echo_first_image(get_the_ID(), 80); ?>
										</a>
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
					<div id="trending">
						<div id="trending_body">
							<div class="title">TRENDING:</div>
							<ul>
							<?php 
								//$tags = wp_tag_cloud('smallest=10&largest=10&number=5&orderby=count&order=DESC&format=array');
								function limit_tags($sql){
									global $wpdb;							
									$pattern = " WHERE ";
									$replace = " RIGHT JOIN {$wpdb->prefix}term_relationships AS tr ON ( tr.term_taxonomy_id = tt.term_taxonomy_id AND tr.object_id IN
									(SELECT ID FROM {$wpdb->posts} WHERE DATE(post_date) >= '".date("Y-m-d", strtotime("-7 days"))."' AND DATE(post_date) <= NOW() )	) ".$pattern;
									$sql = str_replace($pattern, $replace, $sql);
									return $sql;
								
								}
								add_filter('query', 'limit_tags');
								$tags_displayed = array();
								$tags = wp_tag_cloud('smallest=10&largest=10&number=10&orderby=count&order=DESC&format=array');
								remove_filter('query', 'limit_tags');
								foreach ($tags as $tag) {
									if (isset($tags_displayed[$tag]))
										continue;
									$tags_displayed[$tag] = true;
									?>
									<li><?php echo $tag ?> <span class="bull">&bull;</span></li>
									<?php
									if (count($tags_displayed) >= 5)
										break;
								}
							?>
							</ul>
						</div>
					</div>
					<?php } ?>
					<div id="posts">
					<?php $saved = $wp_query; ?>
					<?php 
					$show_posts = 10;
					?>
					<?php query_posts(array('showposts' => $show_posts, 'paged' => $paged, 'post__not_in' => $exclude_ids)); ?>
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
											echo $content ...
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
						<?php if ($count == 5) : ?>
					    	<?php include( TEMPLATEPATH . '/includes/ads-2x300.php' ); ?>
						<?php endif; ?>
					<?php endwhile; ?> 
					<?php endif; $wp_query = $saved; ?>
					</div>
					<?php
						pagination($wp_query->max_num_pages); 
					?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>