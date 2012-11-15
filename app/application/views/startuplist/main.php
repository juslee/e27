<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Startup List</title>
<script language="javascript" src="<?php echo site_url(); ?>media/js/jquery-1.7.2.min.js"></script>
<style>
body{
	margin-top:-2px;
	background:#fff;
}
td{
	vertical-align:top;
	text-align:left;
	font-weight:500;
}
*{
	
}
.font{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.bar{
	width:100%;
}
.bar td{
	text-align:center;
	vertical-align:middle;
	color:white;
	font-size:12px;
	background: #21913f;
	height:30px;
	padding-top:5px;
}
.bar a:link, .bar a:visited, .bar a:hover{
	color: #ffea00;
}
.barbottom{
	background: url(<?php echo site_url(); ?>media/startuplist/barbottom.png);
	background-repeat:repeat-x;
	height:10px;
	bottom:-13px;
}
.maindiv{
}
.maintable{
	width:1200px;
	margin:auto;
	border: 1px solid #D0D0D0;
	/*-webkit-box-shadow: 0 0 8px #D0D0D0;*/
	border: 1px solid #E5E5E5;
	border-radius: 5px 5px 5px 5px;
	box-shadow: 0 4px 10px #F0F0F0;
	background:white;
	border-top:0px;
}
.banner{
	vertical-align:top;
	height:133px;
	background:white;
}
.bannercontentcontainer{
	background:white;
	height:133px;
	width: 1198px;
}
.bannercontent{
	width:100%;
	height:100%
}
.bannerlinks{
	padding:10px;
}
.bannerlinks a:link, .bannerlinks a:hover, .bannerlinks a:visited{
	text-decoration:none;
	color: gray;
}
.bannerleft{
	padding-left:50px;
}
.bannerright{
	padding-right:50px;
}
.search{
	height:53px;
	background:white;
}
.searchcontentcontainer{
	width:1198px;
	background: url(<?php echo site_url(); ?>media/startuplist/searchbg.png);
	background-repeat:repeat-x;
}
.searchleft{
	padding-left:48px;
	padding-top:10px;
	padding-bottom:10px;
}
.searchtext{
	color:#a9a9a9;
	background-color: #fff;
	/*
	box-shadow: inset 0 1px 5px rgba(0,0,0,.1), 
	0 0 0 1px #cdcdcd;
	*/
	height:29px;
	border: 1px solid #AAAAAA;
    border-radius: 3px 3px 3px 3px;
	width:400px;
	padding-left:10px;
}
.contents{
	height:500px;
	width:790px;
	background:#FFFFFF;
	padding-left:50px;
}

.contentshead{
	margin-bottom:10px;
	width:770px;
}
.contentsheadleft {
	width:50%;
	padding-top:30px;
	padding-bottom:30px;
	font-size:24px;
	color: #21913f;
}
.contentsheadright{
	width:50%;
	padding-top:5px;
}
.contentblock{
	border-radius: 6px 6px 6px 6px;
	border: 1px solid #eeeeee;
	width:170px;
}
.companyblockcontainer{
	padding:15px;
}
.first{
	padding-left:0px;
}
.last{
	padding-right:0px;
}
.contentblock .head{
	background:  #f8f8f8;
	padding:7px;
	
	border-bottom: 1px solid #eeeeee
	font-size:13px;
}
.contentblock .head a:link, .contentblock .head a:hover, .contentblock .head a:visited{
	color: #21913e;
	text-decoration: none;
}
.contentblock .head a{
	color: #21913f;
}
.contentblock .content{
	padding:10px;
	font-family:Arial, Helvetica, sans-serif;
	color: #666666;
	height:65px;
}
.contentblock .logo{
	height:168px;
	width:168px;
	padding: 5px 0px 5px 0px;
	vertical-align:middle;
	text-align:center;
}
.contentblock .label{
	padding-right:10px;
	padding-top:2px;
}
.contentblock .value{
	padding-top:2px;
}
.contentblock .small a{
	font-size:10px;
}

.contentblock a:link, .contentblock a:hover, .contentblock a:visited{
	color: #7caae5;
}

.loadmore{
	margin:20px;
	text-align:center;
}


/********* sidebar ************/

.sidebar{
	background:white;
	width:360px;
}
.sidebarblockcontainer{

}

.sidebarblock{
	border-radius: 6px 6px 6px 6px;
	margin:15px;
	border: 1px solid #eeeeee;
	width:300px;
	margin-left:30px;
	margin-right:0px;
}
.sidebarblock .head{
	background:  #f8f8f8;
	padding:7px;
	color: #21913f;
	border-bottom: 1px solid #eeeeee
	font-size:13px;
}
.sidebarblock .content{
	padding:10px;
	font-family:Arial, Helvetica, sans-serif;
	color: #666666;
}

.sidebarblock a:link, .sidebarblock a:hover, .sidebarblock a:visited{
	color: #7caae5;
}

/********* newly funded ************/

.nflogo{
	height:50px;
}

.newlyfunded{
	margin-bottom:5px;
}

.seeall{
	text-align:right;
	margin:5px;
	margin-top:10px;
	color: #21913e;
}

/********* common ************/

.absolute{
	position:relative;
}

.relative{
	position:relative;
}
.p100{
	width:100%;
}
.left{
	text-align:left;
}
.right{
	text-align:right;
}
.center{
	text-align:center;
}
.top{
	vertical-align:top;
}
.middle{
	vertical-align:middle;
}
.bottom{
	vertical-align:bottom;
}
.padleft10{
	padding-left:10px;
}
.pointer{
	cursor:pointer;
}

img.rounded{
    background-clip: padding-box;
    border-radius: 20% 20% 20% 20%;
    height: auto
}

.pad3{
	padding:3px;
}

.pad5{
	padding:5px;
}

.pad10{
	padding:10px;
}

/********* main page filter ************/


ul ul {
	display: none;
}

	ul li:hover > ul {
		display: block;
	}


ul {
	list-style: none;
	position: relative;
	display: inline-table;
	background: #21913f;
}
	ul:after {
		content: ""; clear: both; display: block;
	}

	ul li.inner {
		float: left;
		width:130px;
		text-align:left;
	}
	ul li.outer {
		float: left;
		width:85px;
		text-align:left;
	}
		ul li:hover {
			background: #21913f;
		}
			ul li:hover a {
				color: #fff;
			}
		
		ul li a {
			display: block; padding: 15px 10px 15px 10px;
			color: white; text-decoration: none;
			font-size:11px;
		}
		
		
	ul ul {
		background: #21913f; border-radius: 0px; padding-left: 0;
		position: absolute; top: 100%;
		left:-50px;
	}
		ul ul li {
			float: none; 
		}
			ul ul li a {
				padding: 10px;
				color: #fff;
				
			}	
				ul ul li a:hover {
					background: #21913f;
					text-decoration:underline;
				}




.company_left{
	width: 230px;
	padding-top:10px;
	padding-right:10px;
	padding-bottom:10px;
}
.company_right{
	padding:10px;
}
.company_name{
	font-size:24px;
	color: #21913f;
	padding-top:5px;
}

</style>
<script>
/********************************** number formating *****************************/
	
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function fNum(num){
	num = uNum(num);
	num = num.toFixed(2);
	return addCommas(num);
}
function uNum(num){
	if(!num){
		num = 0;
	}
	else if(isNaN(num)){
		num = num.replace(/[^0-9\.]/g, "");
		if(isNaN(num)){
			num = 0;
		}
	}
	return num*1;
}

jQuery(function(){
	sbcposition = jQuery(".sidebarblockcontainer").position();
	sbcheight = jQuery(".sidebarblockcontainer").height();
	
	jQuery(window).resize(function () {
		pos = jQuery(".sidebarblockcontainer").position();
		wh = uNum(jQuery(window).height());
		sh = uNum(jQuery(window).scrollTop())+uNum(jQuery(window).height()); //scroll plus window height
		ht = uNum(sbcheight )+uNum(sbcposition.top);
		st = uNum(jQuery(window).scrollTop());
		sl = uNum(jQuery(window).scrollLeft());

		jQuery(".sidebarblockcontainer").each(function(){
			if(jQuery(this).css("position")=="fixed"){
				//set to static
				jQuery(this).css("position", "static");
				//get position
				sbcposition = jQuery(".sidebarblockcontainer").position();
				//set back to fixed
				jQuery(this).css("position", "fixed");
			}
			jQuery(this).css("left", sbcposition.left-sl);
		});
		if(sbcheight>wh){
			if(sh-50>=ht){
				jQuery(".sidebarblockcontainer").each(function(){
					//pos = jQuery(this).position();
					//console.log("sbc top = ", sbcposition .top);
					//return false;
					if(jQuery(this).css("position")=="static"){
						jQuery(this).css("position", "fixed");
						//jQuery(this).css("top", (sbcheight-wh-sbcposition.top)-st));
						jQuery(this).css("top", (Math.abs(sbcheight-wh)*-1)-20); //-20 is some space at the bottom
						//jQuery(this).css("left", pos.left);
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		else{
			
			if(jQuery(window).scrollTop()+15>sbcposition.top){
				jQuery(".sidebarblockcontainer").each(function(){
					if(jQuery(this).css("position")=="static"){
						position = jQuery(this).position();
						if(jQuery(this).css("position")=="static"){
							jQuery(this).css("top", 0);
							jQuery(this).css("position", "fixed");
							
						}
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
	
	});
	jQuery(window).scroll(function () { 
		
		pos = jQuery(".sidebarblockcontainer").position();
		wh = uNum(jQuery(window).height());
		sh = uNum(jQuery(window).scrollTop())+uNum(jQuery(window).height()); //scroll plus window height
		ht = uNum(sbcheight )+uNum(sbcposition.top);
		st = uNum(jQuery(window).scrollTop());
		sl = uNum(jQuery(window).scrollLeft());

		jQuery(".sidebarblockcontainer").each(function(){
			if(jQuery(this).css("position")=="fixed"){
				//set to static
				jQuery(this).css("position", "static");
				//get position
				sbcposition = jQuery(".sidebarblockcontainer").position();
				//set back to fixed
				jQuery(this).css("position", "fixed");
			}
			jQuery(this).css("left", sbcposition.left-sl);
		});
		if(sbcheight>wh){
			if(sh-50>=ht){
				jQuery(".sidebarblockcontainer").each(function(){
					//pos = jQuery(this).position();
					//console.log("sbc top = ", sbcposition .top);
					//return false;
					if(jQuery(this).css("position")=="static"){
						jQuery(this).css("position", "fixed");
						//jQuery(this).css("top", (sbcheight-wh-sbcposition.top)-st));
						jQuery(this).css("top", (Math.abs(sbcheight-wh)*-1)-20); //-20 is some space at the bottom
						//jQuery(this).css("left", pos.left);
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		else{
			
			if(jQuery(window).scrollTop()+15>sbcposition.top){
				jQuery(".sidebarblockcontainer").each(function(){
					if(jQuery(this).css("position")=="static"){
						position = jQuery(this).position();
						if(jQuery(this).css("position")=="static"){
							jQuery(this).css("top", 0);
							jQuery(this).css("position", "fixed");
							
						}
					}
					
				});
				//jQuery(".sidebarblockcontainer").css("top", "0px");
			}
			else{
				jQuery(".sidebarblockcontainer").each(function(){
					position = jQuery(this).position();
					jQuery(this).css("position", "static");
					//console.log(position.top);
				});
			}
		}
		
	});

});
</script>
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
							<td class='bannerleft left middle'><img src="<?php echo site_url(); ?>media/startuplist/startuplist.png"></td>
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
