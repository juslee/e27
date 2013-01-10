<?php
@session_start();
$this->load->helper('url');
//force www
if($_SERVER['HTTP_HOST']!="localhost"&&strpos($_SERVER['HTTP_HOST'], "www.")===false){
	$qs = "";
	if($_SERVER['QUERY_STRING']){
		$qs = "?".$_SERVER['QUERY_STRING'];
	}
	header ('HTTP/1.1 301 Moved Permanently');
	header("Location: ".sanitizeX("http://www.".$_SERVER['HTTP_HOST']."/".uri_string().$qs));
	exit();
}

$editmode = false;
if($method=='editcompany'){
	$editmode = true;
}

//linkedin
if(!$_SESSION['web_user']){
	$config['base_url']             =   'http://www.startuplist.sg/media/startuplist/linkedin/auth.php';
	$config['callback_url']         =   'http://www.startuplist.sg';
	$config['linkedin_access']      =   'ivfdie7hflz3';
	$config['linkedin_secret']      =   'SQ7Tp9Vxf2i5KDsz';
	include_once dirname(__FILE__)."/../../../media/startuplist/linkedin/linkedin.php";
	# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
	$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
	//$linkedin->debug = true;
	//print_r($_SESSION);
	if (isset($_REQUEST['oauth_verifier'])){
		$_SESSION['oauth_verifier'] = $_REQUEST['oauth_verifier'];
		$linkedin->request_token    =   unserialize($_SESSION['requestToken']);
		$linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
		$linkedin->getAccessToken($_REQUEST['oauth_verifier']);
		$_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
		header("Location: " . $config['callback_url']);
		exit;
	}
	else{
		$linkedin->request_token    =   unserialize($_SESSION['requestToken']);
		$linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
		$linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
	}
	# You now have a $linkedin->access_token and can make calls on behalf of the current member
	$xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url,public-profile-url)");
	if($xml_response){
		$linkedinarr = getXMLtoArr($xml_response);
		if($linkedinarr['id']){
			/*
			echo '<pre>';
			echo 'My Profile Info';
			echo $xml_response;
			echo '<br />';
			print_r($linkedinarr);
			$json = json_encode($linkedinarr);
			echo $json; 
			$a = (json_decode($json));
			$a = objectToArray($a);
			echo $a['first-name'];
			*/
			//check in linkedin use already exists
			$sql = "select * from `web_users` where `in_id`='".mysql_real_escape_string($linkedinarr['id'])."'";
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];

			if(!$web_user['id']){
				$sql = "insert into `web_users` set 
					`in_id` = ".$this->db->escape($linkedinarr['id']).",
					`in_name` = ".$this->db->escape($linkedinarr['first-name']." ".$linkedinarr['last-name']).",
					`in_data` = ".$this->db->escape(json_encode($linkedinarr)).",
					`dateadded` = NOW();
				";	
				$q = $this->db->query($sql);
				$userid = $this->db->insert_id();
				
			}
			else{
				$sql = "update `web_users` set 
					`in_id` = ".$this->db->escape($linkedinarr['id']).",
					`in_name` = ".$this->db->escape($linkedinarr['first-name']." ".$linkedinarr['last-name']).",
					`in_data` = ".$this->db->escape(json_encode($linkedinarr)).",
					`dateupdated` = NOW()
					where `in_id`=".$this->db->escape($linkedinarr['id']);	
				$q = $this->db->query($sql);
			}
			$sql = "select * from `web_users` where `in_id`=".$this->db->escape($linkedinarr['id']);
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$_SESSION['web_user'] = $web_user[0];
		}
	}
}

