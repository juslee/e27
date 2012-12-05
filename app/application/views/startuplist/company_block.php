<table cellpadding="0" cellspacing="0" class='contentblock'>
	<tr>
		<td class="head"><a href="<?php echo site_url(); ?>company/<?php echo $company['slug']; ?>"><?php echo htmlentitiesX($company['name']) ?></a></td>
	</tr>
	<tr>
		<td class="logo">
		<a href="<?php echo site_url(); ?>company/<?php echo $company['slug']; ?>" title="<?php echo sanitizeX($company['name'])?>" alt="<?php echo sanitizeX($company['name'])?>">
		<?php
		if(trim($company['logo'])){
			?>
			<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $company['logo'] ?>&mx=160' />
			<?php
		}
		else{
			?>
			<img src='<?php echo site_url(); ?>media/startuplist/noimage.jpg' />
			<?php	
		}
		?>
		</a>
		</td>
	</tr>
	<tr>
		<td class="content">
			<table cellpadding="0" cellspacing="0">
				<?php
				if(strtotime($company['founded'])>0){
					?>
					<tr>
						<td class="label">
						Founded
						</td>
						<td class="value">
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
				?>
				<?php
				if(count($company['funding'])){
					?>
					<tr>
						<td class="label">
						Funding
						</td>
						<td class="value">
						<?php
							$amount = 0;
							foreach($company['funding'] as $f){
								$amount += $f['amount'];
							}
							$amount = amountIze($amount);
							
							echo $company['funding'][0]['currency'].$amount;
						?>
						</td>
					</tr>
					<?php
				}
				if(count($company['categories'])){
					?>
					<tr>
						<td class="label">
						Categories
						</td>
						<td class="value small">
						<?php
							$ct = count($company['categories']);
							$count = 0;
							foreach($company['categories'] as $value){
								$count++;
								echo "<a href='".site_url()."category/".seoIze($value['category'])."/".$value['id']."'>".$value['category']."</a> ";
								if($count>=4){
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
				if(trim($company['country'])){
					?>
					<tr>
						<td class="label">
						Country
						</td>
						<td class="value small">
						<?php
							echo "<a href='".site_url()."country/".rawurlencode($company['country'])."'>".trim($company['country'])."</a>";
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