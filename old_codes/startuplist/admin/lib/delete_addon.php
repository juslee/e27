<?php
include('../lib/dbcon.php');
$trash_name=$_POST['trash_name'];
$addon_id=$_POST['addon_id'];
//echo $addon_id;
//+sign delete
if($trash_name=='comp'){

mysql_query("DELETE FROM profile_competitors WHERE profile_competitors_id='$addon_id'");

}else if($trash_name=='fund'){

mysql_query("DELETE FROM  profile_funding WHERE profile_funding_id='$addon_id'");

}else if($trash_name=='peop'){

mysql_query("DELETE FROM  profile_people WHERE profile_people_id='$addon_id'");

}else{

mysql_query("DELETE FROM  profile_history_mile WHERE profile_hm_id='$addon_id'");
}
?>