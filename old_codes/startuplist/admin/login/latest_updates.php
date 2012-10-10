<?php 
include("../lib/dbcon.php"); 
include("../classes/class.acl.php");
$killtime=(time()-(7 * 24 * 60 * 60));
 $sql = "delete from latest_update where profile_create_date < '$killtime'";
   mysql_query($sql);
 $sql1 = "delete from latest_update_person where profile_person_date < '$killtime'";
   mysql_query($sql1);
 $sql2 = "delete from latest_delete where profile_delete_date < '$killtime'";
   mysql_query($sql2);
 $sql3 = "delete from latest_delete_person where profile_person_delete_date < '$killtime'";
   mysql_query($sql3);  
 $sql4 = "delete from latest_edited where profile_create_date < '$killtime'";
   mysql_query($sql4);  
 $sql5 = "delete from latest_edited_person where profile_person_date < '$killtime'";
   mysql_query($sql5);
$myACL = new ACL();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>StartupList - Admin</title>

<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->
<!--  jquery core -->

<script src="../js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
Cufon.replace('h1', { fontFamily: 'myriadreg' });
Cufon.replace('h2', { fontFamily: 'helvthin' });
Cufon.replace('h3', { fontFamily: 'myriadreg' });
Cufon.replace('h4', { fontFamily: 'myriadreg' });
Cufon.replace('h5', { fontFamily: 'myriadreg' });
Cufon.replace('h6', { fontFamily: 'helvthin' });
Cufon.replace('h7', { fontFamily: 'myriadreg' });
Cufon.replace('arrow', { fontFamily: 'myriadreg' });
Cufon.replace('heading', { fontFamily: 'Museo' });
Cufon.replace('museo', { fontFamily: 'Museo' });
Cufon.replace('details', { fontFamily: 'Myriad Pro' });
Cufon.replace('shadow', { fontFamily: 'myriadreg' });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
 $(".close-green").live("click",function(){
		 var del_id = $(this).attr("id");
	$(this).parents("tr.latest").fadeOut(200);
  });
  
  
  
});
</script>
<!--  checkbox styling script -->
<script src="../js/ui.core.js" type="text/javascript"></script>
<script src="../js/ui.checkbox.js" type="text/javascript"></script>
<script src="../js/jquery.bind.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('input').checkBox();
	$('#toggle-all').click(function(){
 	$('#toggle-all').toggleClass('toggle-checked');
	$('#mainform input[type=checkbox]').checkBox('toggle');
	return false;
	});
});
</script>  

<![if !IE 7]>

<!--  styled select box script version 1 -->
<script src="js/jquery.selectbox-0.5.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
});
</script>
 

<![endif]>





<!-- Custom jquery scripts -->
<script src="js/custom_jquery.js" type="text/javascript"></script>
 
<!-- Tooltips -->
<script src="js/jquery.tooltip.js" type="text/javascript"></script>
<script src="js/jquery.dimensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> 




