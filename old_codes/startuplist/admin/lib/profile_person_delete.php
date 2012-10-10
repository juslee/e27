<?php 

include("dbcon.php");

if(isset($_POST['id'])){
   $id=$_POST['id'];
   
	$sql_in=mysql_query("SELECT profile_person_name FROM profile_person where profile_person_id='$id'");
	$r=mysql_fetch_array($sql_in);
	$profile_person_delete_name=$r['profile_person_name'];
	$time1=time();
	$sql1 = "INSERT INTO latest_delete_person	(profile_person_delete_id,profile_person_delete_name,profile_person_delete_date) VALUES ('$id','$profile_person_delete_name','$time1')";
	mysql_query($sql1);
	
	$sql = "delete from profile_person where profile_person_id='$id'";
	mysql_query($sql);
  
  
}
 

?>


<li class='record'><?php echo $r['profile_person_name'];?><a href='#' id="<?php echo $r['profile_person_id'];?>" class='edit'></a><a href='#' id="<?php echo $r['profile_person_id'];?>" class='delbutton'> </a></li>