<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
            	<div class="SearchBox">
                	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="txtinput" /> 
                        <input type="button" class="Search_btn" id="searchsubmit"/>
                </div>
                </form>