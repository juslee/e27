<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class webusers extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$search = trim($_GET['search']);
		if($search){
			$sqlext = " and (
				lower(`email`) like '%".mysql_real_escape_string(strtolower($search))."%' or 
				lower(`name`) like '%".mysql_real_escape_string(strtolower($search))."%' or 
				lower(`fb_email`) like '%".mysql_real_escape_string(strtolower($search))."%' 
			)";
		}
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		
		$sql = "select * from `web_users` where (`name`<>'' or `fb_data` <>'' or `in_data`<>'') $sqlext order by `id` desc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$web_users = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `web_users` where (`name`<>'' or `fb_data` <>'' or `in_data`<>'') $sqlext" ;
		
		
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$data = array();
		$data['search'] = $search;
		$data['web_users'] = $web_users;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['type'] = $type;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('webusers/main', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function deletewebuser($id){
		$sql = "delete from `web_users` where `id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		header ('HTTP/1.1 301 Moved Permanently');
		header("Location: ".site_url()."webusers");
		exit();
	}

	
	
}
