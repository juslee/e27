					<div id="search-box-large">
						<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
						<div id="search-box-content">
							<h1>Search</h1>
							<input type="text" name="s" value="<?php echo get_search_query() ?>" id="search-box-textfield" />
							<input type="submit" name="s-submit" id="search-box-submit" />
						</div>
						</form>
					</div>