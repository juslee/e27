<?php get_header(); ?>

    <div id="content" class="col-full">
		<div id="main" class="col-left">
		
		<?php $showfeatured = get_option('woo_featured'); if ($showfeatured <> "true") update_option("woo_exclude", ""); ?>
		<?php if ( !$paged && $showfeatured == "true" ) include ( TEMPLATEPATH . '/includes/featured.php' ); ?>
            
			<?php  
				$exclude = get_option('woo_exclude');
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
				$args = array( 'post__not_in' => $exclude, 'cat' => '-'.$GLOBALS[video_id], 'paged'=> $paged ); query_posts($args);		
			?>
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
            
            <?php if ($count == 5) : ?>
	            <?php include( TEMPLATEPATH . '/ads/2x300.php' ); ?>
            <?php endif; $count++; ?>
                
                
   			<?php include( TEMPLATEPATH . '/includes/post-layout.php' ); ?>
                                                    
			<?php endwhile; else: ?>
                <div class="box">
                    <div class="post">
                        <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                    </div><!-- /.post -->
                </div><!-- /.box -->
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