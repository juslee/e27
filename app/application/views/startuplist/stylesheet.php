<?php
header("Content-type: text/css", true);
?>
body{
	margin-top:-2px;
	background:#fff;
	background: url(<?php echo site_url(); ?>media/startuplist/searchbg.png);
	background-position:0px 131px;
	
	background-repeat:repeat-x;
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
	/*-webkit-box-shadow: 0 0 8px #D0D0D0;*/
	/*
	border: 1px solid #D0D0D0;
	border: 1px solid #E5E5E5;
	border-radius: 5px 5px 5px 5px;
	box-shadow: 0 4px 10px #F0F0F0;
	*/
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
	padding-left:50px;
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
	
	border: 1px solid #eeeeee;
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
.sidebar_right{
	margin-left:10px;
	margin:15px;
	margin-top:15px;
	width:300px;
}

.sidebar_left{
	margin-top:15px;
	width:100%;
}

.sidebar_left .label{
	padding:3px;
	padding-top:6px;
}
.sidebar_left .value{
	padding:3px;
	padding-top:6px;
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
}
.seeall a:link, .seeall a:hover, .seeall a:visited {
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

.bold{
	font-weight:bold;
}

.padb5{
	padding-bottom:5px;
}

.padb10{
	padding-bottom:10px;
}

.padb20{
	padding-bottom:20px;
}

.padb15{
	padding-bottom:15px;
}

.padb25{
	padding-bottom:25px;
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

.hidden{
	display:none;
}

/********* main page filter ************/


#filter ul ul {
	display: none;
}

	#filter ul li:hover > ul {
		display: block;
	}


#filter ul {
	list-style: none;
	position: relative;
	display: inline-table;
	background: #21913f;
}
	#filter ul:after {
		content: ""; clear: both; display: block;
	}

	#filter ul li.inner {
		float: left;
		width:130px;
		text-align:left;
	}
	#filter ul li.outer {
		float: left;
		width:85px;
		text-align:left;
	}
		#filter ul li:hover {
			background: #21913f;
		}
			#filter ul li:hover a {
				color: #fff;
			}
		
		#filter ul li a {
			display: block; padding: 15px 10px 15px 10px;
			color: white; text-decoration: none;
			font-size:11px;
		}
		
		
	#filter ul ul {
		background: #21913f; border-radius: 0px; padding-left: 0;
		position: absolute; top: 100%;
		left:-50px;
	}
		#filter ul ul li {
			float: none; 
		}
			#filter ul ul li a {
				padding: 10px;
				color: #fff;
				
			}	
				#filter ul ul li a:hover {
					background: #21913f;
					text-decoration:underline;
				}




.company_left{
	width: 230px;
	padding-top:10px;
	padding-right:10px;
	padding-bottom:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.company_left .logo{
	height:220px;
	vertical-align:middle;
	text-align:center;
	border: 1px solid #f1efea;
	border-radius: 6px 6px 6px 6px;
}
.company_right{
	padding:10px;
	
}
.company_name{
	font-size:24px;
	color: #21913f;
	padding-top:5px;
	padding-bottom:20px;
	border-bottom: 1px solid #f1efea;
}
.description{
	padding-top:20px;
	padding-bottom:20px;
	border-bottom: 1px solid #f1efea;
	color:black;
	font-family:Arial, Helvetica, sans-serif;
}
.description_title{
	padding-bottom:20px;
	color:#7b7b7b;
}
.productgal{
	padding-top:20px;
	padding-bottom:20px;
	border-bottom: 1px solid #f1efea;
	color:black;
	font-family:Arial, Helvetica, sans-serif;
}
.productgal_title{
	padding-bottom:20px;
	color:#7b7b7b;
}