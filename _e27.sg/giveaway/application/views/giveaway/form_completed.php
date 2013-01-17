				<a name="formarea"></a>
				<script type="text/javascript">window.location.hash = '#formarea';</script>
				
				<h2>Start Spreading the Word!</h2>
				<p>
					Spread your unique link below to gain points! The person with the most points win the giveaway!
				</p>	
				<table >
				<tr>
						<th>Your Registered Email</th>
						<td>
							<?php echo $registration['email']; ?>
						</td>
					</tr>
					<tr>
						<th>Your Unique URL</th>
						<td>
							<input type="text" id="unique_url" value="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>" readonly="readonly" onclick="document.getElementById('unique_url').select();">
								
						</td>
					</tr>
					<tr>
						<th>Share Now!</th>
						<td>
							<span class="st_facebook_large" displayText="Facebook" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
							<span class="st_twitter_large" displayText="Tweet" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
							<span class="st_googleplus_large" displayText="Google +" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
							<span class="st_linkedin_large" displayText="LinkedIn" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
							<span class="st_email_large" displayText="Email" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
							<span class="st_sharethis_large" displayText="ShareThis" st_url="<?php echo site_url(''.$giveaway['permalink'].'/'.$registration['unique_code']); ?>"></span>
						</td>
					</tr>
					</table>
				</p>