<script>
jQuery(function(){
	jQuery("#people_search").autocomplete({
		//define callback to format results
		source: function(req, add){
			//pass request to server
			jQuery.getJSON("<?php echo site_url(); ?>people/ajax_search", req, function(data) {
				//create array for response objects
				var suggestions = [];
				//process response
				jQuery.each(data, function(i, val){								
					suggestions.push(val);
				});
				//pass array to callback
				add(suggestions);
			});
		},
		//define select handler
		select: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			jQuery("#company_search").val(label);
			self.location = "<?php echo site_url(); ?>people/edit/"+value;
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			jQuery("#people_search").val(label);
			return false;
		},


	});	
});

function deletePerson(person_id){
	if(confirm("Are you sure you want to delete this person?")){
		formdata = "id="+person_id;
		jQuery.ajax({
			url: "<?php echo site_url(); ?>/people/ajax_delete/"+person_id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				jQuery("#tr"+person_id).fadeOut(200);
				self.location = "<?php echo site_url(); ?>people";
			}
		});
		
	}
}
function searchPeople(){
	self.location = "<?php echo site_url(); ?>people/search/?search="+jQuery("#search").val();
}
</script>
<center>
Person Search: <input type='text' id='people_search' /> &nbsp; [ <a href="<?php echo site_url(); ?>people/add" >ADD NEW PERSON</a> ]
<div class='pad10' ><form action="<?php echo site_url(); ?>people/search/" class='inline' >Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' /><input type='button' class='button' value='search' onclick='searchPeople()'></form><div class='hint'>Name, E-mail address, Twitter Handle, Facebook Page, LinkedIn, Blog URL, Description, Tags</div></div>
</center>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th style="width:20px"></th>
		<th>Name</th>
		<th>E-mail Address</th>
		<th>Current Company</th>
		<th>Current Role</th>
		<th>Active</th>
		<th></th>
	</tr>
	<?php
	$t = count($people);
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentities($people[$i]['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<td style='vertical-align:middle;'><?php if(trim($people[$i]['profile_image'])){ ?><img src='<?php echo site_url(); ?>/media/image.php?p=<?php echo $people[$i]['profile_image'] ?>&mx=25' /> <?php } ?></td>
			<td><a href="<?php echo site_url(); ?>people/edit/<?php echo $people[$i]['id']?>" ><?php echo htmlentities($people[$i]['name']); ?></a></td>
			<td><?php if(trim($people[$i]['email_address'])){ echo "<a href=\"mailto:".sanitizeX($people[$i]['email_address'])."\">".htmlentities($people[$i]['email_address'])."</a>"; }?></td>
			<td><?php echo $current_company; ?></td>
			<td><?php echo $current_role; ?></td>
			<td><?php 
					if($people[$i]['active']==1){
						echo "Yes";
					} 
					else{
						echo "No"; 
					}		
			?></td>
			<td>[ <a href="<?php echo site_url(); ?>people/edit/<?php echo $people[$i]['id']?>" >Edit</a> ] 
			[ <a style='color: red; cursor:pointer; text-decoration: underline' onclick='deletePerson("<?php echo htmlentities($people[$i]['id']) ?>"); ' >Delete</a> ]</td>
		</tr>
		<?php
	}
	if($pages>0){
		?>
		<tr>
			<td colspan="8" class='center font12' >
				There is a total of <?php echo $cnt; ?> <?php if($cnt>1) { echo "records"; } else{ echo "record"; }?> in the database. 
				Go to Page:
				<?php
				if($search){
					?>
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&start="+this.value'>
					<?php

				}
				else{
					?>
					<select onchange='self.location="?start="+this.value'>
					<?php
				}
				for($i=0; $i<$pages; $i++){
					if(($i*$limit)==$start){
						?><option value="<?php echo $i*$limit?>" selected="selected"><?php echo $i+1; ?></option><?php
					}
					else{
						?><option value="<?php echo $i*$limit?>"><?php echo $i+1; ?></option><?php
					}
				}
				?>
				</select>
			</td>
		</tr>
		<?php
	}
	?>
</table>
</div>
