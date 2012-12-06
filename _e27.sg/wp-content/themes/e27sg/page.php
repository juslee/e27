<?php get_header(); ?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/post.css" type="text/css" />
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
				<div id="post-<?php the_ID(); ?>" class="post full">
					<div class="title">
						<h1 class="post-title"><?php the_title(); ?></h1>
					</div>
					<div class="description clearfix">          
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; else: ?>
            <?php endif; ?>  					
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>