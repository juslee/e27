<?php get_header(); ?>
<!-- Add the following three tags to your body. -->

		<div id="body">
			<div class="container container_2 clearfix">
				<div class='body-main-content grid_1'>
					<?php $permalink = ''; ?>
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<script src="<?php bloginfo('template_directory') ?>/js/sharebar.js" type="text/javascript"></script>
					<script type="text/javascript">
						jQuery(document).ready(function($) { $('.sharebar').sharebar({horizontal:'true',swidth:'70',minwidth:1000,position:'left',leftOffset:30,rightOffset:10}); });
					</script>
					<?php $permalink = get_permalink(); ?>
					<div id="post-<?php the_ID(); ?>" class="post full">
						<div class="title">
							<h1 class="post-title"><?php the_title(); ?></h1>
						</div>
						<div class="post_info">
							By <span class="author_name"><?php the_author_posts_link(); ?></span>
                            <?php 
								/*$googleplus = get_the_author_meta('googleplus');
								if(!empty($googleplus)) {
									echo '<a href="'.$googleplus.'?rel=author" target="_blank"><img src="'.get_bloginfo('template_directory').'/img/icon-googleplus-author-24x24.png" class="authoricon" /></a>';
								}*/
							?>
                             | <?php the_time('M j, Y'); ?> | 
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
						<div class="description clearfix">
							<div id="sharebar" class="post_share rail">
								<div class="share-buttons share-button-rail">
									<div>
										<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>
									</div>
									<div>
										<a href="https://twitter.com/share?count=vertical" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
									</div>
									<div>
										<g:plusone href="<?php the_permalink() ?>" size="tall"></g:plusone>
									</div>
									<div>
										<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
										<script type="IN/Share" data-counter="top"></script>
									</div>
									<div style='padding-top:10px'>
										<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>" class="pin-it-button" count-layout="vertical">Pin It</a>
										<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
									</div>
                                    <div>
                                        <su:badge layout="5" location="<?php the_permalink(); ?>"></su:badge>
                                        <script type="text/javascript">
                                          (function() {
                                            var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                                            li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
                                          })();
                                        </script>
                                    </div>


						        </div>
						    </div>   
							<?php the_content(); ?>
                            <?
								$tags = wp_get_post_tags(get_the_ID());
								if($tags) {
									$taglinks = array();
									foreach($tags as $t) {
										array_push($taglinks, '<a href="'.get_tag_link($t->term_id).'">'.$t->name.'</a>');
									}
									echo '<p>Tags: '.implode(', ', $taglinks).'</p>';
								}
							?>
							<?php edit_post_link(); ?>
						</div>

						<div id="nav-below" class="navigation clearfix">
							<?php previous_post_link( '<div class="nav-previous fl">%link</div>', '%title' ); ?>
							<?php next_post_link( '<div class="nav-next fr">%link</div>', '%title' ); ?>
						</div><!-- #nav-below -->

						<div id="nav-below-btn" class="navigation clearfix">
							<?php previous_post_link( '<div class="nav-previous-btn fl">%link</div>', '&lsaquo; Prev Story'); ?>
							<?php next_post_link( '<div class="nav-next-btn fr">%link</div>', 'Next Story &rsaquo;'); ?>
						</div><!-- #nav-below -->

					</div>
					<?php endwhile; // end of the loop. ?>
					<?php
						//for use in the loop, list 5 post titles related to first tag on current post
						$tags = wp_get_post_tags(get_the_ID(), array( 'fields' => 'ids' ));
						if ($tags) {
							$args = array(
								'tag__in' => $tags,
								'post__not_in' => array(get_the_ID()),
								'showposts'=> 4,
								'ignore_sticky_posts'=>1
							);
							$my_query = new WP_Query($args);
							if(!$my_query->have_posts()) {
								$my_query = new WP_Query(array('post__not_in' => array(get_the_ID()), 'posts_per_page' => 4, 'orderby' => 'rand' ));
							}
							if( $my_query->have_posts() ) {
					?>
					<div id="we_also_recommend" class="clearfix">
						<h3><span class="midline">You Might Like:</span></h3>
						<div id="we_also_recommend_stories" class="clearfix">					
								<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
							<div class="we_also_recommend_story">
								<div class="story_image">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo_first_image(get_the_ID(), 132); ?></a>
								</div>
								<div class="story_title">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</div>
							</div>
								<?php endwhile; ?>
						</div>
					</div>
							<?php 	
							}
							wp_reset_query();
						}
						//<div class="fb-comments" data-href=" echo $permalink " data-num-posts="2" data-width="719"></div>
					?>
					<?php comments_template(); ?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>