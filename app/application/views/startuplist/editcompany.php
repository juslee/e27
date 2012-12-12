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
	jQuery("#company_form tr.odd, #company_form tr.even").hide();
	jQuery("#company_form tr."+alt).show();
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
					echo "<a href='".site_url()."company/".$company['slug']."/".$company['id']."'>".$company['name']."</a>";
					?>
					> <a style='color:#505050'>Edit</a>
					</td>
				</tr>
				<tr>
					<td class='account_left'>
						<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
							<tr>
								<td class="head">
								<?php 
								if($method=='editcompany'){
									?>EDIT COMPANY<?php
								}
								else if($method=='addcompany'){
									?>ADD COMPANY<?php
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
									echo "<div class='edit pad5 $class'><a href='#' alt='logo' onclick='showRows(jQuery(this)); return false;'>LOGO</div>";
									
									if($part=="screenshots"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='screenshots' onclick='showRows(jQuery(this)); return false;'>SCREEN SHOTS</div>";
									
									if($part=="people"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='people' onclick='showRows(jQuery(this)); return false;'>PEOPLE</div>";
									
									if($part=="funding"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='funding' onclick='showRows(jQuery(this)); return false;'>FUNDING</div>";
									
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
										if($method=='editcompany'){
											echo "Editing <a href='".site_url()."company/".$company['slug']."/".$company['id']."'>".$company['name']."</a>";
										}
										else if($method=='addcompany'){
											echo "Add Company";
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
										$this->load->view("startuplist/editcompany_form", $data);
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
										echo "<a href='".site_url()."company/".$company['slug']."/".$company['id']."'>".$company['name']."</a>";
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
						jQuery("#company_form tr.odd, #company_form tr.even").hide();
						showRows("", "<?php echo $part; ?>");
						</script>
					</td>
					<td class='account_right'>
						<?php
						if($method=='editcompany'){
							?>
							<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
								<tr>
									<td class="head">COMPANY</td>
								</tr>
								<tr>
									<td class="content">
										<table>
											<tr>
												<td class='contribute'>
													<div><a href='<?php echo site_url(); ?>company/<?php echo $company['slug']; ?>/<?php echo $company['id']; ?>'>Back to <?php echo $company['name']; ?></a></div>
													<div><a href='<?php echo site_url(); ?>editcompany/<?php echo $company['id']; ?>/revisions'>Revisions</a></div>
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