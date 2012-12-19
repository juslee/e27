<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class companies extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		
		$sql = "select * from `companies` where 1 order by `name` asc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `companies` where 1 order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['companies'] = $companies;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('companies/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$filter = $_GET['filter'];
		$start += 0;
		$limit = 50;
		$search = strtolower(trim($_GET['search']));
		$searchx = trim($_GET['search']);
		
		$sql = "select * from `companies` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`website`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`blog_url`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`country`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `companies` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`website`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`blog_url`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%' or
				LOWER(`country`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc" ;
		
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['companies'] = $companies;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $searchx;
		$data['filter'] = $filter;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('companies/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function export($md5, $format="html"){
		$sql = $_SESSION['export_sqls'][$md5];
		if($sql){
			$q = $this->db->query($sql);
			$companies = $q->result_array();
			
			$t = count($companies);
			
			for($i=0; $i<$t; $i++){
				$company_id = $companies[$i]['id'];
				if($company_id){
					$data = array();
					$time = time();
					
					$sql = "select * from `screenshots` where `company_id`=".$this->db->escape($company_id)." order by id asc";
					$q = $this->db->query($sql);
					$screenshots = $q->result_array();
		
					$sql = "select `b`.`id` as `value`, `b`.`name` as `label` from `competitors` as `a`, `companies` as `b` where 
						(
							`a`.`company_id`=".$this->db->escape($company_id)." 
							and `a`.`competitor_id` = `b`.`id`
						)
						or
						(
							`a`.`competitor_id`=".$this->db->escape($company_id)." 
							and `a`.`company_id` = `b`.`id`
						)
						order by `b`.`name` asc
					";
					$q = $this->db->query($sql);
					$competitors = $q->result_array();
					$competitorsarr = array();
					foreach($competitors as $competitor){
						$competitorsarr[] = safeExport($competitor['label']);
					}
					$companies[$i]['competitors'] = implode(", ", $competitorsarr);
					
					$sql = "select 
					`a`.*, 
					if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
					`b`.`email_address` as `email`, `b`.`name` as `name` from `company_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
					where `company_id`=".$this->db->escape($company_id)." and `name`<>'' 
					order by `name` asc, `end_date_ts2` desc, `start_date_ts` desc";
					$q = $this->db->query($sql);
					$people = $q->result_array();
					$peoplearr = array();
					foreach($people as $person){
						if(!$person['email']){
							$email = "<e-mail address>";
						}
						else{
							$email = $person['email'];
						}
						
						if(!$person['role']){
							$role = "<role>";
						}
						else{
							$role = $person['role'];
						}
						$peoplearr[] = safeExport($person['name']).",".$email.",".safeExport($role).",".date('M/d/Y', $person['start_date_ts']);
					}
					$companies[$i]['people'] = implode(", ", $peoplearr);
	
					
					$sql = "select * from `company_fundings` where `company_id`=".$this->db->escape($company_id)." order by date_ts desc";
					$q = $this->db->query($sql);
					$company_fundings = $q->result_array();
					foreach($company_fundings as $cfkey=>$cf){	
						$sql = "select * from `company_fundings_ipc` where `company_funding_id`='".$cf['id']."'";
						$q = $this->db->query($sql);
						$company_fundings_ipc = $q->result_array();
						
						$company_fundings[$cfkey]['companies'] = array();
						$company_fundings[$cfkey]['people'] = array();
						$company_fundings[$cfkey]['investment_orgs'] = array();
						
						foreach($company_fundings_ipc as $cfikey=>$cfi){
							if($cfi['type']=='company'){
								$sql = "select `id`, `name` from `companies` where `id`=".$this->db->escape($cfi['ipc_id']);
								$q = $this->db->query($sql);
								$result = $q->result_array();
								$push = array();
								if($result[0]){
									$push['name'] = $result[0]['name'];
									$push['id'] = $result[0]['id'];
								}
								else{
									$push['name'] = $cfi['name'];
									$push['id'] = $cfi['ipc_id'];
								}
								$company_fundings[$cfkey]['companies'][] = $push;
							}
							
							if($cfi['type']=='person'){
								$sql = "select `id`, `name` from `people` where `id`=".$this->db->escape($cfi['ipc_id']);
								$q = $this->db->query($sql);
								$result = $q->result_array();
								$push = array();
								if($result[0]){
									$push['name'] = $result[0]['name'];
									$push['id'] = $result[0]['id'];
								}
								else{
									$push['name'] = $cfi['name'];
									$push['id'] = $cfi['ipc_id'];
								}
								$company_fundings[$cfkey]['people'][] = $push;
							}
							
							if($cfi['type']=='investment_org'){
								$sql = "select `id`, `name` from `investment_orgs` where `id`=".$this->db->escape($cfi['ipc_id']);
								$q = $this->db->query($sql);
								$result = $q->result_array();
								$push = array();
								if($result[0]){
									$push['name'] = $result[0]['name'];
									$push['id'] = $result[0]['id'];
								}
								else{
									$push['name'] = $cfi['name'];
									$push['id'] = $cfi['ipc_id'];
								}
								$company_fundings[$cfkey]['investment_orgs'][] = $push;
							}
						}
					}
					
					$company_fundingsarr = array();
					foreach($company_fundings as $company_funding){
						$str = safeExport($company_funding['round']).",".
						$company_funding['currency'].number_format($company_funding['amount'], 2, ".", "").",".
						date('M/d/Y', $company_funding['date_ts']).",";
						$cfnames = array();
						foreach($company_funding['companies'] as $c){
							$cfnames[] = safeExport($c['name'])."(C)";
						}
						foreach($company_funding['people'] as $c){
							$cfnames[] = safeExport($c['name'])."(P)";
						}
						foreach($company_funding['investment_orgs'] as $c){
							$cfnames[] = safeExport($c['name'])."(I)";
						}
						$str .= implode("/", $cfnames);
						$company_fundingsarr[] = $str;
					}
					$companies[$i]['company_fundings'] = implode(", ", $company_fundingsarr);
				}
				
				$sql = "select `category` from `categories` where `id` in (select `category_id` from `company_category` where `company_id`=".$this->db->escape($company_id).")";
				$q = $this->db->query($sql);
				$co_categories = $q->result_array();
				$arrtemp = array();
				foreach($co_categories as $value){
					$arrtemp[] = safeExport($value['category']);
				}
				$categories = implode(", ", $arrtemp);
				$companies[$i]['categories'] = $categories;
				
				
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
					`ipc_id`=".$this->db->escape($company_id)." and 
					`type`='company'
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
				$companies[$i]['milestones'] = implode(", ", $milestonesarr);
				//echo "<pre>";
				//print_r($milestones);
			}
			$data = array();
			$data['companies'] = $companies;
			$data['format'] = $format;
			$this->load->view('companies/export', $data);
		}
	}
	
	function import($command=""){

		$table = 'companies';
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
				//echo "<pre>";
				//print_r($row);
				//echo "</pre>";
				if($skipped==false&&$_POST['skipheaders']){
					$skipped = true;
					continue;
				}
				if(!trim($row[0])){ //skip if no name
					continue;
				}
				if(trim($row[14])==""){ //active
					$row[14] = "1";
				}
				foreach($row as $key=>$value){
					$row[$key] = trim($value);
				}
				$skipped = true;
				$rowcount++;
				//$data[] = $row;
				$sql =  "select `id`, `name` from `".$table."` where name='".mysql_real_escape_string($row[0])."'";
				$q = $this->db->query($sql);
				$record = $q->result_array();
				if($record[0]){
					if($row[13]!="Live"&&$row[13]!="Closed"){
						$row[13] = "Live";
					}
					if($row[14]!=1&&$row[14]!=0){
						$row[14] = 1;
					}
					$sql = "update `".$table."` set 
					`description` = '".mysql_real_escape_string($row[1])."',
					`email_address` = '".mysql_real_escape_string($row[2])."',
					`website` = '".mysql_real_escape_string($row[3])."',
					`blog_url` = '".mysql_real_escape_string($row[4])."',
					`blog` = '".mysql_real_escape_string($row[5])."',
					`twitter_username` = '".mysql_real_escape_string($row[6])."',
					`facebook` = '".mysql_real_escape_string($row[7])."',
					`linkedin` = '".mysql_real_escape_string($row[8])."',
					`number_of_employees` = '".mysql_real_escape_string($row[9])."',
					`founded` = '".mysql_real_escape_string($row[10])."',
					`country` = '".mysql_real_escape_string($row[11])."',
					`tags` = '".mysql_real_escape_string($row[12])."',
					`status` = '".mysql_real_escape_string($row[13])."',
					`active` = '".mysql_real_escape_string($row[14])."',
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
					echo "[$rowcount] Updated <a href='".site_url().$table."/edit/".$id."'>".$record[0]['name']."</a><br>";
				}
				else{
					if($row[13]!="Live"&&$row[13]!="Closed"){
						$row[13] = "Live";
					}
					if($row[14]!=1&&$row[14]!=0){
						$row[14] = 1;
					}
					$sql = "insert into `".$table."` set 
					`name` = '".mysql_real_escape_string($row[0])."',
					`description` = '".mysql_real_escape_string($row[1])."',
					`email_address` = '".mysql_real_escape_string($row[2])."',
					`website` = '".mysql_real_escape_string($row[3])."',
					`blog_url` = '".mysql_real_escape_string($row[4])."',
					`blog` = '".mysql_real_escape_string($row[5])."',
					`twitter_username` = '".mysql_real_escape_string($row[6])."',
					`facebook` = '".mysql_real_escape_string($row[7])."',
					`linkedin` = '".mysql_real_escape_string($row[8])."',
					`number_of_employees` = '".mysql_real_escape_string($row[9])."',
					`founded` = '".mysql_real_escape_string($row[10])."',
					`country` = '".mysql_real_escape_string($row[11])."',
					`tags` = '".mysql_real_escape_string($row[12])."',
					`status` = '".mysql_real_escape_string($row[13])."',
					`active` = '".mysql_real_escape_string($row[14])."',
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
					echo "[$rowcount] Added <a href='".site_url().$table."/edit/".$id."'>".$row[0]."</a><br>";
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
				if($skipped<2&&$_POST['skipheaders']){
					$skipped++;
					continue;
				}
				if(!trim($row[1])){ //skip if no name
					continue;
				}
				$rowcount++;
				foreach($row as $key=>$value){
					$row[$key] = trim($value);
				}
				$sql =  "select `id`, `name` from `".$table."` where name='".mysql_real_escape_string($row[1])."'";
				$q = $this->db->query($sql);
				$record = $q->result_array();
				if($record[0]){
					if($row[16]!="Live"&&$row[16]!="Closed"){ //status
						$row[16] = "Live";
					}
					if($row[17]!="1"&&$row[17]!="0"){
						$row[17] = "1";
					}
					/*
					Array
					(
						[0] => Headers :
						[1] => Name of Company
						[2] => Description
						[3] => Category
						[4] => Website
						[5] => Blog
						[6] => Twitter
						[7] => Facebook
						[8] => Email address
						[9] => Year Founded
						[10] => Logo
						[11] => Country
						[12] => People
						[13] => Funding
						[14] => Screenshots
						[15] => Competitors
						[16] => Status
						[17] => Active?
					)
					*/
					$blog =  explode(",", $row[5]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "update `".$table."` set 
					`description` = '".mysql_real_escape_string($row[2])."',
					`email_address` = '".mysql_real_escape_string($row[8])."',
					`website` = '".mysql_real_escape_string($row[4])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[6])."',
					`facebook` = '".mysql_real_escape_string($row[7])."',
					`founded` = '".mysql_real_escape_string($row[9])."',
					`country` = '".mysql_real_escape_string($row[11])."',
					`status` = '".mysql_real_escape_string($row[16])."',
					`active` = '".mysql_real_escape_string($row[17])."',
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
					echo "[$rowcount] Updated <a href='".site_url().$table."/edit/".$id."'>".$record[0]['name']."</a><br>";
				}
				else{
					if($row[16]!="Live"&&$row[16]!="Closed"){ //status
						$row[16] = "Live";
					}
					if($row[17]!="1"&&$row[17]!="0"){
						$row[17] = "1";
					}
					$blog =  explode(",", $row[5]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "insert into `".$table."` set 
					`name` = '".mysql_real_escape_string($row[1])."',
					`description` = '".mysql_real_escape_string($row[2])."',
					`email_address` = '".mysql_real_escape_string($row[8])."',
					`website` = '".mysql_real_escape_string($row[4])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[6])."',
					`facebook` = '".mysql_real_escape_string($row[7])."',
					`founded` = '".mysql_real_escape_string($row[9])."',
					`country` = '".mysql_real_escape_string($row[11])."',
					`tags` = '".mysql_real_escape_string($row[1])."',
					`status` = '".mysql_real_escape_string($row[16])."',
					`active` = '".mysql_real_escape_string($row[17])."',
					`dateadded` = NOW(),
					`dateupdated` = NOW()
					";
					$this->db->query($sql);
					$id = $this->db->insert_id();
					$sql = "insert into `logs` set 
						`action` = 'added',
						`table` = '".$table."',
						`ipc_id` = ".$this->db->escape($id).",
						`name` = ".$this->db->escape($row[1]).",
						`user_id` = ".$this->db->escape(trim($_SESSION['user']['id'])).",
						`dateadded_ts` = ".time().",
						`dateadded` = NOW()
					";
					$this->db->query($sql);
					$this->slugify($id);
					echo "[$rowcount] Added <a href='".site_url().$table."/edit/".$id."'>".$row[1]."</a><br>";
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
		$sql = "select `id` as `value`, `name` as `label` from `companies` where LOWER(`name`) like ".$this->db->escape(trim($co_name))." limit 10" ;
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		echo json_encode($companies);
		exit();
	}
	function ajax_check_company(){
		$co_name = $_POST['name'];
		$co_id = $_POST['id'];
		if(strlen($co_name)>0){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($co_name));
			$q = $this->db->query($sql);
			$company = $q->result_array();
			if(!trim($co_id)){
				if($company[0]['id']){
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='Company already exists in the database.' alt='Company already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
					<?php
				}

			}
			else{
				if(trim($company[0]['id'])&&$company[0]['id']!=$co_id){
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='Company already exists in the database.' alt='Company already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
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
		
		//error check
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($_POST['name']));
			//echo $sql;
			$q = $this->db->query($sql);
			$company = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($company[0]['id']!=""&&$company[0]['id']!=$_POST['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Company name already exists in the database.</div>");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Description.</div>");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a valid E-mail.</div>");
			<?php
		}
		else{
			$sql = "select * from `companies` where `id`=".$this->db->escape(trim($_POST['id']));
			$q = $this->db->query($sql);
			$company = $q->result_array();	
			if(!$company[0]){
				$err = 1;
				?>
				alertX("<div class='red'>Company doesnt exists in the database.</div>");
				<?php
			}
		}
		
		
		//save a revision
		if($_SESSION['web_user']&&$_POST['web_edit']&&!$err){
			$sql = "select `id` from `revisions` where 
				`web_user_id`='".$_SESSION['web_user']['id']."' and 
				`table`='companies' and 
				`ipc_id`='".mysql_real_escape_string($_POST['id'])."' and 
				`approved` = 0
				";
			$q = $this->db->query($sql);
			$revision = $q->result_array();
			$revision = $revision[0];
			if($revision['id']){
				$sql = "update `revisions` set 
					`web_user_id`='".$_SESSION['web_user']['id']."',
					`table`='companies',
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
					`table`='companies',
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
			
			setTimeout(function(){ self.location = "<?php echo site_url(); ?>editcompany/<?php echo $_POST['id']; ?>/revisions" }, 2000);
			
			jQuery("#savebutton").val("Submit");
			jQuery("#company_form *").attr("disabled", false);
			<?php
			return false;
		}
		
		
	
		
		
		if(!$err){
			$sql = "update `companies` set ";
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
			if($_POST['founded']){
				$mdy = explode("/", $_POST['founded']);
				$arr[] = "`found_month` = ".$this->db->escape(trim($mdy[0]));
				$arr[] = "`found_day` = ".$this->db->escape(trim($mdy[1]));
				$arr[] = "`found_year` = ".$this->db->escape(trim($mdy[2]));
			}
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext.", `dateupdated`=NOW()";
			$sql .= "where `id`=".$this->db->escape(trim($_POST['id']));
			$q = $this->db->query($sql);
			$id = trim($_POST['id']);
			$this->slugify($id);
			
			$sql = "delete from `company_category` where `company_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['categories'])){
				
				foreach($_POST['categories'] as $value){
					$sql = "insert into `company_category` set `company_id`=".$this->db->escape($id).", `category_id`=".$this->db->escape($value);
					$this->db->query($sql);
				}
			}
			
			$sql = "delete from `screenshots` where `company_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['screenshots'])){
				
				foreach($_POST['screenshots'] as $key=>$value){
					$sql = "insert into `screenshots` set 
					`company_id`=".$this->db->escape($id).", 
					`title`=".$this->db->escape($_POST['screenshot_titles'][$key]).",
					`screenshot`=".$this->db->escape($value);
					$this->db->query($sql);
				}
			}
			
			$sql = "delete from `company_person` where `company_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['p_ids'])){
				foreach($_POST['p_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `company_person` set 
					`company_id`=".$this->db->escape($id).", 
					`person_id`=".$this->db->escape($_POST['p_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}

			$sql = "delete from `competitors` where `company_id`=".$this->db->escape($id);
			$this->db->query($sql);
			$sql = "delete from `competitors` where `competitor_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['competitors'])){
				foreach($_POST['competitors'] as $key=>$value){
					$sql = "insert into `competitors` set 
					`company_id`=".$this->db->escape($id).", 
					`competitor_id`=".$this->db->escape($_POST['competitors'][$key]);
					$this->db->query($sql);
				}
			}
			
			$sql = "delete from `company_fundings_ipc` where `company_funding_id` in (select `id` from `company_fundings` where `company_id`=".$this->db->escape($id).")";
			$this->db->query($sql);
			$sql = "delete from `company_fundings` where `company_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['f_rounds'])){
				foreach($_POST['f_rounds'] as $key=>$value){
					$sql = "insert into `company_fundings` set 
					`round`=".$this->db->escape($value).", 
					`company_id`=".$this->db->escape($id).", 
					`currency`=".$this->db->escape($_POST['f_currencies'][$key]).", 
					`amount`=".$this->db->escape($_POST['f_fund_amounts'][$key]).", 
					`date`=".$this->db->escape($_POST['f_dates'][$key]).",
					`date_ts`=".$this->db->escape(strtotime($_POST['f_dates'][$key]))."
					";
					$this->db->query($sql);
					
					$cfid = $this->db->insert_id();
					$fid = $key;
					
					
					//companies
					if(is_array($_POST['f_companies'.$fid])){
						foreach($_POST['f_companies'.$fid] as $key=>$name){
							$ipc_id = $_POST['f_company_vals'.$fid][$key];
							$sql = "insert into `company_fundings_ipc` set 
							`company_funding_id` = ".$this->db->escape($cfid).",
							`name` = ".$this->db->escape($name).",
							`ipc_id` = ".$this->db->escape($ipc_id).",
							`type` = 'company'
							";
							$this->db->query($sql);
						}
					}
					
					//people
					if(is_array($_POST['f_people'.$fid])){
						foreach($_POST['f_people'.$fid] as $key=>$name){
							$ipc_id = $_POST['f_person_vals'.$fid][$key];
							$sql = "insert into `company_fundings_ipc` set 
							`company_funding_id` = ".$this->db->escape($cfid).",
							`name` = ".$this->db->escape($name).",
							`ipc_id` = ".$this->db->escape($ipc_id).",
							`type` = 'person'
							";
							$this->db->query($sql);
						}
					}
					
					//investment_orgs
					if(is_array($_POST['f_investment_orgs'.$fid])){
						foreach($_POST['f_investment_orgs'.$fid] as $key=>$name){
							$ipc_id = $_POST['f_investment_org_vals'.$fid][$key];
							$sql = "insert into `company_fundings_ipc` set 
							`company_funding_id` = ".$this->db->escape($cfid).",
							`name` = ".$this->db->escape($name).",
							`ipc_id` = ".$this->db->escape($ipc_id).",
							`type` = 'investment_org'
							";
							$this->db->query($sql);
						}
					}
				}
			}
			?>
			alertX("Successfully Updated Company '<?php echo htmlentitiesX($_POST['name']); ?>'.");
			//self.location = "<?php echo site_url(); ?>companies/edit/<?php echo $_POST['id']; ?>"; //refresh
			self.location = self.location; //refresh
			<?php
			$sql = "insert into `logs` set 
				`action` = 'edited',
				`table` = 'companies',
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
		jQuery("#company_form *").attr("disabled", false);
		
		<?php		
		
		
		exit();
	}
	
	
	public function ajax_delete($company_id=""){
		if(!$_SESSION['user']){
			return false;
		}
		if(!$company_id){
			$company_id = $_POST['id'];
		}
		$sql = "select * from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$company = $q->result_array();
		$sql = "delete from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$sql = "delete from `company_category` where `company_id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$sql = "delete from `screenshots` where `company_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		$sql = "delete from `competitors` where `company_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		$sql = "delete from `competitors` where `competitor_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		$sql = "delete from `company_person` where `company_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		$sql = "delete from `company_fundings_ipc` where `type`='company' and `ipc_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		$sql = "delete from `company_fundings` where `company_id`=".$this->db->escape($company_id);
		$this->db->query($sql);
		if(trim($company[0]['name'])){
			?>
			alertX("Successfully deleted <?php echo htmlentitiesX($company[0]['name']); ?>");
			<?php
			$sql = "insert into `logs` set 
				`action` = 'deleted',
				`table` = 'companies',
				`ipc_id` = ".$this->db->escape(trim($_POST['id'])).",
				`name` = ".$this->db->escape(trim($company[0]['name'])).",
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
		exit();
	}
	
	public function ajax_add_company_shortcut_ipc(){
		if(!$_SESSION['user']){
			return false;
		}
		
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$company = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Company already exists in the database.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `companies` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", country='Singapore', active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
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
				`table` = 'companies',
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
	
	public function ajax_add_company_shortcut(){
		if(!$_SESSION['user']){
			return false;
		}
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$company = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Company already exists in the database.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `companies` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", country='Singapore', active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>";
			companyPreAdd(label, value);
			jQuery("#company_add_loader").html("");
			jQuery("#company_search").attr("disabled", false);
			jQuery("#company_search").val("");
			
			<?php
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'companies',
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
			jQuery("#company_add_loader").html("");
			jQuery("#company_search").attr("disabled", false);
			jQuery("#company_search").val("");
			<?php
		}
	}
	
	public function ajax_add_competitor_shortcut(){
		if(!$_SESSION['user']){
			return false;
		}
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$company = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Company already exists in the database.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `companies` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", country='Singapore', active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>";
			addCompetitor(label, value, true);
			jQuery("#competitor_add_loader").html("");
			jQuery("#competitor_search").attr("disabled", false);
			jQuery("#competitor_search").val("");
			<?php
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'companies',
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
			jQuery("#competitor_add_loader").html("");
			jQuery("#competitor_search").attr("disabled", false);
			jQuery("#competitor_search").val("");
			<?php
		}
		
		
		
	}
	public function ajax_add($contributionid=""){
		if(!$_SESSION['user']&&!$_SESSION['web_user']){
			return false;
		}
		//error check
		$err = 0;
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `companies` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$company = $q->result_array();	
		}
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Company already exists in the database.</div>");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Description.</div>");
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
				`table`='companies',
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
		
		
		
		if($contributionid){
			$sql = "update `contributions` set `approved`=1 where `id`='".mysql_real_escape_string($contributionid)."'";
			$q = $this->db->query($sql);
		}
		
		if(!$err){
			$sql = "insert into `companies` set ";
			$arr = array();
			foreach($_POST as $key=>$value){
				if(!is_array($value)&&$key!='sid'){
					$arr[] ="`".$key."`=".$this->db->escape(trim($value));
				}
			}
			if($_POST['founded']){
				$mdy = explode("/", $_POST['founded']);
				$arr[] = "`found_month` = ".$this->db->escape(trim($mdy[0]));
				$arr[] = "`found_day` = ".$this->db->escape(trim($mdy[1]));
				$arr[] = "`found_year` = ".$this->db->escape(trim($mdy[2]));
			}
			
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext.", `dateadded`=NOW(), `dateupdated`=NOW()";
			
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			
			if(is_array($_POST['categories'])){
				$sql = "delete from `company_category` where `company_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['categories'] as $value){
					$sql = "insert into `company_category` set `company_id`=".$this->db->escape($id).", `category_id`=".$this->db->escape($value);
					$this->db->query($sql);
				}
			}
			
			//update logo url
			$logo = $_POST['logo'];
			if($logo){
				$logo = str_replace("temp/".$_POST['sid'], $id, $logo); //replace sid with the company id
				$sql = "update `companies` set `logo`=".$this->db->escape($logo)." where `id`=".$this->db->escape($id);
				$this->db->query($sql);
				//move files
				$from = dirname(__FILE__)."/../../media/uploads/temp/".$_POST['sid']."/logo/".urldecode(basename($logo));
				$folder = dirname(__FILE__)."/../../media/uploads/".$id."/";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$folder = $folder."logo/";
				if(!is_dir($folder)){
					mkdir($folder, 0777);
				}
				$to = $folder.urldecode(basename($logo));
				rename($from, $to);
			}
			
			if(is_array($_POST['screenshots'])){
				foreach($_POST['screenshots'] as $key=>$value){
					$value = str_replace("temp/".$_POST['sid'], $id, $value); //replace sid with the company id
					//move files
					$from = dirname(__FILE__)."/../../media/uploads/temp/".$_POST['sid']."/screenshots/".urldecode(basename($value));
					$folder = dirname(__FILE__)."/../../media/uploads/".$id."/";
					if(!is_dir($folder)){
						mkdir($folder, 0777);
					}
					$folder = $folder."screenshots/";
					if(!is_dir($folder)){
						mkdir($folder, 0777);
					}
					$to = $folder.urldecode(basename($value));
					rename($from, $to);
					
					$sql = "insert into `screenshots` set 
					`company_id`=".$this->db->escape($id).", 
					`title`=".$this->db->escape($_POST['screenshot_titles'][$key]).",
					`screenshot`=".$this->db->escape($value);
					$this->db->query($sql);
				}
			}
			
			if(is_array($_POST['competitors'])){
				$sql = "delete from `competitors` where `company_id`=".$this->db->escape($id);
				$this->db->query($sql);
				$sql = "delete from `competitors` where `competitor_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['competitors'] as $key=>$value){
					$sql = "insert into `competitors` set 
					`company_id`=".$this->db->escape($id).", 
					`competitor_id`=".$this->db->escape($_POST['competitors'][$key]);
					$this->db->query($sql);
				}
			}
					
			if(is_array($_POST['p_ids'])){
				$sql = "delete from `company_person` where `company_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['p_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `company_person` set 
					`company_id`=".$this->db->escape($id).", 
					`person_id`=".$this->db->escape($_POST['p_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}
			
			
			if(is_array($_POST['f_rounds'])){
				$sql = "delete from `company_fundings_ipc` where `company_funding_id` in (select `id` from `company_fundings` where `company_id`=".$this->db->escape($id).")";
				$this->db->query($sql);
				$sql = "delete from `company_fundings` where `company_id`=".$this->db->escape($id);
				$this->db->query($sql);
				if(is_array($_POST['f_rounds'])){
					foreach($_POST['f_rounds'] as $key=>$value){
						$sql = "insert into `company_fundings` set 
						`round`=".$this->db->escape($value).", 
						`company_id`=".$this->db->escape($id).", 
						`currency`=".$this->db->escape($_POST['f_currencies'][$key]).", 
						`amount`=".$this->db->escape($_POST['f_fund_amounts'][$key]).", 
						`date`=".$this->db->escape($_POST['f_dates'][$key]).",
						`date_ts`=".$this->db->escape(strtotime($_POST['f_dates'][$key]))."
						";
						$this->db->query($sql);
						
						$cfid = $this->db->insert_id();
						$fid = $key;
						
						
						//companies
						if(is_array($_POST['f_companies'.$fid])){
							foreach($_POST['f_companies'.$fid] as $key=>$name){
								$ipc_id = $_POST['f_company_vals'.$fid][$key];
								$sql = "insert into `company_fundings_ipc` set 
								`company_funding_id` = ".$this->db->escape($cfid).",
								`name` = ".$this->db->escape($name).",
								`ipc_id` = ".$this->db->escape($ipc_id).",
								`type` = 'company'
								";
								$this->db->query($sql);
							}
						}
						
						//people
						if(is_array($_POST['f_people'.$fid])){
							foreach($_POST['f_people'.$fid] as $key=>$name){
								$ipc_id = $_POST['f_person_vals'.$fid][$key];
								$sql = "insert into `company_fundings_ipc` set 
								`company_funding_id` = ".$this->db->escape($cfid).",
								`name` = ".$this->db->escape($name).",
								`ipc_id` = ".$this->db->escape($ipc_id).",
								`type` = 'person'
								";
								$this->db->query($sql);
							}
						}
						
						//investment_orgs
						if(is_array($_POST['f_investment_orgs'.$fid])){
							foreach($_POST['f_investment_orgs'.$fid] as $key=>$name){
								$ipc_id = $_POST['f_investment_org_vals'.$fid][$key];
								$sql = "insert into `company_fundings_ipc` set 
								`company_funding_id` = ".$this->db->escape($cfid).",
								`name` = ".$this->db->escape($name).",
								`ipc_id` = ".$this->db->escape($ipc_id).",
								`type` = 'investment_org'
								";
								$this->db->query($sql);
							}
						}
					}
				}
			}

			if($_POST['sid']){
				$dir = dirname(__FILE__)."/../../media/uploads/temp/".$_POST['sid'];
				SureRemoveDir($dir, "true");
			}
			
			if($contributionid){
				$sql = "update `contributions` set `ipc_id`='".$id."', `approved`=1 where `id`='".mysql_real_escape_string($contributionid)."'";
				$q = $this->db->query($sql);
			}
			
			?>
			alertX("Successfully Added Company '<?php echo htmlentitiesX($_POST['name']); ?>'.");
			//self.location = "<?php echo site_url(); ?>companies/edit/<?php echo $id; ?>";
			<?php
			if($contributionid){
				?>
				self.location = "<?php echo site_url(); ?>contributions";
				<?php
			}
			else{
				?>
				self.location = "<?php echo site_url(); ?>companies/add";
				<?php
			}
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'companies',
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
		jQuery("#company_form *").attr("disabled", false);
		<?php	
		exit();
	}
	
	function add(){
		$data = array();
		$sql = "select * from `categories`";
		$q = $this->db->query($sql);
		$categories = $q->result_array();	
		$data['categories'] = $categories;
		$sql = "select * from `countries`";
		$q = $this->db->query($sql);
		$countries = $q->result_array();	
		$sql = "select distinct `code`, `currency` from `currencies` where LOWER(`currency`) not like 'uses%'";
		$q = $this->db->query($sql);
		$currencies = $q->result_array();	
		$sql = "select * from `funding_rounds`";
		$q = $this->db->query($sql);
		$funding_rounds = $q->result_array();	
		$data['funding_rounds'] = $funding_rounds;
		$data['currencies'] = $currencies;
		$data['countries'] = $countries;
		$data['content'] = $this->load->view('companies/add', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	function edit($company_id, $return=false){
		$sql = "select * from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$company = $q->result_array();	
		if($company[0]['id']){
			$data = array();
			$time = time();
			
			$sql = "select * from `categories`";
			$q = $this->db->query($sql);
			$categories = $q->result_array();	
			$data['categories'] = $categories;
			$sql = "select * from `countries`";
			$q = $this->db->query($sql);
			$countries = $q->result_array();
			
			$sql = "select * from `company_category` where `company_id`=".$this->db->escape($company_id);
			$q = $this->db->query($sql);
			$co_categories = $q->result_array();
			$arrtemp = array();
			foreach($co_categories as $value){
				$arrtemp[] = $value['category_id'];
			}
			$co_categories = $arrtemp;
			
			$sql = "select * from `screenshots` where `company_id`=".$this->db->escape($company_id)." order by id asc";
			$q = $this->db->query($sql);
			$screenshots = $q->result_array();

			$sql = "select `b`.`id` as `value`, `b`.`name` as `label` from `competitors` as `a`, `companies` as `b` where 
				(
					`a`.`company_id`=".$this->db->escape($company_id)." 
					and `a`.`competitor_id` = `b`.`id`
				)
				or
				(
					`a`.`competitor_id`=".$this->db->escape($company_id)." 
					and `a`.`company_id` = `b`.`id`
				)
				order by `b`.`name` asc
			";
			$q = $this->db->query($sql);
			$competitors = $q->result_array();
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`name` as `name` from `company_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
			where `company_id`=".$this->db->escape($company_id)." and `name`<>'' 
			order by `name` asc, `end_date_ts2` desc, `start_date_ts` desc";
			$q = $this->db->query($sql);
			$people = $q->result_array();
			$sql = "select distinct `code`, `currency` from `currencies` where LOWER(`currency`) not like 'uses%'";
			$q = $this->db->query($sql);
			$currencies = $q->result_array();
			$sql = "select * from `funding_rounds`";
			$q = $this->db->query($sql);
			$funding_rounds = $q->result_array();	
			
			$sql = "select * from `company_fundings` where `company_id`=".$this->db->escape($company_id)." order by date_ts desc";
			$q = $this->db->query($sql);
			$company_fundings = $q->result_array();
			foreach($company_fundings as $cfkey=>$cf){
					
				$sql = "select * from `company_fundings_ipc` where `company_funding_id`='".$cf['id']."'";
				$q = $this->db->query($sql);
				$company_fundings_ipc = $q->result_array();
				
				$company_fundings[$cfkey]['companies'] = array();
				$company_fundings[$cfkey]['people'] = array();
				$company_fundings[$cfkey]['investment_orgs'] = array();
				
				foreach($company_fundings_ipc as $cfikey=>$cfi){
					if($cfi['type']=='company'){
						$sql = "select `id`, `name` from `companies` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['id'] = $result[0]['id'];
						}
						else{
							$push['name'] = $cfi['name'];
							$push['id'] = $cfi['ipc_id'];
						}
						$company_fundings[$cfkey]['companies'][] = $push;
					}
					
					if($cfi['type']=='person'){
						$sql = "select `id`, `name` from `people` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['id'] = $result[0]['id'];
						}
						else{
							$push['name'] = $cfi['name'];
							$push['id'] = $cfi['ipc_id'];
						}
						$company_fundings[$cfkey]['people'][] = $push;
					}
					
					if($cfi['type']=='investment_org'){
						$sql = "select `id`, `name` from `investment_orgs` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['id'] = $result[0]['id'];
						}
						else{
							$push['name'] = $cfi['name'];
							$push['id'] = $cfi['ipc_id'];
						}
						$company_fundings[$cfkey]['investment_orgs'][] = $push;
					}
				}
			}
			
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
				`ipc_id`=".$this->db->escape($company_id)." and 
				`type`='company'
				)
			order by `date_ts` desc, `company_name` asc
			";
			$q = $this->db->query($sql);
			$milestones = $q->result_array();
			$data['milestones'] = $milestones;
			$data['company_fundings'] = $company_fundings;	
			$data['funding_rounds'] = $funding_rounds;				
			$data['currencies'] = $currencies;
			$data['people'] = $people;
			$data['competitors'] = $competitors;
			$data['screenshots'] = $screenshots;	
			$data['co_categories'] = $co_categories;	
			$data['countries'] = $countries;
			$data['company'] = $company[0];
			if($return){
				return $data;
			}
			
			$data['content'] = $this->load->view('companies/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			redirect_to(site_url()."companies");
		}
	}
	
	public function revision($id=""){
		$changed = array();
		$data = array();
		$sql = "select `revisions`.* from `revisions` where `revisions`.`id`='".mysql_real_escape_string($id)."' and `revisions`.`table`='companies' ";
		$q = $this->db->query($sql);
		$revision = $q->result_array();
		$revision = $revision[0];
		
		if($revision['id']){
			$company_id = $revision['ipc_id'];
			$company = json_decode($revision['json_data']);
			$company = objectToArray($company);
			$sql = "select * from `companies` where `id`=".$this->db->escape($company_id);
			$q = $this->db->query($sql);
			$companytemp = $q->result_array();	
			
			$sql = "select * from `web_users` where `id`=".$this->db->escape($revision['web_user_id']);
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			$web_user = getWebUser($web_user);
			$data['web_user'] =  $web_user;
		}
		
		if($companytemp[0]['id']&&$web_user){
			$corig = $this->edit($companytemp[0]['id'], true); //get original data
			
			$data['companyorig'] = $companytemp[0];
			$data['revision'] = $revision;
			
			
			$categories = $corig['categories'];
			$funding_rounds = $corig['funding_rounds'];
			$currencies = $corig['currencies'];
			$countries = $corig['countries'];
			$milestones = $corig['milestones'];
			$competitors = $corig['competitors'];
			
			$data['categories'] = $categories;
			$data['funding_rounds'] = $funding_rounds;				
			$data['currencies'] = $currencies;
			$data['countries'] = $countries;
			$data['milestones'] = $milestones;
			$data['competitors'] = $competitors;
			if(arrDiff($corig['competitors'], $data['competitors'])){
				$changed[] = 'competitors';
			}
			
			
			
			$company_fundings = array();
			if(is_array($company['f_rounds'])){
				foreach($company['f_rounds'] as $key=>$value){
					$company_funding = array();
					$company_funding['round'] = $value;
					$company_funding['company_id'] = $company_id;
					$company_funding['currency'] = $company['f_currencies'][$key];
					$company_funding['amount'] = number_format($company['f_amounts'][$key], "4", ".", "").""; //must format amount
					$company_funding['date'] = $company['f_dates'][$key];
					$company_funding['date_ts'] = strtotime($company['f_dates'][$key]).""; //stringify the thing
					$company_funding['companies'] = array();
					if(is_array($company['f_companies'.$key])){
						foreach($company['f_companies'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_company_vals'.$key][$k];
							$company_funding['companies'][] = $c;
						}
					}
					$company_funding['people'] = array();
					if(is_array($company['f_people'.$key])){
						foreach($company['f_people'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_person_vals'.$key][$k];
							$company_funding['people'][] = $c;
						}
					}
					$company_funding['investment_orgs'] = array();
					if(is_array($company['f_investment_orgs'.$key])){
						foreach($company['f_investment_orgs'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_investment_org_vals'.$key][$k];
							$company_funding['investment_orgs'][] = $c;
						}
					}
					$company_fundings[] = $company_funding;
				}
			}
			$data['company_fundings'] = $company_fundings;	
			//check if there are changes 
			//remove ids 
			foreach($corig['company_fundings'] as $key=>$value){
				unset($corig['company_fundings'][$key]['id']);
			}
			if(arrDiff($corig['company_fundings'], $data['company_fundings'])){
				$changed[] = 'company_fundings';
			}

			$people = array();
			if(is_array($company['p_ids'])){
				foreach($company['p_ids'] as $key=>$value){
					$sql = "select * from `people` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$p = $q->result_array();
					$p = $p[0];
					$person = array();
					$person['company_id'] = $company_id;
					$person['person_id'] = $value;
					$person['role'] = $company['p_roles'][$key];;
					$person['start_date'] = $company['p_start_dates'][$key];
					$person['start_date_ts'] = strtotime($company['p_start_dates'][$key])."";
					$person['end_date'] = $company['p_end_dates'][$key];
					$person['end_date_ts'] = (strtotime($company['p_end_dates'][$key])+0)."";
					$person['name'] = $p['name'];
					//$person['slug'] = $p['slug'];
					$people[] = $person;
				}
			}
			
			$data['people'] = $people;
			//remove ids and edn_date_ts2
			foreach($corig['people'] as $key=>$value){
				unset($corig['people'][$key]['id']);
				unset($corig['people'][$key]['end_date_ts2']);
			}
			if(arrDiff($data['people'], $corig['people'])){
				$changed[] = "people";
			}
			
			$screenshots = array();
			if(is_array($company['screenshots'])){
				foreach($company['screenshots'] as $key=>$value){
					$screenshot = array();
					$screenshot['company_id'] = $company_id;
					$screenshot['screenshot'] = $value;
					$screenshot['title'] = $company['screenshot_titles'][$key];
					$screenshots[] = $screenshot;
				}
			}
			$data['screenshots'] = $screenshots;	
			//remove ids 
			foreach($corig['screenshots'] as $key=>$value){
				unset($corig['screenshots'][$key]['id']);
			}
			if(arrDiff($data['screenshots'], $corig['screenshots'])){
				$changed[] = 'screenshots';
			}
			
			$co_categories = $company['categories'];
			$data['co_categories'] = $co_categories;	
			if(is_array($data['co_categories'])&&is_array($corig['co_categories'])){
				sort($data['co_categories']);
				sort($corig['co_categories']);
				if(arrDiff($data['co_categories'], $corig['co_categories'])){
					$changed[] = 'co_categories';
				}
			}

			//remove arrays
			$unsets = array();
			foreach($company as $key=>$value){
				if(is_array($value)){
					$unsets[] = $key;
				}
				else{
					if(trim($value)!=trim($corig['company'][$key])){
						$changed[] = $key;
					}
				}
			}
			foreach($unsets as $key){
				unset($company[$key]);
			}
			$data['company'] = $company;
			$data['changed'] = $changed;
			$data['content'] = $this->load->view('companies/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		
	}
	
	public function contribution($id=""){
		$data = array();
		$sql = "select `contributions`.* from `contributions` where `contributions`.`id`='".mysql_real_escape_string($id)."' and `contributions`.`table`='companies' ";
		$q = $this->db->query($sql);
		$contribution = $q->result_array();
		$contribution = $contribution[0];
		
		if($contribution['id']){
			$company = json_decode($contribution['json_data']);
			$company = objectToArray($company);
			
			$sql = "select * from `web_users` where `id`=".$this->db->escape($contribution['web_user_id']);
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			$web_user = getWebUser($web_user);
			$data['web_user'] =  $web_user;
		}
	
		if($web_user){
			$data['contribution'] = $contribution;
			$sql = "select * from `categories`";
			$q = $this->db->query($sql);
			$categories = $q->result_array();	
			$data['categories'] = $categories;
			$sql = "select * from `countries`";
			$q = $this->db->query($sql);
			$countries = $q->result_array();
			$sql = "select distinct `code`, `currency` from `currencies` where LOWER(`currency`) not like 'uses%'";
			$q = $this->db->query($sql);
			$currencies = $q->result_array();
			$sql = "select * from `funding_rounds`";
			$q = $this->db->query($sql);
			$funding_rounds = $q->result_array();
			/*
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
					`ipc_id`=".$this->db->escape($company_id)." and 
					`type`='company'
					)
				order by `date_ts` desc, `company_name` asc
				";
			$q = $this->db->query($sql);
			$milestones = $q->result_array();
			
			$sql = "select `b`.`id` as `value`, `b`.`name` as `label` from `competitors` as `a`, `companies` as `b` where 
				(
					`a`.`company_id`=".$this->db->escape($company_id)." 
					and `a`.`competitor_id` = `b`.`id`
				)
				or
				(
					`a`.`competitor_id`=".$this->db->escape($company_id)." 
					and `a`.`company_id` = `b`.`id`
				)
				order by `b`.`name` asc
			";
			$q = $this->db->query($sql);
			$competitors = $q->result_array();
			*/
			$data['funding_rounds'] = $funding_rounds;				
			$data['currencies'] = $currencies;
			$data['countries'] = $countries;
			$data['milestones'] = $milestones;
			$data['competitors'] = $competitors;
			
			
			
			$company_fundings = array();
			if(is_array($company['f_rounds'])){
				foreach($company['f_rounds'] as $key=>$value){
					$company_funding = array();
					$company_funding['round'] = $value;
					$company_funding['company_id'] = $company_id;
					$company_funding['currency'] = $company['f_currencies'][$key];
					$company_funding['amount'] = $company['f_currencies'][$key];
					$company_funding['date'] = $company['f_dates'][$key];
					$company_funding['date_ts'] = strtotime($company['f_dates'][$key]);
					$company_funding['companies'] = array();
					if(is_array($company['f_companies'.$key])){
						foreach($company['f_companies'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_company_vals'.$key][$k];
							$company_funding['companies'][] = $c;
						}
					}
					$company_funding['people'] = array();
					if(is_array($company['f_people'.$key])){
						foreach($company['f_people'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_person_vals'.$key][$k];
							$company_funding['people'][] = $c;
						}
					}
					$company_funding['investment_orgs'] = array();
					if(is_array($company['f_investment_orgs'.$key])){
						foreach($company['f_investment_orgs'.$key] as $k=>$v){
							$c = array();
							$c['name'] = $v;
							//$c['slug'] = 
							$c['id'] = $company['f_investment_org_vals'.$key][$k];
							$company_funding['investment_orgs'][] = $c;
						}
					}
					$company_fundings[] = $company_funding;
				}
			}
			$data['company_fundings'] = $company_fundings;	
			$people = array();
			if(is_array($company['p_ids'])){
				foreach($company['p_ids'] as $key=>$value){
					$sql = "select * from `people` where `id`='".mysql_real_escape_string($value)."'";
					$q = $this->db->query($sql);
					$p = $q->result_array();
					$p = $p[0];
					$person = array();
					$person['company_id'] = $company_id;
					$person['person_id'] = $value;
					$person['role'] = $company['p_roles'][$key];;
					$person['start_date'] = $company['p_start_dates'][$key];
					$person['start_date_ts'] = strtotime($company['p_start_dates'][$key]);
					$person['end_date'] = $company['p_end_dates'][$key];
					$person['end_date_ts'] = strtotime($company['p_end_dates'][$key]);
					$person['name'] = $p['name'];
					$person['slug'] = $p['slug'];
					$people[] = $person;
				}
			}
			$data['people'] = $people;
			$screenshots = array();
			if(is_array($company['screenshots'])){
				foreach($company['screenshots'] as $key=>$value){
					$screenshot = array();
					$screenshot['company_id'] = $company_id;
					$screenshot['screenshot'] = $value;
					$screenshot['title'] = $company['screenshot_titles'][$key];
					$screenshots[] = $screenshot;
				}
			}
			$data['screenshots'] = $screenshots;	
			$co_categories = $company['categories'];
			$data['co_categories'] = $co_categories;	

			//remove arrays
			$unsets = array();
			foreach($company as $key=>$value){
				if(is_array($value)){
					$unsets[] = $key;
				}
			}
			foreach($unsets as $key){
				unset($company[$key]);
			}
			$data['company'] = $company;
			$data['content'] = $this->load->view('companies/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		
	}
	
	private function slugify($id){
		$table = "companies";
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
