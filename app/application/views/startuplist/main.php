<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Startup List<?php

$method = $this->router->method;
if($method!="index"){
	echo " | "; 
	if($person['name']){
		echo strip_tags($person['name']);
	}
	else if($company['name']){
		echo strip_tags($company['name']);
	}
	else if($investment_org['name']){
		echo strip_tags($investment_org['name']);
	}
}
?></title>
<?php
if($method!="index"){
	if($person['description']){
		$metadesc = strip_tags($person['description']);
	}
	else if($company['description']){
		$metadesc = strip_tags($company['description']);
	}
	else if($investment_org['description']){
		$metadesc = strip_tags($investment_org['description']);
	}
	
	if($person['tags']){
		$metakw = strip_tags($person['tags']);
	}
	else if($company['tags']){
		$metakw = strip_tags($company['tags']);
	}
	else if($investment_org['tags']){
		$metakw = strip_tags($investment_org['tags']);
	}
	?>
	<meta name="description" content="<?php echo sanitizeX($metadesc); ?>" />
	<meta name="keywords" content="<?php echo sanitizeX($metakw); ?>" />
	<?php
}
?>
<script language="javascript" src="<?php echo site_url(); ?>media/js/jquery-1.7.2.min.js"></script>
<?php /* <script language="javascript" src="<?php echo site_url(); ?>media/js/jquery.sharrre-1.3.4/jquery.sharrre-1.3.4.js"></script> */ ?>
<link rel="stylesheet" href="<?php echo site_url(); ?>media/startuplist/slideshow.css">
<script language="javascript" src="<?php echo site_url(); ?>media/startuplist/slides.min.jquery.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>startuplist/assets/styles.css">
<script language="javascript" src="<?php echo site_url(); ?>startuplist/assets/javascript.js"></script>


<?php
if(trim($company['logo'])){
	?><link rel="image_src" href="<?php echo site_url(); ?>media/image.php?p=<?php echo $company['logo'] ?>&mx=250" /><?php
}
else if(trim($person['profile_image'])){
	?><link rel="image_src" href="<?php echo site_url(); ?>media/image.php?p=<?php echo $person['profile_image'] ?>&mx=250" /><?php
}
else if(trim($investment_org['logo'])){
	?><link rel="image_src" href="<?php echo site_url(); ?>media/image.php?p=<?php echo $investment_org['logo'] ?>&mx=250" /><?php
}
else{
	$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
	?><link rel="image_src" href="<?php echo site_url(); ?>media/image.php?p=<?php echo $logo; ?>&mx=250" /><?php	
}
?>
</head>



<body class="font">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
								<input type='text' id='q' class='searchtext' placeholder="Search Startup List" value="<?php echo sanitizeX($search); ?>" />
							</td>
							<td class="padleft10">
								<img src="<?php echo site_url(); ?>media/startuplist/searchbutton.png" class='pointer' onclick='searchForIt()'>
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
					if($method=='company'||$method=='person'||$method=='investment_org'){
						$this->load->view("startuplist/sharer");
					}
					
					$this->load->view("startuplist/bannerad_block");
					
					
					
					
					
					$data = array();
					$data['newlyfunded'] = $newlyfunded;
					$this->load->view("startuplist/nfcompany_block", $data);

					$data = array();
					if(is_array($feeds)){
						$data['feeds'] = $feeds;
						$this->load->view("startuplist/related_e27_articles_block", $data);
					}
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
