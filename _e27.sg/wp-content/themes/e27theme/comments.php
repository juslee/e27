                <div class="CommentsBox box">
                <?php // Do not delete these lines
                    if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
                        die ('Please do not load this page directly. Thanks!');
                
                    if (!empty($post->post_password)) { // if there's a password
                        if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
                            ?>
                
                            <p class="nocomments">This post is password protected. Enter the password to view comments.</p>
                
                            <?php
                            return;
                        }
                    }
                
                    /* This variable is for alternating comment background */
                    $oddcomment = '';
                ?>
                
                <!-- You can start editing here. -->
                
                <?php
                    $in_subcategory_companies = false;
                    foreach( explode( "/", get_category_children( get_cat_id('Companies') ) ) as $child_category ) {
                        if(in_category($child_category)) $in_subcategory_companies = true;
                    }
                ?>
                
                <?php if ($comments) : ?>
				<?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                  
                  	<h1 class="Smallbox"><?php comments_number('No Testimonials', 'One Testimonial', '% Testimonials' );?> to &#8220;<?php the_title(); ?>&#8221;</h1>
                    <?php } else { ?>
					<h1 class="Smallbox"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h1>
	<?php } ?>
                    
                    <ul class="Lists">
                        
                        <?php foreach ($comments as $comment) : ?>
                    	<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>"><p class="Smallbox"><a href="" class="BlueFont"><b><?php comment_author_link() ?></b></a> said : </p>
                        
                            <a href="" class="left">
                            <?php if(function_exists('cmd_show_avatar' && $userid)){ cmd_show_avatar(); } ?>
						    <?php echo get_avatar($comment, 32); ?>
                            </a>
                            <?php if ($comment->comment_approved == '0') : ?>
                            <?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                                <em>Your testimonial is awaiting moderation.</em>
                            <?php } else { ?>
                                <em>Your comment is awaiting moderation.</em>
                            <?php } ?>
                            <?php endif; ?>
                            <span class="CContent"><?php comment_text() ?></span>
                            
                            <br class="clear" />
                            
                            <div class="SmallFont right"><a href="#comment-<?php comment_ID() ?>" title="" class="BlueFont">- <?php comment_date('F jS, Y') ?> at <?php comment_time() ?> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></a></div>
                            
                            <br class="clear" />
                        </li>
                        <?php
                        /* Changes every other comment to a different class */
                        $oddcomment = ( empty( $oddcomment ) ) ? '' : '';
                    ?>
                
                    <?php endforeach; /* end for each comment */ ?>  
                    </ul>
                    <?php else : // this is displayed if there are no comments so far ?>

                    <?php if ('open' == $post->comment_status) : ?>
                        <!-- If comments are open, but there are no comments. -->
                
                     <?php else : // comments are closed ?>
                        <!-- If comments are closed. -->
                        <?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                            <p class="nocomments">Testimonials are closed.</p>
                        <?php } else { ?>
                            <p class="nocomments">Comments are closed.</p>
                        <?php } ?>
                
                    <?php endif; ?>
                <?php endif; ?>
                    
                  </div><br />
                  
                  
                  <div class="LYCBox">
                       
                       <?php if ('open' == $post->comment_status) : ?>

				      <?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                      <h1 class="Smallbox">Leave your Comment</h1>
                      
                      <?php } else { ?>
						<h1 class="Smallbox">Leave Your Comment</h1>
					  <?php } ?>
                      
                      <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
                        <?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                            <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a testimonial.</p>
                        <?php } else { ?>
                            <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
                        <?php } ?>
                    <?php else : ?>
                    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                       
                       <?php if ( $user_ID ) : ?>
                        <?php $fbuid = fbc_get_fbconnect_user(); ?>
                        <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
                            <?php if ($fbuid) { ?>
                                <a onclick="FBConnect.logout(); return false" href="#" title="Log out of this Account">Logout &raquo;</a></p>
                            <?php } else { ?>
                                <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this Account">Logout &raquo;</a></p>
                            <?php } ?>
                                
                        <?php else : ?>
                        <?php do_action('fbc_display_login_button') ?>
                        
                      <div class="Smallbox">
                      <label for="author">Name <?php if ($req) echo "(required)"; ?></label><br class="clear" />
                      <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
                      </div>
                      
                      <div class="Smallbox">
                      <label for="email">Email <?php if ($req) echo "(required but never published)"; ?> </label><br class="clear" />
                      <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
                      </div>
                      
                      <div class="Smallbox">
                      <label for="url">Website <?php if ($req) echo "(optional)"; ?></label><br class="clear" />
                      <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
                      </div>
                      
                      <?php endif; ?>
                      
                      <div class="Smallbox">
                      <textarea name="comment" id="comment" cols="100%"></textarea>
                      </div>
                      <?php if ( in_category( get_cat_id('Companies') ) || $in_subcategory_companies ) { ?>
                      <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
                      <?php } else { ?>
					  <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				      <?php } ?>
                      <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                      
                      <?php do_action('comment_form', $post->ID); ?>
                      </form>
                      
                      <?php endif; // If registration required and not logged in ?>

					  <?php endif; // if you delete this the sky will fall on your head ?>
                  </div>