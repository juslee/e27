<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
	<?php if(is_home()) { ?>
		<?php bloginfo('name'); ?>
	<?php } else { ?>
		<?php wp_title(' '); ?>
		&raquo;	<?php bloginfo('name'); ?>
	<?php } ?>
</title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<meta name="description" content="Organizers of "Unconference", the premier startup demo/ showcase event in Southeast Asia. Community events and original news content about Asia's web and mobile startup communities" />
<meta name="keywords" content="e27 unconference startup entrepreneurship venture capital VC angel technology consumer internet consumer web web 2.0 social media social networking marketing" />
 <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/e27_icon.ico">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script src="<?php bloginfo('template_directory'); ?>/menu.js" type="text/javascript"></script>

<script language="javascript">

/*
Auto center window script- Eric King (http://redrival.com/eak/index.shtml)
Permission granted to Dynamic Drive to feature script in archive
For full source, usage terms, and 100's more DHTML scripts, visit http://dynamicdrive.com
*/

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}

</script>

<script type="text/javascript">
	var emaildef = 'your email address here';
	var passdef = 'password';
	var searchdef = 'Search';
	
	function fillbox(){
		var emailbox=document.getElementById("username");
		var passbox=document.getElementById("password");
		var searchbox=document.getElementById("s");
		if (emailbox) emailbox.value = emaildef;
		if (searchbox) searchbox.value = searchdef;
		if (passbox) 
		{
			passbox.value = passdef;
			passbox.type = 'text';
		}
	}

	function swapPanel(DivId)
	{
		var getDivID=document.getElementById(DivId);
		var Tab1=document.getElementById("content1");
		var Tab2=document.getElementById("content2");
		var Tab3=document.getElementById("content3");
		Tab1.style.display="none";
		Tab2.style.display="none";
		if(Tab3) Tab3.style.display="none";
		getDivID.style.display="block";
	}

	function clearbox(id){
		var box=document.getElementById(id);
		if(id == 'username') { if(box.value == emaildef){box.value = '';} }
		else if(id == 's') { if(box.value == searchdef){box.value = '';} }
		else if(id == 'password') { 
			if(box.value == passdef){
				box.value = '';
				box.type = 'password';
			}
		}
	}

	function restorehint(id){
		var box=document.getElementById(id);
		if(id == 'username') { if(box.value == ''){box.value = emaildef;} }
		else if(id == 's') { if(box.value == ''){box.value = searchdef;} }
		else if(id == 'password') { 
			if(box.value == ''){
				box.value = passdef;
				box.type = 'text';
			} 
		}
	}
</script>

<script type="text/javascript">

/*Example message arrays for the two demo scrollers*/

<?php $custom_query = new WP_Query('category_name=blog&showposts=10'); ?>
<?php $linkid = 0; ?>
<?php if ($custom_query->have_posts()) : ?>
var tickercontent=new Array()
<?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
tickercontent[<?php echo $linkid ?>]='<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_time('d F Y') ?>: <?php the_title(); ?><?php //the_content_rss('', TRUE, '', 10); ?></a>'
<?php $linkid++; ?>
<?php endwhile; ?>
<?php endif; ?>

</script>


<script type="text/javascript">

