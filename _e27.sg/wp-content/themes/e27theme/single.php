<?php get_header(); ?>
        
        <!-- START OF CONTENT -->
        <div class="Content">
        	
            <!-- START OF LEFTCOL -->
            <div class="LeftCol">
                
                <!--START OF COL -->
                <div class="Col">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="navigation">
							<div class="alignleft"><?php previous_post_link(' %link', '%title', TRUE) ?></div>
							<div class="alignright"><?php next_post_link('%link ', '%title', TRUE) ?></div>
                            <br class="clear" />
					</div>
                    <br />
                	
                    <ul class="Lists box">
                    
                    	<li>
                        	<h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							    </a>
                            </h1>
                            
                            <div class="Dotted Smallbox" style="position:relative;">
                                <div class="DateBox">
                                	<div class="date_top"><?php the_time('M') ?></div>
                                    <div class="date_bottom"><?php the_time('d') ?></div>
                                </div>
                               <!-- <?php $wp_query->is_page = false; ?>
                            	<div class="NumberBox"><?php comments_popup_link('0', '1', '%', 'comments_link', 'Comments are disabled for this post'); ?></div>-->
                            	
                            </div>
                            
                            <span class="left SmallFont Grey">posted by <?php the_author() ?> on <?php the_time('l, F j, Y') ?> at <?php the_time('g:ia') ?></span>
                            <span class="right SmallFont Grey"><b>Categories:</b> 
                            <?php if(in_category( get_cat_id('Blog') ) ) { ?>
									<a href="<?php echo get_permalink(get_page_id('Blog')); ?>">Blog</a>
								<?php } else if(in_category( get_cat_id('Events') ) ) { ?>
									<a href="<?php echo get_permalink(get_page_id('Events')); ?>">Events</a>
								<?php } else if(in_category( get_cat_id('Companies') ) ) { ?>
									<a href="<?php echo get_permalink(get_page_id('Companies')); ?>">Companies</a>
								<?php } else { ?>
								<?php the_category(', '); } ?>
                            </span>
                            <br class="clear" /><br />
                            
                            <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

								<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
								<?php // the_tags( '<p>Tags: ', ', ', '</p>'); ?> <!-- <a href="" class="BlueFont">read more ></a> -->
                            
                        </li>

                    </ul><br />
                    
                    <?php comments_template(); ?>
                    
                    <?php endwhile; else: ?>
							<p>Sorry, no posts matched your criteria.</p>
					<?php endif; ?>
                    </div>
                    <!-- END OF COL -->
            </div>
            <!-- END OF LEFTCOL -->
            
            <!-- START OF RIGHTCOL -->
            <div class="RightCol">
              <!--  <div class="NextEvent_Box">
               <p align="center"><a href= "http://advision.webevents.yahoo.com/scp/viewer/index.php?client_id=5482&event_id=21928">   <img src = "<?php bloginfo('template_directory'); ?>/images/OpenHack09-02.jpg" alt = "Open Hack Day" align="center"> </a></p>

                </div>-->
                <!--  <div class="NextEvent_Box">
<a href="http://www.amiando.com/echelon2010.html?page=383830"><img title="echelon2010" src="http://www.e27.sg/blog/wp-content/uploads/2010/04/Register-Now-300x250-ver2.jpg" /></a>
</div>
<div class="NextEvent_Box">

<a href="http://samsung-dev-day-sg.eventbrite.com/">
<object classid="Samsung">
<embed src="http://www.e27.sg/blog/wp-content/uploads/2010/04/Samsung_Developer_Day.swf" quality="high" 
pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="300" 
height="300"> </embed> 
</object>
</a>
</div>-->
                <div class="ConnectedBox">
                	<h2 class="box">Stay Connected.</h2>
                    <a href="http://eepurl.com/bFzq"><div><img src="<?php bloginfo('template_directory'); ?>/images/subscribe_icon.gif" /> <span class="Dotted">Subscribe to our Newsletters</span></div></a>
                    <a href="http://www.facebook.com/pages/E27-Singapore/7137316668"><div><img src="<?php bloginfo('template_directory'); ?>/images/fackbook_icon.gif" /> <span class="Dotted">e27 on Facebook</span></div></a>
                    <a href="http://twitter.com/E27sg"><div><img src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.gif"/> <span class="Dotted">e27 on Twitter</span></div></a>
                    <a href="http://www.slideshare.net/e27sg"><div><img src="<?php bloginfo('template_directory'); ?>/images/slideshare_icon.gif" /> <span class="Dotted">e27 on Slideshare</span></div></a>
                    <a href="http://www.flickr.com/photos/e27sg/"><div><img src="<?php bloginfo('template_directory'); ?>/images/flickr_icon.gif" /> <span class="Dotted">e27 on Flickr</span></div></a>
                    <a href="<?php bloginfo('url'); ?>/feed/"><div><img src="<?php bloginfo('template_directory'); ?>/images/blogfeed_icon.gif"/> <span class="Dotted">Blog Feed</span></div></a>
                    <a href=""><div><img src="<?php bloginfo('template_directory'); ?>/images/eventsfeed_icon.gif" /> <span class="Dotted">Events Feed</span></div></a>
                </div>
                
                <div class="new_add_most_read_and_latest_comments">
					<div class="NextEvent_Box ForumBox" style="display: block;" id="content1">
		            	<div class="Top_bar">
		                	<ul class="TabMenu">
								<li class="box1 activated"><a href="javascript: swapPanel('content1')">Most Read</a></li>
								<li class="box2"><a href="javascript: swapPanel('content2')">Latest Comments</a></li>
		                    </ul>
		                </div>
		                <div class="Bottom_bar Lists">
		                	<?php if (function_exists('get_mostpopular')) get_mostpopular(); ?>
		                </div>
		            </div>
				
					<div class="NextEvent_Box ForumBox" style="display: none;" id="content2">
		            	<div class="Top_bar">
		                	<ul class="TabMenu">
								<li class="box1 "><a href="javascript: swapPanel('content1')">Most Read</a></li>
								<li class="box2 activated2"><a href="javascript: swapPanel('content2')">Latest Comments</a></li>
		                    </ul>
		                </div>
		                <div class="Bottom_bar Lists">
		                	<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(10, 60, '', ''); } ?>
		                </div>
		            </div> 
				</div> 
                
             <!--<div class="new_add_archives_and_categories">
				<div class="ForumBox SelectBox">
                	<h2>Archives</h2>
                    <?php // wp_get_archives('type=monthly'); ?>
		
		<select name=\"archive-dropdown\" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
		<option value=\"\"><?php echo attribute_escape(__('Select Month')); ?></option> 
		<?php wp_get_archives('type=monthly&format=option&cat='.get_cat_id('Events')); ?> </select><br/><br/><br/>
                    
                    <h2>Categories</h2>
                    <select>
                    	<option>Select Categories</option>
                    </select>
                </div>
			  </div> -->
            
            </div>
            <!-- END OF RIGHTCOL -->
            
            <div class="clear"><!-- DON'T DELETE --></div>  
            
        </div>
        <!-- END OF CONTENT -->
        
    </div>
    <!-- END OF MIBBLE BAR -->
    
   <div class="Bottom_bar"><!-- DON'T DELETE --></div> 
    
    <a  href="#page" class="Top_btn"><img src="<?php bloginfo('template_directory'); ?>/images/top_icon.gif" alt="top" /></a><br class="clear" />
    
    <?php get_footer(); ?>
