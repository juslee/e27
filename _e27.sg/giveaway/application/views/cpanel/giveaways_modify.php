			<?php if($message_id=='modify_success') { ?><div class="msgbox success">Giveaway saved successfully</div><?php } ?>
			
			<h2><?php echo $giveaway['title']; ?></h2>
			<p>
				<a href="<?php echo site_url('cpanel/giveaway_stats/'.$giveaway['id']); ?>" class="button_large">Giveaway Stats</a>
				<br /><strong>Total Visits</strong>: <?php echo number_format($stats['total_signups'],0); ?>
				<br /><strong>Total Registrations</strong>: <?php echo number_format($stats['total_visits'],0); ?>
				<br />
				<br /><strong>Start Date</strong>: <?php echo date('d M Y',strtotime($giveaway['start_date'])); ?>			
				&nbsp;&nbsp;/&nbsp;&nbsp;
				<strong>End Date</strong>: <?php echo date('d M Y',strtotime($giveaway['end_date'])); ?>
			</p>
			<div class="clearfloat"></div>
			<hr />
			<h3>Modify Giveaway</h3>
			
			<form method="post" enctype="multipart/form-data">
			<table class="form_area">
				<tr>
					<td width="180">Giveaway Link</td>
					<td colspan="3">
						<a href="<?php echo site_url(''.$giveaway['permalink']); ?>" target="_blank"><?php echo site_url(''.$giveaway['permalink']); ?></a>
					</td>
				</tr>
				<tr>
					<td>Start Date</td>
					<td colspan="3">
						<input type="text" name="start_date" class="input_small date_picker" contenteditable="false"  
							value="<?php if(set_value('start_date')!="") echo set_value('start_date'); else echo date('d-m-Y',strtotime($giveaway['start_date'])); ?>" /><br />
						<?php if(form_error('start_date')!="") { ?><span class="error"><?php echo strip_tags(form_error('start_date')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>End Date</td>
					<td colspan="3">
						<input type="text" name="end_date" class="input_small date_picker" contenteditable="false" 
							 value="<?php if(set_value('end_date')!="") echo set_value('end_date'); else echo date('d-m-Y',strtotime($giveaway['end_date'])); ?>"/><br />
						<?php if(form_error('end_date')!="") { ?><span class="error"><?php echo strip_tags(form_error('end_date')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Question</td>
					<td colspan="3">
						<input type="text" name="question" class="input_large" 
							value="<?php if(set_value('question')!="") echo set_value('question'); else echo $giveaway['question']; ?>" /><br />
						<?php if(form_error('question')!="") { ?><span class="error"><?php echo strip_tags(form_error('question')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Answer</td>
					<td colspan="3">
						<input type="text" name="answer" class="input_large" 
							value="<?php if(set_value('answer')!="") echo set_value('answer'); else echo $giveaway['answer']; ?>" /><br />
						<?php if(form_error('answer')!="") { ?><span class="error"><?php echo strip_tags(form_error('answer')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Invalid Answer #1</td>
					<td colspan="3">
						<input type="text" name="invalid_answer_1" class="input_large" 
							value="<?php if(set_value('invalid_answer_1')!="") echo set_value('invalid_answer_1'); else echo $giveaway['invalid_answer_1']; ?>" /><br />
						<?php if(form_error('invalid_answer_1')!="") { ?><span class="error"><?php echo strip_tags(form_error('invalid_answer_1')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Invalid Answer #2</td>
					<td colspan="3">
						<input type="text" name="invalid_answer_2" class="input_large" 	
							value="<?php if(set_value('invalid_answer_2')!="") echo set_value('invalid_answer_2'); else echo $giveaway['invalid_answer_2']; ?>" /><br />
						<?php if(form_error('invalid_answer_2')!="") { ?><span class="error"><?php echo strip_tags(form_error('invalid_answer_2')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Change Banner</td>
					<td colspan="3">
						<a href="<?php echo site_url('banners/'.$giveaway['banner_file']); ?>" rel="facebox"><img src="<?php echo site_url('banners/'.$giveaway['banner_file']); ?>" alt="" width="300" /></a>
						<br />
						<input type="file" name="banner" class="input_large"  /><br />
						<span class="info">Recommended width is 1200px. Only JPG/PNG/GIF files allowed. File size must be 2MB or less.  </span><br />
						<?php if($upload_errors!="") { ?><span class="error"><?php echo strip_tags($upload_errors); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td colspan="3">
						<textarea class="wysiwyg_mini" name="description"><?php if(set_value('description')!="") echo set_value('description'); else echo $giveaway['description']; ?></textarea><br />
						<?php if(form_error('description')!="") { ?><span class="error"><?php echo strip_tags(form_error('description')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Legal</td>
					<td colspan="3">
						<textarea class="wysiwyg_mini" name="legal"><?php if(set_value('legal')!="") echo set_value('legal'); else echo $giveaway['legal']; ?></textarea><br />
						<?php if(form_error('legal')!="") { ?><span class="error"><?php echo strip_tags(form_error('legal')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Admin Notes</td>
					<td colspan="3"><textarea class="wysiwyg_mini" name="admin_notes"><?php if(set_value('admin_notes')!="") echo set_value('admin_notes'); else echo $giveaway['admin_notes']; ?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<input type="submit" name="submit" value="Save Changes" class="button_medium"  />
						<input type="submit" name="submit" value="Delete Giveaway" class="button_medium" 
							onclick="return confirm('Confirm delete giveaway: <?php echo $giveaway['title']; ?>?')" />
					</td>
				</tr>
				
			</table>
			</form>
			
			<p class="align_right"><a href="<?php echo site_url('cpanel/giveaways'); ?>">&raquo; Back to Manage Giveaways</a></p>