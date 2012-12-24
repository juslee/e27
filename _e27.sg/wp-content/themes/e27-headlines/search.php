<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
            <?php if (have_posts()) : $count = 0; ?>
            
                <h2 class="archive_header"><?php _e('Search results', 'woothemes') ?> for <em><?php printf(the_search_query()); ?></em></h2>
                
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
