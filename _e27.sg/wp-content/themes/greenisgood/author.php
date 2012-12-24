<?php get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					<?php 
						if(get_query_var('author_name')) :
						$curauth = get_userdatabylogin(get_query_var('author_name'));
						else :
						$curauth = get_userdata(get_query_var('author'));
						endif;
						$authid = $curauth->ID;
					?>
					<div id="author_about_container">
						<h1><span><?php echo $curauth->display_name ?></span></h1>
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
								<?php the_author_meta('description'); ?>
							</p>
						</div>
					</div>
					<?php $facebook = get_the_author_meta('facebook'); ?>
					<?php $twitter = get_the_author_meta('twitter'); ?>
					<?php $linkedin = get_the_author_meta('linkedin'); ?>
					<?php $googleplus = get_the_author_meta('googleplus'); ?>
					<?php if ($facebook != '' || $twitter != '' || $linkedin != '' || $googleplus != '') { ?>
					<div id="author_about_social">
						<h1><span>CONNECT WITH <span class="gray"><?php echo $curauth->display_name ?></span></span></h1>
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
						<h1><span>ALL STORIES BY <span class="gray"><?php echo $curauth->display_name; ?></span></span></h1>
						<div id="posts">
						<!-- start -->
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
							
							
							
							<?php if ($count == 5) : ?>
					            <?php include( TEMPLATEPATH . '/includes/ads-2x300.php' ); ?>
				            <?php endif; ?>						
				            
						<?php endwhile; ?>
						</div>
					</div>
					<?php
						pagination($wp_query->max_num_pages); 
					?>
						<!-- end -->
    				<?php endif; ?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>