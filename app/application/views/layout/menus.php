<?php
$controller = $this->router->class;
?>
<ul>
	<li <?php if($controller=="latest"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."latest";?>"'>
		Latest Updates
	</li>
	<li <?php if($controller=="companies"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."companies";?>"'>
		Companies
	</li>
	<li <?php if($controller=="people"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."people";?>"'>
		People
	</li>
	<li <?php if($controller=="investment_orgs"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."investment_orgs";?>"'>
		Investment Organizations
	</li>
	<li <?php if($controller=="blogs_rss"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."blogs_rss";?>"'>
		Blogs RSS Feeds
	</li>
</ul>