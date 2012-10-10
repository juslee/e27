<?php include("lib/dbcon.php");include("lib/functions.php"); ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Startuplist-Admin-System</title>
<link href="styles/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.infieldlabel.min.js"></script>
<script type="text/javascript" src="js/cufon-yui.js" ></script>
<script type="text/javascript" src="js/fonts/helvthin_400.font.js"></script>
<script type="text/javascript" src="js/transition.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	Cufon.replace('h1', { fontFamily: 'myriadreg' });
	Cufon.replace('h2', { fontFamily: 'helvthin' });
	Cufon.replace('h3', { fontFamily: 'myriadreg' });
	Cufon.replace('h4', { fontFamily: 'myriadreg' });
	Cufon.replace('h5', { fontFamily: 'myriadreg' });
	Cufon.replace('h6', { fontFamily: 'helvthin' });
});

$(document).ready(function(){
  //$("label").inFieldLabels();
});

$("input").live("focus",function(){
     $("label").inFieldLabels();
});

$('a#createaccount').click(function(){
	
	alert("test");
	
});

</script>
<script src="js/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>


<body id="login">
<div id="wrapper">
<?php
//If the user has submitted the form
if(isset($_POST['submit'])){
	//protect the posted value then store them to variables
	$username = protect($_POST['username']);
	$password = protect($_POST['password']);
	
	//Check if the username or password boxes were not filled in
	if(!$username || !$password){
		//if not display an error message
		echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You need to fill in a <b>Username</b> and a <b>Password</b>!</center></div>";
	}else{
		//if the were continue checking
		
		//select all rows from the table where the username matches the one entered by the user
		$res = mysql_query("SELECT * FROM `users` WHERE `users_username` = '".$username."'");
		$num = mysql_num_rows($res);
		
		//check if there was not a match
		if($num == 0){
			//if not display an error message
			echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>Username</b> you supplied does not exist!</center></div>";
		}else{
			//if there was a match continue checking
			
			//select all rows where the username and password match the ones submitted by the user
			$res = mysql_query("SELECT * FROM `users` WHERE `users_username` = '".$username."' AND `users_password` = '".$password."'");
			$num = mysql_num_rows($res);
			
			//check if there was not a match
			if($num == 0){
				//if not display error message
				echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>Password</b> you supplied does not match the one for that username!</center></div>";
			}else{
				//if there was continue checking
				
				//split all fields fom the correct row into an associative array
				$row = mysql_fetch_assoc($res);
				
				//check to see if the user has not activated their account yet
				if($row['users_active'] != 1){
					//if not display error message
					echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You have not yet <b>Activated</b> your account!</center></div>";
				}else{
					//if they have log them in
					
					//set the login session storing there id - we use this to see if they are logged in or not
					$_SESSION['userID'] = $row['users_id'];
					$userID =  $row['users_id'];
					//show message
					echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You have successfully logged in!</center></div>";
					
					//update the online field to 50 seconds into the future
					$time = date('U')+50;
					mysql_query("UPDATE `users` SET `users_online` = '".$time."' WHERE `users_id` = '".$_SESSION['userID']."'");
					
					//redirect them to the users online page
					echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://startuplist.10dd.co/admin/login/latest_updates.php">';
					exit;
				}
			}
		}
	}
}
?>		
<div id="login_container">
	<!-- <div id="usericon"></div> -->
	<div id="login_box_top"></div>
	<div id="login_box_mid">
	
		<div id="login_usericon"><div id="loginpic"></div></div>
		<div id="error_msg"></div>
		<div id="form_load">
		<form action="index.php" method="post" id="form_login" autocomplete="off">
		<ul id="loginform">
				<li class="header"><h5>Sign-in to your account</h5></li>
				<li><label for="username">username</label><input type="text" name="username" id="username" /></li>
				<li><label for="password">password</label><input type="password" name="password" id="password"/></li>
				<li><input type="submit" name="submit" value="Login" id="loginbutton"/></li>
				<li><a href="login/forgot.php" id="forgotpass">Forgot Password</a></li>			
			</ul>
		</form>
		</div>
		<div id="login_createacc">
			<a href="login/register.php" id="createaccount">Register</a>
		</div>
		<div class="clear"></div>
	</div>
	<div id="login_box_btm"></div>
	<div class="clear"></div>
</div>
	
	
</div> <!-- close wrapper -->
</body>
</html>
<?php ob_end_flush(); ?>