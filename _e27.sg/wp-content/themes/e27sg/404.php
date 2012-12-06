<?php 

/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Green_Is_Good
 * @since Green Is Good 1.0
 */
get_header(); ?>
		<div id="body">
			<div class="container container_2 clearfix">
				<div class='grid_1' style="width: 719px; padding-right: 15px;">
					<?php include( TEMPLATEPATH . '/includes/startup_quotes.php' ); ?>
					<?php include (TEMPLATEPATH . '/searchform.php'); ?>
					<div id="results-header">
						<h1>Your requested page was not found</h1>
						<p style="margin-top: 20px;">
							Have you tried searching for the content you're looking for?
						</p>
						
						<p style="margin-top: 20px;">
							If you believe there should be a page here, please contact us so we can be aware.
						</p>
					</div>
					
					
					<?php include( TEMPLATEPATH . '/includes/ads-2x300.php' ); ?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>