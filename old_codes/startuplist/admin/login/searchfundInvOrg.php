<?php
include("../lib/dbcon.php"); 
if($_POST)
{

$q=$_POST['searchword'];

$sql_res=mysql_query("select * from profile where profile_name like '%$q%' and profile_org='0' order by profile_id");

if (mysql_num_rows($sql_res) == 0) { 
?>
<div id="<?php echo $q ?>" class="display_boxpif" align="left" >
	&nbsp;Create&nbsp;<?php echo $q ?><br/>
	<br/>
	<span style="font-size:9px; color:#999999"></span>
</div>
<?php } else {
	while($row=mysql_fetch_array($sql_res))
	{
	$fname=$row['profile_name'];
	$profile_country=$row['profile_country'];
	/* $lname=$row['lname'];
	$img=$row['img'];
	$country=$row['country']; */
	/*
	$re_fname='<b>'.$q.'</b>';
	/* $re_lname='<b>'.$q.'</b>';

	$final_fname = str_ireplace($q, $re_fname, $fname); */

	/* $final_lname = str_ireplace($q, $re_lname, $lname); */
?>
<div id="<?php echo $fname; ?>" class="display_boxpif" align="left" >

	&nbsp;<?php //echo $final_lname; ?><?php echo $fname; ?>&nbsp;<?php echo $profile_country; ?>
	<br/>
	<span style="font-size:9px; color:#999999"></span>
</div>

<?php
}
?>
<div id="<?php echo $q ?>" class="display_boxpif" align="left" >
	&nbsp;Create&nbsp;<?php echo $q ?><br/>
	<br/>
	<span style="font-size:9px; color:#999999"></span>
</div>
<?php
}
}
else
{

}
?>
<script type="text/javascript">
/* $(".create_new").live("click", function (e) {
	var comprofile_name = $(this).attr('id');
	//alert('front');
	location.href = "http://startuplist.10dd.co/admin/login/companyFormSubmit.php?comprofile_name=" + comprofile_name;
	return false;
}); */
</script>