/***********************************************
* DHTML Ticker script- c Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

function domticker(content, divId, divClass, delay, fadeornot){
this.content=content
this.tickerid=divId //ID of master ticker div. Message is contained inside first child of ticker div
this.delay=6000 //Delay between msg change, in miliseconds.
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over ticker (and pause it if it is)
this.pointer=1
this.opacitystring=(typeof fadeornot!="undefined")? "width: 100%; filter:progid:DXImageTransform.Microsoft.alpha(opacity=100); -moz-opacity: 1" : ""
if (this.opacitystring!="") this.delay+=500 //add 1/2 sec to account for fade effect, if enabled
this.opacitysetting=0.2 //Opacity value when reset. Internal use.
document.write('<div id="'+divId+'" class="'+divClass+'"><div style="'+this.opacitystring+'">'+content[0]+'</div></div>')
var instanceOfTicker=this
setTimeout(function(){instanceOfTicker.initialize()}, delay)
}

domticker.prototype.initialize=function(){
var instanceOfTicker=this
this.contentdiv=document.getElementById(this.tickerid).firstChild //div of inner content that holds the messages
document.getElementById(this.tickerid).onmouseover=function(){instanceOfTicker.mouseoverBol=1}
document.getElementById(this.tickerid).onmouseout=function(){instanceOfTicker.mouseoverBol=0}
this.rotatemsg()
}

domticker.prototype.rotatemsg=function(){
var instanceOfTicker=this
if (this.mouseoverBol==1) //if mouse is currently over ticker, do nothing (pause it)
setTimeout(function(){instanceOfTicker.rotatemsg()}, 100)
else{
this.fadetransition("reset") //FADE EFFECT- RESET OPACITY
this.contentdiv.innerHTML=this.content[this.pointer]
this.fadetimer1=setInterval(function(){instanceOfTicker.fadetransition('up', 'fadetimer1')}, 100) //FADE EFFECT- PLAY IT
this.pointer=(this.pointer<this.content.length-1)? this.pointer+1 : 0
setTimeout(function(){instanceOfTicker.rotatemsg()}, this.delay) //update container
}
}

// -------------------------------------------------------------------
// fadetransition()- cross browser fade method for IE5.5+ and Mozilla/Firefox
// -------------------------------------------------------------------

domticker.prototype.fadetransition=function(fadetype, timerid){
var contentdiv=this.contentdiv
if (fadetype=="reset")
this.opacitysetting=0.2
if (contentdiv.filters && contentdiv.filters[0]){
if (typeof contentdiv.filters[0].opacity=="number") //IE6+
contentdiv.filters[0].opacity=this.opacitysetting*100
else //IE 5.5
contentdiv.style.filter="alpha(opacity="+this.opacitysetting*100+")"
}
else if (typeof contentdiv.style.MozOpacity!="undefined" && this.opacitystring!=""){
contentdiv.style.MozOpacity=this.opacitysetting
}
else
this.opacitysetting=1
if (fadetype=="up")
this.opacitysetting+=0.2
if (fadetype=="up" && this.opacitysetting>=1)
clearInterval(this[timerid])
}

</script>

<script type="text/javascript">

/***********************************************
* Advanced Gallery script- c Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice must stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var tickspeed=6000 //ticker speed in miliseconds (2000=2 seconds)
var resumespeed=14000 //time for manual mode to change to auto in miliseconds (2000=2 seconds)
var displaymode="auto" //displaymode ("auto" or "manual"). No need to modify as form at the bottom will control it, unless you wish to remove form.

if (document.getElementById){
document.write('<style type="text/css">\n')
document.write('.gallerycontent{display:none;}\n')
document.write('</style>\n')
}

var selectedDiv=0
var totalDivs=0


function hasClass(ele,cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	if (hasClass(ele,cls)) {
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}

function getElementbyClass(classname){
partscollect=new Array()
var inc=0
var alltags=document.all? document.all.tags("DIV") : document.getElementsByTagName("*")
for (i=0; i<alltags.length; i++){
if (alltags[i].className==classname)
partscollect[inc++]=alltags[i]
}
}

function getButtonbyClass(classname){
buttonscollect=new Array()
var inc=0
var alltags=document.all? document.all.tags("a") : document.getElementsByTagName("a")
for (i=0; i<alltags.length; i++){
if (alltags[i].className==classname)
buttonscollect[inc++]=alltags[i]
}
}

function contractall(){
var inc=0
while (partscollect[inc]){
partscollect[inc].style.display="none"
removeClass(buttonscollect[inc], "activated")
inc++
}
}

function expandone(){
var selectedDivObj=partscollect[selectedDiv]
contractall()
selectedDivObj.style.display="block"
addClass(buttonscollect[selectedDiv], "activated")
// if (document.gallerycontrol)
// temp.options[selectedDiv].selected=true
selectedDiv=(selectedDiv<totalDivs-1)? selectedDiv+1 : 0
if (displaymode=="auto"){
autocontrolvar=setTimeout("expandone()",tickspeed)
}
else if(displaymode=="autopause"){
displaymode="auto"
clearTimeout(autocontrolvar)
autocontrolvar=setTimeout("expandone()",resumespeed)
}
}

/*
function populatemenu(){
temp=document.gallerycontrol.menu
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<totalDivs;i++){
var thesubject=partscollect[i].getAttribute("subject")
thesubject=(thesubject=="" || thesubject==null)? "HTML Content "+(i+1) : thesubject
temp.options[i]=new Option(thesubject,"")
}
temp.options[0].selected=true
}
*/

