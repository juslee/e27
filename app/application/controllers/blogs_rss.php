<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blogs_rss extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function index(){
		$data = array();
		$data['content'] = $this->load->view('blogs_rss/main', "", true);
		$this->load->view('layout/main', $data);
	}
	
	public function people(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 10;
		
		$shuffle = "";
		if($_GET['shuffle']){
			$shuffle = "rand(), ";
		}
		$sqlwhere = "`blog`<>''";
		$search = trim($_GET['search']);
		if($search){
			/*
			$sqlwhere .= "
				and
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
			";
			*/
			$sqlwhere .= "
				and
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
			";
		}
		
		$sql = "select * from `people` where $sqlwhere order by $shuffle `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$list = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `people` where $sqlwhere order by $shuffle `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$time = time();
		$t  = count($list);
		for($i=0; $i<$t; $i++){
			$url = trim($list[$i]['blog']);
			$list[$i]['list_type'] = 'people';
			if ( $url ) {
				//if not http or https
				if(strpos(strtolower($url), "http://")!==0&&strpos(strtolower($url), "https://")!==0){
					$url = "http://".$url;
				}
				//echo "fetching...".$url;
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$list[$i]['feed'] = array();
				$list[$i]['feed']['rss'] = $rss;
				$list[$i]['feed']['items'] = $items;
				$list[$i]['feed']['url'] = $url;
				$list[$i]['feed']['time'] = $time;
 			}
		}
		
		$list = $this->bubbleSort($list);
		
		$data = array();
		$data['search'] = $search;
		$data['list'] = $list;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('blogs_rss/list', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function companies(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 10;
		
		$shuffle = "";
		if($_GET['shuffle']){
			$shuffle = "rand(), ";
		}
		
		$sqlwhere = "`blog`<>''";
		$search = trim($_GET['search']);
		if($search){
			/*
			$sqlwhere .= "
				and
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
			";
			*/
			$sqlwhere .= "
				and
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
			";
		}
		
		$sql = "select * from `companies` where $sqlwhere order by $shuffle `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$list = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `companies` where $sqlwhere order by $shuffle `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$time = time();
		$t  = count($list);
		for($i=0; $i<$t; $i++){
			$url = trim($list[$i]['blog']);
			$list[$i]['list_type'] = 'companies';
			//echo "fetching...".$url;
			if ( $url ) {
				//if not http or https
				if(strpos(strtolower($url), "http://")!==0&&strpos(strtolower($url), "https://")!==0){
					$url = "http://".$url;
				}
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$list[$i]['feed'] = array();
				$list[$i]['feed']['rss'] = $rss;
				$list[$i]['feed']['items'] = $items;
				$list[$i]['feed']['url'] = $url;
				$list[$i]['feed']['time'] = $time;
 			}
		}
	
		$list = $this->bubbleSort($list);
		
		$data = array();
		$data['search'] = $search;
		$data['list'] = $list;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('blogs_rss/list', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function investment_orgs(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 10;
		
		$shuffle = "";
		if($_GET['shuffle']){
			$shuffle = "rand(), ";
		}
		
		$sqlwhere = "`blog`<>''";
		$search = trim($_GET['search']);
		if($search){
			/*
			$sqlwhere .= "
				and
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
			";
			*/
			$sqlwhere .= "
				and
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
			";
		}
		
		$sql = "select * from `investment_orgs` where $sqlwhere order by $shuffle `name` asc limit $start, $limit" ;
		$q = $this->db->query($sql);
		$list = $q->result_array();
		
		$sql = "select count(id) as `cnt` from `investment_orgs` where $sqlwhere order by $shuffle `name` asc" ;
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$pages = ceil($cnt[0]['cnt']/$limit);
		
		$time = time();
		$t  = count($list);
		for($i=0; $i<$t; $i++){
			$url = trim($list[$i]['blog']);
			$list[$i]['list_type'] = 'investment_orgs';
			if ( $url ) {
				//if not http or https
				if(strpos(strtolower($url), "http://")!==0&&strpos(strtolower($url), "https://")!==0){
					$url = "http://".$url;
				}
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$list[$i]['feed'] = array();
				$list[$i]['feed']['rss'] = $rss;
				$list[$i]['feed']['items'] = $items;
				$list[$i]['feed']['url'] = $url;
				$list[$i]['feed']['time'] = $time;
 			}
		}
		
		$list = $this->bubbleSort($list);
	
		$data = array();
		$data['search'] = $search;
		$data['list'] = $list;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limit;
		$data['cnt'] = $cnt[0]['cnt'];
		$data['content'] = $this->load->view('blogs_rss/list', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	public function all(){
		$start = $_GET['start'];
		$start += 0;
		$limit = 20;
		
		$list_types = array("companies", "people", "investment_orgs");
		$limittotal = ($limit*count($list_types));
		
		$listall = array();
		
		$time = time();
		
		$shuffle = "";
		if($_GET['shuffle']){
			$shuffle = "rand(), ";
		}
		
		$sqlwhere = "`blog`<>''";
		$search = trim($_GET['search']);
		if($search){
			/*
			$sqlwhere .= "
				and
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
			";
			*/
			$sqlwhere .= "
				and
				(
					`name` like '%".mysql_real_escape_string($search)."%' or
					`description` like '%".mysql_real_escape_string($search)."%' or 
					`tags` like '%".mysql_real_escape_string($search)."%'
				)
			";
		}
		
		foreach($list_types as $list_type){
			$sql = "select * from `$list_type` where $sqlwhere order by $shuffle `name` asc limit $start, $limit" ;
			$q = $this->db->query($sql);
			$list = $q->result_array();
	
			$sql = "select count(id) as `cnt` from `$list_type` where $sqlwhere order by $shuffle `name` asc" ;
			$q = $this->db->query($sql);
			$cnt = $q->result_array();
			$cnt = $cnt[0]['cnt'];	
			$cnttotal += $cnt;

			$t  = count($list);
			for($i=0; $i<$t; $i++){
				$url = trim($list[$i]['blog']);
				$list[$i]['list_type'] = $list_type;
				if ( $url ) {
					//if not http or https
					if(strpos(strtolower($url), "http://")!==0&&strpos(strtolower($url), "https://")!==0){
						$url = "http://".$url;
					}
					$rss = @fetch_rss( $url );
					$items = @array_slice($rss->items, 0, 10);
					$list[$i]['feed'] = array();
					$list[$i]['feed']['rss'] = $rss;
					$list[$i]['feed']['items'] = $items;
					$list[$i]['feed']['url'] = $url;
					$list[$i]['feed']['time'] = $time;
				}
			}
			$listall = array_merge($listall, $list);
		}

		
		
		$pages = ceil($cnttotal/$limittotal);
		
		$listall = $this->bubbleSort($listall);
		
		$data = array();
		$data['search'] = $search;
		$data['list'] = $listall;
		$data['pages'] = $pages;
		$data['start'] = $start;
		$data['limit'] = $limittotal;
		$data['cnt'] = $cnttotal;
		$data['content'] = $this->load->view('blogs_rss/list', $data, true);
		$this->load->view('layout/main', $data);
	}
	
	private function bubbleSort($arr){
		//strcasecmp ( string $str1 , string $str2 )
		$size = count($arr);
		for ($i=0; $i<$size; $i++) {
			for ($j=0; $j<$size-1-$i; $j++) {
				if (strcasecmp($arr[$j+1]['name'],$arr[$j]['name'])<=0) {
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
	
	function techinasia(){
		$date = date("Y-m-d");
		$day = 24*60*60;
		$tsnow = strtotime($date);
		$ts = $tsnow;
		header('Content-type: application/ms-excel;');
		header("Content-Type: application/force-download");
		header('Content-Disposition: attachment; filename=techinasia.xls');
		echo '<table border="1">';
		while(date("Y-m-d", $ts)!="2012-09-30"){
			$url = "http://www.techinasia.com/".date("Y/m/d", $ts)."/feed/";
			$rss = @fetch_rss( $url );
			foreach($rss->items as $key=>$value){
				echo "<tr>";
				echo "<td>".date("M d, Y",strtotime($value['pubdate']))."</td>";
				echo "<td>".htmlentitiesX($value['title'])."</td>";
				echo "<td>".htmlentitiesX($value['dc']['creator'])."</td>";
				echo "</tr>";
			}
			$ts -= $day;
		}
		echo "</table>";
		
		//$items = @array_slice($rss->items, 0, 10);
		
	}
	
	function e27(){
		$datefrom = $_GET['datefrom'];
		$dateto = $_GET['dateto'];
		if(!trim($datefrom)||!trim($dateto)){
			echo "Incomplete parameters!";
			exit();
		}
		$date = date($dateto);
		$day = 24*60*60;
		$tsnow = strtotime($date);
		$ts = $tsnow;
		header('Content-type: application/ms-excel;');
		header("Content-Type: application/force-download");
		header('Content-Disposition: attachment; filename=e27.xls');
		echo '<table border="1">';
		$datefrom = strtotime($datefrom)-$day;
		$datefrom = date("Y-m-d", $datefrom);
		while(date("Y-m-d", $ts)!=$datefrom){
			$url = "http://www.e27.sg/".date("Y/m/d", $ts)."/feed/";
			$rss = @fetch_rss( $url );
			foreach($rss->items as $key=>$value){
				//echo "<pre>";
				//print_r($value);
				//echo "</pre>";
				//exit();
				echo "<tr>";
				echo "<td>".date("M d, Y",strtotime($value['pubdate']))."</td>";
				echo "<td>".htmlentitiesX($value['title'])."</td>";
				echo "<td>".htmlentitiesX($value['dc']['creator'])."</td>";
				echo "</tr>";
			}
			$ts -= $day;
		}
		echo "</table>";
		
		//$items = @array_slice($rss->items, 0, 10);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */