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
#logins a:link, #logins a:visited{
	color:white; 
	text-decoration:none;
}
#logins a:hover{
	color:white; 
	text-decoration:underline;
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
	font-size:20px;
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
.sidebarblock .content .edit a:link, .sidebarblock .content .edit a:hover, .sidebarblock .content .edit a:visited{
	text-transform:none;
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

.margin10{
	margin:10px;
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
	text-transform:lowercase;
	
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
	margin: 3px 5px 3px 5px;
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
	/*top:-3px;*/
	top:-15px;
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

/** forgot password **/
#anemail{
	text-align:center;
	font-size:20px;
	padding:20px;
	color: black;
}

/** change pass **/
#youmay{
	text-align:center;
	font-size:20px;
	padding:20px;
	color: black;
}

/** footer **/
.footer{
	padding-top:40px;
	text-align:center;
	color:#B5B5B5;
}

.footer a:link, .footer a:visited, .footer a:hover {
	color:#f0f0f0;
}

/** link farm **/
.linkfarm{
	padding:80px;
	padding-top:30px;
}

.linkfarm a:link, .linkfarm a:visited, .linkfarm a:hover {
	color:#B5B5B5;
}

/** tool tip **/
.tooltip{
	margin-left:5px;
	cursor:pointer;
}

/** next prev **/
#bnext{
	font-weight:bold;
}
#bprev{
	font-weight:bold;
}



/*********************** flags *************************/
.f32 .flag{display:inline-block;height:32px;width:32px;vertical-align:text-top;line-height:32px;background:url(<?php echo site_url(); ?>media/startuplist/world-flags-sprite-master/images/flags32.png) no-repeat;}
.f32 ._African_Union(OAS){background-position:0 -32px;}
.f32 ._Arab_League{background-position:0 -64px;}
.f32 ._ASEAN{background-position:0 -96px;}
.f32 ._CARICOM{background-position:0 -128px;}
.f32 ._CIS{background-position:0 -160px;}
.f32 ._Commonwealth{background-position:0 -192px;}
.f32 ._England{background-position:0 -224px;}
.f32 ._European_Union{background-position:0 -256px;}
.f32 ._Islamic_Conference{background-position:0 -288px;}
.f32 ._Kosovo{background-position:0 -320px;}
.f32 ._NATO{background-position:0 -352px;}
.f32 ._Northern_Cyprus{background-position:0 -384px;}
.f32 ._Northern_Ireland{background-position:0 -416px;}
.f32 ._Olimpic_Movement{background-position:0 -448px;}
.f32 ._OPEC{background-position:0 -480px;}
.f32 ._Red_Cross{background-position:0 -512px;}
.f32 ._Scotland{background-position:0 -544px;}
.f32 ._Somaliland{background-position:0 -576px;}
.f32 ._Tibet{background-position:0 -608px;}
.f32 ._United_Nations{background-position:0 -640px;}
.f32 ._Wales{background-position:0 -672px;}
.f32 .ad{background-position:0 -704px;}
.f32 .ae{background-position:0 -736px;}
.f32 .af{background-position:0 -768px;}
.f32 .ag{background-position:0 -800px;}
.f32 .ai{background-position:0 -832px;}
.f32 .al{background-position:0 -864px;}
.f32 .am{background-position:0 -896px;}
.f32 .an{background-position:0 -928px;}
.f32 .ao{background-position:0 -960px;}
.f32 .aq{background-position:0 -992px;}
.f32 .ar{background-position:0 -1024px;}
.f32 .as{background-position:0 -1056px;}
.f32 .at{background-position:0 -1088px;}
.f32 .au{background-position:0 -1120px;}
.f32 .aw{background-position:0 -1152px;}
.f32 .az{background-position:0 -1184px;}
.f32 .ba{background-position:0 -1216px;}
.f32 .bb{background-position:0 -1248px;}
.f32 .bd{background-position:0 -1280px;}
.f32 .be{background-position:0 -1312px;}
.f32 .bf{background-position:0 -1344px;}
.f32 .bg{background-position:0 -1376px;}
.f32 .bh{background-position:0 -1408px;}
.f32 .bi{background-position:0 -1440px;}
.f32 .bj{background-position:0 -1472px;}
.f32 .bm{background-position:0 -1504px;}
.f32 .bn{background-position:0 -1536px;}
.f32 .bo{background-position:0 -1568px;}
.f32 .br{background-position:0 -1600px;}
.f32 .bs{background-position:0 -1632px;}
.f32 .bt{background-position:0 -1664px;}
.f32 .bw{background-position:0 -1696px;}
.f32 .by{background-position:0 -1728px;}
.f32 .bz{background-position:0 -1760px;}
.f32 .ca{background-position:0 -1792px;}
.f32 .cd{background-position:0 -1824px;}
.f32 .cf{background-position:0 -1856px;}
.f32 .cg{background-position:0 -1888px;}
.f32 .ch{background-position:0 -1920px;}
.f32 .ci{background-position:0 -1952px;}
.f32 .ck{background-position:0 -1984px;}
.f32 .cl{background-position:0 -2016px;}
.f32 .cm{background-position:0 -2048px;}
.f32 .cn{background-position:0 -2080px;}
.f32 .co{background-position:0 -2112px;}
.f32 .cr{background-position:0 -2144px;}
.f32 .cu{background-position:0 -2176px;}
.f32 .cv{background-position:0 -2208px;}
.f32 .cy{background-position:0 -2240px;}
.f32 .cz{background-position:0 -2272px;}
.f32 .de{background-position:0 -2304px;}
.f32 .dj{background-position:0 -2336px;}
.f32 .dk{background-position:0 -2368px;}
.f32 .dm{background-position:0 -2400px;}
.f32 .do{background-position:0 -2432px;}
.f32 .dz{background-position:0 -2464px;}
.f32 .ec{background-position:0 -2496px;}
.f32 .ee{background-position:0 -2528px;}
.f32 .eg{background-position:0 -2560px;}
.f32 .eh{background-position:0 -2592px;}
.f32 .er{background-position:0 -2624px;}
.f32 .es{background-position:0 -2656px;}
.f32 .et{background-position:0 -2688px;}
.f32 .fi{background-position:0 -2720px;}
.f32 .fj{background-position:0 -2752px;}
.f32 .fm{background-position:0 -2784px;}
.f32 .fo{background-position:0 -2816px;}
.f32 .fr{background-position:0 -2848px;}
.f32 .ga{background-position:0 -2880px;}
.f32 .gb{background-position:0 -2912px;}
.f32 .gd{background-position:0 -2944px;}
.f32 .ge{background-position:0 -2976px;}
.f32 .gg{background-position:0 -3008px;}
.f32 .gh{background-position:0 -3040px;}
.f32 .gi{background-position:0 -3072px;}
.f32 .gl{background-position:0 -3104px;}
.f32 .gm{background-position:0 -3136px;}
.f32 .gn{background-position:0 -3168px;}
.f32 .gp{background-position:0 -3200px;}
.f32 .gq{background-position:0 -3232px;}
.f32 .gr{background-position:0 -3264px;}
.f32 .gt{background-position:0 -3296px;}
.f32 .gu{background-position:0 -3328px;}
.f32 .gw{background-position:0 -3360px;}
.f32 .gy{background-position:0 -3392px;}
.f32 .hk{background-position:0 -3424px;}
.f32 .hn{background-position:0 -3456px;}
.f32 .hr{background-position:0 -3488px;}
.f32 .ht{background-position:0 -3520px;}
.f32 .hu{background-position:0 -3552px;}
.f32 .id{background-position:0 -3584px;}
.f32 .mc{background-position:0 -3584px;}
.f32 .ie{background-position:0 -3616px;}
.f32 .il{background-position:0 -3648px;}
.f32 .im{background-position:0 -3680px;}
.f32 .in{background-position:0 -3712px;}
.f32 .iq{background-position:0 -3744px;}
.f32 .ir{background-position:0 -3776px;}
.f32 .is{background-position:0 -3808px;}
.f32 .it{background-position:0 -3840px;}
.f32 .je{background-position:0 -3872px;}
.f32 .jm{background-position:0 -3904px;}
.f32 .jo{background-position:0 -3936px;}
.f32 .jp{background-position:0 -3968px;}
.f32 .ke{background-position:0 -4000px;}
.f32 .kg{background-position:0 -4032px;}
.f32 .kh{background-position:0 -4064px;}
.f32 .ki{background-position:0 -4096px;}
.f32 .km{background-position:0 -4128px;}
.f32 .kn{background-position:0 -4160px;}
.f32 .kp{background-position:0 -4192px;}
.f32 .kr{background-position:0 -4224px;}
.f32 .kw{background-position:0 -4256px;}
.f32 .ky{background-position:0 -4288px;}
.f32 .kz{background-position:0 -4320px;}
.f32 .la{background-position:0 -4352px;}
.f32 .lb{background-position:0 -4384px;}
.f32 .lc{background-position:0 -4416px;}
.f32 .li{background-position:0 -4448px;}
.f32 .lk{background-position:0 -4480px;}
.f32 .lr{background-position:0 -4512px;}
.f32 .ls{background-position:0 -4544px;}
.f32 .lt{background-position:0 -4576px;}
.f32 .lu{background-position:0 -4608px;}
.f32 .lv{background-position:0 -4640px;}
.f32 .ly{background-position:0 -4672px;}
.f32 .ma{background-position:0 -4704px;}
.f32 .md{background-position:0 -4736px;}
.f32 .me{background-position:0 -4768px;}
.f32 .mg{background-position:0 -4800px;}
.f32 .mh{background-position:0 -4832px;}
.f32 .mk{background-position:0 -4864px;}
.f32 .ml{background-position:0 -4896px;}
.f32 .mm{background-position:0 -4928px;}
.f32 .mn{background-position:0 -4960px;}
.f32 .mo{background-position:0 -4992px;}
.f32 .mq{background-position:0 -5024px;}
.f32 .mr{background-position:0 -5056px;}
.f32 .ms{background-position:0 -5088px;}
.f32 .mt{background-position:0 -5120px;}
.f32 .mu{background-position:0 -5152px;}
.f32 .mv{background-position:0 -5184px;}
.f32 .mw{background-position:0 -5216px;}
.f32 .mx{background-position:0 -5248px;}
.f32 .my{background-position:0 -5280px;}
.f32 .mz{background-position:0 -5312px;}
.f32 .na{background-position:0 -5344px;}
.f32 .nc{background-position:0 -5376px;}
.f32 .ne{background-position:0 -5408px;}
.f32 .ng{background-position:0 -5440px;}
.f32 .ni{background-position:0 -5472px;}
.f32 .nl{background-position:0 -5504px;}
.f32 .no{background-position:0 -5536px;}
.f32 .np{background-position:0 -5568px;}
.f32 .nr{background-position:0 -5600px;}
.f32 .nz{background-position:0 -5632px;}
.f32 .om{background-position:0 -5664px;}
.f32 .pa{background-position:0 -5696px;}
.f32 .pe{background-position:0 -5728px;}
.f32 .pf{background-position:0 -5760px;}
.f32 .pg{background-position:0 -5792px;}
.f32 .ph{background-position:0 -5824px;}
.f32 .pk{background-position:0 -5856px;}
.f32 .pl{background-position:0 -5888px;}
.f32 .pr{background-position:0 -5920px;}
.f32 .ps{background-position:0 -5952px;}
.f32 .pt{background-position:0 -5984px;}
.f32 .pw{background-position:0 -6016px;}
.f32 .py{background-position:0 -6048px;}
.f32 .qa{background-position:0 -6080px;}
.f32 .re{background-position:0 -6112px;}
.f32 .ro{background-position:0 -6144px;}
.f32 .rs{background-position:0 -6176px;}
.f32 .ru{background-position:0 -6208px;}
.f32 .rw{background-position:0 -6240px;}
.f32 .sa{background-position:0 -6272px;}
.f32 .sb{background-position:0 -6304px;}
.f32 .sc{background-position:0 -6336px;}
.f32 .sd{background-position:0 -6368px;}
.f32 .se{background-position:0 -6400px;}
.f32 .sg{background-position:0 -6432px;}
.f32 .si{background-position:0 -6464px;}
.f32 .sk{background-position:0 -6496px;}
.f32 .sl{background-position:0 -6528px;}
.f32 .sm{background-position:0 -6560px;}
.f32 .sn{background-position:0 -6592px;}
.f32 .so{background-position:0 -6624px;}
.f32 .sr{background-position:0 -6656px;}
.f32 .st{background-position:0 -6688px;}
.f32 .sv{background-position:0 -6720px;}
.f32 .sy{background-position:0 -6752px;}
.f32 .sz{background-position:0 -6784px;}
.f32 .tc{background-position:0 -6816px;}
.f32 .td{background-position:0 -6848px;}
.f32 .tg{background-position:0 -6880px;}
.f32 .th{background-position:0 -6912px;}
.f32 .tj{background-position:0 -6944px;}
.f32 .tl{background-position:0 -6976px;}
.f32 .tm{background-position:0 -7008px;}
.f32 .tn{background-position:0 -7040px;}
.f32 .to{background-position:0 -7072px;}
.f32 .tr{background-position:0 -7104px;}
.f32 .tt{background-position:0 -7136px;}
.f32 .tv{background-position:0 -7168px;}
.f32 .tw{background-position:0 -7200px;}
.f32 .tz{background-position:0 -7232px;}
.f32 .ua{background-position:0 -7264px;}
.f32 .ug{background-position:0 -7296px;}
.f32 .us{background-position:0 -7328px;}
.f32 .uy{background-position:0 -7360px;}
.f32 .uz{background-position:0 -7392px;}
.f32 .va{background-position:0 -7424px;}
.f32 .vc{background-position:0 -7456px;}
.f32 .ve{background-position:0 -7488px;}
.f32 .vg{background-position:0 -7520px;}
.f32 .vi{background-position:0 -7552px;}
.f32 .vn{background-position:0 -7584px;}
.f32 .vu{background-position:0 -7616px;}
.f32 .ws{background-position:0 -7648px;}
.f32 .ye{background-position:0 -7680px;}
.f32 .za{background-position:0 -7712px;}
.f32 .zm{background-position:0 -7744px;}
.f32 .zw{background-position:0 -7744px;}

