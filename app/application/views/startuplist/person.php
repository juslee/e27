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
						<a href="<?php echo site_url(); ?>person/<?php echo seoIze($person['name']); ?>/<?php echo $person['id']; ?>" title="<?php echo sanitizeX($person['name'])?>" alt="<?php echo sanitizeX($person['name'])?>">
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
			</table>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">OVERVIEW</td>
				</tr>
				<tr>
					<td class="content">
						<table cellpadding="0" cellspacing="0" class="p100">
							<?php
							if(trim($companies[0]['company_name'])){
								?>
								<tr>
									<td class='label'>
										Company
									</td>
									<td class='value'>
										<?php echo "<a href='".site_url()."company/".seoIze($companies[0]['company_name'])."/".$companies[0]['company_id']."'>".trim($companies[0]['company_name'])."</a>"; ?>
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
							if(trim($person['twitter_username'])){
								?>
								<tr>
									<td class='label'>
										Twitter
									</td>
									<td class='value'>
										<a href="http://www.twitter.com/<?php echo str_replace("@", "", $person['twitter_username']); ?>"><?php echo $person['twitter_username']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['blog_url'])){
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo $person['blog_url']; ?>"><?php echo $person['blog_url']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($person['linkedin'])){
								?>
								<tr>
									<td class='label'>
										Blog
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
						<td class="head">CAREER</td>
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
											if(!in_array($value['id'], $inp)){
												$inp[] = $value['id'];
												if($value['end_date_ts2']>time()-(1*60*60)){
													echo "<tr>";
													
													if(trim($value['company_logo'])){
														echo "<td class='middle pad5'><a href='".site_url()."company/".seoIze($value['company_name'])."/".$value['company_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['company_logo']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."company/".seoIze($value['company_name'])."/".$value['company_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."company/".seoIze($value['company_name'])."/".$value['company_id']."'>".$value['company_name']."</a><br />".$value['role']."</td>";
													echo "</tr>";
												}
												$n++;
											}
											if($n>5){
												break;
											}
										}
										
										
										?>
										</table>
										<?php
										if($ct>5){
											echo "<div class='seeall'><a href='".site_url()."startuplist/person_companies/".$person['id']."'>See All ($ct)</a></div>";
										}
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
												if($value['end_date_ts2']>time()-(1*60*60)){
													echo "<tr>";
													
													if(trim($value['investment_org_logo'])){
														echo "<td class='middle pad5'><a href='".site_url()."investment_org/".seoIze($value['investment_org_name'])."/".$value['investment_org_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['investment_org_logo']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."investment_org/".seoIze($value['investment_org_name'])."/".$value['investment_org_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."investment_org/".seoIze($value['investment_org_name'])."/".$value['investment_org_id']."'>".$value['investment_org_name']."</a><br />".$value['role']."</td>";
													echo "</tr>";
												}
												$n++;
											}
											if($n>5){
												break;
											}
										}
										
										
										?>
										</table>
										<?php
										if($iot>5){
											echo "<div class='seeall'><a href='".site_url()."startuplist/person_investment_orgs/".$person['id']."'>See All ($iot)</a></div>";
										}
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
									<td class='bold padb10 p100 right'>
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
										<td class='padb5' >
											<?php
											echo "<a href='".site_url()."company/".seoIze($milestones[$cfi]['company_name'])."/".$milestones[$cfi]['company_id']."'>"; 
											echo $milestones[$cfi]['company_name'];
											echo "</a>";
											?>
										</td>
										<td class='padb5' style='padding-left:20px;'>
											<?php
											echo $milestones[$cfi]['round'];
											?>
										</td>
										<td class='padb5 p100 right'>
											<?php echo $milestones[$cfi]['currency'].amountIze($milestones[$cfi]['amount']); ?>
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
						echo htmlentities($person['name']);
						?>
					</td>
				</tr>
				<tr>
					<td class="description">
						<div class="description_title">Description</div>
						<div class="description_contents"><?php echo nl2br($person['description']); ?></div>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>