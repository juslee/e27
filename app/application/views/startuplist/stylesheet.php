<?php
header("Content-type: text/css", true);
?>
body{
	margin-top:0px;
	margin-bottom:50px;
	background:#fff;
	background: url(<?php echo site_url(); ?>media/startuplist/searchbg.png);
	background-position:0px 133px;
	
	background-repeat:repeat-x;
}
td{
	vertical-align:top;
	text-align:left;
	font-weight:500;
}
textarea{
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
}
a:link, a:hover, a:visited{
	color: #21913E;
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
	padding-top:7px;
	padding-bottom:10px;
}
.searchright{
	padding-right:45px;
	vertical-align:middle;
	text-align:center;
	width:300px;
	
}
.searchright #login{
	background:#21913F;
	color:white; 
	height:32px;
	padding-top:18px;
	position:relative;
	cursor:pointer;
	width:80px;
	float:right;
	margin-top:-4px;
}
.searchright #loggedin{
	height:50px;
	position:relative;
	display:none;
	text-align:right;
	margin-top:-3px;
}
#logins{
	position:absolute;
	background:#21913F;
	color:white; 
	height:32px;
	padding-top:18px;
	width: 187px;
	left:-107px;
	top:50px;
	display:none;
}
#logins a:hover{
	text-decoration:underline;
	color:white; 
}

.fb_details{
	color:#21913F;
}


input[type="text"].searchtext {
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

.contents2{
	height:500px;
	width:790px;
	background:#FFFFFF;
	padding-left:50px;
	padding-right:50px;
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

.padb5{
	padding-bottom:5px;
}

.pad10{
	padding:10px;
}

.pad20{
	padding:20px;
}

.pad30{
	padding:30px;
}

.hidden{
	display:none;
}

.inline{
	display:inline;
}
.right{
	float:right;
}
.left{
	float:left;
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
	width: 220px;
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
.person_role{
	font-size:16px;
	color:gray;
	padding-top:2px;
}
.person_company{
	font-size:16px;
	color:gray;
	padding-top:2px;
}
.person_company a:link, .person_company a:visited, .person_company a:hover{
	font-size:16px;
	color:#7CAAE5;
	text-decoration:none;
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

.productgal .title{
	padding-top:20px;
	color:#7b7b7b;
	text-align:center;
}

.seachblock{
	margin-bottom:10px;
	
}
.search_results{
	color:black;
	font-size:12px;
	padding-top:20px;
}
.seachblock .logo{
	/*
	border-radius: 6px 6px 6px 6px;
	border: 1px solid #eeeeee;
	*/
	width:60px;
	height:60px;
	
}

.seachblock .logo img.rounded{
    background-clip: padding-box;
    border-radius: 6px 6px 6px 6px;
    height: auto
	margin-right:10px;
}


.seachblock .name a:link, .seachblock .name a:hover, .seachblock .name a:visited, .seachblock .name a{
	color: #4c8bdc;
	font-weight:bold;
	font-size:14px;
	text-decoration:none;
}
.seachblock .name{
	padding:5px;
	padding-left:15px;
	padding-top:0px;
}
.seachblock .type{
	padding:5px;
	padding-left:15px;
	padding-top:0px;
	color:gray;
}
.seachblock .description{
	padding:5px;
	padding-left:15px;
	padding-top:0px;
	padding-bottom:0px;
	border-bottom:0px;
}

.tenure{
	font-size:12px;
	color:gray;
}


/********** account ***********/

.account{
}
.account_left{
	width: 220px;
	padding-right:10px;
	padding-bottom:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.account_left .logo{
	height:168px;
	width:168px;
	padding: 5px 0px 15px 0px;
	vertical-align:middle;
	text-align:center;
	
}

.account_left .sidebar_left, .account_right .sidebar_right{
	margin:0px;
	margin-bottom:15px;
	width: 220px;
}
.account_center{
	width:660px;
	padding-left:10px;
	padding-right:10px;
}
.account_head{
	font-size:24px;
	color: #21913f;
	padding-top:0px;
	padding-bottom:20px;
	border-bottom: 1px solid #f1efea;
}
.account_right{
	width: 220px;
	padding-left:10px;
	padding-bottom:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.breadcrumbs{
	padding:20px;
}
.contribute div{
	padding-bottom:5px;
	/*font-weight:bold;*/
}

.edit a:link, .edit a:hover, .edit a:visited{
	/*color: #21913E;*/
	color:#505050;
	
}

.parted{
	background:#21913f;
}
.parted a:link, .parted a:hover, .parted a:visited{
	color:white;
}


/* add company */
.hint{
	font-size:10px;
	font-style:italic;
	color:#666666;
	display:inline;
	padding: 0px 5px 0px 5px;
}
.more{
	font-size:10px;
	color:#666666;
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
	cursor:pointer;	
	padding-top:10px;
	padding-bottom:10px;
}

input[type="button"].button{
	min-width: 50px;
	cursor:pointer;	
}
input[type="button"].normal{
	padding:2px;
}

#savebutton{
	width:100%;
	padding-top:10px;
	padding-bottom:10px;
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
	/*
	background:#EEEEEE;
	*/
	background:#FFFFFF;
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
.border{
	border: 1px solid #CCCCCC;
	border-radius: 3px 3px 3px 3px;
}
.hidden{
	display:none;
}
.cursor{
	cursor:pointer;
}

#peoplehtml table, 
#companyhtml table, 
#investment_orghtml table, 
#competitors_html table,
#milestoneshtml table
{
	border-collapse:collapse;
}
#peoplehtml table td, 
#companyhtml table td, 
#investment_orghtml table td, 
#competitors_html table td,
#milestoneshtml table td
{
	padding: 2px 5px 2px 5px;
	border: 1px solid #AAAAAA;
}



#fundinghtml{
	width:100%;
}
#fundinghtml .label{
	background:#505050;
	width:15%;
	color:#FFFFFF;
	font-size:11px;
}

#fundinghtml .label_ipc{
	background:#CCCCCC;
}

#fundinghtml .value0{
	font-size:11px;
}
#fundinghtml .value1{
	width:20%;
	font-size:11px;
}
#fundinghtml .value2{
	width:50%;
	
}

