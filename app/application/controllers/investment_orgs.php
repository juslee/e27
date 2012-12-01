<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class investment_orgs extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		
		$sql = "select * from `investment_orgs` where 1 order by `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$investment_orgs = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `investment_orgs` where 1 order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['investment_orgs'] = $investment_orgs;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('investment_orgs/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$filter = $_GET['filter'];
		$start += 0;
		$limit = 50;
		$search = strtolower(trim($_GET['search']));
		$searchx = trim($_GET['search']);
		
		$sql = "select * from `investment_orgs` where ";
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
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= " LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$investment_orgs = $q->result_array();
		
		$sql = "select count(`id`) as `cnt` from `investment_orgs` where ";
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
				LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= " LOWER(`".$filter."`) like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc " ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['investment_orgs'] = $investment_orgs;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $searchx;
		$data['filter'] = $filter;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('investment_orgs/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function export($md5, $format="html"){
		$sql = $_SESSION['export_sqls'][$md5];
		if($sql){
			$q = $this->db->query($sql);
			$investment_orgs = $q->result_array();
			//print_r($people);
			$t = count($investment_orgs);
			for($i=0; $i<$t; $i++){
				$investment_org_id = $investment_orgs[$i]['id'];
				$time = time();
				
				$sql = "select 
				`a`.*, 
				if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
				`b`.`name` as `name` from `investment_org_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
				where `investment_org_id`=".$this->db->escape($investment_org_id)." and `name`<>'' 
				order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
				$q = $this->db->query($sql);
				$people = $q->result_array();
				$peoplearr = array();
				foreach($people as $person){
					$peoplearr[] = $person['name'].",".$person['role'].",".date('Y', $person['start_date_ts']);
				}
				$investment_orgs[$i]['people'] = implode(", ", $peoplearr);
				
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
					`ipc_id`=".$this->db->escape($investment_org_id)." and 
					`type`='investment_org'
					)
				order by `date_ts` desc	
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
				$investment_orgs[$i]['milestones'] = implode(", ", $milestonesarr);
				
			}
			$data = array();
			$data['investment_orgs'] = $investment_orgs;
			$data['format'] = $format;
			$this->load->view('investment_orgs/export', $data);
		}
	}
	
	function import($command=""){
		$table = 'investment_orgs';
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
				$data[] = $row;
				$sql =  "select `id`, `name` from `".$table."` where name='".$row[0]."'";
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
					`active` = '".mysql_real_escape_string($row[14])."'
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
					`active` = '".mysql_real_escape_string($row[14])."'
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
				//echo "<pre>";
				//print_r($row);
				//exit();			
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
					if($row[12]!="Live"&&$row[12]!="Closed"){ //status
						$row[12] = "Live";
					}
					if($row[13]!="1"&&$row[13]!="0"){ //active
						$row[13] = "1";
					}
					/*
					Array
					(
						[0] => Headers :
						[1] => Name of Investment Organizations
						[2] => Description
						[3] => Website
						[4] => Blog
						[5] => Twitter
						[6] => Facebook
						[7] => Email address
						[8] => Year Founded
						[9] => Logo
						[10] => Country 
						[11] => People
						[12] => Status
						[13] => Active?
					)
					*/
					$blog =  explode(",", $row[4]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "update `".$table."` set 
					`description` = '".mysql_real_escape_string($row[2])."',
					`email_address` = '".mysql_real_escape_string($row[7])."',
					`website` = '".mysql_real_escape_string($row[3])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[5])."',
					`facebook` = '".mysql_real_escape_string($row[6])."',
					`founded` = '".mysql_real_escape_string($row[8])."',
					`country` = '".mysql_real_escape_string($row[10])."',
					`status` = '".mysql_real_escape_string($row[12])."',
					`active` = '".mysql_real_escape_string($row[13])."'
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
					if($row[12]!="Live"&&$row[12]!="Closed"){ //status
						$row[12] = "Live";
					}
					if($row[13]!="1"&&$row[13]!="0"){ //active
						$row[13] = "1";
					}
					$blog =  explode(",", $row[4]);
					$blog_url = trim($blog[0]);
					$blogfeed_url = trim($blog[1]);
					
					$sql = "insert into `".$table."` set 
					`name` = '".mysql_real_escape_string($row[1])."',
					`description` = '".mysql_real_escape_string($row[2])."',
					`email_address` = '".mysql_real_escape_string($row[7])."',
					`website` = '".mysql_real_escape_string($row[3])."',
					`blog_url` = '".mysql_real_escape_string($blog_url)."',
					`blog` = '".mysql_real_escape_string($blogfeed_url)."',
					`twitter_username` = '".mysql_real_escape_string($row[5])."',
					`facebook` = '".mysql_real_escape_string($row[6])."',
					`founded` = '".mysql_real_escape_string($row[8])."',
					`country` = '".mysql_real_escape_string($row[10])."',
					`status` = '".mysql_real_escape_string($row[12])."',
					`active` = '".mysql_real_escape_string($row[13])."'
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
		$sql = "select `id` as `value`, `name` as `label` from `investment_orgs` where LOWER(`name`) like ".$this->db->escape(trim($co_name))." limit 10" ;;
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		echo json_encode($companies);
		exit();
	}
	function ajax_check_investment_org(){
		$io_name = $_POST['name'];
		$io_id = $_POST['id'];
		if(strlen($io_name)>0){
			//check if company already exists
			$sql = "select `id` from `investment_orgs` where `name`=".$this->db->escape(trim($io_name));
			$q = $this->db->query($sql);
			$investment_org = $q->result_array();
			if(!trim($io_id)){
				if($investment_org[0]['id']){
					?>
					jQuery("#io_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='Investment organization already exists in the database.' alt='Investment organization already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#io_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
					<?php
				}

			}
			else{
				if(trim($investment_org[0]['id'])&&$investment_org[0]['id']!=$io_id){
					?>
					jQuery("#io_check").html("<img src='<?php echo site_url(); ?>media/x.png' title='Company already exists in the database.' alt='Company already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#io_check").html("<img src='<?php echo site_url(); ?>media/check.png' />");
					<?php
				}
			}
		}
	}
	public function ajax_edit(){
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `investment_orgs` where `name`=".$this->db->escape(trim($_POST['name']));
			//echo $sql;
			$q = $this->db->query($sql);
			$investment_org = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Company Name.</div>");
			<?php
		}
		else if($investment_org[0]['id']!=""&&$investment_org[0]['id']!=$_POST['id']){
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
			$sql = "select * from `investment_orgs` where `id`=".$this->db->escape(trim($_POST['id']));
			$q = $this->db->query($sql);
			$investment_orgs = $q->result_array();	
			if(!$investment_orgs[0]){
				$err = 1;
				?>
				alertX("<div class='red'>Investment Organization doesnt exists in the database.</div>");
				<?php
			}
		}

		
		if(!$err){
			$sql = "update `investment_orgs` set ";
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
			
			$sql = "delete from `investment_org_person` where `investment_org_id`=".$this->db->escape($id);
			$this->db->query($sql);
			if(is_array($_POST['p_ids'])){
				foreach($_POST['p_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `investment_org_person` set 
					`investment_org_id`=".$this->db->escape($id).", 
					`person_id`=".$this->db->escape($_POST['p_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}

			?>
			alertX("Successfully Updated Investment Organization '<?php echo htmlentities($_POST['name']); ?>'.");
			self.location = self.location; //refresh
			<?php
			$sql = "insert into `logs` set 
				`action` = 'edited',
				`table` = 'investment_orgs',
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
		jQuery("#investment_org_form *").attr("disabled", false);
		<?php		
		
		exit();
	}
	
	public function ajax_delete($investment_org_id=""){
		if(!$investment_org_id){
			$investment_org_id = $_POST['id'];
		}
		$sql = "select * from `investment_orgs` where `id`=".$this->db->escape($investment_org_id);
		$q = $this->db->query($sql);
		$investment_org = $q->result_array();
		$sql = "delete from `investment_orgs` where `id`=".$this->db->escape($investment_org_id);
		$q = $this->db->query($sql);
		$sql = "delete from `investment_org_person` where `investment_org_id`=".$this->db->escape($investment_org_id);
		$this->db->query($sql);
		$sql = "delete from `company_fundings_ipc` where `type`='investment_org' and `ipc_id`=".$this->db->escape($investment_org_id);
		$this->db->query($sql);
		if(trim($investment_org[0]['name'])){
			?>
			alertX("Successfully deleted <?php echo htmlentities($investment_org[0]['name']); ?>");
			<?php
			
			$sql = "insert into `logs` set 
				`action` = 'deleted',
				`table` = 'investment_orgs',
				`ipc_id` = ".$this->db->escape(trim($_POST['id'])).",
				`name` = ".$this->db->escape(trim($investment_org[0]['name'])).",
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
	
	public function ajax_add_investment_org_shortcut_ipc(){	
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `investment_orgs` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$investment_org = $q->result_array();	
		}
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		else if($investment_org[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Investment Organization already exists in the database.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `investment_orgs` set `name`=".$this->db->escape(trim($_POST['name']));
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
				`table` = 'investment_orgs',
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
	
	public function ajax_add_investment_org_shortcut(){
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `investment_orgs` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$investment_org = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Investment Organization Name.</div>");
			<?php
		}
		else if($investment_org[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Investment Organization already exists in the database.</div>");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `investment_orgs` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", country='Singapore', active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			$this->slugify($id);
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>";
			investmentOrgPreAdd(label, value);
			jQuery("#investment_org_add_loader").html("");
			jQuery("#investment_org_search").attr("disabled", false);
			jQuery("#investment_org_search").val("");
			
			<?php
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'investment_orgs',
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
			jQuery("#investment_org_add_loader").html("");
			jQuery("#investment_org_search").attr("disabled", false);
			jQuery("#investment_org_search").val("");
			<?php
		}
		
		
	}
	
	public function ajax_add(){
		if(trim($_POST['name'])){
			//check if company already exists
			$sql = "select `id` from `investment_orgs` where `name`=".$this->db->escape(trim($_POST['name']));
			$q = $this->db->query($sql);
			$investment_org = $q->result_array();	
		}
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Name.</div>");
			<?php
		}
		else if($investment_org[0]['id']){
			$err = 1;
			?>
			alertX("<div class='red'>Investment organization already exists in the database.</div>");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a Investment organization description.</div>");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("<div class='red'>Please input a valid E-mail.</div>");
			<?php
		}
		if(!$err){
			$sql = "insert into `investment_orgs` set ";
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
			//update logo url
			$logo = $_POST['logo'];
			if($logo){
				$logo = str_replace("temp/".$_POST['sid'], $id, $logo); //replace sid with the company id
				$sql = "update `investment_orgs` set `logo`=".$this->db->escape($logo)." where `id`=".$this->db->escape($id);
				$this->db->query($sql);
				//move files
				$from = dirname(__FILE__)."/../../media/uploads/investment_orgs/temp/".$_POST['sid']."/logo/".urldecode(basename($logo));
				$folder = dirname(__FILE__)."/../../media/uploads/investment_orgs/".$id."/";
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
					
			if(is_array($_POST['p_ids'])){
				$sql = "delete from `investment_org_person` where `investment_org_id`=".$this->db->escape($id);
				$this->db->query($sql);
				foreach($_POST['p_ids'] as $key=>$value){
					$start_date_ts = strtotime($_POST['p_start_dates'][$key]);
					$end_date_ts = 0;
					if($_POST['p_end_dates'][$key]){
						$end_date_ts = strtotime($_POST['p_end_dates'][$key]);
					}
					$sql = "insert into `investment_org_person` set 
					`investment_org_id`=".$this->db->escape($id).", 
					`person_id`=".$this->db->escape($_POST['p_ids'][$key]).",
					`role`=".$this->db->escape($_POST['p_roles'][$key]).",
					`start_date`=".$this->db->escape($_POST['p_start_dates'][$key]).",
					`start_date_ts`=".$this->db->escape($start_date_ts).",
					`end_date`=".$this->db->escape($_POST['p_end_dates'][$key]).",
					`end_date_ts`=".$this->db->escape($end_date_ts);
					$this->db->query($sql);
				}
			}

			if($_POST['sid']){
				$dir = dirname(__FILE__)."/../../media/uploads/investment_orgs/temp/".$_POST['sid'];
				SureRemoveDir($dir, "true");
			}
			
			?>
			alertX("Successfully Added Investment Organization '<?php echo htmlentities($_POST['name']); ?>'.");
			//self.location = "<?php echo site_url(); ?>investment_orgs/edit/<?php echo $id; ?>";
			self.location = "<?php echo site_url(); ?>investment_orgs/add";
			<?php
		
			$sql = "insert into `logs` set 
				`action` = 'added',
				`table` = 'investment_orgs',
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
		jQuery("#investment_org_form *").attr("disabled", false);
		<?php
		
		exit();
	}
	
	function add(){
		$data = array();
		$sql = "select * from `countries`";
		$q = $this->db->query($sql);
		$countries = $q->result_array();	
		$data['countries'] = $countries;
		$data['content'] = $this->load->view('investment_orgs/add', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	function edit($investment_org_id){
		$sql = "select * from `investment_orgs` where `id`=".$this->db->escape($investment_org_id);
		$q = $this->db->query($sql);
		$investment_org = $q->result_array();	
		if($investment_org[0]['id']){
			$data = array();
			$time = time();
			$sql = "select * from `countries`";
			$q = $this->db->query($sql);
			$countries = $q->result_array();
			
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`name` as `name` from `investment_org_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
			where `investment_org_id`=".$this->db->escape($investment_org_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			$q = $this->db->query($sql);
			$people = $q->result_array();
			
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
				`ipc_id`=".$this->db->escape($investment_org_id)." and 
				`type`='investment_org'
				)
			order by `date_ts` desc	
			";
			$q = $this->db->query($sql);
			$milestones = $q->result_array();
			$data['milestones'] = $milestones;
			$data['people'] = $people;
			$data['countries'] = $countries;
			$data['investment_org'] = $investment_org[0];
			$data['content'] = $this->load->view('investment_orgs/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			redirect_to(site_url()."investment_orgs");
		}
	}
	
	private function slugify($id){
		$table = "investment_orgs";
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
