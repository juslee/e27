			<?php if(isset($message_id) AND $message_id=='delete_success') { ?>
				<div class="msgbox success">Giveaway registration deleted successfully</div>
			<?php } ?>
			<h2><?php echo $giveaway['title']; ?></h2>
			<p>
				<a href="<?php echo site_url('cpanel/modify_giveaway/'.$giveaway['id']); ?>" class="button_large">Modify Giveaway</a>
				<br /><strong>Total Visits</strong>: <?php echo number_format($stats['total_visits'],0); ?>
				<br /><strong>Total Registrations</strong>: <?php echo number_format($stats['total_signups'],0); ?>
				<br />
				<br /><strong>Start Date</strong>: <?php echo date('d M Y',strtotime($giveaway['start_date'])); ?>			
				&nbsp;&nbsp;/&nbsp;&nbsp;
				<strong>End Date</strong>: <?php echo date('d M Y',strtotime($giveaway['end_date'])); ?>
			</p>
			<p><strong>Admin Notes</strong><br />
				<?php echo strip_tags($giveaway['admin_notes']); ?>
			</p>
			<div class="clearfloat"></div>
			<hr />
			<h3>Registrations</h3>
			<p>
				<table class="datatable">
					<thead>
					<tr>
						<th>Rank</th>
						<th>Registered On</th>
						<th>Name</th>
						<th>Email</th>
						<th>Signups</th>
						<th>Visits</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$i=0;
					
					if(!empty($registrations)) 
						foreach($registrations as $registration) {
							$i++;
					?>
					<tr>
						<td><?php echo number_format($i,0); ?> of <?php echo number_format(count($registrations),0); ?></td>
						<td><?php echo date('d M Y',strtotime($registration['created_on'])); ?></td>
						<td><?php echo $registration['first_name'].' '.$registration['last_name']; ?></td>
						<td><?php echo $registration['email']; ?></td>
						<td><?php echo number_format($registration['signups'],0); ?></td>
						<td><?php echo number_format($registration['visits'],0); ?></td>
						<td>
							<a href="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>" target="_blank">Visit</a> | 
							<a href="<?php echo site_url('cpanel/delete_registration/'.$giveaway['id'].'/'.$registration['id']); ?>" 
								onclick="return confirm('Confirm delete registration: <?php echo $registration['first_name']; ?>?')">Delete</a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</p>
			<div class="clearfloat"></div>
			<p>&nbsp;</p>
			<p class="align_right"><a href="<?php echo site_url('cpanel/giveaways'); ?>">&raquo; Back to Manage Giveaways</a></p>