<?php 
include("../lib/dbcon.php"); 
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
				<div id="adsDiv0"></div>
				</div>
			</div>

		</div>

		<div id="strip">
			<div id="session">

				<div id="cssmenu">
					<ul>
					  
					   <li class="has-sub"><a href="http://startuplist.10dd.co/admin/"><span>LOGIN</span></a></li>
					</ul>
				</div>

			</div>
			<div id="strip_right">

			</div>
			<div id="search">
				<form method="post" action="">
					<input autocomplete="off" id="search_box" name="q" type="text" placeholder="Search Startup List"> <input type="submit" id="search_button" class="button" value=""/>
				</form>
			</div>
		</div>
		<div id="breadcrumbs"><a href="http://startuplist.10dd.co/" title="Home" rel="nofollow">Home</a></div>
		
		<div id="container_person">
			<div id="col1">
			<?php 
			$query_profcom_num = "SELECT COUNT(*) AS count FROM profile where profile_org='1'";
			$result_profcom_num = mysql_query($query_profcom_num);
			$row = mysql_fetch_array($result_profcom_num);
			$count = $row['count'];
			$query_profinv_num = "SELECT COUNT(*) AS count FROM profile where profile_org='0'";
			$result_profinv_num = mysql_query($query_profinv_num);
			$rowprofinv = mysql_fetch_array($result_profinv_num);
			$countprofinv = $rowprofinv['count'];
			$query_profpeo_num = "SELECT COUNT(*) AS count FROM profile_person";
			$result_profpeo_num = mysql_query($query_profpeo_num);
			$rowprofpeo = mysql_fetch_array($result_profpeo_num);
			$countprofpeo = $rowprofpeo['count'];
			$query_funding_num = "SELECT COUNT(*) AS count FROM profile_funding";
			$result_funding_num = mysql_query($query_funding_num);
			$rowfunding = mysql_fetch_array($result_funding_num);
			$countfunding = $rowfunding['count'];
			?>
			
		
	<div class="col1_content">
	<h2>filters</h2>
		<table>
			<tr><td class="td_left2"><a href="/companies" title="Companies" rel="nofollow">Companies</a></td><td class="td_right2"><?php echo $count; ?></td></tr>
			<tr><td class="td_left2"><a href="/people" title="People" rel="nofollow">People</a></td><td class="td_right2"><?php echo $countprofpeo; ?></td></tr>
			<tr><td class="td_left2"><a href="/financial-organizations" title="Financial Organizations" rel="nofollow">Financial Organizations</a></td><td class="td_right2"><?php echo $countprofinv; ?></td></tr>
			<tr><td class="td_left2"><a href="/funding-rounds" title="Funding Rounds">Funding Rounds</a></td><td class="td_right2"><?php echo $countfunding; ?></td></tr>
			
		</table>
	</div>
	</div>
           
	
</div>

<div id="col2_profile">
	
