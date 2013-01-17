<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/content.css" media="screen" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/cufon.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/helvetica.thin.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/myriad.normal.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/init.js"></script>
	
	<title><?php echo $website_title; ?> - Admin Dashboard</title>

</head>

<body>
	<!-- Begin Login Section -->
	<div id="login_panel">
		<div id="login_header">
			<h1 id="title"><?php echo $website_title; ?></h1>
			<h2 id="subtitle">Admin Login</h2>
		</div>
		<div id="login_content">
			<form id="login_form" method="post" action="<?php echo site_url('cpanel'); ?>">
			<p>
				<label>Email</label> <input type="text" name="email" value="<?php echo $email; ?>" /><br />
				<label>Password</label> <input type="password" name="password" /><br />
				<span class="error"><?php echo $error_message; ?></span><br />
				<a href="javascript:void(0)" id="login_button" onclick="$('#login_form').submit()"></a>
			</p>
			</form>
		</div>
	</div>
	<!-- End Login Section -->
</body>

</html>