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
	
	public function all($q="", $id=""){
		$search = urldecode(trim($_GET['q']));
		if(!$search){
			$search = urldecode(trim($q));
		}
		$searchx = $search;
		$search = strtolower($search);
		$search2 = explode(":",$search);
		if($search2[1]){
			$exact = trim($search2[0]);
			$search2 = html_entity_decode(trim($search2[1]));
			if($exact!="country"&&$exact!="category"){
				$exact = "";
			}
			if($exact=="category"){
				$search2 = $id;
			}
		}
		$gfilter = trim($_GET['filter']);
		$start = $_GET['start'];
		$start += 0;
		$limit = 1000;
		
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
			$sql = "select * from `".$table."` where 
				(
					";
					if($exact=='country'){
						$sql .= "
						`".$exact."` = '".mysql_real_escape_string($search2)."'";
					}
					else if($exact=='category'){
						$sql .= "
						`id` in (select `company_id` from `company_category` where `category_id`='".mysql_real_escape_string($search2)."')";
					}
					else{
						$sql .= "
						LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`website`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`blog`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'";
					}
			$sql .="
				)
				and
				(
					".$filter."
					and `active`=1
				)
			order by `name` asc limit $start, $limit" ;
			
			$q = $this->db->query($sql);
			$$table = $q->result_array();
			//echo $sql;
			//print_r($companies);
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
			$sql = "select * from `".$table."` where 
				(
					";
					if($exact=='country'){
						$sql .= "0";
					}
					else if($exact=='category'){
						$sql .= "0";
					}
					else{
						$sql .= "
						LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`blog`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'";
					}
			$sql .="
				)
				and
				(
					".$filter."
					and `active`=1
				)
			order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$$table = $q->result_array();
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
			$sql = "select * from `".$table."` where 
				(
					";
					if($exact=='country'){
						$sql .= "
						`".$exact."` = '".mysql_real_escape_string($search2)."'";
					}
					else if($exact=='category'){
						$sql .= "0";
					}
					else{
						$sql .= "
						LOWER(`name`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`email_address`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`twitter_username`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`website`) like '%".mysql_real_escape_string($search)."%' or
						LOWER(`blog`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`facebook`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`linkedin`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`description`) like '%".mysql_real_escape_string($search)."%' or 
						LOWER(`tags`) like '%".mysql_real_escape_string($search)."%'";
					}
			$sql .="
				)
				and
				(
					".$filter."
					and `active`=1
				)
			order by `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$$table = $q->result_array();
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
			$sql = "select `company_fundings`.* ,`companies`.`name`, `companies`.`slug`, `companies`.`logo` from `company_fundings` left join `companies` on (`companies`.`id` = `company_fundings`.`company_id`) where `company_id` = '".$nf['company_id']."' and `date_ts`='".$nf['date_ts']."'";
			$q = $this->db->query($sql);
			$nfc = $q->result_array();
			if($nfc[0]){
				$newlyfunded[] = $nfc[0];
			}
		}
		
		return $newlyfunded;
	}
}