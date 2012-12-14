<?php
//echo "<pre>";
//print_r($person);
//echo "</pre>";
?>
<table cellpadding="0" cellspacing="0" class='p100'>
	<tr>
		<td class='company_left'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class='logo'>
						<div>
						<a href="<?php echo site_url(); ?>person/<?php echo $person['slug']; ?>" title="<?php echo sanitizeX($person['name'])?>" alt="<?php echo sanitizeX($person['name'])?>">
						<?php
						if(trim($person['profile_image'])){
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $person['profile_image'] ?>&mx=220' />
							<?php
						}
						else{
							$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $logo; ?>&mx=220' />
							<?php	
						}
						?>
						</div>
						</a>
					</td>
				</tr>
				<?php
				if($_SESSION['web_user']){
					?>
					<tr>
						<td align="center">
							<?php
							echo "<div class='edit' style='text-align:center'><a href='".site_url()."editperson/".$person['id']."/profileimage'>EDIT</div>";
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
					if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editperson/".$person['id']."/overview'>EDIT</div>"; }
					?>
					</td>
				</tr>
				<tr>
					<td class="content">
						<table cellpadding="0" cellspacing="0" class="p100">
							<?php
							if(trim($companies[0]['company_name'])){
								$value = $companies[0];
								$year = "";
								if((time()-$value['end_date_ts2'])>(1*60*60)){ //if last day is greater than yesterday
									$year = "(".date("Y", $value['end_date_ts2']).")";
								}
								?>
								<tr>
									<td class='label'>
										Company
									</td>
									<td class='value'>
										<?php echo "<a href='".site_url()."company/".$companies[0]['slug']."'>".trim($companies[0]['company_name'])."</a>"; ?>
									</td>
								</tr>
								<?php
							}
							if(trim($companies[0]['co_website'])){
								?>
								<tr>
									<td class='label'>
										Co. Website
									</td>
									<td class='value'>
										<a href="<?php echo sanitizeX(trim($companies[0]['co_website'])); ?>"><?php echo trim($companies[0]['co_website']); ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['email_address'])&&0){
								?>
								<tr>
									<td class='label'>
										Email
									</td>
									<td class='value'>
										<a href="mailto:<?php echo $person['email_address']; ?>"><?php echo $person['email_address']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['blog_url'])){
								$blog_url = preg_replace("/http:\/\//i", "", $person['blog_url']);
								$blog_url = preg_replace("/https:\/\//i", "", $person['blog_url']);
								if(
									strpos(strtolower(trim($person['blog_url'])),"http://")===false&&
									strpos(strtolower(trim($person['blog_url'])),"https://")===false
								){
									$person['blog_url'] = "http://".$person['blog_url'];
								}
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo $person['blog_url']; ?>"><?php echo $blog_url; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['twitter_username'])){
								?>
								<tr>
									<td class='label'>
										Twitter
									</td>
									<td class='value'>
										<?php
										$tws = explode(",", $person['twitter_username']);
										$twitarr = array();
										foreach($tws as $twitter_username){
											$twitter_username = trim($twitter_username);
											$twitter_username = trim($twitter_username, "@");
											$twitarr[] = '<a href="http://www.twitter.com/'.$twitter_username.'">@'.$twitter_username.'</a>';
										}
										echo implode(", ", $twitarr);
										?>
									</td>
								</tr>
								<?php
							}
							if(trim($person['facebook'])){
								if(
									strpos(strtolower(trim($person['facebook'])),"http://")===false&&
									strpos(strtolower(trim($person['facebook'])),"https://")===false
								){
									$person['facebook'] = "http://".$person['facebook'];
								}
								?>
								<tr>
									<td class='label'>
										Facebook
									</td>
									<td class='value'>
										<a href="<?php echo $person['facebook']; ?>"><?php echo $person['name']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['linkedin'])){
								if(
									strpos(strtolower(trim($person['linkedin'])),"http://")===false&&
									strpos(strtolower(trim($person['linkedin'])),"https://")===false
								){
									$person['linkedin'] = "http://".$person['linkedin'];
								}
								?>
								<tr>
									<td class='label'>
										LinkedIn
									</td>
									<td class='value'>
										<a href="<?php echo $person['linkedin']; ?>"><?php echo $person['name']; ?></a>
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
			$ct = count($companies);
			if($ct){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">CAREER
						<?php
						if($_SESSION['web_user']){ echo "<div class='edit inline right'><a href='".site_url()."editperson/".$person['id']."/career'>EDIT</div>"; }
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
										foreach($companies as $value){
											if(!in_array($value['company_id'], $inp)){
												$inp[] = $value['company_id'];
												//echo time()." - ".$value['end_date_ts2']." = ".(time() - $value['end_date_ts2'])."<br>";
												//if((time() - $value['end_date_ts2']) <= (1*60*60)||1){
													
													$year = "";
													if((time()-$value['end_date_ts2'])>(1*60*60)){ //if last day is greater than yesterday
														$year = "(".date("Y", $value['end_date_ts2']).")";
													}
													if($value['end_date_ts']==0){
														$tenure = date("M, Y", $value['start_date_ts'])." - Present";
													}
													else{
														$tenure = date("M, Y", $value['start_date_ts'])." - ".date("M, Y", $value['end_date_ts']);
													}
													echo "<tr>";
													
													if(trim($value['company_logo'])){
														echo "<td class='middle pad5'><a href='".site_url()."company/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['company_logo']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."company/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."company/".$value['slug']."'>".$value['company_name']."</a>
													<div class='role'>".$value['role']."</div>
													<div class='tenure'>".$tenure."</div>
													</td>";
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
										//if($ct>5){
										//	echo "<div class='seeall'><a href='".site_url()."startuplist/person_companies/".$person['id']."'>See All ($ct)</a></div>";
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
			
			$iot = count($investment_orgs);
			if($iot){
				?>
				<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
					<tr>
						<td class="head">INVESTMENT ORGANIZATIONS</td>
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
										foreach($investment_orgs as $value){
											if(!in_array($value['id'], $inp)){
												$inp[] = $value['id'];
												//if($value['end_date_ts2']>time()-(1*60*60)){
													$year = "";
													if((time()-$value['end_date_ts2'])>(1*60*60)){ //if last day is greater than yesterday
														$year = "(".date("Y", $value['end_date_ts2']).")";
													}
													if($value['end_date_ts']==0){
														$tenure = date("M, Y", $value['start_date_ts'])." - Present";
													}
													else{
														$tenure = date("M, Y", $value['start_date_ts'])." - ".date("M, Y", $value['end_date_ts']);
													}
													echo "<tr>";
													if(trim($value['investment_org_logo'])){
														echo "<td class='middle pad5'><a href='".site_url()."investment_org/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['investment_org_logo']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."investment_org/".$value['slug']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."investment_org/".$value['slug']."'>".$value['investment_org_name']."</a>
													<div class='role'>".$value['role']."</div>
													<div class='tenure'>".$tenure."</div>
													</td>";
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
										//if($iot>5){
										//	echo "<div class='seeall'><a href='".site_url()."startuplist/person_investment_orgs/".$person['id']."'>See All ($iot)</a></div>";
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
						echo htmlentitiesX($person['name']);
						
						if($companies[0]){
							?>
							<div class='person_role'>
							<?php echo trim($companies[0]['role']); ?>
							</div>
							<div class='person_company'>
							<?php echo trim($companies[0]['company_name']); ?>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class="description">
						<div class="description_title">Description</div>
						<div class="description_contents"><?php echo nl2br($person['description']); ?></div>
					</td>
				</tr>
				<?php
				if(trim($person['twitter_username'])){
					?>
					<tr>
						<td class="description">
							<div class="description_title">Tweets</div>
							<div class="tweets"></div>
							<?php
							$tws = explode(",", $person['twitter_username']);
							$twitarr = array();
							$n = 0;
							foreach($tws as $twitter_username){
								$twitter_username = trim($twitter_username);
								?>
								<div id='tweet<?php echo $n; ?>'></div><br />
								<script>
								jQuery(function($){
									jQuery("#tweet<?php echo $n; ?>").tweet({
										join_text: "auto",
										username: "<?php echo $twitter_username; ?>",
										avatar_size: 48,
										count: 5,
										auto_join_text_default: " we said, ",
										auto_join_text_ed: " we ",
										auto_join_text_ing: " we were ",
										auto_join_text_reply: " we replied ",
										auto_join_text_url: " we were checking out ",
										loading_text: "loading tweets..."
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
				?>
			</table>
		</td>
	</tr>
</table>