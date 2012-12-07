<?php
@session_start();
$user = getWebUser($_SESSION['web_user']);
?>
<table cellpadding="0" cellspacing="0" class="p100">
	<tr>
		<td class="contents2">
			<table cellpadding="0" cellspacing="0" class='p100'>
				<tr>
					<td class='breadcrumbs'>
					<a href='<?php echo site_url(); ?>'>Home</a> >
					<?php
					echo "<a href='".site_url()."account'>".$user['name']."</a>";
					?>
					</td>
				</tr>
				<tr>
					<td class='account_left'>left</td>
					<td class='account_center'>
						<table cellpadding="0" cellspacing="0" class="p100">
							<tr>
								<td class="account_head">
									Your Recent Edits
								</td>
							</tr>
							<tr>
								<td class="description">
									...
								</td>
							</tr>
						</table>
					</td>
					<td class='account_right'>right</td>
				</tr>
			</table>
		</td>
	</tr>
</table>