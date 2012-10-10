<?php
include ("../lib/dbcon.php");
if ($_POST) {
	$profile_person_name = (filter_var($_POST['profile_person_name'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_blog_url = (filter_var($_POST['profile_person_blog_url'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_twitter_username = (filter_var($_POST['profile_person_twitter_username'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_linkedin_username = (filter_var($_POST['profile_person_linkedin_username'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_image = (filter_var($_POST['profile_person_image'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_des = (filter_var($_POST['profile_person_des'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_email = (filter_var($_POST['profile_person_email'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_person_active = (filter_var($_POST['profile_person_active'], FILTER_SANITIZE_SPECIAL_CHARS));
	$stringifyCompaniesSub = json_decode($_POST['stringifyCompaniesSub']);
	$stringifyInvestmentSub = json_decode($_POST['stringifyInvestmentSub']);

	$res = mysql_query("SELECT * FROM profile_person WHERE profile_person_name = '" . $profile_person_name . "' AND profile_person_email ='" . $profile_person_email . "'");
	$row = mysql_num_rows($res);

	//check if there was not a match
	if ($row == 0) {

		$arr = count($stringifyCompaniesSub);
		$a = 0;
		$sql_in1 = mysql_query("SELECT profile_name,profile_id FROM profile WHERE profile_name='" . $stringifyCompaniesSub[$a] . "' ");
		$r1 = mysql_fetch_array($sql_in1);
		$profile_id = $r1['profile_id'];

		$sql = "INSERT INTO profile_person	(profile_person_id,profile_person_name,profile_person_blog_url,profile_person_twitter_username,profile_person_linkedin_username,profile_person_image,profile_person_des,profile_person_email,profile_person_active,profile_id) 
	VALUES ('','$profile_person_name','$profile_person_blog_url','$profile_person_twitter_username','$profile_person_linkedin_username','$profile_person_image','$profile_person_des','$profile_person_email','$profile_person_active','$profile_id')";
		mysql_query($sql);
		$sql_in = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person order by profile_person_id desc");
		$r = mysql_fetch_array($sql_in);
		$profile_person_id = $r['profile_person_id'];

		$arr = count($stringifyCompaniesSub);
		$a = 0;

		while ($a < $arr) {
			$resPC = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $stringifyCompaniesSub[$a] . "' AND profile_person_id='" . $r['profile_person_id'] . "'");
			$rowPC = mysql_num_rows($resPC);

			if ($rowPC == 0) {
				//Checking empty!
				if ($stringifyCompaniesSub[$a] != '') {
					mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) 
	values('" . $r['profile_person_id'] . "','" . $stringifyCompaniesSub[$a] . "','" . $stringifyCompaniesSub[$a + 1] . "','" . $stringifyCompaniesSub[$a + 2] . "','" . $stringifyCompaniesSub[$a + 3] . "')");
					$resPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyCompaniesSub[$a] . "'");
					$rowPPC = mysql_num_rows($resPPC);
					if ($rowPPC == 0) {
						$sqlSPi = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies='" . $stringifyCompaniesSub[$a] . "'");
						$rSPi = mysql_fetch_array($sqlSPi);
						$profile_person_companies_id = $rSPi['profile_person_companies_id'];
						mysql_query("INSERT INTO profile (profile_name,profile_person_id,profile_org,profile_person_companies_id) values('" . $stringifyCompaniesSub[$a] . "','" . $profile_person_id . "','1','" . $profile_person_companies_id . "')");
						$sqlSP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyCompaniesSub[$a] . "'");
						$rSP = mysql_fetch_array($sqlSP);
						$profile_id2 = $rSP['profile_id'];
						mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_id2 . "','" . $profile_person_name . "','" . $stringifyCompaniesSub[$a + 1] . "','" . $stringifyCompaniesSub[$a + 2] . "','" . $stringifyCompaniesSub[$a + 3] . "')");
						$timex = time();
						$sqllu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profile_id2 . "','$stringifyCompaniesSub[$a]','$timex')";
						mysql_query($sqllu);
					} else {
						$sqlccP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyCompaniesSub[$a] . "'");
						$rccP = mysql_fetch_array($sqlccP);
						$profile_idcc2 = $rccP['profile_id'];
						$resddb = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $profile_person_name . "' AND profile_id='" . $profile_idcc2 . "'");
						$rowddb = mysql_num_rows($resddb);
						if ($rowddb == 0) {
							if ($profile_person_name != '') {
								mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_idcc2 . "','" . $profile_person_name . "','" . $stringifyCompaniesSub[$a + 1] . "','" . $stringifyCompaniesSub[$a + 2] . "','" . $stringifyCompaniesSub[$a + 3] . "')");

							}
						}
					}
				}
			}
			$a = $a + 4;
		}

		$arb = count($stringifyInvestmentSub);
		$b = 0;

		while ($b < $arb) {
			$resPF = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo = '" . $stringifyInvestmentSub[$b] . "' AND profile_person_id='" . $r['profile_person_id'] . "'");
			$rowPF = mysql_num_rows($resPF);

			if ($rowPF == 0) {
				//Checking empty!
				if ($stringifyInvestmentSub[$b] != '') {
					mysql_query("INSERT INTO profile_person_fo (profile_person_id,profile_person_fo,profile_person_fo_role,profile_person_fo_start,profile_person_fo_end) values('" . $r['profile_person_id'] . "','" . $stringifyInvestmentSub[$b] . "','" . $stringifyInvestmentSub[$b + 1] . "','" . $stringifyInvestmentSub[$b + 2] . "','" . $stringifyInvestmentSub[$b + 3] . "')");
					$resPPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyInvestmentSub[$b] . "'");
					$rowPPPC = mysql_num_rows($resPPPC);
					if ($rowPPPC == 0) {
						$sqlSPFo = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo='" . $stringifyInvestmentSub[$b] . "'");
						$rSPFo = mysql_fetch_array($sqlSPFo);
						$profile_person_companies_idx = $rSPFo['profile_person_fo_id'];
						mysql_query("INSERT INTO profile (profile_name,profile_person_id,profile_org,profile_person_companies_id) values('" . $stringifyInvestmentSub[$b] . "','" . $profile_person_id . "','0','" . $profile_person_companies_idx . "')");
						$sqlSPP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyInvestmentSub[$b] . "'");
						$rSPP = mysql_fetch_array($sqlSPP);
						$profile_id3 = $rSPP['profile_id'];
						mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_id3 . "','" . $profile_person_name . "','" . $stringifyInvestmentSub[$b + 1] . "','" . $stringifyInvestmentSub[$b + 2] . "','" . $stringifyInvestmentSub[$b + 3] . "')");
						$timexx = time();
						$sqlluu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profile_id3 . "','$stringifyInvestmentSub[$b]','$timexx')";
						mysql_query($sqlluu);

					} else {
						$sqlScP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyInvestmentSub[$b] . "'");
						$rScP = mysql_fetch_array($sqlScP);
						$profile_idc3 = $rScP['profile_id'];
						$resddv = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $profile_person_name . "' AND profile_id='" . $profile_idc3 . "'");
						$rowddv = mysql_num_rows($resddv);
						if ($rowddv == 0) {
							if ($profile_person_name != '') {
								mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_idc3 . "','" . $profile_person_name . "','" . $stringifyInvestmentSub[$b + 1] . "','" . $stringifyInvestmentSub[$b + 2] . "','" . $stringifyInvestmentSub[$b + 3] . "')");

							}
						}
					}
				}
			}
			$b = $b + 4;
		}
		$time1 = time();
		$sql1 = "INSERT INTO latest_update_person	(profile_person_id,profile_person_name,profile_person_date) VALUES ('$profile_person_id','$profile_person_name','$time1')";
		mysql_query($sql1);
		echo '1';
	} else {
		echo '0';
	}

} else {
	echo "not success";
}
?>
