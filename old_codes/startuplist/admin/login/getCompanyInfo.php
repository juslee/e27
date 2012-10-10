<?php include("../lib/dbcon.php"); 
	$companyId=$_GET['companyId'];
	$c=0;
	$c2=0;
	$c3=0;
	$c4=0;
	$array=array();
	$array2=array();
	$array3=array();
	$array4=array();
	$array5=array();
	$arrayMain=array();
	$sqlInfo=mysql_query("select * from profile where profile_id='$companyId'");
	
	while($rowInfo=mysql_fetch_array($sqlInfo)){
		$array[0]=$rowInfo['profile_name'];
		$array[1]=$rowInfo['profile_description'];
		$array[2]=$rowInfo['profile_category'];
		$array[3]=$rowInfo['profile_homepage_url'];
		$array[4]=$rowInfo['profile_blog_url'];
		$array[5]=$rowInfo['profile_twitter_username'];
		$array[6]=$rowInfo['profile_facebook_username'];
		$array[7]=$rowInfo['profile_email'];
		$array[8]=$rowInfo['profile_number_of_employees'];
		$array[9]=$rowInfo['profile_founded_month'];
		$array[10]=$rowInfo['profile_founded_day'];
		$array[11]=$rowInfo['profile_founded_year'];
		$array[12]=$rowInfo['profile_country'];
		$array[13]=$rowInfo['profile_logo'];
		$array[14]=$rowInfo['profile_status'];
		$array[15]=$rowInfo['profile_active'];
		$array[16]=$rowInfo['profile_screenshots'];
	}
	$arrayMain['companyBasic']=$array;
	
	
	$sqlCompetiInfo=mysql_query("select * from profile_competitors where profile_id='$companyId' order by profile_competitors_id asc");
	while($rowCompetiInfo=mysql_fetch_array($sqlCompetiInfo)){
		$array2[$c]=$rowCompetiInfo['profile_competitors_id'];
		$array2[$c+1]=$rowCompetiInfo['profile_competitors_name'];	
		$c=$c+2;
	
	}
	
	$sqlPeopleInfo=mysql_query("select * from  profile_people where profile_id='$companyId' order by profile_people_id asc");
	while($rowPeopleInfo=mysql_fetch_array($sqlPeopleInfo)){
		$array3[$c2]=$rowPeopleInfo['profile_people_id'];	
		$array3[$c2+1]=$rowPeopleInfo['profile_people'];	
		$array3[$c2+2]=$rowPeopleInfo['profile_people_role'];	
		$array3[$c2+3]=$rowPeopleInfo['profile_people_start'];	
		$array3[$c2+4]=$rowPeopleInfo['profile_people_end'];	
		$c2=$c2+5;
	
	}
	
	$sqlMilestones=mysql_query("select * from  profile_history_mile where profile_id='$companyId' order by profile_hm_id asc");
	while($rowMilestones=mysql_fetch_array($sqlMilestones)){
		$array4[$c3]=$rowMilestones['profile_hm_id'];	
		$array4[$c3+1]=$rowMilestones['profile_hm_name'];	
		$array4[$c3+2]=$rowMilestones['profile_hm_founded'];	
		$c3=$c3+3;
	}
	
	$sqlFunding=mysql_query("select * from   profile_funding where profile_id='$companyId' order by profile_funding_id asc");
	while($rowFunding=mysql_fetch_array($sqlFunding)){
		$array5[$c4]=$rowFunding['profile_funding_id'];	
		$array5[$c4+1]=$rowFunding['profile_funding_round'];	
		$array5[$c4+2]=$rowFunding['profile_funding_asign'];	
		$array5[$c4+3]=$rowFunding['profile_funding_amount'];	
		$array5[$c4+4]=$rowFunding['profile_funding_date'];	
		$array5[$c4+5]=$rowFunding['profile_funding_type'];	
		$array5[$c4+6]=$rowFunding['profile_funding_person'];	
			
		$c4=$c4+7;
	}
	
	
	$arrayMain['companyBasic']=$array;
	$arrayMain['companyCompeti']=$array2;
	$arrayMain['companyPeople']=$array3;
	$arrayMain['companyMilestones']=$array4;
	$arrayMain['companyFunding']=$array5;
	echo json_encode($arrayMain);
	//echo json_encode($array2);



?>