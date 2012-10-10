<?php include("../lib/dbcon.php");include("../lib/functions.php"); ?>
<html>
	<head>
		<title>Login</title>
		<link href="../styles/styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
		
		//check if the login session does not exist
		if(!$_SESSION['uid']){
			//if it doesn't display an error message
			echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You are logging out!</center></div>";
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://Startuplist.10dd.co/admin/">';
		}else{
			//if it does continue checking
			
			//update to set this users online field to the current time
			mysql_query("UPDATE `users` SET `users_online` = '".date('U')."' WHERE `users_id` = '".$_SESSION['uid']."'");
			
			//destroy all sessions canceling the login session
			session_destroy();
			
			//display success message
			echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You have successfully logged out!</center></div>";
			//redirect them to the users online page
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://Startuplist.10dd.co/admin">';
		}
		
		?>
	</body>
</html>