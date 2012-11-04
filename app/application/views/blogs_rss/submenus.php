<center>
<?php
	$method = $this->router->method;
	?>
	<table cellpadding="0" cellspacing="0">
	<td class='submenus'>
		<ul>
			<li <?php if($method=="all"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."blogs_rss/all";?>"'>
				All
			</li>
			<li <?php if($method=="people"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."blogs_rss/people";?>"'>
				People
			</li>
			<li <?php if($method=="companies"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."blogs_rss/companies";?>"'>
				Companies
			</li>
			<li <?php if($method=="investment_orgs"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."blogs_rss/investment_orgs";?>"'>
				Investment Organizations
			</li>
		</ul>
	</td>
	</tr>
	</table>
</center>