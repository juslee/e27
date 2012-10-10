<p id="searchresults">

	<?php // PHP5 Implementation - uses MySQLi.
	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
	$db = new mysqli('localhost', 'mikesoer', '+10DDwaylan', 'mikesoer_startuplist');

	if (!$db) {
		// Show error if we cannot connect.
		echo 'ERROR: Could not connect to the database.';
	} else {
		// Is there a posted query string?
		if (isset($_POST['queryString'])) {
			$queryString = $db -> real_escape_string($_POST['queryString']);

			// Is the string length greater than 0?
			if (strlen($queryString) > 0) {
				$query = $db -> query("SELECT profile_name,profile_country,profile_id FROM profile WHERE profile_name  LIKE '%" . $queryString . "%' UNION SELECT profile_person_name,profile_person_email,profile_person_id FROM profile_person WHERE profile_person_name  LIKE '%" . $queryString . "%' order by profile_id ASC limit 10");

				//$query = $db->query("SELECT * FROM search s INNER JOIN profile c ON s.cat_id = c.cid WHERE name LIKE '%" . $queryString . "%' ORDER BY cat_id LIMIT 8");
				if ($query) {
					// While there are results loop through them - fetching an Object.

					// Store the category id
					$catid = 0;
					while ($result = $query -> fetch_object()) {
						if ($result -> profile_id != $catid) {// check if the category changed
							$catid = $result -> profile_id;

							$name = $result -> profile_category;
							if (strlen($name) > 35) {
								$name = substr($name, 0, 35) . "...";
							}
							//echo '<span class="searchheading">'.$name.'</span>';

							$description = $result -> profile_id;
							if (strlen($description) > 80) {
								$description = substr($description, 0, 80) . "...";
							}
							
							$profile_person_email = $result -> profile_country;
							
							$querya = $db -> query("SELECT * FROM profile where profile_id='$description'");
							while ($resulta = $querya -> fetch_object()) {
								$profile_org = $resulta -> profile_org;
								
							}
							
							echo '<div class="block" style="" id=' . $description . ' title=' . $profile_org . '><span class="category">' . $result -> profile_name . '&nbsp;' . $result -> profile_country . '</span>';

						}
						//echo '<a href="'.$result->profile_homepage_url.'">User front page.</a>';
						//echo '<a href="'.$result->profile_form_url.'">Form page.</a>';
						//echo '<img class="img" src="../img/uploads/'.$result->profile_logo.'" alt="" />';

						echo '</br><span style="background-color:#ffffff; position:relative; bottom:30px;left:-5px; float:right;width:15px;height:15px; cursor:default;">
						</span></div>';
					}
					//echo '<span class="seperator"><a href="#nogo" title="Sitemap">Nothing interesting here? Try the sitemap.</a></span><br class="break" />';
				} else {
					echo 'ERROR: There was a problem with the query.';
				}
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>
</p>
<script>
	$(document).ready(function () {
		var test;
		$(".block").live("click", function (e) {
			test = $(this).attr('id');
			var test2 = $(this).attr('title');
			//alert('front');
			if (test2 == '1') {
				location.href = "http://startuplist.10dd.co/admin/login/companyFormUpdate.php?test=" + test;
				
			} else if (test2 == '0') {
				location.href = "http://startuplist.10dd.co/admin/login/investmentFormUpdate.php?test=" + test;
			} else if (test2 == '') {
				location.href = "http://startuplist.10dd.co/admin/login/peopleFormUpdate.php?test=" + test;
			} else {}
			return false;
		});
	});
</script>