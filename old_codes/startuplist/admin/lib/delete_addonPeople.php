<?php
include('../lib/dbcon.php');
$trash_name=$_POST['trash_name'];
$addon_id=$_POST['addon_id'];
//echo $addon_id;
//+sign delete person
if($trash_name=='comp'){

mysql_query("DELETE FROM profile_person_companies WHERE profile_person_companies_id='$addon_id'");

}else{

mysql_query("DELETE FROM  profile_person_fo WHERE profile_person_fo_id='$addon_id'");
}
?>