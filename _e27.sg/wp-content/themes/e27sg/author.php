<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php 
						if(get_query_var('author_name')) :
							$curauth = get_userdatabylogin(get_query_var('author_name'));
						else :
							$curauth = get_userdata(get_query_var('author'));
						endif;
						
						global $authordata;
						$authordata=get_userdata(get_query_var( 'author' ));

						//print_r($curauth);
						$authid = $curauth->ID;
					?>
					<div id="author_about_container">
						<h3><span><?php echo $curauth->display_name ?></span></h3>
						<div id="author_about_body" class="clearfix">
							<p>
								<?php if (function_exists('profilepic_internal_picpath')) { ?>
									<?php $pic = profilepic_internal_picpath($curauth->ID, false); ?>
									<img src="<?php echo $pic ?>" width="128" align="right" id="avatar_<?php echo $curauth->ID ?>" />
								<?php } else if (function_exists('userphoto_the_author_photo')) { ?>
									<?php userphoto_the_author_photo('', '', array('align' => 'right', 'id' => 'avatar_'.$curauth->ID), get_bloginfo('template_directory').'/img/avatar-sample.png'); ?>
								<?php } else { ?>
									<?php $pic = get_bloginfo('template_directory').'/img/avatar-sample.png'; ?>
									<img src="<?php echo $pic ?>" width="128" align="right" id="avatar_<?php echo $curauth->ID ?>" />
								<?php } ?>
								<?php the_author_meta('description', $curauth->ID); ?>
							</p>
						</div>
					</div>
					<?php $facebook = get_the_author_meta('facebook'); ?>
					<?php $twitter = get_the_author_meta('twitter'); ?>
					<?php $linkedin = get_the_author_meta('linkedin'); ?>
					<?php $googleplus = get_the_author_meta('googleplus'); ?>
					<?php if ($facebook != '' || $twitter != '' || $linkedin != '' || $googleplus != '') { ?>
					<div id="author_about_social">
						<h3><span>CONNECT WITH <?php echo $curauth->display_name ?></span></h3>
						<div class="container container_2 clearfix" style="text-align: center;">
							<?php if ($facebook != '') { ?>
							<div class='grid_1' style="width: 25%;">
								<a href="<?php echo $facebook ?>" target="_blank"><img src="<?php bloginfo('template_directory') ?>/img/icon-facebook-75x85.png" /></a>
							</div>
							<?php } ?>
							<?php if ($twitter != '') { ?>
							<div class='grid_1' style="width: 25%;">
								<a href="<?php echo $twitter ?>" target="_blank"><img src="<?php bloginfo('template_directory') ?>/img/icon-twitter-75x85.png" /></a>
							</div>
							<?php } ?>
							<?php if ($linkedin != '') { ?>
							<div class='grid_1' style="width: 25%;">
								<a href="<?php echo $linkedin ?>" target="_blank"><img src="<?php bloginfo('template_directory') ?>/img/icon-linkedin-75x85.png" /></a>
							</div>
							<?php } ?>
							<?php if ($googleplus != '') { ?>
							<div class='grid_1' style="width: 25%;">
								<a href="<?php echo $googleplus ?>" target="_blank"><img src="<?php bloginfo('template_directory') ?>/img/icon-googleplus-75x85.png" /></a>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>					 
    				<?php if ( have_posts() ) : ?>
					<div id="author_about_stories">
					<h3><span>ALL STORIES BY <?php echo $curauth->display_name; ?></span></h3>
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