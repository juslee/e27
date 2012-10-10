<?php
include("../../lib/dbcon.php");
include("../../classes/class.acl.php");
$myACL = new ACL();
if (isset($_POST['action']))
{
switch($_POST['action'])
{
case 'saveRoles':
$redir = "?action=user&userID=" . $_POST['userID'];
foreach ($_POST as $k => $v)
{
if (substr($k,0,5) == "role_")
{
$roleID = str_replace("role_","",$k);
if ($v == '0' || $v == 'x') {
$strSQL = sprintf("DELETE FROM `user_roles` WHERE `userID` = %u AND `roleID` = %u",$_POST['userID'],$roleID);
} else {
$strSQL = sprintf("REPLACE INTO `user_roles` SET `userID` = %u, `roleID` = %u, `addDate` = '%s'",$_POST['userID'],$roleID,date ("Y-m-d H:i:s"));
}
mysql_query($strSQL);
}
}

break;
case 'savePerms':
$redir = "?action=user&userID=" . $_POST['userID'];
foreach ($_POST as $k => $v)
{
if (substr($k,0,5) == "perm_")
{
$permID = str_replace("perm_","",$k);
if ($v == 'x')
{
$strSQL = sprintf("DELETE FROM `user_perms` WHERE `userID` = %u AND `permID` = %u",$_POST['userID'],$permID);
} else {
$strSQL = sprintf("REPLACE INTO `user_perms` SET `userID` = %u, `permID` = %u, `value` = %u, `addDate` = '%s'",$_POST['userID'],$permID,$v,date ("Y-m-d H:i:s"));
}
mysql_query($strSQL);
}
}
break;
}
header("location: users.php" . $redir);
}
/*
if ($myACL->hasPermission('access_admin') != true)
{
header("location: ../admin_index.php");
}
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>10dd</title>
		<link rel="stylesheet" href="../../styles/styles.css" type="text/css" media="screen" title="default" />
		<!--[if IE]>
		<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
		<![endif]-->

		<!--  jquery core -->
		<script src="../../js/jquery-1.4.1.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="../script.js" ></script>
		<script type="text/javascript" src="../../js/cufon-yui.js" ></script>
		<script type="text/javascript" src="../../js/fonts/helvthin_400.font.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				Cufon.replace('h1', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('h2', {
					fontFamily : 'helvthin'
				});
				Cufon.replace('h3', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('h4', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('h5', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('h6', {
					fontFamily : 'helvthin'
				});
				Cufon.replace('h7', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('arrow', {
					fontFamily : 'myriadreg'
				});
				Cufon.replace('heading', {
					fontFamily : 'Museo'
				});
				Cufon.replace('museo', {
					fontFamily : 'Museo'
				});
				Cufon.replace('details', {
					fontFamily : 'Myriad Pro'
				});
				Cufon.replace('shadow', {
					fontFamily : 'myriadreg'
				});
			});
		</script>
	</head>

	<body>
		<div id="wrapper">
			<div id="header">
				<ul id="mainnav">
					<li class="logo"></li>
					<li class="button">
						<a href="http://startuplist.10dd.co/admin/login/latest_updates.php" class="latest"><h2>Latest &nbsp;</h2></a>
					</li>
					<li class="button2">
						<a href="http://Startuplist.10dd.co/admin/login/companyDashboard.php" class="Companies"><h2>Companies &nbsp;</h2></a>
					</li>
					<li class="button3">
						<a href="http://startuplist.10dd.co/admin/login/peopleDashboard.php" class="People"><h2>People &nbsp;</h2></a>
					</li>
					<li class="button4">
						<a href="http://startuplist.10dd.co/admin/login/investmentDashboard.php" class="Investment"><h2>Investment&nbsp;</h2></a>
					</li>
					
					<li class="button6">
						<a href="http://Startuplist.10dd.co/admin/login/login_index.php" class="User"><h2>User &nbsp;</h2></a>
					</li>

					<!--  start top-search -->

					<li class="logout">
						<a href="http://Startuplist.10dd.co/admin/login/logout.php" id="logout" class="logout"><h2>Logout<!--<img src="../images/shared/nav/nav_logout.gif" width="64" height="14" alt="" />--></h2></a>
					</li>
					<li class="button8">
						<form id="searchform">
							<input type="text" value="" id="inputString" onkeyup="lookup(this.value);" placeholder="Search"/>
							<div id="suggestions"></div>
						</form>
					</li>
					<!--  end top-search -->

					<li class="latest_updates"></li>
				</ul>
			</div>
			<div class="clear"></div>

			<div id="main_content">
				<!--<div id="sidebar">
				<a href="" id="updatecompany"></a>
				<!-- 			<a href="" id="addcompany"></a> --
				<span class="small">Last Updated: __ / __ / __</span>
				</div>-->

				<div id="form_container">
					<div id="left_header" class="usermanagement">
						<ul id="submenutop">
							<li>
								<a href="../login_index.php" class="home">Home</a>
							</li>
							
							<li>
								<a href="users.php" class="users_manage">Users</a>
							</li>
							<li>
								<a href="roles.php" class="roles">Roles</a>
							</li>
							<li>
								<a href="perms.php" class="permissions">Permissions</a>
							</li>
							<li>
								<a href="admin_index.php" class="user_admin">User Admin</a>
							</li>
						</ul>
					</div>

					<div id="table-content">
						<div id="page">
							<? if ($_GET['action'] == '' ) { ?>
							<h2>Select a User to Manage:</h2>
							<?
							$strSQL = "SELECT * FROM `users` ORDER BY `users_username` ASC";
							$data = mysql_query($strSQL);
							while ($row = mysql_fetch_assoc($data))
							{
							echo "<a href=\"?action=user&userID=" . $row['users_id'] . "\">" . $row['users_firstname']." ".  $row['users_lastname']."</a><br />";
							}
							} ?> <?
							if ($_GET['action'] == 'user' ) {
							$userACL = new ACL($_GET['userID']);
							?> <h2>Managing <?= $myACL->getUsername($_GET['userID']); ?>:</h2> ... Some form to edit user info ... <h3>Roles for user:   (<a href="users.php?action=roles&userID=<?= $_GET['userID']; ?>">Manage Roles</a>)</h3>
							<ul>
								<? $roles = $userACL->getUserRoles();
								foreach ($roles as $k => $v)
								{
								echo "
								<li>
									" . $userACL->getRoleNameFromID($v) . "
								</li>";
								}
								?>
							</ul> <h3>Permissions for user:   (<a href="users.php?action=perms&userID=<?= $_GET['userID']; ?>">Manage Permissions</a>)</h3>
							<ul>
								<? $perms = $userACL->perms;
								foreach ($perms as $k => $v)
								{
								if ($v['value'] === false) { continue; }
								echo "
								<li>
									" . $v['Name'];
									if ($v['inheritted']) { echo "  (inheritted)"; }
									echo "
								</li>";
								}
								?>
							</ul> <? } ?>
							<? if ($_GET['action'] == 'roles') { ?> <h2>Manage User Roles: (<?= $myACL->getUsername($_GET['userID']); ?>)</h2>
							<form action="users.php" method="post">
								<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th></th><th>Member</th><th>Not Member</th>
									</tr>
									<?
									$roleACL = new ACL($_GET['userID']);
									$roles = $roleACL->getAllRoles('full');
									foreach ($roles as $k => $v)
									{
									echo "
									<tr>
										<td><label>" . $v['Name'] . "</label></td>";
										echo "<td>
										<input type=\"radio\" name=\"role_" . $v['ID'] . "\" id=\"role_" . $v['ID'] . "_1\" value=\"1\"";
										if ($roleACL->
										userHasRole($v['ID'])) { echo " checked=\"checked\""; }
										echo " /></td>";
										echo "<td>
										<input type=\"radio\" name=\"role_" . $v['ID'] . "\" id=\"role_" . $v['ID'] . "_0\" value=\"0\"";
										if (!$roleACL->
										userHasRole($v['ID'])) { echo " checked=\"checked\""; }
										echo " /></td>";
										echo "
									</tr>";
									}
									?>
								</table>
								<input type="hidden" name="action" value="saveRoles" />
								<input type="hidden" name="userID" value="<?= $_GET['userID']; ?>" />
								<input type="submit" name="Submit" value="Submit" />
							</form>
							<form action="users.php" method="post">
								<input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?= $_GET['userID']; ?>'" value="Cancel" />
							</form> <? } ?>
							<?
							if ($_GET['action'] == 'perms' ) {
							?> <h2>Manage User Permissions: (<?= $myACL->getUsername($_GET['userID']); ?>)</h2>
							<form action="users.php" method="post">
								<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th></th><th></th>
									</tr>
									<?
									$userACL = new ACL($_GET['userID']);
									$rPerms = $userACL->perms;
									$aPerms = $userACL->getAllPerms('full');
									foreach ($aPerms as $k => $v)
									{
									echo "
									<tr>
										<td>" . $v['Name'] . "</td>";
										echo "<td>
										<select name=\"perm_" . $v['ID'] . "\">";
										echo "<option value=\"1\"";
										if ($userACL->
											hasPermission($v['Key']) && $rPerms[$v['Key']]['inheritted'] != true) { echo " selected=\"selected\""; }
											echo ">Allow</option>";
											echo "<option value=\"0\"";
											if ($rPerms[$v['Key']]['value'] === false && $rPerms[$v['Key']]['inheritted'] != true) { echo " selected=\"selected\""; }
											echo ">Deny</option>";
											echo "<option value=\"x\"";
											if ($rPerms[$v['Key']]['inheritted'] == true || !array_key_exists($v['Key'],$rPerms))
											{
											echo " selected=\"selected\"";
											if ($rPerms[$v['Key']]['value'] === true )
											{
											$iVal = '(Allow)';
											} else {
											$iVal = '(Deny)';
											}
											}
											echo ">Inherit $iVal</option>";
											echo "</select></td></tr>";
											}
											?>
								</table>
								<input type="hidden" name="action" value="savePerms" />
								<input type="hidden" name="userID" value="<?= $_GET['userID']; ?>" />
								<input type="submit" name="Submit" value="Submit" />
							</form>
							<form action="users.php" method="post">
								<input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?= $_GET['userID']; ?>'" value="Cancel" />
							</form> <? } ?> <a href="#nogo" id="Change"><h2>Change User Password:</h2></a><?php

							//Check to see if the form has been submitted
							if (isset($_POST['submitPass'])) {

								//protect and then add the posted data to variables
								$username = ($_POST['username']);
								$password = ($_POST['password']);
								$passnew = ($_POST['passnew']);
								$passconf = ($_POST['passconf']);

								//check to see if any of the boxes were not filled in
								if (!$username || !$password || !$passnew || !$passconf) {
									//if any weren't display the error message
									echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																You need to fill in all of the required fields!
															</center>
														</div>";
								} else {
									//if all were filled in continue checking

									//Check if the wanted username is more than 32 or less than 3 characters long
									if (strlen($username) > 32 || strlen($username) < 3) {
										//if it is display error message
										echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																Your <b>Username</b> must be between 3 and 32 characters long!
															</center>
														</div>";
									} else {
										//if not continue checking

										//select all the rows from out users table where the posted username matches the username stored
										$res = mysql_query("SELECT * FROM `users` WHERE `users_username` = '" . $username . "'");
										$num = mysql_num_rows($res);

										//check if theres a match
										if ($num == 1) {
											//otherwise continue checking

											//check if the password is less than 5 or more than 32 characters long
											if (strlen($password) < 5 || strlen($password) > 32) {
												//if it is display error message
												echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																Your <b>Password</b> must be between 5 and 32 characters long!
															</center>
														</div>";
											} else {
												//else continue checking
												if (strlen($password) < 5 || strlen($password) > 32) {
													//if it is display error message
													echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																Your <b>NewPassword</b> must be between 5 and 32 characters long!
															</center>
														</div>";
												} else {

													if (strlen($passnew) < 5 || strlen($passnew) > 32) {
														//if it is display error message
														echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																Your <b>NewPassword</b> must be between 5 and 32 characters  long!
															</center>
														</div>";
													} else {
														//check if the password and confirm password match
														if ($password == $passnew) {
															//if not display error message
															echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																The <b>Password</b> you supplied did match the old password!
															</center>
														</div>";
														} else {
															//otherwise continue checking

															//check if the formats match
															if ($passnew != $passconf) {
																//if not display error message
																echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																The <b>you supplied did not match the confirmation password!
															</center>
														</div>";
															} else {
																//if they do, continue checking

																//select all rows from our users table where the emails match
																$res1 = mysql_query("SELECT * FROM `users` WHERE `users_password` = '" . $passconf . "'");
																$num1 = mysql_num_rows($res1);
																//echo $num1;
																//if the number of matches is 1
																if ($num1 == 1) {
																	//the email address supplied is taken so display error message
																	echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																The <b>Password</b> you supplied is already taken
															</center>
														</div>";
																} else {
																	//finally, otherwise register there account

																	//time of register (unix)
																	$registerTime = date('U');

																	//make a code for our activation key
																	$code = md5($username) . $registerTime;

																	//insert the row into the database
																	$res2 = mysql_query("UPDATE users SET users_username='" . $username . "',users_password='" . $passconf . "',users_rtime='" . $registerTime . "' WHERE users_username='" . $username . "'");

																	//display the success message
																	echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																You have successfully Changed your password,
															</center>
														</div>";
																}
															}
														}
													}
												}
											}
										} else {
											//if yes the username is taken so display error message
											echo "
														<div style='color:#061A69;background-color:#E9EBF5;margin-top:0px;height:20px;width:875px;'>
															<center>
																The <b>Username</b> you have chosen is not matching!
															</center>
														</div>";

										}
									}
								}
							}
							?>
							<div id="change_container">
								<!-- <div id="usericon"></div> -->
								<div id="change_box_top"></div>
								

									<div id="change_usericon">
										<div id="changepic"></div>
									</div>
									<div id="changeerror_msg"></div>
									<div id="form_userchange">
										<form action="users.php" method="post" id="change">
											<ul id="changeform">
												
												<li>
													<label for="username" >Username:</label>
													<input type="text" name="username" id="changeusername" />
												</li>
												<li>
													<label for="password" >Old password:</label>
													<input type="password" name="password" id="changepassword"/>
												</li>
												<li>
													<label for="passnew" >New password:</label>
													<input type="password" name="passnew" id="changepassnew"/>
												</li>
												<li>
													<label for="passconf" >Confirm new password:</label>
													<input type="password" name="passconf" id="changepassconf"/>
												</li>
												<li>
													<input type="submit" name="submitPass" value="Submit" id="" />
												</li>
												<li>
													<a href="http://Startuplist.10dd.co/admin/">Login</a>
												</li>

											</ul>
											<div class="clear"></div>
										</form>
									</div>
									<div class="clear"></div>
								
								
								<div class="clear"></div>
							</div> <!-- close page --> <div class="clear"></div>
						</div>
						<!-- close page -->

						<div class="clear"></div>
					</div>
					<!--  end table-content  -->
				</div>
			</div>
		</div>
		<!-- close wrapper -->
	</body>
</html>
<style>
#change_container													{margin: 0 auto; width:869px; margin-top: 0px;border-style:solid;
border-color:#A8A8A8 ;}
 #change_box_top													{height: 13px; background:  url(../img/bg_box_top) no-repeat top left;}
/*#change_box_mid													{height: 300px; background:  url(../img/bg_box_mid) repeat-y top left;}
#change_box_btm													{height: 30px; background:  url(../img/bg_box_btm) no-repeat top left;} */


