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
		$search = trim($_GET['search']);
		
		$sql = "select * from `people` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				`name` like '%".mysql_real_escape_string($search)."%' or
				`email_address` like '%".mysql_real_escape_string($search)."%' or
				`twitter_username` like '%".mysql_real_escape_string($search)."%' or
				`blog_url` like '%".mysql_real_escape_string($search)."%' or 
				`facebook` like '%".mysql_real_escape_string($search)."%' or 
				`linkedin` like '%".mysql_real_escape_string($search)."%' or 
				`description` like '%".mysql_real_escape_string($search)."%' or 
				`tags` like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "`".$filter."` like '%".mysql_real_escape_string($search)."%'";
		}
		$sql .= "order by `name` asc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$people = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `people` where ";
		if($filter=='all' || !trim($filter)){
			$sql .= "
				`name` like '%".mysql_real_escape_string($search)."%' or
				`email_address` like '%".mysql_real_escape_string($search)."%' or
				`twitter_username` like '%".mysql_real_escape_string($search)."%' or
				`blog_url` like '%".mysql_real_escape_string($search)."%' or 
				`facebook` like '%".mysql_real_escape_string($search)."%' or 
				`linkedin` like '%".mysql_real_escape_string($search)."%' or 
				`description` like '%".mysql_real_escape_string($search)."%' or 
				`tags` like '%".mysql_real_escape_string($search)."%'
			";
		}
		else{
			$sql .= "`".$filter."` like '%".mysql_real_escape_string($search)."%'";
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
		$data['search'] = $search;
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
				if(!trim($row[2])){ //skip if no email
					continue;
				}
				$skipped = true;
				$rowcount++;
				$data[] = $row;
				$sql =  "select `id`, `name`, `email_address` from `".$table."` where `email_address`='".$row[2]."'"; //email address is the unique field
				$q = $this->db->query($sql);
				$record = $q->result_array();
				if($record[0]){
					//if($row[9]!="Live"&&$row[9]!="Closed"){
					//	$row[9] = "Live";
					//}
					if($row[9]!=1&&$row[9]!=0){
						$row[9] = 1;
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
					`active` = '".mysql_real_escape_string($row[9])."'
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
					echo "[$rowcount] Updated <a href='".site_url().$table."/edit/".$id."'>".$record[0]['email_address']." (".$row[0].")"."</a><br>";
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
					`blog_url` = '".mysql_real_escape_string($row[3])."',
					`blog` = '".mysql_real_escape_string($row[4])."',
					`twitter_username` = '".mysql_real_escape_string($row[5])."',
					`facebook` = '".mysql_real_escape_string($row[6])."',
					`linkedin` = '".mysql_real_escape_string($row[7])."',
					`tags` = '".mysql_real_escape_string($row[8])."',
					`active` = '".mysql_real_escape_string($row[9])."'
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
		else{
			$data = array();
			$data['content'] = $this->load->view($table.'/import', $data, true);
			$this->load->view('layout/main', $data);
		}
	}
	
	public function ajax_search(){
		$co_name = $_GET['term']."%";
		$sql = "select `id` as `value`, `name` as `label` from `people` where `name` like ".$this->db->escape(trim($co_name))." limit 10" ;
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
		if(strlen($co_name)>0){
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
	
	public function ajax_edit(){
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
			alertX("Successfully Updated Person '<?php echo htmlentities($_POST['name']); ?>'.");
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
			alertX("Successfully deleted <?php echo htmlentities($person[0]['name']); ?>");
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
	public function ajax_add(){
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
			
			?>
			alertX("Successfully Added Person '<?php echo htmlentities($_POST['name']); ?>'.");
			self.location = "<?php echo site_url(); ?>people/add";
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
	
	function edit($person_id){
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
			$data['content'] = $this->load->view('people/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			redirect_to(site_url()."people");
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