function manualcontrol(menuobj){
if (displaymode=="auto")
displaymode="autopause"

selectedDiv=menuobj
expandone()
}

function preparemode(themode){
displaymode=themode
if (typeof autocontrolvar!="undefined")
clearTimeout(autocontrolvar)
if (themode=="auto")
autocontrolvar=setTimeout("expandone()",tickspeed)
}


function startgallery(){
if (document.getElementById("controldiv")) //if it exists
document.getElementById("controldiv").style.display="block"
getElementbyClass("gallerycontent")
getButtonbyClass("gallerycontrol")
totalDivs=partscollect.length
expandone()
}

if (window.addEventListener)
window.addEventListener("load", startgallery, false)
else if (window.attachEvent)
window.attachEvent("onload", startgallery)
else if (document.getElementById)
window.onload=startgallery

</script>

<style type="text/css" media="screen">
</style>
<?php wp_head(); ?>
<?php /*useful global declares*/
	$post_obj = $wp_query->get_queried_object();
	$post_ID = $post_obj->ID;
	$post_title = $post_obj->post_title;
	$post_name = $post_obj->post_name;
	
function get_page_id($page_title) {
	global $wpdb;
	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='page'", $page_title ));
	return $page;
}

function wt_get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}

?>
</head>

<body onload="fillbox()">
<!--[if IE]>  <div id="IEroot">  <![endif]-->
<!-- START OF WRAPPER -->
<div class="Wrapper">

	<div class="Top_bar"><!-- DON'T DELETE --></div>
    
    <!-- START OF MIBBLE BAR -->
    <div class="Mid_bar">
    
    	<!-- START OF HEADER -->
        <div class="Header">
        
        	<div class="Logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.gif" id="e27_logo" /></a></div>
            
            <div class="Legend Smallbox">
            
            	<div class="Facebook">
                	<img src="<?php bloginfo('template_directory'); ?>/images/facebook_pic.gif" class="right" />
                    <span style="margin-top:10px;" class="right">
                    <?php global $user_ID, $user_identity, $user_level ?>
					<?php if ( $user_ID ) : ?>
                    <b>Welcome, <?php echo $user_identity ?></b><br />
                    <?php endif // $user_level >= 1 ?>
                	<a href="">Account Settings</a> | <a href="">Logout of Facebook</a>
                    </span><br class="clear">
                </div>
                
                <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/ads.jpg" alt="ads"/></a>
            
            </div>
            
            <div class="clear"><!-- DON'T DELETE --></div>
            
            <div class="NavBar">
            
                <!-- START OF MENU -->
                <ul class="Menu" id="treemenu1">
                    <?php if (is_home()) {  ?>
                	<li><a href="<?php bloginfo('url'); ?>" class="activated">Home</a></li>
                    <?php } else {  ?>
					<li class="home_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>
                    <?php } ?>
											<?php
												$companies_id = get_page_id('Companies');
												$corpnews_id = get_page_id('Corporate News');
												$service_id = get_page_id('Service Provider Directory');		
												$contact_id = get_page_id('Contact Us'); 
												$ad_id = get_page_id('Advertise'); ?>
											<?php wp_list_pages('title_li=&sort_column=menu_order&exclude='.$contact_id.','.$ad_id.','.$companies_id.','
																	.$corpnews_id.','.$service_id); ?>
                </ul>
                <!-- END OF MENU -->
                <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
            	<div class="SearchBox">
                	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="txtinput" /> 
                    <input type="button" class="Search_btn" id="searchsubmit"/>
                </div>
                </form>
                <div class="clear"><!-- DON'T DELETE --></div>
            
            </div>
        
        </div>
        <!-- END OF HEADER -->