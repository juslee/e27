<?php
include ("../lib/dbcon.php");
$companyId = $_POST['companyId'];
$profile_name = $_POST['profile_name'];
$profile_description = $_POST['profile_description'];
$profile_category = $_POST['profile_category'];
$profile_homepage_url = $_POST['profile_homepage_url'];
$profile_blog_url = $_POST['profile_blog_url'];
$profile_twitter_username = $_POST['profile_twitter_username'];
$profile_facebook_username = $_POST['profile_facebook_username'];
$profile_email = $_POST['profile_email'];
$profile_number_of_employees = $_POST['profile_number_of_employees'];
$profile_founded_month = $_POST['profile_founded_month'];
$profile_founded_day = $_POST['profile_founded_day'];
$profile_founded_year = $_POST['profile_founded_year'];
$profile_logo = $_POST['profile_logo'];
$profile_screenshots = $_POST['profile_screenshots'];
$profile_country = $_POST['profile_country'];
$profile_status = $_POST['profile_status'];
$profile_active = $_POST['profile_active'];
$profileOld_name = $_POST['profileOld_name'];
$stringifyCompetitors = json_decode($_POST['stringifyCompetitors']);
$stringifyPeople = json_decode($_POST['stringifyPeople']);
$stringifyMiles = json_decode($_POST['stringifyMiles']);
$stringifyFund = json_decode($_POST['stringifyFund']);

