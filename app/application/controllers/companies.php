<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class companies extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 100;
		
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
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>/media/x.png' title='Company already exists in the database.' alt='Company already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>/media/check.png' />");
					<?php
				}

			}
			else{
				if($company[0]['id']!=$co_id){
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>/media/x.png' title='Company already exists in the database.' alt='Company already exists in the database.' />");
					<?php
				}
				else{
					?>
					jQuery("#co_check").html("<img src='<?php echo site_url(); ?>/media/check.png' />");
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
			alertX("Please input Company Name.");
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
			alertX("Please input Company Description.");
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
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext;
			$sql .= "where `id`=".$this->db->escape(trim($_POST['id']));
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
			?>
			alertX("Successfully Updated Company '<?php echo htmlentities($_POST['name']); ?>'.");
			<?php
		}
		
		?>
		jQuery("#savebutton").val("Save");
		jQuery("#company_form *").attr("disabled", false);
		<?php
		
		
		//echo $sql;
		
		exit();
	}
	
	public function ajax_delete($company_id=""){
		if(!company_id){
			$company_id = $_POST['id'];
		}
		$sql = "select * from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$company = $q->result_array();
		$sql = "delete from `companies` where `id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		$sql = "delete from `company_category` where `company_id`=".$this->db->escape($company_id);
		$q = $this->db->query($sql);
		?>
		alertX("Successfully deleted <?php echo htmlentities($company[0]['name']); ?>");
		<?php
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
			alertX("Please input Company Name.");
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
			alertX("Please input Company Description.");
			<?php
		}
		if(!$err){
			$sql = "insert into `companies` set ";
			$arr = array();
			foreach($_POST as $key=>$value){
				if(!is_array($value)){
					$arr[] ="`".$key."`=".$this->db->escape(trim($value));
				}
			}
			$sqlext = implode(", ", $arr);
			$sql .= $sqlext;
			
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
			?>
			alertX("Successfully Added Company '<?php echo htmlentities($_POST['name']); ?>'.");
			<?php
		}
		
		?>
		jQuery("#savebutton").val("Save");
		jQuery("#company_form *").attr("disabled", false);
		<?php
		
		
		//echo $sql;
		
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */