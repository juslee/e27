<?php
include ("dbcon.php");

if (isset($_POST['peopleId'])) {

	$profile_person_id = $_POST['peopleId'];
	$profile_person_name = $_POST['profile_person_name'];
	$profile_person_blog_url = $_POST['profile_person_blog_url'];
	$profile_person_twitter_username = $_POST['profile_person_twitter_username'];
	$profile_person_linkedin_username = $_POST['profile_person_linkedin_username'];
	$profile_person_image = $_POST['profile_person_image'];
	$profile_person_des = $_POST['profile_person_des'];
	$profile_person_email = $_POST['profile_person_email'];
	$profile_person_active = $_POST['profile_person_active'];
	$profile_people_id = $_POST['profile_people_id'];
	$profilePersonOld = $_POST['profilePersonOld'];
	$stringifyCompaniesUp = json_decode($_POST['stringifyCompaniesUp']);
	$stringifyInvestmentUp = json_decode($_POST['stringifyInvestmentUp']);
	//echo $stringifyInvestmentUp;
	$res1 = mysql_query("SELECT profile_person_name,profile_person_id FROM profile_person where profile_person_name='" . $profile_person_name . "' AND profile_person_email='" . $profile_person_email . "' AND profile_person_id!='" . $profile_person_id . "' ");
	$row1 = mysql_num_rows($res1);
	//check if there was not a match
	if ($row1 == 0) {
		$sql = "UPDATE profile_person SET profile_person_name='" . $profile_person_name . "',profile_person_blog_url='" . $profile_person_blog_url . "',profile_person_twitter_username='" . $profile_person_twitter_username . "',profile_person_linkedin_username='" . $profile_person_linkedin_username . "',profile_person_image='" . $profile_person_image . "',profile_person_des='" . $profile_person_des . "',profile_person_email='" . $profile_person_email . "',profile_person_active='" . $profile_person_active . "' WHERE profile_person_id='" . $profile_person_id . "' ";

		mysql_query($sql);

		$resPP = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $profile_person_name . "' AND profile_people='" . $profilePersonOld . "'");
		$rowPP = mysql_num_rows($resPP);

		if ($rowPP == 0) {
			//Checking empty!
			if ($profile_person_name != '') {
				mysql_query("UPDATE profile_people SET profile_people='" . $profile_person_name . "' where profile_people='$profilePersonOld'");
				//echo $stringifyPeople[$c2+1];

			}
		}

		$arr = count($stringifyCompaniesUp);
		//echo $arr;
		$d = 0;
		while ($d < $arr) {
			if ($stringifyCompaniesUp[$d] == '0') {
				$resPC = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $stringifyCompaniesUp[$d + 1] . "' AND profile_person_id='" . $profile_person_id . "'");
				$rowPC = mysql_num_rows($resPC);

				if ($rowPC == 0) {
					//Checking empty!
					if ($stringifyCompaniesUp[$d + 1] != '') {
						mysql_query("INSERT INTO profile_person_companies (profile_person_id,profile_person_companies,profile_person_companies_role,profile_person_companies_start,profile_person_companies_end) values('" . $profile_person_id . "','" . $stringifyCompaniesUp[$d + 1] . "','" . $stringifyCompaniesUp[$d + 2] . "','" . $stringifyCompaniesUp[$d + 3] . "','" . $stringifyCompaniesUp[$d + 4] . "')");
						//	echo $stringifyCompaniesUp[$d+1];
						$resPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyCompaniesUp[$d + 1] . "'");
						$rowPPC = mysql_num_rows($resPPC);
						if ($rowPPC == 0) {
							$sqlSPp = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies='" . $stringifyCompaniesUp[$d + 1] . "'");
							$rSPp = mysql_fetch_array($sqlSPp);
							$profile_person_companies_id = $rSPp['profile_person_companies_id'];
							mysql_query("INSERT INTO profile (profile_name,profile_person_id,profile_org,profile_person_companies_id) values('" . $stringifyCompaniesUp[$d + 1] . "','" . $profile_person_id . "','1','" . $profile_person_companies_id . "')");
							$sqlSP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyCompaniesUp[$d + 1] . "'");
							$rSP = mysql_fetch_array($sqlSP);
							$profile_id = $rSP['profile_id'];
							mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_id . "','" . $profile_person_name . "','" . $stringifyCompaniesUp[$d + 2] . "','" . $stringifyCompaniesUp[$d + 3] . "','" . $stringifyCompaniesUp[$d + 4] . "')");
							$timex = time();
							$sqllu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profile_id . "','" . $stringifyCompaniesUp[$d + 1] . "','$timex')";
							mysql_query($sqllu);
						} else {
							$sqlnn = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyCompaniesUp[$d + 1] . "'");
							$rnn = mysql_fetch_array($sqlnn);
							$profile_idnn = $rnn['profile_id'];
							$resddv = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $profile_person_name . "' AND profile_id='" . $profile_idnn . "'");
							$rowddv = mysql_num_rows($resddv);
							if ($rowddv == 0) {
								if ($profile_person_name != '') {
									mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_idnn . "','" . $profile_person_name . "','" . $stringifyCompaniesUp[$d + 2] . "','" . $stringifyCompaniesUp[$d + 3] . "','" . $stringifyCompaniesUp[$d + 4] . "')");
								}
							}
						}
					}
				}
			} else {
				$resPC = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies = '" . $stringifyCompaniesUp[$d + 1] . "' AND profile_person_id='" . $profile_person_id . "'");
				$rowPC = mysql_num_rows($resPC);

				if ($rowPC == 0) {
					//Checking empty!
					if ($stringifyCompaniesUp[$d + 1] != '') {
						mysql_query("UPDATE profile_person_companies SET profile_person_companies='" . $stringifyCompaniesUp[$d + 1] . "',profile_person_companies_role='" . $stringifyCompaniesUp[$d + 2] . "',profile_person_companies_start='" . $stringifyCompaniesUp[$d + 3] . "',profile_person_companies_end='" . $stringifyCompaniesUp[$d + 4] . "' WHERE profile_person_companies_id='$stringifyCompaniesUp[$d]'");
						//echo $stringifyCompaniesUp[$d];
						$sqlSPU = mysql_query("SELECT * FROM profile_person_companies WHERE profile_person_companies='" . $stringifyCompaniesUp[$d + 1] . "'");
						$rSPU = mysql_fetch_array($sqlSPU);
						$profile_person_companies_idc = $rSPU['profile_person_companies_id'];
						mysql_query("UPDATE profile SET profile_name='" . $stringifyCompaniesUp[$d + 1] . "' where profile_person_companies_id='$profile_person_companies_idc'");

					}
				}
			}
			$d = $d + 5;

		}
		$arrp = count($stringifyInvestmentUp);
		$dp = 0;
		while ($dp < $arrp) {
			if ($stringifyInvestmentUp[$dp] == '0') {
				$resPF = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo = '" . $stringifyInvestmentUp[$dp + 1] . "' AND profile_person_id='" . $profile_person_id . "'");
				$rowPF = mysql_num_rows($resPF);

				if ($rowPF == 0) {
					//Checking empty!
					if ($stringifyInvestmentUp[$dp + 1] != '') {
						mysql_query("INSERT INTO profile_person_fo (profile_person_id,profile_person_fo,profile_person_fo_role,profile_person_fo_start,profile_person_fo_end) values('" . $profile_person_id . "','" . $stringifyInvestmentUp[$dp + 1] . "','" . $stringifyInvestmentUp[$dp + 2] . "','" . $stringifyInvestmentUp[$dp + 3] . "','" . $stringifyInvestmentUp[$dp + 4] . "')");
						//echo $stringifyCompetitors[$c+1];
						$resPPPC = mysql_query("SELECT * FROM profile WHERE profile_name = '" . $stringifyInvestmentUp[$dp + 1] . "'");
						$rowPPPC = mysql_num_rows($resPPPC);
						if ($rowPPPC == 0) {
							$sqlSPFc = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo='" . $stringifyInvestmentUp[$dp + 1] . "'");
							$rSPFc = mysql_fetch_array($sqlSPFc);
							$profile_person_companies_idx = $rSPFc['profile_person_fo_id'];
							mysql_query("INSERT INTO profile (profile_name,profile_person_id,profile_org,profile_person_companies_id) values('" . $stringifyInvestmentUp[$dp + 1] . "','" . $profile_person_id . "','0','" . $profile_person_companies_idx . "')");
							$sqlSPP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyInvestmentUp[$dp + 1] . "'");
							$rSPP = mysql_fetch_array($sqlSPP);
							$profile_idy = $rSPP['profile_id'];
							mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_idy . "','" . $profile_person_name . "','" . $stringifyInvestmentUp[$dp + 2] . "','" . $stringifyInvestmentUp[$dp + 3] . "','" . $stringifyInvestmentUp[$dp + 4] . "')");
							$timexx = time();
							$sqlluu = "INSERT INTO latest_update (profile_id,profile_name,profile_create_date) VALUES ('" . $profile_idy . "','" . $stringifyInvestmentUp[$dp + 1] . "','$timexx')";
							mysql_query($sqlluu);
						} else {
							$sqlnnP = mysql_query("SELECT * FROM profile WHERE profile_name='" . $stringifyInvestmentUp[$dp + 1] . "'");
							$rnnP = mysql_fetch_array($sqlnnP);
							$profile_idnny = $rnnP['profile_id'];
							$resddb = mysql_query("SELECT * FROM profile_people WHERE profile_people = '" . $profile_person_name . "' AND profile_id='" . $profile_idnny . "'");
							$rowddb = mysql_num_rows($resddb);
							if ($rowddb == 0) {
								if ($profile_person_name != '') {
									mysql_query("INSERT INTO profile_people (profile_id,profile_people,profile_people_role,profile_people_start,profile_people_end) values('" . $profile_idnny . "','" . $profile_person_name . "','" . $stringifyInvestmentUp[$dp + 2] . "','" . $stringifyInvestmentUp[$dp + 3] . "','" . $stringifyInvestmentUp[$dp + 4] . "')");

								}
							}
						}
					}
				}
			} else {
				$resPF = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo = '" . $stringifyInvestmentUp[$dp + 1] . "' AND profile_person_id='" . $profile_person_id . "'");
				$rowPF = mysql_num_rows($resPF);

				if ($rowPF == 0) {
					//Checking empty!
					if ($stringifyInvestmentUp[$dp + 1] != '') {
						mysql_query("UPDATE profile_person_fo SET profile_person_fo='" . $stringifyInvestmentUp[$dp + 1] . "',profile_person_fo_role='" . $stringifyInvestmentUp[$dp + 2] . "',profile_person_fo_start='" . $stringifyInvestmentUp[$dp + 3] . "',profile_person_fo_end='" . $stringifyInvestmentUp[$dp + 4] . "' WHERE profile_person_fo_id='$stringifyInvestmentUp[$dp]'");
						//echo $stringifyCompetitors[$c];
						$sqlSPFU = mysql_query("SELECT * FROM profile_person_fo WHERE profile_person_fo='" . $stringifyInvestmentUp[$dp + 1] . "'");
						$rSPFU = mysql_fetch_array($sqlSPFU);
						$profile_person_companies_idy = $rSPFU['profile_person_fo_id'];
						mysql_query("UPDATE profile SET profile_name='" . $stringifyInvestmentUp[$dp + 1] . "' where profile_person_companies_id='$profile_person_companies_idy'");
					}
				}
			}
			$dp = $dp + 5;

		}
		$time1 = time();
		$sql1 = "INSERT INTO latest_edited_person	(profile_person_id,profile_person_name,profile_person_date) VALUES ('$profile_person_id','$profile_person_name','$time1')";
		mysql_query($sql1);
		echo '1';
	} else {
		echo '0';
	}
} else {
	echo "not success";
}
?>

