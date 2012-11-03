<?php
@session_start();
$sid = session_id()."_".time();
?>
<script>
function saveInvestmentOrg(){
	jQuery("#savebutton").val("Saving...");
	formdata = jQuery("#investment_org_form").serialize();
	jQuery("#investment_org_form *").attr("disabled", true);
	jQuery.ajax({
		<?php
		if($investment_org['id']){
			?>url: "<?php echo site_url(); ?>investment_orgs/ajax_edit",<?php
		}
		else{
			?>url: "<?php echo site_url(); ?>investment_orgs/ajax_add",<?php
		}
		?>
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(){
			
		}
	});

}
function deleteInvestmentOrg(io_id){
	if(confirm("Are you sure you want to delete this investment organization?")){
		formdata = "id="+io_id;
		jQuery.ajax({
			url: "<?php echo site_url(); ?>companies/ajax_delete/"+io_id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				self.location = "<?php echo site_url(); ?>investment_orgs";
			}
		});
		
	}
}

function checkInvestmentOrg(io_name){
	if(jQuery.trim(io_name)){
		formdata = "name="+io_name;
		<?php
			if($investment_org['id']){
				?>formdata += "&id=<?php echo $investment_org['id']; ?>";<?php
			}
		?>
		jQuery("#io_check").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
		
		jQuery.ajax({
			url: "<?php echo site_url(); ?>investment_orgs/ajax_check_investment_org",
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				
			}
		});
	}
	else{
		jQuery("#io_check").html("");
	}
	
}

function refreshLogo(logopath){
	logopath = escape(logopath);
	jQuery("#logopathhtml").html("<img src='<?php echo site_url(); ?>media/image.php?p="+logopath+"&mx=220&_="+(new Date().getTime())+"' />");
	jQuery("#logopath").val(logopath);
}

var people = []; 

function delPerson(obj, pid){
	if(confirm("Are you sure you want to delete this person?")){
		pid = pid*1;
		index = people.indexOf(pid);
		people.splice(index, 1);
		obj.parentElement.parentElement.outerHTML = "";
		return true;
	}
	return false;
}

function addPersonShortcut(name){
	jQuery("#people_search").attr("disabled", true);
	jQuery("#person_add_loader").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
	jQuery.ajax({
		url: "<?php echo site_url(); ?>people/ajax_add_person_shortcut",
		type: "POST",
		data: "name="+escape(name),
		dataType: "script",
		success: function(data){
			
		}
	});
}

function peoplePreAdd(label, value){
	value = value*1;
	if(people.indexOf(value)!=-1){
		alert(label+" is already part of this investment organization.");
		return false;
	}
	
	jQuery("#peopleadd").slideDown(200);
	jQuery("#p_name").html(label);
	jQuery("#p_id").val(value);
	
	
}
function addPerson(id, name, role, start_date, end_date, add){
	if(!id){
		return false;
	}
	if(!start_date){
		alert("Must input a start date.");
		return false;
	}
	id = id*1;
	if(people.indexOf(id)!=-1){
		alert(name+" is already part of this investment organization.");
		return false;
	}
	
	people.push(id);
	jQuery("#peopleadd").hide();
	html = "";
	
	if(add){
		html += "<tr class='lightgreen'><td><input type='hidden' name='p_ids[]' value='"+id+"' />";
	}
	else{
		html += "<tr><td><input type='hidden' name='p_ids[]' value='"+id+"' />";
	}

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
	
	html += "<a href='<?php echo site_url()?>people/edit/"+id+"' target=''>"+name+"</a></td><td>"+role+"</td><td>"+start_date+" to "+end_date+"</td><td><a style='cursor:pointer; text-decoration:underline' class='red delete' onclick='delPerson(this, \""+id+"\")' >Delete</a></td></tr>";
	
	htmlorig = jQuery("#peoplehtml table tbody").html();
	
	if(add){
		html = html + htmlorig;
	}
	else{
		html = htmlorig + html;
	}
	
	jQuery("#peoplehtml table tbody").html(html);
}


