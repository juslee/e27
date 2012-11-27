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
						<a href="<?php echo site_url(); ?>company/<?php echo seoIze($investment_org['name']); ?>/<?php echo $investment_org['id']; ?>" title="<?php echo sanitizeX($investment_org['name'])?>" alt="<?php echo sanitizeX($investment_org['name'])?>">
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
								?>
								<tr>
									<td class='label'>
										Web
									</td>
									<td class='value'>
										<a href="<?php echo $investment_org['website']; ?>"><?php echo $investment_org['website']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($investment_org['blog_url'])){
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo $investment_org['blog_url']; ?>"><?php echo $investment_org['blog_url']; ?></a>
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
							if(count($investment_org['categories'])){
								?>
								<tr>
									<td class='label'>
										Category
									</td>
									<td class='value'>
										<?php
											$ct = count($investment_org['categories']);
											$count = 0;
											foreach($investment_org['categories'] as $value){
												$count++;
												echo "<a href='".site_url()."category/".seoIze($value['category'])."/".$value['id']."'>".$value['category']."</a> ";
												if($count>=4){
													if($count<$ct){
														?><a href="<?php echo site_url(); ?>company/<?php echo seoIze($investment_org['name']); ?>/<?php echo $investment_org['id']; ?>">...<?php
													}
													break;
												}
											}
											
										?>
									</td>
								</tr>
								<?php
							}
							if($investment_org['number_of_employees']>0){
								?>
								<tr>
									<td class='label'>
										Employees
									</td>
									<td class='value'>
										<?php echo $investment_org['number_of_employees']; ?>
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
										<?php echo date("M d, Y", strtotime($investment_org['founded'])); ?>
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
														echo "<td class='middle pad5'><a href='".site_url()."person/".seoIze($value['name'])."/".$value['person_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['profile_image']."&mx=38'></a></td>";
													}
													else{
														$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
														echo "<td class='middle pad5'><a href='".site_url()."person/".seoIze($value['name'])."/".$value['person_id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
													}
													
													echo "<td class='middle pad5'><a href='".site_url()."person/".seoIze($value['name'])."/".$value['person_id']."'>".$value['name']."</a> ".$year."<br />".$value['role']." </td>";
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
						echo htmlentities($investment_org['name']);
						?>
					</td>
				</tr>
				<tr>
					<td class="description">
						<div class="description_title">Description</div>
						<div class="description_contents"><?php echo nl2br($investment_org['description']); ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>