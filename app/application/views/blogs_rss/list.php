<?php
$this->load->view('blogs_rss/submenus');
$method = $this->router->method;
?>
<center>
<div class='pad10' ><form action="<?php echo site_url(); ?>blogs_rss/<?php echo $method; ?>/" class='inline' >Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' /><input type='button' class='button normal' value='search' onclick='searchCompany()'><input type='button' class='button normal' onclick='self.location="<?php echo site_url(); ?>blogs_rss/<?php echo $method; ?>/?search="+jQuery("#search").val()+"&shuffle=1"' value='Shuffle'></form><div class='hint'>Name, Description, Tags</div>
</div>
</center>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th style="width:15%">Name</th>
		<th>Feeds</th>
	</tr>
	<?php
	$t = count($list);
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentities($list[$i]['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<td><a href="<?php echo site_url().$list[$i]['list_type']; ?>/edit/<?php echo $list[$i]['id']?>" ><?php echo htmlentities($list[$i]['name']); ?></a></td>
			<td>
			<?php 
				if(is_array($list[$i]['feed'])){
					$this->load->view('blogs_rss/feeds', $list[$i]['feed']);
				}
			?>
			</td>
		</tr>
		<?php
	}
	if($pages>0){
		?>
		<tr>
			<td colspan="8" class='center font12' >
				There is a total of <?php echo $cnt; ?> <?php if($cnt>1) { echo "records"; } else{ echo "record"; }?> in the database. 
				Go to Page:
				<?php
				if($search){
					?>
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&start="+this.value'>
					<?php

				}
				else{
					?>
					<select onchange='self.location="?start="+this.value'>
					<?php
				}
				for($i=0; $i<$pages; $i++){
					if(($i*$limit)==$start){
						?><option value="<?php echo $i*$limit?>" selected="selected"><?php echo $i+1; ?></option><?php
					}
					else{
						?><option value="<?php echo $i*$limit?>"><?php echo $i+1; ?></option><?php
					}
				}
				?>
				</select>
			</td>
		</tr>
		<?php
	}
	?>
</table>
</div>