if($_SESSION['web_user']&&!$_SESSION['web_user']['business_email']&&($_SESSION['web_user']['fb_data']||$_SESSION['in_data'])&&!$_GET['missingemail']){
	header("Location: " . site_url()."editaccount?missingemail=1");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php
$metatitle = "Startup List";
$method = $this->router->method;
if($method!="index"&&$method!="country"){
	$metatitle .= " | "; 
	if($person['name']){
		$metatitle .= strip_tags($person['name']);
	}
	else if($company['name']){
		$metatitle .= strip_tags($company['name']);
	}
	else if($investment_org['name']){
		$metatitle .= strip_tags($investment_org['name']);
	}
	if($method=="account"){
		$metatitle .= "Account";
	}
}
else if($_SESSION['country']){
	$metatitle .= " | "; 
	$metatitle .= ucfirst($_SESSION['country']);
}
echo $metatitle;
?></title>
<?php
if($method!="index"&&$method!="country"){
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
else if($_SESSION['country']){
	$metadesc = ucfirst($_SESSION['country']);
	$metakw = ucfirst($_SESSION['country']);
	?>
	<meta name="description" content="<?php echo sanitizeX($metadesc); ?>" />
	<meta name="keywords" content="<?php echo sanitizeX($metakw); ?>" />
	<?php

}

//facebook
$og_url = sanitizeX(site_url().uri_string());
echo '<meta property="og:type" content="website" />';
echo '<meta property="og:url" content="'.$og_url.'" />';
echo '<meta property="og:title" content="'.$metatitle.'" />';

if(trim($company['logo'])){
	$og_image = site_url()."media/image.php?p=".$company['logo']."&mx=200";
}
else if(trim($person['profile_image'])){
	$og_image = site_url()."media/image.php?p=".$person['profile_image']."&mx=200";
}
else if(trim($investment_org['logo'])){
	$og_image = site_url()."media/image.php?p=".$investment_org['logo']."&mx=200";
}
else{
	$logo = urlencode(site_url()."media/startuplist/noimage.jpg");
	$og_image = site_url()."media/image.php?p=".$logo."&mx=250";
	/*?><link rel="image_src" href="<?php echo site_url(); ?>media/image.php?p=<?php echo $logo; ?>&mx=250" /><?php	*/
}
echo '<meta property="og:image" content="'.$og_image.'" />';
echo '<meta property="og:description" content="'.$metadesc.'" />';
//echo '<meta property="fb:admins" content="'.$fb_admins.'" />';
//echo '<meta property="fb:app_id" content="'.$fb_app_id.'" />';

/*
?>
<script language="javascript" src="<?php echo site_url(); ?>media/js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="<?php echo site_url(); ?>media/js/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?php echo site_url(); ?>media/js/development-bundle/jquery-1.8.0.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.position.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.autocomplete.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.position.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="<?php echo site_url(); ?>media/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
*/
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script type="text/javascript" src="<?php echo site_url(); ?>media/js/jquery.alerts-1.1/jquery.alerts.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>media/js/jquery.alerts-1.1/jquery.alerts.css" media="screen" />
<script type="text/javascript" src="<?php echo site_url(); ?>media/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>media/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>media/js/uploadify/uploadify.css" media="screen" />
	
<!-- assets -->
<script language="javascript" src="<?php echo site_url(); ?>media/js/jquery.sharrre-1.3.4/jquery.sharrre-1.3.4.js"></script>
<?php
if(!$editmode){
	?>
	<link rel="stylesheet" href="<?php echo site_url(); ?>media/startuplist/slideshow.css">
	<script language="javascript" src="<?php echo site_url(); ?>media/startuplist/slides.min.jquery.js"></script>
	<link href="<?php echo site_url(); ?>media/js/tweet-master/tweet/jquery.tweet.css" rel="stylesheet"/>
	<script src="<?php echo site_url(); ?>media/js/tweet-master/tweet/jquery.tweet.js" charset="utf-8"></script>
	<?php
}
?>
<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>startuplist/assets/styles.css">
<script language="javascript" src="<?php echo site_url(); ?>startuplist/assets/javascript.js"></script>


</head>
<body class="font">
<div id="dialog" title="">
    <div id='dialoghtml'></div>
</div>
<div id="fb-root"></div>
<script>
refreshx = false;

function gotoAccount(){
	self.location = "<?php site_url(); ?>account";
}

function refreshPage(){
	self.location = self.location;
}

function logout(){
	formdata = "";
	jQuery.ajax({
		url: "<?php echo site_url(); ?>startuplist/ajax_logout",
		type: "POST",
		data: formdata,
		success: function(){
			refreshPage();
		}
	});
}



/***** facebook ********/
function saveFBUserData(userid, useremail, userdata){
	//alert(userid);
	//alert(useremail);
	//alert(userdata);
	formdata = "userid="+userid+"&useremail="+useremail+"&userdata="+userdata;
	jQuery.ajax({
		url: "<?php echo site_url(); ?>startuplist/ajax_saveFbUserData",
		type: "POST",
		data: formdata,
		success: function(){
		}
	});
	
}
function saveFBUserFriends (userid, userfriends){
	//alert(userid);
	//alert(userfriends);
	formdata = "userid="+userid+"&userfriends="+userfriends;
	jQuery.ajax({
		url: "<?php echo site_url(); ?>startuplist/ajax_saveFbUserFriends",
		type: "POST",
		data: formdata,
		dataType: "script",
		success: function(){
			<?php
			if($_GET['ref']){
				?>self.location="<?php echo $_GET['ref']; ?>"<?
			}
			else{
				?>refreshPage();<?php
			}
			?>
		}
	});
}
function fetchFBData() {
    //console.log('Welcome!  Fetching your information.... ');
	userdata = "";
	userid = "";
	useremail = "";
	userfriends = "";
    FB.api('/me', function(response) {
		html = jQuery('#fbdata').html();
		//jQuery('#fbdata').html(html+JSON.stringify(response));
		userdata = JSON.stringify(response);
		userid = response.id;
		useremail = response.email;
		if(userid){
			jQuery("#fb_logging").show();
			jQuery("#fb_loginbutton").hide();
			jQuery("#loggedin").html("<br />Logging in... <img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
			jQuery("#loggedin").show();
			jQuery("#loggedout").hide();
			jQuery("#login").hide();
			jQuery("#loggedin").html("<br />Logging in... <img src='<?php echo site_url(); ?>media/ajax-loader.gif' />");
			jQuery("#loggedin").show();
			saveFBUserData(userid, useremail, userdata);
			FB.api('/me/friends', function(response) {
				//html = jQuery('#fbdata').html();
				//jQuery('#fbdata').html(html+JSON.stringify(response));
				userfriends = JSON.stringify(response);
				saveFBUserFriends(userid, userfriends);
			});
		}
    });
}
function fb_login() {
	
	FB.login(function(response) {
			if (response.authResponse) {
				refreshx = true;
				fetchFBData();
				
				
			} else {	
			}
		},{scope: 'email'}
	);
}

function fb_logout(){
	/*
	jQuery("#loggedin").hide();
	FB.logout(function(response) {
		jQuery("#login").show();
		// user is now logged out
		logout();
	});
	*/
	logout();
}
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
window.fbAsyncInit = function() {
	FB.init({
	  appId      : '135632699922818', // App ID
	  channelUrl : '//www.startuplist.sg/fb-channel.php', // Channel File
	  status     : true, // check login status
	  cookie     : true, // enable cookies to allow the server to access the session
	  xfbml      : true  // parse XFBML
	});
	<?php
	if($_SESSION['web_user']['fb_id']&&0){
		?>
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				fetchFBData();
				jQuery("#login").hide();
				//alert('connected 1');
			} else if (response.status === 'not_authorized') {
				//alert('not authorized');
				//fb_login();
			} else {
				//alert('not logged in');
				//fb_login();
			}
		});
		<?php
	}
	?>
};



