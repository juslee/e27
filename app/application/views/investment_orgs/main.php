<script>
jQuery(function(){

	
	
	jQuery("#investment_org_search").autocomplete({
		//define callback to format results
		source: function(req, add){
			//pass request to server
			jQuery.getJSON("<?php echo site_url(); ?>investment_orgs/ajax_search", req, function(data) {
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
			jQuery("#investment_org_search").val(label);
			self.location = "<?php echo site_url(); ?>investment_orgs/edit/"+value;
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			jQuery("#investment_org_search").val(label);
			return false;
		},


	});	
});

function deleteInvestmentOrg(co_id){
	if(confirm("Are you sure you want to delete this investment organization?")){
		formdata = "id="+co_id;
		jQuery.ajax({
			url: "<?php echo site_url(); ?>investment_orgs/ajax_delete/"+co_id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				jQuery("#tr"+co_id).fadeOut(200);
				self.location = "<?php echo site_url(); ?>investment_orgs";
			}
		});
		
	}
}
function searchInvestmentOrg(){
	self.location = "<?php echo site_url(); ?>investment_orgs/search/?search="+jQuery("#search").val()+"&filter="+jQuery("#sfilter").val();
}
</script>
<center>
Investment Organization Search: <input type='text' id='investment_org_search' /> &nbsp; [ <a href="<?php echo site_url(); ?>investment_orgs/add" >ADD NEW INVESTMENT ORGANIZATION</a> ]
<div class='pad10' >
<form action="<?php echo site_url(); ?>investment_orgs/search/" class='inline' >
	Filter: <select name='filter' id='sfilter'>
	<option value="name">Name</option>
	<option value="email_address">E-mail</option>
	<option value="website">Website</option>
	<option value="twitter_username">Twitter Handle</option>
	<option value="facebook">Facebook Page</option>
	<option value="linkedin">LinkedIn</option>
	<option value="blog_url">Blog URL</option>
	<option value="description">Description</option>
	<option value="tags">Tags</option>
	<option value="all" selected="selected">All</option>
	</select>	
	Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' />
	<input type='button' class='button normal' value='search' onclick='searchInvestmentOrg()'>
</form>
<?php
if(trim($filter)){
	?>
	<script>
	jQuery("#sfilter").val("<?php echo sanitizeX($filter); ?>")
	</script>
	<?php
}
?>
<div class='hint hidden'>Name, E-mail, Website, Twitter Handle, Facebook Page, LinkedIn, Blog URL, Description, Tags</div></div>
</center>
<div class='list'>
<table>
	<tr>
		<th style="width:20px"></th>
		<th style="width:20px"></th>
		<th>Investment Org Name</th>
		<th>E-mail Address</th>
		<th>Active</th>
		<th></th>
	</tr>
	<?php
	$t = count($investment_orgs);
	for($i=0; $i<$t; $i++){
		?>
		<tr id="tr<?php echo htmlentities($investment_orgs[$i]['id']); ?>" class="row" >
			<td><?php echo $start+$i+1; ?></td>
			<!--<td><?php echo htmlentities($investment_orgs[$i]['id']); ?></td>-->
			<td style='vertical-align:middle;'><?php if(trim($investment_orgs[$i]['logo'])){ ?><img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $investment_orgs[$i]['logo'] ?>&mx=25' /> <?php } ?></td>
			<td><a href="<?php echo site_url(); ?>investment_orgs/edit/<?php echo $investment_orgs[$i]['id']?>" ><?php echo htmlentities($investment_orgs[$i]['name']); ?></a></td>
			<td><?php if(trim($investment_orgs[$i]['email_address'])){ echo "<a href=\"mailto:".sanitizeX($investment_orgs[$i]['email_address'])."\">".htmlentities($investment_orgs[$i]['email_address'])."</a>"; }?></td>
			<td><?php 
					if($investment_orgs[$i]['active']==1){
						echo "Yes";
					} 
					else{
						echo "No"; 
					}		
			?></td>
			<td>[ <a href="<?php echo site_url(); ?>investment_orgs/edit/<?php echo $investment_orgs[$i]['id']?>" >Edit</a> ] 
			[ <a style='color: red; cursor:pointer; text-decoration: underline' onclick='deleteInvestmentOrg("<?php echo htmlentities($investment_orgs[$i]['id']) ?>"); ' >Delete</a> ]</td>
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
					<select onchange='self.location="?search=<?php echo sanitizeX($search); ?>&filter=<?php echo sanitizeX($filter); ?>&start="+this.value'>
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
