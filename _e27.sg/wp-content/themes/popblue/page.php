<?php get_header(); ?>

	<div id="content">
	<div class="entry">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
		
		<div class="breadcrumb">
			<?php
				if (function_exists('breadcrumb_nav_xt_display'))
		 		{
					// Display the breadcrumb
					breadcrumb_nav_xt_display();
		  		}
			?>
		</div>
		
				<?php the_content(' class="serif">Read the rest of this page &raquo;'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>