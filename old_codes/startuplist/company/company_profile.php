<?php
include ("../lib/dbcon.php");
//include("../classes/class.acl.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http?://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=ISO-8859-1" />
		<title>startuplist, The Free Tech company Database</title>
		<link href="../styles/all.css" media="screen" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../styles/nivo-slider.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" media="print" href="print.css">
		<link href="../styles/default.css" media="screen" rel="stylesheet" type="text/css">

	</head>
	<body>
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		<script type="text/javascript" src="//www.hellobar.com/hellobar.js"></script>
		<script type="text/javascript">
			new HelloBar(55008,78522);
		</script>

		<!-- <div id="welcome" style="display:none;"><div class="close" onClick="Effect.BlindUp('welcome', { duration: 1.0 });ignoreWelcome();return false;">x</div>Welcome to startuplist! <a href ="/help/faq" onClick="ignoreWelcome();">Learn more</a></div> -->

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
								<a href="http://startuplist.10dd.co/" title="startuplist">ECHELON27</a>
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
			<a href="http://startuplist.10dd.co/" id="logo"><img src="../img/logo_startuplist.png" alt="startuplist Picture" border="0"></a>
			<div class="ads leaderboard">
				

				<div id="ads">
					<a href="http://startuplist.10dd.co/" id=""><img id="headbanner" src="../img/headbanner.png" alt="startuplist Picture" border="0"></a>
				</div>
			</div>

		</div>

		<div id="strip">
			<div id="session">

				<a href="http://startuplist.10dd.co/admin" rel="nofollow" title="Login">LOGIN</a>
				

			</div>
			<div id="strip_right">

			</div>
			<div id="search">
				<form method="post" action="index.php">
					<input autocomplete="off" id="search_box" name="q" type="text" placeholder="Search Startup List"> <input type="submit" id="search_button" class="button" value=""/>
				</form>
			</div>
		</div>
		<div id="breadcrumbs">
				<?php	$profile_id =$_GET['profile_id'];
				$sql = mysql_query("SELECT * FROM profile where profile_id='$profile_id' ");

				while($row=mysql_fetch_array($sql))
				{
				$profile_id				=$row["profile_id"];
				$profile_name			=$row["profile_name"];
				$profile_description	=$row["profile_description"];
				$profile_category		=$row["profile_category"];
				$profile_homepage_url			=$row["profile_homepage_url"];
				$profile_twitter_username		=$row["profile_twitter_username"];
				$profile_number_of_employees	=$row["profile_number_of_employees"];
				$profile_people			=$row["profile_people"];
				$profile_funding		=$row["profile_funding"];
				$profile_founded_month 		= $row["profile_founded_month"];
				$profile_founded_day 		= $row["profile_founded_day"];
				$profile_founded_year 		= $row["profile_founded_year"];
				$profile_blog_url		=$row["profile_blog_url"];
				$profile_logo	=$row["profile_logo"];
				?>
				<?php } ?>
			<a href="http://startuplist.10dd.co/" title="Home" rel="nofollow">Home</a> &gt; <span>Companies</span> &gt; <span><?php echo $profile_name; ?></span>
		</div>

		<div id="container_person">
		
			<div id="col1">
				
				<div id="company_logo">
					<a href="#nogo" rel="nofollow"><img src="http://startuplist.10dd.co/admin/img/uploads/<?php echo $profile_logo; ?>" alt="No Image Available" border="0" width="200px" height="220px"></a><div class="right"></div>
				</div>
				<div class="col1_content">
					<h2> overview <div class="right"></div></h2>

					<p>

						<table>
							<tr>
								<td class="td_left">Web</td><td class="td_right"><a href="http://finance.aol.com/usw/quotes/quotesandnews?sym=NASDAQ:FB" rel="nofollow" title="NASDAQ:FB"><?php echo $profile_homepage_url; ?></a></td>
							</tr>
							<tr>
								<td class="td_left">Blog</td><td class="td_right"><?php echo $profile_blog_url; ?></td>
							</tr>
							<tr>
								<td class="td_left">Twitter</td><td class="td_right"><?php echo $profile_twitter_username; ?></td>
							</tr>
							<tr>
								<td class="td_left">Category</td><td class="td_right"><?php echo $profile_category; ?></td>
							</tr>
							<tr>
								<td class="td_left">Employees</td><td class="td_right"><?php echo $profile_number_of_employees; ?></td>
							</tr>
							<tr>
								<td class="td_left">Founded</td><td class="td_right"><?php if ($profile_founded_month=='') { echo "..."; } else { echo $profile_founded_month; } ?>-<?php if ($profile_founded_day=='') { echo "..."; } else { echo $profile_founded_day; } ?>-<?php if ($profile_founded_year=='') { echo "..."; } else { echo $profile_founded_year; } ?></td>
							</tr>

						</table>

					</p>

				</div>

				<div class="col1_content">
					<h2 id="current_relationships"> People <div class="right"></div></h2>

					<table>
						<?php	$profile_id =$_GET['profile_id'];
						$sql = mysql_query("SELECT * FROM profile_people where profile_id='$profile_id' ");

						while($row=mysql_fetch_array($sql))
						{
						$profile_id				=$row["profile_id"];
						$profile_people 	=$row["profile_people"];
						$profile_people_role 	=$row["profile_people_role"];
						$profile_people_start		=$row["profile_people_start"];
						$profile_people_end			=$row["profile_people_end"];
						$result1 = mysql_query("SELECT * FROM profile_person where profile_person_name='".$profile_people."'");
								while($row1 = mysql_fetch_array($result1)) {
								$profile_person_image	=$row1["profile_person_image"];
						?>

						<tr>
							<td class="td_left"><img alt="Dollar" class="col1_people_name" src="../admin/img/uploads/<?php echo $profile_person_image; ?>" width="36px" height="36px"/></td><td class="td_right"><a href="http://startuplist.10dd.co" title="example"><?php echo $profile_people; ?></a>
				</div>
				<div class="col1_people_title ">
					<?php echo $profile_people_role; ?>
				</div></td></tr>

				<?php } }?>

				</table>

				<span id="toggle_more_relationships_link"> <a href="#" onclick="toggle_more_relationships(); return false;">Show All People</a> </span>
				<div id="more_relationships" style="display:none;">

					<table>

						<tr>
							<td class="td_left"><img alt="Dollar" class="col1_people_name" src="http://ec2-107-22-191-133.compute-1.amazonaws.com/images/dollar.png" /></td><td class="td_right"><a href="http://startuplist.10dd.co" title="example">Brian</a>
				</div>
				<div class="col1_people_title ">
					Founder and CEO, Board Of Directors
				</div></td></tr>

				<tr>
					<td class="td_left"><img alt="Dollar" class="col1_people_name" src="http://ec2-107-22-191-133.compute-1.amazonaws.com/images/dollar.png" /></td><td class="td_right"><a href="http://startuplist.10dd.co" title="example">Brian</a>
					<div class="col1_people_title ">
						Founder and CEO, Board Of Directors
					</div></td>
				</tr>

				<tr>
					<td class="td_left"><img alt="Dollar" class="col1_people_name" src="http://ec2-107-22-191-133.compute-1.amazonaws.com/images/dollar.png" /></td><td class="td_right"><a href="http://startuplist.10dd.co" title="example">Brian</a>
					<div class="col1_people_title ">
						Founder and CEO, Board Of Directors
					</div></td>
				</tr>

				<tr>
					<td class="td_left"><img alt="Dollar" class="col1_people_name" src="http://ec2-107-22-191-133.compute-1.amazonaws.com/images/dollar.png" /></td><td class="td_right"><a href="http://startuplist.10dd.co" title="example">Brian</a>
					<div class="col1_people_title ">
						Founder and CEO, Board Of Directors
					</div></td>
				</tr>

				</table>

				<a href="#" onclick="toggle_more_relationships(); return false;">Show Fewer People</a>
			</div>

		</div>

		<div class="col1_content">
			<h2> Funding <div class="right"></div></h2>
			<?php	$profile_id =$_GET['profile_id'];
			$sql = mysql_query("SELECT * FROM profile_funding where profile_id='$profile_id' ");

			while($row=mysql_fetch_array($sql))
			{
			$profile_id				=$row["profile_id"];
			$profile_funding_round	=$row["profile_funding_round"];
			$profile_funding_amount	=$row["profile_funding_amount"];
			$profile_funding_date	=$row["profile_funding_date"];
			$profile_funding_type	=$row["profile_funding_type"];
			$profile_funding_person	=$row["profile_funding_person"];

			?>

			<table>

				<!-- Overall Funding Rounds Total -->
				<tbody>
					<tr class="col1_fundings_round_total" style="border-bottom: 1px solid grey;">
						<td class="td_left2">TOTAL</td>
						<td class="td_right2"><strong><?php echo $profile_funding_amount; ?></strong></td>
					</tr>

					<!-- Venture Rounds Total -->

					<tr class="col1_funding_round_total" style="background-color: rgb(238, 238, 238);">
						<td class="td_left2">VENTURE FUNDING TOTAL</td>
						<td class="td_right2"><strong><?php echo $profile_funding_amount; ?></strong></td>
					</tr>

					<tr>
						<td class="td_left2"><?php echo $profile_funding_round; ?><sup class="super_src"><a href="#src29" onclick="new Effect.Highlight('src29', {duration: 1.5});" title="profile round" rel="nofollow"></a></sup>
						<br>
						<a href="http://startuplist.10dd.co" title=""><?php echo $profile_funding_person; ?></a>
						<br>
						<a href="http://startuplist.10dd.co/person/reid-hoffman" title=""></a>
						<br>
						</td><td class="td_right2" style="padding-top: 0.25em;"><?php echo $profile_funding_amount; ?> 
				</tbody>
			</table>
			<?php } ?>
		</div>
		</div>

		<div id="col2_profile">
			<div id="col2_internal">

				<h1 class="h1_first"> <?php echo $profile_name; ?> Description <div class="right"></div></h1>
				<p>
					<?php echo $profile_description; ?>&nbsp;
				</p>

				<h1 class="h1_first"> PHOTO GALLERY <div class="right"></div></h1>
				<!--<div id="wrapper">
					<a href="http://dev7studios.com" id="dev7link" title="Go to dev7studios">dev7studios</a>

					<div class="slider-wrapper theme-default">
						<div id="slider" class="nivoSlider">
							<img src="../img/walle.jpg" data-thumb="images/walle.jpg" alt="" />
							<a href="http://dev7studios.com"><img src="../img/up.jpg" data-thumb="images/up.jpg" alt="" title="This is an example of a caption" /></a>
							<img src="../img/walle.jpg" data-thumb="images/walle.jpg" alt="" data-transition="slideInLeft" />
							<img src="../img/nemo.jpg" data-thumb="../img/nemo.jpg" alt="" title="#htmlcaption" />
						</div>
						<div id="htmlcaption" class="nivo-html-caption">
							<strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
						</div>
					</div>

				</div>-->

				<div id="ads">
					<script type="text/javascript">
						<!--adSetType('F');
						htmlAdWH("93318414", "RR", "RR");
						//-->
					</script>
				</div>
				<h3 class="clear">History & Milestones</h3>
				<div class="col3_content">
					<ul id="milestones" style="padding-left:0;">
						<?php	$profile_id =$_GET['profile_id'];
						$sql = mysql_query("SELECT * FROM profile_history_mile where profile_id='$profile_id' ");

						while($row=mysql_fetch_array($sql))
						{
						$profile_id				=$row["profile_id"];
						$profile_hm_name		=$row["profile_hm_name"];
						$profile_hm_founded	=$row["profile_hm_founded"];

						?>

						<li class="milestone_addition" style="list-style:none;">
							<div class="milestone_favicon">
								<img alt="Addition" class="milestone_favicon" src="http://ec2-107-22-191-133.compute-1.amazonaws.com/images/addition.png" />
							</div>
							<div class="milestone_text">

								<strong><a href="/company/jmg-exploration" title="JMG Exploration"><?php echo $profile_hm_name; ?></a></strong> &#8212;

								Company added to startuplist

							</div>
							<div class="meta_milestone">
								<!--Posted date-->
							</div>
						</li>
						<br />
						<?php } ?>

					</ul>
					<script type="text/javascript">
						//<![CDATA[
						Event.observe(window, 'load', init_milestones);
						//]]>
					</script>
				</div>

			</div>
		</div>

		<div id="col3">
			<div class="col3_content">
				<h3>SHARE THIS PAGE</h3>
				<div id="edit_page">

				<?php $profile_id =$_GET['profile_id'];?>
					<div class="share_p" ><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://startuplist.10dd.co/company/company_profile.php?profile_id=<?php echo $profile_id; ?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
					<div class="share_p1"><div class="fb-like" data-href="http://startuplist.10dd.co/company/company_profile.php?profile_id=<?php echo $profile_id; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-counter="right"></div></div>
					<div class="share_p2"><script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="http://startuplist.10dd.co/company/company_profile.php?profile_id=<?php echo $profile_id; ?>" data-counter="right"></script></div>
					
				</div>
			</div>
			<!-- ADS *************** -->
			<div class="col3_content">
				<h3 style="margin:2px;padding:9px;">SPOT AN ERROR? LET US KNOW!</h3>

			</div>

			<div id="ads">
				<img src="../img/rightpost.png" alt="Right Post" height="250" width="310">
			</div>

			<div class="col3_content">
				<h3>RELATED e27 ARTICLES</h3>

				<ul>

					<li>
						
						<div class="recently_link">
							<a href="http://toolbar.inbox/search/results.aspx?tp=pts&amp;src=pts&amp;tbid=80465&amp;q=example" title="Inbox Toolbar"></a> 
						</div>
						<div class="recently_desc"></div>
					</li>
					<div class="tc_see_more">
						<a href="http://startuplist.10dd.co/company/example/posts" title="See All">See All</a>
					</div>

				</ul>
			</div>

			<div class="col3_content">
				<h3> AROUND THE WEB <a href="http://startuplist.10dd.co/" rel="nofollow"></a></h3>

				<ul>
					<li>
					</li>
				</ul>

				<div class="tc_see_more">
					<a href="http://startuplist.10dd.co/company/example/posts" title="See All">See All</a>
				</div>

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
		
		

		

		<!-- CrazyEgg -->
		

		<!-- Omniture -->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.nivo.slider.pack.js"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider();
			});
		</script>
		

		
		
		
		
		

		
	</body>
</html>
