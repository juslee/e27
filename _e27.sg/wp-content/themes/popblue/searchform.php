<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<img class="searchleft" border=none src="http://www.e27.sg/blog/wp-content/uploads/sleft.png">
<input class="searchtext" border=none type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<img class="searchright" border=none src="http://www.e27.sg/blog/wp-content/uploads/sright.png">
<input style="margin-bottom:7px" type="submit" id="searchsubmit" value="Search" />
</form>


