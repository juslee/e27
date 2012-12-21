<script>
function forgotpass(){
	jQuery("#forgotpassbutton").hide();
	jQuery("#forgotpassing").show();
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
		jQuery("#forgotpassbutton").show();
		jQuery("#forgotpassing").hide();
	}
	else{
		formdata = jQuery("#forgotpassform").serialize();
		jQuery.ajax({
			url: "<?php echo site_url(); ?>forgotpass",
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
									Forgot Password
								</td>
							</tr>
							<tr>
								<td class="description">
									<div id='anemail' class='hidden'>
										An E-mail has been sent to -email- 
									</div>
									<form id='forgotpassform' method="post">
									<table class='login'>
										<tr>
											<td class='req label' colspan="2" id='message'>Input your E-mail to retrive password.</td>
										</tr>
										<tr>
											<td class='label'>E-mail</td>
											<td class='value'>
												<input type='text' name='email' id='femail' class='required'>	
											</td>
										</tr>
										<tr>
											<td class='submit' colspan="2" >
												<table style='margin:auto'>
													<tr>
														<td style="vertical-align:middle">
															<img id='forgotpassbutton' src='<?php echo site_url(); ?>media/startuplist/submit.jpg' onclick='forgotpass();'  />
															<div id='forgotpassing' class='hidden'><img src='<?php echo site_url(); ?>media/ajax-loader.gif' /> </div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										
									</table>
									</form>
									<script>
									jQuery("#femail").each(function(){
										jQuery(this).keypress(function(event){
											if ( event.which == 13 ) {
												//forgotpass();
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