<?php
$query_pag_data = "SELECT profile_id,profile_name,profile_email,profile_active from profile WHERE profile_org='1' ORDER BY profile_id DESC LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$finaldata = "";
$tablehead="<tr><th class='table-header-check'>No</th><th class='table-header-repeat line-left minwidth-1'><a href='#'>Company</a></th><th class='table-header-repeat line-left minwidth-1'><a href='#' >Email</a></th><th class='table-header-repeat line-left'><a href='#' >Active?</a></th><th class='table-header-options line-left'><a href='#' >Action</a></th></tr>";
$tabledata="";
$t=1;
while($row = mysql_fetch_array($result_pag_data)) 
{

$profile_id=htmlentities($row['profile_id']);
$profile_name=htmlentities($row['profile_name']);
$profile_email=htmlentities($row['profile_email']);
$profile_active=htmlentities($row['profile_active']);
 if($profile_active=='1'){
		
		$profile_active1='Active';
	
	
	}else{
		$profile_active1='Not Active';
	} 

$tabledata.="
<tr id='$profile_id' class='edit_tr'>

<td class='edit_td' >
<span id='' class='text'>$t</span>
</td>

<td class='edit_td' >
<span id='one_$profile_id' class='text'>$profile_name</span>
<input type='text' value='$profile_name' class='editbox' id='one_input_$profile_id' />
</td>

<td class='edit_td' >
<span id='two_$profile_id' class='text'>$profile_email</span> 
<input type='text' value='$profile_email' class='editbox' id='two_input_$profile_id'/>
</td>

<td class='edit_td' >
<span id='three_$profile_id' class='text'>$profile_active1</span> 
<input type='text' value='$profile_active1' class='editbox' id='three_input_$profile_id'/>
</td>


<td class='options-width'><a href='#nogo' title='Edit' class='icon-1 info-tooltip view_profile' id='$profile_id'></a>
<a href='#nogo' title='delete' class='icon-2 info-tooltip delete_profile' id='$profile_id'></a><a href='#nogo' title='front' class='icon-5 info-tooltip frontPage_Profile' id='$profile_id'></a></td>
</tr>";
$t++;}
$finaldata = "<table border='0' width='100%' cellpadding='0' cellspacing='0' id='product-table' class='sortable'>". $tablehead . $tabledata . "</table>"; // Content for Data


/* Total Count */
$query_pag_num = "SELECT COUNT(*) AS count FROM profile";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);




?>
<script type="text/javascript">
var test;
$(".view_profile").live("click",function(e){
test = $(this).attr('id');
	//alert('front');
	location.href = "http://startuplist.10dd.co/admin/login/companyFormUpdate.php?test="+test;
	return false;
});	
$(".frontPage_Profile").live("click", function (e) {
	//alert('front');
	var test1 = $(this).attr('id');
	location.href = "http://startuplist.10dd.co/company/company_profile.php?profile_id=" + test1;
	return false;
});
</script>


