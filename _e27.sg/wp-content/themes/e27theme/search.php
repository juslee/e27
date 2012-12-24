<?php get_header(); ?>
<div id="Content">
<div class="Search">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="bodyb1">
					<div id="content" class="widecolumn">

					<?php if (have_posts()) : ?>

						<div class="EventsBox" style="margin-left: -20px;">
						<h2 class="left Blue">Search Results</h2>
						<div class="clear"></div>
						</div>
<br clear="all"  />
						<div class="navigation">
							<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
							<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
						</div>


						<?php while (have_posts()) : the_post(); ?>
						
							<div class="post" id="post-<?php the_ID(); ?>">
								<div class="date_field"><?php the_time('l, F j, Y') ?></div>
								
								<div class="author_field">
									<?php // echo get_avatar( get_the_author_id(), 42); ?>
									<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<small>
										by <?php the_author() ?> at <?php the_time('g:ia') ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Categories: 
										<?php if(in_category( get_cat_id('Blog') ) ) { ?>
											<a href="<?php echo get_permalink(get_page_id('Blog')); ?>">Blog</a>
										<?php } else if(in_category( get_cat_id('Events') ) ) { ?>
											<a href="<?php echo get_permalink(get_page_id('Events')); ?>">Events</a>
										<?php } else if(in_category( get_cat_id('Companies') ) ) { ?>
											<a href="<?php echo get_permalink(get_page_id('Companies')); ?>">Companies</a>
										<?php } else { ?>
										<?php the_category(', '); } ?>
									</small>
								</div>
								
								
								<div class="com_share_field">
									<table cellspacing="0" cellpadding="0" width="100%">
										<tr>
											<td width="50%">
												<?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments_link', 'Comments are disabled for this post'); ?>
											</td>
											<td width="50%" style="text-align:right;">
												<?php if (function_exists('sharethis_button')) { sharethis_button(); } ?>
											</td>
										</tr>
									</table>
								</div>
								
								<!-- p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p -->
							</div>

						<?php endwhile; ?>

						<div class="navigation">
							<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
							<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
						</div>

					<?php else : ?>

						<h2 class="center">No posts found. Try a different search?</h2>
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>

					<?php endif; ?>

					</div>
				</td> <!-- /body b1 -->
				<td id="bodyb2">
					<?php get_sidebar(); ?>
				</td> <!-- /body b2 -->
			</tr>
		</table>
</div> <!-- /Search-->
</div> <!-- /Content -->
</div>

<div class="Bottom_bar"><!-- DON'T DELETE --></div>
<a  href="#page" class="Top_btn"><img src="<?php bloginfo('template_directory'); ?>/images/top_icon.gif" alt="top" /></a><br class="clear" />
<?php get_footer(); ?> 
