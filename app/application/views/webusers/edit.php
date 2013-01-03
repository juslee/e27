<?php
/*
Array
(
    [id] => 13
    [email] => jairus@nmgresources.ph
    [password] => 0987b2c275e5d366480a9774a5050137
    [plain_password] => jaijai
    [name] => Jairus Bondoc
    [twitter] => 
    [homepage] => 
    [fb_id] => 
    [fb_email] => 
    [fb_data] => 
    [fb_friends] => 
    [in_name] => 
    [in_data] => 
    [dateadded] => 2012-12-20 15:47:15
    [dateupdated] => 0000-00-00 00:00:00
)
*/

?>

<table width="100%" cellpadding="10px">
	<tr>
		<td class="font18 bold">Edit Web user - <a href="<?php echo site_url()?>account/<?php echo $web_user['id']; ?>" class="font16 bold">Click here to preview</a></td>
	</tr>
	<tr>
		<td width='50%'>
			<table width="100%">
				<tr class="odd required">
				  <td>Type:</td>
				  <td>
				  <?php
				  	if(trim($web_user['fb_id'])!=""){
						echo "Facebook";
					}
					else if(trim($web_user['in_id'])!=""){
						echo "LinkedIn";
					}
					else{
						echo "Account";
					}
				  ?>
				  </td>
				</tr>
			</table>
		</td>
		
		<td>
		</td>
		
	</tr>
</table>