<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="js/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
<script type="text/javascript" >
$(function(){
	$("a.useradmin").addClass("active");
	$("a.home").addClass("active1");
});
</script>
</head>
<body>
	<div id="wrapper">
		<?php include('../lib/left_bar.php');?>
		<div class="clear"></div>

		<div id="main_content">
			<!--<div id="sidebar">
			<a href="" id="updatecompany"></a>
			<!-- 			<a href="" id="addcompany"></a> --
			<span class="small">Last Updated: __ / __ / __</span>
			</div>-->

			<div id="form_container">
							<!--  start message-green -->

							<div id="message-green">
								<table border="0" width="900px" cellpadding="0" cellspacing="0" height="50%">
									<div id="display"></div>

									<?php
									$result = mysql_query("SELECT * FROM latest_update order by profile_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_id=$row['profile_id'];
									$profile_name=$row['profile_name'];
									$profile_create_date= $row['profile_create_date'];
									?>
									<tr class='latest'>
										<td class='green-left'><?php echo $row['profile_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile where profile_id='" . $profile_id . "' ORDER BY profile_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_country'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() - $profile_create_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Company added sucessfully.</td><td class='green-right'><a href='#nogo' id="<?php $row['profile_id']?>" class='close-green'><img src='../images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
									<?php

									$result = mysql_query("SELECT * FROM latest_update_person order by profile_person_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_person_id=$row['profile_person_id'];
									$profile_person_name=$row['profile_person_name'];
									$profile_person_date= $row['profile_person_date'];
									?>
									<tr class='latest'>
										<td class='yellow-left'><?php echo $row['profile_person_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile_person where profile_person_id='" . $profile_person_id . "' ORDER BY profile_person_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_person_email'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() -$profile_person_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Person added sucessfully.</td><td class='yellow-right'><a href='#nogo' id="<? $row['profile_person_id']?>" class='close-green'><img src='../images/table/icon_close_yellow.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
									<?php

									$result = mysql_query("SELECT * FROM latest_delete order by profile_delete_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_delete_id=$row['profile_delete_id'];
									$profile_delete_name=$row['profile_delete_name'];
									$profile_delete_date= $row['profile_delete_date'];
									?>
									<tr class='latest'>
										<td class='green-left'><?php echo $row['profile_delete_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile where profile_id='" . $profile_delete_id . "' ORDER BY profile_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_country'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() -$profile_delete_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Company deleted sucessfully.</td><td class='green-right'><a href='#nogo' id="<? $row['profile_delete_id']?>" class='close-green'><img src='../images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
									<?php

									$result = mysql_query("SELECT * FROM latest_delete_person order by profile_person_delete_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_person_delete_id=$row['profile_person_delete_id'];
									$profile_person_delete_name=$row['profile_person_delete_name'];
									$profile_person_delete_date= $row['profile_person_delete_date'];
									?>
									<tr class='latest'>
										<td class='yellow-left'><?php echo $row['profile_person_delete_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile_person where profile_person_id='" . $profile_person_delete_id . "' ORDER BY profile_person_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_person_email'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() -$profile_person_delete_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Person deleted sucessfully.</td><td class='yellow-right'><a href='#nogo' id="<? $row['profile_person_delete_id']?>" class='close-green'><img src='../images/table/icon_close_yellow.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
									<?php
									$result = mysql_query("SELECT * FROM latest_edited order by profile_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_id=$row['profile_id'];
									$profile_name=$row['profile_name'];
									$profile_create_date= $row['profile_create_date'];
									?>
									<tr class='latest'>
										<td class='blue-left'><?php echo $row['profile_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile where profile_id='" . $profile_id . "' ORDER BY profile_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_country'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() - $profile_create_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Company edited sucessfully.</td><td class='blue-right'><a href='#nogo' id="<?php $row['profile_id']?>" class='close-green'><img src='../images/table/icon_close_blue.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
									<?php

									$result = mysql_query("SELECT * FROM latest_edited_person order by profile_person_id desc");
									while($row = mysql_fetch_array($result)) {
									$profile_person_id=$row['profile_person_id'];
									$profile_person_name=$row['profile_person_name'];
									$profile_person_date= $row['profile_person_date'];
									?>
									<tr class='latest'>
										<td class='red-left'><?php echo $row['profile_person_name']?>&nbsp;<?php $sql_fpid = mysql_query("select * from profile_person where profile_person_id='" . $profile_person_id . "' ORDER BY profile_person_id DESC limit 1");
										while ($row1 = mysql_fetch_array($sql_fpid)) {echo $row1['profile_person_email'];}?><span style='font-size:10px;opacity:0.6;float:right'><?php $time_difference = time() -$profile_person_date ;
											$seconds = $time_difference ;
											$minutes = round($time_difference / 60 );
											$hours = round($time_difference / 3600 );
											$days = round($time_difference / 86400 );
											$weeks = round($time_difference / 604800 );
											$months = round($time_difference / 2419200 );
											$years = round($time_difference / 29030400 );

											if($seconds <= 60){
											echo"$seconds seconds ago";
											}
											else if($minutes <=60){
											if($minutes==1){
											echo"one minute ago";
											}
											else{
											echo"$minutes minutes ago";
											}
											}
											else if($hours <=24){
											if($hours==1){
											echo"one hour ago";
											}
											else{
											echo"$hours hours ago";
											}
											}
											else if($days <=7){
											if($days==1){
											echo"one day ago";
											}
											else{
											echo"$days days ago";
											}
											}
											else if($weeks <=4){
											if($weeks==1){
											echo"one week ago";
											}
											else{
											echo"$weeks weeks ago";
											}
											}
											else if($months <=12){
											if($months==1){
											echo"one month ago";
											}
											else{
											echo"$months months ago";
											}
											}
											else{
											if($years==1){
											echo"one year ago";
											}
											else{
											echo"$years years ago";
											}
											}
											?></span>&nbsp;Person edited sucessfully.</td><td class='red-right'><a href='#nogo' id="<? $row['profile_person_id']?>" class='close-green'><img src='../images/table/icon_close_red.gif'   alt='' /></a></td>
									</tr>

									<?php
									}
									?>
								</table>
							</div>
							<!--  end message-green -->

							<div class="clear"></div>
						

			</div>
		</div>
	</div>
	<!-- close wrapper -->
</body>
</html>
						