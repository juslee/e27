<?php
//echo "<pre>";
//print_r($company);
//echo "</pre>";

?>
<table cellpadding="0" cellspacing="0" class='p100'>
	<tr>
		<td class='company_left'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class='logo'>
						<div>
						<a href="<?php echo site_url(); ?>investment_org/<?php echo $investment_org['slug']; ?>" title="<?php echo sanitizeX($investment_org['name'])?>" alt="<?php echo sanitizeX($investment_org['name'])?>">
						<?php
						if(trim($investment_org['logo'])){
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $investment_org['logo'] ?>&mx=220&square=1' />
							<?php
						}
						else{
							$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $logo; ?>&mx=220&square=1' />
							<?php	
						}
						?>
						</a>
						</div>
					</td>
				</tr>
				<?php
				if($_SESSION['web_user']){
					?>
					<tr>
						<td align="center">
							<?php
							echo "<div class='edit' style='text-align:center'><a href='".site_url()."editinvestment_org/".$investment_org['id']."/logo'>EDIT</div>";
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">
					OVERVIEW
					<?php
					if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editinvestment_org/".$investment_org['id']."/overview'>EDIT</div>"; }
					?>
					</td>
				</tr>
				<tr>
					<td class="content">
						<table cellpadding="0" cellspacing="0" class="p100">
							<?php
							if(trim($investment_org['website'])){
								$website = preg_replace("/http:\/\//i", "", $investment_org['website']);
								$website = preg_replace("/https:\/\//i", "", $investment_org['website']);
								if(
									strpos(strtolower(trim($investment_org['website'])),"http://")===false&&
									strpos(strtolower(trim($investment_org['website'])),"https://")===false
								){
									$investment_org['website'] = "http://".$investment_org['website'];
								}
								?>
								<tr>
									<td class='label'>
										Web
									</td>
									<td class='value'>
										<a href="<?php echo outlink($investment_org['website']); ?>"><?php echo $website; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($investment_org['blog_url'])){
								$blog_url = preg_replace("/http:\/\//i", "", $investment_org['blog_url']);
								$blog_url = preg_replace("/https:\/\//i", "", $investment_org['blog_url']);
								if(
									strpos(strtolower(trim($investment_org['blog_url'])),"http://")===false&&
									strpos(strtolower(trim($investment_org['blog_url'])),"https://")===false
								){
									$investment_org['blog_url'] = "http://".$investment_org['blog_url'];
								}
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo outlink($investment_org['blog_url']); ?>"><?php echo $blog_url; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($investment_org['twitter_username'])){
								?>
								<tr>
									<td class='label'>
										Twitter
									</td>
									<td class='value'>
										<?php
										$tws = explode(",", $investment_org['twitter_username']);
										$twitarr = array();
										foreach($tws as $twitter_username){
											$twitter_username = trim($twitter_username);
											$twitter_username = trim($twitter_username, "@");
											$tw = outlink('http://www.twitter.com/'.$twitter_username);
											$twitarr[] = '<a href="'.$tw.'">@'.$twitter_username.'</a>';
										}
										echo implode(", ", $twitarr);
										?>
									</td>
								</tr>
								<?php
							}
							if(trim($investment_org['facebook'])){
								if(
									strpos(strtolower(trim($investment_org['facebook'])),"http://")===false&&
									strpos(strtolower(trim($investment_org['facebook'])),"https://")===false
								){
									$investment_org['facebook'] = "http://".$investment_org['facebook'];
								}
								?>
								<tr>
									<td class='label'>
										Facebook
									</td>
									<td class='value'>
										<a href="<?php echo outlink($investment_org['facebook']); ?>"><?php echo $investment_org['name']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($investment_org['linkedin'])){
								if(
									strpos(strtolower(trim($investment_org['linkedin'])),"http://")===false&&
									strpos(strtolower(trim($investment_org['linkedin'])),"https://")===false
								){
									$investment_org['linkedin'] = "http://".$investment_org['linkedin'];
								}
								?>
								<tr>
									<td class='label'>
										LinkedIn
									</td>
									<td class='value'>
										<a href="<?php echo outlink($investment_org['linkedin']); ?>"><?php echo $investment_org['name']; ?></a>
									</td>
								</tr>
								<?php
							}
							
							if(trim($investment_org['founded'])){
								?>
								<tr>
									<td class='label'>
										Founded
									</td>
									<td class='value'>
										<?php echo date("Y", strtotime($investment_org['founded'])); ?>
									</td>
								</tr>
								<?php
							}
							
							?>
							
						</table>
					</td>
				</tr>
			</table>
			<?php
			$pt = count($people);
			if($pt){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">
						PEOPLE
						<?php
						if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editinvestment_org/".$investment_org['id']."/people'>EDIT</div>"; }
						?>
						</td>
					</tr>
					<tr>
						<td class="content">
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td>
										<table>
										<?php
										/*
										Array
										(
											[id] => 455
											[company_id] => 13
											[person_id] => 1
											[role] => Director
											[start_date] => 07/01/2008
											[start_date_ts] => 1214841600
											[end_date] => 07/01/2010
											[end_date_ts] => 1277913600
											[end_date_ts2] => 1277913600
											[name] => Mohan Belani
										)
										*/
										$inp = array();
										$n = 0;
										foreach($people as $value){
											if(!in_array($value['person_id'], $inp)){
												$inp[] = $value['person_id'];
												//if($value['end_date_ts2']>time()-(1*60*60)){
													$year = "";
													if((time()-$value['end_date_ts2'])>(1*60*60)){ //if last day is greater than yesterday
														$year = "(".date("Y", $value['end_date_ts2']).")";
													}
													echo "<tr>";
													
													if(trim($value['profile_image'])){
														echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['profile_image']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'>".$value['name']."</a> ".$year."<br />".$value['role']." </td>";
													echo "</tr>";
												//}
												//$n++;
											}
											//if($n>5){
											//	break;
											//}
										}
										
										
										?>
										</table>
										<?php
										//if($pt>5){
										//	echo "<div class='seeall'><a href='".site_url()."startuplist/io_people/".$investment_org['id']."'>See All ($pt)</a></div>";
										//}
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php
			}
			$cft = count($milestones);
			if($cft){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">INVESTMENTS</td>
					</tr>
					<tr>
						<td class="content">
							<?php
							
							$cf_total = array();
							for($cfi=0; $cfi<$cft; $cfi++){
								$cf_total[$milestones[$cfi]['currency']] += $milestones[$cfi]['amount'];
							}
							?>
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td class='bold padb10' colspan="2">
										Total
									</td>
									<td class='bold padb10 right'>
										<?php
										foreach($cf_total as $key=>$value){
											echo "<div>".$key.amountIze($value)."</div>";
										}
										?>
									</td>
								</tr>
								<?php
								for($cfi=0; $cfi<$cft; $cfi++){
									?>
									<tr>
										<td class='padb5' colspan="2">
											<?php
											echo $milestones[$cfi]['round'];
											?>
										</td>
										<td class='padb5 right'>
											<?php echo $milestones[$cfi]['currency'].amountIze($milestones[$cfi]['amount']); ?>
										</td>
									</tr>
									<tr>
										<td class='padb5' colspan="3" >
											<?php
											echo "<a href='".site_url()."company/".$milestones[$cfi]['slug']."'>"; 
											echo $milestones[$cfi]['company_name'];
											echo "</a>";
											?>
										</td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
					</tr>
				</table>
			<?php
			}
			?>
		</td>
		<td class='company_right'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class="company_name">
						<?php
						echo htmlentitiesX($investment_org['name']);
						if($_SESSION['web_user']||1){ echo "<div class='edit inline right'><a href='".site_url()."editinvestment_org/".$investment_org['id']."/about'>EDIT</div>"; }
						?>
					</td>
				</tr>
				<tr>
					<td class="description">
						<div class="description_title">Description</div>
						<div class="description_contents"><?php echo nl2br($investment_org['description']); ?></div>
					</td>
				</tr>
				<?php
				/*
				if(trim($investment_org['twitter_username'])){
					?>
					<tr>
						<td class="description">
							<div class="description_title">Tweets</div>
							<div class="tweets"></div>
							<?php
							$tws = explode(",", $investment_org['twitter_username']);
							$twitarr = array();
							$n = 0;
							foreach($tws as $twitter_username){
								$twitter_username = trim($twitter_username);
								?>
								<div id='tweet<?php echo $n; ?>'></div><br />
								<script>
								jQuery(function($){
									
									//jQuery("#tweet<?php echo $n; ?>").tweet({
									//	join_text: "auto",
									//	username: "<?php echo $twitter_username; ?>",
									//	avatar_size: 48,
									//	count: 5,
									//	auto_join_text_default: " we said, ",
									//	auto_join_text_ed: " we ",
									//	auto_join_text_ing: " we were ",
									//	auto_join_text_reply: " we replied ",
									//	auto_join_text_url: " we were checking out ",
									//	loading_text: "loading tweets..."
									//});
									
									jQuery("#tweet<?php echo $n; ?>").tweet({
										username: "<?php echo $twitter_username; ?>",
										avatar_size: 48,
										count: 5,
										fetch: 20,
										filter: function(t){ return ! /^@\w+/.test(t.tweet_raw_text); },
										loading_text: "Loading tweets..."
									});
								});
								</script>
								<?php
								$n++;
							}
							
							?>
							
						</td>
					</tr>
				<?php
				}
				*/
				function convertLinks($str){
					$str = preg_replace("/(http:\/\/[^\s]*)/i", "<a href='$1' target='_blank'>$1</a>", $str);
					$str = preg_replace("/#([^\s]*)/i", "<a class='tweet_hashtag' href='https://twitter.com/search?q=%23$1&src=hash' target='_blank'>#$1</a>", $str);
					
					return $str;
				}
				
				if(trim($investment_org['twitter_username'])){
					$feed = 'http://search.twitter.com/search.json?q=from:'.trim($investment_org['twitter_username']);
					$tweets = json_decode(file_get_contents($feed));
					$t = count($tweets->results);
					if($t){
						?>
						<tr>
							<td class="description">
								<div class="description_title">Tweets</div>
								<?php
								//echo "<pre>";
								//print_r($tweets);
								//echo "</pre>";
								/*
								stdClass Object
								(
									[completed_in] => 0.019
									[max_id] => 3.02276351598E+17
									[max_id_str] => 302276351598141441
									[next_page] => ?page=2&max_id=302276351598141441&q=from%3Ae27co
									[page] => 1
									[query] => from%3Ae27co
									[refresh_url] => ?since_id=302276351598141441&q=from%3Ae27co
									[results] => Array
										(
											[0] => stdClass Object
												(
													[created_at] => Fri, 15 Feb 2013 04:41:12 +0000
													[from_user] => e27co
													[from_user_id] => 15315691
													[from_user_id_str] => 15315691
													[from_user_name] => e27
													[geo] => 
													[id] => 3.02276351598E+17
													[id_str] => 302276351598141441
													[iso_language_code] => en
													[metadata] => stdClass Object
														(
															[result_type] => recent
														)

													[profile_image_url] => http://a0.twimg.com/profile_images/2817545201/83d0f88ad573ddf1a64f0b567a109a46_normal.jpeg
													[profile_image_url_https] => https://si0.twimg.com/profile_images/2817545201/83d0f88ad573ddf1a64f0b567a109a46_normal.jpeg
													[source] => <a href="http://www.hootsuite.com">HootSuite</a>
													[text] => Creative Mixer 5 is here. The theme will be "push", exploring how #entrepreneurs are pushing the boundaries http://t.co/bH19QMon
													[to_user] => 
													[to_user_id] => 0
													[to_user_id_str] => 0
													[to_user_name] => 
												)

											[1] => stdClass Object
												(
													[created_at] => Fri, 15 Feb 2013 04:20:14 +0000
													[from_user] => e27co
													[from_user_id] => 15315691
													[from_user_id_str] => 15315691
													[from_user_name] => e27
													[geo] => 
													[id] => 3.02271073104E+17
													[id_str] => 302271073104326656
													[iso_language_code] => en
													[metadata] => stdClass Object
														(
															[result_type] => recent
														)

													[profile_image_url] => http://a0.twimg.com/profile_images/2817545201/83d0f88ad573ddf1a64f0b567a109a46_normal.jpeg
													[profile_image_url_https] => https://si0.twimg.com/profile_images/2817545201/83d0f88ad573ddf1a64f0b567a109a46_normal.jpeg
													[source] => <a href="http://www.hootsuite.com">HootSuite</a>
													[text] => What's going to be hot in #mobile #ecommerce this year? http://t.co/aZz5AF7H
													[to_user] => 
													[to_user_id] => 0
													[to_user_id_str] => 0
													[to_user_name] => 
												)

									
									
								*/
								$i = 0;
								?><div id="tweet0">
								<ul class="tweet_list">
								<li class="tweet_first tweet_even" style='height:48px'>
									<a href="http://twitter.com/<?php echo $tweets->results[$i]->from_user; ?>" class="tweet_avatar">
										<img height="48" border="0" width="48" title="<?php echo $tweets->results[$i]->from_user; ?>'s avatar" alt="<?php echo $tweets->results[$i]->from_user; ?>'s avatar" src="<?php echo $tweets->results[$i]->profile_image_url; ?>">
									</a>
									<span class="tweet_time" >
									<a href="http://twitter.com/<?php echo $tweets->results[$i]->from_user; ?>" class="tweet_avatar" style='font-size:26px; text-decoration:none'>
									@<?php echo $tweets->results[$i]->from_user; ?>
									</a>
									</span>
								</li>
								</ul>
								<ul class="tweet_list"><?php
								for($i=0; $i<7; $i++){
									if(!trim($tweets->results[$i]->text)){
										continue;
									}
									$hoursago = (time() - strtotime($tweets->results[$i]->created_at))/(60*60);
									if($hoursago<1){
										$hoursago = "less than an hour ago";
									}
									else if($hoursago<2){
										$hoursago = "about an hour ago";
									}
									else{
										$hoursago = floor($hoursago)." hours ago";
									}
									if($i%2){
										$class = 'tweet_even';
									}
									else{
										$class = 'tweet_odd';
									}
									?>
									<li class="tweet_first <?php echo $class; ?>" style='height:48px'>
									<span class="tweet_time"><a title="view tweet on twitter" href="http://twitter.com/<?php echo $tweets->results[$i]->from_user; ?>/status/<?php echo $tweets->results[$i]->id_str; ?>"><?php echo $hoursago; ?></a></span> 
									<span class="tweet_text">
									<?php
									echo convertLinks($tweets->results[$i]->text);
									?>
									</li>
									<?php
								}
								?>
								</ul>
								</div>
								
							</td>
						</tr>
					<?php
					}
				}
				?>
			</table>
		</td>
	</tr>
</table>