jQuery(function(){

	jQuery("#io_name").blur(function(){
		checkInvestmentOrg(jQuery("#io_name").val());
	});
	
	jQuery('#io_logo').uploadify({
		'uploader'  : '<?php echo site_url(); ?>media/js/uploadify/uploadify.swf',
		'script'    : '<?php echo site_url(); ?>media/js/uploadify/uploadify.php',
		'cancelImg' : '<?php echo site_url(); ?>media/js/uploadify/cancel.png',
		'folder'    : '<?php
			$folder = dirname(__FILE__)."/../../../media/uploads/";
			if(!is_dir($folder)){
				mkdir($folder, 0777);
			}
			$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/";
			if(!is_dir($folder)){
				mkdir($folder, 0777);
			}
			if($person['id']){
				$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/".$person['id'];
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/".$person['id']."/logo";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
			}
			else{
				$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/temp";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/temp/".$sid ;
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = dirname(__FILE__)."/../../../media/uploads/investment_orgs/temp/".$sid."/logo";
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
		  logopath = "<?php echo site_url(); ?>"+fileObj.filePath;
		  refreshLogo(logopath);
		}	
	});
	
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
				val = [];
				val.label = "Create";
				val.value = -1;
				suggestions.push(val);
				//pass array to callback
				add(suggestions);
			});
		},
		//define select handler
		select: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			
			if(value!=-1){
				jQuery("#people_search").val("");
				peoplePreAdd(label, value);
			}
			else{
				addPersonShortcut(this.value);
			}
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			if(value!=-1){
				jQuery("#people_search").val(label);
			}
			return false;
		},
		search: function(e, ui) {
			jQuery("#tempcreatelabel").val( jQuery(this).val());
		}
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
		value = item.value;
		label = item.label;
		append = "";
		if(item.value==-1){
			append = "<div class='additem'>"+label+" '"+jQuery("#tempcreatelabel").val()+"'</div>";
			return $( "<li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + append + "</a>")
				.appendTo( ul );
		}
		else{
			if(item.desc){
				append = "<div class='more'>" + item.desc + "</div>";
			}
			return $( "<li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.label + append + "</a>")
				.appendTo( ul );
		}
		
	};
	
});
</script>
<input type='hidden' id='tempcreatelabel' />
<form id='investment_org_form'>

