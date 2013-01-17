				<a name="formarea"></a>
				<script type="text/javascript">window.location.hash = '#formarea';</script>
				
				<h2>Almost Done!</h2>
				<p>
					Please fill in your details below to retrieve your unique URL.
				</p>	
				<form method="post" action="<?php echo site_url(''.$giveaway['permalink'].'/'.$referrer_id.'/process'); ?>">
				<table >
					<tr>
						<th>First Name</th>
						<td>
							<input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" /><br />
							<?php if(form_error('first_name')!="") { ?><span class="error"><?php echo strip_tags(form_error('first_name')); ?></span><?php } ?>
						</td>
					</tr>
					<tr>
						<th>Last Name</th>
						<td>
							<input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" /><br />
							<?php if(form_error('last_name')!="") { ?><span class="error"><?php echo strip_tags(form_error('last_name')); ?></span><?php } ?>
						</td>
					</tr>
					<tr>
						<th>Company</th>
						<td>
							<input type="text" name="company" value="<?php echo set_value('company'); ?>" /><br />
							<?php if(form_error('company')!="") { ?><span class="error"><?php echo strip_tags(form_error('company')); ?></span><?php } ?>
						</td>
					</tr>
					<tr>
						<th>Title</th>
						<td>
							<input type="text" name="title" value="<?php echo set_value('title'); ?>" /><br />
							<?php if(form_error('title')!="") { ?><span class="error"><?php echo strip_tags(form_error('title')); ?></span><?php } ?>
						</td>
					</tr>
					
					<tr>
						<th>I am a</th>
						<td>
							<input type="checkbox" name="profile[]" value="Startup"> Startup <br />
							<input type="checkbox" name="profile[]" value="Investor"> Investor <br />
							<input type="checkbox" name="profile[]" value="Corporate Company"> Corporate Company <br />
							<input type="checkbox" name="profile[]" value="Regulator/Government"> Regulator/Government <br />
							<input type="checkbox" name="profile[]" value="Media Company"> Media Company <br />
							<input type="checkbox" name="profile[]" value="Developer"> Developer
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Continue" class="button_medium" />
						</td>
					</tr>
				</table>
				</p>
				</form>	