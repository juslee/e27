<?php
@session_start();
if($_SESSION['web_user']||1){
	?>
	<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
		<tr>
			<td class="head">CONTRIBUTE</td>
		</tr>
		<tr>
			<td class="content">
				<table>
					<tr>
						<td class='contribute'>
							<div><a href='<?php echo site_url(); ?>addcompany/about'>Add a Company</a></div>
							<div><a href='<?php echo site_url(); ?>addperson/about'>Add a Person</a></div>
							<div><a href='<?php echo site_url(); ?>addinvestment_org/about'>Add an Investment Organization</a></div>
							<!--
							<div><a href='#'>Add Person</a></div>
							<div><a href='#'>Add Investment Organization</a></div>
							-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
}
?>