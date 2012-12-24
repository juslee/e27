                <div class="post-top box">
                	<div class="metadata">
	                <p class="col-left post-date">
	                	<?php the_time($GLOBALS['woodate']); ?>
	                    
	                </p>
	                <ul class="stat-buttons col-right">
	                
	                	<!--
				<li>
	                		<?php if (function_exists('wpp_get_views')) { echo wpp_get_views( get_the_ID() ); } ?> <em>views</em>
	                	</li>
				-->
	                	<li>
	                		<div class="comments"><?php comments_popup_link(__('<span>0</span> Comments', 'woothemes'), __('<span>1 Comment', 'woothemes'), __('<span>%</span> Comments', 'woothemes')); ?>
	                		</div>
	                	</li>
	                	
						<li class="button-retweet"><script type="text/javascript">
						tweetmeme_style = 'compact';
						tweetmeme_source = 'e27sg';
						tweetmeme_url = '<?php the_permalink(); ?>';
						</script>
						<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
						</li>
						
						<li class="facebook">
						<!--
	                		<a name="fb_share" type="button_count" share_url="<?php the_permalink(); ?>" href="http://www.facebook.com/sharer.php">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
	                		-->
							<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px"></iframe>	                		
	                	</li>
	                </ul>
	                </div>
	                 <div class="fix"></div>   
	             </div>                                                      
                <div class="box">
                    <div class="post">
                    	<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    	<p class="author"><span>by </span><?php the_author_posts_link(); ?></p>
                    	 <div class="entry">
                        
	                    	<?php if(!is_single()) { ?>    
								<?php //woo_get_image('image',$GLOBALS['thumb_width'],$GLOBALS['thumb_height'],'thumbnail '.$GLOBALS['align']); ?> 
								<?php if ( function_exists( 'get_the_image' ) ) get_the_image(array( 'custom_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'medium', 'width' => '200') ); ?>
								
							 <?php } ?>
							                    
	                        
	                        	<?php if(is_single()) { ?>                        
									<?php the_content(); ?>
	                            <?php } else {?>
	                            	<?php the_advanced_excerpt('exclude_tags=img,div&length=50'); ?>
	                            	<p class="read-more"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="button">read more</a></p>
	                            <?php } ?>
                            </div>
                        <div class="post-bottom">
                            <p><em>tagged </em><?php the_tags('<span class="tags">', ', ', '</span>'); ?></p> 
                            <div class="fix"></div>                       
                        </div>

                        <div class="fix"></div>
                    </div><!-- /.post -->
                                             
                    
                </div><!-- /.box -->
