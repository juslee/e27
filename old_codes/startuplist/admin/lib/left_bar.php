<script type="text/javascript" src="../login/script.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js" ></script>
<script type="text/javascript" src="../js/fonts/helvthin_400.font.js"></script>
<style type="text/css">
</style>
<!-- Start: page-top-outer -->

<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
	$(document).ready(function() {
	//nonessential part.
		$("#zone-bar li em").click(function() {
			var hidden = $(this).parents("li").children("ul").is(":hidden");
			$("#zone-bar>ul>li>ul>li").live("click", function() {
				$("#zone-bar>ul>li>ul").hide();

			});

			$("#zone-bar>ul>li>ul").live("mouseenter", function() {

			}).live("mouseleave", function() {
				$("#zone-bar>ul>li>ul").hide();
			});

			$("#zone-bar>ul>li>ul").hide();
			$("#zone-bar>ul>li>a").removeClass();

			if (hidden) {
				$(this).parents("li").children("ul").toggle().parents("li").children("a").addClass("zoneCur");

			}
		});

	}); 
</script>
<script type="text/javascript">
	$(document).ready(function() {
		Cufon.replace('h1', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('h2', {
			fontFamily : 'helvthin'
		});
		Cufon.replace('h3', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('h4', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('h5', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('h6', {
			fontFamily : 'helvthin'
		});
		Cufon.replace('h7', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('arrow', {
			fontFamily : 'myriadreg'
		});
		Cufon.replace('heading', {
			fontFamily : 'Museo'
		});
		Cufon.replace('museo', {
			fontFamily : 'Museo'
		});
		Cufon.replace('details', {
			fontFamily : 'Myriad Pro'
		});
		Cufon.replace('shadow', {
			fontFamily : 'myriadreg'
		});
	}); 
</script>
<div id="header">
	<ul id="mainnav">
		<li class="logo"></li>
		<li class="button">
			<a href="http://startuplist.10dd.co/admin/login/latest_updates.php" class="latest">Latest &nbsp;</a>
		</li>
		<li class="button2">
			<a href="http://Startuplist.10dd.co/admin/login/companyDashboard.php" class="Companies">Companies &nbsp;</a>
		</li>
		<li class="button3">
			<a href="http://startuplist.10dd.co/admin/login/peopleDashboard.php" class="People">People &nbsp;</a>
		</li>
		<li class="button4">
			<a href="http://startuplist.10dd.co/admin/login/investmentDashboard.php" class="Investment">Investment&nbsp;</a>
		</li>
		<!--<li class="button5">
			<a href="#nogo" class="Blogg">Blogg &nbsp;</a>
		</li>-->
		<li class="button6">
			<a href="http://Startuplist.10dd.co/admin/login/login_index.php" class="User">User &nbsp;</a>
		</li>

		<!--  start top-search -->

		<li class="logout">
			<a href="http://Startuplist.10dd.co/admin/login/logout.php" id="logout" class="logout">Logout<!--<img src="../images/shared/nav/nav_logout.gif" width="64" height="14" alt="" />--></a>
		</li>
		<li class="button8">
			<form id="searchform">
				<input type="text" value="" id="inputString" onkeyup="lookup(this.value);" placeholder="Search"/>
				<div id="suggestions"></div>
			</form>
		</li>
		<!--  end top-search -->

		<li class="latest_updates"></li>
	</ul>
</div>

