<?php
/*
Template Name: Long Copy
Template Description: A simple long copy landing page.
*/

get_header();
	?>
	<div id="content" class="hfeed">
		<?php the_post(); ?>
		<div id="sharebar" class="post_share rail">
			<div class="share-buttons share-button-rail" style='text-align:center'>
				<div>
					<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=453738384663077";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
				</div>
				<div>
					<a href="https://twitter.com/share?count=vertical" class="twitter-share-button" data-url="<?php the_permalink() ?>">Tweet</a>
    				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div>
					<g:plusone href="<?php the_permalink() ?>" size="tall"></g:plusone>
					<script type="text/javascript">
					  (function() {
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div>
				<div>
					<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/Share" data-counter="top"></script>
				</div>
				<div style='padding-top:10px'>
					<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>" class="pin-it-button" count-layout="vertical">Pin It</a>
					<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
				</div>
				<div>
					<su:badge layout="5" location="<?php the_permalink(); ?>"></su:badge>
					<script type="text/javascript">
					  (function() {
						var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
						li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
					  })();
					</script>
				</div>


			</div>
		</div> 
		<div class="hentry">
			
			<?php include('inc/headline.php'); ?>
			<div class="entry-content"><?php the_content(); ?></div>
		</div>
	</div><!-- end #content -->
	<?php
get_footer();