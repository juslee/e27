<?php 

include("dbcon.php");

if(isset($_POST['id'])){
   $id=$_POST['id'];
   
   
   $sql = "delete from profile_investment where profile_investment_id='$id'";
   mysql_query($sql);
  
  
}
 

?>


<li class='record'><?php echo $r['profile_investment_name'];?><a href='#' id="<?php echo $r['profile_investment_id'];?>" class='edit'></a><a href='#' id="<?php echo $r['profile_investment_id'];?>" class='delbutton'> </a></li>