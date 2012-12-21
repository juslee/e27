<script>
function changepass(){
	jQuery("#changepassbutton").hide();
	jQuery("#changepassing").show();
	err = false;
	jQuery(".required").each(function(){
		v = jQuery.trim(jQuery(this).val());
		if(v==''){
			err = true;
			jQuery(this).css({border:"1px solid red"});
		}
		else{
			jQuery(this).css({border:"1px solid gray"});
		}
	});
	if(err){
		alertX("Please complete all fields!");
		jQuery("#changepassbutton").show();
		jQuery("#changepassing").hide();
	}
	else{
		formdata = jQuery("#changepassform").serialize();
		jQuery.ajax({
			url: "<?php echo site_url(); ?>changepass",
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				
			}
		});
	}
}
function recap(){
	jQuery("#getanother").hide();
	jQuery("#anotherloading").show();
	jQuery("#captchaimg").attr("src", "<?php echo site_url(); ?>media/startuplist/cool-php-captcha-0.3.1/captcha.php?_="+(new Date()).getTime());
}
</script>
<table cellpadding="0" cellspacing="0" class="p100">
	<tr>
		<td class="contents2">
			<table cellpadding="0" cellspacing="0" class='p100'>
				<tr>
					<td class='company_right'>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class="company_name">
									Change Password
								</td>
							</tr>
							<tr>
								<td class="description">
									<div id='youmay' class='hidden'>
										An E-mail has been sent to -email- 
									</div>
									<?php
									if($changepass_user['email']){
										?>
										<form id='changepassform' method="post">
										<table class='login'>
											<tr>
												<td class='req label' colspan="2" id='message'>Input your new password.</td>
											</tr>
											<tr>
												<td class='label'>E-mail</td>
												<td class='label'>
													<?php echo "<b>".$changepass_user['email']."</b>"; ?>	
												</td>
											</tr>
											<tr>
												<td class='label'>New Password</td>
												<td class='value'><input type='password' name='password' class='required'></td>
											</tr>
											<tr>
												<td class='label'>Confirm Password</td>
												<td class='value'><input type='password' name='repassword' class='required'></td>
											</tr>
											<tr>
												<td class='submit' colspan="2" >
													<table style='margin:auto'>
														<tr>
															<td style="vertical-align:middle">
																<img id='changepassbutton' src='<?php echo site_url(); ?>media/startuplist/submit.jpg' onclick='changepass();'  />
																<div id='changepassing' class='hidden'><img src='<?php echo site_url(); ?>media/ajax-loader.gif' /> </div>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											
										</table>
										</form>
										<?php
									}
									else{
										?>
										<script>
										jQuery("#youmay").html("This link has expired. Please click <a href='<?php echo site_url(); ?>userlogin'>here</a> to login.");
										jQuery("#youmay").show();
										</script>
										<?php
									}
									?>
									
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<!--
		<td class="sidebar">
			
		</td>
		-->
	</tr>
</table>