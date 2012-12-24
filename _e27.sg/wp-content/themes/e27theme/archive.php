<?php get_header(); ?>
<div id="Content">
<div class="Search">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="bodyb1">
					<div id="content" class="widecolumn">
					<?php is_tag(); ?>
						<?php if (have_posts()) : ?>
                        
					  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
					  <?php /* If this is a category archive */ if (is_category()) { ?>
						<?php if(in_category( get_cat_id('Companies') ) ) { ?>
							<h2 class="pagetitle"><?php single_cat_title(); ?> Company Listings</h2>
						<?php } else if(in_category( get_cat_id('Events') ) && is_month() ) { ?>
							<h2 class="pagetitle"><?php single_cat_title(); ?> Archive for <?php the_time('F, Y'); ?></h2>
						<?php } ?>
					  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
						<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
					  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
						<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
					  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                      <div class="EventsBox" style="margin-left: -20px;">
						<h2 class="left Blue">Archive for <?php the_time('F, Y'); ?></h2>
						<div class="clear"></div>
						</div>
						<br clear="all"  />
					  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
						<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
					  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
						<h2 class="pagetitle">Author Archive</h2>
					  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<h2 class="pagetitle">Blog Archives</h2>
					  <?php } ?>


						<div class="navigation">
							<!-- div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
							<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div -->
						</div>

						<?php while (have_posts()) : the_post(); ?>
							<div class="post" id="post-<?php the_ID(); ?>">
								<?php if(in_category( get_cat_id('Companies') ) ) { ?>
									<div class="date_field">Listed on <?php the_time('l, F j, Y') ?></div>
								<?php } else if(in_category( get_cat_id('Events') ) && is_month() ) { ?>
									<div class="date_field"><?php the_time('l, F j, Y') ?></div>
								<?php } ?>
								
								<div class="author_field">
									<?php // echo get_avatar( get_the_author_id(), 42); ?>
									<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<!-- small>by <?php the_author() ?> at <?php the_time('g:ia') ?></small -->
								</div>
								
								<div class="entry">
									<p class="small">
									<?php the_content_rss('', TRUE, '', 30); ?>
									</p>
								</div>
								
								<div class="com_share_field">
									<table cellspacing="0" cellpadding="0" width="100%">
										<tr>
											<td width="50%">
												<?php if(in_category( get_cat_id('Companies') ) ) { ?>
													<?php comments_popup_link('No Testimonials', '1 Testimonial', '% Testimonials', 'comments_link', 'Testimonials are disabled for this post'); ?>
												<?php } else if(in_category( get_cat_id('Events') ) && is_month() ) { ?>
													<?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments_link', 'Comments are disabled for this post'); ?>
												<?php } ?>												
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

						<?php 	if (function_exists('wp_pagenavi')) { wp_pagenavi(); } 
								else {
									echo '<div style="overflow:hidden">';
									echo '<div class="alignleft">'; 
									posts_nav_link('','','&laquo; Previous Entries'); 
									echo '</div><div class="alignright">';posts_nav_link('','Next Entries &raquo;',''); 
									echo '</div>';
									echo '</div>';	} ?>
									
					<?php else : ?>

						<h2 class="center">Not Found</h2>
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