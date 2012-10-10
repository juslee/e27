<?php
include("lib/dbcon.php");
//include("../classes/class.acl.php");

$per_page = 10; 

//getting number of rows and calculating no of pages
$sql = "select * from profile";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$pages = ceil($count/$per_page)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
<html xmlns:fb="http://facebook.10dd.co/2008/fbml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>startuplist, The Free Tech company Database</title>
		<link href="styles/all.css" media="screen" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" media="print" href="print.css">
		<link href="default.css" media="screen" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
		<script type="text/javascript">
		
		$(document).ready(function(){
			
		//Display Loading Image
		function Display_Load()
		{
			$("#loading").fadeIn(900,0);
			$("#loading").html("<img src='img/bigLoader.gif' />");
		}
		//Hide Loading Image
		function Hide_Load()
		{
			$("#loading").fadeOut('slow');
		};
		

	   //Default Starting Page Results
	   
		$("#pagination li:first").css({'color' : '#FF0084'}).css({'border' : 'none'});
		
		Display_Load();
		
		$("#content").load("pagination_data.php?page=1", Hide_Load());



		//Pagination Click
		$("#pagination li").click(function(){
				
			Display_Load();
			
			//CSS Styles
			$("#pagination li")
			.css({'border' : 'solid #dddddd 1px'})
			.css({'color' : '#0063DC'});
			
			$(this)
			.css({'color' : '#FF0084'})
			.css({'border' : 'none'});

			//Loading Data
			var pageNum = this.id;
			
			$("#content").load("pagination_data.php?page=" + pageNum, Hide_Load());
		});
		
		
	});
	</script>

	</head>
	
	<body>
		<!-- <div id="wel10dd.coe" style="display:none;"><div class="close" onClick="Effect.BlindUp('wel10dd.coe', { duration: 1.0 });ignoreWel10dd.coe();return false;">x</div>Wel10dd.coe to startuplist! <a href ="/help/faq" onClick="ignoreWel10dd.coe();">Learn more</a></div> -->
		<script type="text/javascript" src="//www.hellobar.com/hellobar.js"></script>
		<script type="text/javascript">
			new HelloBar(55008,78522);
		</script>

		<div id="top">
			<div id="top_strip">
				
				<div id="top_strip_left">
					<ul>
						<li>
							<div>
								<a href="http://startuplist.10dd.co/" title="Tech">HOME</a>
							</div>
						</li>
						<li id="top_active_tab">
							<div>
								<a href="#" title="startuplist">ECHELON27</a>
							</div>
						</li>
						<li id="tcnetwork_more">
							<div>
								<a id="tcnetwork_more_link" href="#" onclick="tcnetwork_more(); tcStopPropagation(event); return false;">STARTUPLIST</a>
							</div>
							<div id="tcnetwork_more_content">
								<ul>
									<li>
										<a href="http://startuplist.10dd.co/europe" title="startuplist UK">startuplist Europe</a>
									</li>
									<li>
										<a href="http://fr.startuplist.10dd.co/" title="startuplist France">startuplist France</a>
									</li>
									<li>
										<a href="http://jp.startuplist.10dd.co/" title="startuplist Japan">startuplist Japan</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="header">
			<a href="http://startuplist.10dd.co/" id="logo"><img src="img/logo_startuplist.png" alt="startuplist Picture" border="0"></a>
			<div class="ads leaderboard">
				
				 

				<div id="ads">
				<a href="http://startuplist.10dd.co/" id=""><img id="headbanner" src="img/headbanner.png" alt="startuplist Picture" border="0"></a>
				<div id="adsDiv0"></div>
				</div>
			</div>

		</div>

		<div id="strip">
			<div id="session">
			<div id="menu">
				<ul>
					<li><a href="http://startuplist.10dd.co/admin">Login</a>
						<ul>
							<li><a href="http://www.linkedin.com/">Linkedin</a></li>
							<li><a href="http://www.facebook.com/">Facebook</a></li>
						</ul>
					</li>
				</ul>
			</div>	
			</div>
			<div id="strip_right">

			</div>
			<div id="search">
				<form method="post" action="company/index.php">
					<input autocomplete="off" id="search_box" name="q" type="text" placeholder="Search Startup List"> <input type="submit" id="search_button" class="button" value=""/>
				</form>
			</div>
		</div>
		<div id="breadcrumbs">
			<p id="Newly">Newly Added Startups</p>
				<div id="menufilter">
				<ul>
					<li><a href="#">Filter</a>
						<ul>
							<li><a href="#">Newly Added</a></li>
							<li><a href="#">Newly Updated</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
			
		<div id="container_person">

			

			<div id="col2">
				<div id="col2_internal" >
					<div id="lists">
					<div id="loading" ></div>
					<div id="content" ></div>
						
						<table width="800px">
						<tr><Td>
						<ul id="pagination">
							<?php
							//Show page links
							for($i=1; $i<=$pages; $i++)
							{
								echo '<li class="li_page" id="'.$i.'">'.$i.'</li>';
							}
							?>
						</ul>	
						</Td></tr></table>
						
						<div id="lists">
							
							<div class="list-content" id="content-popular" style="display:none;">
								

							</div>
							
						</div>

					</div>
				</div>
			</div>
			<!--<div style="clear:both;"></div>-->
			<div id="col3_profile">
				

				<div id="ads">
					<img src="img/rightpost.png" alt="Right Post" height="250" width="310">
					
				</div>
				<div class="col3_content">
					<h3 class="clear">NEWLY FUNDED</h3>
					<ul id="milestones" style="padding-left:0;" title="Funding Added">
						<?php
						$result = mysql_query("SELECT * FROM profile_funding ORDER BY profile_funding_id DESC LIMIT 5");
						while($row = mysql_fetch_array($result)) {
							$result1 = mysql_query("SELECT * FROM profile where profile_id='".$row['profile_id']."'");
								while($row1 = mysql_fetch_array($result1)) {
								
						echo "
						<li class='milestone_addition' style='list-style:none;'>
							<div class='milestone_favicon'>
								<img alt='Addition' class='milestone_favicon' src='admin/img/uploads/".$row1['profile_logo']."' width='36px' height='36px'>
							</div>
							<div class='milestone_text'>

								<strong><a href='#nogo' title='Sign'>".$row['profile_funding_asign']."&nbsp".$row['profile_funding_amount']."&nbsp".$row['profile_funding_round']."</a></strong>

								".$row['profile_funding_round']."

							</div>
							<div class='meta_milestone'>
								<!--Posted 00/00/00 at 6:39pm-->
							</div>
						</li>";

						?>

						<?php
						}}
						?>

						<br>

						<div class="tc_see_more">
							<a href="http://startuplist.10dd.co/" title="See All">See All</a>
						</div>

					</ul>
					
				</div>

				<div class="col3_content">
					<h3> LATEST e27 NEWS <a href="http://startuplist.10dd.co/" rel="nofollow"><!--<img src="startuplist_new_logo_sm.png" alt="startuplist Logo Small Picture" border="0">--></a></h3>

					<ul>
						
						<div class="tc_see_more">
							<a href="http://startuplist.10dd.co/" title="See All">See All</a>
						</div>
					</ul>

				</div>

				

			</div>

			<div style="clear:both;"></div>
			<div id="footer">
				<a href="http://startuplist.10dd.co/about" rel="nofollow" title="About">About</a> | <a href="http://startuplist.10dd.co/advertise/" rel="nofollow" title="Advertise">Advertise</a> | <a href="http://startuplist.10dd.co/api" title="API">API</a> | <a href="http://blog.startuplist.10dd.co/" title="Blog">Blog</a> | <a href="http://startuplist.10dd.co/help/faq" title="FAQ">FAQ</a> | <a href="http://startuplist.10dd.co/feedback/new" rel="nofollow" title="Feedback">Feedback</a> | <a href="http://twitter.10dd.co/startuplist" rel="nofollow" title="Twitter">Twitter</a> | <a href="http://startuplist.10dd.co/widget" title="Widget">Widget</a> |

				© 2012 startuplist

				<a href="http://startuplist.10dd.co/" id="footer_logo"><img src="../img/e27.gif" alt="startuplist Picture" border="0"></a>
			</div>
			<div id="subfooter">
				<a href="http://startuplist.10dd.co/help/terms-of-service" rel="nofollow" title="Terms of Service">Terms of Service</a> | <a href="http://startuplist.10dd.co/help/privacy-policy" rel="nofollow" title="Privacy Policy">Privacy Policy</a> | <a href="http://startuplist.10dd.co/help/licensing-policy" rel="nofollow" title="Licensing Policy">Licensing Policy</a>
			</div>

			<!-- Google Analytics -->
			

			<!-- Quantcast -->
			

			<!-- CrazyEgg -->
			

			<!-- Omniture -->

			

		
			
			
			
			
	</body>
</html>