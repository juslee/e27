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
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $investment_org['logo'] ?>&mx=220' />
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
			</table>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">OVERVIEW</td>
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
										<a href="<?php echo $investment_org['website']; ?>"><?php echo $website; ?></a>
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
										<a href="<?php echo $investment_org['blog_url']; ?>"><?php echo $blog_url; ?></a>
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
										<a href="http://www.twitter.com/<?php echo str_replace("@", "", $investment_org['twitter_username']); ?>"><?php echo $investment_org['twitter_username']; ?></a>
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
										<a href="<?php echo $investment_org['facebook']; ?>"><?php echo $investment_org['name']; ?></a>
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
										<a href="<?php echo $investment_org['linkedin']; ?>"><?php echo $investment_org['name']; ?></a>
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
						<td class="head">PEOPLE</td>
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