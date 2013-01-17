			<?php if($message_id=='modify_success') { ?><div class="msgbox success">User profile saved successfully</div><?php } ?>
			<h2>User Profile - <?php echo $user['name']; ?></h2>
			<div class="clearfloat"></div>
			<hr />
			<h3>Modify User Profile</h3>
			<form method="post">
			<table class="form_area">
				<tr>
					<td width="180">Name</td>
					<td colspan="3">
						<input type="text" name="name" class="input_medium" 
							value="<?php if(set_value('name')!="") echo set_value('name'); else echo $user['name']; ?>" /><br />
						<?php if(form_error('name')!="") { ?><span class="error"><?php echo strip_tags(form_error('name')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Email Address</td>
					<td colspan="3">
						<input type="text" name="email" class="input_medium"  
							value="<?php if(set_value('email')!="") echo set_value('email'); else echo $user['email']; ?>" /><br />
						<?php if(form_error('email')!="") { ?><span class="error"><?php echo strip_tags(form_error('email')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Change Password</td>
					<td colspan="3">
						<input type="password" name="password" class="input_small" autocomplete="off" /><br />
						<span class="info">Password must contain 8 characters or more</span><br />
						<?php if(form_error('password')!="") { ?><span class="error"><?php echo strip_tags(form_error('password')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Password Confirmation</td>
					<td colspan="3">
						<input type="password" name="passwconf" class="input_small" autocomplete="off" /><br />
						<?php if(form_error('passwconf')!="") { ?><span class="error"><?php echo strip_tags(form_error('passwconf')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>User Role</td>
					<td colspan="3">Administrator</td>
				</tr>
				<tr>
					<td>Last Login</td>
					<td colspan="3">10th April 2012 at 10:20am (IP 122.12.311.22)</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<input type="submit" name="submit" value="Save Changes" class="button_medium"  />
						<input type="submit" name="submit"  value="Delete User" class="button_medium" 
							onclick="return confirm('Confirm delete user: <?php echo $user['name']; ?>?')" />
					</td>
				</tr>
				
			</table>
			</form>

			<p class="align_right"><a href="<?php echo site_url('cpanel/users'); ?>">&raquo; Back to Manage Users</a></p>