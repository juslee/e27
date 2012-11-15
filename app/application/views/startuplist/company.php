<table cellpadding="0" cellspacing="0" class='p100'>
	<tr>
		<td class='company_left'>
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
			</a>
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
			</table>
		</td>
	</tr>
</table>