$res1 = mysql_query("SELECT profile_name,profile_id FROM profile where profile_name='" . $profile_name . "' AND profile_country='" . $profile_country . "' AND profile_id!='" . $companyId . "' ");
$row1 = mysql_num_rows($res1);
//check if there was not a match
if ($row1 == 0) {
	mysql_query("UPDATE profile SET profile_name='" . $profile_name . "',profile_description='" . $profile_description . "',profile_category='" . $profile_category . "',profile_homepage_url='" . $profile_homepage_url . "',profile_blog_url='" . $profile_blog_url . "',profile_twitter_username='" . $profile_twitter_username . "',profile_facebook_username='" . $profile_facebook_username . "',profile_email='" . $profile_email . "',profile_number_of_employees='" . $profile_number_of_employees . "',profile_founded_month='" . $profile_founded_month . "',profile_founded_day='" . $profile_founded_day . "',profile_founded_year='" . $profile_founded_year . "',profile_logo='" . $profile_logo . "',profile_screenshots='" . $profile_screenshots . "',profile_country='" . $profile_country . "',profile_status='" . $profile_status . "',profile_active='" . $profile_active . "' WHERE profile_id='" . $companyId . "' ");

	$resPCd = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $profileOld_name . "' ");
	$rowPCd = mysql_num_rows($resPCd);

	if ($rowPCd != 0) {
		if ($profileOld_name != '') {
			mysql_query("UPDATE profile_person_companies SET profile_person_companies='" . $profile_name . "' where profile_person_companies='$profileOld_name'");
			//echo $stringifyCompetitors[$c];
		}

	}
	$reser = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $profileOld_name . "' ");
	$rower = mysql_num_rows($reser);

	if ($rower != 0) {
		if ($profileOld_name != '') {
			mysql_query("UPDATE profile_competitors SET profile_competitors_name='" . $profile_name . "' where profile_competitors_name='$profileOld_name'");
			//echo $stringifyCompetitors[$c];
		}

	}

	$lengthCompet = count($stringifyCompetitors);
	$c = 0;
	while ($c < $lengthCompet) {
		if ($stringifyCompetitors[$c] == '0') {
			$resPC = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $stringifyCompetitors[$c + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPC = mysql_num_rows($resPC);

			if ($rowPC == 0) {
				if ($stringifyCompetitors[$c + 1] != '') {
					mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $companyId . "','" . $stringifyCompetitors[$c + 1] . "')");

					//echo $stringifyCompetitors[$c+1];
					$resPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyCompetitors[$c + 1] . "'");
					$rowPPC = mysql_num_rows($resPPC);
					if ($rowPPC == 0) {
						mysql_query("INSERT INTO profile (profile_name,profile_org) values('" . $stringifyCompetitors[$c + 1] . "','1')");
						$sqlx = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyCompetitors[$c + 1] . "'");
						$rx = mysql_fetch_array($sqlx);
						$profileSign_id = $rx['profile_id'];
						mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $profileSign_id . "','" . $profile_name . "')");
						$sqlxz = mysql_query("SELECT * FROM profile_competitors WHERE profile_id='" . $companyId . "' and profile_competitors_name!='" . $stringifyCompetitors[$c + 1] . "'");

						while ($rxz = mysql_fetch_array($sqlxz)) {
							$profile_competitors_namex = $rxz['profile_competitors_name'];
							mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $profileSign_id . "','" . $profile_competitors_namex . "')");
						}
						$timex = time();
						$sqllu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profileSign_id . "','" . $stringifyCompetitors[$c + 1] . "','$timex')";
						mysql_query($sqllu);
					} else {
						$sqlns = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyCompetitors[$c + 1] . "'");
						$rns = mysql_fetch_array($sqlns);
						$profilens_id = $rns['profile_id'];
						$resdu = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $profile_name . "' AND profile_id='" . $profilens_id . "'");
						$rowdu = mysql_num_rows($resdu);
						if ($rowdu == 0) {
							if ($profile_name != '') {
								mysql_query("INSERT INTO profile_competitors (profile_id,profile_competitors_name) values('" . $profilens_id . "','" . $profile_name . "')");
							}
						}
					}
				}
			}
		} else {
			$resPC = mysql_query("SELECT * FROM profile_competitors WHERE profile_competitors_name = '" . $stringifyCompetitors[$c + 1] . "' AND profile_id='" . $companyId . "' ");
			$rowPC = mysql_num_rows($resPC);

			if ($rowPC == 0) {
				if ($stringifyCompetitors[$c + 1] != '') {
					mysql_query("UPDATE profile_competitors SET profile_competitors_name='" . $stringifyCompetitors[$c + 1] . "' where profile_competitors_id='$stringifyCompetitors[$c]'");
					//echo $stringifyCompetitors[$c];
				}
			}
		}
		//mysql_query("UPDATE profile SET  ");

		$c = $c + 2;
	}

	$lengthPeople = count($stringifyPeople);
	$c2 = 0;
	while ($c2 < $lengthPeople) {
		if ($stringifyPeople[$c2] == '0') {
			$resPP = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $stringifyPeople[$c2 + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPP = mysql_num_rows($resPP);

			if ($rowPP == 0) {
				//Checking empty!
				if ($stringifyPeople[$c2 + 1] != '') {
					mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $companyId . "','" . $stringifyPeople[$c2 + 1] . "','" . $stringifyPeople[$c2 + 2] . "','" . $stringifyPeople[$c2 + 3] . "','" . $stringifyPeople[$c2 + 4] . "')");
					$resPPP = mysql_query("SELECT * FROM profile_person WHERE profile_person_name = '" . $stringifyPeople[$c2 + 1] . "'");
					$rowPPP = mysql_num_rows($resPPP);
					if ($rowPPP == 0) {
						$sqlSPp = mysql_query("SELECT * FROM profile_people WHERE profile_people='" . $stringifyPeople[$c2 + 1] . "'");
						$rSPp = mysql_fetch_array($sqlSPp);
						$profile_people_id = $rSPp['profile_people_id'];
						mysql_query("INSERT INTO profile_person (profile_person_name,profile_id,profile_people_id) values('" . $stringifyPeople[$c2 + 1] . "','" . $companyId . "','" . $profile_people_id . "')");
						//echo $PeopleSub[$a];
						$sqlSP = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person WHERE profile_person_name='" . $stringifyPeople[$c2 + 1] . "'");
						$rSP = mysql_fetch_array($sqlSP);
						$profile_person_id = $rSP['profile_person_id'];
						mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) values('" . $profile_person_id . "','" . $profile_name . "','" . $stringifyPeople[$c2 + 2] . "','" . $stringifyPeople[$c2 + 3] . "','" . $stringifyPeople[$c2 + 4] . "')");
						$timexx = time();
						$sqlluu = "INSERT INTO latest_update_person	(profile_person_id,profile_person_name,profile_person_date) VALUES ('$profile_person_id','" . $stringifyPeople[$c2 + 1] . "','$timexx')";
						mysql_query($sqlluu);
					} else {
						$sqlunP = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person WHERE profile_person_name='" . $stringifyPeople[$c2 + 1] . "'");
						$run = mysql_fetch_array($sqlunP);
						$profile_person_idun = $run['profile_person_id'];
						$resddu = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $profile_name . "' AND profile_person_id='" . $profile_person_idun . "'");
						$rowddu = mysql_num_rows($resddu);
						if ($rowddu == 0) {
							if ($profile_name != '') {
								mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) values('" . $profile_person_idun . "','" . $profile_name . "','" . $stringifyPeople[$c2 + 2] . "','" . $stringifyPeople[$c2 + 3] . "','" . $stringifyPeople[$c2 + 4] . "')");
							}
						}
					}
				}
			}
		} else {
			$resPP = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $stringifyPeople[$c2 + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPP = mysql_num_rows($resPP);

			if ($rowPP == 0) {
				//Checking empty!
				if ($stringifyPeople[$c2 + 1] != '') {
					mysql_query("UPDATE profile_people SET profile_people='" . $stringifyPeople[$c2 + 1] . "',profile_people_role='" . $stringifyPeople[$c2 + 2] . "',profile_people_start='" . $stringifyPeople[$c2 + 3] . "',profile_people_end='" . $stringifyPeople[$c2 + 4] . "' where profile_people_id='$stringifyPeople[$c2]'");
					//echo $stringifyPeople[$c2+1];

				}
			}
		}
		//mysql_query("UPDATE profile SET  ");

		$c2 = $c2 + 5;
	}

	$lengthMiles = count($stringifyMiles);
	$c3 = 0;
	while ($c3 < $lengthMiles) {
		if ($stringifyMiles[$c3] == '0') {
			$resPH = mysql_query("SELECT * FROM profile_history_mile WHERE profile_hm_name = '" . $stringifyMiles[$c3 + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPH = mysql_num_rows($resPH);

			if ($rowPH == 0) {
				//Checking empty!
				if ($stringifyMiles[$c3 + 1] != '') {
					mysql_query("INSERT INTO profile_history_mile (profile_id,profile_hm_name,profile_hm_founded) values('" . $companyId . "','" . $stringifyMiles[$c3 + 1] . "','" . $stringifyMiles[$c3 + 2] . "')");
					//echo $stringifyMiles[$c3+1];
				}
			}
		} else {
			$resPH = mysql_query("SELECT * FROM profile_history_mile WHERE profile_hm_name = '" . $stringifyMiles[$c3 + 1] . "' AND profile_id!='" . $companyId . "'");
			$rowPH = mysql_num_rows($resPH);

			if ($rowPH == 0) {
				//Checking empty!
				if ($stringifyMiles[$c3 + 1] != '') {
					mysql_query("UPDATE profile_history_mile SET profile_hm_name='" . $stringifyMiles[$c3 + 1] . "',profile_hm_founded='" . $stringifyMiles[$c3 + 2] . "' where profile_hm_id='$stringifyMiles[$c3]'");

					//echo $stringifyMiles[$c3];
				}
			}
		}
		//mysql_query("UPDATE profile SET  ");

		$c3 = $c3 + 3;
	}

	$lengthFund = count($stringifyFund);
	$c4 = 0;
	while ($c4 < $lengthFund) {
		if ($stringifyFund[$c4] == '0') {
			$resPF = mysql_query("SELECT * FROM profile_funding WHERE profile_funding_round = '" . $stringifyFund[$c4 + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPF = mysql_num_rows($resPF);

			if ($rowPF == 0) {
				//Checking empty!
				if ($stringifyFund[$c4 + 1] != '') {
					mysql_query("INSERT INTO profile_funding (profile_id,profile_funding_round,profile_funding_asign,profile_funding_amount,profile_funding_date,profile_funding_type,profile_funding_person) values('" . $companyId . "','" . $stringifyFund[$c4 + 1] . "','" . $stringifyFund[$c4 + 2] . "','" . $stringifyFund[$c4 + 3] . "','" . $stringifyFund[$c4 + 4] . "','" . $stringifyFund[$c4 + 5] . "','" . $stringifyFund[$c4 + 6] . "')");
					//echo $stringifyMiles[$c3+1];
				}
			}
		} else {
			$resPF = mysql_query("SELECT * FROM profile_funding WHERE profile_funding_round = '" . $stringifyFund[$c4 + 1] . "' AND profile_id='" . $companyId . "'");
			$rowPF = mysql_num_rows($resPF);

			if ($rowPF == 1) {
				//Checking empty!
				if ($stringifyFund[$c4 + 1] != '') {
					mysql_query("UPDATE profile_funding SET profile_funding_round='" . $stringifyFund[$c4 + 1] . "',profile_funding_asign='" . $stringifyFund[$c4 + 2] . "',profile_funding_amount='" . $stringifyFund[$c4 + 3] . "',profile_funding_date='" . $stringifyFund[$c4 + 4] . "',profile_funding_type='" . $stringifyFund[$c4 + 5] . "',profile_funding_person='" . $stringifyFund[$c4 + 6] . "' where profile_funding_id='$stringifyFund[$c4]'");

					//echo $stringifyMiles[$c3];
				}
			}
		}
		//mysql_query("UPDATE profile SET  ");

		$c4 = $c4 + 7;
	}

	//echo $lengthCompet;

	$time = time();
	$sql1 = "INSERT INTO latest_edited (profile_id,profile_name,profile_create_date) VALUES ('$companyId','$profile_name','$time')";
	mysql_query($sql1);

	echo '1';
} else {
	echo '0';
}
?>