
<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
	<tr>
		<td class="head">SHARE THIS PAGE</td>
	</tr>
	<tr>
		<td class="content">
		<table cellpadding="0" cellspacing="0" style='margin-left:3'>
		<tr>
			<td style="width:92px;">
				<div style="width:92px; overflow:hidden">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo site_url().uri_string(); ?>" data-text="E27 Startup List <?php

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


?>">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
			</td>
			<td style="width:87px;">
				<div style="width:87px; position:relative">
					<?php
					/*
					<div class="fb-like" data-href="<?php echo site_url().uri_string(); ?>" data-send="false" data-layout="button_count" data-width="87" data-show-faces="false"></div>
					<div style='position:absolute'>
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo site_url().uri_string(); ?>&layout=button_count"
        scrolling="no" frameborder="0"
        style="border:none; width:87px; height:80px"></iframe>
					
					</div>
					*/
					?>
					<div id="fbshareme" data-url="<?php echo site_url().uri_string(); ?>" data-text="Startup List <?php
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
					
					
					?>"></div>
					<script>
					jQuery('#fbshareme').sharrre({
						share: {
							facebook: true
						},
						buttons: {
							facebook: {layout: 'button_count'},
						},
						enableHover: false,
						enableCounter: false,
						enableTracking: true
					});
					</script>
				</div>
			</td>
			<td style="width:96px;">
				<div style="width:94px; overflow:hidden; padding-left:2px">
					<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="<?php echo site_url().uri_string(); ?>" data-counter="right"></script>
				</div>
			</td>
		</tr>
		</table>
<?php
/*
<style type="text/css">
#example5{
float:left;
margin:68px 25% 0 25%;
}
#shareme .button{
width:60px;
float: left;
margin-left:10px;
}
#shareme .facebook{
	width:50px;
}

</style>
<div id="shareme" data-url="<?php echo site_url().uri_string(); ?>" data-text="E27 Startup List <?php

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


?>"></div>
<script>
$('#shareme').sharrre({
	share: {
		//googlePlus: true,
		twitter: true,
		facebook: true,
		//digg: true,
		//delicious: true,
		//stumbleupon: true,
		linkedin: true,
		//pinterest: true
	},
	buttons: {
		//googlePlus: {size: 'tall'},
		twitter: {count: 'vertical'},
		facebook: {layout: 'box_count'},
		//digg: {type: 'DiggMedium'},
		//delicious: {size: 'tall'},
		//stumbleupon: {layout: '5'},
		linkedin: {counter: 'top'},
		//pinterest: {media: 'http://sharrre.com/img/example1.png', description: $('#shareme').data('text'), layout: 'vertical'}
	},
	enableHover: false,
	enableCounter: false,
	enableTracking: true
});
</script>

*/
?>

		</td>
	</tr>
</table>