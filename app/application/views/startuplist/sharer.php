<table cellpadding="0" cellspacing="0" class='sidebarblock sidebar_right' >
	<tr>
		<td class="content" style="height:70px">
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
		googlePlus: true,
		facebook: true,
		twitter: true,
		digg: true,
		//delicious: true,
		//stumbleupon: true,
		//linkedin: true,
		//pinterest: true
	},
	buttons: {
		googlePlus: {size: 'tall'},
		facebook: {layout: 'box_count'},
		twitter: {count: 'vertical'},
		digg: {type: 'DiggMedium'},
		//delicious: {size: 'tall'},
		//stumbleupon: {layout: '5'},
		//linkedin: {counter: 'top'},
		//pinterest: {media: 'http://sharrre.com/img/example1.png', description: $('#shareme').data('text'), layout: 'vertical'}
	},
	enableHover: false,
	enableCounter: false,
	enableTracking: true
});
</script>

		</td>
	</tr>
</table>