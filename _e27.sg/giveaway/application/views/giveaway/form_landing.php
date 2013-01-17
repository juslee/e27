				<h2>Register Today!</h2>
				<p>
					Answer a simple question below to get started!
				</p>	
				<form method="post" action="<?php echo site_url(''.$giveaway['permalink'].'/'.$referrer_id); ?>">
				<table >
					<tr>
						<th>Email Address</th>
						<td>
							<input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
							<?php if(form_error('email')!="") { ?><span class="error"><?php echo strip_tags(form_error('email')); ?></span><?php } ?>

						</td>
					</tr>
					<tr>
						<th>The Question</th>
						<td>
							<?php echo $giveaway['question']; ?>
						</td>
					</tr>
					<tr>
						<th>Your Answer</th>
						<td>
							<select name="answer" >
								<option value="">Select an Answer</option>
								<?php
									// Store and randomize answer choices
									$answers=array();
									$answers[0]=$giveaway['answer'];
									$answers[1]=$giveaway['invalid_answer_1'];
									$answers[2]=$giveaway['invalid_answer_2'];
									shuffle($answers);
									
									foreach($answers as $answer) {
								?>
								<option value="<?php echo $answer; ?>" 
									<?php echo set_select('answer',$answer); ?>>
									<?php echo $answer; ?></option>
								<?php } ?>
							</select><br />
							<?php if(form_error('answer')!="") { ?><span class="error"><?php echo strip_tags(form_error('answer')); ?></span><?php } ?>

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
				<p><a href="<?php echo site_url(''.$giveaway['permalink'].'/'.$referrer_id.'/check'); ?>">&raquo; Click here to check your results</a></p>