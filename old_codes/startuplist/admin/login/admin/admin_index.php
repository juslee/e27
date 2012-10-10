<?php
include("../../lib/dbcon.php");
include("../../classes/class.acl.php");
/*
$myACL = new ACL();
if ($myACL->hasPermission('access_admin') != true)
{
header("location: ../login/noentry.php");
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
								<a href="" class="user_admin">User Admin</a>
							</li>
						</ul>
					</div>

					<div id="table-content">
						<div id="page">
							<h2>Click buttons above to navigate.</h2>

						</div>
						<div class="clear"></div>
					</div>
					<!--  end table-content  -->
				</div>
			</div>
		</div>
		<!-- close wrapper -->
	</body>
</html>
