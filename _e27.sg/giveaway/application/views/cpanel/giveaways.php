			<?php if($message_id=='create_success') { ?>
				<div class="msgbox success">Giveaway created successfully</div>
			<?php } elseif($message_id=='delete_success') { ?>
				<div class="msgbox success">Giveaway deleted successfully</div>
			<?php } ?>
			
			<p><a href="<?php echo site_url('cpanel/create_giveaway'); ?>" class="button_large">Create Giveaway</a></p>
			<div class="clearfloat"></div>
			<p>
				<table class="datatable">
					<thead>
					<tr>
						<th>Giveaway</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Leader (Signups/Visits)</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($giveaways))
						foreach($giveaways as $giveaway) {
					?>
					<tr>
						<td><?php echo $giveaway['title']; ?></td>
						<td><?php echo date('d M Y',strtotime($giveaway['start_date'])); ?></td>
						<td><?php echo date('d M Y',strtotime($giveaway['end_date'])); ?></td>
						<td>
						<?php 
							if(!empty($giveaway['leader'])) { 
								echo $giveaway['leader'].' ('.number_format($giveaway['signups'],0).'/'
								.number_format($giveaway['visits'],0).')';
							} else { 
								echo 'No registrations yet';
							} 
						?>
						</td>
						<td>
							<a href="<?php echo site_url('cpanel/giveaway_stats/'.$giveaway['id']); ?>">Stats</a> | 
							<a href="<?php echo site_url('cpanel/modify_giveaway/'.$giveaway['id']); ?>">Modify</a> | 
							<a href="<?php echo site_url($giveaway['permalink']); ?>" target="_blank">Visit</a> | 
							<a href="<?php echo site_url('cpanel/delete_giveaway/'.$giveaway['id']); ?>"
								onclick="return confirm('Confirm delete giveaway: <?php echo $giveaway['title']; ?>?')">Delete</a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</p>
			
			