<?php get_header(); ?>

<!-- START OF CONTENT -->
        <div class="Content">
        	
            <!-- START OF LEFTCOL -->
            <div class="LeftCol"> 
                <div style="position:relative; z-index:0; height:330px;">
                <?php
						update_post_caches($posts);
						$custom_query = new WP_Query('category_name=Home Gallery 590x330');
						$post_no = 0;
					?>					
                                   
					<?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
					   
						<div class="gallerycontent">
							<?php								
								if( get_post_meta($post->ID, 'link', true) ) { 
									$link = get_post_meta($post->ID, 'link', true);
								} else {
									$link = '#';
								}
							?>
							<a href="<?php echo $link; ?>">
							<?php if( get_post_meta($post->ID, 'image_link', true) ) { ?>
								<img src="<?php echo get_post_meta($post->ID, 'image_link', true); ?>" />							
							<?php } else { ?>
								<img src="<?php bloginfo('template_directory'); ?>/images/main_gal_<?php echo $post_no+1; ?>.jpg" />
							<?php } ?>							
							</a>
							
							<div class="description">
								<h1 class="Smallbox"><?php the_title(); ?></h1>
								<?php the_content(''); ?>
							</div>

						</div>
						
						<?php $post_no++; ?>
						
					<?php endwhile; ?>
                                       
					<div id="controldiv" style="display:none" class="gallerycontroller">					
						<?php for ($i = 0; $i < $post_no; $i++) { ?>			
							<a href="javascript:manualcontrol(<?php echo $i; ?>)" class="gallerycontrol"><?php echo $i+1; ?></a>						
						<?php } ?>
					</div>
                                 </div>	
                <!--START OF COL -->
                <div class="Col">
                
                	<div class="NewsBar box">
                    	<script type="text/javascript">
						//new domticker(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds, optionalfadeswitch = "fadeit")
						new domticker(tickercontent, "", "", 6000)
						</script>
                    </div>
                    <ul class="Lists box">
                        
                        <?php
                            update_post_caches($posts);
                            $custom_query = new WP_Query('category_name=blog&showposts=10'); 
						?>
						<?php if ($custom_query->have_posts()) : ?>

						<?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                                
                    	<li id="post-<?php the_ID(); ?>">
                            <?php // echo get_avatar( get_the_author_id(), 42); ?>
                        	<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                            
                            <div class="Dotted Smallbox" style="position:relative;">
                                <div class="DateBox">
                                	<div class="date_top"><?php the_time('M') ?></div>
                                    <div class="date_bottom"><?php the_time('d') ?></div>
                                </div>
                            	<div class="NumberBox"><?php comments_popup_link('0', '1', '%', 'comments_link', 'Comments are disabled for this post'); ?></div>
                            </div>
                            
                            <span class="left SmallFont">posted by <?php the_author() ?>  on <?php the_time('l, F j, Y') ?> at <?php the_time('g:ia') ?></span>
                            <span class="right SmallFont"><b>Categories:</b> <?php if(in_category( get_cat_id('Blog') ) ) { ?>
													<a href="<?php echo get_permalink(get_page_id('Blog')); ?>">Blog</a>
												<?php } else if(in_category( get_cat_id('Events') ) ) { ?>
													<a href="<?php echo get_permalink(get_page_id('Events')); ?>">Events</a>
												<?php } else if(in_category( get_cat_id('Companies') ) ) { ?>
													<a href="<?php echo get_permalink(get_page_id('Companies')); ?>">Companies</a>
												<?php } else { ?>
												<?php the_category(', '); } ?>
                            </span>
                            <br class="clear" /><br />
                            
                            <?php the_content('Read the rest of this entry &raquo;'); ?> 
                           <!-- <a href="" class="BlueFont">read more ></a> -->
                            </span>
                            <br class="clear" />
                        </li>
                        
                        <?php endwhile; ?>

							<?php else : ?>

								<h1 class="centered">Not Found</h1>
								<p class="centered">Sorry, but you are looking for something that isn't here.</p>
								<?php include (TEMPLATEPATH . "/searchform.php"); ?>

							<?php endif; ?>	
                        </ul>	
                    
                    <div class="right Page">
                        Page 1 of 20
                    	<a href=""><<</a>
                        <span class="activated">1</span>
                        <a href="">2</a>
                        <a href="">3</a>
                        <a href="">4</a>
                        <a href="">5</a>
                        <a href="">...</a>
                        <a href="">20</a>
                        <a href="">>></a>
                    </div>
                    
                </div>
                <!-- END OF COL -->
                
        </div>
            <!-- END OF LEFTCOL -->
            
            <?php get_sidebar(); ?>
            
            <div class="clear"><!-- DON'T DELETE --></div>  
            
        </div>
        <!-- END OF CONTENT -->
    
    </div>
    <!-- END OF MIBBLE BAR -->
    
    <div class="Bottom_bar"><!-- DON'T DELETE --></div>
    
    <a  href="#page" class="Top_btn"><img src="<?php bloginfo('template_directory'); ?>/images/top_icon.gif" alt="top" /></a><br class="clear" />

<?php get_footer(); ?>
