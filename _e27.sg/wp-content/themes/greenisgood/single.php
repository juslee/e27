<?php get_header(); ?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/post.css" type="text/css" />
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					<?php $permalink = ''; ?>
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<script src="<?php bloginfo('template_directory') ?>/js/sharebar.js" type="text/javascript"></script>
					<script type="text/javascript">
						jQuery(document).ready(function($) { $('.sharebar').sharebar({horizontal:'true',swidth:'70',minwidth:1000,position:'left',leftOffset:30,rightOffset:10}); });
					</script>
					<script type="text/javascript">
					</script>
					<?php $permalink = get_permalink(); ?>
					<div id="post-<?php the_ID(); ?>" class="post full">
						<div class="title">
							<h1 class="post-title"><?php the_title(); ?></h1>
						</div>
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
						<div class="description clearfix">
							<div id="sharebar" class="post_share rail" style="display: block; margin-left: -100px; position: absolute; width: 70px; z-index: 99; float: left;">
								<div class="share-buttons share-button-rail">
									<div style="margin-bottom: 5px;">
										<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>
									</div>
									<div style="margin-bottom: 5px;">
										<a href="https://twitter.com/share?count=vertical" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
									</div>
									<div style="margin-bottom: 5px;">
										<g:plusone href="<?php the_permalink() ?>" size="tall"></g:plusone>
									</div>
									<div style="margin-bottom: 5px;">
										<script type="IN/Share" data-url="<?php the_permalink() ?>" data-counter="top"></script>
									</div>
						        </div>
						    </div>          
							<?php the_content(); ?>
						</div>
						<div id="nav-below" class="navigation clearfix">
							<?php previous_post_link( '<div class="nav-previous">%link</div>', '%title' ); ?>
							<?php next_post_link( '<div class="nav-next">%link</div>', '%title' ); ?>
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
								'caller_get_posts'=>1
							);
							$my_query = new WP_Query($args);
							if(!$my_query->have_posts()) {
								$my_query = new WP_Query(array('post__not_in' => array(get_the_ID()), 'posts_per_page' => 4, 'orderby' => 'rand' ));
							}
							if( $my_query->have_posts() ) {
								?>
					<div id="we_also_recommend" class="clearfix">
						<h1><span>WE <span class="gray">ALSO RECOMMEND</span></span></h1>
						<div id="we_also_recommend_stories" class="clearfix">					
								<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
							<div class="we_also_recommend_story">
								<div class="story_image">
									<?php echo_first_image(get_the_ID(), 95); ?>
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
					<?php edit_post_link(); ?>
					<?php comments_template(); ?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>