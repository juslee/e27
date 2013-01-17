<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/admin.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/content.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.ui.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>scripts/wysiwyg/css/redactor.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>scripts/facebox/facebox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datatables.css" media="screen" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/cufon.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/helvetica.thin.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/myriad.normal.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/wysiwyg/redactor.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/facebox/facebox.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/init.js"></script>
	
	<title><?php echo $website_title; ?> - Admin Panel</title>

</head>

<body>
	<!-- Begin Menu Section -->
	<div id="panel_menu">
		<p>
			<img src="<?php echo base_url(); ?>images/logo_e27.png" width="58" height="58" />
		</p>
		<p>
			<a href="<?php echo site_url('cpanel/giveaways'); ?>" id="menu_giveaways" title="Manage Giveaways" ></a>
			<a href="<?php echo site_url('cpanel/users'); ?>" id="menu_users" title="Manage Users" ></a>
		</p>
		<p>
			<a href="<?php echo site_url('cpanel'); ?>" id="menu_logout" title="Logout" ></a>
		</p>
	</div>
	<!-- End Menu Section -->
	<!-- Begin Main Panel Section -->
	<div id="panel_main">
		<!-- Begin Header Section -->
		<div id="header">
			<h1 id="title">Admin Panel</h1>
			<h2 id="subtitle"><?php echo $breadcrumbs; ?></h2>
			<h3 id="current_user">Logged in as <?php echo $user_name; ?> (<a href="<?php echo site_url("/cpanel/modify_user/".$user_id); ?>">Edit</a>)</h3>
		</div>
		<!-- End Header Section -->
		<!-- Begin Content Section -->
		<div id="content">
			<?php echo $content; ?>
		</div>
		<!-- End Content Section -->
	</div>
	<!-- End Main Panel Section -->
</body>

</html>