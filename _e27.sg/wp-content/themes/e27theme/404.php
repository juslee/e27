<?php get_header(); ?>
<div id="bodi">
	<!-- div id="bodya">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="bodyam1">
				</td>
				<td id="bodyam2">
				</td>
				<td id="bodya2">				
				</td> 
				<td id="bodyam3">
				</td>
				<td id="bodyam4">
				</td>
			</tr>
		</table>
	</div --> <!-- /body a -->
	<div id="bodyb">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="bodyb1">
					<div id="content" class="widecolumn">
						<h2 class="pagetitle">The page cannot be found (Error 404)</h2>
							<p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
							<p>Please try one of these links on the menu above or the ones below:</p>
							<ul>
								<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
								<!-- li><a href="<?php bloginfo('url'); ?>/sitemap">Sitemap</a></li -->
							</ul>
					</div>
				</td> <!-- /body b1 -->
				<td id="bodybm2">
				</td>
				<td id="bodyb2">
					<?php get_sidebar(); ?>
				</td> <!-- /body b2 -->
				<td id="bodybm3">
				</td>
			</tr>
		</table>
	</div> <!-- /body b -->
	<div id="bodyc">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="bodycm1">
				</td>
				<td id="bodyc1">
				</td> <!-- /body c1 -->
				<td id="bodycm2">
				</td>
				<td id="bodyc2">
				</td> <!-- /body c2 -->
				<td id="bodycm3">
				</td>
				<td id="bodyc3">
				</td> <!-- /body c3 -->
				<td id="bodycm4">
				</td>
			</tr>
		</table>
	</div> <!-- /body c -->
</div> <!-- /bodi -->

<?php get_footer(); ?>