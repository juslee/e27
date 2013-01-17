			<h3>Create Giveaway</h3>
			<form method="post" action="<?php echo site_url('cpanel/create_giveaway'); ?>" enctype="multipart/form-data">
			<table class="form_area">
				<tr>
					<td width="180">Giveaway Title</td>
					<td colspan="3">
						<input type="text" name="title" class="input_large"  value="<?php echo set_value('title'); ?>" /><br />
						<?php if(form_error('title')!="") { ?><span class="error"><?php echo strip_tags(form_error('title')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Start Date</td>
					<td colspan="3">
						<input type="text" name="start_date" class="input_small date_picker" contenteditable="false"  
							value="<?php echo set_value('start_date'); ?>" /><br />
						<?php if(form_error('start_date')!="") { ?><span class="error"><?php echo strip_tags(form_error('start_date')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>End Date</td>
					<td colspan="3">
						<input type="text" name="end_date" class="input_small date_picker" contenteditable="false" 
							 value="<?php echo set_value('end_date'); ?>"/><br />
						<?php if(form_error('end_date')!="") { ?><span class="error"><?php echo strip_tags(form_error('end_date')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Question</td>
					<td colspan="3">
						<input type="text" name="question" class="input_large" value="<?php echo set_value('question'); ?>" /><br />
						<?php if(form_error('question')!="") { ?><span class="error"><?php echo strip_tags(form_error('question')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Answer</td>
					<td colspan="3">
						<input type="text" name="answer" class="input_large" value="<?php echo set_value('answer'); ?>" /><br />
						<?php if(form_error('answer')!="") { ?><span class="error"><?php echo strip_tags(form_error('answer')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Invalid Answer #1</td>
					<td colspan="3">
						<input type="text" name="invalid_answer_1" class="input_large" value="<?php echo set_value('invalid_answer_1'); ?>" /><br />
						<?php if(form_error('invalid_answer_1')!="") { ?><span class="error"><?php echo strip_tags(form_error('invalid_answer_1')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Invalid Answer #2</td>
					<td colspan="3">
						<input type="text" name="invalid_answer_2" class="input_large" value="<?php echo set_value('invalid_answer_2'); ?>" /><br />
						<?php if(form_error('invalid_answer_2')!="") { ?><span class="error"><?php echo strip_tags(form_error('invalid_answer_2')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Banner</td>
					<td colspan="3">
						<input type="file" name="banner" class="input_large"  /><br />
						<span class="info">Recommended width is 1200px. Only JPG/PNG/GIF files allowed. File size must be 2MB or less.  </span><br />
						<?php if($upload_errors!="") { ?><span class="error"><?php echo strip_tags($upload_errors); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td colspan="3">
						<textarea class="wysiwyg_mini" name="description"><?php echo set_value('description'); ?></textarea><br />
						<?php if(form_error('description')!="") { ?><span class="error"><?php echo strip_tags(form_error('description')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Legal</td>
					<td colspan="3">
						<textarea class="wysiwyg_mini" name="legal"><?php echo set_value('legal'); ?></textarea><br />
						<?php if(form_error('legal')!="") { ?><span class="error"><?php echo strip_tags(form_error('legal')); ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td>Admin Notes</td>
					<td colspan="3"><textarea class="wysiwyg_mini" name="admin_notes"><?php echo set_value('admin_notes'); ?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<input type="submit" value="Save Changes" class="button_medium"  />
						<input type="submit" value="Delete Giveaway" class="button_medium" />
					</td>
				</tr>
				
			</table>
			</form>
			
			<p class="align_right"><a href="<?php echo site_url('cpanel/giveaways'); ?>">&raquo; Back to Manage Giveaways</a></p>