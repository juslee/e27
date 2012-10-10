<?php
include("dbcon.php");
if(isset($_POST['id']))
{

$id=$_POST['id'];
   
	$sql_in=mysql_query("SELECT profile_name FROM profile where profile_id='$id'");
	$r=mysql_fetch_array($sql_in);
	$profile_delete_name=$r['profile_name'];
	$time1=time();
	$sql1 = "INSERT INTO latest_delete	(profile_delete_id,profile_delete_name,profile_delete_date) VALUES ('$id','$profile_delete_name','$time1')";
	mysql_query($sql1);

$profile_id=mysql_escape_String($_POST['id']);
$sql_img=mysql_query("select * from profile where profile_id='$profile_id'");
while($row_img=mysql_fetch_array($sql_img)){

			$img=$row_img['profile_logo'];
			$img2=$row_img['profile_screenshots'];
			//echo $img;
			$files = glob('../img/uploads/'.$img.'');
foreach($files as $file) {
    unlink($file);
}
$files2 = glob('../img/uploads/'.$img2.'');
foreach($files2 as $file2) {
    unlink($file2);
}		
}	
	

$sql = "delete from profile where profile_id='$profile_id'";
mysql_query($sql);
$sql_pp = "delete from profile_people where profile_id='$profile_id'";
mysql_query($sql_pp);
$sql_pcc = "delete from profile_competitors where profile_id='$profile_id'";
mysql_query($sql_pcc);
$sql_hm = "delete from profile_history_mile where profile_id='$profile_id'";
mysql_query($sql_hm);
$sql_pf = "delete from profile_funding where profile_id='$profile_id'";
mysql_query($sql_pf);








}
?>