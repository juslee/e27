<?php
@session_start();
if(!$user){
	$user = getWebUser($_SESSION['web_user']);
}
?>
<table cellpadding="0" cellspacing="0" class="p100">
	<tr>
		<td class="contents2">
			<table cellpadding="0" cellspacing="0" class='p100'>
				<tr>
					<td class='breadcrumbs' colspan="3">
					<a href='<?php echo site_url(); ?>'>Home</a> >
					<?php
					echo "<a href='".site_url()."account/".$user['id']."'>".$user['name']."</a>";
					?>
					> Account
					</td>
				</tr>
				<tr>
					<td class='account_left'>
						<?php
						if(trim($user['img'])){
							?>
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td class='logo'>
										<div><img src='<?php echo $user['img']; ?>' /></div>
									</td>
								</tr>
							</table>
							<?php
						}
						?>
						<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
							<tr>
								<td class="head">ACCOUNT DETAILS</td>
							</tr>
							<tr>
								<td class="content">
									<table>
										<tr>
											<td class='bold'>
												Name:
											</td>
											<td>
												<?php echo $user['name']; ?>
											</td>
										</tr>
										<tr>
											<td class='bold'>
												E-mail:
											</td>
											<td>
												<?php echo $user['email']; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td class='account_center'>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class="account_head">
									Recent Edits
								</td>
							</tr>
							<tr>
								<td class="description">
									<?php
										if(is_array($revisions)){
											foreach($revisions as $key=>$revision){
												$sql = "select * from `".$revision['table']."` where `id`=".$this->db->escape($revision['ipc_id']);
												$q = $this->db->query($sql);
												$ipc = $q->result_array();
												$ipc = $ipc[0];
												$approved = "";
												if($revision['approved']=='1'){
													$approved = "<a style='color:green' class='bold'>APPROVED</a>";
												}
												else if($revision['approved']=='-1'){
													$approved = "<a style='color:red' class='bold'>REJECTED</a>";
												}
												else{
													$approved = "<a style='color:black' class='bold'>PENDING</a>";
												}
												if($revision['table']=='companies'){
													$table = "company";
												}
												else if($revision['table']=='people'){
													$table = "person";
												}
												else if($revision['table']=='investment_orgs'){
													$table = "investment_org";
												}
												echo "<div class='revision padb5'>[ ".date("M d, Y H:i:s", $revision['dateupdated_ts'])." ] Edited <a href='".site_url().$table."/".$ipc['slug']."'>".$ipc['name']."</a>... $approved </div>";
											}
										}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td class='account_right'>
						<?php
						$this->load->view("startuplist/contribute_block");
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>