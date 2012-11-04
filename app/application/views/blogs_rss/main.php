<?php
$this->load->view('blogs_rss/submenus');
?>
<center>
<div class='pad10' ><form action="<?php echo site_url(); ?>blogs_rss/all/" class='inline' >Search: <input type='text' id='search' value="<?php echo sanitizeX($search); ?>" name='search' /><input type='button' class='button normal' value='search' onclick='searchCompany()'><input type='button' class='button normal' onclick='self.location="<?php echo site_url(); ?>blogs_rss/all/?search="+jQuery("#search").val()+"&shuffle=1"' value='Shuffle'></form><div class='hint'>Name, Description, Tags</div>
</div>
</center>