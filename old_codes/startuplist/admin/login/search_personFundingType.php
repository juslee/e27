<?php
include("../lib/dbcon.php"); 
if($_POST)
{

$q=$_POST['searchwordp'];

$sql_res=mysql_query("select * from profile_person where profile_person_name like '%$q%'  order by profile_person_id");
if (mysql_num_rows($sql_res) == 0) { 
?>
<div id="<?php echo $q; ?>" class="display_boxType" align="left" >
	&nbsp;Create&nbsp;<?php echo $q; ?><br/>
	<br/>
	<span style="font-size:9px; color:#999999"></span>
</div>
<?php } else {
	while($row=mysql_fetch_array($sql_res))
	{
	$fname=$row['profile_person_name'];
	$profile_person_email = $row['profile_person_email'];
	$profile_person_id = $row['profile_person_id'];
?>
<div id="<?php echo $fname; ?>" class="display_boxType" align="left" >

	&nbsp;<span style="font-size:14px;"><?php echo $fname; ?></span>&nbsp;<span style="float:right;"><?php echo $profile_person_email; ?></span><br/>&nbsp;&nbsp;<span style="margin:0px 0px 0px 0px;"><?php $sql_fpid = mysql_query("select * from profile_person_companies where profile_person_id='" . $profile_person_id . "' ORDER BY profile_person_id DESC limit 1");
	while ($row1 = mysql_fetch_array($sql_fpid)) {
		$fppid = $row1['profile_person_companies'];
		echo $fppid;
	}
?></span><br/>
	<span style="font-size:9px; color:#999999"></span>
</div>

<?php } ?>
<div id="<?php echo $q; ?>" class="display_boxType" align="left" >
	&nbsp;Create&nbsp;<?php echo $q; ?><br/>
	<br/>
	<span style="font-size:9px; color:#999999"></span>
</div><?php
}
}
else
{

}
?>
<script type="text/javascript">
	$(".create_new").live("click", function(e) {
		var profilePerson_name = $(this).attr('id');
		//alert('front');
		location.href = "http://startuplist.10dd.co/admin/login/peopleFormSubmit.php?profilePerson_name=" + profilePerson_name;
		return false;
	}); 
</script>
