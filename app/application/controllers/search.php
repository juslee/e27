<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class search extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	
	public function index(){
		$this->all($search);
	}
	
	public function all(){
		$search = urldecode(trim($_GET['q']));
		$gfilter = trim($_GET['filter']);
		$start = $_GET['start'];
		$start += 0;
		$limit = 50;
		
		if($gfilter=='newlyadded'){
			$filter = "UNIX_TIMESTAMP(`dateadded`)>".(time()-(5*24*60*60)).""; //within 5 days
		}
		else if($gfilter=='newlyupdated'){
			$filter = "UNIX_TIMESTAMP(`dateupdated`)>".(time()-(5*24*60*60)).""; //within 5 days
		}
		else{
			$filter = 1;
		}
		
		$totalcnt = 0;
		$results = array();
		
		if($gfilter==""||$gfilter=="companies"){
			//companies
			$results['companies'] = array();
			$sql = "select * from `companies` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or
					`website` like '%".mysql_real_escape_string($search)."%' or
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
				and
				(
					".$filter."
				)
			order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$companies = $q->result_array();
			
			$sql = "select count(id) as `cnt` from `companies` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or
					`website` like '%".mysql_real_escape_string($search)."%' or
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%' 
				)
				and
				(
					".$filter."
				)
			order by `name` asc" ;
			$q = $this->db->query($sql);
			$cnt = $q->result_array();
			$cnt = $cnt[0]['cnt'];
			$totalcnt += $cnt;
			$results['companies']['cnt'] = $cnt;
			$results['companies']['results'] = $companies;
		}
		
		if($gfilter==""||$gfilter=="people"){
			//people
			$results['people'] = array();
			$sql = "select * from `people` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or 
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
				and
				(
					".$filter."
				)
			order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$people = $q->result_array();
			
			$sql = "select count(id) as `cnt` from `people` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%' 
				)
				and
				(
					".$filter."
				)
			order by `name` asc" ;
			$q = $this->db->query($sql);
			$cnt = $q->result_array();
			$cnt = $cnt[0]['cnt'];
			$totalcnt += $cnt;
			$results['people']['cnt'] = $cnt;
			$results['people']['results'] = $people;
		}
		
		if($gfilter==""||$gfilter=="investment_orgs"){
			//investment_orgs
			$results['investment_orgs'] = array();
			$sql = "select * from `investment_orgs` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or
					`website` like '%".mysql_real_escape_string($search)."%' or
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
				and
				(
					".$filter."
				)
			order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$investment_orgs = $q->result_array();
			
			$sql = "select count(id) as `cnt` from `investment_orgs` where 
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`email_address` like '%".mysql_real_escape_string($search)."%' or
					`twitter_username` like '%".mysql_real_escape_string($search)."%' or
					`website` like '%".mysql_real_escape_string($search)."%' or
					`blog` like '%".mysql_real_escape_string($search)."%' or 
					`facebook` like '%".mysql_real_escape_string($search)."%' or 
					`linkedin` like '%".mysql_real_escape_string($search)."%' or 
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%' 
				)
				and
				(
					".$filter."
				)
			order by `name` asc" ;
			$q = $this->db->query($sql);
			$cnt = $q->result_array();
			$cnt = $cnt[0]['cnt'];
			$totalcnt += $cnt;
			$results['investment_orgs']['cnt'] = $cnt;
			$results['investment_orgs']['results'] = $investment_orgs;
		}
		
		$results['totalcnt'] = $totalcnt;
		
		$data['results'] = $results;
		$data['search'] = $search;
		$data['newlyfunded'] = $this->newlyFunded();
		$data['content'] = $this->load->view('startuplist/search', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	private function newlyFunded(){
		//get newly funded companies
		$sql = "SELECT `company_id` , MAX( `date_ts` ) AS `date_ts` FROM `company_fundings` GROUP BY `company_id` ORDER BY `date_ts` DESC LIMIT 50";
		$q = $this->db->query($sql);
		$nfcompanies = $q->result_array();
		$newlyfunded = array();
		foreach($nfcompanies as $nf){
			$sql = "select `company_fundings`.* ,`companies`.`name`, `companies`.`logo` from `company_fundings` left join `companies` on (`companies`.`id` = `company_fundings`.`company_id`) where `company_id` = '".$nf['company_id']."' and `date_ts`='".$nf['date_ts']."'";
			$q = $this->db->query($sql);
			$nfc = $q->result_array();
			if($nfc[0]){
				$newlyfunded[] = $nfc[0];
			}
		}
		
		return $newlyfunded;
	}
}