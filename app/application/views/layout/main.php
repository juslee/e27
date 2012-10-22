<?php
@session_start();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>E27</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		margin-top: 0px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
	td{
		vertical-align:top;
	}
	a {
		color: white;
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
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		/*-webkit-box-shadow: 0 0 8px #D0D0D0;*/
	}
	#header{
		background:#21913e;
		padding: 5px;
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
		font-size:11px;
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