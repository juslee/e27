<div class='list'>
<table>
	<tr>
		<td colspan=6 style='border:0px;'>
		[ <a href='<?php echo site_url(); ?>revisions' <?php if($type==''){ echo "class='bold'"; } ?> >ALL</a> ]
		[ <a href='<?php echo site_url(); ?>revisions/?type=pending' <?php if($type=='pending'){ echo "class='bold'"; } ?> >PENDING</a> ]
		[ <a href='<?php echo site_url(); ?>revisions/?type=approved' <?php if($type=='approved'){ echo "class='bold'"; } ?> >APPROVED</a> ]
		[ <a href='<?php echo site_url(); ?>revisions/?type=rejected' <?php if($type=='rejected'){ echo "class='bold'"; } ?> >REJECTED</a> ]
		</th>
	</tr>
	<tr>
		<th style="width:20px"></th>
		<th>Date</th>
		<th>Revised Record</th>
		<th>Revision By</th>
		<th>Status</th>
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
				echo "<a href='".site_url().$revisions[$i]['table']."/revision/".$revisions[$i]['id']."'>".date("M d, Y H:i:s", $revisions[$i]['dateupdated_ts'])."</a>";
				?>
			</td>
			<td>
				<?php
				$sql = "select * from `".$revisions[$i]['table']."` where `id`=".$this->db->escape($revisions[$i]['ipc_id']);
				$q = $this->db->query($sql);
				$ipc = $q->result_array();
				$ipc = $ipc[0];
				
				if($revisions[$i]['table']=='companies'){
					$table = "Company";
				}
				else if($revisions[$i]['table']=='people'){
					$table = "Person";
				}
				else if($revisions[$i]['table']=='investment_orgs'){
					$table = "Investment Org";
				}
				
				echo "$table - <a href='".site_url().$revisions[$i]['table']."/edit/".$revisions[$i]['ipc_id']."'>".$ipc['name']."</a>";
				
				?>
			</td>
			<td>
				<?php
				$sql = "select * from `web_users` where `id`=".$this->db->escape($revisions[$i]['web_user_id']);
				$q = $this->db->query($sql);
				$web_user = $q->result_array();
				$web_user = $web_user[0];
				$web_user = getWebUser($web_user);
				
				//echo "<pre>";
				//print_r($web_user);
				//echo "</pre>";
				
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
					<select onchange='self.location="?type=<?php echo sanitizeX($type); ?>&search=<?php echo sanitizeX($search); ?>&filter=<?php echo sanitizeX($filter); ?>&start="+this.value'>
					<?php

				}
				else{
					?>
					<select onchange='self.location="?type=<?php echo sanitizeX($type); ?>&start="+this.value'>
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