<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th>Revision</th>
		<th>Revision By</th>
		<th>Status</th>
		<th>Date</th>
		<th></th>
		
	</tr>
	<?php
	$t = count($revisions);
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentitiesX($revisions[$i]['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<td>
				<?php
				$sql = "select * from `".$revisions[$i]['table']."` where `id`=".$this->db->escape($revisions[$i]['ipc_id']);
				$q = $this->db->query($sql);
				$ipc = $q->result_array();
				$ipc = $ipc[0];
				echo "<a href='".site_url().$revisions[$i]['table']."/edit/".$revisions[$i]['ipc_id']."'>".$ipc['name']."</a>";
				
				?>
			</td>
			<td>
				<?php
				$sql = "select * from `web_users` where `id`=".$this->db->escape($revisions[$i]['web_user_id']);
				$q = $this->db->query($sql);
				$web_user = $q->result_array();
				$web_user = $web_user[0];
				$web_user = getWebUser($web_user);
				echo "<a href='".site_url()."account/".$web_user['id']."'>".$web_user['name']."</a>";
				
				?>
			</td>
			<td>
				<?php
				if($revisions[$i]['approved']==1){
					echo "<a style='color:green' class='bold'>APPROVED<a>";
				}
				else if($revisions[$i]['approved']==0){
					echo "<a style='color:black' class='bold'>PENDING<a>";
				}
				else if($revisions[$i]['approved']<0){
					echo "<a style='color:red' class='bold'>REJECTED<a>";
				}
				?>
			</td>
			<td>
				<?php
				echo date("M d, Y H:i:s", $revisions[$i]['dateupdated_ts']);
				?>
			</td>
			<td>
				<?php
				echo "[ <a href='".site_url().$revisions[$i]['table']."/revision/".$revisions[$i]['id']."'>VIEW</a> ]";
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
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&filter=<?php echo sanitizeX($filter); ?>&start="+this.value'>
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