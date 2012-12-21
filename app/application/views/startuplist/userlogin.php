<script>
function userlogin(){
	jQuery("#loginbutton").hide();
	jQuery("#logging").show();
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
		jQuery("#loginbutton").show();
		jQuery("#logging").hide();
	}
	else{
		formdata = jQuery("#loginform").serialize();
		jQuery.ajax({
			url: "<?php echo site_url(); ?>userlogin<?php
			if($_GET['ref']){
				echo "?ref=".$_GET['ref'];
			}
			?>",
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
									Login
								</td>
							</tr>
							<tr>
								<td class="description">
									<form id='loginform' method="post">
									<table class='login'>
										<?php
										if($_GET['register']=='complete'){
											?>
											<tr>
												<td class='thankyou' colspan="2">
												Thank you for registering. You may now login to your account.
												</td>
											</tr>
											<?php
										}
										?>
										<tr>
											<td class='label'>E-mail</td>
											<td class='value'>
												<input type='text' name='email' class='required'>	
											</td>
										</tr>
										<tr>
											<td class='label'>Password</td>
											<td class='value'><input type='password' name='password' class='required' id='upass'></td>
										</tr>
										<tr>
											<td class='submit' colspan="2" >
												<table style='margin:auto'>
													<tr>
														<td style="vertical-align:middle">
															<img id='loginbutton' src='<?php echo site_url(); ?>media/startuplist/login.jpg' onclick='userlogin();'  />
															<div id='logging' class='hidden'>Logging in... <img src='<?php echo site_url(); ?>media/ajax-loader.gif' /> </div>
														</td>
														<td style='vertical-align:middle'>
															<img id='fb_loginbutton' src='<?php echo site_url(); ?>media/startuplist/fb_login.jpg' onclick='fb_login();'  />
															<div id='fb_logging' class='hidden'>Logging in... <img src='<?php echo site_url(); ?>media/ajax-loader.gif' /> </div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td class='spiels' colspan="2">
												No account yet? Click <a href='<?php echo site_url() ?>register'>here</a> to register.
												Forgot Password? Click <a href='<?php echo site_url() ?>forgotpass'>here</a>.
											</td>
										</tr>
										
									</table>
									</form>
									<script>
									jQuery("#upass").each(function(){
										jQuery(this).keypress(function(event){
											if ( event.which == 13 ) {
												userlogin();
											}
									
										});
									});
									</script>
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