<?php
@session_start();
if(!$user){
	$user = getWebUser($_SESSION['web_user']);
}
?>
<script>
function showRows(obj, alt){
	if(!alt){
		jQuery(".edit").removeClass("parted");
		obj.parent().addClass("parted");
		alt = obj.attr("alt");
	}
	jQuery("#company_form tr.odd, #company_form tr.even").hide();
	jQuery("#company_form tr."+alt).show()
	if(!alt){
		return false;
	}
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
								<td class="head">EDIT COMPANY</td>
							</tr>
							<tr>
								<td class="content">
									<?php
									if($part=="logo"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='logo' onclick='return showRows(jQuery(this));'>LOGO</div>";
									
									if($part=="about"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='about' onclick='return showRows(jQuery(this));'>ABOUT</div>";
									
									if($part=="overview"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='overview' onclick='return showRows(jQuery(this));'>OVERVIEW</div>";
									
									if($part=="people"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='people' onclick='return showRows(jQuery(this));'>PEOPLE</div>";
									
									if($part=="funding"){ $class="parted"; } else { $class=""; }
									echo "<div class='edit pad5 $class'><a href='#' alt='funding' onclick='return showRows(jQuery(this));'>FUNDING</div>";
									
									//if($part=="investments"){ $class="parted"; } else { $class=""; }
									//echo "<div class='edit pad5 $class'><a href='".site_url()."editcompany/".$company['id']."/investments'>INVESTMENTS</div>";

									
									?>
									
								</td>
							</tr>
						</table>
					</td>
					<td class='account_center'>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class="account_head">
									Editing <?php
									echo "<a href='".site_url()."company/".$company['slug']."/".$company['id']."'>".$company['name']."</a>";
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
									<script>
									jQuery("#company_form tr.odd, #company_form tr.even").hide();
									showRows("", "<?php echo $part; ?>");
									</script>
							
								</td>
							</tr>
						</table>
					</td>
					<td class='account_right'>
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
												<div><a href='<?php echo site_url(); ?>revcompany/<?php echo $company['id']; ?>'>Revisions</a></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<?php
						$this->load->view("startuplist/contribute_block");
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>