<?php
$t = count($people);
header('Content-type: application/ms-excel');
header("Content-Type: application/force-download");
header('Content-Disposition: attachment; filename=people.xls');
?>
<table border="1">
<tr bgcolor="#008000">
	<td>Name</td>
	<td>Blog</td>	
	<td>Twitter</td>
	<td>Linkedin</td>
	<td>Profile Image</td>
	<td>Description</td>
	<td>Companies</td>
	<td>Investment Organizations</td>
	<td>Email</td>
	<td>Active?</td>
</tr>
<tr bgcolor="#75923C">
	<td>[First Last name]</td>
	<td>[Blog URL],[Blog Feed URL]</td>	
	<td>[Twitter handler],[Twitter handler2]</td>
	<td>[URL]</td>
	<td></td>
	<td>[Text description]</td>
	<td>[Company name],[position],[year joined],[Company name 2],[position],[year joined]</td>
	<td>[Company name],[position],[year joined],[Company name 2],[position],[year joined]</td>
	<td>[Email address]</td>
	<td>["1"/"0"]?</td>
</tr>
<?php
for($i=0; $i<$t; $i++){
	
	$c = $people[$i];
	echo "<tr bgcolor='#C2D69A'>";
	?>
	<td><?php echo htmlentities($c['name']); ?></td>
	<td><?php echo htmlentities($c['blog_url']); ?>,<?php echo htmlentities($c['blog']); ?></td>
	<td><?php echo htmlentities($c['twitter_username']); ?></td>
	<td><?php echo htmlentities($c['linkedin']); ?></td>
	<td></td>
	<td><?php echo htmlentities($c['description']); ?></td>
	<td><?php echo htmlentities($c['companies']); ?></td>
	<td><?php echo htmlentities($c['investment_orgs']); ?></td>
	<td><?php echo htmlentities($c['email_address']); ?></td>
	<td><?php echo htmlentities($c['active']); ?></td>
	<?php
	echo "</tr>";
}
?>
</table>
