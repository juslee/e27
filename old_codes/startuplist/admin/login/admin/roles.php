<?php
include("../../lib/dbcon.php");
include("../../classes/class.acl.php");
$myACL = new ACL();
if (isset($_POST['action']))
{
switch($_POST['action'])
{
case 'saveRole':
$strSQL = sprintf("REPLACE INTO `roles` SET `ID` = %u, `roleName` = '%s'",$_POST['roleID'],$_POST['roleName']);
mysql_query($strSQL);
if (mysql_affected_rows() > 1)
{
$roleID = $_POST['roleID'];
} else {
$roleID = mysql_insert_id();
}
foreach ($_POST as $k => $v)
{
if (substr($k,0,5) == "perm_")
{
$permID = str_replace("perm_","",$k);
if ($v == 'X')
{
$strSQL = sprintf("DELETE FROM `role_perms` WHERE `roleID` = %u AND `permID` = %u",$roleID,$permID);
mysql_query($strSQL);
continue;
}
$strSQL = sprintf("REPLACE INTO `role_perms` SET `roleID` = %u, `permID` = %u, `value` = %u, `addDate` = '%s'",$roleID,$permID,$v,date ("Y-m-d H:i:s"));
mysql_query($strSQL);
}
}
header("location: roles.php");
break;
case 'delRole':
$strSQL = sprintf("DELETE FROM `roles` WHERE `ID` = %u LIMIT 1",$_POST['roleID']);
mysql_query($strSQL);
$strSQL = sprintf("DELETE FROM `user_roles` WHERE `roleID` = %u",$_POST['roleID']);
mysql_query($strSQL);
$strSQL = sprintf("DELETE FROM `role_perms` WHERE `roleID` = %u",$_POST['roleID']);
mysql_query($strSQL);
header("location: roles.php");
break;
}
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
							<? if ($_GET['action'] == '') { ?>
							<h2>Select a Role to Manage:</h2>
							<?
							$roles = $myACL->getAllRoles('full');
							foreach ($roles as $k => $v)
							{
							echo "<a href=\"?action=role&roleID=" . $v['ID'] . "\">" . $v['Name'] . "</a><br />";
							}
							if (count($roles) < 1)
							{
							echo "No roles yet.<br />";
							} ?>
							<input type="button" name="New" value="New Role" onclick="window.location='?action=role'" />
							<? }
							if ($_GET['action'] == 'role') {
							if ($_GET['roleID'] == '') {
							?>
							<h2>New Role:</h2>
							<? } else { ?>
							<h2>Manage Role: (<?= $myACL->getRoleNameFromID($_GET['roleID']); ?>)</h2><? } ?>
							<form action="roles.php" method="post">
								<label for="roleName">Name:</label>
								<input type="text" name="roleName" id="roleName" value="<?= $myACL->getRoleNameFromID($_GET['roleID']); ?>" />
								<table border="0" cellpadding="5" cellspacing="0">
									<tr>
										<th></th><th>Allow</th><th>Deny</th><th>Ignore</th>
									</tr>
									<?
									$rPerms = $myACL->getRolePerms($_GET['roleID']);
									$aPerms = $myACL->getAllPerms('full');
									foreach ($aPerms as $k => $v)
									{
									echo "
									<tr>
										<td><label>" . $v['Name'] . "</label></td>";
										echo "<td>
										<input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_1\" value=\"1\"";
										if ($rPerms[$v['Key']]['value'] === true && $_GET['roleID'] != '') { echo " checked=\"checked\""; }
										echo " /></td>";
										echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_0\" value=\"0\"";
										if ($rPerms[$v['Key']]['value'] != true && $_GET['roleID'] != '') { echo " checked=\"checked\""; }
										echo " /></td>";
										echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_X\" value=\"X\"";
										if ($_GET['roleID'] == '' || !array_key_exists($v['Key'],$rPerms)) { echo " checked=\"checked\""; }
										echo " /></td>";
										echo "</tr>";
										}
										?>
								</table>
								<input type="hidden" name="action" value="saveRole" />
								<input type="hidden" name="roleID" value="<?= $_GET['roleID']; ?>" />
								<input type="submit" name="Submit" value="Submit" />
							</form>
							<form action="roles.php" method="post">
								<input type="hidden" name="action" value="delRole" />
								<input type="hidden" name="roleID" value="<?= $_GET['roleID']; ?>" />
								<input type="submit" name="Delete" value="Delete" />
							</form>
							<form action="roles.php" method="post">
								<input type="submit" name="Cancel" value="Cancel" />
							</form> <? } ?>
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
