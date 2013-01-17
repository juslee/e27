				<a name="formarea"></a>
				<script type="text/javascript">window.location.hash = '#formarea';</script>

				<h2>Check Your Results!</h2>
				<p>
					Type in your email address below to check your current rank and score.
				</p>	
				<form method="post" action="<?php echo site_url(''.$giveaway['permalink'].'/'.$referrer_id.'/check'); ?>">
				<table >
					<tr>
						<th>Email Address</th>
						<td>
							<input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
							<?php if(form_error('email')!="") { ?><span class="error"><?php echo strip_tags(form_error('email')); ?></span><?php } ?>

						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="submit" value="Check Results" class="button_medium" />
						</td>
					</tr>
				</table>
				</p>
				</form>	
				<p><a href="<?php echo site_url($giveaway['permalink'].'/'.$referrer_id); ?>">&raquo; Click here to return to registration</a></p>