#change_usericon													{width:160px; float: left; min-height: 10px;}


ul#changeform 														{margin: 0; padding: 0; text-align: left;}
ul#changeform li													{text-align: left; height: 40px; list-style: none;position: relative;}
ul#changeform li	label											{background: ;position:absolute; top:8px; left:-153px; font-size: 13px; font-family: Verdana; font-weight: 300; color:;  display:block;}
ul#changeform li.header												{height: 45px; color: #6d7179;}
ul#changeform input													{text-align: left; font-size: 14px; font-family: Verdana;}

/* input#changeusername														{border-style:solid;
border-color:#A8A8A8 ;background:#FFFFFF  url(../img/span_formicons.) no-repeat; width:244px; height: 21px; padding: 0px; background-position: 0px -150px }
input#changepassword														{border-style:solid;
border-color:#A8A8A8 ;background:#FFFFFF  url(../img/span_formicons.) no-repeat; width:244px; height: 21px;padding: 0px; background-position: 0px -180px}
input#changepassconf														{border-style:solid;
border-color:#A8A8A8 ;background:#FFFFFF  url(../img/span_formicons.) no-repeat; width:244px; height: 21px; padding: 0px; background-position: 0px -180px}
input#changepassnew															{border-style:solid;
border-color:#A8A8A8 ;background:#FFFFFF  url(../img/span_formicons.) no-repeat; width:244px; height: 21px;padding: 0px; background-position: 0px -120px} */
#changepic														{background: url(../img/icon_user.) no-repeat top left; width:108px; height: 108px;margin: 55px 0 0 27px}

#changeerror_msg															{background-color:red;width:250px;}
#form_userchange												{width:239px; float: left; }



form#change														{margin: 0; padding: 0;}
#Change                                                          {margin:50px;}
</style>