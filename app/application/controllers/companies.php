<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `companies` where 1 order by `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['companies'] = $companies;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('companies/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function search(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		$search = trim($_GET['search']);
		
		$sql = "select * from `companies` where 
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
		$companies = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `companies` where 
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
		$data['companies'] = $companies;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['search'] = $search;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('companies/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function ajax_search(){
		$co_name = $_GET['term']."%";
		$sql = "select `id` as `value`, `name` as `label` from `companies` where `name` like ".$this->db->escape(trim($co_name))." limit 10" ;
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
	public function ajax_edit(){
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
			alertX("Please input a Company Name.");
			<?php
		}
		else if($company[0]['id']!=""&&$company[0]['id']!=$_POST['id']){
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
			alertX("Successfully Updated Company '<?php echo htmlentities($_POST['name']); ?>'.");
			self.location = self.location; //refresh
			<?php
		}
		
		?>
		jQuery("#savebutton").val("Save");
		jQuery("#company_form *").attr("disabled", false);
		
		<?php		
		exit();
	}
	
	public function ajax_delete($company_id=""){
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
		?>
		alertX("Successfully deleted <?php echo htmlentities($company[0]['name']); ?>");
		<?php
	}
	
	public function ajax_add_competitor_shortcut(){
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
			alertX("Please input a Company Name.");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("Company already exists in the database.");
			<?php
		}
		
		if(!$err){
			$sql = "insert into `companies` set `name`=".$this->db->escape(trim($_POST['name']));
			$sql .= ", active=1, `dateadded`=NOW(), `dateupdated`=NOW()";
			$q = $this->db->query($sql);
			$id = $this->db->insert_id();
			?>
			label = "<?php echo sanitizeX(trim($_POST['name'])); ?>";
			value = "<?php echo sanitizeX($id); ?>";
			addCompetitor(label, value, true);
			jQuery("#competitor_add_loader").html("");
			jQuery("#competitor_search").attr("disabled", false);
			jQuery("#competitor_search").val("");
			
			<?php
		}
		else{
			?>
			jQuery("#competitor_add_loader").html("");
			jQuery("#competitor_search").attr("disabled", false);
			jQuery("#competitor_search").val("");
			<?php
		}
		
	}
	public function ajax_add(){
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
			alertX("Please input a Company Name.");
			<?php
		}
		else if($company[0]['id']){
			$err = 1;
			?>
			alertX("Company already exists in the database.");
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
			
			?>
			alertX("Successfully Added Company '<?php echo htmlentities($_POST['name']); ?>'.");
			//self.location = "<?php echo site_url(); ?>companies/edit/<?php echo $id; ?>";
			self.location = "<?php echo site_url(); ?>companies/add";
			<?php
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
		$sql = "select distinct `code`, `currency` from `currencies` where `currency` not like 'uses%'";
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
	
	function edit($company_id){
		$sql = "select * from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$company = $q->result_array();	
		if($company[0]['id']){
			$data = array();
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
			
			$sql = "select `a`.*, `b`.`name` as `name` from `company_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) where `company_id`=".$this->db->escape($company_id)." and `name`<>'' order by `name` asc";
			$q = $this->db->query($sql);
			$people = $q->result_array();
			$sql = "select distinct `code`, `currency` from `currencies` where `currency` not like 'uses%'";
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
			order by `date_ts` desc	
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
			$data['content'] = $this->load->view('companies/add', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			redirect_to(site_url()."companies");
		}
	}
}
