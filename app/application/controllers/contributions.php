<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class contributions extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 200;
		
		$sql = "select * from `contributions` where 1 order by `dateupdated_ts` desc limit $start, $limit" ;
		$export_sql = md5($sql);
		$_SESSION['export_sqls'][$export_sql] = $sql;
		$q = $this->db->query($sql);
		$contributions = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `contributions` where 1" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['contributions'] = $contributions;
		$data['export_sql'] = $export_sql;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('contributions/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function reject_contribution($contributionid=""){
		if($contributionid){
			$sql = "update `contributions` set `approved`=-1 where `id`='".mysql_real_escape_string($contributionid)."'";
			$q = $this->db->query($sql);
		}
		header ('HTTP/1.1 301 Moved Permanently');
		header("Location: ".site_url()."contributions");
		exit();
	}
	
	
}
