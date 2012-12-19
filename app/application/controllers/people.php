<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class people extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		
		$sql = "select * from `people` where 1 order by `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$people = $q->result_array();
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		
		$sql = "select count(id) as `cnt` from `people` where 1 order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		
		$t  = count($people);
		for($i=0; $i<$t; $i++){
			//get the latest company
			$sql = "select `a`.`id`, `a`.`name`, `b`.`role` from `companies` as `a`, `company_person` as `b` where 
			`a`.`id` = `b`.`company_id` and 
			`b`.`person_id`='".$people[$i]['id']."' and 
			(
				(
					`b`.`end_date_ts`<>0 and 
					`b`.`end_date_ts`>=".time()."
				)
				or
				`b`.`end_date_ts` = 0
			)
			order by `b`.`start_date_ts` desc
			limit 1
			";
			$q = $this->db->query($sql);
			$company_person = $q->result_array();
			$current_company_id = $company_person[0]['id'];
			$current_company = $company_person[0]['name'];
			$current_role = $company_person[0]['role'];
			$people[$i]['current_company_id'] = $current_company_id;
			$people[$i]['current_company'] = $current_company;
			$people[$i]['current_role'] = $current_role;
		}
	
		$data = array();
		$data['people'] = $people;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('people/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$filter = $_GET['filter'];
		$start += 0;
		$limit = 50;
		$search = strtolower(trim($_GET['search']));
		$searchx = trim($_GET['search']);
		
		$sql = "select * from `people` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`blog_url`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$people = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `people` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`blog_url`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$t  = count($people);
		for($i=0; $i<$t; $i++){
			//get the latest company
			$sql = "select `a`.`id`, `a`.`name`, `b`.`role` from `companies` as `a`, `company_person` as `b` where 
			`a`.`id` = `b`.`company_id` and 
			`b`.`person_id`='".$people[$i]['id']."' and 
			(
				(
					`b`.`end_date_ts`<>0 and 
					`b`.`end_date_ts`>=".time()."
				)
				or
				`b`.`end_date_ts` = 0
			)
			order by `b`.`start_date_ts` desc
			limit 1
			";
			$q = $this->db->query($sql);
			$company_person = $q->result_array();
			$current_company_id = $company_person[0]['id'];
			$current_company = $company_person[0]['name'];
			$current_role = $company_person[0]['role'];
			$people[$i]['current_company_id'] = $current_company_id;
			$people[$i]['current_company'] = $current_company;
			$people[$i]['current_role'] = $current_role;
		}
		
		$data = array();
		$data['people'] = $people;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $searchx;
		$data['filter'] = $filter;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('people/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function export($md5, $format="html"){
		$sql = $_SESSION['export_sqls'][$md5];
		if($sql){
			$q = $this->db->query($sql);
			$people = $q->result_array();
			//print_r($people);
			$t = count($people);
			for($i=0; $i<$t; $i++){
				$person_id = $people[$i]['id'];
				$time = time();
				$sql = "select 
				`a`.*, 
				if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
				`b`.`name` as `name` 
				from `company_person` as `a` left join `companies` as `b` on (`a`.`company_id`=`b`.`id`) 
				where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
				order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
				$q = $this->db->query($sql);
				$companies = $q->result_array();
				$companiesarr = array();
				foreach($companies as $company){
					$companiesarr[] = safeExport($company['name']).",".safeExport($company['role']).",".date("M/d/Y", $company['start_date_ts']);
				}
				$companiesstr = implode(", ", $companiesarr);
				$people[$i]['companies'] = $companiesstr;
				
				$sql = "select 
				`a`.*,
				if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
				`b`.`name` as `name` from `investment_org_person` as `a` left join `investment_orgs` as `b` on (`a`.`investment_org_id`=`b`.`id`) 
				where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
				order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
				$q = $this->db->query($sql);
				$investment_orgs = $q->result_array();
				$investment_orgsarr = array();
				foreach($investment_orgs as $investment_org){
					$investment_orgsarr[] = safeExport($investment_org['name']).",".safeExport($investment_org['role']).",".date("M/d/Y", $investment_org['start_date_ts']);
				}
				$investment_orgsstr = implode(", ", $investment_orgsarr);
				$people[$i]['investment_orgs'] = $investment_orgsstr;
				
				$sql = "select 
				`a`.`round`,
				`a`.`currency`,
				`a`.`amount`,
				`a`.`date_ts`,
				`a`.`company_id`,
				`b`.`name` as `company_name`
				from
				`company_fundings` as `a` left join `companies` as `b` on (`a`.`company_id` = `b`.`id`) where `a`.`id` in (
					select distinct `company_funding_id` from `company_fundings_ipc`
					where 
					`ipc_id`=".$this->db->escape($person_id)." and 
					`type`='person'
					)
				order by `date_ts` desc, `company_name` asc
				";
				$q = $this->db->query($sql);
				$milestones = $q->result_array();
				
				$milestonesarr = array();
				foreach($milestones as $milestone){
					$str = safeExport($milestone['round']).",".
					$milestone['currency'].number_format($milestone['amount'], 2, ".", "").",".
					date('M/d/Y', $milestone['date_ts']).",".safeExport($milestone['company_name']);
					$milestonesarr[] = $str;
				}
				$people[$i]['milestones'] = implode(", ", $milestonesarr);
			}
			$data = array();
			$data['people'] = $people;
			$data['format'] = $format;
			$this->load->view('people/export', $data);
		}
	}
	
	function import($command=""){
		$table = 'people';
		if($command=="samplecsv"){
			$this->load->view($table.'/samplecsv');
		}
		else if($command=='getfiles'){
			$folder = dirname(__FILE__)."/../../media/uploads/csv/".$table;
			$files = scandir($folder);
		}
		else if($command=='processfile'){
			$file = dirname(__FILE__)."/../../".$_POST['filepath'];
			$handle = fopen($file, "r");
			$skipped = false;
			$rowcount = 0;
			while (($row = fgetcsv($handle)) !== FALSE) {
				if($skipped==false&&$_POST['skipheaders']){
					$skipped = true;
					continue;
				}
				//if(!trim($row[2])&&!trim($row[0])){ //skip if no email and no namel
				//	continue;
				//}
				if(!trim($row[2])){ //skip if no email
					continue;
				}
				foreach($row as $key=>$value){
					$row[$key] = trim($value);
				}
				$skipped = true;
				$rowcount++;
				$data[] = $row;
				$sql =  "select `id`, `name`, `email_address` from `".$table."` where `email_address`='".$row[2]."'"; //email address is the unique field
				$q = $this->db->query($sql);
				$record = $q->result_array();
				if($record[0]&&trim($row[2])){ //if there is record and email is not blank
					if($row[9]!="1"&&$row[9]!="0"){ //active
						$row[9] = "1";
					}
					$sql = "update `".$table."` set 
					`name` = '".mysql_real_escape_string($row[0])."',
					`description` = '".mysql_real_escape_string($row[1])."',
					`email_address` = '".mysql_real_escape_string($row[2])."',
					`blog_url` = '".mysql_real_escape_string($row[3])."',
					`blog` = '".mysql_real_escape_string($row[4])."',
					`twitter_username` = '".mysql_real_escape_string($row[5])."',
					`facebook` = '".mysql_real_escape_string($row[6])."',
					`linkedin` = '".mysql_real_escape_string($row[7])."',
					`tags` = '".mysql_real_escape_string($row[8])."',
					`active` = '".mysql_real_escape_string($row[9])."',
					`dateupdated` = NOW()
					where 
					`id`='".$record[0]['id']."'
					";
					$this->db->query($sql);
					
					$sql = "insert into `logs` set 
						`action` = 'edited',
						`table` = '".$table."',
						`ipc_id` = ".$this->db->escape($record[0]['id']).",
						`name` = ".$this->db->escape($record[0]['name']).",
						`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
						`dateadded_ts` = ".time().",
						`dateadded` = NOW()
					";
					$this->db->query($sql);
					$id = $record[0]['id'];
					$this->slugify($id);
					echo "[$rowcount] Updated <a href='".site_url().$table."/edit/".$id."'>".$record[0]['email_address']." (".$row[0].")"."</a><br>";
				}
				else{
					if($row[9]!="1"&&$row[9]!="0"){ //active
						$row[9] = "1";
					}
					$sql = "insert into `".$table."` set 
					`name` = '".mysql_real_escape_string($row[0])."',
					`description` = '".mysql_real_escape_string($row[1])."',
					`email_address` = '".mysql_real_escape_string($row[2])."',
					`blog_url` = '".mysql_real_escape_string($row[3])."',
					`blog` = '".mysql_real_escape_string($row[4])."',
					`twitter_username` = '".mysql_real_escape_string($row[5])."',
					`facebook` = '".mysql_real_escape_string($row[6])."',
					`linkedin` = '".mysql_real_escape_string($row[7])."',
					`tags` = '".mysql_real_escape_string($row[8])."',
					`active` = '".mysql_real_escape_string($row[9])."',
					`dateadded` = NOW(),
					`dateupdated` = NOW()
					";
					$this->db->query($sql);
					$id = $this->db->insert_id();
					$sql = "insert into `logs` set 
						`action` = 'added',
						`table` = '".$table."',
						`ipc_id` = ".$this->db->escape($id).",
						`name` = ".$this->db->escape($row[0]).",
						`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
						`dateadded_ts` = ".time().",
						`dateadded` = NOW()
					";
					$this->db->query($sql);
					$this->slugify($id);
					echo "[$rowcount] Added <a href='".site_url().$table."/edit/".$id."'>".$row[2]." (".$row[0].")"."</a><br>";
				}
			}
			fclose($handle);
			unlink($file);
		}
		elseif($command=="samplecsvold"){
			$this->load->view($table.'/samplecsvold');
		}
		else if($command=='processfileold'){
			$file = dirname(__FILE__)."/../../".$_POST['filepath'];
			$handle = fopen($file, "r");
			$skipped = 0;
			$rowcount = 0;
			while (($row = fgetcsv($handle)) !== FALSE) {
				/*
				Array
				(
					[0] => Headers :
					[1] => Name
					[2] => Blog
					[3] => Twitter
					[4] => Linkedin
					[5] => Profile Image
					[6] => Description
					[7] => Companies
					[8] => Investment Organizations
					[9] => Email
					[10] => Active? 
				)
				*/		
				if($skipped<2&&$_POST['skipheaders']){
					$skipped++;
					continue;
				}
				//if(!trim($row[9])&&!trim($row[1])){ //skip if no email and no name
				//	continue;
				//}
				if(!trim($row[9])){ //skip if no email
					continue;
				}
				foreach($row as $key=>$value){
					$row[$key] = trim($value);
				}
				$skipped++;;
				$rowcount++;
				$data[] = $row;
				$sql =  "select `id`, `name`, `email_address` from `".$table."` where `email_address`='".$row[9]."'"; //email address is the unique field
				$q = $this->db->query($sql);
				$record = $q->result_array();
				if($record[0]&&trim($row[9])){
					if($row[10]!="1"&&$row[10]!="0"){ //active
						$row[10] = "1";
					}
					$blog =  explode(",", $row[2]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "update `".$table."` set 
					`name` = '".mysql_real_escape_string($row[1])."',
					`description` = '".mysql_real_escape_string($row[6])."',
					`email_address` = '".mysql_real_escape_string($row[9])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[3])."',
					`linkedin` = '".mysql_real_escape_string($row[4])."',
					`active` = '".mysql_real_escape_string($row[10])."',
					`dateupdated` = NOW()
					where 
					`id`='".$record[0]['id']."'
					";
					$this->db->query($sql);
					
					$sql = "insert into `logs` set 
						`action` = 'edited',
						`table` = '".$table."',
						`ipc_id` = ".$this->db->escape($record[0]['id']).",
						`name` = ".$this->db->escape($record[0]['name']).",
						`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
						`dateadded_ts` = ".time().",
						`dateadded` = NOW()
					";
					$this->db->query($sql);
					$id = $record[0]['id'];
					$this->slugify($id);
					echo "[$rowcount] Updated <a href='".site_url().$table."/edit/".$id."'>".$record[0]['email_address']." (".$row[1].")"."</a><br>";
				}
				else{
					if($row[10]!="1"&&$row[10]!="0"){ //active
						$row[10] = "1";
					}
					$blog =  explode(",", $row[2]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "insert into `".$table."` set 
					`name` = '".mysql_real_escape_string($row[1])."',
					`description` = '".mysql_real_escape_string($row[6])."',
					`email_address` = '".mysql_real_escape_string($row[9])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[3])."',
					`linkedin` = '".mysql_real_escape_string($row[4])."',
					`active` = '".mysql_real_escape_string($row[10])."',
					`dateadded` = NOW(),
					`dateupdated` = NOW()
					";
					$this->db->query($sql);
					$id = $this->db->insert_id();
					$sql = "insert into `logs` set 
						`action` = 'added',
						`table` = '".$table."',
						`ipc_id` = ".$this->db->escape($id).",
						`name` = ".$this->db->escape($row[9]."(".$row[1].")").",
						`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
						`dateadded_ts` = ".time().",
						`dateadded` = NOW()
					";
					$this->db->query($sql);
					$this->slugify($id);
					echo "[$rowcount] Added <a href='".site_url().$table."/edit/".$id."'>".$row[9]." (".$row[1].")"."</a><br>";
				}
			}
			fclose($handle);
			unlink($file);
		}
		else{
			$data = array();
			$data['command'] = $command; 
			$data['content'] = $this->load->view($table.'/import', $data, true);
			$this->load->view('layout/main', $data);
		}
	}
	
	public function ajax_search(){
		$co_name = strtolower($_GET['term'])."%";
		$sql = "select `id` as `value`, `name` as `label` from `people` where LOWER(`name`) like ".$this->db->escape(trim($co_name))." limit 10" ;
		
		$q = $this->db->query($sql);
		$people = $q->result_array();
		
		$t = count($people);
		for($i=0; $i<$t; $i++){
			//get the latest company
			$sql = "select `a`.`id`, `a`.`name`, `b`.`role` from `companies` as `a`, `company_person` as `b` where 
			`a`.`id` = `b`.`company_id` and 
			`b`.`person_id`='".$people[$i]['value']."' and 
			(
				(
					`b`.`end_date_ts`<>0 ";
					
					//$sql .= "and `b`.`end_date_ts`>=".time();
					
					$sql.= "
					
				)
				or
				`b`.`end_date_ts` = 0
			)
			order by `b`.`start_date_ts` desc
			limit 1
			";
			$q = $this->db->query($sql);
			$company_person = $q->result_array();
			$current_company_id = $company_person[0]['id'];
			$current_company = $company_person[0]['name'];
			$current_role = $company_person[0]['role'];
			$people[$i]['current_company_id'] = $current_company_id;
			$people[$i]['current_company'] = $current_company;
			$people[$i]['current_role'] = $current_role;
			$people[$i]['desc'] = $current_company;
		}

		echo json_encode($people);
		exit();
	}
	
	function ajax_check_email(){
		$co_name = $_POST['email'];
		$co_id = $_POST['id'];
		if(!checkEmail($_POST['email_address'])){
			?>
			jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='Invalid E-mail address.' alt='Invalid E-mail address.' />");
			<?php
		}
		else if(strlen($co_name)>0){
			//check if email already exists
			$sql = "select `id` from `people` where `email_address`=".$this->db->escape(trim($co_name));
			$q = $this->db->query($sql);
			$person = $q->result_array();
			if(!trim($co_id)){
				if($person[0]['id']){
					?>
					jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='E-mail already exists in the database.' alt='E-mail already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
					<?php
				}

			}
			else{
				if(trim($person[0]['id'])&&$person[0]['id']!=$co_id){
					?>
					jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='E-mail already exists in the database.' alt='E-mail already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#email_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
					<?php
				}
			}
		}
	}
	
	public function ajax_edit($revisionid=""){
		if($revisionid){
			$sql = "update `revisions` set `approved`=1 where `id`='".mysql_real_escape_string($revisionid)."'";
			$q = $this->db->query($sql);
		}
		if(!$_SESSION['user']&&!$_SESSION['web_user']){
			return false;
		}
		$err = 0;
		if(trim($_POST['email_address'])){
			//check if company already exists
			$sql = "select `id` from `people` where `email_address`=".$this->db->escape(trim($_POST['email_address']));
			$q = $this->db->query($sql);
			$person = $q->result_array();	
		}
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		else if($person[0]['id']!=""&&$person[0]['id']!=$_POST['id']){
			$err = 1;
			?>
			alertX("<div class='red'>E-mail already exists in the database.</div>");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Description.</div>");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a valid E-mail.</div>");
			<?php
		}
		else{
			$sql = "select * from `people` where `id`=".$this->db->escape(trim($_POST['id']));
			$q = $this->db->query($sql);
			$people = $q->result_array();	
			if(!$people[0]){
				$err = 1;
				?>
				alertX("<div class='red'><div class='red'>Person doesnt exists in the database.</div></div>");
				<?php
			}
		}
		
		//save a revision
		if($_SESSION['web_user']&&$_POST['web_edit']&&!$err){
			$sql = "select `id` from `revisions` where 
				`web_user_id`='".$_SESSION['web_user']['id']."' and 
				`table`='people' and 
				`ipc_id`='".mysql_real_escape_string($_POST['id'])."' and 
				`approved` = 0
				";
			$q = $this->db->query($sql);
			$revision = $q->result_array();
			$revision = $revision[0];
			if($revision['id']){
				$sql = "update `revisions` set 
					`web_user_id`='".$_SESSION['web_user']['id']."',
					`table`='people',
					`ipc_id`='".mysql_real_escape_string($_POST['id'])."',
					`json_data`='".mysql_real_escape_string(json_encode($_POST))."',
					`dateupdated_ts` = '".time()."',
					`approved` = 0
					where 
					`id`='".$revision['id']."'
				";
				$this->db->query($sql);
			}
			else{
				$sql = "insert into `revisions` set 
					`web_user_id`='".$_SESSION['web_user']['id']."',
					`table`='people',
					`ipc_id`='".mysql_real_escape_string($_POST['id'])."',
					`json_data`='".mysql_real_escape_string(json_encode($_POST))."',
					`dateadded_ts` = '".time()."',
					`dateupdated_ts` = '".time()."',
					`approved` = 0
				";
				$this->db->query($sql);
			}
			$debug = $sql;
			$debug = str_replace("\n", "\\n", $debug);
			$debug = str_replace("\r", "", $debug);
			?>
			alertX("<center>Thank you for the submission. It will be reviewed and approved shortly.</center>");
			
			setTimeout(function(){ self.location = "<?php echo site_url(); ?>editperson/<?php echo $_POST['id']; ?>/revisions" }, 2000);
			
			jQuery("#savebutton").val("Submit");
			jQuery("#person_form *").attr("disabled", false);
			<?php
			return false;
		}
		
		if(!$err){
			$sql = "update `people` set ";
			$arr = array();
			$post = $_POST;
			if(!$post['active']){
				$post['active'] = "0";
			}
			foreach($post as $key=>$value){
				if(!is_array($value)){
					$arr[] ="`".$key."`=".$this->db->escape(trim($value));
				}
			}
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext.", `dateupdated`=NOW()";
			$sql .= "where `id`=".$this->db->escape(trim($_POST['id']));
			$q = $this->db->query($sql);
			$id = trim($_POST['id']);
			$this->slugify($id);
			$sql = "delete from `company_person` where `person_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['c_ids'])){
				foreach($_POST['c_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `company_person` set 
					`person_id`=".$this->db->escape($id).", 
					`company_id`=".$this->db->escape($_POST['c_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}
			
			$sql = "delete from `investment_org_person` where `person_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['io_ids'])){
				foreach($_POST['io_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['iop_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['iop_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['iop_end_dates'][$key]);
					}
					$sql = "insert into `investment_org_person` set 
					`person_id`=".$this->db->escape($id).", 
					`investment_org_id`=".$this->db->escape($_POST['io_ids'][$key]).",
					`role`=".$this->db->escape($_POST['iop_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['iop_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['iop_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}

			?>
			alertX("Successfully Updated Person '<?php echo htmlentitiesX($_POST['name']); ?>'.");
			self.location = self.location; //refresh
			<?php
			$sql = "insert into `logs` set 
				`action` = 'edited',
				`table` = 'people',
				`ipc_id` = ".$this->db->escape(trim($_POST['id'])).",
				`name` = ".$this->db->escape(trim($_POST['name'])).",
				`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
				`dateadded_ts` = ".time().",
				`dateadded` = NOW()
			";
			$this->db->query($sql);
		}
		
		?>
		jQuery("#savebutton").val("Save");
		jQuery("#person_form *").attr("disabled", false);
		<?php		
		exit();
	}
	
	public function ajax_delete($person_id=""){
		if(!$_SESSION['user']){
			return false;
		}
		if(!$person_id){
			$person_id = $_POST['id'];
		}
		$sql = "select * from `people` where `id`=".$this->db->escape($person_id);
		$q = $this->db->query($sql);
		$person = $q->result_array();
		$sql = "delete from `people` where `id`=".$this->db->escape($person_id);
		$q = $this->db->query($sql);
		$sql = "delete from `company_person` where `person_id`=".$this->db->escape($person_id);
		$this->db->query($sql);
		$sql = "delete from `investment_org_person` where `person_id`=".$this->db->escape($person_id);
		$this->db->query($sql);
		$sql = "delete from `company_fundings_ipc` where `type`='person' and `ipc_id`=".$this->db->escape($person_id);
		$this->db->query($sql);
		if(trim($person[0]['name'])){
			?>
			alertX("Successfully deleted <?php echo htmlentitiesX($person[0]['name']); ?>");
			<?php
			$sql = "insert into `logs` set 
				`action` = 'deleted',
				`table` = 'people',
				`ipc_id` = ".$this->db->escape(trim($_POST['id'])).",
				`name` = ".$this->db->escape(trim($person[0]['name'])).",
				`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
				`dateadded_ts` = ".time().",
				`dateadded` = NOW()
			";
			$this->db->query($sql);
		}
		else{
			?>
			alertX("The record is already deleted in the database.");
			<?php
		}
	}
	
	public function ajax_add_person_shortcut_ipc(){	
		if(!$_SESSION['user']){
			return false;
		}
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `people` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			?>
			insert_id = "<?php echo sanitizeX($id); ?>";
			insert_id = uNum(insert_id);
			success = true;
			<?php
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'people',
				`ipc_id` = ".$this->db->escape($id).",
				`name` = ".$this->db->escape(trim($_POST['name'])).",
				`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
				`dateadded_ts` = ".time().",
				`dateadded` = NOW()
			";
			$this->db->query($sql);
		}
		else{
			?>
			insert_id = "";
			insert_id = uNum(insert_id);
			success = false;
			<?php
		}
		
		
	}
	
	public function ajax_add_person_shortcut(){
		if(!$_SESSION['user']){
			return false;
		}
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `people` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>"
			peoplePreAdd(label, value);
			jQuery("#person_add_loader").html("");
			jQuery("#people_search").attr("disabled", false);
			jQuery("#people_search").val("")
			<?php
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'people',
				`ipc_id` = ".$this->db->escape($id).",
				`name` = ".$this->db->escape(trim($_POST['name'])).",
				`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
				`dateadded_ts` = ".time().",
				`dateadded` = NOW()
			";
			$this->db->query($sql);
		}
		else{
			?>
			jQuery("#person_add_loader").html("");
			jQuery("#people_search").attr("disabled", false);
			jQuery("#people_search").val("");
			<?php
		}
	}
	public function ajax_add($contributionid=""){
		if(!$_SESSION['user']&&!$_SESSION['web_user']){
			return false;
		}
		$err = 0;
		if(trim($_POST['email_address'])){
			//check if company already exists
			$sql = "select `id` from `people` where `email_address`=".$this->db->escape(trim($_POST['email_address']));
			$q = $this->db->query($sql);
			$person = $q->result_array();	
		}
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		else if($person[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>E-mail already exists in the database.</div>");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Description.</div>");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a valid E-mail.</div>");
			<?php
		}
		
		//save a contribution
		if($_SESSION['web_user']&&$_POST['web_edit']&&!$err){
			$sql = "insert into `contributions` set 
				`web_user_id`='".$_SESSION['web_user']['id']."',
				`table`='people',
				`json_data`='".mysql_real_escape_string(json_encode($_POST))."',
				`dateadded_ts` = '".time()."',
				`dateupdated_ts` = '".time()."',
				`approved` = 0
			";
			$this->db->query($sql);
			?>
			alertX("<center>Thanks for the submission. It will be reviewed and approved shortly.</center>");
			setTimeout(function(){ self.location = self.location; }, 2000);
			self.location = self.location;
			//jQuery("#savebutton").val("Submit");
			//jQuery("#company_form *").attr("disabled", true);
			<?php
			return false;
		}
		
		if(!$err){
			$sql = "insert into `people` set ";
			$arr = array();
			foreach($_POST as $key=>$value){
				if(!is_array($value)&&$key!='sid'){
					$arr[] ="`".$key."`=".$this->db->escape(trim($value));
				}
			}
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext.", `dateadded`=NOW(), `dateupdated`=NOW()";
			
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			if(is_array($_POST['c_ids'])){
				$sql = "delete from `company_person` where `person_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['c_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `company_person` set 
					`person_id`=".$this->db->escape($id).", 
					`company_id`=".$this->db->escape($_POST['c_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}
			
			if(is_array($_POST['io_ids'])){
				$sql = "delete from `investment_org_person` where `person_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['io_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['iop_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['iop_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['iop_end_dates'][$key]);
					}
					$sql = "insert into `investment_org_person` set 
					`person_id`=".$this->db->escape($id).", 
					`investment_org_id`=".$this->db->escape($_POST['io_ids'][$key]).",
					`role`=".$this->db->escape($_POST['iop_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['iop_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['iop_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}
			
			//update profile_image url
			$profile_image = $_POST['profile_image'];
			if($profile_image){
				$profile_image = str_replace("temp/".$_POST['sid'], $id, $profile_image); //replace sid with the company id
				$sql = "update `people` set `profile_image`=".$this->db->escape($profile_image)." where `id`=".$this->db->escape($id);
				$this->db->query($sql);
				//move files
				$from = dirname(__FILE__)."/../../media/uploads/people/temp/".$_POST['sid']."/profile_image/".urldecode(basename($profile_image));
				$folder = dirname(__FILE__)."/../../media/uploads/people/".$id."/";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = $folder."profile_image/";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$to = $folder.urldecode(basename($profile_image));
				rename($from, $to);
			}
			if($_POST['sid']){
				$dir = dirname(__FILE__)."/../../media/uploads/people/temp/".$_POST['sid'];
				SureRemoveDir($dir, "true");
			}
			
			//approve the conrti and add the ipc id
			if($contributionid){
				$sql = "update `contributions` set `ipc_id`='".$id."', `approved`=1 where `id`='".mysql_real_escape_string($contributionid)."'";
				$q = $this->db->query($sql);
			}
			
			?>
			alertX("Successfully Added Person '<?php echo htmlentitiesX($_POST['name']); ?>'.");
			<?php
			if($contributionid){
				?>
				self.location = "<?php echo site_url(); ?>contributions";
				<?php
			}
			else{
				?>
				self.location = "<?php echo site_url(); ?>people/add";
				<?php
			}
			
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'people',
				`ipc_id` = ".$this->db->escape($id).",
				`name` = ".$this->db->escape(trim($_POST['name'])).",
				`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
				`dateadded_ts` = ".time().",
				`dateadded` = NOW()
			";
			$this->db->query($sql);
		}
		
		?>
		jQuery("#savebutton").val("Save");
		jQuery("#person_form *").attr("disabled", false);
		<?php		
		exit();
	}
	
	function add(){
		$data = array();
		$data['content'] = $this->load->view('people/add', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	function edit($person_id, $return=false){
		$sql = "select * from `people` where `id`=".$this->db->escape($person_id);
		$q = $this->db->query($sql);
		$person = $q->result_array();	
		if($person[0]['id']){
			$data = array();
			$time = time();
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`name` as `name` 
			from `company_person` as `a` left join `companies` as `b` on (`a`.`company_id`=`b`.`id`) 
			where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			$q = $this->db->query($sql);
			$companies = $q->result_array();
			
			$sql = "select 
			`a`.*,
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`name` as `name` from `investment_org_person` as `a` left join `investment_orgs` as `b` on (`a`.`investment_org_id`=`b`.`id`) 
			where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			$q = $this->db->query($sql);
			$investment_orgs = $q->result_array();
			
			$sql = "select 
			`a`.`round`,
			`a`.`currency`,
			`a`.`amount`,
			`a`.`date_ts`,
			`a`.`company_id`,
			`b`.`name` as `company_name`
			from
			`company_fundings` as `a` left join `companies` as `b` on (`a`.`company_id` = `b`.`id`) where `a`.`id` in (
				select distinct `company_funding_id` from `company_fundings_ipc`
				where 
				`ipc_id`=".$this->db->escape($person_id)." and 
				`type`='person'
				)
			order by `date_ts` desc, `company_name` asc
			";
			$q = $this->db->query($sql);
			$milestones = $q->result_array();
			$data['milestones'] = $milestones;
			$data['investment_orgs'] = $investment_orgs;
			$data['companies'] = $companies;
			$data['person'] = $person[0];
			if($return){
				return $data;
			}
			$data['content'] = $this->load->view('people/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			redirect_to(site_url()."people");
		}
	}
	
	public function revision($id=""){
		$changed = array();
		$data = array();
		$sql = "select `revisions`.* from `revisions` where `revisions`.`id`='".mysql_real_escape_string($id)."' and `revisions`.`table`='people' ";
		$q = $this->db->query($sql);
		$revision = $q->result_array();
		$revision = $revision[0];
		
		if($revision['id']){
			$person_id = $revision['ipc_id'];
			$person = json_decode($revision['json_data']);
			$person = objectToArray($person);
			$sql = "select * from `people` where `id`=".$this->db->escape($person_id);
			$q = $this->db->query($sql);
			$persontemp = $q->result_array();	
			
			$sql = "select * from `web_users` where `id`=".$this->db->escape($revision['web_user_id']);
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			$web_user = getWebUser($web_user);
			$data['web_user'] =  $web_user;
		}
		
		if($persontemp[0]['id']&&$web_user){
			$corig = $this->edit($persontemp[0]['id'], true); //get original data
			
			$data['personorig'] = $persontemp[0];
			$data['revision'] = $revision;
			
			$currencies = $corig['currencies'];
			$countries = $corig['countries'];
			$milestones = $corig['milestones'];
					
			$data['currencies'] = $currencies;
			$data['countries'] = $countries;
			$data['milestones'] = $milestones;

			$companies = array();
			if(is_array($person['c_ids'])){
				foreach($person['c_ids'] as $key=>$value){
					$sql = "select * from `companies` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$c = $q->result_array();
					$c = $c[0];
					$company = array();
					$company['company_id'] = $value;
					$company['person_id'] = $person_id;
					$company['role'] = $person['p_roles'][$key];;
					$company['start_date'] = $person['p_start_dates'][$key];
					$company['start_date_ts'] = strtotime($person['p_start_dates'][$key])."";
					$company['end_date'] = $person['p_end_dates'][$key];
					$company['end_date_ts'] = (strtotime($person['p_end_dates'][$key])+0)."";
					$company['name'] = $c['name'];
					//$person['slug'] = $p['slug'];
					$companies[] = $company;
				}
			}
			$data['companies'] = $companies;
			//remove ids and edn_date_ts2
			foreach($corig['companies'] as $key=>$value){
				unset($corig['companies'][$key]['id']);
				unset($corig['companies'][$key]['end_date_ts2']);
			}
			$a = bubble_sort($data['companies'], "name", "asc", true);
			$b = bubble_sort($corig['companies'], "name", "asc", true);
			if(arrDiff($a, $b)){
				$changed[] = "companies";
			}
			
			$investment_orgs = array();
			if(is_array($person['io_ids'])){
				foreach($person['io_ids'] as $key=>$value){
					$sql = "select * from `investment_orgs` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$io = $q->result_array();
					$io = $io[0];
					$investment_org = array();
					$investment_org['investment_org_id'] = $value;
					$investment_org['person_id'] = $person_id;
					$investment_org['role'] = $person['iop_roles'][$key];;
					$investment_org['start_date'] = $person['iop_start_dates'][$key];
					$investment_org['start_date_ts'] = strtotime($person['iop_start_dates'][$key])."";
					$investment_org['end_date'] = $person['iop_end_dates'][$key];
					$investment_org['end_date_ts'] = (strtotime($person['iop_end_dates'][$key])+0)."";
					$investment_org['name'] = $io['name'];
					$investment_orgs[] = $investment_org;
				}
			}
			$data['investment_orgs'] = $investment_orgs;
			//remove ids and edn_date_ts2
			foreach($corig['investment_orgs'] as $key=>$value){
				unset($corig['investment_orgs'][$key]['id']);
				unset($corig['investment_orgs'][$key]['end_date_ts2']);
			}
			$a = bubble_sort($data['investment_orgs'], "name", "asc", true);
			$b = bubble_sort($corig['investment_orgs'], "name", "asc", true);	
			if(arrDiff($a, $b)){
				$changed[] = "investment_orgs";
			}
			
			
			//remove arrays
			$unsets = array();
			foreach($person as $key=>$value){
				if(is_array($value)){
					$unsets[] = $key;
				}
				else{
					if(trim($value)!=trim($corig['person'][$key])){
						$changed[] = $key;
					}
				}
			}
			foreach($unsets as $key){
				unset($person[$key]);
			}
			$data['person'] = $person;
			$data['changed'] = $changed;
			$data['content'] = $this->load->view('people/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		
	}
	
	public function contribution($id=""){
		$data = array();
		$sql = "select `contributions`.* from `contributions` where `contributions`.`id`='".mysql_real_escape_string($id)."' and `contributions`.`table`='people' ";
		$q = $this->db->query($sql);
		$contribution = $q->result_array();
		$contribution = $contribution[0];
		
		if($contribution['id']){
			$person = json_decode($contribution['json_data']);
			$person = objectToArray($person);
			$sql = "select * from `people` where `id`=".$this->db->escape($person_id);
			$q = $this->db->query($sql);
			$persontemp = $q->result_array();	
			
			$sql = "select * from `web_users` where `id`=".$this->db->escape($contribution['web_user_id']);
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			$web_user = getWebUser($web_user);
			$data['web_user'] =  $web_user;
		}

	
		if($web_user){
			$data['contribution'] = $contribution;
			$companies = array();
			if(is_array($person['c_ids'])){
				foreach($person['c_ids'] as $key=>$value){
					$sql = "select * from `companies` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$c = $q->result_array();
					$c = $c[0];
					$company = array();
					$company['company_id'] = $value;
					$company['person_id'] = $person_id;
					$company['role'] = $person['p_roles'][$key];;
					$company['start_date'] = $person['p_start_dates'][$key];
					$company['start_date_ts'] = strtotime($person['p_start_dates'][$key])."";
					$company['end_date'] = $person['p_end_dates'][$key];
					$company['end_date_ts'] = (strtotime($person['p_end_dates'][$key])+0)."";
					$company['name'] = $c['name'];
					//$person['slug'] = $p['slug'];
					$companies[] = $company;
				}
			}
			$data['companies'] = $companies;
			
			$investment_orgs = array();
			if(is_array($person['io_ids'])){
				foreach($person['io_ids'] as $key=>$value){
					$sql = "select * from `investment_orgs` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$io = $q->result_array();
					$io = $io[0];
					$investment_org = array();
					$investment_org['investment_org_id'] = $value;
					$investment_org['person_id'] = $person_id;
					$investment_org['role'] = $person['iop_roles'][$key];;
					$investment_org['start_date'] = $person['iop_start_dates'][$key];
					$investment_org['start_date_ts'] = strtotime($person['iop_start_dates'][$key])."";
					$investment_org['end_date'] = $person['iop_end_dates'][$key];
					$investment_org['end_date_ts'] = (strtotime($person['iop_end_dates'][$key])+0)."";
					$investment_org['name'] = $io['name'];
					$investment_orgs[] = $investment_org;
				}
			}
			$data['investment_orgs'] = $investment_orgs;
			
			
			//remove arrays
			$unsets = array();
			foreach($person as $key=>$value){
				if(is_array($value)){
					$unsets[] = $key;
				}
				else{
					if(trim($value)!=trim($corig['person'][$key])){
						$changed[] = $key;
					}
				}
			}
			foreach($unsets as $key){
				unset($person[$key]);
			}
			$data['person'] = $person;
			$data['content'] = $this->load->view('people/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		
	}
	
	private function slugify($id){
		$table = "people";
		$sql = "select * from `".$table."` where `id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$list = $q->result_array();
		$t = count($list);
		for($i=0; $i<$t; $i++){
			$row = $list[$i];
			$n = 1;
			do{
				$slug = seoIze($row['name']);
				if($n>1){
					$slug = $slug.$n;
				}
				$sql = "select `id` from `".$table."` where `slug`='".$slug."' and `id`<>'".$row['id']."'";
				$q = $this->db->query($sql);
				$rowtemp = $q->result_array();
				$n++;
			}while($rowtemp[0]['id']);
			$sql = "update `".$table."` set `slug`='".$slug."' where `id`='".$row['id']."'";
			$q = $this->db->query($sql);
		}
	}
}
