
<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
    				<?php if ( have_posts() ) : ?>
					<div id="author_about_stories">
						<h3><span>ALL STORIES ON <?php echo single_cat_title( '', false ) ?></span></h3>
						<div id="posts">
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
												<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>" data-via="e27co" data-url="<?php the_permalink() ?>">Tweet</a>
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
			</div>
			<?php get_sidebar(); ?>

			</div>
		</div>
<?php get_footer(); ?>