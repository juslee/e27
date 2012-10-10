<?php
include("dbcon.php");
if(isset($_POST['id']))
{

$id=$_POST['id'];
   
	$sql_in=mysql_query("SELECT profile_person_name FROM profile_person where profile_person_id='$id'");
	$r=mysql_fetch_array($sql_in);
	$profile_person_delete_name=$r['profile_person_name'];
	$time1=time();
	$sql1 = "INSERT INTO latest_delete_person	(profile_person_delete_id,profile_person_delete_name,profile_person_delete_date) VALUES ('$id','$profile_person_delete_name','$time1')";
	mysql_query($sql1);

$profile_person_id=mysql_escape_String($_POST['id']);
$sql_img=mysql_query("select * from profile_person where profile_person_id='$profile_person_id'");
while($row_img=mysql_fetch_array($sql_img)){

			$img=$row_img['profile_person_image'];

			//echo $img;
			$files = glob('../img/uploads/'.$img.'');
foreach($files as $file) {
    unlink($file);
}

}

$sql = "delete from profile_person where profile_person_id='$profile_person_id'";
mysql_query($sql);
$sql_pc = "delete from profile_person_companies where profile_person_id='$profile_person_id'";
mysql_query($sql_pc);
$sql_pfo = "delete from profile_person_fo where profile_person_id='$profile_person_id'";
mysql_query($sql_pfo);

}
?>