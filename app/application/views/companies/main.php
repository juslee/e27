<script>
jQuery(function(){

	
	
	jQuery("#company_search").autocomplete({
		//define callback to format results
		source: function(req, add){
			//pass request to server
			jQuery.getJSON("<?php echo site_url(); ?>companies/ajax_search", req, function(data) {
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
			self.location = "<?php echo site_url(); ?>companies/edit/"+value;
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			jQuery("#company_search").val(label);
			return false;
		},


	});	
});

function deleteCompany(co_id){
	if(confirm("Are you sure you want to delete this company?")){
		formdata = "id="+co_id;
		jQuery.ajax({
			url: "<?php echo site_url(); ?>/companies/ajax_delete/"+co_id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				jQuery("#tr"+co_id).fadeOut(200);
				self.location = "<?php echo site_url(); ?>companies";
			}
		});
		
	}
}
function searchCompany(){
	self.location = "<?php echo site_url(); ?>companies/search/?search="+jQuery("#search").val();
}
</script>
<center>
Company Search: <input type='text' id='company_search' /> &nbsp; [ <a href="<?php echo site_url(); ?>companies/add" >ADD NEW COMPANY</a> ]
<div class='pad10' ><form action="<?php echo site_url(); ?>/companies/search/" class='inline' >Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' /><input type='button' class='button normal' value='search' onclick='searchCompany()'></form><div class='hint'>Name, E-mail, Website, Twitter Handle, Facebook Page, LinkedIn, Blog URL, Description, Tags</div></div>
</center>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th style="width:20px"></th>
		<th>Company Name</th>
		<th>E-mail Address</th>
		<th>Active</th>
		<th></th>
	</tr>
	<?php
	$t = count($companies);
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentities($companies[$i]['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<!--<td><?php echo htmlentities($companies[$i]['id']); ?></td>-->
			<td style='vertical-align:middle;'><?php if(trim($companies[$i]['logo'])){ ?><img src='<?php echo site_url(); ?>/media/image.php?p=<?php echo $companies[$i]['logo'] ?>&mx=25' /> <?php } ?></td>
			<td><a href="<?php echo site_url(); ?>companies/edit/<?php echo $companies[$i]['id']?>" ><?php echo htmlentities($companies[$i]['name']); ?></a></td>
			<td><?php if(trim($companies[$i]['email_address'])){ echo "<a href=\"mailto:".sanitizeX($companies[$i]['email_address'])."\">".htmlentities($companies[$i]['email_address'])."</a>"; }?></td>
			<td><?php 
					if($companies[$i]['active']==1){
						echo "Yes";
					} 
					else{
						echo "No"; 
					}		
			?></td>
			<td>[ <a href="<?php echo site_url(); ?>companies/edit/<?php echo $companies[$i]['id']?>" >Edit</a> ] 
			[ <a style='color: red; cursor:pointer; text-decoration: underline' onclick='deleteCompany("<?php echo htmlentities($companies[$i]['id']) ?>"); ' >Delete</a> ]</td>
		</tr>
		<?php
	}
	if($pages>0){
		?>
		<tr>
			<td colspan="6" class='center font12' >
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
