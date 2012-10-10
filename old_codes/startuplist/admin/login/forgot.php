<?php include("../lib/dbcon.php");include("../lib/functions.php"); ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Startuplist</title>
<link href="../styles/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
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
		
		//Check to see if the forms submitted
		if(isset($_POST['submit'])){
			//if it is continue checks
			
			//store the posted email to variable after protection
			$email = protect($_POST['email']);
			
			//check if the email box was not filled in
			if(!$email){
				//if it wasn't display error message
				echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>You need to fill in your <b>E-mail</b> address!</center></div>";
			}else{
				//else continue checking
				
				//set the format to check the email against
				$checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
				
				//check if the email doesnt match the required format
	            if(!preg_match($checkemail, $email)){
	            	//if not then display error message
	                echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center><b>E-mail</b> is not valid, must be name@server.tld!</center></div>";
	            }else{
	            	//otherwise continue checking
	            	
	            	//select all rows from the database where the emails match
					$res = mysql_query("SELECT * FROM `users` WHERE `users_email` = '".$email."'");
	            	
	            	$num = mysql_num_rows($res);
	            	
	            	//check if the number of row matched is equal to 0
	            	if($num == 0){
	            		//if it is display error message
						echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>The <b>E-mail</b> you supplied does not exist in our database!</center></div>";
					}else{
						//otherwise complete forgot pass function
						
						//split the row into an associative array
						$row = mysql_fetch_assoc($res);
						
						//send email containing their password to their email address
						mail($email, 'Forgotten Password', "Here is your password: ".$row['users_password']."\n\nPlease try not to lose it again!", 'From: support@10dd.com');
						
						//display success message
						echo "<div style='color:#061A69;background-color:#E9EBF5;margin-top:60px;height:20px;'><center>An email has been sent too your email address containing your password!</center></div>";
					}
				}
			}
		}
		
		?>
		
		<div id="forgot_container">
			<!-- <div id="usericon"></div> -->
			<div id="forgot_box_top"></div>
			<div id="forgot_box_mid">
	
				<div id="forgot_usericon"><div id="forgotpic"></div></div>
				<div id="error_msg"></div>
				<div id="form_userforgot">
					<form action="forgot.php" method="post" id="register">
						<ul id="forgotform">
							<li class="forgot_header"></li>
							
							<li><label for="email" >email</label><input type="text" name="email" id="email"/></li>
							<li><input type="submit" name="submit" value="Send" /></li>
							<li><a href="../index.php">Login</a></li>	
							<li><a href="register.php">Register</a> | <a href="../index.php">Login</a></li>			
						</ul>
						<div class="clear"></div>
					</form>
				</div>
				<div class="clear"></div>
			</div>
			<div id="forgot_box_btm"></div>
			<div class="clear"></div>
		</div>
		
		
		
		<!--<div id="login_container">
			<!-- <div id="usericon"></div>
			<form action="forgot.php" method="post" id="register">
				<table cellpadding="2" cellspacing="0" border="0">
					<tr>
						<td>Email: </td>
						<td><input type="text" name="email" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><a href="register.php">Register</a> | <a href="../index.php">Login</a></a></td>
					</tr>
				</table>
			</form>
			<div class="clear"></div>
		</div>-->

</div> <!-- close container -->
</body>
</html>
<?php ob_end_flush(); ?>