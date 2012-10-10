<?php include('lib/dbcon.php'); include('lib/functions.php'); include("classes/class.acl.php"); 
/*
$myACL = new ACL();
if ($myACL->hasPermission('access_site') != true)
{
	header("location: ../noentry.php");
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>startuplist No Entry</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('lib/scripts.php');?>
</head>

<body id="login">

<div id="wrapper">
	<?php include('../lib/left_bar.php');?>
	
	<div id="content_main"> 
		<!-- ======================================== RIGHT CONTENT ============================ -->
		<div id="left_content">
			<h2>Sorry you do not have sufficient rights to access this panel</h2></br>
			<a href="../login/task_index.php">Task</a>
			
		</div>
		
		
		<!-- ======================================== RIGHT CONTENT ============================ -->
		<div id="right_content">
			
						
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	
	
	<div id="right_bar">right</div>
</div> <!-- close wrapper -->


</body>
</html>