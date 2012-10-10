<?php
include ("../lib/dbcon.php");
//include("../classes/class.acl.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http?://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=ISO-8859-1" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>startuplist, The Free Tech company Database</title>
		<link href="../styles/all.css" media="screen" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../styles/nivo-slider.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" media="print" href="../styles/print.css">
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
				<form method="post" action="../company/index.php">
					<input autocomplete="off" id="search_box" name="q" type="text" placeholder="Search Startup List"> <input type="submit" id="search_button" class="button" value=""/>
				</form>
			</div>
		</div>	<?php	$profile_person_id =$_GET['profile_person_id'];
		$sql = mysql_query("SELECT * FROM profile_person where profile_person_id='$profile_person_id' ");

		while($row=mysql_fetch_array($sql))
		{

		$profile_person_id 		=$row['profile_person_id'];
		$profile_person_name	=$row["profile_person_name"];
		$profile_person_blog_url 	=$row['profile_person_blog_url'];
		$profile_person_twitter_username=$row['profile_person_twitter_username'];
		$profile_person_linkedin_username=$row['profile_person_linkedin_username'];
		$profile_person_image		=$row['profile_person_image'];
		$profile_person_des		=$row['profile_person_des'];
		$profile_person_email	=$row['profile_person_email'];
		$profile_person_active	=$row['profile_person_active'];

		?>
		<?php } ?>
		<div id="breadcrumbs">
			<a href="http://www.startuplist.10dd.co/" title="Home" rel="nofollow">Home</a> &gt; <span><a href="http://www.startuplist.10dd.co/" title="People" rel="nofollow">People</a></span> &gt; <span><?php echo $profile_person_name; ?></span>
		</div>

		<div id="container_person">
			<div id="col1">

				<div id="company_logo">
					<a href="#nogo" rel="nofollow"><img src="http://startuplist.10dd.co/admin/img/uploads/<?php echo $profile_person_image; ?>" alt="example Picture" border="0" style="width:200px;height:220px;"></a><div class="right"></div>
				</div>
				<div class="col1_content">
					<h2> overview <div class="right"></div></h2>
					<p>

						<table>
							<tr>
								<td class="td_left">Blog</td><td class="td_right"><?php echo $profile_person_blog_url; ?></td>
							</tr>
							<tr>
								<td class="td_left">Twitter</td><td class="td_right"><?php echo $profile_person_twitter_username; ?></td>
							</tr>
							<tr>
								<td class="td_left">Linkedin</td><td class="td_right"><?php echo $profile_person_linkedin_username; ?></td>
							</tr>
							<tr>
								<td class="td_left">Email</td><td class="td_right"><?php echo $profile_person_email; ?></td>
							</tr>

						</table>

					</p>
				</div>
				<!--<div class="col1_content">
					<h2> Degrees
					<div class="right">
						<a href="http://www.startuplist.10dd.co/person/ashwin-a/edit_degrees" title="edit" rel="nofollow">edit</a>
					</div></h2>

					<table>
						<tr>
							<td class="td_left">Normal</td><td class="td_right"><a href="http://www.startuplist.10dd.co/person/ashwin-a/edit_degrees" rel="nofollow" title="edit"><?php //echo $profile_person_blog_url; ?></a></td>
						</tr>
					</table>
				</div>-->
				<div class="col1_content">
					<h2 id="current_relationships"> Career
					<div class="right">
						<a href="http://www.startuplist.10dd.co/person/ashwin-a/edit_companies" title="edit" rel="nofollow">edit</a>
					</div></h2>
				<?php	$profile_person_id =$_GET['profile_person_id'];
				$sql = mysql_query("SELECT * FROM profile_person_companies where profile_person_id='$profile_person_id' ");

				while($row=mysql_fetch_array($sql))
				{
				$profile_person_id			=$row["profile_person_id"];
				$profile_person_companies_id		=$row["profile_person_companies_id"];
				$profile_person_companies		=$row["profile_person_companies"];
				$profile_person_companies_role 	=$row["profile_person_companies_role"];
				$profile_person_companies_start		=$row["profile_person_companies_start"];
				$profile_person_companies_end 	=$row["profile_person_companies_end"];

				?>
				

					<div class="col1_people_name ">
						<a href="http://www.startuplist.10dd.co/company/negobuy" title="NeGoBuY"><?php echo $profile_person_companies; ?></a>
					</div>
					<div class="col1_people_title ">
						<?php echo $profile_person_companies_role; ?>
					</div>
				<?php } ?>
				</div>

				
				<div class="col1_content">
					<h2> Web Presences
					<div class="right">
						<a href="http://www.startuplist.10dd.co/person/ashwin-a/edit_links" title="edit" rel="nofollow">edit</a>
					</div></h2>
				</div>

				<div class="col1_content">
					<h2> Tags
					<div class="right">
						<a href="http://www.startuplist.10dd.co/person/ashwin-a/edit_tags" title="edit" rel="nofollow">edit</a>
					</div></h2>
				</div>

			</div>

		</div>

		<div id="col2_profile">
			<div id="col2_internal">

				<h1 class="h1_first"> <?php echo $profile_person_name; ?> Description <div class="right"></div></h1>
				<p>
					<?php echo $profile_person_des; ?>&nbsp;
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

			</div>
		</div>

		<div id="col3">
			<div class="col3_content">
				
				<h3>SHARE THIS PAGE</h3>
				<div id="edit_page">

				<?php $profile_id =$_GET['profile_id'];?>
					<div class="share_p" ><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://startuplist.10dd.co/people/people_profile.php?profile_person_id=<?php echo $profile_person_id; ?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
					<div class="share_p1"><div class="fb-like" data-href="http://startuplist.10dd.co/people/people_profile.php?profile_person_id=<?php echo $profile_person_id; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-counter="right"></div></div>
					<div class="share_p2"><script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="http://startuplist.10dd.co/people/people_profile.php?profile_person_id=<?php echo $profile_person_id; ?>" data-counter="right"></script></div>
					
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

		
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.nivo.slider.pack.js"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider();
			});
		</script>
		
		
		
		
	</body>
</html>