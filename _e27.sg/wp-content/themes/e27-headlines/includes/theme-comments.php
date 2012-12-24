<?php
// Fist full of comments
function custom_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
                 
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    
    	<a name="comment-<?php comment_ID() ?>"></a>
      	
      	<div class="comment-container">

			<?php if(get_comment_type() == "comment"){ ?>
            
            <div class="avatar"><?php the_commenter_avatar($args) ?></div>
        
            <?php } ?>
      	    
            <div class="comment-right">
                    
                <div class="comment-head">
                                
                    <span class="name fl"><?php the_commenter_link() ?></span>
                    
                    <?php if(get_comment_type() == "comment"){ ?>
                    
                        <span class="reply fr"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span><!-- /.reply -->
                        <span class="date fr"><a href="<?php echo get_comment_link(); ?>" title="<?php _e('Direct link to this comment', 'woothemes'); ?>"><?php echo get_comment_date($GLOBALS['woodate']) ?> <?php _e('at', 'woothemes'); ?> <?php echo get_comment_time(); ?></a></span>
                    <?php }?>
                        <span class="edit fr"><?php edit_comment_link('Edit &nbsp;', '', ''); ?></span>
                                        
                </div><!-- /.comment-head -->
              
                <div class="comment-entry"  id="comment-<?php comment_ID(); ?>">
                
                    <?php comment_text() ?>
                    
                    <?php if ($comment->comment_approved == '0') { ?>
                        <p class='unapproved'><?php _e('Your comment is awaiting moderation.', 'woothemes'); ?></p>
                    <?php } ?>
                    
        
                </div><!-- /comment-entry -->
            
            </div><!-- /comment-right -->
		
		</div><!-- /.comment-container -->
		
<?php 
}

// PINGBACK / TRACKBACK OUTPUT
function list_pings($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment; ?>
	
	<li id="comment-<?php comment_ID(); ?>">
		<span class="author"><?php comment_author_link(); ?></span> - 
		<span class="date"><?php echo get_comment_date($GLOBALS['woodate']) ?></span>
		<span class="pingcontent"><?php comment_text() ?></span>

<?php 
} 
	
function the_commenter_link() {
    $commenter = get_comment_author_link();
    if ( ereg( ']* class=[^>]+>', $commenter ) ) {$commenter = ereg_replace( '(]* class=[\'"]?)', '\\1url ' , $commenter );
    } else { $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );}
    echo $commenter ;
}

function the_commenter_avatar($args) {
    $email = get_comment_author_email();
    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( "$email",  $args['avatar_size']) );
    echo $avatar;
}

?>