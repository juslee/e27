<?php
$controller = $this->router->class;
$method = $this->router->method;
if($method=='revision'){
	$controller = "revisions";
}
if($method=='contribution'){
	$controller = "contributions";
}
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
	<li <?php if($controller=="revisions"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."revisions";?>"'>
		Web User Revisions
	</li>
	<li <?php if($controller=="contributions"){ echo "class='selected'"; } ?> onclick='self.location="<?php echo site_url()."contributions";?>"'>
		Web User Contributions
	</li>
</ul>