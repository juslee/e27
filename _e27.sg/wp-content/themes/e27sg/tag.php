<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  ?>
					<?php $exclude_ids = array(); ?>
					<?php if ($paged == 1) { ?>
					<div id="featured" class="clearfix">
						<div class="prel">
							<h3><span>FEATURED STORY FOR <?php echo single_tag_title( '', false ) ?></span></h3>
							<?php $saved = $wp_query; ?>		
							<?php 
								//query_posts( $query_string . '&showposts=3' );
							
							?>
								

							<?php if (have_posts()) : $count = 0; ?>		
			
								<?php while (have_posts()&&$count<3) : the_post(); $count++; ?>
								<?php $exclude_ids[] = get_the_ID(); ?>
								<div id="featuredblock">
								<div id="featured_story_container">
									<div id="featured_story_image">
										<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
										<?php echo_first_image(get_the_ID(), 220); ?>
										</a>
									</div>
								</div><!-- featured_story_container -->

								<div id="featured_story_teaser">
								<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								</div><!-- featured_story_teaser -->

								<div id="featured_story_meta">
									<div class="container container_2 clearfix">
										<div class='social'>
											<div class="facebook-likes">
												<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=90&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
												<?php 
												/*
												 * <div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="arial"></div> 
												 */
												?>
											</div>
											<div class="twitter-tweets">
												<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>" data-via="e27sg" data-url="<?php the_permalink() ?>">Tweet</a>
											</div>
										</div>
									</div>
								</div><!-- featured_story_meta -->			
		
							</div><!-- featuredblock -->
								<?php endwhile; //wp_reset_postdata(); ?>
							<?php endif; //$wp_query = $saved; ?>  
						</div>
					</div>
					<?php
					}
					else{
						//$tag = $wp_query->query_vars['tag'];
						//query_posts(array('orderby'=> 'date', 'order'=> 'DESC', 'tag'=> $tag, 'showposts' => $show_posts, 'paged' => 1));
						//while (have_posts()){
						//	the_post();
						//	$exclude_ids[] = get_the_ID();
						//}
					}
					
					?>
					<div id="author_about_stories">
					<h3><span>ALL STORIES ON <?php echo single_tag_title( '', false ) ?></span></h3>
					<div id="posts">
					<?php
					//$tag = strtolower(single_tag_title( '', false ));
					$tag = $wp_query->query_vars['tag'];
					$saved = $wp_query;
					//echo "<pre>";
					//print_r($wp_query->query_vars);
					//echo "</pre>";
					$show_posts = $wp_query->query_vars['posts_per_page'];
					
					//$qs = $query_string.'&orderby=date&order=DESC&offset=3&showposts='.$show_posts.'&paged='.$paged.'&post_not_in='.implode(",", $exclude_ids);
					
					
					//$qs = $query_string.'&offset=3&posts_per_page='.$show_posts.'&post_not_in='.implode(",", $exclude_ids);
					//echo $qs;
					//query_posts($qs);
					//echo $tag;
					//echo "<pre>", print_r($exclude_ids, 1), "</pre>";
					/*
					query_posts(array(
						'orderby'=> 'date', 
						'order'=> 'DESC', 
						'tag'=> $tag, 
						'showposts' => $show_posts, 
						'paged' => $paged, 
						'post__not_in' => $exclude_ids,
						'offset'=> 3, 
						)
					);
					*/
					?>
					<?php if (have_posts()) : $count = 0; ?>					
					<?php while (have_posts()) : the_post(); $count++; ?>
						<div class="post homepost">
							<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
							<div class="container container_2 clearfix">
								<div class='grid_1 image' style="width: 220px;">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
									<?php echo_first_image(get_the_ID(), 220); ?>

									</a>
								</div>
								<div class='grid_1 postpreview'>
									<div id="postmetasocial">
										<div class="post_info">
											By <span class="author_name"><?php the_author_posts_link(); ?></span> | <?php the_time('M j, Y'); ?> | 
											<?php 
												$categories = get_the_category();
												if (is_array($categories) && count($categories) > 0) {
													$category = $categories[0]->name;
													?>
													<span class="post_category"><a href="<?php echo get_category_link($categories[0]->cat_ID) ?>"><?php echo $category ?></a></span>
													<?php
												}
											?>
										</div><!-- post_info -->
										<div class='social'>
											<div class="facebook-likes">
												<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=90&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
											</div>
											<div class="twitter-tweets">
												<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>" data-via="e27sg" data-url="<?php the_permalink() ?>">Tweet</a>
											</div>
										</div><!-- social -->		
									</div><!-- postmetasocial -->
									<div class="post_preview">										
										<?php the_excerpt(); ?>
									</div><!-- post_preview -->
								</div><!-- grid_1 postpreview -->

								<div class="nav-next-btn fr">
									<span class="post_read_more"><a href="<?php the_permalink() ?>">Read More</a></span>
								</div>
							</div>
						</div>		
						<?php if ($count == 5) : ?>
					    	<?php include( TEMPLATEPATH . '/includes/ads-2x300.php' ); ?>
						<?php endif; ?>
								<?php endwhile; wp_reset_postdata(); ?>
					<?php endif; $wp_query = $saved; ?>
					</div>
					<?php
						pagination($wp_query->max_num_pages); 
					?>
				</div>
			</div>
				<?php get_sidebar(); ?>
			</div>

		</div>
<?php get_footer(); ?>