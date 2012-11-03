<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$investment_orgs = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `investment_orgs` where 1 order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['investment_orgs'] = $investment_orgs;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('investment_orgs/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		$search = trim($_GET['search']);
		
		$sql = "select * from `investment_orgs` where 
			`name` like '%".mysql_escape_string($search)."%' or
			`email_address` like '%".mysql_escape_string($search)."%' or
			`twitter_username` like '%".mysql_escape_string($search)."%' or
			`website` like '%".mysql_escape_string($search)."%' or
			`blog` like '%".mysql_escape_string($search)."%' or 
			`facebook` like '%".mysql_escape_string($search)."%' or 
			`linkedin` like '%".mysql_escape_string($search)."%' or 
			`description` like '%".mysql_escape_string($search)."%' or 
			`tags` like '%".mysql_escape_string($search)."%'
		order by `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$investment_orgs = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `investment_orgs` where 
			`name` like '%".mysql_escape_string($search)."%' or
			`email_address` like '%".mysql_escape_string($search)."%' or
			`twitter_username` like '%".mysql_escape_string($search)."%' or
			`website` like '%".mysql_escape_string($search)."%' or
			`blog` like '%".mysql_escape_string($search)."%' or 
			`facebook` like '%".mysql_escape_string($search)."%' or 
			`linkedin` like '%".mysql_escape_string($search)."%' or 
			`description` like '%".mysql_escape_string($search)."%' or 
			`tags` like '%".mysql_escape_string($search)."%' 
		order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['investment_orgs'] = $investment_orgs;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $search;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('investment_orgs/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function ajax_search(){
		$co_name = $_GET['term']."%";
		$sql = "select `id` as `value`, `name` as `label` from `investment_orgs` where `name` like ".$this->db->escape(trim($co_name))." limit 10" ;
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
			alertX("Please input a Company Name.");
			<?php
		}
		else if($investment_org[0]['id']!=""&&$investment_org[0]['id']!=$_POST['id']){
			$err = 1;
			?>
			alertX("Company name already exists in the database.");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("Please input a Company Description.");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("Please input a valid E-mail.");
			<?php
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
		?>
		alertX("Successfully deleted <?php echo htmlentities($investment_org[0]['name']); ?>");
		<?php
	}
	
	public function ajax_add_investment_org_shortcut_ipc(){	
		$err = 0;
		if(!trim($_POST['name'])){
			$err = 1;
			?>
			alertX("Please input a Name.");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `investment_orgs` set `name`=".$this->db->escape(trim($_POST['name']));
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
			alertX("Please input a Investment Organization Name.");
			<?php
		}
		else if($investment_org[0]['id']){
			$err = 1;
			?>
			alertX("Investment Organization already exists in the database.");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `investment_orgs` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>";
			investmentOrgPreAdd(label, value);
			jQuery("#investment_org_add_loader").html("");
			jQuery("#investment_org_search").attr("disabled", false);
			jQuery("#investment_org_search").val("");
			
			<?php
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
			alertX("Please input a Name.");
			<?php
		}
		else if($investment_org[0]['id']){
			$err = 1;
			?>
			alertX("Investment organization already exists in the database.");
			<?php
		}
		else if(!trim($_POST['description'])){
			$err = 1;
			?>
			alertX("Please input a Investment organization description.");
			<?php
		}
		else if(!checkEmail($_POST['email_address'])){
			$err = 1;
			?>
			alertX("Please input a valid E-mail.");
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
			$sql = "select * from `countries`";
			$q = $this->db->query($sql);
			$countries = $q->result_array();
			
			
			$sql = "select `a`.*, `b`.`name` as `name` from `investment_org_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) where `investment_org_id`=".$this->db->escape($investment_org_id)." and `name`<>'' order by `name` asc";
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
}
