<div id="page-nav">
    <div class="col-full">
        <ul id="nav" class="fl">
        	<li id="home"><a href="/">Home <span class="nav-description">frontpage news</span></a></li>
			<?php 
        	if ( get_option('woo_custom_nav_menu') == 'true' && function_exists('woo_custom_navigation_output') ) {
			
			woo_custom_navigation_output('name=Woo Menu 1');
			
			} else { ?>
        
            <?php wp_list_pages('sort_column=menu_order&depth=4&title_li=&exclude='.get_option('woo_nav_exclude')); ?>
            
			<?php }	?>
            
            
        </ul><!-- /#nav1 -->
    </div><!-- /.col-full -->
</div><!-- /#page-nav -->
