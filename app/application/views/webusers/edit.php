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
<script>
function saveWebuser(){
	extra = "?id=<?php echo $web_user['id']; ?>";
	jQuery("#savebutton").val("Saving...");
	formdata = jQuery("#webuser_form").serialize();
	jQuery("#webuser_form *").attr("disabled", true);
	jQuery.ajax({
		url: "<?php echo site_url(); ?>webusers/ajax_editwebuser"+extra,
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(){
			
		}
	});
}
</script>
<form id='webuser_form'>
<table width="100%" cellpadding="10px">
	<tr>
		<td class="font18 bold">Edit Web user - <a href="<?php echo site_url()?>account/<?php echo $web_user['id']; ?>" class="font16 bold">Click here to preview</a></td>
	</tr>
	<tr>
		<td width='70%'>
			<table width="100%">
				<tr class="odd">
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
				<tr class="even">
				  <td>E-mail:</td>
				  <td>
				  <?php
				  	if(trim($web_user['fb_id'])!=""){
						echo $web_user['fb_email'];
					}
					else{
						?>
						<input type='text' style='width:300px;' name='email' value="<?php echo htmlentitiesX($web_user['email']); ?>" />
						<?php
					}
				  ?>
				  </td>
				</tr>
				<tr class="odd">
				  <td>Name:</td>
				  <td>
				  <?php
				  	if(trim($web_user['fb_id'])!=""){
						echo $web_user['name'];
					}
					else if(trim($web_user['in_id'])!=""){
						echo $web_user['name'];
					}
					else{
						?>
						<input type='text' style='width:300px;' name='name' value="<?php echo htmlentitiesX($web_user['name']); ?>" />
						<?php
					}
				  	
				  ?>
				  </td>
				</tr>
				<tr class="even">
				  <td>Twitter:</td>
				  <td>
					<input type='text' style='width:300px;' name='twitter' value="<?php echo htmlentitiesX($web_user['homepage']); ?>" />
				  </td>
				</tr>
				<tr class="odd">
				  <td>Homepage:</td>
				  <td>
					<input type='text' style='width:300px;' name='homepage' value="<?php echo htmlentitiesX($web_user['twitter']); ?>" />
				  </td>
				</tr>
				<?php
					if(trim($web_user['fb_id'])==""&&trim($web_user['in_id'])==""){
						?>
						<tr class="even">
						  <td>Password:</td>
						  <td>
							<input type='text' style='width:300px;' name='password' placeholder='Input value to change password.' value="<?php echo htmlentitiesX($web_user['twitter']); ?>" />
						  </td>
						</tr>
						<?php
					}
				?>
				<tr class="odd">
				  <td colspan="2" align="center" style='padding:10px'>
					<input type='button' value="  Save  " id='savebutton' onclick='saveWebuser()' />
				  </td>
				</tr>
			</table>
		</td>
		
		<td>
		</td>
		
	</tr>
</table>
</form>