<?php
include("lib/dbcon.php");

$per_page = 32; 

if($_GET)
{
$page=$_GET['page'];
}



//get table contents
$start = ($page-1)*$per_page;
$sql = "select * from profile order by profile_id DESC limit $start,$per_page";
$rsd = mysql_query($sql);
?>

<div id="row">
							<?php

							while($row=mysql_fetch_array($rsd))
							{
							$profile_id				=$row["profile_id"];
							$profile_name			=$row["profile_name"];
							$profile_description	=$row["profile_description"];
							$profile_category		=$row["profile_category"];
							$profile_homepage_url			=$row["profile_homepage_url"];
							$profile_twitter_username		=$row["profile_twitter_username"];
							$profile_number_of_employees	=$row["profile_number_of_employees"];
							$profile_founded_month 		= $row["profile_founded_month"];
							$profile_founded_day 		= $row["profile_founded_day"];
							$profile_founded_year 		= $row["profile_founded_year"];
							$profile_blog_url		=$row["profile_blog_url"];
							$profile_country		=$row["profile_country"];
							$profile_logo	=$row["profile_logo"];
							
							
							?>
							<div class="image img<?echo $profile_id;?>" id="<?php echo $profile_id; ?>">
								<div class="row_box_btm">
									<a id="href_company" href="http://startuplist.10dd.co/company/company_profile.php?profile_id=<?echo $profile_id;?>"><span class="letter_padding"><?echo $profile_name;?></span></a>
								</div>
								<div class="row_box_middle"><a id="href_company" href="http://startuplist.10dd.co/company/company_profile.php?profile_id=<?echo $profile_id;?>"><img id="row_box_midimg" src="admin/img/uploads/<?php echo $profile_logo; ?>" alt="No Image Available"/>
								</a>
								</div>
								<div class="row_box_middle_bottom">
									<table>
										<tr>
											<td class="td_left">Founded</td><td class="td_right"><?php if ($profile_founded_month=='') { echo "..."; } else { echo $profile_founded_month; } ?>-<?php if ($profile_founded_day=='') { echo "..."; } else { echo $profile_founded_day; } ?>-<?php if ($profile_founded_year=='') { echo "..."; } else { echo $profile_founded_year; } ?></td>
										</tr>
										<tr>
											<td class="td_left">Website</td><td class="td_right"><a href="company/company_profile.php" target="_self" title="blog.facebook.com" ><?php echo $profile_homepage_url; ?></a></td>
										</tr>
										<tr>
											<td class="td_left">Category</td><td class="td_right"><a href="/companies?q=web" title="Web"><?php echo $profile_category; ?></a></td>
										</tr>
										<tr>
											<td class="td_left">Country</td><td class="td_right"><? echo $profile_country; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<?}?>

						</div>
	

