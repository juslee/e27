<?php
@session_start();
$sid = session_id()."_".time();
?>
<script>
function savePerson(){
	jQuery("#savebutton").val("Saving...");
	formdata = jQuery("#person_form").serialize();
	jQuery("#person_form *").attr("disabled", true);
	jQuery.ajax({
		<?php
		if($person['id']){
			?>url: "<?php echo site_url(); ?>/people/ajax_edit",<?php
		}
		else{
			?>url: "<?php echo site_url(); ?>/people/ajax_add",<?php
		}
		?>
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(){
			
		}
	});

}
function deletePerson(id){
	if(confirm("Are you sure you want to delete this person?")){
		formdata = "id="+id;
		jQuery.ajax({
			url: "<?php echo site_url(); ?>/people/ajax_delete/"+id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				self.location = "<?php echo site_url(); ?>/people";
			}
		});
		
	}
}

function refreshProfile(profilepath){
	profilepath = escape(profilepath);
	jQuery("#profilepathhtml").html("<img src='<?php echo site_url(); ?>/media/image.php?p="+profilepath+"&mx=220&_="+(new Date().getTime())+"' />");
	jQuery("#profilepath").val(profilepath);
}

var companies = [];

function companyPreAdd(label, value){
	value = value*1;
	if(companies.indexOf(value)!=-1){
		alert(label+" is already added as this person's company.");
		return false;
	}
	
	jQuery("#companyadd").slideDown(200);
	jQuery("#c_name").html(label);
	jQuery("#c_id").val(value);
}

function delCompany(obj, cid){
	if(confirm("Are you sure you want to delete this company?")){
		cid = cid*1;
		index = companies.indexOf(cid);
		companies.splice(index, 1);
		obj.parentElement.outerHTML = "";
		return true;
	}
	return false;
}

function addCompany(id, name, role, start_date, end_date){
	if(!id){
		return false;
	}
	if(!start_date){
		alert("Must input a start date.");
		return false;
	}
	id = id*1;
	if(companies.indexOf(id)!=-1){
		alert(name+" is already added as this person's company.");
		return false;
	}
	
	companies.push(id);
	jQuery("#companyadd").hide();
	html = jQuery("#companyhtml").html();
	
	html += "<div><input type='hidden' name='c_ids[]' value='"+id+"' />";
	html += "<input type='hidden' name='p_roles[]' value='"+role+"' />";
	html += "<input type='hidden' name='p_start_dates[]' value='"+start_date+"' />";
	html += "<input type='hidden' name='p_end_dates[]' value='"+end_date+"' />";
	
	if(!end_date){
		end_date = "Present";
	}
	else{
		thedate = new Date(end_date);
		thedate.setDate(thedate.getDate());
		end_date = dateFormat(thedate, "mmm dd, yyyy");
	}
	
	thedate = new Date(start_date);
	thedate.setDate(thedate.getDate());
	start_date = dateFormat(thedate, "mmm dd, yyyy");
	
	html += "<a href='<?php echo site_url()?>/companies/edit/"+id+"' target=''>"+name+"</a> - "+role+" ( "+start_date+" to "+end_date+" )&nbsp;&nbsp;&nbsp<a style='cursor:pointer; text-decoration:underline' class='red delete' onclick='delCompany(this, \""+id+"\")' >Delete</a></div>";
	
	
	jQuery("#companyhtml").html(html);
}

