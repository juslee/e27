<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0;>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/giveaway.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/content.css" media="screen" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/cufon.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/helvetica.thin.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/fonts/myriad.normal.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/init.js"></script>
	
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "ur-9a96cb1d-f102-c80a-d53a-202e2f1ef1b7"});</script>
	
	<title><?php echo $giveaway['title']; ?> | E27 Giveaways</title>
	
</head>

<body>

	<!-- Begin Wrapper -->
	<div id="wrapper">
		
		<!-- Begin Header Area -->
		<div id="header">
			<a href="http://www.e27.sg"><img src="<?php echo base_url(); ?>images/logo_e27_large.png" alt="E27 Logo" /></a>
		</div>
		<!-- End Header Area -->
		
		<!-- Begin Banner Area -->
		<div id="banner">
			<img src="<?php echo base_url(); ?>banners/<?php echo $giveaway['banner_file']; ?>" alt="<?php echo $giveaway['title']; ?>" />
		</div>
		<!-- End Banner Area -->
		
		<!-- Begin Content Area -->
		<div id="content">
			<div id="content-description">
				<h2><?php echo $giveaway['title']; ?></h2>
				<?php echo $giveaway['description']; ?>
				<p id="ending_date">Ending on <?php echo date('d M Y', strtotime($giveaway['end_date'])); ?></p>
				
				<?php echo $giveaway['legal']; ?>
			</div>
			<div id="content-form">
<?php echo $content; ?>
			</div>
			<div class="clearfloat"></div>
		</div>
		<!-- End Content Area -->
		
	</div>
	<!-- End Wrapper -->
</body>

</html>