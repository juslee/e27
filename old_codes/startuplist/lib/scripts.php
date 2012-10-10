
<link type="text/css" href="../styles/.css" rel="stylesheet" />
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
