<script>
function register(){
	err = false;
	jQuery(".required").each(function(){
		v = jQuery.trim(jQuery(this).val());
		if(v==''){
			err = true;
			jQuery(this).css({border:"1px solid red"});
		}
	});
	if(err){
		alertX("Please complete all required fields");
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
											<td class='value'><input type='text' name='email' class='required'></td>
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
											<td class='label'>* Type the word you see</td>
											<td class='value'>
											<?php
												captcha()
											?>
											<br>
											<input type='text' name='captcha' class='required' />
											</td>
										</tr>
										
										<tr>
											<td class='submit' colspan="2" >
												<img id='registerbutton' src='<?php echo site_url(); ?>media/startuplist/register.jpg' onclick='register();'  />
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