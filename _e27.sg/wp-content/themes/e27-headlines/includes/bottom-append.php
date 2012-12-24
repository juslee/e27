<div id="bottom-append">

	<?php if(is_single()) {?>
	
	<div id="related-reads" class="widget post-list">
		<h3><em>Related</em> Reads</h3>	
		<?php related_posts() ?>
	</div>
	<?php } ?>

	<div id="popular-reads" class="widget post-list">
		<h3><em>Popular</em> Reads</h3>	
		<?php if (function_exists('wpp_get_mostpopular')) wpp_get_mostpopular("range=weekly&order_by=views&limit=5&stats_comments=0&pages=0"); ?>
	</div>
</div> <!-- appends to the end of every post listing and single post -->