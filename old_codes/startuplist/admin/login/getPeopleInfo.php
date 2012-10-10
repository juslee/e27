<?php include("../lib/dbcon.php"); 
	$peopleId=$_GET['peopleId'];
	$c=0;
	$c2=0;

	$array=array();
	$array2=array();
	$array3=array();

	$arrayMain=array();
	$sqlInfo=mysql_query("select * from profile_person where profile_person_id='$peopleId'");
	
	while($rowInfo=mysql_fetch_array($sqlInfo)){
		$array[0]=$rowInfo['profile_person_name'];
		$array[1]=$rowInfo['profile_person_blog_url'];
		$array[2]=$rowInfo['profile_person_twitter_username'];
		$array[3]=$rowInfo['profile_person_linkedin_username'];
		$array[4]=$rowInfo['profile_person_image'];
		$array[5]=$rowInfo['profile_person_des'];
		$array[6]=$rowInfo['profile_person_email'];
		$array[7]=$rowInfo['profile_person_active'];
		$array[8]=$rowInfo['profile_people_id'];

	}
	$arrayMain['peopleBasic']=$array;
	
	
	$sqlCompaniesInfo=mysql_query("select * from  profile_person_companies where profile_person_id='$peopleId' order by profile_person_id asc");
	while($rowCompaniesInfo=mysql_fetch_array($sqlCompaniesInfo)){
		$array2[$c]=$rowCompaniesInfo['profile_person_companies_id'];	
		$array2[$c+1]=$rowCompaniesInfo['profile_person_companies'];	
		$array2[$c+2]=$rowCompaniesInfo['profile_person_companies_role'];	
		$array2[$c+3]=$rowCompaniesInfo['profile_person_companies_start'];	
		$array2[$c+4]=$rowCompaniesInfo['profile_person_companies_end'];	
		$c=$c+5;
	}
	$sqlInvestmentInfo=mysql_query("select * from  profile_person_fo where profile_person_id='$peopleId' order by profile_person_id asc");
	while($rowInvestmentInfo=mysql_fetch_array($sqlInvestmentInfo)){
		$array3[$c2]=$rowInvestmentInfo['profile_person_fo_id'];	
		$array3[$c2+1]=$rowInvestmentInfo['profile_person_fo'];	
		$array3[$c2+2]=$rowInvestmentInfo['profile_person_fo_role'];	
		$array3[$c2+3]=$rowInvestmentInfo['profile_person_fo_start'];	
		$array3[$c2+4]=$rowInvestmentInfo['profile_person_fo_end'];	
		$c2=$c2+5;
	
	}
	

	
	
	$arrayMain['peopleBasic']=$array;
	$arrayMain['peopleCompanies']=$array2;
	$arrayMain['peopleInvestment']=$array3;

	echo json_encode($arrayMain);
	//echo json_encode($array2);



?>