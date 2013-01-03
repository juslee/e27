<div class='pad10' >
<center>
<form action="<?php echo site_url(); ?>webusers" class='inline' >
	Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' />
	<input type='submit' class='button normal' value='Search' style='padding:2px'>
</form>
</center>
</div>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th>E-mail</th>
		<th>Name</th>
		<th>Type</th>
		<th>Date Added</th>
		<th></th>
		
	</tr>
	<?php
	$t = count($web_users);
	for($i=0; $i<$t; $i++){
		$user = getWebUser($web_users[$i]);
		if(!trim($user['name'])){
			continue;
		}
		?>
		<tr id="tr<?php echo htmlentitiesX($user['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<td>
				<?php
				if(trim($user['email'])){
					echo "<a href='".site_url()."webusers/editwebuser/".$user['id']."'>".$user['email']."</a>";
					
				}
				else{
					echo "<a href='".site_url()."webusers/editwebuser/".$user['id']."'>No email</a>";
				}
				?>
			</td>
			<td>
				<?php
				echo $user['name'];
				?>
			</td>
			<td>
				<?php
				if(trim($user['in_data'])){
					echo "LinkedIn";
				}
				else if(trim($user['fb_data'])){
					echo "Facebook";
				}
				else{
					echo "Account";
				}
				
				?>
			</td>
			<td>
				<?php
				echo date("M d, Y", strtotime($web_users[$i]['dateadded']));
				?>
			</td>
			<td>
				<?php
				echo "[ <a href='".site_url()."webusers/editwebuser/".$user['id']."'>EDIT</a> ]&nbsp;";
				echo "[ <a href='".site_url()."webusers/deletewebuser/".$user['id']."' class='red' onclick='return confirm(\"Are you sure you want to delete this web user?\")'>DELETE</a> ]";
				?>
			</td>
		</tr>
		<?php
	}
	if($pages>0){
		?>
		<tr>
			<td colspan="6" class='center font12' >
				There is a total of <?php echo $cnt; ?> <?php if($cnt>1) { echo "records"; } else{ echo "record"; }?> in the database. 
				Go to Page:
				<?php
				if($search){
					?>
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&search=<?php echo sanitizeX($search); ?>&filter=<?php echo sanitizeX($filter); ?>&start="+this.value'>
					<?php

				}
				else{
					?>
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&start="+this.value'>
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