.fundingtable{
	width:100%;
	border:1px solid #CCCCCC;
	margin-bottom:10px;
}
.fundingtable td{
	padding:4px;
}

.underline{
	text-decoration:underline;
}

.milestone{
	padding:5px;
	margin:5px;
	background:white;
	font-size:11px;
}

.lightgreen{
	background: #E4FFE4;
}

.additem{
	font-style:italic;
	font-weight:bold;
}

.f_check{
	position:relative;
}
.f_check img{
	position:absolute;
	top:-3px;
}
.f_delete{
	padding-left:18px;
}
#ipc{
	margin-top:10px;
}
.center{
	text-align:center;
}



/** register ***/
.register{
	margin:auto; 	
}
.register .value input{
	width:300px;
	border: 1px solid gray;
}
.register .label{
	padding:5px;
	padding-right:20px;
}
.register .submit{
	padding-top:10px;
	text-align:center;
	cursor:pointer;
}
.register .req{
	text-align:center;
	padding:10px;
}

.ui-dialog .ui-widget-header{
	background: white;
	border:0px;
}
#dialoghtml{
	text-align:center;
}
.ui-dialog {
	border: 2px solid gray;
	color: #222222;
}

/** login **/
.login{
	margin:auto; 	
}
.login .value input{
	width:300px;
	border: 1px solid gray;
}
.login .label{
	padding:5px;
	padding-right:20px;
	padding-bottom:10px;
}
.login .submit{
	padding-top:10px;
	text-align:center;
	cursor:pointer;
}
.login .spiels{
	padding:5px;
	padding-top:10px;
	text-align:left;
}
.login .thankyou{
	padding:20px;
	padding-top:0px;
	text-align:center;	
	font-weight:bold;
}