<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('people/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		$search = trim($_GET['search']);
		
		$sql = "select * from `people` where 
			`name` like '%".mysql_escape_string($search)."%' or
			`email_address` like '%".mysql_escape_string($search)."%' or
			`twitter_username` like '%".mysql_escape_string($search)."%' or 
			`blog` like '%".mysql_escape_string($search)."%' or 
			`facebook` like '%".mysql_escape_string($search)."%' or 
			`linkedin` like '%".mysql_escape_string($search)."%' or 
			`description` like '%".mysql_escape_string($search)."%' or 
			`tags` like '%".mysql_escape_string($search)."%'
		order by `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$people = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `people` where 
			`name` like '%".mysql_escape_string($search)."%' or
			`email_address` like '%".mysql_escape_string($search)."%' or
			`twitter_username` like '%".mysql_escape_string($search)."%' or
			`blog` like '%".mysql_escape_string($search)."%' or 
			`facebook` like '%".mysql_escape_string($search)."%' or 
			`linkedin` like '%".mysql_escape_string($search)."%' or 
			`description` like '%".mysql_escape_string($search)."%' or 
			`tags` like '%".mysql_escape_string($search)."%' 
		order by `name` asc" ;
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
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $search;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('people/main', $data, true);
		$this->load->view('layout/main', $data);
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
			$people[$i]['desc'] = $current_company;
		}

		echo json_encode($people);
		exit();
	}
	
	public function ajax_edit(){
		
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("Please input a Name.");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("Please input a Description.");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("Please input a valid E-mail.");
			<?php
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
		?>
		alertX("Successfully deleted <?php echo htmlentities($person[0]['name']); ?>");
		<?php
	}
	
	public function ajax_add_person_shortcut_ipc(){	
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("Please input a Name.");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `people` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			?>
			insert_id = "<?php echo sanitizeX($id); ?>";
			insert_id = uNum(insert_id);
			success = true;
			<?php
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
			alertX("Please input a Name.");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `people` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>"
			peoplePreAdd(label, value);
			jQuery("#person_add_loader").html("");
			jQuery("#people_search").attr("disabled", false);
			jQuery("#people_search").val("")
			<?php
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
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("Please input a Name.");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("Please input a Description.");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("Please input a valid E-mail.");
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
			$sql = "select `a`.*, `b`.`name` as `name` from `company_person` as `a` left join `companies` as `b` on (`a`.`company_id`=`b`.`id`) where `person_id`=".$this->db->escape($person_id)." and `name`<>'' order by `name` asc";
			$q = $this->db->query($sql);
			$companies = $q->result_array();
			
			$sql = "select `a`.*, `b`.`name` as `name` from `investment_org_person` as `a` left join `investment_orgs` as `b` on (`a`.`investment_org_id`=`b`.`id`) where `person_id`=".$this->db->escape($person_id)." and `name`<>'' order by `name` asc";
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
			order by `date_ts` desc	
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
}
