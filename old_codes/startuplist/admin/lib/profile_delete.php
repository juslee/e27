<?php 

include("dbcon.php");

if(isset($_POST['id'])){
   $id=$_POST['id'];
   
	$sql_in=mysql_query("SELECT profile_name FROM profile where profile_id='$id'");
	$r=mysql_fetch_array($sql_in);
	$profile_delete_name=$r['profile_name'];
	$time1=time();
	$sql1 = "INSERT INTO latest_delete	(profile_delete_id,profile_delete_name,profile_delete_date) VALUES ('$id','$profile_delete_name','$time1')";
	mysql_query($sql1);
	
   $sql = "delete from profile where profile_id='$id'";
   mysql_query($sql);
  

  
}
 

?>


<li class='record'><?php echo $r['profile_name'];?><a href='#' id="<?php echo $r['profile_id'];?>" class='edit'></a><a href='#' id="<?php echo $r['profile_id'];?>" class='delbutton'> </a></li>