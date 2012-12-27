<?php
@session_start();
$myaccount = false;
if(!$user){
	$user = getWebUser($_SESSION['web_user']);
	$myaccount = true;
}
?>
<script>
function saveaccount(){
	jQuery("#savebuttonx").val("Saving...");
	formdata = jQuery("#account_form").serialize();
	jQuery("#account_form *").attr("disabled", true);
	jQuery.ajax({
		url: "<?php echo site_url(); ?>editaccount?missingemail=<?php echo $_GET['missingemail']; ?>",
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(){
			
		}
	});
}
</script>
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
								<td class="head">ACCOUNT DETAILS
								
								</td>
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
										<?php
										if(trim($user['email'])&&$user['id']==$_SESSION['web_user']['id']){
											?>
											<tr>
												<td class='bold'>
													E-mail:
												</td>
												<td>
													<?php echo $user['email']; ?>
												</td>
											</tr>
											<?php
										}
										if(trim($user['twitter'])){
											?>
											<tr>
												<td class='bold'>
													Twitter:
												</td>
												<td>
													<?php echo $user['twitter']; ?>
												</td>
											</tr>
											<?php
										}
										if(trim($user['homepage'])){
											?>
											<tr>
												<td class='bold'>
													URL:
												</td>
												<td>
													<?php echo $user['homepage']; ?>
												</td>
											</tr>
											<?php
										}
										?>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td class='account_center'>
						<form style='margin:0px' id='account_form'>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class="account_head">
									Edit Account
								</td>
							</tr>
							<tr>
								<td class="description" style='border:0px'>
									<table cellpadding="0" cellspacing="0" class="p100">
									<?php
									//echo "<pre>";
									//print_r($user);
									//echo "</pre>";
									
									
									if($user['type']!='fb'&&$user['type']!='in'){
										?>
										<tr>
										  <td class='pad5'>Password:</td>
										  <td class='pad5'><input type="password" name="password" size="40"><br><div class='hint'>Fill in password to change password</div></td>
										</tr>
										<tr>
										  <td class='pad5'>Confirm Password:</td>
										  <td class='pad5'><input type="password" name="repassword" size="40"></td>
										</tr>
										<?php
									}
									else if($user['type']=='in'||$_GET['missingemail']){
										if($_GET['missingemail']){
											?>
											<tr>
											  <td class='center' colspan="2" style='padding:10px;' >
												Please complete your registration by registering your E-mail Address.
											  </td>
											</tr>
											<?php
										}
										?>
										<tr>
										  <td class='pad5'>E-mail Address:</td>
										  <td class='pad5'><input type="text" name="email" size="40" value="<?php echo sanitizeX($user['email']); ?>"></td>
										</tr>
										<?php
									}
									if(!$_GET['missingemail']){
										?>
										<tr>
										  <td class='pad5'>Twitter Handle:</td>
										  <td class='pad5'><input type="text" name="twitter" size="40" value="<?php echo sanitizeX($user['twitter']); ?>"><div class='hint'>E.g. @twitter</div></td>
										</tr>
										<tr>
										  <td class='pad5'>Homepage URL:</td>
										  <td class='pad5'><input type="text" name="homepage" size="40" value="<?php echo sanitizeX($user['homepage']); ?>"><div class='hint'>E.g. http://www.e27.sg</div></td>
										</tr>
										<?php
									}
									?>
									<tr>
										  <td class='center' colspan="2" style='padding-top:15px;' >
											<input type='button' class='normal' value='Save' onclick='saveaccount()' id='savebuttonx' />
										  </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td class='account_right'>
						<?php
						$this->load->view("startuplist/contribute_block");
						?>
						<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
							<tr>
								<td class="head">KARMA POINTS</td>
							</tr>
							<tr>
								<td class="content center">
									<?php 
									$karma = startuplist::getAccountKarma($user['id']);
									echo "<div class='hint'>".$karma['approved']." Approved, ".$karma['rejected']." Rejected, ".$karma['pending']." Pending</div>";
									echo "<br /><br />Total Points: ".($karma['approved']-$karma['rejected']);
									 ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>