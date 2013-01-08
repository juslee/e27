<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class contributions extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$type = $_GET['type'];
		if($type!=""){
			$type = strtolower($type);
			if($type=='approved'){
				$sqlext = " and `approved`=1";
			}
			else if($type=='rejected'){
				$sqlext = " and `approved`=-1";
			}
			else if($type=='pending'){
				$sqlext = " and `approved`=0";
			}
		}
		$start = $_GET['start'];
		$start += 0;
		$limit = 200;
		
		$sql = "select * from `contributions` where 1 $sqlext order by `dateupdated_ts` desc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$contributions = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `contributions` where 1 $sqlext" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['contributions'] = $contributions;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['type'] = $type;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('contributions/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function reject_contribution($contributionid=""){
		if($contributionid){
			$sql = "update `contributions` set `approved`=-1, `dateupdated_ts`='".time()."' where `id`='".mysql_real_escape_string($contributionid)."'";
			$q = $this->db->query($sql);
		}
		header ('HTTP/1.1 301 Moved Permanently');
		header("Location: ".site_url()."contributions");
		exit();
	}
	
	public function countpending(){
		$sql = "select count(id) as `cnt` from `contributions` where `approved`=0";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		echo $cnt[0]['cnt'];
	}
	
}
