<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  ?>
                    <?php
						$posts = get_posts(array('numberposts' => 3, 'category_name' => 'featured'));
						if(3 - sizeof($posts) > 0) {
							// make exclude list
							$excludes = array();
							foreach($posts as $p) {
								array_push($excludes, $p->ID);
							}
							$latest_posts = get_posts(array('numberposts' => 3 - sizeof($posts), 'exclude' => $excludes));
							foreach($latest_posts as $p) {
								array_push($excludes, $p->ID);
							}
							$posts = array_merge($posts, $latest_posts);
						}
						$featured_posts = $posts;
					?>
					<?php if ($paged == 1) { ?>
                        <div id="featured" class="clearfix">
                            <div class="prel">
                                <h3><span>Featured Story</span></h3>
                       			<?php
									foreach($featured_posts as $p) {
										global $post;
										$post = $p;
								?>
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
                                                        <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
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
                                <?php
									}
								?>
                                </div>
                        </div>
                        <div id="trending">
                            <div id="trending_body">
                                <div class="title">TRENDING:</div>
                                <ul>
                                <?php 
                                    $tags = wp_tag_cloud('number=15&order=RAND&format=array' );
                                    foreach ($tags as $tag) {
                                        ?>
                                        <li><?php echo $tag ?></li>
                                        <?php
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?> <!-- end featured div -->
					<div id="posts">
					<?php 
						$show_posts = 10;
					?>
					<?php query_posts(array('numberposts' => $show_posts, 'paged' => $paged, 'post__not_in' => $excludes)); ?>
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
					<?php endwhile; ?> 
					<?php endif; ?>
					</div>
					<?php
						pagination($wp_query->max_num_pages); 
					?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>