<?php
@session_start();
?>
<table cellpadding="0" cellspacing="0" class='p100'>
	<tr>
		<td class='company_left'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class='logo'>
						<div>
						<a href="<?php echo site_url(); ?>company/<?php echo $company['slug']; ?>" title="<?php echo sanitizeX($company['name'])?>" alt="<?php echo sanitizeX($company['name'])?>">
						<?php
						if(trim($company['logo'])){
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $company['logo'] ?>&mx=220&square=1' />
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
						<?php
						
						?>
						</div>
						
					</td>
				</tr>
				<?php
				if($_SESSION['web_user']){
					?>
					<tr>
						<td align="center">
							<?php
							echo "<div class='edit' style='text-align:center'><a href='".site_url()."editcompany/".$company['id']."/logo'>EDIT</div>";
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">OVERVIEW 
					<?php
					if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editcompany/".$company['id']."/overview'>EDIT</div>"; }
					?>
					</td>
				</tr>
				<tr>
					<td class="content">
						<table cellpadding="0" cellspacing="0" class="p100">
							<?php
							if(trim($company['country'])){
								?>
								<tr>
									<td class='label'>
										Country
									</td>
									<td class='value f16'>
										<div class='flag <?php echo strtolower($company['countrycode']); ?>' ></div>
										<?php
										echo "<a href='".site_url()."country/".rawurlencode($company['country'])."'>".trim($company['country'])."</a>";
										?>
									</td>
								</tr>
								<?php
							}
							if(trim($company['website'])){
								$website = preg_replace("/http:\/\//i", "", $company['website']);
								$website = preg_replace("/https:\/\//i", "", $company['website']);
								if(
									strpos(strtolower(trim($company['website'])),"http://")===false&&
									strpos(strtolower(trim($company['website'])),"https://")===false
								){
									$company['website'] = "http://".$company['website'];
								}
								?>
								<tr>
									<td class='label'>
										Web
									</td>
									<td class='value'>
										<a href="<?php echo outlink($company['website']); ?>"><?php echo $website; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($company['blog_url'])){
								$blog_url = preg_replace("/http:\/\//i", "", $company['blog_url']);
								$blog_url = preg_replace("/https:\/\//i", "", $company['blog_url']);
								if(
									strpos(strtolower(trim($company['blog_url'])),"http://")===false&&
									strpos(strtolower(trim($company['blog_url'])),"https://")===false
								){
									$company['blog_url'] = "http://".$company['blog_url'];
								}
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo outlink($company['blog_url']); ?>"><?php echo $blog_url; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($company['twitter_username'])){
								?>
								<tr>
									<td class='label'>
										Twitter
									</td>
									<td class='value'>
										<?php
										$tws = explode(",", $company['twitter_username']);
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
							if(trim($company['facebook'])){
								if(
									strpos(strtolower(trim($company['facebook'])),"http://")===false&&
									strpos(strtolower(trim($company['facebook'])),"https://")===false
								){
									$company['facebook'] = "http://".$company['facebook'];
								}
								?>
								<tr>
									<td class='label'>
										Facebook
									</td>
									<td class='value'>
										<a href="<?php echo outlink($company['facebook']); ?>"><?php echo $company['name']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($company['linkedin'])){
								if(
									strpos(strtolower(trim($company['linkedin'])),"http://")===false&&
									strpos(strtolower(trim($company['linkedin'])),"https://")===false
								){
									$company['linkedin'] = "http://".$company['linkedin'];
								}
								?>
								<tr>
									<td class='label'>
										LinkedIn
									</td>
									<td class='value'>
										<a href="<?php echo outlink($company['linkedin']); ?>"><?php echo $company['name']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(count($company['categories'])){
								?>
								<tr>
									<td class='label'>
										Category
									</td>
									<td class='value'>
										<?php
											$ct = count($company['categories']);
											$count = 0;
											foreach($company['categories'] as $value){
												$count++;
												echo "<a href='".site_url()."category/".seoIze($value['category'])."'>".$value['category']."</a> ";
												if($count>=4&&0){
													if($count<$ct){
														?><a href="<?php echo site_url(); ?>company/<?php echo $company['slug']; ?>">...<?php
													}
													break;
												}
												
											}
											
										?>
									</td>
								</tr>
								<?php
							}
							if($company['number_of_employees']>0&&0){
								?>
								<tr>
									<td class='label'>
										Employees
									</td>
									<td class='value'>
										<?php echo $company['number_of_employees']; ?>
									</td>
								</tr>
								<?php
							}
							if(trim($company['founded'])){
								?>
								<tr>
									<td class='label'>
										Founded
									</td>
									<td class='value'>
										<?php 
										if(strlen($company['founded'])==4 && is_numeric($company['founded'])){
											echo $company['founded'];
										}
										else{
											echo date("Y", strtotime($company['founded']));
										}
										
										
										?>
									</td>
								</tr>
								<?php
							}
							if($company['status']=="Closed"){
								?>
								<tr>
									<td class='label'>
										Status
									</td>
									<td class='value'>
										<?php echo "<a style='color:red'>Closed</a>"; ?>
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
						<td class="head">PEOPLE
						<?php
						if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editcompany/".$company['id']."/people'>EDIT</div>"; }
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
												//if((time()-$value['end_date_ts2'])<=(1*60*60)){ //if person is still associated with company
													$year = "";
													if((time()-$value['end_date_ts2'])>(1*60*60)){ //if last day is greater than yesterday
														$year = "(".date("Y", $value['end_date_ts2']).")";
													}
													echo "<tr>";
													
													if(trim($value['profile_image'])){
														echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['profile_image']."&mx=38&square=1'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38&square=1'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."person/".$value['slug']."'>".$value['name']."</a> ".$year."<br />".$value['role']."</td>";
													echo "</tr>";
												//}
												$n++;
											}
											//if($n>5){
											//	break;
											//}
										}
										
										
										?>
										</table>
										<?php
										//$pt = count($people);
										//if($pt>5){
										//	echo "<div class='seeall'><a href='".site_url()."startuplist/co_people/".$company['id']."'>See All ($pt)</a></div>";
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
			$cft = count($company_fundings);
			
			if($cft){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">FUNDING
						<?php
						if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editcompany/".$company['id']."/funding'>EDIT</div>"; }
						?>
						</td>
					</tr>
					<tr>
						<td class="content">
							<?php
							//echo "<pre>";
							//print_r($company_fundings);
							//echo "</pre>";
							/*
							Array
							(
								[id] => 168
								[round] => Seed
								[company_id] => 13
								[currency] => SGD
								[amount] => 25000.0000
								[date] => 01/01/2012
								[date_ts] => 1325347200
								[companies] => Array
									(
									)
					
								[people] => Array
									(
										[0] => Array
											(
												[name] => Nic Lim
												[id] => 16
											)
					
									)
					
								[investment_orgs] => Array
									(
									)
					
							)
							*/
							
							$cf_total = array();
							for($cfi=0; $cfi<$cft; $cfi++){
								if($company_fundings[$cfi]['amount_public']=="1"){
									$cf_total[$company_fundings[$cfi]['currency']] += $company_fundings[$cfi]['amount'];
								}
								else{
									$cf_total[$company_fundings[$cfi]['currency']] += 0;
								}
							}
							$thereisatotal = false;
							foreach($cf_total as $key=>$value){
								if($value<=0){
									continue;
								}
								$thereisatotal = true;
								break;
							}
							?>
							<table cellpadding="0" cellspacing="0" class="p100">
								<?php
								if($thereisatotal){
									?>
									<tr>
										<td class='bold padb10'>
											Total
										</td>
										<td class='bold padb10 right'>
											<?php
											//echo "<pre>";
											//print_r($cf_total);
											//echo "</pre>";
											foreach($cf_total as $key=>$value){
												if($value<=0){
													continue;
												}
												echo "<div>".$key.amountIze($value)."</div>";
											}
											?>
										</td>
									</tr>
									<?php
								}
								for($cfi=0; $cfi<$cft; $cfi++){
									?>
									<tr>
										<td class='padb5'>
											<?php echo $company_fundings[$cfi]['round']; ?>
										</td>
										<td class='padb5 right'>
											<?php
											if($company_fundings[$cfi]['amount_public']=="1"){
												echo $company_fundings[$cfi]['currency'].amountIze($company_fundings[$cfi]['amount']);
											}
											else{
												echo "Undisclosed";
											}	
											?>
										
										</td>
									</tr>
									<tr>
										<td colspan="2" class='padb5'>
											<?php
											$it = count($company_fundings[$cfi]['investment_orgs']);
											for($ii=0; $ii<$it; $ii++){
												echo "<div class='padb5'>";
												if($company_fundings[$cfi]['investment_orgs'][$ii]['slug']){
													echo "<a href='".site_url()."investment_org/".$company_fundings[$cfi]['investment_orgs'][$ii]['slug']."'>".$company_fundings[$cfi]['investment_orgs'][$ii]['name']."</a>";
												}
												else{
													echo $company_fundings[$cfi]['investment_orgs'][$ii]['name'];	
												}
												echo "</div>";
											}
											$it = count($company_fundings[$cfi]['companies']);
											for($ii=0; $ii<$it; $ii++){
												echo "<div class='padb5'>";
												if($company_fundings[$cfi]['companies'][$ii]['slug']){
													echo "<a href='".site_url()."company/".$company_fundings[$cfi]['companies'][$ii]['slug']."'>".$company_fundings[$cfi]['companies'][$ii]['name']."</a>";
												}
												else{
													echo $company_fundings[$cfi]['companies'][$ii]['name'];
												}
												echo "</div>";
											}
											$it = count($company_fundings[$cfi]['people']);
											for($ii=0; $ii<$it; $ii++){
												echo "<div class='padb5'>";
												if($company_fundings[$cfi]['people'][$ii]['slug']){
													echo "<a href='".site_url()."person/".$company_fundings[$cfi]['people'][$ii]['slug']."'>".$company_fundings[$cfi]['people'][$ii]['name']."</a>";
												}
												else{
													echo $company_fundings[$cfi]['people'][$ii]['name'];
												}
												echo "</div>";
											}
											
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
			//print_r($milestones);
			$cft = count($milestones);
			if($cft){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">INVESTMENTS
						<?php
						if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editcompany/".$company['id']."/investments'>EDIT</div>"; }
						?>
						</td>
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
						echo htmlentitiesX($company['name']);
						
						
						?>
						<?php
						if($_SESSION['web_user']||1){ echo "<div class='edit inline right'><a href='".site_url()."editcompany/".$company['id']."/about'>EDIT</div>"; }
						?>
					</td>
				</tr>
				<tr>
					<td class="description">
						<div class="description_title">Description</div>
						<div class="description_contents"><?php echo nl2br($company['description']); ?></div>
					</td>
				</tr>
				<?php
				
				$sst = count($screenshots);
				if($sst){
					?>
					<tr>
						<td class="productgal">
							<div class="productgal_title">Gallery</div>
							<div class="productgal_loader hidden" style="text-align:center; padding:50px;"><img src="<?php echo site_url(); ?>media/ajax-loader.gif"><br>&nbsp;<br>Loading Gallery...</div>
							<div class="productgal_contents">
							<div id="screenshots">
								<div class="slides_container" >
								<?php
									for($i=0; $i<$sst; $i++){
										$imgfile = site_url()."media/image.php?p=".$screenshots[$i]['screenshot']."&mx=520";
										$imgfilebig = site_url()."media/image.php?p=".$screenshots[$i]['screenshot']."&mx=0";
										//$imagesize = getimagesize($imgfile);
										//print_r($imagesize);
										?>
										<a href='<?php echo $imgfilebig; ?>' target='_blank'>
										<img style='border:0px' src="<?php echo $imgfile; ?>" alt="<?php echo htmlentitiesX($screenshots[$i]['title']); ?>" title="<?php echo htmlentitiesX($screenshots[$i]['title']); ?>"  />
										<div class='title'><?php echo htmlentitiesX($screenshots[$i]['title']); ?></div>
										</a>
										<?php
									}
								/*
								?>
								<a><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAM0AAAD
	 NCAMAAAAsYgRbAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5c
	 cllPAAAABJQTFRF3NSmzMewPxIG//ncJEJsldTou1jHgAAAARBJREFUeNrs2EEK
	 gCAQBVDLuv+V20dENbMY831wKz4Y/VHb/5RGQ0NDQ0NDQ0NDQ0NDQ0NDQ
	 0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0PzMWtyaGhoaGhoaGhoaGhoaGhoxtb0QGho
	 aGhoaGhoaGhoaGhoaMbRLEvv50VTQ9OTQ5OpyZ01GpM2g0bfmDQaL7S+ofFC6x
	 v3ZpxJiywakzbvd9r3RWPS9I2+MWk0+kbf0Hih9Y17U0nTHibrDDQ0NDQ0NDQ0
	 NDQ0NDQ0NTXbRSL/AK72o6GhoaGhoRlL8951vwsNDQ0NDQ1NDc0WyHtDTEhD
	 Q0NDQ0NTS5MdGhoaGhoaGhoaGhoaGhoaGhoaGhoaGposzSHAAErMwwQ2HwRQ
	 AAAAAElFTkSuQmCC" alt="beastie.png" /></a>
								<?php
								*/
								?>
								</div>
							</div> 
		
							<?php 
							//echo "<pre>";
							//print_r($screenshots);
							
							?></div>
						</td>
					</tr>
					<?php
				}
				
				function convertLinks($str){
					$str = preg_replace("/(http:\/\/[^\s]*)/i", "<a href='$1' target='_blank'>$1</a>", $str);
					$str = preg_replace("/#([^\s]*)/i", "<a class='tweet_hashtag' href='https://twitter.com/search?q=%23$1&src=hash' target='_blank'>#$1</a>", $str);
					
					return $str;
				}
				
				if(trim($company['twitter_username'])){
					$feed = 'http://search.twitter.com/search.json?q=from:'.trim($company['twitter_username']);
					$feed = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=".trim($company['twitter_username'])."&include_rts=true";
					$tweets = new stdClass();
					$tweets->results = json_decode(file_get_contents($feed));
					
					//echo "<pre>";
					//print_r($tweets);
					//echo "</pre>";
					$t = count($tweets->results);
					if($t){
						?>
						<tr>
							<td class="description">
								<div class="description_title">Tweets</div>
								<?php
								
								/*
								Array
								(
									[0] => stdClass Object
										(
											[created_at] => Tue Feb 19 10:03:45 +0000 2013
											[id] => 3.03807073442E+17
											[id_str] => 303807073441955840
											[text] => RT @TechCrunch: Thai Mobile Shopping App ShopSpot Adds Brands, Gets $630,000 http://t.co/q6FO2Y54 by @vickiho
											[source] => Twitter for iPhone
											[truncated] => 
											[in_reply_to_status_id] => 
											[in_reply_to_status_id_str] => 
											[in_reply_to_user_id] => 
											[in_reply_to_user_id_str] => 
											[in_reply_to_screen_name] => 
											[user] => stdClass Object
												(
													[id] => 485860171
													[id_str] => 485860171
													[name] => ShopSpot
													[screen_name] => ShopSpotApp
													[location] => Singapore
													[url] => http://www.shopspotapp.com
													[description] => Discover all the local shops you love in one place. Download now on the App Store.
													[protected] => 
													[followers_count] => 161
													[friends_count] => 114
													[listed_count] => 5
													[created_at] => Tue Feb 07 17:15:26 +0000 2012
													[favourites_count] => 113
													[utc_offset] => 28800
													[time_zone] => Singapore
													[geo_enabled] => 1
													[verified] => 
													[statuses_count] => 275
													[lang] => en
													[contributors_enabled] => 
													[is_translator] => 
													[profile_background_color] => 8B542B
													[profile_background_image_url] => http://a0.twimg.com/images/themes/theme8/bg.gif
													[profile_background_image_url_https] => https://si0.twimg.com/images/themes/theme8/bg.gif
													[profile_background_tile] => 
													[profile_image_url] => http://a0.twimg.com/profile_images/2047788510/512x512_normal.png
													[profile_image_url_https] => https://si0.twimg.com/profile_images/2047788510/512x512_normal.png
													[profile_link_color] => 9D582E
													[profile_sidebar_border_color] => D9B17E
													[profile_sidebar_fill_color] => EADEAA
													[profile_text_color] => 333333
													[profile_use_background_image] => 1
													[default_profile] => 
													[default_profile_image] => 
													[following] => 
													[follow_request_sent] => 
													[notifications] => 
												)

											[geo] => 
											[coordinates] => 
											[place] => 
											[contributors] => 
											[retweeted_status] => stdClass Object
												(
													[created_at] => Tue Feb 19 09:08:08 +0000 2013
													[id] => 3.03793075892E+17
													[id_str] => 303793075891867649
													[text] => Thai Mobile Shopping App ShopSpot Adds Brands, Gets $630,000 http://t.co/q6FO2Y54 by @vickiho
													[source] => WordPress.com VIP
													[truncated] => 
													[in_reply_to_status_id] => 
													[in_reply_to_status_id_str] => 
													[in_reply_to_user_id] => 
													[in_reply_to_user_id_str] => 
													[in_reply_to_screen_name] => 
													[user] => stdClass Object
														(
															[id] => 816653
															[id_str] => 816653
															[name] => TechCrunch
															[screen_name] => TechCrunch
															[location] => Silicon Valley
															[url] => http://techcrunch.com
															[description] => Breaking Technology News And Opinions From TechCrunch
															[protected] => 
															[followers_count] => 2605895
															[friends_count] => 823
															[listed_count] => 73264
															[created_at] => Wed Mar 07 01:27:09 +0000 2007
															[favourites_count] => 36
															[utc_offset] => -28800
															[time_zone] => Pacific Time (US & Canada)
															[geo_enabled] => 1
															[verified] => 1
															[statuses_count] => 54050
															[lang] => en
															[contributors_enabled] => 
															[is_translator] => 
															[profile_background_color] => 149500
															[profile_background_image_url] => http://a0.twimg.com/profile_background_images/710259120/2c873e1157470b4c0d07478ebe412e40.png
															[profile_background_image_url_https] => https://si0.twimg.com/profile_background_images/710259120/2c873e1157470b4c0d07478ebe412e40.png
															[profile_background_tile] => 
															[profile_image_url] => http://a0.twimg.com/profile_images/2176846885/-5-1_normal.jpeg
															[profile_image_url_https] => https://si0.twimg.com/profile_images/2176846885/-5-1_normal.jpeg
															[profile_link_color] => 0888C4
															[profile_sidebar_border_color] => FFFFFF
															[profile_sidebar_fill_color] => DDFFCC
															[profile_text_color] => 222222
															[profile_use_background_image] => 1
															[default_profile] => 
															[default_profile_image] => 
															[following] => 
															[follow_request_sent] => 
															[notifications] => 
														)

													[geo] => 
													[coordinates] => 
													[place] => 
													[contributors] => 
													[retweet_count] => 32
													[favorited] => 
													[retweeted] => 
													[possibly_sensitive] => 
												)

											[retweet_count] => 32
											[favorited] => 
											[retweeted] => 
											[possibly_sensitive] => 
										)
								*/
								$i = 0;
								?><div id="tweet0">
								<ul class="tweet_list">
								<li class="tweet_first tweet_even" style='height:48px'>
									<a href="http://twitter.com/<?php echo $tweets->results[$i]->user->screen_name; ?>" class="tweet_avatar">
										<img height="48" border="0" width="48" title="<?php echo $tweets->results[$i]->user->screen_name; ?>'s avatar" alt="<?php echo $tweets->results[$i]->user->screen_name; ?>'s avatar" src="<?php echo $tweets->results[$i]->user->profile_image_url; ?>">
									</a>
									<span class="tweet_time" >
									<a href="http://twitter.com/<?php echo $tweets->results[$i]->user->screen_name; ?>" class="tweet_avatar" style='font-size:26px; text-decoration:none'>
									@<?php echo $tweets->results[$i]->user->screen_name; ?>
									</a>
									</span>
								</li>
								</ul>
								<ul class="tweet_list"><?php
								for($i=0; $i<7; $i++){
									if(!trim($tweets->results[$i]->text)){
										continue;
									}
									/*
									echo "<div style='padding:20px 0px 0px 0px;'>";
									echo "<div>";
									echo convertLinks($tweets->results[$i]->text);
									echo "</div>";
									echo "<div style='padding-top:4px;'>";
									*/
									$hoursago = (time() - strtotime($tweets->results[$i]->created_at))/(60*60);
									if($hoursago<1){
										$hoursago = "Less than an hour ago";
									}
									else if($hoursago<2){
										$hoursago = "About an hour ago";
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
									<span class="tweet_time"><a title="view tweet on twitter" href="http://twitter.com/<?php echo $tweets->results[$i]->user->screen_name; ?>/status/<?php echo $tweets->results[$i]->id_str; ?>"><?php echo $hoursago; ?></a></span> 
									<span class="tweet_text">
									<?php
									echo convertLinks($tweets->results[$i]->text);
									?>
									</li>
									<?php
									
									/*
									echo "<i>".$hoursago." by </i><a href='http://twitter.com/".$tweets->results[$i]->from_user."' target='_blank'>".$tweets->results[$i]->from_user."</a>";
									echo "</div>";
									echo "</div>";
									*/
								}
								/*
								<div class="tweets"></div>
								<?php
								$tws = explode(",", $company['twitter_username']);
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
										});
										
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
								*/
								
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