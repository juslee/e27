<?php
//echo "<pre>";
//print_r($person);
//echo "</pre>";
?>
<table cellpadding="0" cellspacing="0" class='p100'>
	<tr>
		<td class='company_left'>
			<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
				<tr>
					<td class="head">FILTERS</td>
				</tr>
				<tr>
					<td class="content">
						<div class='pad5'><a <?php if($_GET['filter']=='companies'){ echo "class='bold'"; }?> href="?q=<?php echo rawurlencode($search)?>&filter=companies">Companies</a></div>
						<div class='pad5'><a <?php if($_GET['filter']=='people'){ echo "class='bold'"; }?> href="?q=<?php echo rawurlencode($search)?>&filter=people">People</a></div>
						<div class='pad5'><a <?php if($_GET['filter']=='investment_orgs'){ echo "class='bold'"; }?> href="?q=<?php echo rawurlencode($search)?>&filter=investment_orgs">Investment Organizations</a></div>
						<div class='pad5'><a <?php if($_GET['filter']=='newlyadded'){ echo "class='bold'"; }?> href="?q=<?php echo rawurlencode($search)?>&filter=newlyadded">Recently Added</a></div>
						<div class='pad5'><a <?php if($_GET['filter']=='newlyupdated'){ echo "class='bold'"; }?> href="?q=<?php echo rawurlencode($search)?>&filter=newlyupdated">Recently Updated</a></div>
						
					</td>
				</tr>
			</table>
		</td>
		<td class='company_right'>
			<table cellpadding="0" cellspacing="0" class="p100">
				<tr>
					<td class="company_name">
						Search Results
						<?php
						if($results['totalcnt']){
							?>
							<div class="search_results">
							<?php
							echo "Diplaying ".$results['totalcnt']." of ".$results['totalcnt']." for '".$search."', sorted by relevance.";
							?>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				
				
						
				<tr>
					<td class="description" style="border:0px;">
						<?php
						if($results['totalcnt']){
							$cresults = $results['results'];
							$t = count($cresults);
							for($i=0; $i<$t; $i++){
								$value = $cresults[$i];
								?>
								<table class='seachblock'>
								<tr>
									<td>
										<?php
										//echo $cresults[$i]['name_score'];
										?>
										<div class='logo'>
										<?php
										if($cresults[$i]['table']=="companies"){
											$link = "company";
											$logokey = "logo";
										}
										else if($cresults[$i]['table']=="people"){
											$link = "person";
											$logokey = "profile_image";
										}
										else if($cresults[$i]['table']=="investment_orgs"){
											$link = "investment_org";
											$logokey = "logo";
										}
										if(trim($cresults[$i][$logokey])){
											echo "<a href='".site_url().$link."/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$cresults[$i][$logokey]."&mx=60' />";
											echo "</a>";
										}
										else{
											$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
											echo "<a href='".site_url().$link."/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=60' />";
											echo "</a>";
										}
										?>
										</div>
									</td>
									<td>
										<div class='name'>
										<?php
										echo "<a href='".site_url().$link."/".$cresults[$i]['slug']."' >";
										echo $cresults[$i]['name'];
										echo "</a>";
										?>
										</div>
										<div class='type'>
										<?php
										
										if($cresults[$i]['table']=="companies"){
											echo "Company";
										}
										else if($cresults[$i]['table']=="people"){
											echo "Person";
										}
										else if($cresults[$i]['table']=="investment_orgs"){
											echo "Investment Organization";
										}
										
										?>
										</div>
										<div class='description'>
										<?php
										echo word_limit(trim($cresults[$i]['description']), 50);
										?>
										</div>
									</td>
								</tr>
								</table>
								<?php
							}
							/*
							$cresults = $results['companies']['results'];
							$t = count($cresults);
							for($i=0; $i<$t; $i++){
								$value = $cresults[$i];
								?>
								<table class='seachblock'>
								<tr>
									<td>
										<div class='logo'>
										<?php
										if(trim($cresults[$i]['logo'])){
											echo "<a href='".site_url()."company/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$cresults[$i]['logo']."&mx=60' />";
											echo "</a>";
										}
										else{
											$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
											echo "<a href='".site_url()."company/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=60' />";
											echo "</a>";
										}
										?>
										</div>
									</td>
									<td>
										<div class='name'>
										<?php
										echo "<a href='".site_url()."company/".$cresults[$i]['slug']."' >";
										echo $cresults[$i]['name'];
										echo "</a>";
										?>
										</div>
										<div class='type'>
										Company
										</div>
										<div class='description'>
										<?php
										echo word_limit(trim($cresults[$i]['description']), 50);
										?>
										</div>
									</td>
								</tr>
								</table>
								<?php
							}
							
							
							$cresults = $results['people']['results'];
							$t = count($cresults);
							for($i=0; $i<$t; $i++){
								$value = $cresults[$i];
								?>
								<table class='seachblock'>
								<tr>
									<td>
										<div class='logo'>
										<?php
										if(trim($cresults[$i]['profile_image'])){
											echo "<a href='".site_url()."person/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$cresults[$i]['profile_image']."&mx=60' />";
											echo "</a>";
										}
										else{
											$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
											echo "<a href='".site_url()."person/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=60' />";
											echo "</a>";
										}
										?>
										</div>
									</td>
									<td>
										<div class='name'>
										<?php
										echo "<a href='".site_url()."person/".$cresults[$i]['slug']."' >";
										echo $cresults[$i]['name'];
										echo "</a>";
										?>
										</div>
										<div class='type'>
										Person
										</div>
										<div class='description'>
										<?php
										echo word_limit(trim($cresults[$i]['description']), 50);
										?>
										</div>
									</td>
								</tr>
								</table>
								<?php
							}
							
							
							$cresults = $results['investment_orgs']['results'];
							$t = count($cresults);
							for($i=0; $i<$t; $i++){
								$value = $cresults[$i];
								?>
								<table class='seachblock'>
								<tr>
									<td>
										<div class='logo'>
										<?php
										if(trim($cresults[$i]['logo'])){
											echo "<a href='".site_url()."investment_org/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$cresults[$i]['logo']."&mx=60' />";
											echo "</a>";
										}
										else{
											$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
											echo "<a href='".site_url()."investment_org/".$cresults[$i]['slug']."' >";
											echo "<img class='rounded' src='".site_url()."media/image.php?p=".$logo."&mx=60' />";
											echo "</a>";
										}
										?>
										</div>
									</td>
									<td>
										<div class='name'>
										<?php
										echo "<a href='".site_url()."investment_org/".$cresults[$i]['slug']."' >";
										echo $cresults[$i]['name'];
										echo "</a>";
										?>
										</div>
										<div class='type'>
										Investment Organization
										</div>
										<div class='description'>
										<?php
										echo word_limit(trim($cresults[$i]['description']), 50);
										?>
										</div>
									</td>
								</tr>
								</table>
								<?php
							}
							*/
							/*
							?>
							<div class="center">
								<img src="<?php echo site_url(); ?>media/startuplist/load_more.png" onclick="loadMore()" class="pointer" id="loadmorebutton">
								<div id="loadmoreloader" style="display:none"><img src="<?php echo site_url(); ?>media/ajax-loader.gif" /></div>
							</div>
							<?php
							*/
						}
						else{
							echo "No Results";
						}
						?>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>