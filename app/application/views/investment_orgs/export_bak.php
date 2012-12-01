<?php
$t = count($investment_orgs);
header('Content-type: application/ms-excel');
header("Content-Type: application/force-download");
header('Content-Disposition: attachment; filename=investment_orgs.xls');
?>
<table border="1">
<tr bgcolor="#008000">
	<td>Headers</td>
	<td>Name of Company</td>
	<td>Description</td>
	<td>Website</td>
	<td>Blog</td>	
	<td>Twitter</td>
	<td>Facebook</td>
	<td>Email address</td>	
	<td>Year Founded</td>
	<td>Logo</td>
	<td>Country</td>
	<td>People</td>
	<td>Status</td>
	<td>Active?</td>
</tr>
<tr bgcolor="#75923C">
	<td>Data Format:</td>
	<td>[Incorporated company]</td>
	<td>[Text Description]</td>
	<td></td>
	<td>[Blog URL],[Blog Feed URL]</td>
	<td>[Twitter handler],[Twitter handler2]</td>
	<td>[Facebook Page URL], [Facebook Page URL 2]</td>
	<td>[General contact email address]</td>
	<td>[yyyy]</td>
	<td></td>
	<td>[Recognized country name]</td>
	<td>[First Last name],[position],[year joined],[First Last name 2],[position],[year joined]</td>
	<td>["Closed"/"Live"]</td>
	<td>["1"/"0"]</td>
</tr>
<?php
for($i=0; $i<$t; $i++){
	/*
	Array
	(
		[id] => 4
		[name] => Google Ventures
		[description] => 
		[website] => 
		[blog] => 
		[blog_url] => 
		[twitter_username] => 
		[facebook] => 
		[linkedin] => 
		[number_of_employees] => 0
		[email_address] => 
		[founded] => 
		[found_year] => 0
		[found_month] => 0
		[found_day] => 0
		[country] => 
		[logo] => 
		[tags] => 
		[status] => 
		[active] => 1
		[dateadded] => 2012-11-03 15:14:18
		[dateupdated] => 2012-11-03 15:14:18
	)
	*/
	$c = $investment_orgs[$i];
	echo "<tr bgcolor='#C2D69A'>";
	?>
	<td><?php echo htmlentitiesX(date("M d, Y", strtotime($c['dateadded']))); ?></td>
	<td><?php echo htmlentitiesX($c['name']); ?></td>
	<td><?php echo htmlentitiesX($c['description']); ?></td>
	<td><?php echo htmlentitiesX($c['website']); ?></td>
	<td><?php echo htmlentitiesX($c['blog_url']); ?>,<?php echo htmlentitiesX($c['blog']); ?></td>
	<td><?php echo htmlentitiesX($c['twitter_username']); ?></td>
	<td><?php echo htmlentitiesX($c['facebook']); ?></td>
	<td><?php echo htmlentitiesX($c['email_address']); ?></td>
	<td><?php echo htmlentitiesX($c['found_year']); ?></td>
	<?php
	if(trim($c['logo'])&&0){
		$imgdata = file_get_contents(site_url()."media/image.php?p=".$c['logo']."&mx=50");
		$imgdata = base64_encode($imgdata);
		$img = '<img src="data::image/jpg;base64,'.$imgdata.'" />';
	}
	else{
		$img = "";
	}
	?>
	<td><?php echo $img; ?></td>
	<td><?php echo htmlentitiesX($c['country']); ?></td>
	<td><?php echo htmlentitiesX($c['people']); ?></td>
	<td><?php echo htmlentitiesX($c['status']); ?></td>
	<td><?php echo htmlentitiesX($c['active']); ?></td>
	<?php
	echo "</tr>";
}
?>
</table>
