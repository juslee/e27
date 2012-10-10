<?php
include ("../lib/dbcon.php");

if ($_POST) {

	$profile_name = (filter_var($_POST['profile_name'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_description = (filter_var($_POST['profile_description'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_category = (filter_var($_POST['profile_category'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_homepage_url = (filter_var($_POST['profile_homepage_url'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_blog_url = (filter_var($_POST['profile_blog_url'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_twitter_username = (filter_var($_POST['profile_twitter_username'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_facebook_username = (filter_var($_POST['profile_facebook_username'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_email = (filter_var($_POST['profile_email'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_number_of_employees = (filter_var($_POST['profile_number_of_employees'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_founded_month = (filter_var($_POST['profile_founded_month'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_founded_day = (filter_var($_POST['profile_founded_day'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_founded_year = (filter_var($_POST['profile_founded_year'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_logo = (filter_var($_POST['profile_logo'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_country = (filter_var($_POST['profile_country'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_screenshots = (filter_var($_POST['profile_screenshots'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_status = (filter_var($_POST['profile_status'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_active = (filter_var($_POST['profile_active'], FILTER_SANITIZE_SPECIAL_CHARS));
	$profile_org = (filter_var($_POST['profile_org'], FILTER_SANITIZE_SPECIAL_CHARS));
	$PeopleSub = json_decode($_POST['stringifyPeopleSub']);
	$CompetitorsSub = json_decode($_POST['stringifyCompetitorsSub']);
	$MilesSub = json_decode($_POST['stringifyMilesSub']);
	$FundSub = json_decode($_POST['stringifyFundSub']);
	//echo $profile_founded_year;
	//need to code again.
	$res = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $profile_name . "' AND profile_country ='" . $profile_country . "'");
	$row = mysql_num_rows($res);

	//check if there was not a match
	if ($row == 0) {
		$arr = count($PeopleSub);
		$a = 0;
		$sql_in1 = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person WHERE profile_person_name='" . $PeopleSub[$a] . "'");
		$r1 = mysql_fetch_array($sql_in1);
		$profile_person_id = $r1['profile_person_id'];

		$sql = "INSERT INTO profile	(profile_id,profile_name,profile_description,profile_category,profile_homepage_url,profile_blog_url,profile_twitter_username,profile_facebook_username,profile_email,profile_number_of_employees,profile_founded_month,profile_founded_day,profile_founded_year,profile_logo,profile_country,profile_screenshots,profile_status,profile_active,profile_person_id,profile_org) 
	VALUES ('','$profile_name','$profile_description','$profile_category','$profile_homepage_url','$profile_blog_url','$profile_twitter_username','$profile_facebook_username','$profile_email','$profile_number_of_employees','$profile_founded_month','$profile_founded_day','$profile_founded_year','$profile_logo','$profile_country','$profile_screenshots','$profile_status','$profile_active','$profile_person_id','$profile_org')";
		mysql_query($sql);
		$mysql_insert_id = mysql_insert_id();
		echo $mysql_insert_id;
		$sql_in = mysql_query("SELECT profile_name,profile_id FROM profile order by profile_id desc");
		$r = mysql_fetch_array($sql_in);

		$arra = count($PeopleSub);
		//echo $arra;
		//$arra=4;
		$a = 0;

		while ($a < $arra) {
			$resPP = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $PeopleSub[$a] . "' and profile_id='" . $r['profile_id'] . "' ");
			$rowPP = mysql_num_rows($resPP);

			if ($rowPP == 0) {
				//Checking empty!
				if ($PeopleSub[$a] != '') {
					mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $r['profile_id'] . "','" . $PeopleSub[$a] . "','" . $PeopleSub[$a + 1] . "','" . $PeopleSub[$a + 2] . "','" . $PeopleSub[$a + 3] . "')");
					$resPPP = mysql_query("SELECT * FROM profile_person WHERE profile_person_name = '" . $PeopleSub[$a] . "'");
					$rowPPP = mysql_num_rows($resPPP);
					if ($rowPPP == 0) {
						$sqlSPFc = mysql_query("SELECT * FROM profile_people WHERE profile_people='" . $PeopleSub[$a] . "'");
						$rSPFc = mysql_fetch_array($sqlSPFc);
						$profile_people_id = $rSPFc['profile_people_id'];
						mysql_query("INSERT INTO profile_person (profile_person_name,profile_id,profile_people_id) values('" . $PeopleSub[$a] . "','" . $r['profile_id'] . "','" . $profile_people_id . "')");
						$sqlSP = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person WHERE profile_person_name='" . $PeopleSub[$a] . "'");
						$rSP = mysql_fetch_array($sqlSP);
						$profile_person_id = $rSP['profile_person_id'];
						mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) values('" . $profile_person_id . "','" . $profile_name . "','" . $PeopleSub[$a + 1] . "','" . $PeopleSub[$a + 2] . "','" . $PeopleSub[$a + 3] . "')");
						$timex = time();
						$sqllu = "INSERT INTO latest_update_person	(profile_person_id,profile_person_name,profile_person_date) VALUES ('$profile_person_id','$PeopleSub[$a]','$timex')";
						mysql_query($sqllu);
						//echo $PeopleSub[$a];
					} else {
						$sqlNA = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person WHERE profile_person_name='" . $PeopleSub[$a] . "'");
						$rNA = mysql_fetch_array($sqlNA);
						$profile_person_idNA = $rNA['profile_person_id'];
						$resddu = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $profile_name . "' AND profile_person_id='" . $profile_person_idNA . "'");
						$rowddu = mysql_num_rows($resddu);
						if ($rowddu == 0) {
							if ($profile_name != '') {
								mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) values('" . $profile_person_idNA . "','" . $profile_name . "','" . $PeopleSub[$a + 1] . "','" . $PeopleSub[$a + 2] . "','" . $PeopleSub[$a + 3] . "')");
							}
						}
					}
				}
			}
			$a = $a + 4;
		}

		$arrb = count($CompetitorsSub);
		$b = 0;

		while ($b < $arrb) {
			$resPC = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $CompetitorsSub[$b] . "' and profile_id = '" . $r['profile_id'] . "'");
			$rowPC = mysql_num_rows($resPC);

			if ($rowPC == 0) {
				if ($CompetitorsSub[$b] != '') {
					mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $r['profile_id'] . "','" . $CompetitorsSub[$b] . "')");
					$resPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $CompetitorsSub[$b] . "'");
					$rowPPC = mysql_num_rows($resPPC);
					if ($rowPPC == 0) {
						mysql_query("INSERT INTO profile (profile_name,profile_org) values('" . $CompetitorsSub[$b] . "','1')");
						$sqlx = mysql_query("SELECT * FROM profile WHERE profile_name='" . $CompetitorsSub[$b] . "'");
						$rx = mysql_fetch_array($sqlx);
						$profileSign_id = $rx['profile_id'];
						mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $profileSign_id . "','" . $profile_name . "')");
						$timexx = time();
						$sqlluu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profileSign_id . "','$CompetitorsSub[$b]','$timexx')";
						mysql_query($sqlluu);
					} else {
						$sqlex = mysql_query("SELECT * FROM profile WHERE profile_name='" . $CompetitorsSub[$b] . "'");
						$rex = mysql_fetch_array($sqlex);
						$profileSign_ide = $rex['profile_id'];
						$resdu = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $profile_name . "' AND profile_id='" . $profileSign_ide . "'");
						$rowdu = mysql_num_rows($resdu);
						if ($rowdu == 0) {
							if ($profile_name != '') {
								mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $profileSign_ide . "','" . $profile_name . "')");
							}
						}
					}
				}
			}
			$b = $b + 1;
		}
		$arrc = count($MilesSub);
		$c = 0;

		while ($c < $arrc) {
			$resPH = mysql_query("SELECT * FROM profile_history_mile WHERE profile_hm_name = '" . $MilesSub[$c] . "' and profile_id='" . $r['profile_id'] . "'");
			$rowPH = mysql_num_rows($resPH);

			if ($rowPH == 0) {
				//Checking empty!
				if ($MilesSub[$c] != '') {
					mysql_query("INSERT INTO profile_history_mile(profile_id,profile_hm_name,profile_hm_founded)  
		values('" . $r['profile_id'] . "','" . $MilesSub[$c] . "','" . $MilesSub[$c + 1] . "')");
				}
			}
			$c = $c + 2;
		}
		$arrd = count($FundSub);
		$d = 0;

		while ($d < $arrd) {
			$resPF = mysql_query("SELECT * FROM profile_funding WHERE profile_funding_round = '" . $FundSub[$d] . "' and profile_id='" . $r['profile_id'] . "'");
			$rowPF = mysql_num_rows($resPF);

			if ($rowPF == 0) {
				//Checking empty!
				if ($FundSub[$d] != '') {
					mysql_query("INSERT INTO profile_funding (profile_id,profile_funding_round,profile_funding_asign, 	profile_funding_amount,profile_funding_date,profile_funding_type,profile_funding_person)  
		values('" . $r['profile_id'] . "','" . $FundSub[$d] . "','" . $FundSub[$d + 1] . "','" . $FundSub[$d + 2] . "','" . $FundSub[$d + 3] . "','" . $FundSub[$d + 4] . "','" . $FundSub[$d + 5] . "')");
				}
			}
			$d = $d + 6;
		}
		$time = time();
		$sql1 = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $r['profile_id'] . "','$profile_name','$time')";
		mysql_query($sql1);
	} else {
		echo '0';
	}
} else {
	echo "not success";
}
?>

