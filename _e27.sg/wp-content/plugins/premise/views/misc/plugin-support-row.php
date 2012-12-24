<tr id="premise-plugin-support-row">
	<td colspan="<?php echo $count; ?>">
		<?php if($valid) { ?>
		<h3 style="margin-top: 0;"><?php _e('Get Support', 'premise' ); ?></h3>
		<div>
			<p><?php _e('Need to get support for Premise?  Please fill in your name, email address, and a brief description of the problem and we\'ll get back to you as soon as possible.', 'premise' ); ?></p>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="premise-support-your-name"><?php _e('Your Name', 'premise' ); ?></label></th>
						<td>
							<input type="text" class="text regular-text" name="premise-support[your-name]" id="premise-support-your-name" value="" autocomplete="false" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="premise-support-your-email"><?php _e('Your Email', 'premise' ); ?></label></th>
						<td>
							<input type="text" class="text regular-text" name="premise-support[your-email]" id="premise-support-your-email" value="" autocomplete="false" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="premise-support-your-problem"><?php _e('Your Issue', 'premise' ); ?></label></th>
						<td>
							<textarea class="large-text" row="6" name="premise-support[your-problem]" id="premise-support-your-problem"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<?php wp_nonce_field('premise-support-submit-request', 'premise-support-submit-request-nonce'); ?>
				<input type="submit" class="button button-primary" name="premise-support-submit-request" id="premise-support-submit-request" value="<?php _e('Submit Support Request', 'premise' ); ?>" />
			</p>
		</div>
		<?php } else { ?>
		<p><?php printf(__('You must have entered a valid API key to request support.  Please <a href="%s">enter one now</a>.', 'premise' ), admin_url('admin.php?page=premise-main')); ?></p>
		<?php } ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#premise-plugin-support-row').hide();
			$('#premise-support-dropdown').click(function(event) {
				event.preventDefault();
				
				$('#premise-plugin-support-row').toggle();
			});
		});
		</script>
	</td>
</tr>