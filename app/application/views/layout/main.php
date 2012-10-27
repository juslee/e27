<?php
@session_start();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="http://e27.wpengine.netdna-cdn.com/wp-content/themes/e27sg/favicon.ico" />
	<title>E27 Startup List</title>


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

	
	<script type="text/javascript" src="<?php echo site_url(); ?>media/js/jquery.alerts-1.1/jquery.alerts.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>media/js/jquery.alerts-1.1/jquery.alerts.css" media="screen" />

	<script type="text/javascript" src="<?php echo site_url(); ?>media/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="<?php echo site_url(); ?>media/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>media/js/uploadify/uploadify.css" media="screen" />
	
	<script>
	jQuery(function(){
		jQuery(".datepicker").datepicker({ 
		onSelect: function(date) {
			},
		});
	
	});
	function alertX(data){
		jAlert(data);
	}
	
	function confirmX(data){
		return jConfirm(data);
	}
	
	
	
	</script>
	<style type="text/css">

	::selection{ background-color: #21913E; color: white; }
	::moz-selection{ background-color: #21913E; color: white; }
	::webkit-selection{ background-color: #21913E; color: white; }

	body {
		background-color: #f0f0f0;
		margin: 40px;
		margin-top: 0px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: black;
	}
	td{
		vertical-align:top;
	}
	a {
		color: black;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 0px 0 0 0;
	}
	form{
		margin:0px;
	}
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		/*-webkit-box-shadow: 0 0 8px #D0D0D0;*/
		border: 1px solid #E5E5E5;
    	border-radius: 5px 5px 5px 5px;
    	box-shadow: 0 4px 18px #C8C8C8;
		background:white;
	}
	.list{
		margin: 10px;
		/*border: 1px solid #D0D0D0;*/
		/*-webkit-box-shadow: 0 0 8px #D0D0D0;*/
		/*border: 1px solid #E5E5E5;*/
    	/*border-radius: 5px 5px 5px 5px;*/
		background:white;
	}
	.list table{
		border-collapse:collapse;
		border-radius: 5px 5px 5px 5px;
		width:100%;
	}
	.list th{
		border: 1px solid #D0D0D0;
		padding:5px;
		color: white;
		background: #666666;
	}
	.list td{
		border: 1px solid #D0D0D0;
		padding:5px;
	}
	#header{
		background:#21913e;
		padding: 5px;
	}
	#header a{
		color:white;	
	}
	#menus{
		background:black;
		color:white;
		padding:0px;
		height: 34px;
	}
	#menus ul{
		margin:0px;
		padding:7px;
		
	}
	#menus li{
		margin:0px;
		list-style:none;
		display:inline;
		padding:10px;
		cursor:pointer;
	}
	#menus li:hover, #menus li.selected{
		background:orange;
	}
	
	#content{
		padding:10px;
	}
	*{
		font-family: Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.font14{
		font-size:14px;
	}
	.font16{
		font-size:16px;
	}
	.font18{
		font-size:18px;
	}
	.bold{
		font-weight:bold;
	}
	.red{
		color:red;
	}
	.right{
		text-align:right;
	}
	.left{
		text-align:left;
	}
	.center{
		text-align:center;
	}
	.pad10{
		padding: 10px;
	}
	
	/* add company */
	.hint{
		font-size:10px;
		font-style:italic;
		color:#666666;
		display:inline;
		padding: 0px 5px 0px 5px;
	}
	
	input[type="password"], input[type="text"], textarea{
		border: 1px solid #aaaaaa;
    	border-radius: 3px 3px 3px 3px;
		padding:4px;
		width:220px;
	}
	input[name="name"]{
		width:350px;
	}
	input[type="submit"], input[type="button"]{
		min-width: 80px;
		min-height: 40px;
		cursor:pointer;	
	}
	
	#savebutton{
		width:200px;
		height: 40px;
	}
	input[type="button"].button{
		min-height: 25px;
		min-width: 50px;
		cursor:pointer;	
	}
	textarea{
		width: 350px;
		height: 80px;
	}
	select[multiple="multiple"]{
		height: 150px;
		width: 250px;
		padding: 5px;
	}
	.even{
		
		background:#EEEEEE;
	}
	.odd{
		background:#FFFFFF;
	}
	.inline{
		display:inline;
	}
	.block{
		display:block;
	}
	.row:hover{
		background:#FFDB96;
	}
	.inline{
		display:inline;
	}
	</style>
</head>
<body>

<div id="container">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td id='header'>
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td><img onclick='self.location="<?php echo site_url(); ?>"' src="<?php echo site_url()."media/logo.png"; ?>"  style='cursor:pointer'/></td>
						<?php
						if($user){ //if logged in
							?>
							<td class='right'><a href='<?php echo site_url(); ?>main/logout'>Log Out</a></td>
							<?php
						}
						?>
					</tr>
				</table>	
		</tr>
		<tr>
			<td id='menus'>
				<?php
				if($user){ //if logged in
					?>
					
							<?php
							$this->load->view("layout/menus");
							?>
						
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td id='content'>
				<?php
				if($content&&$user){
					echo $content;
				}
				else if(!$user){ //if not logged in
					$this->load->view("layout/login");
				}
				else{
					?>
					hello world
					<?php
				}
				?>
			</td>
		</tr>
	</table>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>