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
						<a href="<?php echo site_url(); ?>startuplist/company/<?php echo seoIze($company['name']); ?>/<?php echo $company['id']; ?>" title="<?php echo sanitizeX($company['name'])?>" alt="<?php echo sanitizeX($company['name'])?>">
						<?php
						if(trim($company['logo'])){
							?>
							<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $company['logo'] ?>&mx=220' />
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
							if(trim($company['website'])){
								?>
								<tr>
									<td class='label'>
										Web
									</td>
									<td class='value'>
										<a href="<?php echo $company['website']; ?>"><?php echo $company['website']; ?></a>
									</td>
								</tr>
								<?php
							}
							if(trim($company['blog_url'])){
								?>
								<tr>
									<td class='label'>
										Blog
									</td>
									<td class='value'>
										<a href="<?php echo $company['blog_url']; ?>"><?php echo $company['blog_url']; ?></a>
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
										<a href="http://www.twitter.com/<?php str_replace("@", "", $company['twitter_username']); ?>"><?php echo $company['twitter_username']; ?></a>
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
												echo "<a href='".site_url()."staruplist/company_category/".seoIze($value['category'])."/".$value['id']."'>".$value['category']."</a> ";
												if($count>=4){
													if($count<$ct){
														?><a href="<?php echo site_url(); ?>startuplist/company/<?php echo seoIze($company['name']); ?>/<?php echo $company['id']; ?>">...<?php
													}
													break;
												}
											}
											
										?>
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
										<?php echo date("M d, Y", strtotime($company['founded'])); ?>
									</td>
								</tr>
								<?php
							}
							
							?>
							
						</table>
					</td>
				</tr>
			</table>
			
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
										if(!in_array($value['id'], $inp)){
											$inp[] = $value['id'];
											if($value['end_date_ts2']>time()-(1*60*60)){
												echo "<tr>";
												
												if(trim($value['profile_image'])){
													echo "<td class='middle pad5'><a href='".site_url()."startuplist/person/".seoIze($value['name'])."/".$value['id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$value['profile_image']."&mx=38'></a></td>";
												}
												else{
													$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
													echo "<td class='middle pad5'><a href='".site_url()."startuplist/person/".seoIze($value['name'])."/".$value['id']."'><img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=38'></a></td>";
												}
												
												echo "<td class='middle pad5'><a href='".site_url()."startuplist/person/".seoIze($value['name'])."/".$value['id']."'>".$value['name']."</a><br />".$value['role']."</td>";
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
									$pt = count($people);
									if($pt>5){
										echo "<div class='seeall'><a href='".site_url()."startuplist/co_people/".$company['id']."'>See All ($pt)</a></div>";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">FUNDING</td>
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
						$cft = count($company_fundings);
						$cf_total = array();
						for($cfi=0; $cfi<$cft; $cfi++){
							$cf_total[$company_fundings[$cfi]['currency']] += $company_fundings[$cfi]['amount'];
						}
						?>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class='bold padb10'>
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
									<td class='padb5'>
										<?php echo $company_fundings[$cfi]['round']; ?>
									</td>
									<td class='padb5 p100 right'>
										<?php echo $company_fundings[$cfi]['currency'].amountIze($company_fundings[$cfi]['amount']); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2" class='padb5'>
										<?php
										$it = count($company_fundings[$cfi]['investment_orgs']);
										for($ii=0; $ii<$it; $ii++){
											echo "<div class='padb5'>";
											echo "<a href='".site_url()."startuplist/investment_org/".seoIze($company_fundings[$cfi]['investment_orgs'][$ii]['name'])."/".$company_fundings[$cfi]['people'][$ii]['id']."'>".$company_fundings[$cfi]['investment_orgs'][$ii]['name']."</a>";
											echo "</div>";
										}
										$it = count($company_fundings[$cfi]['companies']);
										for($ii=0; $ii<$it; $ii++){
											echo "<div class='padb5'>";
											echo "<a href='".site_url()."startuplist/company/".seoIze($company_fundings[$cfi]['companies'][$ii]['name'])."/".$company_fundings[$cfi]['people'][$ii]['id']."'>".$company_fundings[$cfi]['companies'][$ii]['name']."</a>";
											echo "</div>";
										}
										$it = count($company_fundings[$cfi]['people']);
										for($ii=0; $ii<$it; $ii++){
											echo "<div class='padb5'>";
											echo "<a href='".site_url()."startuplist/person/".seoIze($company_fundings[$cfi]['people'][$ii]['name'])."/".$company_fundings[$cfi]['people'][$ii]['id']."'>".$company_fundings[$cfi]['people'][$ii]['name']."</a>";
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
		</td>
		<td class='company_right'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class="company_name">
						<?php
						echo htmlentities($company['name']);
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
							<div class="productgal_title">Product Gallery</div>
							<div class="productgal_loader" style="text-align:center; padding:50px;"><img src="<?php echo site_url(); ?>media/ajax-loader.gif"><br>&nbsp;<br>Loading Gallery...</div>
							<div class="productgal_contents hidden">
							<div id="screenshots">
								<div class="slides_container" >
								<?php
									for($i=0; $i<$sst; $i++){
										$imgfile = site_url()."media/image.php?p=".$screenshots[$i]['screenshot']."&mx=520";
										//$imagesize = getimagesize($imgfile);
										//print_r($imagesize);
										?><a><img src="<?php echo $imgfile; ?>"  /></a><?php
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
				}?>
			</table>
		</td>
	</tr>
</table>