jQuery(function(){
	jQuery('#profile_image').uploadify({
		'uploader'  : '<?php echo site_url(); ?>media/js/uploadify/uploadify.swf',
		'script'    : '<?php echo site_url(); ?>media/js/uploadify/uploadify.php',
		'cancelImg' : '<?php echo site_url(); ?>media/js/uploadify/cancel.png',
		'folder'    : '<?php
			$folder = dirname(__FILE__)."/../../../media/uploads/";
			if(!is_dir($folder)){
				mkdir($folder, 0777);
			}
			$folder = dirname(__FILE__)."/../../../media/uploads/people/";
			if(!is_dir($folder)){
				mkdir($folder, 0777);
			}
			if($person['id']){
				$folder = dirname(__FILE__)."/../../../media/uploads/people/".$person['id'];
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/people/".$person['id']."/profile_image";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
			}
			else{
				$folder = dirname(__FILE__)."/../../../media/uploads/people/temp";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/people/temp/".$sid ;
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/people/temp/".$sid."/profile_image";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
			}
			echo str_replace(dirname(__FILE__)."/../../..", "", $folder);
		?>',
		'auto'      : true,
		'multi'       : false,
		'onComplete'  : function(event, ID, fileObj, response, data) {
		  //alert('There are ' + data.fileCount + ' files remaining in the queue.');
		  str = "";
		  for(x in fileObj){
		  	str += x+"\n";
		  }
		  //alert(str);
		  //alert(fileObj.filePath);		  
		  profilepath = "<?php echo site_url(); ?>"+fileObj.filePath;
		  refreshProfile(profilepath);
		}	
	});
	
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
			jQuery("#company_search").val("");
			companyPreAdd(label, value);
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
</script>
<form id='person_form'>

<?php
if($person['id']){
	?>
	<input type='hidden' name='id' id='person_id' >
	<?php
}
else{
	?>
	<input type='hidden' name='sid' value="<?php echo sanitizeX($sid); ?>">
	<?php
}


?>
<table width="100%" cellpadding="10px">
<!--
<tr>
<td colspan="2" class='center bold font14'>Fields with * are required.</td>
</tr>
-->
<tr>
<td width='50%'> 
  <table width="100%">
  <?php
	if(!$person['id']){
		?>
		<tr>
		<td class='font18 bold'>Add New Person</td>
		<td></td>
		</tr>
		<?php
	}
	else{
		?>
		<tr>
		<td class='font18 bold'>Edit Person</td>
		<td></td>
		</tr>
		<?php
	}
	?>
    <tr class="odd required">
      <td>* Name:</td>
      <td><input type="text" name="name" size="40" id='person_name'><div class='inline' style='padding-left:5px;' id='co_check'></div></td>
    </tr>
    <tr class="even">
      <td>* Description:</td>
      <td><textarea name="description"></textarea></td>
    </tr>		
    <tr class="odd required">
      <td>* Email Address: </td>
      <td><input type="text" name="email_address" size="35"></td>
    </tr>	
    <tr class="even">
      <td>Blog URL:</td>
      <td><input type="text" name="blog" size="30">
        <div class='hint'>e.g. http://feeds.feedsburner.com/e27/Kabk</div></td>
    </tr>
    <tr class="odd">
      <td>Twitter Username:</td>
      <td><input type="text" name="twitter_username" size="25">
        <div class='hint'>e.g. @kiip</div></td>
    </tr>
    <tr class="even">
      <td>Facebook Page:</td>
      <td><input type="text" name="facebook" size="35">
        <div class='hint'>e.g. http://facebook.com/yourpagename</div></td>
    </tr>
    <tr class="odd">
      <td>LinkedIn Page:</td>
      <td><input type="text" name="linkedin" size="35">
        <div class='hint'>e.g. http://linkedin.com/yourpagename</div></td>
    </tr>

    <tr class="even">
      <td>Profile Image:</td>
      <td>
	  <div id='profilepathhtml'></div>
	  <input type='hidden' id='profilepath' name='profile_image' />
	  <input type='text' id="profile_image" />
	  <input type='button' class='button' value='Upload' onclick="jQuery('#profile_image').uploadifyUpload();" >
	  <br><div class='hint'>e.g. Image Suggestion 220 x 220 pixels .jpg file</div>
	  </td>
    </tr>
    <tr class="odd">
      <td>Tags:</td>
      <td><textarea name="tags" ></textarea>
      <br/>
      <div class='hint'>multiple tags must be comma separated. e.g. company,person,power</div>
      </td>
    </tr>    
    <tr class="even">
      <td>Active?</td>
      <td><input type="checkbox" name="active" value="1" checked="checked" />
      </td>
    </tr>
  </table>
</td>
<td width='50%'>
	<table width="100%">
		<tr class="odd">
		  <td>Companies:</td>
		  <td>
		  <input type="text" size: "30" id="company_search" /><div class='hint'>Type in the company name to search and add a company.</div>
		  <div id='companyadd' style='display:none'>
		  	<input type='hidden' id='c_id' />
		  	<table class='border margin10 pad10'>
				<tr>
					<td>Company Name:</td>
					<td id='c_name'></td>
				</tr>
				<tr>
					<td>Role:</td>
					<td><input type='text' id='p_role' /></td>
				</tr>
				<tr>
					<td>Start Date:</td>
					<td><input type='text' id='p_start_date' class='datepicker' /><div class='hint'>mm/dd/yyyy</div></td>
				</tr>
				<tr>
					<td>End Date:</td>
					<td><input type='text' id='p_end_date' class='datepicker' /><div class='hint'>mm/dd/yyyy (leave blank if present)</div></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type='button' value='Add Company' class='button' onclick='addCompany(jQuery("#c_id").val(), jQuery("#c_name").html(), jQuery("#p_role").val(), jQuery("#p_start_date").val(), jQuery("#p_end_date").val())' >&nbsp;
					<input type='button' value='Cancel' class='button' onclick='jQuery("#companyadd").hide()' /></td>
				</tr>
			</table>
		  </div>
			<div class='margin10 pad10'>
			  <div id='companyhtml' \>
			  </div>
			</div>
		  </td>
		</tr>
		
		<tr class="even">
		  <td>Funding:</td>
		  <td></td>
		</tr>
		<!--<tr>
		  <td></td>
		  <td><select>
			  <option value="Seed">Seed</option>
			  <option value="Angel">Angel</option>
			  <option value="Series A">Series A</option>
			  <option value="Series B">Series B</option>
			  <option value="Series C">Series C</option>
			  <option value="Series D">Series D</option>
			  <option value="Series E">Series E</option>
			  <option value="Series F">Series F</option>
			  <option value="Series G">Series G</option>
			  <option value="Series H">Series H</option>
			  <option value="Grant">Grant</option>
			  <option value="Debt">Debt</option>
			  <option value="Venture Round">Venture Round</option>
			  <option value="Post IPO Equity">Post IPO Equity</option>
			  <option value="Post IPO Debt">Post IPO Debt</option>
			</select></td>
		</tr>
		<td></td>
		  <td>Amount</td>
		<tr>
		  <td></td>
		  <td><select>
			  <option value="PHP">PHP</option>
			  <option value="YEN">YEN</option>
			  <option value="SGD">SGD</option>
			</select>
			&nbsp;
			<input type="text"/>
		  </td>
		</tr>
		<td></td>
		  <td>Date of Funding</td>
		<tr>
		  <td></td>
		  <td><?php
			// lowest year wanted
			$cutoff = 1910;
	
			// current year
			$now = date('Y');
	
			// build years menu
			echo '<select>' . PHP_EOL;
			for ($y=$now; $y>=$cutoff; $y--) {
				echo '  <option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
			}
			echo '</select>' . PHP_EOL;
	
			// build months menu
			echo '<select>' . PHP_EOL;
			for ($m=1; $m<=12; $m++) {
				echo '  <option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
			}
			echo '</select>' . PHP_EOL;
	
			// build days menu
			echo '<select>' . PHP_EOL;
			for ($d=1; $d<=31; $d++) {
				echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
			}
			echo '</select>' . PHP_EOL;
			?>
		  </td>
		</tr>
		<td></td>
		  <td>Type of Investor:</td>
		<tr>
		  <td></td>
		  <td><select>
			  <option value="Company">Company</option>
			  <option value="Person">Person</option>
			  <option value="Investment Organization">Investment Organization</option>
			</select>
			&nbsp;
			<input type="text"  size="30" />
		  </td>
		</tr>
		-->
	</table>
</tr>
<tr>
	<td colspan="2" class='center'>
		<input type="button" id='savebutton' value="Save" onclick="savePerson()" style='height:40px' />
		<!--<input type="button" value="Back to Company List" onclick="self.location='<?php echo site_url(); ?>companies'" />-->
		<?php 
		if($person['id']){
			?><input type="button" style='background:red; color:white' value="Delete" onclick="deletePerson('<?php echo $person['id']; ?>')" /><?php
		}
		?>
	</td>
</tr>
</td>
</table>
<?php

if($person['id']){
	?>
	<script>
		<?php 
		if(is_array($companies)){
			foreach($companies as $value){
				?>
				addCompany(<?php echo $value['company_id']?>, "<?php echo $value['name']?>", "<?php echo $value['role']?>", "<?php echo $value['start_date']?>", "<?php echo $value['end_date']?>");
				<?php
			}
		}
		foreach($person as $key=>$value){
			if($key=="profile_image"&&trim($value)){
				?>
				jQuery('#profilepath').val("<?php echo sanitizeX($value); ?>");
				jQuery("#profilepathhtml").html("<img src='<?php echo site_url(); ?>/media/image.php?p=<?php echo $value ?>&mx=220' />");
				<?php
			}
			else if($key=="active"){
				if($value=="1"){
					?>
					jQuery('[name="<?php echo $key; ?>"]').attr("checked", true);
					<?php
				}
				else{
					?>
					jQuery('[name="<?php echo $key; ?>"]').attr("checked", false);
					<?php
				}
			}
			else{
				?>
				jQuery('[name="<?php echo $key; ?>"]').val("<?php echo sanitizeX($value); ?>");
				<?php
			}
		}
		?>	
	</script>
	<?php
}
?>
</form>
