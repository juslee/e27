<?php include("../lib/dbcon.php");include("../lib/functions.php"); ob_start();?>
<html>
	<head>
		<title>Login with Users Online</title>
		<link href="../styles/styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
		
		//echo md5('other');
		//get the code that is being checked and protect it before assigning it to a variable
		$code = protect($_GET['code']);
		
		//check if there was no code found
		if(!$code){
			//if not display error message
			echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>Unfortunatly there was an error there!</center></div>";
		}else{
			//other wise continue the check
			
			//select all the rows where the accounts are not active
			$res = mysql_query("SELECT * FROM `users` WHERE `users_active` = '0'");
			
			//loop through this script for each row found not active
			while($row = mysql_fetch_assoc($res)){
				//check if the code from the row in the database matches the one from the user
				if($code == md5($row['users_username']).$row['users_rtime']){
					//if it does then activate there account and display success message
					$res1 = mysql_query("UPDATE `users` SET `users_active` = '1' WHERE `users_id` = '".$row['users_id']."'");
					echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You have successfully activated your account!</center></div>";
					echo '<META HTTP-EQUIV="Refresh" Content="3; URL=http://Startuplist.10dd.co/">';
				}
			}
		}
		
		?>
		</div>
	</body>
</html>
<?php ob_end_flush(); ?>