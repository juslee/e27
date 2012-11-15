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