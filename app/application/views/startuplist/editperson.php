<?php
@session_start();
$controller = $this->router->class;
$method = $this->router->method;
if(!$user){
	$user = getWebUser($_SESSION['web_user']);
}
?>
<script>
function showRows(obj, alt){
	if(alt){
		if(alt=='revisions'){
			jQuery("#revisionsx").show();
			return true;
		}
	}
	else {
		jQuery(".edit").removeClass("parted");
		obj.parent().addClass("parted");
		alt = obj.attr("alt");
	}
	jQuery("#revisionsx").hide();
	jQuery("#editx").show();
	jQuery("#person_form tr.odd, #person_form tr.even").hide();
	jQuery("#person_form tr."+alt).show();
}
</script>
<table cellpadding="0" cellspacing="0" class="p100">
	<tr>
		<td class="contents2">
			<table cellpadding="0" cellspacing="0" class='p100'>
				<tr>
					<td class='breadcrumbs'>
					<a href='<?php echo site_url(); ?>'>Home</a> >
					<?php
					if($method=='editperson'){
						echo "<a href='".site_url()."person/".$company['slug']."/".$person['id']."'>".$person['name']."</a>";
						?>
						> <a style='color:#505050'>Edit</a>
						<?php
					}
					else if($method=='addperson'){
						?>
						<a style='color:#505050'>Add Person</a>
						<?php
					}
					?>
					</td>
				</tr>
				<tr>
					<td class='account_left'>
						<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
							<tr>
								<td class="head">
								<?php 
								if($method=='editperson'){
									?>EDIT PERSON<?php
								}
								else if($method=='addperson'){
									?>ADD PERSON<?php
								}
								?>
								
								</td>
							</tr>
							<tr>
								<td class="content">
									<?php
									
									if($part=="about"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='about' onclick='showRows(jQuery(this)); return false;'>ABOUT</div>";
									
									if($part=="overview"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='overview' onclick='showRows(jQuery(this)); return false;'>OVERVIEW</div>";
									
									if($part=="logo"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='logo' onclick='showRows(jQuery(this)); return false;'>PROFILE IMAGE</div>";
									
									
									if($part=="career"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='career' onclick='showRows(jQuery(this)); return false;'>CAREER</div>";
									
									if($part=="investment_orgs"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='investment_orgs' onclick='showRows(jQuery(this)); return false;'>INVESTMENT ORGS</div>";
									
									//if($part=="investments"){ $class="parted"; } else { $class=""; }
									//echo "<div class='edit pad5 $class'><a href='".site_url()."editcompany/".$company['id']."/investments'>INVESTMENTS</div>";

									
									?>
									
								</td>
							</tr>
						</table>
					</td>
					<td class='account_center'>
						<div id='editx' class='hidden'>
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td class="account_head">
										<?php 
										if($method=='editperson'){
											echo "Editing <a href='".site_url()."person/".$person['slug']."/".$person['id']."'>".$person['name']."</a>";
										}
										else if($method=='addperson'){
											echo "Add Person";
										}
										?>
									</td>
								</tr>
								<tr>
									<td class="description">
										
										<?php
										//echo "<pre>";
										//echo "Part to edit: ".$part."<br /><br />";
										//print_r($company);
										//echo "</pre>";
										$this->load->view("startuplist/editperson_form", $data);
										?>
										
								
									</td>
								</tr>
							</table>
						</div>
						<div id='revisionsx' class='hidden'>
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td class="account_head">
										<?php
										echo "<a href='".site_url()."person/".$person['slug']."/".$person['id']."'>".$person['name']."</a>";
										?> Revisions
									</td>
								</tr>
								<tr>
									<td class="description">
										<?php
										if(is_array($revisions)){
											foreach($revisions as $key=>$revision){
												$sql = "select * from `web_users` where `id`=".$this->db->escape($revision['web_user_id']);
												$q = $this->db->query($sql);
												$web_user = $q->result_array();
												$web_user = $web_user[0];
												$web_user = getWebUser($web_user);
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
												echo "<div class='revision padb5'>[ ".date("M d, Y H:i:s", $revision['dateupdated_ts'])." ] Revision submitted by <a href='".site_url()."account/".$web_user['id']."'>".$web_user['name']."</a> ... $approved </div>";
											}
										}
										?>
								
									</td>
								</tr>
							</table>
						</div>
						<script>
						jQuery("#editx").hide();
						jQuery("#person_form tr.odd, #person_form tr.even").hide();
						showRows("", "<?php echo $part; ?>");
						</script>
					</td>
					<td class='account_right'>
						<?php
						if($method=='editperson'){
							?>
							<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
								<tr>
									<td class="head">PERSON</td>
								</tr>
								<tr>
									<td class="content">
										<table>
											<tr>
												<td class='contribute'>
													<div><a href='<?php echo site_url(); ?>person/<?php echo $person['slug']; ?>/<?php echo $person['id']; ?>'>Back to <?php echo $person['name']; ?></a></div>
													<div><a href='<?php echo site_url(); ?>editperson/<?php echo $person['id']; ?>/revisions'>Revisions</a></div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<?php
						}
						$this->load->view("startuplist/contribute_block");
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>