
<div id="loopedSlider" class="box">

    <?php if ( get_option('woo_featured_banner') == "true" ) { ?><div class="featured-banner"><?php _e('Featured', 'woothemes'); ?></div><?php } ?>
    
    <?php
		$featposts = get_option('woo_featured_entries'); // Number of featured entries to be shown
		$GLOBALS[feat_tags_array] = explode(',',get_option('woo_featured_tags')); // Tags to be shown
        foreach ($GLOBALS[feat_tags_array] as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 )
				$tag_array[] = $tag['term_id'];
		}
    ?>    

	

    <div class="container">
    
        <div class="slides">
        
        	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
        	<?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
            
            <div id="slide-<?php echo $count; ?>" class="slide">                
                    <div class="entry">
                    	<span class="cat">featured</span>
                        <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        
                
                            <?php //woo_get_image('image',$GLOBALS['thumb_width_feat'],$GLOBALS['thumb_height_feat'],'thumbnail '.$GLOBALS['align_feat']); ?> 
                            
                            <?php if ( function_exists( 'get_the_image' ) ) get_the_image(array( 'custom_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'medium', 'width' => '200') ); ?>
                    	
                        
	                        <p><?php the_advanced_excerpt('exclude_tags=img,p&length=50'); ?></p>
	                        
	                        <p><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="button">read more</a></p>
                       
        			
                    </div><!-- /.entry -->
                    
        
            </div>
            
		<?php endwhile; ?> 
		<?php endif; $wp_query = $saved; ?>   

        </div><!-- /.slides -->
        
        	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
            <?php if (have_posts()) : $count = 0; ?>
        
        	<div class="featured-nav">
        		<h4>more featured headlines</h4>
                <ul class="pagination">
        			<?php while (have_posts()) : the_post();  $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
                    <li>
                    	<a href="#">
                    		<?php echo $count; ?>
                        </a>
                    </li>
                  	<?php endwhile; ?>      
                </ul>      
            </div> 
                
        	<?php endif; $wp_query = $saved; ?>    
        	        
    </div><!-- /.container -->
	<div class="fix"></div>
    
   
    <?php update_option("woo_exclude", $GLOBALS[shownposts]); ?>
        
</div><!-- /#loopedSlider -->