.f16 .flag{display:inline-block;height:16px;width:16px;vertical-align:text-top;line-height:16px;background:url(<?php echo site_url(); ?>media/startuplist/world-flags-sprite-master/images/flags16.png) no-repeat;}
.f16 ._African_Union(OAS){background-position:0 -16px;}
.f16 ._Arab_League{background-position:0 -32px;}
.f16 ._ASEAN{background-position:0 -48px;}
.f16 ._CARICOM{background-position:0 -64px;}
.f16 ._CIS{background-position:0 -80px;}
.f16 ._Commonwealth{background-position:0 -96px;}
.f16 ._England{background-position:0 -112px;}
.f16 ._European_Union{background-position:0 -128px;}
.f16 ._Islamic_Conference{background-position:0 -144px;}
.f16 ._Kosovo{background-position:0 -160px;}
.f16 ._NATO{background-position:0 -176px;}
.f16 ._Northern_Cyprus{background-position:0 -192px;}
.f16 ._Northern_Ireland{background-position:0 -208px;}
.f16 ._Olimpic_Movement{background-position:0 -224px;}
.f16 ._OPEC{background-position:0 -240px;}
.f16 ._Red_Cross{background-position:0 -256px;}
.f16 ._Scotland{background-position:0 -272px;}
.f16 ._Somaliland{background-position:0 -288px;}
.f16 ._Tibet{background-position:0 -304px;}
.f16 ._United_Nations{background-position:0 -320px;}
.f16 ._Wales{background-position:0 -336px;}
.f16 .ad{background-position:0 -352px;}
.f16 .ae{background-position:0 -368px;}
.f16 .af{background-position:0 -384px;}
.f16 .ag{background-position:0 -400px;}
.f16 .ai{background-position:0 -416px;}
.f16 .al{background-position:0 -432px;}
.f16 .am{background-position:0 -448px;}
.f16 .an{background-position:0 -464px;}
.f16 .ao{background-position:0 -480px;}
.f16 .aq{background-position:0 -496px;}
.f16 .ar{background-position:0 -512px;}
.f16 .as{background-position:0 -528px;}
.f16 .at{background-position:0 -544px;}
.f16 .au{background-position:0 -560px;}
.f16 .aw{background-position:0 -576px;}
.f16 .az{background-position:0 -592px;}
.f16 .ba{background-position:0 -608px;}
.f16 .bb{background-position:0 -624px;}
.f16 .bd{background-position:0 -640px;}
.f16 .be{background-position:0 -656px;}
.f16 .bf{background-position:0 -672px;}
.f16 .bg{background-position:0 -688px;}
.f16 .bh{background-position:0 -704px;}
.f16 .bi{background-position:0 -720px;}
.f16 .bj{background-position:0 -736px;}
.f16 .bm{background-position:0 -752px;}
.f16 .bn{background-position:0 -768px;}
.f16 .bo{background-position:0 -784px;}
.f16 .br{background-position:0 -800px;}
.f16 .bs{background-position:0 -816px;}
.f16 .bt{background-position:0 -832px;}
.f16 .bw{background-position:0 -848px;}
.f16 .by{background-position:0 -864px;}
.f16 .bz{background-position:0 -880px;}
.f16 .ca{background-position:0 -896px;}
.f16 .cg{background-position:0 -912px;}
.f16 .cf{background-position:0 -928px;}
.f16 .cd{background-position:0 -944px;}
.f16 .ch{background-position:0 -960px;}
.f16 .ci{background-position:0 -976px;}
.f16 .ck{background-position:0 -992px;}
.f16 .cl{background-position:0 -1008px;}
.f16 .cm{background-position:0 -1024px;}
.f16 .cn{background-position:0 -1040px;}
.f16 .co{background-position:0 -1056px;}
.f16 .cr{background-position:0 -1072px;}
.f16 .cu{background-position:0 -1088px;}
.f16 .cv{background-position:0 -1104px;}
.f16 .cy{background-position:0 -1120px;}
.f16 .cz{background-position:0 -1136px;}
.f16 .de{background-position:0 -1152px;}
.f16 .dj{background-position:0 -1168px;}
.f16 .dk{background-position:0 -1184px;}
.f16 .dm{background-position:0 -1200px;}
.f16 .do{background-position:0 -1216px;}
.f16 .dz{background-position:0 -1232px;}
.f16 .ec{background-position:0 -1248px;}
.f16 .ee{background-position:0 -1264px;}
.f16 .eg{background-position:0 -1280px;}
.f16 .eh{background-position:0 -1296px;}
.f16 .er{background-position:0 -1312px;}
.f16 .es{background-position:0 -1328px;}
.f16 .et{background-position:0 -1344px;}
.f16 .fi{background-position:0 -1360px;}
.f16 .fj{background-position:0 -1376px;}
.f16 .fm{background-position:0 -1392px;}
.f16 .fo{background-position:0 -1408px;}
.f16 .fr{background-position:0 -1424px;}
.f16 .ga{background-position:0 -1440px;}
.f16 .gb{background-position:0 -1456px;}
.f16 .gd{background-position:0 -1472px;}
.f16 .ge{background-position:0 -1488px;}
.f16 .gg{background-position:0 -1504px;}
.f16 .gh{background-position:0 -1520px;}
.f16 .gi{background-position:0 -1536px;}
.f16 .gl{background-position:0 -1552px;}
.f16 .gm{background-position:0 -1568px;}
.f16 .gn{background-position:0 -1584px;}
.f16 .gp{background-position:0 -1600px;}
.f16 .gq{background-position:0 -1616px;}
.f16 .gr{background-position:0 -1632px;}
.f16 .gt{background-position:0 -1648px;}
.f16 .gu{background-position:0 -1664px;}
.f16 .gw{background-position:0 -1680px;}
.f16 .gy{background-position:0 -1696px;}
.f16 .hk{background-position:0 -1712px;}
.f16 .hn{background-position:0 -1728px;}
.f16 .hr{background-position:0 -1744px;}
.f16 .ht{background-position:0 -1760px;}
.f16 .hu{background-position:0 -1776px;}
.f16 .id{background-position:0 -1792px;}
.f16 .mc{background-position:0 -1792px;}
.f16 .ie{background-position:0 -1808px;}
.f16 .il{background-position:0 -1824px;}
.f16 .im{background-position:0 -1840px;}
.f16 .in{background-position:0 -1856px;}
.f16 .iq{background-position:0 -1872px;}
.f16 .ir{background-position:0 -1888px;}
.f16 .is{background-position:0 -1904px;}
.f16 .it{background-position:0 -1920px;}
.f16 .je{background-position:0 -1936px;}
.f16 .jm{background-position:0 -1952px;}
.f16 .jo{background-position:0 -1968px;}
.f16 .jp{background-position:0 -1984px;}
.f16 .ke{background-position:0 -2000px;}
.f16 .kg{background-position:0 -2016px;}
.f16 .kh{background-position:0 -2032px;}
.f16 .ki{background-position:0 -2048px;}
.f16 .km{background-position:0 -2064px;}
.f16 .kn{background-position:0 -2080px;}
.f16 .kp{background-position:0 -2096px;}
.f16 .kr{background-position:0 -2112px;}
.f16 .kw{background-position:0 -2128px;}
.f16 .ky{background-position:0 -2144px;}
.f16 .kz{background-position:0 -2160px;}
.f16 .la{background-position:0 -2176px;}
.f16 .lb{background-position:0 -2192px;}
.f16 .lc{background-position:0 -2208px;}
.f16 .li{background-position:0 -2224px;}
.f16 .lk{background-position:0 -2240px;}
.f16 .lr{background-position:0 -2256px;}
.f16 .ls{background-position:0 -2272px;}
.f16 .lt{background-position:0 -2288px;}
.f16 .lu{background-position:0 -2304px;}
.f16 .lv{background-position:0 -2320px;}
.f16 .ly{background-position:0 -2336px;}
.f16 .ma{background-position:0 -2352px;}
.f16 .md{background-position:0 -2368px;}
.f16 .me{background-position:0 -2384px;}
.f16 .mg{background-position:0 -2400px;}
.f16 .mh{background-position:0 -2416px;}
.f16 .mk{background-position:0 -2432px;}
.f16 .ml{background-position:0 -2448px;}
.f16 .mm{background-position:0 -2464px;}
.f16 .mn{background-position:0 -2480px;}
.f16 .mo{background-position:0 -2496px;}
.f16 .mq{background-position:0 -2512px;}
.f16 .mr{background-position:0 -2528px;}
.f16 .ms{background-position:0 -2544px;}
.f16 .mt{background-position:0 -2560px;}
.f16 .mu{background-position:0 -2576px;}
.f16 .mv{background-position:0 -2592px;}
.f16 .mw{background-position:0 -2608px;}
.f16 .mx{background-position:0 -2624px;}
.f16 .my{background-position:0 -2640px;}
.f16 .mz{background-position:0 -2656px;}
.f16 .na{background-position:0 -2672px;}
.f16 .nc{background-position:0 -2688px;}
.f16 .ne{background-position:0 -2704px;}
.f16 .ng{background-position:0 -2720px;}
.f16 .ni{background-position:0 -2736px;}
.f16 .nl{background-position:0 -2752px;}
.f16 .no{background-position:0 -2768px;}
.f16 .np{background-position:0 -2784px;}
.f16 .nr{background-position:0 -2800px;}
.f16 .nz{background-position:0 -2816px;}
.f16 .om{background-position:0 -2832px;}
.f16 .pa{background-position:0 -2848px;}
.f16 .pe{background-position:0 -2864px;}
.f16 .pf{background-position:0 -2880px;}
.f16 .pg{background-position:0 -2896px;}
.f16 .ph{background-position:0 -2912px;}
.f16 .pk{background-position:0 -2928px;}
.f16 .pl{background-position:0 -2944px;}
.f16 .pr{background-position:0 -2960px;}
.f16 .ps{background-position:0 -2976px;}
.f16 .pt{background-position:0 -2992px;}
.f16 .pw{background-position:0 -3008px;}
.f16 .py{background-position:0 -3024px;}
.f16 .qa{background-position:0 -3040px;}
.f16 .re{background-position:0 -3056px;}
.f16 .ro{background-position:0 -3072px;}
.f16 .rs{background-position:0 -3088px;}
.f16 .ru{background-position:0 -3104px;}
.f16 .rw{background-position:0 -3120px;}
.f16 .sa{background-position:0 -3136px;}
.f16 .sb{background-position:0 -3152px;}
.f16 .sc{background-position:0 -3168px;}
.f16 .sd{background-position:0 -3184px;}
.f16 .se{background-position:0 -3200px;}
.f16 .sg{background-position:0 -3216px;}
.f16 .si{background-position:0 -3232px;}
.f16 .sk{background-position:0 -3248px;}
.f16 .sl{background-position:0 -3264px;}
.f16 .sm{background-position:0 -3280px;}
.f16 .sn{background-position:0 -3296px;}
.f16 .so{background-position:0 -3312px;}
.f16 .sr{background-position:0 -3328px;}
.f16 .st{background-position:0 -3344px;}
.f16 .sv{background-position:0 -3360px;}
.f16 .sy{background-position:0 -3376px;}
.f16 .sz{background-position:0 -3392px;}
.f16 .tc{background-position:0 -3408px;}
.f16 .td{background-position:0 -3424px;}
.f16 .tg{background-position:0 -3440px;}
.f16 .th{background-position:0 -3456px;}
.f16 .tj{background-position:0 -3472px;}
.f16 .tl{background-position:0 -3488px;}
.f16 .tm{background-position:0 -3504px;}
.f16 .tn{background-position:0 -3520px;}
.f16 .to{background-position:0 -3536px;}
.f16 .tr{background-position:0 -3552px;}
.f16 .tt{background-position:0 -3568px;}
.f16 .tv{background-position:0 -3584px;}
.f16 .tw{background-position:0 -3600px;}
.f16 .tz{background-position:0 -3616px;}
.f16 .ua{background-position:0 -3632px;}
.f16 .ug{background-position:0 -3648px;}
.f16 .us{background-position:0 -3664px;}
.f16 .uy{background-position:0 -3680px;}
.f16 .uz{background-position:0 -3696px;}
.f16 .va{background-position:0 -3712px;}
.f16 .vc{background-position:0 -3728px;}
.f16 .ve{background-position:0 -3744px;}
.f16 .vg{background-position:0 -3760px;}
.f16 .vi{background-position:0 -3776px;}
.f16 .vn{background-position:0 -3792px;}
.f16 .vu{background-position:0 -3808px;}
.f16 .ws{background-position:0 -3824px;}
.f16 .ye{background-position:0 -3840px;}
.f16 .za{background-position:0 -3856px;}
.f16 .zm{background-position:0 -3872px;}
.f16 .zw{background-position:0 -3872px;}