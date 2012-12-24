<?php get_header(); ?>

<div id="content"> 
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="entry">
			<div class="post" id="post-<?php the_ID(); ?>">
				<h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<abbr title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?></abbr> by <?php the_author() ?>
		
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
			</div>
		</div>

<div class="navigation">
	<div class="alignleft">
		<div class="cssbutton"><?php previous_post_link('« %link', 'Previous Post', false) ?></div>
	</div>
	<div class="alignright">
		<div class="cssbutton"><?php next_post_link('%link »', 'Next Post', false) ?></div>
	</div>
</div>
<br style="clear:both;"/>
	<h2>Related Posts:</h2>
	<?php similar_posts(); ?>
	<h2>Other Posts:</h2>
	<?php random_posts(); ?>
<div class="entry">
	<?php comments_template(); ?>
	</div>

	<?php endwhile; else: ?>
<div class="entry">
		<p>Sorry, no posts matched your criteria.</p>
</div>
<?php endif; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