<div id="col2">
  <div id="col2_internal">
  <h1 class="h1_first">Search Results</h1>
  <?php
					
					if($_SERVER["REQUEST_METHOD"] == "POST")
					{
						$q=$_POST['q'];
						$q=mysql_escape_string($q);
						$q_fix=str_replace(" ","%",$q); // Space replacing with %
						$sql=mysql_query("SELECT profile_id,profile_name,profile_category,profile_logo,profile_org FROM profile WHERE profile_name LIKE N'%$q_fix%' union SELECT profile_person_id,profile_person_name,profile_person_email,profile_person_image,profile_person_twitter_username FROM profile_person WHERE profile_person_name LIKE N'%$q_fix%'");
					}
					$rowsql = mysql_num_rows($sql);
					if($rowsql != 0){
					while($row=mysql_fetch_array($sql))
					{
						$profile_id				=$row["profile_id"];
						$profile_name			=$row["profile_name"];
						$profile_category		=$row["profile_category"];
						$profile_logo	=$row["profile_logo"];
						$profile_org	=$row["profile_org"];
						

						//echo $profile_org;
						if($profile_org == '1' || $profile_org == '0'){
							echo ' <div class="search_result">
									<a href="#nogo"><img src="../admin/img/uploads/'.$profile_logo.'" border="0" alt="image" height="100" width="100" /></a>
										<div class="search_result_name"><a href="http://startuplist.10dd.co/company/company_profile.php?profile_id='.$profile_id.'" title="'.$profile_name.'">'.$profile_name.'</a></div>
										<div class="search_result_type">
										</div>
									<div class="search_result_preview"><p>'.$profile_category.'</p></div>
								</div>';
						
						} else {
							echo ' <div class="search_result">
									<a href="#nogo"><img src="../admin/img/uploads/'.$profile_logo.'" border="0" alt="image" height="100" width="100" /></a>
										<div class="search_result_name"><a href="http://startuplist.10dd.co/people/people_profile.php?profile_person_id='.$profile_id.'" title="'.$profile_name.'">'.$profile_name.'</a></div>
										<div class="search_result_type">
										</div>
									<div class="search_result_preview"><p>'.$profile_category.'</p></div>
								</div>';
						
						
						}
					
						
					}
					} else {
						 
						echo ' <div class="search_result">
									<a href="#nogo"><img src="../img/loading.gif" border="0" alt="image" height="100" width="100"/></a>
										<div class="search_result_name"><a href="http://startuplist.10dd.co" title="Company Name">No Data</a></div>
										<div class="search_result_type">
										</div>
									<div class="search_result_preview"><p>No Data</p></div>
								</div>';
					}
					?>


  <div id="search_suggest">
  <h5>Don't see what you are looking for?</h5>
  <p>Create a new person or company instead.</p>
  <ul>
    <li><a href="http://startuplist.10dd.co/admin/">Create New Person</a></li>
    <li><a href="http://startuplist.10dd.co/admin/">Create New Company</a></li>
    <li><a href="http://startuplist.10dd.co/admin/">Create New Investment Organization</a></li>
  </ul>
</div>

    <!--<div class="pagination"><span class="disabled">&laquo; Previous</span> <span class="current">1</span> <a href="/search?page=2&amp;query=company">2</a> <a href="/search?page=3&amp;query=company">3</a> <a href="/search?page=4&amp;query=company">4</a> <a href="/search?page=5&amp;query=company">5</a> <a href="/search?page=6&amp;query=company">6</a> <a href="/search?page=7&amp;query=company">7</a> <a href="/search?page=8&amp;query=company">8</a> <a href="/search?page=9&amp;query=company">9</a> ... <a href="/search?page=14285&amp;query=company">14285</a> <a href="/search?page=14286&amp;query=company">14286</a> <a href="/search?page=2&amp;query=company">Next &raquo;</a></div>-->
  </div>
</div>


</div>

<div id="col3">
	<div id="ads">
					<img src="../img/rightpost.png" alt="Right Post" height="250" width="310">
					
	</div>
	<div class="col3_content sponsors">
		<h3>Sponsors</h3>
		
		<br><br>
		<a href="http://startuplist.10dd.co/advertise/" rel="nofollow" title="Become a Sponsor">Become a Sponsor</a>			
	</div>
  
  



</div>
		</div>
		<div style="clear:both;"></div>
<div id="footer">
  <a href="http://startuplist.10dd.co/about" rel="nofollow" title="About">About</a> |
  <a href="http://startuplist.10dd.co/advertise/" rel="nofollow" title="Advertise">Advertise</a> |
  <a href="http://startuplist.10dd.co/api" title="API">API</a> |        
  <a href="http://blog.startuplist.10dd.co/" title="Blog">Blog</a> |        
  <a href="http://startuplist.10dd.co/help/faq" title="FAQ">FAQ</a> |
  <a href="http://startuplist.10dd.co/feedback/new" rel="nofollow" title="Feedback">Feedback</a> |
  <a href="http://twitter.10dd.co/startuplist" rel="nofollow" title="Twitter">Twitter</a> |
  <a href="http://startuplist.10dd.co/widget" title="Widget">Widget</a> |
  
  © 2012 startuplist
  
	<a href="http://startuplist.10dd.co/" id="footer_logo"><img src="../img/e27.gif" alt="startuplist Picture" border="0"></a>
</div>
<div id="subfooter">
	<a href="http://startuplist.10dd.co/help/terms-of-service" rel="nofollow" title="Terms of Service">Terms of Service</a> | <a href="http://startuplist.10dd.co/help/privacy-policy" rel="nofollow" title="Privacy Policy">Privacy Policy</a> | <a href="http://startuplist.10dd.co/help/licensing-policy" rel="nofollow" title="Licensing Policy">Licensing Policy</a>
</div>
		



	
</body></html>