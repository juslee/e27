			<?php if($message_id=='create_success') { ?>
				<div class="msgbox success">User profile created successfully</div>
			<?php } elseif($message_id=='delete_success') { ?>
				<div class="msgbox success">User profile deleted successfully</div>
			<?php } ?>
			
			<p><a href="<?php echo site_url('cpanel/create_user'); ?>" class="button_large">Create User</a></p>
			<div class="clearfloat"></div>
			<p>
				<table class="datatable">
					<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Last Login</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($users))
						foreach($users as $user) {
					?>
					<tr>
						<td><?php echo $user['name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td>Admin</td>
						<td>
							<?php 
								if(!empty($user['last_login']))
									echo date('d M Y \a\t H:i:s',strtotime($user['last_login'])); 
								else
									echo "Not yet logged in";
							?>
						</td>
						<td>
							<a href="<?php echo site_url('cpanel/modify_user/'.$user['id']); ?>">Modify</a> | 
							<a href="<?php echo site_url('cpanel/delete_user/'.$user['id']); ?>"
								onclick="return confirm('Confirm delete user: <?php echo $user['name']; ?>?')">Delete</a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</p>
