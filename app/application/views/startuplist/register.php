<script>
function register(){
	jQuery("#registerbutton").hide();
	jQuery("#registering").show();
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
		alertX("Please complete all required fields");
		jQuery("#registerbutton").show();
		jQuery("#registering").hide();
	}
	else{
		formdata = jQuery("#registerform").serialize();
		jQuery.ajax({
			url: "<?php echo site_url(); ?>register",
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
									Register
								</td>
							</tr>
							<tr>
								<td class="description">
									<form id='registerform' method="post">
									<table class='register'>
										<tr>
											<td class='req' colspan="2">* Required Fields</td>
										</tr>
										<tr>
											<td class='label'>* Name</td>
											<td class='value'><input type='text' name='name' class='required'></td>
										</tr>
										<tr>
											<td class='label'>* E-mail</td>
											<td class='value'>
												<input type='text' name='email' class='required'>
												<br /><div class='hint'>We prefer a company email address if you have one</div>
											</td>
										</tr>
										<tr>
											<td class='label'>* Password</td>
											<td class='value'><input type='password' name='password' class='required'></td>
										</tr>
										<tr>
											<td class='label'>* Confirm Password</td>
											<td class='value'><input type='password' name='repassword' class='required'></td>
										</tr>
										<tr>
											<td class='label'>Twitter Handle (optional)</td>
											<td class='value'><input type='text' name='twitter'></td>
										</tr>
										<tr>
											<td class='label'>Website (optional)</td>
											<td class='value'><input type='text' name='homepage'></td>
										</tr>
										<tr>
											<td class='label'></td>
											<td class='value'>
											<?php
												captcha()
											?>
											<script>
												jQuery("#captchaimg").load(function(){
													jQuery("#getanother").show();
													jQuery("#anotherloading").hide();
												});
											</script>
											<br>
											<div id='anotherloading' class='hidden'><img src='<?php echo site_url(); ?>media/ajax-loader.gif' /></div>
											<div id='getanother'><a href='#' onclick='recap(); return false;' >Get another word</a></div>
											<br />
											* Type the word you see on the image above <br />
											<input type='text' name='captcha' class='required' />
											</td>
										</tr>
										
										<tr>
											<td class='submit' colspan="2" >
												<img id='registerbutton' src='<?php echo site_url(); ?>media/startuplist/register.jpg' onclick='register();'  />
												<div id='registering' class='hidden'>Registering... <img src='<?php echo site_url(); ?>media/ajax-loader.gif' /> </div>
											</td>
										</tr>
									</table>
									</form>
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