<?php get_header(); ?>

	<div id="content">
	<?php tantan_fbShowBadge() ?>

	<img src="<?php bloginfo('template_directory')?>/images/badge-shadow.png">
	<br/><br/>
		<table width=640px>
			<tr>
				<th>UNCONFERENCE EVENTS</th>
				<th>CAMPUS OUTREACH PROGRAMMES</th>
				<th>CONTRIBUTE TO OUR EVENTS</th>
			</tr>
			<tr height= 135px;>
				<td width="33%" align="center">By inviting leaders & startups in relevant fields to showcase their ideas & products - through interaction & brainstorming sessions - we aim to maximise your takeaway value.<a href="index.php/events/unconferences"><br/>Read More</a></td>
				<td width="33%" align="center">Campus Outreach Programmes focuses on spreading the entrepreneurial spirit, inviting startups to share their valuable experiences with the students in different instituitions.<a href="index.php/outreach-events"><br/>Read More</a></td>
				<td width="33%" align="center">If you want to showcase your new product, have a fantastic idea to share with others, or simply just looking for an avenue to distribute and raise awareness of your products, we can help.<a href="index.php/about-us/sponsors"><br/>Read More</a></td>
			</tr>
		</table>
	<br/><br/>
	<img border=none src="http://www.e27.sg/blog/wp-content/uploads/e27-blogbanner.jpg" width=635> 	
	<!--<iframe src="http://www.google.com/calendar/hosted/e27.sg/embed?title=Upcoming%20Events!&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=e27.sg_1or99s2a6r98gkvhjjekl4n6h0%40group.calendar.google.com&amp;color=%23B1365F&amp;ctz=Asia%2FSingapore" style=" border-width:0 " width="600" height="400" frameborder="0" scrolling="no"></iframe>-->

	<!--	<?php
		   if (is_home()) {
	      		query_posts('cat=-33');
		}?> -->
	   	<?php if (have_posts()) : ?>
		       <?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<abbr title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?></abbr><!-- by  <?php the_author() ?> -->
					<br />
					<div class="entry"><?php the_content('...READ MORE', FALSE); ?><br />
					<p class="postmetadata">Posted in <span class="cty"><?php the_category(', ') ?> by <?php the_author()?></span> | <?php edit_post_link('Edit', '', ' | '); ?>  <span class="cmt"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span></p>
					</div></div>
			<?php endwhile; ?>
				<a href="http://www.e27.sg/2008/page/2">Read More Blog Posts</a>

				<?php else: ?> 
					<div class="entry">
						<h2>Not Found</h2>
						Sorry, but you are looking for something that isn't here.
					</div>
				<?php endif; ?>
<!--	<img src="<?php bloginfo('template_directory')?>/images/badge-shadowR.png">
	<div id="links">
		<div style="width:200px;float:left;overflow:hidden;"><?php wp_list_bookmarks('title_li="hi"&category_before=&category_after=&category=6'); ?></div>
		<div style="width:200px;float:left;overflow:hidden;"><?php wp_list_bookmarks('title_li=&category_before=<ul>&category_after=</ul>&category=2'); ?></div>
		<div style="width:200px;float:left;overflow:hidden;"><?php wp_list_bookmarks('title_li=&category_before=<ul>&category_after=</ul>&category=5'); ?></div>
	</div>
	<img src="<?php bloginfo('template_directory')?>/images/badge-shadow.png"> -->
	</div>
	
		
<?php get_sidebar(); ?>

<?php get_footer(); ?>
