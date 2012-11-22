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
		$results['results'] = array();
		if($gfilter==""||$gfilter=="companies"){
			//companies
			$table = "companies";
			$$table = array();
			$results[$table] = array();
			$sql = "select * from `".$table."` where (`name` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp); 
			$sql = "select * from `".$table."` where (`email_address` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`twitter_username` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`website` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`blog` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`facebook` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`linkedin` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`description` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`tags` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$temparr = array();
			$resultstemp = $$table;
			$t = count($resultstemp);
			//remove same results
			for($i=0; $i<$t; $i++){
				$value = $resultstemp[$i];
				if(!in_array($value['id'], $temparr)){
					$temparr[] = $value['id'];
					//echo $search, " ", $resultstemp[$i]['name'], " ", abs(strcasecmp($search, $resultstemp[$i]['name'])), "<br>";
					$resultstemp[$i]['name_score'] = $this->nameScore($search, $resultstemp[$i]['name']);
					$resultstemp[$i]['table'] = $table;
				}
				else{
					unset($resultstemp[$i]);
				}
			}
			$resultstemp = array_values($resultstemp);
			$results[$table]['cnt'] = $t;
			$totalcnt += $results[$table]['cnt'];
			$results[$table]['results'] = $resultstemp;
			$results['results'] = array_merge($results['results'], $resultstemp);
		}
		
		if($gfilter==""||$gfilter=="people"){
			//people
			$table = "people";
			$$table = array();
			$results[$table] = array();
			$sql = "select * from `".$table."` where (`name` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp); 
			$sql = "select * from `".$table."` where (`email_address` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`twitter_username` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`blog` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`facebook` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`linkedin` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`description` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`tags` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$temparr = array();
			$resultstemp = $$table;
			$t = count($resultstemp);
			//remove same results
			for($i=0; $i<$t; $i++){
				$value = $resultstemp[$i];
				if(!in_array($value['id'], $temparr)){
					$temparr[] = $value['id'];
					//echo $search, " ", $resultstemp[$i]['name'], " ", abs(strcasecmp($search, $resultstemp[$i]['name'])), "<br>";
					$resultstemp[$i]['name_score'] = $this->nameScore($search, $resultstemp[$i]['name']);
					$resultstemp[$i]['table'] = $table;
				}
				else{
					unset($resultstemp[$i]);
				}
			}
			$resultstemp = array_values($resultstemp);
			$results[$table]['cnt'] = $t;
			$totalcnt += $results[$table]['cnt'];
			$results[$table]['results'] = $resultstemp;
			$results['results'] = array_merge($results['results'], $resultstemp);
		}
		
		if($gfilter==""||$gfilter=="investment_orgs"){
			//investment_orgs
			$table = "investment_orgs";
			$$table = array();
			$results[$table] = array();
			$sql = "select * from `".$table."` where (`name` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp); 
			$sql = "select * from `".$table."` where (`email_address` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`twitter_username` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`website` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`blog` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`facebook` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`linkedin` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`description` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$sql = "select * from `".$table."` where (`tags` like '%".mysql_real_escape_string($search)."%' ) and (".$filter.") order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql); $$tabletemp = $q->result_array(); $$table = array_merge($$table, $$tabletemp);
			$temparr = array();
			$resultstemp = $$table;
			$t = count($resultstemp);
			//remove same results
			for($i=0; $i<$t; $i++){
				$value = $resultstemp[$i];
				if(!in_array($value['id'], $temparr)){
					$temparr[] = $value['id'];
					//echo $search, " ", $resultstemp[$i]['name'], " ", abs(strcasecmp($search, $resultstemp[$i]['name'])), "<br>";
					$resultstemp[$i]['name_score'] = $this->nameScore($search, $resultstemp[$i]['name']);
					$resultstemp[$i]['table'] = $table;
				}
				else{
					unset($resultstemp[$i]);
				}
			}
			$resultstemp = array_values($resultstemp);
			$results[$table]['cnt'] = $t;
			$totalcnt += $results[$table]['cnt'];
			$results[$table]['results'] = $resultstemp;
			$results['results'] = array_merge($results['results'], $resultstemp);
		}
		$results['results'] = $this->sortResults($results['results']);
		$results['totalcnt'] = $totalcnt;
		$_SESSION['search_results'] = $results;
		
		//echo "<pre>";
		//print_r($results);
		
		$data['results'] = $results;
		$data['search'] = $search;
		$data['newlyfunded'] = $this->newlyFunded();
		$data['content'] = $this->load->view('startuplist/search', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	private function sortResults($arr){
		$size = count($arr);
		for ($i=0; $i<$size; $i++) {
			for ($j=0; $j<$size-1-$i; $j++) {
				if ($arr[$j+1]['name_score'] < $arr[$j]['name_score']) {
					$this->swap($arr, $j, $j+1);
				}
			}
		}
		return $arr;
	}

	private function swap(&$arr, $a, $b) {
		$tmp = $arr[$a];
		$arr[$a] = $arr[$b];
		$arr[$b] = $tmp;
	}
	
	private function nameScore($search, $name){
		if(strcasecmp($search, $name)==0){
			$score = -2;
		}
		else{
			$names = explode(" ", $name);
			$scores = array();
			$t = count($names);
			for($i=0; $i<$t; $i++){
				$scores[] = abs(strcasecmp($search, $names[$i]));
			}
			//if exact
			if(count($scores)==1&&$scores[0]==0){
				$score = -1;
			}
			else{
				sort($scores, SORT_NUMERIC);
				$score = abs($scores[0]);
			}
		}
		return $score;		
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