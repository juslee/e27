<?php
$query_pag_data = "SELECT profile_person_id,profile_person_name,profile_person_email,profile_person_active from profile_person ORDER BY profile_person_id DESC LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$finaldata = "";
$tablehead="<tr><th class='table-header-check'>No</th><th class='table-header-repeat line-left minwidth-1'><a href='#'>Person name</a></th><th class='table-header-repeat line-left minwidth-1'><a href='#'>Email address</a></th><th class='table-header-repeat line-left'><a href='#'>Active</a><th class='table-header-options line-left'><a href='#' >Action</a></th></tr>";
$tabledata="";
$t=1;
while($row = mysql_fetch_array($result_pag_data)) 
{

$profile_person_id=htmlentities($row['profile_person_id']);
$profile_person_name=htmlentities($row['profile_person_name']);
$profile_person_email=htmlentities($row['profile_person_email']);
$profile_person_active=htmlentities($row['profile_person_active']);
 if($profile_person_active=='1'){
		
		$profile_person_active1='Active';
	
	
	}else{
		$profile_person_active1='Not Active';
	} 

//tabledata for the table to print.
$tabledata.="
<tr id='$profile_person_id' class='edit_tr1'>

<td class='edit_td' >
<span id='' class='text'>$t</span>
</td>

<td class='edit_td' >
<span id='one_$profile_person_id' class='text'>$profile_person_name</span>
<input type='text' value='$profile_person_name' class='editbox' id='one_input_$profile_person_id' />
</td>

<td class='edit_td' >
<span id='two_$profile_person_id' class='text'>$profile_person_email</span> 
<input type='text' value='$profile_person_email' class='editbox' id='two_input_$profile_person_id'/>
</td>

<td class='edit_td' >
<span id='three_$profile_person_id' class='text'>$profile_person_active1</span> 
<input type='text' value='$profile_person_active1' class='editbox' id='three_input_$profile_person_id'/>
</td>

<td class='options-width'><a href='#nogo' title='Edit' class='icon-1 info-tooltip view_profile_person' id='$profile_person_id'></a><a href='#nogo' title='delete' class='icon-2 info-tooltip delete_profile_person' id='$profile_person_id'></a><a href='#nogo' title='front' class='icon-5 info-tooltip frontPage_Person' id='$profile_person_id'></a></td>

</tr>";
$t++;}
$finaldata = "<table border='0' width='100%' cellpadding='0' cellspacing='0' id='product-table'>". $tablehead . $tabledata . "</table>"; // Content for Data


/* Total Count */
$query_pag_num = "SELECT COUNT(*) AS count FROM profile_person";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);




?>

<script type="text/javascript">
var test;
$(".view_profile_person").live("click",function(e){
test = $(this).attr('id');
	//alert('front');
	location.href = "http://startuplist.10dd.co/admin/login/peopleFormUpdate.php?test="+test;
	return false;
});	
$(".frontPage_Person").live("click", function (e) {
	//alert('front');
	var test1 = $(this).attr('id');
	//alert(test1);
	location.href = "http://startuplist.10dd.co/people/people_profile.php?profile_person_id=" + test1;
	return false;
	
});
</script>
