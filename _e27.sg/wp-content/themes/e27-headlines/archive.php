<?php get_header(); ?>


<?php //code to get author's name outside loop
if(get_query_var('author_name')) :
    $curauth = get_userdatabylogin(get_query_var('author_name'));
else :
    $curauth = get_userdata(get_query_var('author'));
endif;
?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
		<?php if (have_posts()) : $count = 0; ?>
        
            <?php if (is_category()) { ?>
            <span class="archive_header"><span class="fl"><?php _e('Topic', 'woothemes'); ?> | <?php echo single_cat_title(); ?></span> <span class="fr catrss"><?php $cat_obj = $wp_query->get_queried_object(); $cat_id = $cat_obj->cat_ID; echo '<a href="'; get_category_rss_link(true, $cat, ''); ?>"><?php _e('RSS feed for this section', 'woothemes'); ?></a></span></span>        
        
            <?php } elseif (is_day()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time($GLOBALS['woodate']); ?></span>

            <?php } elseif (is_month()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time('F, Y'); ?></span>

            <?php } elseif (is_year()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time('Y'); ?></span>

			<?php } elseif (is_author()) { ?>
            <span class="archive_header"><?php _e('Posts by: ', 'woothemes'); ?><?php echo $curauth->nickname; ?></span>

            <?php } elseif (is_tag()) { ?>
            <span class="archive_header"><?php _e('Tag Archives:', 'woothemes'); ?> <?php echo single_tag_title('', true); ?></span>
            
            <?php } ?>
            
            <div class="fix"></div>
        
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                                                                                      
                <?php include( TEMPLATEPATH . '/includes/post-layout.php' ); ?>        
                                                    
            <?php endwhile; else: ?>
            <div class="box">
                <div class="post">
                    <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            </div>        
            <?php endif; ?>  
            
            <?php include( TEMPLATEPATH . '/includes/bottom-append.php' ); ?>

            <div class="more_entries">
                <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
                <div class="fl"><?php previous_posts_link(__('Newer Entries', 'woothemes')) ?></div>
                <div class="fr"><?php next_posts_link(__('Older Entries', 'woothemes')) ?></div>
                <br class="fix" />
                <?php } ?> 
            </div>		
                
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>