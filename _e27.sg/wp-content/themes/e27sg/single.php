<?php get_header(); ?>
<!-- Add the following three tags to your body. -->

		<div id="body">
			<div class="container container_2 clearfix">
				<div class='body-main-content grid_1'>
					<?php $permalink = ''; ?>
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<script src="<?php bloginfo('template_directory') ?>/js/sharebar.js" type="text/javascript"></script>
					<script type="text/javascript">
						jQuery(document).ready(function($) { $('.sharebar').sharebar({horizontal:'true',swidth:'70',minwidth:1000,position:'left',leftOffset:30,rightOffset:10}); });
					</script>
					<?php $permalink = get_permalink(); ?>
					<div id="post-<?php the_ID(); ?>" class="post full">
						<div class="title">
							<h1 class="post-title"><?php the_title(); ?></h1>
						</div>
						<div class="post_info">
							<table cellpadding="0" cellspacing="0" style='display:inline'>
							<tr>
							<td>
							By <span class="author_name"><?php the_author_posts_link(); ?></span>
							</td>
							<td id='gplusauthor'>
							<?php
							$googleplus = get_the_author_meta('googleplus');
							
							$gid = str_replace("https://plus.google.com/u/0/", "", $googleplus);
							$gid = str_replace("https://plus.google.com/", "", $gid);
							$gid = str_replace("/posts", "", $gid);
							if(trim($gid)){
								?><a href="https://plus.google.com/<?php echo $gid; ?>?rel=author"><img style='margin: 0 5px 0 5px !important;' src="<?php bloginfo('template_directory') ?>/gplus.png" /></a><?php
								/*?><a href="<?php echo $googleplus; ?>?rel=author"><img style='margin: 0 5px 0 5px !important;' src="<?php bloginfo('template_directory') ?>/gplus.png" /><?php*/
                            	echo get_option( 'siteurl' );
								echo str_replace("http://www.", "http://", $permalink);
							}
							
							?>
							</td>
							</tr>
							</table>
							<script>
							jQuery("#gplusauthor").hide();
							</script>
							<?php

								/*$googleplus = get_the_author_meta('googleplus');
								if(!empty($googleplus)) {
									echo '<a href="'.$googleplus.'?rel=author" target="_blank"><img src="'.get_bloginfo('template_directory').'/img/icon-googleplus-author-24x24.png" class="authoricon" /></a>';
								}*/
							?>
                             | <?php the_time('M j, Y'); ?> | 
							<?php 
								$categories = get_the_category();
								if (is_array($categories) && count($categories) > 0) {
									$category = $categories[0]->name;
									?>
									<span class="post_category"><a href="<?php echo get_category_link($categories[0]->cat_ID) ?>"><?php echo $category ?></a></span>
									<?php
								}
							?>
						</div>
						<div class="description clearfix">
							<div id="sharebar" class="post_share rail">
								<div class="share-buttons share-button-rail">
									<div>
										<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>
									</div>
									<div>
										<a href="https://twitter.com/share?count=vertical" class="twitter-share-button" data-url="<?php echo str_replace("http://www.", "http://", $permalink); ?>">Tweet</a>
									</div>
									<div>
										<g:plusone href="<?php echo str_replace("http://www.", "http://", $permalink); ?>" size="tall"></g:plusone>
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
							<?php the_content(); ?>
							
							<?
								$tags = wp_get_post_tags(get_the_ID());
								if($tags) {
									$taglinks = array();
									foreach($tags as $t) {
										array_push($taglinks, '<a href="'.get_tag_link($t->term_id).'">'.$t->name.'</a>');
									}
									if($_GET['showtags']){
										echo '<p>Tags: '.implode(', ', $taglinks).'</p>';
									}
								}
							?>
							<?php edit_post_link(); ?>
						</div>
						
						
						<?php
						$post_id = get_the_ID();
						$companies = trim(get_post_meta( $post_id, 'startuplist_companies', true ));
						$investment_orgs = trim(get_post_meta( $post_id, 'startuplist_investment_orgs', true ));
						$people = trim(get_post_meta( $post_id, 'startuplist_people', true ));
						if(count($companies)||count($investment_orgs)||count($people)){
							function word_limit($str, $limit){
								$str .= "";
								$str = trim($str);
								$l = strlen($str);
								$s = "";
								for($i=0; $i<$l; $i++)
								{
									$s .= $str[$i];
									if($limit>0&&(preg_match("/\s/", $str[$i])))
									{  
										if(!preg_match("/\s/", $str[$i+1]))
											$limit--;
										if(!$limit)
										{
											return $s."...";
											break;
										}
									}
								}
								return $s;
							}
							
							function company27x($slug, $id=""){
								$json = file_get_contents("http://27x.co/company/".$slug."~json/".$id);
								$data27x = json_decode($json);
								if(!trim($data27x->name)){
									return false;
								}
								?>
								<table class='x27tablecontent'>
									<tr>
										<td width='25%'>
											<a href='http://27x.co/company/<?php echo $data27x->slug; ?>'><img src='http://27x.co/media/image.php?p=<?php echo $data27x->logo; ?>&mx=150' /></a>
										</td>
										<td width='25%'>
											<div class='label'>Company</div>
											<div class='value'><?php echo $data27x->name; ?></div>
											<?php
											if(trim($data27x->website)){
												?>
												<div class='label'>Website</div>
												<div class='value'><a href='<?php echo $data27x->website; ?>'><?php echo $data27x->website; ?></a></div>
												<?php
											}
											
											if(trim($data27x->Founded)){
												?>
												<div class='label'>Founded</div>
												<div class='value'><?php echo $data27x->founded; ?></div>
												<?php
											}
											?>
										</td>
										<td width='50%'>
											<div class='description'>
												<?php echo nl2br(word_limit($data27x->description, 45)); ?>
												
												<div class='more'><a href='http://27x.co/company/<?php echo $data27x->slug; ?>' style='font-weight:bold; font-size:12px'>More on <?php echo $data27x->name; ?> &raquo;</a></div>
											</div>
										</td>
									</tr>
								</table>
								<?php
							}
							
							function investment_org27x($slug, $id=""){
								$json = file_get_contents("http://27x.co/investment_org/".$slug."~json/".$id);
								$data27x = json_decode($json);
								if(!trim($data27x->name)){
									return false;
								}
								?>
								<table class='x27tablecontent'>
									<tr>
										<td width='25%'>
											<a href='http://27x.co/investment_org/<?php echo $data27x->slug; ?>'><img src='http://27x.co/media/image.php?p=<?php echo $data27x->logo; ?>&mx=150' /></a>
										</td>
										<td width='25%'>
											<div class='label'>Investment Organization</div>
											<div class='value'><?php echo $data27x->name; ?></div>
											<?php
											if(trim($data27x->website)){
												?>
												<div class='label'>Website</div>
												<div class='value'><a href='<?php echo $data27x->website; ?>'><?php echo $data27x->website; ?></a></div>
												<?php
											}
											
											if(trim($data27x->Founded)){
												?>
												<div class='label'>Founded</div>
												<div class='value'><?php echo $data27x->founded; ?></div>
												<?php
											}
											?>
											
										</td>
										<td width='50%'>
											<div class='description'>
												<?php echo nl2br(word_limit($data27x->description, 45)); ?>
												
												<div class='more'><a href='http://27x.co/investment_org/<?php echo $data27x->slug; ?>' style='font-weight:bold; font-size:12px'>More on <?php echo $data27x->name; ?> &raquo;</a></div>
											</div>
										</td>
									</tr>
								</table>
								<?php
							}
							
							function person27x($slug, $id=""){
								$json = file_get_contents("http://27x.co/person/".$slug."~json/".$id);
								$data27x = json_decode($json);
								if(!trim($data27x->name)){
									return false;
								}
								?>
								<table class='x27tablecontent'>
									<tr>
										<td width='25%'>
											<a href='http://27x.co/person/<?php echo $data27x->slug; ?>'><img src='http://27x.co/media/image.php?p=<?php echo $data27x->profile_image; ?>&mx=150' /></a>
										</td>
										<td width='25%'>
											<div class='label'>Name</div>
											<div class='value'><?php echo $data27x->name; ?></div>
											<?php
											if(trim($data27x->blog_url)){
												?>
												<div class='label'>Blog</div>
												<div class='value'><a href='<?php echo $data27x->blog_url; ?>'><?php echo $data27x->blog_url; ?></a></div>
												<?php
											}
											?>
										</td>
										<td width='50%'>
											<div class='description'>
												<?php echo nl2br(word_limit($data27x->description, 45)); ?>
												
												<div class='more'><a href='http://27x.co/person/<?php echo $data27x->slug; ?>' style='font-weight:bold; font-size:12px'>More on <?php echo $data27x->name; ?> &raquo;</a></div>
											</div>
										</td>
									</tr>
								</table>
								<?php
							}

							
							
							
							?>
							<style>
								#x27 .x27head{
									background:#21913E;
									color: white;
									padding:3px;
									font-size:22px;
									font-weight:bold;
									border: 1px solid #21913E;
								}
								#x27 .x27head a:link, #x27 .x27head a:hover, #x27 .x27head a:visited{
									font-size:22px;
									font-weight:bold;
									color: white;
									text-decoration:none;
								}
								#x27 .x27content{
									border-left:1px solid #CCCCCC;;
									border-right:1px solid #CCCCCC;;
									border-bottom:1px solid #CCCCCC;;
								}
								#x27 td{
									vertical-align:top;
								}
								#x27 .x27table{
									width:100%;
									
								}
								
								#x27 .x27tablecontent td{
									padding:20px;
								}
								#x27 .label{
									font-size:16px;
									color:#333333;
									font-weight:bold;
								}
								#x27 .value{
									font-size:16px;
									color: black;
									padding-bottom:10px;
								}
								#x27 .description{
									font-size:16px;
									color: black;
									border: 0px;
									padding:0px;
								}
								#x27 .more{
									font-size:12px;
									padding-top:10px;
								}
								#x27 a:link, #x27 a:hover, #x27 a:visited {
									color: #21913E;
									text-decoration: none;
									font-size:16px;
								}
								.post.full #x27 img {
									margin: 0px 0px 0px 0px !important;
									float:none;
									border:0px;
								}
							</style>
							<div id='x27'>
							<table class='x27table'>
								<tr>
									<td class='x27head'>
										<a href='http://27x.co'>27X.CO</a>
									</td>
								</tr>
								<tr>
									<td class='x27content'>
										<?php
											
											if($companies){
												$companies = json_decode($companies);
												foreach($companies as $value){
													company27x("id", $value);
												}
											}
											if($investment_orgs){
												$investment_orgs = json_decode($investment_orgs);
												foreach($investment_orgs as $value){
													investment_org27x("id", $value);
												}
											}
											if($people){
												$people = json_decode($people);
												foreach($people as $value){
													person27x("id", $value);
												}
											}
											
											
											/*
											company27x("e27");
											company27x("YOOSE");
											investment_org27x("Red-Dot-Ventures-Pte-Ltd");
											person27x("Mohan-Belani");
											*/
										?>
									</td>
								</tr>
								
							</table>
							</div>
							<?php
							
							
						}
						?>
						

						<div id="nav-below" class="navigation clearfix">
							<?php previous_post_link( '<div class="nav-previous fl">%link</div>', '%title' ); ?>
							<?php next_post_link( '<div class="nav-next fr">%link</div>', '%title' ); ?>
						</div><!-- #nav-below -->

						<div id="nav-below-btn" class="navigation clearfix">
							<?php previous_post_link( '<div class="nav-previous-btn fl">%link</div>', '&lsaquo; Prev Story'); ?>
							<?php next_post_link( '<div class="nav-next-btn fr">%link</div>', 'Next Story &rsaquo;'); ?>
						</div><!-- #nav-below -->
						
						
						

						
						
						<?php
						if($_GET['outbrain']||1){
							?>
						<!-- outbrain -->
							<style>
								.AR_1 {
									border-left: 0px dotted #329330!important;
									border-right: 0px dotted #329330!important;
									border-top: 0px dotted #329330!important;
									border-top-left-radius: 0px!important;
									border-top-right-radius: 0px!important;
									padding: 10px!important;
								}
								.AR_2 {
									border-bottom: 0px dotted #329330!important;
									border-bottom-left-radius: 0px!important;
									border-bottom-right-radius: 0px!important;
									border-left: 0px dotted #329330!important;
									border-right: 0px dotted #329330!important;
									padding: 10px!important;
								}
								#outbrainx img {
									margin:0px!important;
								}
								#outbrainx{
									padding-top:20px;
								}
							</style>
							<div id='outbrainx'>
								<div class="OUTBRAIN" data-src="<?php the_permalink() ?>" data-widget-id="AR_1" data-ob-template="e27" ></div> 
	<div class="OUTBRAIN" data-src="<?php the_permalink() ?>" data-widget-id="AR_2" data-ob-template="e27" ></div> 
	<script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
                            </div>

						<?php
					}
					?>

					</div>
					<?php endwhile; // end of the loop. ?>
					<?php
						/*
						//for use in the loop, list 5 post titles related to first tag on current post
						$tags = wp_get_post_tags(get_the_ID(), array( 'fields' => 'ids' ));
						if ($tags) {
							$args = array(
								'tag__in' => $tags,
								'post__not_in' => array(get_the_ID()),
								'showposts'=> 4,
								'ignore_sticky_posts'=>1
							);
							$my_query = new WP_Query($args);
							if(!$my_query->have_posts()) {
								$my_query = new WP_Query(array('post__not_in' => array(get_the_ID()), 'posts_per_page' => 4, 'orderby' => 'rand' ));
							}
							if( $my_query->have_posts() ) {
								?>
								<div id="we_also_recommend" class="clearfix">
									<h3><span class="midline">You Might Like:</span></h3>
									<div id="we_also_recommend_stories" class="clearfix">					
											<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
										<div class="we_also_recommend_story">
											<div class="story_image">
												<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo_first_image(get_the_ID(), 132); ?></a>
											</div>
											<div class="story_title">
												<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
											</div>
										</div>
											<?php endwhile; ?>
									</div>
								</div>
								<?php 	
							}
							wp_reset_query();
							
						}
						*/
						//<div class="fb-comments" data-href=" echo $permalink " data-num-posts="2" data-width="719"></div>
						
					?>
					<?php comments_template(); ?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
<?php get_footer(); ?>