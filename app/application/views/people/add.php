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
			?>url: "<?php echo site_url(); ?>people/ajax_edit",<?php
		}
		else{
			?>url: "<?php echo site_url(); ?>people/ajax_add",<?php
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
			url: "<?php echo site_url(); ?>people/ajax_delete/"+id,
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				self.location = "<?php echo site_url(); ?>people";
			}
		});
		
	}
}

function refreshProfile(profilepath){
	profilepath = escape(profilepath);
	jQuery("#profilepathhtml").html("<img src='<?php echo site_url(); ?>media/image.php?p="+profilepath+"&mx=220&_="+(new Date().getTime())+"' />");
	jQuery("#profilepath").val(profilepath);
}


function checkEmail(email_address){
	if(jQuery.trim(email_address)){
		formdata = "email="+email_address;
		<?php
			if($person['id']){
				?>formdata += "&id=<?php echo $person['id']; ?>";<?php
			}
		?>
		jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
		
		jQuery.ajax({
			url: "<?php echo site_url(); ?>people/ajax_check_email",
			type: "POST",
			data: formdata,
			dataType: "script",
			success: function(){
				
			}
		});
	}
	else{
		jQuery("#email_check").html("");
	}
	
}

var companies = [];
var investment_orgs = [];

function companyPreAdd(label, value){
	value = value*1;
	/*
	if(companies.indexOf(value)!=-1){
		alert(label+" is already added as this person's company.");
		return false;
	}
	*/
	
	jQuery("#companyadd").slideDown(200);
	jQuery("#c_name").html(label);
	jQuery("#c_id").val(value);
}

function investmentOrgPreAdd(label, value){
	value = value*1;
	/*
	if(investment_orgs.indexOf(value)!=-1){
		alert(label+" is already added as this person's investment organization.");
		return false;
	}
	*/
	
	jQuery("#investment_orgadd").slideDown(200);
	jQuery("#io_name").html(label);
	jQuery("#io_id").val(value);
}

function delCompany(obj, cid){
	if(confirm("Are you sure you want to delete this company?")){
		cid = cid*1;
		index = companies.indexOf(cid);
		companies.splice(index, 1);
		obj.parentElement.parentElement.outerHTML = "";
		return true;
	}
	return false;
}

function delInvestmentOrg(obj, ioid){
	if(confirm("Are you sure you want to delete this investment organization?")){
		ioid = ioid*1;
		index = investment_orgs.indexOf(ioid);
		investment_orgs.splice(index, 1);
		obj.parentElement.parentElement.outerHTML = "";
		return true;
	}
	return false;
}

function addCompanyShortcut(company_name){
	jQuery("#company_search").attr("disabled", true);
	jQuery("#company_add_loader").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
	jQuery.ajax({
		url: "<?php echo site_url(); ?>companies/ajax_add_company_shortcut",
		type: "POST",
		data: "name="+escape(company_name),
		dataType: "script",
		success: function(data){
			
		}
	});
}

function addInvestmentOrgShortcut(name){
	jQuery("#investment_org_search").attr("disabled", true);
	jQuery("#investment_org_add_loader").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
	jQuery.ajax({
		url: "<?php echo site_url(); ?>investment_orgs/ajax_add_investment_org_shortcut",
		type: "POST",
		data: "name="+escape(name),
		dataType: "script",
		success: function(data){
			
		}
	});
}


