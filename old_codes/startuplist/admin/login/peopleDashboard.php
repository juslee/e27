<?php
if(isset($_POST['submit']))
{ 
$host = 'localhost'; // MYSQL database host adress
$db = 'mikesoer_startuplist'; // MYSQL database name
$user = 'mikesoer'; // Mysql Datbase user
$pass = '+10DDwaylan'; // Mysql Datbase password
 
// Connect to the database
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db);
 
require 'exportcsv.inc.php';
 
$table="profile_person"; // this is the tablename that you want to export to csv from mysql.
 
exportMysqlToCsv($table);
} 
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> 
<script type='text/javascript' src='../js/picnet.table.filter.min.js'></script>   
<script type="text/javascript" src="../js/EditDeletePage_investment.js"></script> 
<script type="text/javascript" src="../js/EditDeletePage_person.js"></script>


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
<script src="../js/jquery.selectbox-0.5.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
});
</script>
 

<![endif]>

<!--  styled select box script version 2 --> 
<script src="../js/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
	$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
});
</script>

<!--  styled select box script version 3 --> 
<script src="../js/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
});
</script>

<!--  styled file upload script --> 
<script src="../js/jquery.filestyle.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
  $(function() {
      $("input.file_1").filestyle({ 
          image: "images/forms/choose-file.gif",
          imageheight : 21,
          imagewidth : 78,
          width : 310
      });
  });
</script>

<!-- Custom jquery scripts -->
<script src="../js/custom_jquery.js" type="text/javascript"></script>
 
<!-- Tooltips -->
<script src="../js/jquery.tooltip.js" type="text/javascript"></script>
<script src="../js/jquery.dimensions.js" type="text/javascript"></script>
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


<!--  date picker script -->
<link rel="stylesheet" href="styles/datePicker.css" type="text/css" />
<script src="../js/date.js" type="text/javascript"></script>
<script src="../js/jquery.datePicker.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
        $(function()
{

// initialise the "Select date" link
$('#date-pick')
	.datePicker(
		// associate the link with a date picker
		{
			createButton:false,
			startDate:'01/01/2005',
			endDate:'31/12/2020'
		}
	).bind(
		// when the link is clicked display the date picker
		'click',
		function()
		{
			updateSelects($(this).dpGetSelected()[0]);
			$(this).dpDisplay();
			return false;
		}
	).bind(
		// when a date is selected update the SELECTs
		'dateSelected',
		function(e, selectedDate, $td, state)
		{
			updateSelects(selectedDate);
		}
	).bind(
		'dpClosed',
		function(e, selected)
		{
			updateSelects(selected[0]);
		}
	);
	
var updateSelects = function (selectedDate)
{
	var selectedDate = new Date(selectedDate);
	$('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
	$('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
	$('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
}
// listen for when the selects are changed and update the picker
$('#d, #m, #y')
	.bind(
		'change',
		function()
		{
			var d = new Date(
						$('#y').val(),
						$('#m').val()-1,
						$('#d').val()
					);
			$('#date-pick').dpSetSelected(d.asString());
		}
	);

// default the position of the selects to today
var today = new Date();
updateSelects(today.getTime());

// and update the datePicker to reflect it...
$('#d').trigger('change');
});
</script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="../js/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
	$(document).pngFix();
});
</script>
<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->

<script type="text/javascript">
$(function () {
	$(document).ready(function () {
		$(".tab-content").hide();
		$("ul.tabs li:first").addClass("active").show();
		$(".tab-content:first").show();
		$("ul.tabs li").click(function () {
			$("ul.tabs li").removeClass("active");
			$(this).addClass("active");
			$(".tab-content").hide();
			var activeTab = $(this).find("a").attr("href");
			$(activeTab).show();
			return false;
		});
	});
	
});
</script>
<style>

</style>
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
				<a href="http://Startuplist.10dd.co/admin/login/peopleFormSubmit.php" id="addpersonDash"  title="Add People"></a>
					<form method="post" action="peopleDashboard.php" >
						<input type="submit" name="submit"  value="" id="CSVsubmit"/>
						<br/>
					</form>
				<!--  start table-content  -->
				<div id="table-content">
					<h2>User Management</h2>

					<div class="tab-container">
						<div id="loading"></div>
						<div id="container_person"  class="tab-content"></div>
						<div id="container_investment" class="tab-content"></div>

					</div>
				</div>
				<!--  end table-content  -->

				<div class="clear"></div>

			</div>
		</div>
	</div>
	<!-- close wrapper -->
</body>
</html>
						