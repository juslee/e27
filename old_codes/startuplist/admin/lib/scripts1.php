<link type="text/css" href="../styles/styles_startuplist.css" rel="stylesheet" />
<link rel="stylesheet" href="../styles/screen.css" type="text/css" media="screen" title="default" />
<link type="text/css" href="../styles/form.css" rel="stylesheet" />
<!--  jquery core -->
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/transition.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.min.js"></script> <!-- Optional -->
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script> <!-- Optional -->
<script type="text/javascript" src="../js/jquery.slidingtabs.pack.js"></script>
<script type="text/javascript" src="../js/cufon-yui.js" ></script>
<script type="text/javascript" src="../js/jClock.js"></script>
<script type="text/javascript" src="../js/jquery.countdown.js"></script>
<script type="text/javascript" src="../js/fonts/Myriad_Pro_700.font.js"></script>
<script type="text/javascript" src="../js/fonts/myriadreg_400.font.js"></script>
<script type="text/javascript" src="../js/fonts/helvthin_400.font.js"></script>
<script type="text/javascript" src="../js/fonts/lobster_400.font.js"></script>
<script type="text/javascript" src="../js/fonts/Franchise_700.font.js"></script>
<script type="text/javascript" src="../js/fonts/Museo_400.font.js"></script>
<script type="text/javascript" src="../js/fonts/arvo_400-arvo_700.font.js"></script>
<script type="text/javascript" src="../js/fonts/lane_400.font.js"></script>
<script type="text/javascript" src="../js/jquery.autogrowtextarea.js"></script>
<script type="text/javascript" src="../js/jquery.infieldlabel.min.js"></script>

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
<link rel="stylesheet" href="../styles/datePicker.css" type="text/css" />
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
$(document).ready(function(){
$(document).pngFix( );
});
</script>
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
$(document).ready(function() {
	$(".tab_content").hide();
	$("ul.tabs li:first").addClass("active").show();
	$(".tab_content:first").show();
	$("ul.tabs li").click(function() {
	    $("ul.tabs li").removeClass("active");
	    $(this).addClass("active");
	    $(".tab_content").hide();
	    var activeTab = $(this).find("a").attr("href");
	    $(activeTab).fadeIn();
	    return false;
	});
});


//JQUERY CLOCK SCRIPT

$(function($) {
  var options = {
    timeNotation: '12h',
    am_pm: true,
    fontFamily:'Myriad Pro',
    fontSize: '13px',
    foreground: '#000',
    //background leftbar #eaeef4 <--
    background: '#eaeef4'
  }
  $('#jclock').jclock(options);
});
</script>
<style type="text/css">
@import "jquery.countdown.css";

#defaultCountdown { width: 300px; height: 91px; color: white;font-family: Helvetica; font-size: 36px; padding-top: 15px;font-stretch: semi-expanded;}
</style>