function addCompany(id, name, role, start_date, end_date, add){
	if(!id){
		return false;
	}
	if(!start_date){
		alert("Must input a start date.");
		return false;
	}
	id = id*1;
	/*
	if(companies.indexOf(id)!=-1){
		alert(name+" is already added as this person's company.");
		return false;
	}
	*/
	
	companies.push(id);
	jQuery("#companyadd").hide();
	html = "";
	
	if(add){
		html += "<tr class='lightgreen' ><td><input type='hidden' name='c_ids[]' value='"+id+"' />";
	}
	else{
		html += "<tr><td><input type='hidden' name='c_ids[]' value='"+id+"' />";
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
	
	html += "<a href='<?php echo site_url(); ?>companies/edit/"+id+"' target=''>"+name+"</a></td><td>"+role+"</td><td>"+start_date+" to "+end_date+"</td><td><a style='cursor:pointer; text-decoration:underline' class='red delete' onclick='delCompany(this, \""+id+"\")' >Delete</a></td></tr>";
	
	htmlorig = jQuery("#companyhtml table tbody").html();
	
	if(add){
		html = html + htmlorig;
	}
	else{
		html = htmlorig + html;
	}	
	jQuery("#companyhtml table tbody").html(html);
}

function addInvestmentOrg(id, name, role, start_date, end_date, add){
	if(!id){
		return false;
	}
	if(!start_date){
		alert("Must input a start date.");
		return false;
	}
	id = id*1;
	/*
	if(investment_orgs.indexOf(id)!=-1){
		alert(name+" is already added as this person's investment organization.");
		return false;
	}
	*/
	
	investment_orgs.push(id);
	jQuery("#investment_orgadd").hide();
	html = "";
	
	if(add){
		html += "<tr class='lightgreen'><td><input type='hidden' name='io_ids[]' value='"+id+"' />";
	}
	else{
		html += "<tr><td><input type='hidden' name='io_ids[]' value='"+id+"' />";
	}
	html += "<input type='hidden' name='iop_roles[]' value='"+role+"' />";
	html += "<input type='hidden' name='iop_start_dates[]' value='"+start_date+"' />";
	html += "<input type='hidden' name='iop_end_dates[]' value='"+end_date+"' />";
	
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
	
	html += "<a href='<?php echo site_url()?>investment_orgs/edit/"+id+"' target=''>"+name+"</a></td><td>"+role+"</td><td>"+start_date+" to "+end_date+"</td><td><a style='cursor:pointer; text-decoration:underline' class='red delete' onclick='delInvestmentOrg(this, \""+id+"\")' >Delete</a></td></tr>";
	
	htmlorig = jQuery("#investment_orghtml table tbody").html();
	if(add){
		html = html + htmlorig;
	}
	else{
		html = htmlorig + html;
	}
	
	jQuery("#investment_orghtml table tbody").html(html);
}

jQuery(function(){
	jQuery("#email_address").blur(function(){
		checkEmail(jQuery("#email_address").val());
	});
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
			jQuery("#company_add_loader").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
			//pass request to server
			jQuery.getJSON("<?php echo site_url(); ?>companies/ajax_search", req, function(data) {
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
				jQuery("#company_add_loader").html("");
			});
		},
		//define select handler
		select: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			
			if(value!=-1){
				jQuery("#company_search").val("");
				companyPreAdd(label, value);
			}
			else{
				addCompanyShortcut(this.value);
			}
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			if(value!=-1){
				jQuery("#company_search").val(label);
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
	
	jQuery("#investment_org_search").autocomplete({
		//define callback to format results
		source: function(req, add){
			jQuery("#investment_org_add_loader").html("<img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
			//pass request to server
			jQuery.getJSON("<?php echo site_url(); ?>investment_orgs/ajax_search", req, function(data) {
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
				jQuery("#investment_org_add_loader").html("");
			});
		},
		//define select handler
		select: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			
			if(value!=-1){
				jQuery("#investment_org_search").val("");
				investmentOrgPreAdd(label, value);
			}
			else{
				addInvestmentOrgShortcut(this.value);
			}
			return false;
		},
		focus: function(e, ui) {
			label = ui.item.label;
			value = ui.item.value;
			if(value!=-1){
				jQuery("#investment_org_search").val(label);
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
		<td class='font18 bold'>Edit Person - <a class='font16 bold' href='<?php echo site_url();?>person/<?php echo $person['slug']; ?>'>Click here to preview</a></td>
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
      <td><input type="text" name="name" size="40" id='person_name'><div class='inline' style='padding-left:5px;' id='co_check'></div></td>
    </tr>
    <tr class="even">
      <td>* Description:</td>
      <td><textarea name="description"></textarea></td>
    </tr>		
    <tr class="odd required">
      <td>* Email Address: </td>
      <td><input type="text" name="email_address" size="35" id='email_address'> <div class='inline' style='padding-left:5px;' id='email_check'></div></td>
    </tr>	
	<tr class="even">
      <td>Blog URL:</td>
      <td><input type="text" name="blog_url" size="30">
        <div class='hint'>e.g. http://e27.sg</div></td>
    </tr>
    <tr class="even">
      <td>Blog RSS feed URL:</td>
      <td><input type="text" name="blog" size="30">
        <div class='hint'>e.g. http://e27.sg/feed</div></td>
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
	  <input type='button' class='button normal' value='Upload' onclick="jQuery('#profile_image').uploadifyUpload();" >
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
		  <input type="text" size: "30" id="company_search" /><div class='inline' id='company_add_loader' ></div><div class='hint'>Type in the company name to search and add a company.</div>
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
					<td colspan="2" align="center"><input type='button' value='Add Company' class='button normal' onclick='addCompany(jQuery("#c_id").val(), jQuery("#c_name").html(), jQuery("#p_role").val(), jQuery("#p_start_date").val(), jQuery("#p_end_date").val(), true)' >&nbsp;
					<input type='button' value='Cancel' class='button normal' onclick='jQuery("#companyadd").hide()' /></td>
				</tr>
			</table>
		  </div>
			<div class='margin10 pad10'>
			  <div id='companyhtml' ><table cellspacing=0><tbody></tbody></table></div>
			</div>
		  </td>
		</tr>
		
		<tr class="even">
		  <td>Investment Orgs:</td>
		  <td>
		  <input type="text" size: "30" id="investment_org_search" /><div class='inline' id='investment_org_add_loader'></div><div class='hint'>Type in the investment organization name to search and add.</div>
		  <div id='investment_orgadd' style='display:none'>
		  	<input type='hidden' id='io_id' />
		  	<table class='border margin10 pad10'>
				<tr>
					<td>Name:</td>
					<td id='io_name'></td>
				</tr>
				<tr>
					<td>Role:</td>
					<td><input type='text' id='iop_role' /></td>
				</tr>
				<tr>
					<td>Start Date:</td>
					<td><input type='text' id='iop_start_date' class='datepicker' /><div class='hint'>mm/dd/yyyy</div></td>
				</tr>
				<tr>
					<td>End Date:</td>
					<td><input type='text' id='iop_end_date' class='datepicker' /><div class='hint'>mm/dd/yyyy (leave blank if present)</div></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type='button' value='Add Investment Organization' class='button normal' onclick='addInvestmentOrg(jQuery("#io_id").val(), jQuery("#io_name").html(), jQuery("#iop_role").val(), jQuery("#iop_start_date").val(), jQuery("#iop_end_date").val(), true)' >&nbsp;
					<input type='button' value='Cancel' class='button normal' onclick='jQuery("#investment_orgadd").hide()' /></td>
				</tr>
			</table>
		  </div>
			<div class='margin10 pad10'>
			  <div id='investment_orghtml'><table cellspacing=0><tbody></tbody></table></div>
			</div>
		  </td>
		</tr>
		
		<tr class="odd">
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
		<td width='100%'>
		<input type="button" id='savebutton' value="Save" onclick="savePerson()" />
		</td>
		<?php 
		if($person['id']){
			?><td><input type="button" style='background:red; color:white' value="Delete" onclick="deletePerson('<?php echo $person['id']; ?>')" /></td><?php
		}
		?>
		</tr>
		</table>
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
		if(is_array($investment_orgs)){
			foreach($investment_orgs as $value){
				?>
				addInvestmentOrg(<?php echo $value['investment_org_id']?>, "<?php echo $value['name']?>", "<?php echo $value['role']?>", "<?php echo $value['start_date']?>", "<?php echo $value['end_date']?>");
				<?php
			}
		}
		foreach($person as $key=>$value){
			if($key=="profile_image"&&trim($value)){
				?>
				jQuery('#profilepath').val("<?php echo sanitizeX($value); ?>");
				jQuery("#profilepathhtml").html("<img src='<?php echo site_url(); ?>media/image.php?p=<?php echo $value ?>&mx=220' />");
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
