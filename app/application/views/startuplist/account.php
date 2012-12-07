<?php
@session_start();
if(!$user){
	$user = getWebUser($_SESSION['web_user']);
}
?>
<table cellpadding="0" cellspacing="0" class="p100">
	<tr>
		<td class="contents2">
			<table cellpadding="0" cellspacing="0" class='p100'>
				<tr>
					<td class='breadcrumbs'>
					<a href='<?php echo site_url(); ?>'>Home</a> >
					<?php
					echo "<a href='".site_url()."account/".$user['id']."'>".$user['name']."</a>";
					?>
					</td>
				</tr>
				<tr>
					<td class='account_left'>
						<?php
						if(trim($user['img'])){
							?>
							<table cellpadding="0" cellspacing="0" class="p100">
								<tr>
									<td class='logo'>
										<div><img src='<?php echo $user['img']; ?>' /></div>
									</td>
								</tr>
							</table>
							<?php
						}
						?>
						<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_left' >
							<tr>
								<td class="head">ACCOUNT DETAILS</td>
							</tr>
							<tr>
								<td class="content">
									<table>
										<tr>
											<td class='bold'>
												Name:
											</td>
											<td>
												<?php echo $user['name']; ?>
											</td>
										</tr>
										<tr>
											<td class='bold'>
												E-mail:
											</td>
											<td>
												<?php echo $user['email']; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
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
					<td class='account_right'>
						<?php
						$this->load->view("startuplist/contribute_block");
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>