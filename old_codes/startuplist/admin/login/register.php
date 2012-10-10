<?php include("../lib/dbcon.php");include("../lib/functions.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Startuplist</title>
<link href="../styles/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.infieldlabel.min.js"></script>
<script type="text/javascript" src="../js/cufon-yui.js" ></script>
<script type="text/javascript" src="../js/fonts/helvthin_400.font.js"></script>
<script type="text/javascript" src="../js/transition.js"></script>
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


<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body id="login">
<div id="wrapper">

		<?php
		
		//Check to see if the form has been submitted
		if(isset($_POST['submit'])){
			
			//protect and then add the posted data to variables
			$username = protect($_POST['username']);
			$password = protect($_POST['password']);
			$passconf = protect($_POST['passconf']);
			$email = protect($_POST['email']);
			
			//check to see if any of the boxes were not filled in
			if(!$username || !$password || !$passconf || !$email){
				//if any weren't display the error message
				echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You need to fill in all of the required fields!</center></div>";
			}else{
				//if all were filled in continue checking
				
				//Check if the wanted username is more than 32 or less than 3 characters long
				if(strlen($username) > 32 || strlen($username) < 3){
					//if it is display error message
					echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>Your <b>Username</b> must be between 3 and 32 characters long!</center></div>";
				}else{
					//if not continue checking
					
					//select all the rows from out users table where the posted username matches the username stored
					$res = mysql_query("SELECT * FROM `users` WHERE `users_username` = '".$username."'");
					$num = mysql_num_rows($res);
					
					//check if theres a match
					if($num == 1){
						//if yes the username is taken so display error message
						echo  "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>Username</b> you have chosen is already taken!</center></div>";
					}else{
						//otherwise continue checking
						
						//check if the password is less than 5 or more than 32 characters long
						if(strlen($password) < 5 || strlen($password) > 32){
							//if it is display error message
							echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>Your <b>Password</b> must be between 5 and 32 characters long!</center></div>";
						}else{
							//else continue checking
							
							//check if the password and confirm password match
							if($password != $passconf){
								//if not display error message
								echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>Password</b> you supplied did not math the confirmation password!</center></div>";
							}else{
								//otherwise continue checking
								
								//Set the format we want to check out email address against
								$checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
								
								//check if the formats match
					            if(!preg_match($checkemail, $email)){
					            	//if not display error message
					                echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>E-mail</b> is not valid, must be name@server.tld!</center></div>";
					            }else{
					            	//if they do, continue checking
					            	
					            	//select all rows from our users table where the emails match
					            	$res1 = mysql_query("SELECT * FROM `users` WHERE `users_email` = '".$email."'");
					            	$num1 = mysql_num_rows($res1);
					            	
					            	//if the number of matches is 1
					            	if($num1 == 1){
					            		//the email address supplied is taken so display error message
										echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>E-mail</b> address you supplied is already taken</center></div>";
									}else{
										//finally, otherwise register there account
										
										//time of register (unix)
						            	$registerTime = date('U');
						            	
						            	//make a code for our activation key
						            	$code = md5($username).$registerTime;
						            	
						            	//insert the row into the database
										$res2 = mysql_query("INSERT INTO `users` (`users_username`, `users_password`, `users_email`, `users_rtime`) VALUES('".$username."','".$password."','".$email."','".$registerTime."')");
										
										//send the email with an email containing the activation link to the supplied email address
										//change the link to the live site when uploading final version :).
										mail($email, $INFO['chatName'].' registration confirmation', "Thank you for registering with Startuplist ".$username.",\n\nHere is your activation link. If the link doesn't work just copy and paste it into your browser address bar.\n\nhttp://Startuplist.10dd.co/admin/login/activate.php?code=".$code, 'From: support@10dd.co');
										
										//display the success message
										echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You have successfully registered, please visit your inbox to activate your account!</center></div>";
									}
								}
							}
						}
					}
				}
			}
		}
		
		?>
		
		<div id="register_container">
			<!-- <div id="usericon"></div> -->
			<div id="register_box_top"></div>
			<div id="register_box_mid">
	
				<div id="register_usericon"><div id="registerpic"></div></div>
				<div id="error_msg"></div>
				<div id="form_userregister">
					<form action="../login/register.php" method="post" id="register">
						<ul id="registerform">
							<li class="header"><h5>Create a new account</h5></li>
							<li><label for="username" >username</label><input type="text" name="username" id="username" /></li>
							<li><label for="password" >password</label><input type="password" name="password" id="password"/></li>
							<li><label for="passconf" >confirm password</label><input type="password" name="passconf" id="passconf"/></li>
							<li><label for="email" >email</label><input type="text" name="email" id="email"/></li>
							<li><input type="submit" name="submit" value="" id="registerbutton" class="register"/></li>
							<li><a href="../index.php">Login</a></li>	
							<li><a href="forgot.php" id="forgotpass">Forgot Password</a></li>			
						</ul>
						<div class="clear"></div>
					</form>
				</div>
				<div class="clear"></div>
			</div>
			<div id="register_box_btm"></div>
			<div class="clear"></div>
		</div>

</div> <!-- close container -->
</body>
</html>
<?php ob_end_flush(); ?>