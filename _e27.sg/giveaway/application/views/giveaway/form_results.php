				<a name="formarea"></a>
				<script type="text/javascript">window.location.hash = '#formarea';</script>

				<h2>Your Latest Results!</h2>
				<p>
					Check your latest results below.
				</p>	
				<table >
					<tr>
						<th>Your Current Rank</th>
						<td>
							<?php echo number_format($rank,0); ?> out of <?php echo number_format($stats['total_signups'],0); ?> with <?php echo number_format($registration['signups'],0); ?> signups.
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
				<p><a href="<?php echo site_url(''.$giveaway['permalink'].'/'.$referrer_id); ?>">&raquo; Click here to return to registration</a></p>