</script>

<?php
if(
$method=='editcompany' ||
$method=='editperson' ||
$method=='editinvestment_org' ||
$method=='addcompany' ||
$method=='addperson' ||
$method=='addinvestment_org' 
){
	?>
	<script>
	jQuery(function() {
			jQuery( document ).tooltip();
	});
	</script>
	<?php	
}

//echo "<pre>";
//print_r($_SESSION['web_user']);
//echo "</pre>";
?>
<div id='fbdata'></div>
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
							<td class='bannerleft left middle'>
							<div style='position:relative'>
							<a href="<?php echo site_url(); ?>"><img src="<?php echo site_url(); ?>media/startuplist/startuplist.png"></a>
							<img style='position:absolute; left:275px; top: -20px;' src="<?php echo site_url(); ?>media/startuplist/beta.png" /></div>
							</td>
							<td class='bannerright right  p100 hidden'><img src="<?php echo site_url(); ?>media/startuplist/banner.png"></td>
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
		<table cellpadding="0" cellspacing="0" class="searchcontent" width="100%">
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
					<div id='loggedout' <?php if($_SESSION['web_user']){ echo "style='display:none'"; } ?>>
						<table cellpadding="0" cellspacing="0" style='float:right'>
						<tr>
							<td class='pad5' style='padding-right:10px;'>
							<div style='padding-bottom:5px'><a href='<?php echo site_url(); ?>register'>Register</a></div>
							<a href='<?php echo site_url(); ?>userlogin'>Login</a>
							</td>
							<td style="text-align:center">
								<div onmouseover="jQuery('#logins').show()" onmouseout="jQuery('#logins').hide()" id='login' <?php if($_SESSION['web_user']){ echo "style='display:none'"; } ?>>Login w/
									<div id='logins'>
										<a id='fb_login' onclick='fb_login()'>Facebook</a>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a id='li_login' href='<?php echo site_url(); ?>media/startuplist/linkedin/auth.php'>Linkedin</a>
									</div>
								</div>
							</td>
						</tr>
						</table>
					</div>
					<div id='loggedin' <?php if($_SESSION['web_user']){ echo "style='display:block'"; } ?>>
					<table cellpadding="0" cellspacing="0" style='float:right'>
						<tr>
							<td class='pad5'>
							<a href='<?php echo site_url(); ?>account'>Account</a>
							</td>
							<td>
							<?php
							if($_SESSION['web_user']['fb_data']){
								$fb_data = json_decode($_SESSION['web_user']['fb_data']);
								//print_r($fb_data);
								$str = "<table cellpadding=0 cellspacing=0 style='float:right'><tr><td style='padding:5px;' class='fb_details'>Hello ".$fb_data->first_name."!<br /><a href='#' onclick='fb_logout(); return false;' style='color:#21913E' >Log Out</a></td><td><img style='height:48px; width:48px;' src='http://graph.facebook.com/".$fb_data->id."/picture' /></td></tr></table>";
								echo $str;
							}
							else if($_SESSION['web_user']['in_data']){
								$in_data = objectToArray(json_decode($_SESSION['web_user']['in_data']));
								//print_r($fb_data);
								$str = "<table cellpadding=0 cellspacing=0 style='float:right'><tr><td style='padding:5px;' class='fb_details'>Hello ".$in_data['first-name']."!<br /><a href='#' onclick='self.location=\"".site_url()."userlogout\"; return false;' style='color:#21913E' >Log Out</a></td><td class=''><img style='height:48px; width:48px;' src='".$in_data['picture-url']."' /></td></tr></table>";
								echo $str;
							}
							else if($_SESSION['web_user']['email']){
								//print_r($fb_data);
								$str = "<table cellpadding=0 cellspacing=0 style='float:right'><tr><td style='padding:5px;' class='fb_details'>Hello ".$_SESSION['web_user']['name']."!<br /><a href='#' onclick='self.location=\"".site_url()."userlogout\"; return false;' style='color:#21913E' >Log Out</a></td><td class='hidden'><img style='height:48px; width:48px;' src='http://graph.facebook.com/".$fb_data->id."/picture' /></td></tr></table>";
								echo $str;
							}
							?>
							</td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
		</table>
		</div>
	</td>
</tr>
<tr>
	<td>
		<?php
		if($method=='account'||$method=='register'||$layout2){
			echo $content;
		}
		else{
			?>
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
						$this->load->view("startuplist/contribute_block");
						
						if($method=='company'||$method=='person'||$method=='investment_org'||$method=='index'||$method=='register'){
							$this->load->view("startuplist/sharer");
						}
						//$this->load->view("startuplist/bannerad_block");
						
						/*
						$data = array();
						$data['newlyfunded'] = $newlyfunded;
						$this->load->view("startuplist/nfcompany_block", $data);
						*/
						
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
			<?php
		}
		?>
	</td>
</tr>
<tr>
	<td class='footer'>
		<?php
		$this->load->view("startuplist/footer");
		?>
	</td>
</tr>
</table>
</body>
</html>
