<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Startup List</title>
<script language="javascript" src="<?php echo site_url(); ?>media/js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="<?php echo site_url(); ?>media/startuplist/slideshow.css">
<script language="javascript" src="<?php echo site_url(); ?>media/startuplist/slides.min.jquery.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>startuplist/assets/styles.css">
<script language="javascript" src="<?php echo site_url(); ?>startuplist/assets/javascript.js"></script>
</head>
<body class="font">
<table cellpadding="0" cellspacing="0" class='maintable'>
<tr>
	<td class="banner">
		<div class="bannercontentcontainer">
		<table class="bannercontent" cellpadding="0" cellspacing="0">
			<tr>
				<td class="bannerlinks">
					<a href="http://e27.sg">e27 HOME</a>
				</td>
			</tr>
			<tr>
				<td>
					<table class="p100" cellpadding="0" cellspacing="0">
						<tr>
							<td class='bannerleft left middle'><a href="<?php echo site_url(); ?>startuplist"><img src="<?php echo site_url(); ?>media/startuplist/startuplist.png"></a></td>
							<td class='bannerright right  p100'><img src="<?php echo site_url(); ?>media/startuplist/banner.png"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</div>
	</td>
</tr>
<tr>
	<td class="search">
		<div class="searchcontentcontainer">
		<table cellpadding="0" cellspacing="0" class="searchcontent">
			<tr>
				<td class="searchleft">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<input type='text' class='searchtext' placeholder="Search Startup List" />
							</td>
							<td class="padleft10">
								<img src="<?php echo site_url(); ?>media/startuplist/searchbutton.png">
							</td>
						</tr>
					</table>
				</td>
				<td class="searchright">
					
				</td>
			</tr>
		</table>
		</div>
	</td>
</tr>
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" class="p100">
			<tr>
				<td class="contents">
					<?php
					echo $content;
					?>
				</td>
				<td class="sidebar">
					<div class="sidebarblockcontainer">
					<?php
					$data = array();
					$data['newlyfunded'] = $newlyfunded;
					$this->load->view("startuplist/nfcompany_block", $data);
					?>
					
					
					</div>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>
