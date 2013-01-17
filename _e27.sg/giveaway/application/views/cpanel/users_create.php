			<h3>Create User Profile</h3>
			<form method="post">
			<table class="form_area">
				<tr>
					<td width="180">Name</td>
					<td colspan="3">
						<input type="text" name="name" class="input_medium" value="<?php echo set_value('name'); ?>" /><br />
						<?php if(form_error('name')!="") { ?><span class="error"><?php echo strip_tags(form_error('name')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Email Address</td>
					<td colspan="3">
						<input type="text" name="email" class="input_medium" value="<?php echo set_value('email'); ?>" /><br />
						<?php if(form_error('email')!="") { ?><span class="error"><?php echo strip_tags(form_error('email')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Password</td>
					<td colspan="3">
						<input type="password" name="password" class="input_small" /><br />
						<span class="info">Password must contain 8 characters or more</span><br />
						<?php if(form_error('password')!="") { ?><span class="error"><?php echo strip_tags(form_error('password')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Password Confirmation</td>
					<td colspan="3">
						<input type="password" name="passwconf" class="input_small" /><br />
						<?php if(form_error('passwconf')!="") { ?><span class="error"><?php echo strip_tags(form_error('passwconf')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>User Role</td>
					<td colspan="3">Administrator</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<input type="submit" value="Create User" class="button_medium"  />
					</td>
				</tr>
				
			</table>
			</form>

			<p class="align_right"><a href="<?php echo site_url('cpanel/users'); ?>">&raquo; Back to Manage Users</a></p>