<?php
if($investment_org['id']){
	?>
	<input type='hidden' name='id' id='io_id' >
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
<?php
if(!$investment_org['id']){
	?>
	<tr>
	<td class='font18 bold' colspan="2">Add New Investment Organization</td>
	</tr>
	<?php
}
else{
	?>
	<tr>
	<td class='font18 bold' colspan="2">Edit Investment Organization</td>
	<td></td>
	</tr>
	<?php
}
?>
<tr>
<td width='50%'> 
  <table width="100%">

    <tr class="odd required">
      <td>* Name:</td>
      <td><input type="text" name="name" size="40" id='io_name'><div class='inline' style='padding-left:5px;' id='io_check'></div></td>
    </tr>
    <tr class="even required">
      <td>* Description:</td>
      <td><textarea name="description"></textarea></td>
    </tr>
	 <tr class="odd">
      <td>* E-mail Address: </td>
      <td><input type="text" name="email_address" size="35"></td>
    </tr>
    <tr class="even">
      <td>Website: </td>
      <td><input type="text" name="website" size="30">
        <div class='hint'>e.g. http://www.yourcompany.com</div></td>
    </tr>
    <tr class="odd">
      <td>Blog URL:</td>
      <td><input type="text" name="blog" size="30">
        <div class='hint'>e.g. http://feeds.feedsburner.com/e27/Kabk</div></td>
    </tr>
    <tr class="even">
      <td>Twitter Username:</td>
      <td><input type="text" name="twitter_username" size="25">
        <div class='hint'>e.g. @kiip</div></td>
    </tr>
    <tr class="odd">
      <td>Facebook Page:</td>
      <td><input type="text" name="facebook" size="35">
        <div class='hint'>e.g. http://facebook.com/yourpagename</div></td>
    </tr>
    <tr class="even">
      <td>LinkedIn Page:</td>
      <td><input type="text" name="linkedin" size="35">
        <div class='hint'>e.g. http://linkedin.com/yourpagename</div></td>
    </tr>
    <tr class="odd">
      <td>Number of Employees: </td>
      <td><input type="text" name="number_of_employees" size="5"></td>
    </tr>
   
    <tr class="even">
      <td>Year Founded:</td>
      <td>
	  	<input type='text' class='datepicker' alt='founded' id='founded_pick' name='founded' /><div class='hint'>mm/dd/yyyy</div>
      </td>
    </tr>
    <tr class="odd">
      <td>Logo:</td>
      <td>
	  <div id='logopathhtml'></div>
	  <input type='hidden' id='logopath' name='logo' />
	  <input type='text' id="io_logo" />
	  <input type='button' class='button normal' value='Upload' onclick="jQuery('#io_logo').uploadifyUpload();" >
	  <br><div class='hint'>e.g. Image Suggestion 220 x 220 pixels .jpg file</div>
	  </td>
    </tr>
    <tr class="even">
      <td>Country:</td>
      <td><select name="country">
      <?php
	  	foreach($countries as $value){
			if(strtolower(trim($value['country']))=="singapore"){
				?>
				<option selected="selected" value="<?php echo sanitizeX($value['country']); ?>"><?php echo sanitizeX($value['country']); ?></option>
				<?php
			}
			else{
				?>
				<option value="<?php echo sanitizeX($value['country']); ?>"><?php echo sanitizeX($value['country']); ?></option>
				<?php
			}
		}
	  ?>
        </select>
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
      <td>Status:</td>
      <td><select name="status">
          <option value="Live">Live</option>
          <option value="Closed">Closed</option>
        </select>
      </td>
    </tr>
    <tr class="odd">
      <td>Active?</td>
      <td><input type="checkbox" name="active" value="1" checked="checked" />
      </td>
    </tr>
  </table>
</td>
<td width='50%'>
	<table width="100%">
		<tr class="odd">
		  <td>People:</td>
		  <td>
		  <input type="text" size: "30" id="people_search" /><div class='inline' id='person_add_loader'></div><div class='hint'>Type in the name to search and add people.</div>
		  <div id='peopleadd' style='display:none'>
		  	<input type='hidden' id='p_id' />
		  	<table class='border margin10 pad10'>
				<tr>
					<td>Name:</td>
					<td id='p_name'></td>
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
					<td colspan="2" align="center"><input type='button' value='Add Person' class='button normal' onclick='addPerson(jQuery("#p_id").val(), jQuery("#p_name").html(), jQuery("#p_role").val(), jQuery("#p_start_date").val(), jQuery("#p_end_date").val(), true)' >&nbsp;
					<input type='button' value='Cancel' class='button normal' onclick='jQuery("#peopleadd").hide()' /></td>
				</tr>
			</table>
		  </div>
		  <div class='margin10 pad10'>
		  	<div id='peoplehtml'><table cellspacing=0><tbody></tbody></table></div>
		  </div>
		  </td>
		</tr>
		<tr class="even">
		  <td>Investments:</td>
		  <td>
		  	<div class='margin10 pad10'>
		  		<div id='milestoneshtml'>
				<?php
				if(is_array($milestones)){
					?><table cellspacing=0><?php
					foreach($milestones as $value){
						echo "<tr>";
						?><td><a href="<?php echo site_url()?>companies/edit/<?php echo $value['company_id']; ?>"><?php echo $value['company_name']; ?></a></td><?php
						?><td><?php echo ucfirst($value['round']) ?></td><?php
						?><td><?php echo $value['currency']; ?> <?php echo number_format($value['amount'],2); ?></td><?php
						?><td><?php echo date("M d, Y", $value['date_ts']); ?></td><?php
						echo "</tr>";
					}
					?></table><?php
				}
				?>
				</div>
			</div>
		  </td>
		</tr>
	</table>
</tr>
<tr>
	<td colspan="2" class='center'>
		<table width='100%'>
		<tr>
		<td width='100%'><input type="button" id='savebutton' value="Save" onclick="saveInvestmentOrg()" /></td>
		<?php 
		if($investment_org['id']){
			?><td><input type="button" style='background:red; color:white' value="Delete" onclick="deleteInvestmentOrg('<?php echo $investment_org['id']; ?>')" /></td><?php
		}
		?>
		</tr>
		</table>
	</td>
</tr>
</td>
</table>
<?php

if($investment_org['id']){
	?>
	<script>
		<?php 
		
		if(is_array($screenshots)){
			?>
			html = "";
			<?php
			foreach($screenshots as $value){
				?>
				filepath = "<?php echo sanitizeX($value['screenshot']); ?>";
				ss.push(filepath);
				file = "<?php echo sanitizeX(urldecode(basename($value['screenshot']))); ?>";
				title = "<?php echo sanitizeX($value['title']); ?>";
				html += "<div><a target='_blank' href='<?php echo site_url(); ?>media/image.php?p="+filepath+"'>"+file+"</a><br><input type='text' name='screenshot_titles[]' value='"+title+"' /><input type='hidden' name='screenshots[]' value='"+filepath+"' />&nbsp;&nbsp;&nbsp;<a onclick='this.parentElement.outerHTML=\"\"' style='cursor:pointer; text-decoration:underline' >Delete</a></div>";
				<?php
			}
			?>
			jQuery("#sspathhtml").html(html);
			<?php
		}
		if(is_array($people)){
			foreach($people as $value){
				?>
				addPerson(<?php echo $value['person_id']?>, "<?php echo $value['name']?>", "<?php echo $value['role']?>", "<?php echo $value['start_date']?>", "<?php echo $value['end_date']?>");
				<?php
			}
		}
		foreach($investment_org as $key=>$value){
			if($key=='founded'&&0){
				?>
				thedate = new Date("<?php echo $value; ?>");
				thedate.setDate(thedate.getDate());
				jQuery("#founded_pick").val(dateFormat(thedate, "mmm dd, yyyy"));
				<?php
			}
			else if($key=="logo"&&trim($value)){
				?>
				jQuery('#logopath').val("<?php echo sanitizeX($value); ?>");
				jQuery("#logopathhtml").html("<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $value ?>&mx=220' />");
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
