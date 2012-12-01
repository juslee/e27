<?php
$t = count($people);
if($format=='xls'||$format=="html"){
	if($format=='xls'){
		header('Content-type: application/ms-excel');
		header("Content-Type: application/force-download");
		header('Content-Disposition: attachment; filename=people.xls');
	}
	?>
	<table border="1">
	<tr>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Name</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Description</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">E-mail Address</font></td>	
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Blog URL</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Blog RSS feed URL</font></td>	
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Twitter Username</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Facebook Page</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">LinkedIn Page</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Tags</font></td>
		<td valign="top" bgcolor="#008000"><font color="#FFFFFF">Active?</font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF">Companies</font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF">Investment Orgs</font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF">Investments</font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF">Date Added</font></td>
	</tr>
	<?php
	for($i=0; $i<$t; $i++){
		$c = $people[$i];
		?>
		<tr>
		
		<td valign="top"><?php echo htmlentitiesX($c['name']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['description']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['email_address']); ?></td>	
		<td valign="top"><?php echo htmlentitiesX($c['blog_url']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['blog']); ?></td>	
		<td valign="top"><?php echo htmlentitiesX($c['twitter_username']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['facebook']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['linkedin']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['tags']); ?></td>
		<td valign="top"><?php echo htmlentitiesX($c['active']); ?></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF"><?php echo htmlentitiesX($c['companies']); ?></font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF"><?php echo htmlentitiesX($c['investment_orgs']); ?></font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF"><?php echo htmlentitiesX($c['milestones']); ?></font></td>
		<td valign="top" bgcolor="red"><font color="#FFFFFF"><?php echo htmlentitiesX(date("M d, Y", strtotime($c['dateadded']))); ?></font></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
else if($format=='csv'){
	//header('Content-type: application/ms-excel');
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename=people.csv');
	$line = "";
	$line .= '"Name",';
	$line .= '"Description",';
	$line .= '"E-mail Address",';
	$line .= '"Blog URL",';
	$line .= '"Blog RSS feed URL",';
	$line .= '"Twitter Username",';
	$line .= '"Facebook Page",';
	$line .= '"LinkedIn Page",';
	$line .= '"Tags",';
	$line .= '"Active?",';
	$line .= '"Companies",';
	$line .= '"Investment Orgs",';
	$line .= '"Investments",';
	$line .= '"Date Added",';
	echo $line."\n";

	for($i=0; $i<$t; $i++){
		$c = $people[$i];
		$line = "";
		$line .= '"'.htmlentitiesX($c['name']).'",';
		$line .= '"'.htmlentitiesX($c['description']).'",';
		$line .= '"'.htmlentitiesX($c['email_address']).'",';	
		$line .= '"'.htmlentitiesX($c['blog_url']).'",';
		$line .= '"'.htmlentitiesX($c['blog']).'",';	
		$line .= '"'.htmlentitiesX($c['twitter_username']).'",';
		$line .= '"'.htmlentitiesX($c['facebook']).'",';
		$line .= '"'.htmlentitiesX($c['linkedin']).'",';
		$line .= '"'.htmlentitiesX($c['tags']).'",';
		$line .= '"'.htmlentitiesX($c['active']).'",';
		$line .= '"'.htmlentitiesX($c['companies']).'",';
		$line .= '"'.htmlentitiesX($c['investment_orgs']).'",';
		$line .= '"'.htmlentitiesX($c['milestones']).'",';
		$line .= '"'.htmlentitiesX(date("M d, Y", strtotime($c['dateadded']))).'",';
		echo $line."\n";
	}
}
?>
