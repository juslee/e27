<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class startuplist extends CI_Controller {
	var $facebook, $fb;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		
		/*
		$this->facebook = fb();
		$this->fb = array();
		$this->fb['login_url'] = $this->facebook->getLoginUrl();
		$this->fb['user'] = $this->facebook->getUser();
		echo "<pre>";
		print_r($this->facebook);
		print_r($this->fb);
		echo "</pre>";
		if ($this->fb['user']) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->fb['user_profile'] = $this->facebook->api('/me');
				$friends = $this->facebook->api('/me/friends');
				$this->fb['user_profile']['friends'] = $friends['data'];
				$this->fb['user_profile']['friendcount'] = count($friends['data']);
			} catch (FacebookApiException $e) {
				echo $e;
				$this->fb['user'] = null;
			}
		}
		*/
	}
	
	public function purgedb($confirm=""){
		if($confirm=="confirm"){
			$sql = "TRUNCATE companies";
			$this->db->query($sql);
			$sql = "TRUNCATE company_category";
			$this->db->query($sql);
			$sql = "TRUNCATE company_fundings";
			$this->db->query($sql);
			$sql = "TRUNCATE company_fundings_ipc";
			$this->db->query($sql);
			$sql = "TRUNCATE company_person";
			$this->db->query($sql);
			$sql = "TRUNCATE competitors";
			$this->db->query($sql);
			$sql = "TRUNCATE investment_orgs";
			$this->db->query($sql);
			$sql = "TRUNCATE investment_org_person";
			$this->db->query($sql);
			$sql = "TRUNCATE logs";
			$this->db->query($sql);
			$sql = "TRUNCATE people";
			$this->db->query($sql);
			$sql = "TRUNCATE screenshots";
			$this->db->query($sql);
			$data = array();
			$data['content'] = "db is purged";
			$this->load->view('startuplist/main', $data);
		}
	}
	
	function ajax_logout(){
		unset($_SESSION['web_user']);
	}
	function userlogout(){
		$this->ajax_logout();
		header ('HTTP/1.1 301 Moved Permanently');
		header("Location: ".site_url());
		exit();
	}
	function ajax_saveFbUserData(){
		$userid = $_POST['userid'];
		$useremail = $_POST['useremail'];
		$userdata = $_POST['userdata'];
		$sql = "select * from `web_users` where `fb_id`=".$this->db->escape($userid);
		$q = $this->db->query($sql);
		$web_user = $q->result_array();
		if(trim($userid)){
			if($web_user[0]){
				$sql = "update `web_users` set 
					`fb_id` = ".$this->db->escape($userid).",
					`fb_email` = ".$this->db->escape($useremail).",
					`fb_data` = ".$this->db->escape($userdata).",
					`dateupdated` = NOW()
					where `id`='".$web_user[0]['id']."'
				";
				$q = $this->db->query($sql);
			}
			else{
				$sql = "insert into `web_users` set 
					`fb_id` = ".$this->db->escape($userid).",
					`fb_email` = ".$this->db->escape($useremail).",
					`fb_data` = ".$this->db->escape($userdata).",
					`dateadded` = NOW();
				";		
				//echo $sql;
				$q = $this->db->query($sql);
				$userid = $this->db->insert_id();
				$sql = "select * from `web_users` where `fb_id`=".$this->db->escape($userid);
				$q = $this->db->query($sql);
				$web_user = $q->result_array();
			}
			$_SESSION['web_user'] = $web_user[0];
		}
	}
	
	function ajax_saveFbUserFriends(){
		$userid = $_POST['userid'];
		$useremail = $_POST['useremail'];
		$userfriends = $_POST['userfriends'];
		$sql = "select `id` from `web_users` where `fb_id`=".$this->db->escape($userid);
		$q = $this->db->query($sql);
		$web_user = $q->result_array();
		if(trim($userid)){
			if($web_user[0]){
				$sql = "update `web_users` set 
					`fb_id` = ".$this->db->escape($userid).",
					`fb_friends` = ".$this->db->escape($userfriends).",
					`dateupdated` = NOW()
					where `id`='".$web_user[0]['id']."'
				";
				$q = $this->db->query($sql);
			}
			else{
				$sql = "insert into `web_users` set 
					`fb_id` = ".$this->db->escape($userid).",
					`fb_friends` = ".$this->db->escape($userfriends).",
					`dateadded` = NOW();
				";		
				//echo $sql;
				$q = $this->db->query($sql);
			}
		}
	}
	
	public function assets($file=""){
		if($file=="styles.css"){
			$this->load->view('startuplist/stylesheet');
		}
		else if($file=="javascript.js"){
			$this->load->view('startuplist/javascript');
		}
	}
	
	public function index($type="newlyadded"){
		$start = 0;
		$limit = 12;
		if($type=="newlyadded"){
			$sql = "select `companies`.* from `companies` where `active`=1  order by `id` desc limit $start , $limit";
		}
		else if($type=="newlyupdated"){
			$sql = "select `companies`.* from `companies` where `active`=1  order by `dateupdated` desc limit $start , $limit";
		}
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		$t = count($companies);
		for($i=0; $i<$t; $i++){
			$sql = "select * from `company_fundings` where `company_id`='".$companies[$i]['id']."' order by date_ts desc ";
			$q = $this->db->query($sql);
			$latest_funding = $q->result_array();
			$companies[$i]['funding'] = $latest_funding;
			$sql = "select `categories`.* from `company_category`, `categories` where `categories`.`id` = `company_category`.`category_id` and  `company_category`.`company_id`='".$companies[$i]['id']."'";
			$q = $this->db->query($sql);
			$categories = $q->result_array();
			$companies[$i]['categories'] = $categories;
		}
		

		
		$sql = "select count(`id`) as `cnt` from `companies` where `active`=1";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();
		$cnt = $cnt[0]['cnt'];
		
		
		
		$data = array();
		$data['cnt'] = $cnt;
		$data['type'] = $type;
		$data['companies'] = $companies;
		$data['newlyfunded'] = $this->newlyFunded();
		$data['fb'] = $this->fb;
		$data['content'] = $this->load->view('startuplist/companies', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	public function ajax_loadmore($start, $type="newlyadded"){
		$limit = 12;
		if($type=="newlyadded"){
			$sql = "select `companies`.* from `companies` where `active`=1  order by `id` desc limit $start , $limit";
		}
		else if($type=="newlyupdated"){
			$sql = "select `companies`.* from `companies` where `active`=1  order by `dateupdated` desc limit $start , $limit";
		}
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		$t = count($companies);
		$n = 0;
		for($i=0; $i<$t; $i++){
			$sql = "select * from `company_fundings` where `company_id`='".$companies[$i]['id']."' order by date_ts desc ";
			$q = $this->db->query($sql);
			$latest_funding = $q->result_array();
			$companies[$i]['funding'] = $latest_funding;
			$sql = "select `categories`.* from `company_category`, `categories` where `categories`.`id` = `company_category`.`category_id` and  `company_category`.`company_id`='".$companies[$i]['id']."'";
			$q = $this->db->query($sql);
			$categories = $q->result_array();
			$companies[$i]['categories'] = $categories;
			$data = array();
			$data['company'] = $companies[$i];
			if($n%4==0){
				$n=0;
			}
			$data['n'] = $n;
			$html = $this->load->view("startuplist/company_block", $data, true);
			$html = str_replace("\n", "", $html);
			$html = str_replace("\r", "", $html);
			$companies[$i]['html'] = $html;
			$n++;
		}
		?>
		start += <?php echo count($companies); ?>;
		jQuery("#loadmorebutton").show();
		jQuery("#loadmoreloader").hide();
		
		if(start>=total){
			jQuery("#loadmorebutton").hide();
		}
		htmls = [];
		<?php
		
		for($i=0; $i<$t; $i++){
			?>
			htmls.push("<?php echo addslashes($companies[$i]['html'])?>");
			<?php
		}
		?>
		htmli = 0;
		//get all empty
		jQuery(".emptycontentblock").each(function(){
			jQuery(this).html(htmls[htmli]);
			htmli++;
		});
		
		html  ="";
		while(htmls[htmli]){
			html += "<tr>";
			for(i=0; i<4; i++){
				xclass = "";
				if(i==0){
					xclass="first";
				}
				else if(i==3){
					xclass="last";
				}
				html += "<td class='companyblockcontainer "+xclass+"'>";
				if(htmls[htmli]){
					html += htmls[htmli];
				}
				html += "</td>";
				htmli++;
			}
			html += "</tr>";
		}
		jQuery("#companies").append(html);
		<?php
	}
	
	function person($name="", $person_id="", $return=false){
		if(!$person_id){
			$sql = "select * from `people` where `slug`=".$this->db->escape($name);
		}
		else{
			$sql = "select * from `people` where `id`=".$this->db->escape($person_id)." and `active`=1";
		}
		$q = $this->db->query($sql);
		$person = $q->result_array();	
		if($person[0]['id']){
			$person_id = $person[0]['id'];
			$data = array();
			$time = time();
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`slug` as `slug`, `b`.`name` as `company_name`, `b`.`country` as `company_country`, `b`.`website` as `company_website`, `b`.`logo` as `company_logo` 
			from `company_person` as `a` left join `companies` as `b` on (`a`.`company_id`=`b`.`id`) 
			where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			
			$q = $this->db->query($sql);
			$companies = $q->result_array();
			
			$sql = "select 
			`a`.*,
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`slug` as `slug`, `b`.`name` as `investment_org_name`, `b`.`website` as `investment_org_website`, `b`.`logo` as `investment_org_logo` 
			from `investment_org_person` as `a` left join `investment_orgs` as `b` on (`a`.`investment_org_id`=`b`.`id`) 
			where `person_id`=".$this->db->escape($person_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			$q = $this->db->query($sql);
			$investment_orgs = $q->result_array();
			
			$sql = "select 
			`a`.`round`,
			`a`.`currency`,
			`a`.`amount`,
			`a`.`date_ts`,
			`a`.`company_id`,
			`b`.`name` as `company_name`,
			`b`.`slug` as `slug`
			from
			`company_fundings` as `a` left join `companies` as `b` on (`a`.`company_id` = `b`.`id`) where `a`.`id` in (
				select distinct `company_funding_id` from `company_fundings_ipc`
				where 
				`ipc_id`=".$this->db->escape($person_id)." and 
				`type`='person'
				)
			order by `date_ts` desc, `company_name` asc
			";
			$q = $this->db->query($sql);
			$milestones = $q->result_array();
			
			//related e27 articles
			//echo "fetching...".$url;
			if(trim($person[0]['tags'])){
				$tags = explode(",", $person[0]['tags']);
				
				$tt = count($tags);
				for($it=0; $it<$tt; $it++){
					$tags[$it] = seoIze($tags[$it]);
				}
				$tagsstr = implode(",", $tags);
				
				$url = "http://e27.sg/tag/".$tagsstr."/feed";
				
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$feeds = array();
				$feeds['rss'] = $rss;
				$feeds['items'] = $items;
				$feeds['url'] = $url;
				$feeds['time'] = $time;
			}
			$data['feeds'] = $feeds;
			
			$data['milestones'] = $milestones;
			$data['investment_orgs'] = $investment_orgs;
			$data['companies'] = $companies;
			$data['person'] = $person[0];
			if($return){
				return $data;
			}
			$data['newlyfunded'] = $this->newlyFunded();
			$data['content'] = $this->load->view('startuplist/person', $data, true);
			$this->load->view('startuplist/main', $data);
		}
		else{
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url());
			exit();
		}
	}
	
	function company($name="", $company_id="", $return=false){
		if(!$company_id){
			$sql = "select * from `companies` where `slug`=".$this->db->escape($name)." and `active`=1";
		}
		else{
			$sql = "select * from `companies` where `id`=".$this->db->escape($company_id)." and `active`=1";
		}
		$q = $this->db->query($sql);
		$company = $q->result_array();	
		if($company[0]['id']){
			$company_id = $company[0]['id'];
			$data = array();
			$time = time();
			
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
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`slug` as `slug`, `b`.`name` as `name`, `b`.`profile_image` as `profile_image` from `company_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
			where `company_id`=".$this->db->escape($company_id)." and `name`<>'' 
			order by `name` asc, `end_date_ts2` desc, `start_date_ts` desc";
			
			
			
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
						$sql = "select `id`, `name`, `slug` from `companies` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['slug'] = $result[0]['slug'];
							$push['id'] = $result[0]['id'];
						}
						else{
							$push['name'] = $cfi['name'];
							$push['id'] = $cfi['ipc_id'];
						}
						$company_fundings[$cfkey]['companies'][] = $push;
					}
					
					if($cfi['type']=='person'){
						$sql = "select `id`, `slug`, `name`, `profile_image` from `people` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['slug'] = $result[0]['slug'];
							$push['id'] = $result[0]['id'];
						}
						else{
							$push['name'] = $cfi['name'];
							$push['id'] = $cfi['ipc_id'];
						}
						if($result[0]['profile_image']){
							$push['profile_image'] = $result[0]['profile_image'];
						}
						$company_fundings[$cfkey]['people'][] = $push;
					}
					
					if($cfi['type']=='investment_org'){
						$sql = "select `id`, `name`, `slug` from `investment_orgs` where `id`=".$this->db->escape($cfi['ipc_id']);
						$q = $this->db->query($sql);
						$result = $q->result_array();
						$push = array();
						if($result[0]){
							$push['name'] = $result[0]['name'];
							$push['slug'] = $result[0]['slug'];
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
			order by `date_ts` desc, `company_name` asc
			";
			
			
			$sql = "select `categories`.* from `company_category`, `categories` where `categories`.`id` = `company_category`.`category_id` and  `company_category`.`company_id`='".$company[0]['id']."'";
			$q = $this->db->query($sql);
			$categories = $q->result_array();
			$company[0]['categories'] = $categories;
			
			
			$sql = "select 
			`a`.`round`,
			`a`.`currency`,
			`a`.`amount`,
			`a`.`date_ts`,
			`a`.`company_id`,
			`b`.`name` as `company_name`,
			`b`.`slug` as `slug`
			from
			`company_fundings` as `a` left join `companies` as `b` on (`a`.`company_id` = `b`.`id`) where `a`.`id` in (
				select distinct `company_funding_id` from `company_fundings_ipc`
				where 
				`ipc_id`=".$this->db->escape($company_id)." and 
				`type`='company'
				)
			order by `date_ts` desc, `company_name` asc
			";
			
			//related e27 articles
			//echo "fetching...".$url;
			if(trim($company[0]['tags'])){
				$tags = explode(",", $company[0]['tags']);
				
				$tt = count($tags);
				for($it=0; $it<$tt; $it++){
					$tags[$it] = seoIze($tags[$it]);
				}
				$tagsstr = implode(",", $tags);
				
				$url = "http://e27.sg/tag/".$tagsstr."/feed";
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$feeds = array();
				$feeds['rss'] = $rss;
				$feeds['items'] = $items;
				$feeds['url'] = $url;
				$feeds['time'] = $time;
			}
			$data['feeds'] = $feeds;
			
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
			
			if($return){
				return $data;
			}
			
			$data['newlyfunded'] = $this->newlyFunded();
			$data['content'] = $this->load->view('startuplist/company', $data, true);
			$this->load->view('startuplist/main', $data);
		}
		else{
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url());
			exit();
		}
		
	}
	
	function investment_org($name="", $investment_org_id="", $return=false){
		if(!$investment_org_id){
			$sql = "select * from `investment_orgs` where `slug`=".$this->db->escape($name)." and `active`=1";
		}
		else{
			$sql = "select * from `investment_orgs` where `id`=".$this->db->escape($investment_org_id)." and `active`=1";
		}
		$q = $this->db->query($sql);
		$investment_org = $q->result_array();	
		if($investment_org[0]['id']){
			$investment_org_id = $investment_org[0]['id'];
			$data = array();
			$time = time();
			$sql = "select * from `countries`";
			$q = $this->db->query($sql);
			$countries = $q->result_array();
			
			
			$sql = "select 
			`a`.*, 
			if(`a`.`end_date_ts`=0, $time, `a`.`end_date_ts`) as `end_date_ts2`,
			`b`.`name` as `name`, `b`.`slug` as `slug` from `investment_org_person` as `a` left join `people` as `b` on (`a`.`person_id`=`b`.`id`) 
			where `investment_org_id`=".$this->db->escape($investment_org_id)." and `name`<>'' 
			order by `end_date_ts2` desc, `start_date_ts` desc, `name` asc";
			$q = $this->db->query($sql);
			$people = $q->result_array();
			
			$sql = "select 
			`a`.`round`,
			`a`.`currency`,
			`a`.`amount`,
			`a`.`date_ts`,
			`a`.`company_id`,
			`b`.`name` as `company_name`,
			`b`.`slug` as `slug`
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
			
			
			//related e27 articles
			//echo "fetching...".$url;
			if(trim($investment_org[0]['tags'])){
				$tags = explode(",", $investment_org[0]['tags']);
				
				$tt = count($tags);
				for($it=0; $it<$tt; $it++){
					$tags[$it] = seoIze($tags[$it]);
				}
				$tagsstr = implode(",", $tags);
				
				$url = "http://e27.sg/tag/".$tagsstr."/feed";
				$rss = @fetch_rss( $url );
				$items = @array_slice($rss->items, 0, 10);
				$feeds = array();
				$feeds['rss'] = $rss;
				$feeds['items'] = $items;
				$feeds['url'] = $url;
				$feeds['time'] = $time;
			}
			$data['feeds'] = $feeds;
			
			$data['milestones'] = $milestones;
			$data['people'] = $people;
			$data['countries'] = $countries;
			$data['investment_org'] = $investment_org[0];
			$data['newlyfunded'] = $this->newlyFunded();
			if($return){
				return $data;
			}
			
			$data['content'] = $this->load->view('startuplist/investment_org', $data, true);
			$this->load->view('startuplist/main', $data);
		}
		else{
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url());
			exit();
		}
	}
	
	private function newlyFunded(){
		//get newly funded companies
		$sql = "SELECT `company_id` , MAX( `date_ts` ) AS `date_ts` FROM `company_fundings` GROUP BY `company_id` ORDER BY `date_ts` DESC LIMIT 50";
		$q = $this->db->query($sql);
		$nfcompanies = $q->result_array();
		$newlyfunded = array();
		foreach($nfcompanies as $nf){
			$sql = "select `company_fundings`.* , `companies`.`slug`, `companies`.`name`, `companies`.`logo` from `company_fundings` left join `companies` on (`companies`.`id` = `company_fundings`.`company_id`) where `company_id` = '".$nf['company_id']."' and `date_ts`='".$nf['date_ts']."'";
			$q = $this->db->query($sql);
			$nfc = $q->result_array();
			if($nfc[0]){
				$newlyfunded[] = $nfc[0];
			}
		}
		
		return $newlyfunded;
	}
	
	function slugify(){
		$table = "companies";
		$sql = "select * from `".$table."`";
		$q = $this->db->query($sql);
		$list = $q->result_array();
		$t = count($list);
		for($i=0; $i<$t; $i++){
			$row = $list[$i];
			$n = 1;
			do{
				$slug = seoIze($row['name']);
				if($n>1){
					$slug = $slug.$n;
				}
				$sql = "select `id` from `".$table."` where `slug`='".$slug."' and `id`<>'".$row['id']."'";
				$q = $this->db->query($sql);
				$rowtemp = $q->result_array();
				$n++;
			}while($rowtemp[0]['id']);
			$sql = "update `".$table."` set `slug`='".$slug."' where `id`='".$row['id']."'";
			$q = $this->db->query($sql);
		}
		
		$table = "people";
		$sql = "select * from `".$table."`";
		$q = $this->db->query($sql);
		$list = $q->result_array();
		$t = count($list);
		for($i=0; $i<$t; $i++){
			$row = $list[$i];
			$n = 1;
			do{
				$slug = seoIze($row['name']);
				if($n>1){
					$slug = $slug.$n;
				}
				$sql = "select `id` from `".$table."` where `slug`='".$slug."' and `id`<>'".$row['id']."'";
				$q = $this->db->query($sql);
				$rowtemp = $q->result_array();
				$n++;
			}while($rowtemp[0]['id']);
			$sql = "update `".$table."` set `slug`='".$slug."' where `id`='".$row['id']."'";
			$q = $this->db->query($sql);
		}
		
		$table = "investment_orgs";
		$sql = "select * from `".$table."`";
		$q = $this->db->query($sql);
		$list = $q->result_array();
		$t = count($list);
		for($i=0; $i<$t; $i++){
			$row = $list[$i];
			$n = 1;
			do{
				$slug = seoIze($row['name']);
				if($n>1){
					$slug = $slug.$n;
				}
				$sql = "select `id` from `".$table."` where `slug`='".$slug."' and `id`<>'".$row['id']."'";
				$q = $this->db->query($sql);
				$rowtemp = $q->result_array();
				$n++;
			}while($rowtemp[0]['id']);
			$sql = "update `".$table."` set `slug`='".$slug."' where `id`='".$row['id']."'";
			$q = $this->db->query($sql);
		}
		
	}
	function page_not_found(){
		$data = array();
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/404', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	
	function register(){
		if($_POST){
			//echo "<pre>";
			//print_r($_POST);
			//print_r($_SESSION);
			foreach($_POST as $key=>$value){
				$_POST[$key] = trim($value);
			}
			?>
			jQuery("#registerbutton").hide();
			jQuery("#registering").show();
			jQuery(".required").each(function(){
				v = jQuery.trim(jQuery(this).val());
				if(v==''){
					err = true;
					jQuery(this).css({border:"1px solid red"});
				}
				else{
					jQuery(this).css({border:"1px solid gray"});
				}
			});
			<?php
			
			if(checkEmail($_POST['email'], true)){
				$sql = "select * from `web_users` where lower(`email`)=".$this->db->escape(strtolower($_POST['email']));
				$q = $this->db->query($sql);
				$euser = $q->result_array();
			}
			
			$err = false;
			if(!checkEmail($_POST['email'], true)){
				$err = true;
				?>
				alertX("Invalid E-mail Address!");
				jQuery('input[name="email"]').css({border:"1px solid red"});
				<?php
			}
			else if($euser[0]['id']){
				$err = true;
				?>
				alertX("The supplied E-mail Address is already registered. Please input a new E-mail Address.");
				jQuery('input[name="email"]').css({border:"1px solid red"});
				<?php
			}
			else if(!trim($_POST['name'])){
				$err = true;
				?>
				alertX("Please input a Name!");
				jQuery('input[name="name"]').css({border:"1px solid red"});
				<?php
			}
			else if(!trim($_POST['password'])){
				$err = true;
				?>
				alertX("Please input a Password!");
				jQuery('input[name="password"]').css({border:"1px solid red"});
				<?php
			}
			else if($_POST['password']!=$_POST['repassword']){
				$err = true;
				?>
				alertX("Password and Confirm Password don't match!");
				jQuery('input[name="password"]').css({border:"1px solid red"});
				jQuery('input[name="repassword"]').css({border:"1px solid red"});
				<?php
			}
			else if(!trim($_POST['captcha'])){
				$err = true;
				?>
				alertX("Please type in the word you see in the image!");
				jQuery('input[name="captcha"]').css({border:"1px solid red"});
				<?php
			}
			else if(trim($_POST['captcha'])!=trim($_SESSION['captcha'])){
				$err = true;
				?>
				alertX("Please type in the word you see in the image!");
				jQuery('input[name="captcha"]').css({border:"1px solid red"});
				<?php
			}
			if(!$err){
				$sql = "insert into `web_users` set 
					`email` = ".$this->db->escape($_POST['email']).",
					`name` = ".$this->db->escape($_POST['name']).",
					`password` = ".$this->db->escape(md5($_POST['password'])).",
					`plain_password` = ".$this->db->escape($_POST['password']).",
					`twitter` = ".$this->db->escape($_POST['twitter']).",
					`homepage` = ".$this->db->escape($_POST['homepage']).",
					`dateadded` = NOW();
				";		
				//echo $sql;
				$q = $this->db->query($sql);
				$userid = $this->db->insert_id();
				?>
				jQuery("#registerbutton").hide();
				jQuery("#registering").show();
				self.location = "<?php echo site_url(); ?>userlogin?register=complete";
				<?php
			}
			else{
				?>
				jQuery("#registering").hide();
				jQuery("#registerbutton").show();
				<?php
			}
		}
		else{
			$data['content'] = $this->load->view('startuplist/register', $data, true);
			$this->load->view('startuplist/main', $data);
		}
	}
	
	
	function userlogin(){
		if($_SESSION['web_user']){
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."account");
			exit();
		}
		if($_POST){
			//echo "<pre>";
			//print_r($_POST);
			//print_r($_SESSION);
			foreach($_POST as $key=>$value){
				$_POST[$key] = trim($value);
			}
			$err = false;
			$sql = "select * from `web_users` where 
				lower(`email`)=".$this->db->escape(strtolower($_POST['email']));
			
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			
			if(!$web_user['id']){
				$err = true;
				?>
				alertX("The E-mail is not yet registered.");
				<?php
			}
			else if(md5($_POST['password'])!=$web_user['password']){
				$err = true;
				?>
				alertX("Invalid E-mail and password combination.");
				<?php
			}
			
			if($err){
				?>
				jQuery("#loginbutton").show();
				jQuery("#logging").hide();
				<?php
			}
			else{
				$_SESSION['web_user'] = $web_user;
				if($_GET['ref']){
					?>
					self.location = "<?php echo urldecode($_GET['ref']); ?>";
					<?php
				}
				else{
					?>
					self.location = "<?php echo site_url(); ?>account";
					<?php
				}
			}
		}
		else{
			$data = array();
			$data['layout2'] = true;
			$data['content'] = $this->load->view('startuplist/userlogin', $data, true);
			$this->load->view('startuplist/main', $data);
		}
	}
	
	function forgotpass(){
		$emailto = strtolower(trim($_POST['email']));
		if($emailto){
			$sql = "select `id`, `name` from `web_users` where lower(`email`)='".mysql_real_escape_string($emailto)."'";
			$q = $this->db->query($sql);
			$account = $q->result_array();
			if($account[0]['id']){ //if account exists
				//create token
				$token = md5(microtime());
				$sql = "insert into `changepass_tokens` set 
					`web_user_id` = '".$account[0]['id']."',
					`token` = '".$token."',
					`used` = 0,
					`dateadded_ts` = -1,
					`dateadded` = NOW()
				";
				$this->db->query($sql);
				
				//send email
				$from = "mailer@startuplist.sg";
				$fromname = "E27 Startup List";
				$to = $emailto;
				$toname = $account[0]['name'];
				$emailtos = array();
				$email = array();
				$email['email'] = $to;
				$email['name'] = $toname;
				$emailtos[] = $email;
				$subject = "E27 Startup List Password Change";
				$passlink = site_url()."changepass/".$token;
				$template = array();
				$template['data'] = array();
				$template['data']['name'] = $toname;
				$template['data']['passlink'] = $passlink ;
				$template['data']['passlinkhere'] = "<a href='".$template['data']['passlink']."'>here</a>";
				//$template['data'] = json_encode($template['data']);
				$template['slug'] = "startuplist-forgot-password"; 
				send_email($from, $fromname, $emailtos, $subject, $message, $template); //mandrill
				//$this->sendChangePassLink($from, $fromname, $to, $toname, $subject, $passlink); //smtp
				?>
				jQuery("#anemail").html("An E-mail has been sent to <?php echo $emailto; ?>. ");
				jQuery("#anemail").show();
				jQuery("#forgotpassform").hide();
				jQuery("#femail").val("");
				jQuery("#forgotpassbutton").show();
				jQuery("#forgotpassing").hide();
				<?php
			}
			else{
				?>
				alertX("The E-mail supplied is not yet registered.");
				jQuery("#forgotpassbutton").show();
				jQuery("#forgotpassing").hide();
				<?php
			}
		}
		else{
			$data['layout2'] = true;
			$data['content'] = $this->load->view('startuplist/forgotpass', $data, true);
			$this->load->view('startuplist/main', $data);
		}
	}
	
	function testemail(){
		$from = "mailer@startuplist.sg";
		$fromname = "E27 Startup List";
		$to = "jairus@nmgresources.ph";
		$toname = "Jairus Bondoc";
		$emailtos = array();
		$email = array();
		$email['email'] = $to;
		$email['name'] = $toname;
		$emailtos[] = $email;
		$subject = "test email 4";
		$template = array();
		$template['data'] = array();
		$template['data']['name'] = $toname;
		$template['data']['passlink'] = "http://e27.sg";
		$template['data']['passlinkhere'] = "<a href='".$template['data']['passlink']."'>here</a>";
		//$template['data'] = json_encode($template['data']);
		$template['slug'] = "startuplist-forgot-password"; 
		
		send_email($from, $fromname, $emailtos, $subject, $message, $template);
	}
	
	function sendChangePassLink($from, $fromname, $to, $toname, $subject, $passlink){
		$message = '
		<table style="width:100%; height: 100%; background:#fafafa">
			<tr>
				<td style="text-align:center; vertical-align:top; padding:20px;">
					<table style="width:500px; background:#ffffff; margin:auto">
						<tr>
							<td style="text-align:center; padding:20px;">';
	
	//$message .= '<img src="data:image/png;base64,'.base64_encode(file_get_contents(dirname(__FILE__)."/../../media/startuplist/startuplist_email.png")).'" />';
	$message .= '<img src="'.site_url().'media/startuplist/startuplist_email.png" />';
	
	$message .= '</td>
						</tr>
						<tr>
						   <td style="text-align:left; vertical-align:top; padding:20px; font-family:Arial, Helvetica, sans-serif; font-size:12px">
							<b>Hello '.$toname.',</b>
							<br>
							<br>
							To change your password please click <a href="'.$passlink.'" target="_blank">here</a> or visit the link below;<br>
							<br>
							'.$passlink.'
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
		
		$bouncereturn = $from; //where the email will forward in cases of bounced email
		$emails = array();
		$emails[0]['email'] = $to;
		$emails[0]['name'] = $toname;
		emailBlast($from, $fromname, $subject, $message, $emails, $bouncereturn, 0); //last parameter for running debug
	}
	
	function changepass($token=""){
		if($_POST){
			$err = false;
			if(!trim($_POST['password'])){
				$err = true;
				?>
				alertX("Please input a Password!");
				jQuery('input[name="password"]').css({border:"1px solid red"});
				<?php
			}
			else if($_POST['password']!=$_POST['repassword']){
				$err = true;
				?>
				alertX("Password and Confirm Password don't match!");
				jQuery('input[name="password"]').css({border:"1px solid red"});
				jQuery('input[name="repassword"]').css({border:"1px solid red"});
				<?php
			}
			if($err){
				?>
				jQuery("#changepassbutton").show();
				jQuery("#changepassing").hide();
				<?php
			}
			else{
				//print_r($_SESSION['changepass_user']);
				$sql = "update `web_users` set 
					`password`='".md5(trim($_POST['password']))."',
					`plain_password`='".trim($_POST['password'])."'
					where 
					`id` = '".$_SESSION['changepass_user']['id']."'
				";
				$this->db->query($sql);
				
				$sql = "update `changepass_tokens` set 
					`used`='1'
					 where `token`='".mysql_real_escape_string($_SESSION['changepass_user']['token'])."'
				";
				$this->db->query($sql);
				
				?>
				jQuery("#youmay").html("Your Password has been updated. Please click <a href='<?php echo site_url(); ?>userlogin?email=<?php echo $_SESSION['changepass_user']['email']; ?>'>here</a> to login.");
				jQuery("#youmay").show();
				jQuery("#changepassform").hide();
				<?php
				unset($_SESSION['changepass_user']);
			}
		}
		else if(trim($token)){
			$sql = "update `changepass_tokens` set 
				`dateadded_ts`=".time()."
				 where 
				 `token`='".mysql_real_escape_string(trim($token))."' and
				 `dateadded_ts`=-1
			";
			$this->db->query($sql);
			
			$sql = "select * from `changepass_tokens` where `token`='".mysql_real_escape_string($token)."' and `used`=0 and (`dateadded_ts`+".(10*60).")>=".time(); //person have 10 mins to change password otherwise it will expire
			$q = $this->db->query($sql);
			$token = $q->result_array();
			$token = $token[0];
			$sql = "select * from `web_users` where `id`='".$token['web_user_id']."'";
			$q = $this->db->query($sql);
			$changepass_user = $q->result_array();
			$changepass_user = $changepass_user[0];
			$_SESSION['changepass_user'] = $changepass_user;
			//echo "<pre>";
			//print_r($token);
			if($_SESSION['changepass_user']['id']){
				$_SESSION['changepass_user']['token'] = $token['token'];
				$data['changepass_user'] = $_SESSION['changepass_user'];
				$data['layout2'] = true;
				$data['content'] = $this->load->view('startuplist/changepass', $data, true);
				$this->load->view('startuplist/main', $data);
			}
			else{
				$data['layout2'] = true;
				$data['content'] = $this->load->view('startuplist/changepass', $data, true);
				$this->load->view('startuplist/main', $data);
			}
			
		}
	}
	
	function account($userid=""){
		$data = array();
		if($_SERVER['HTTP_HOST']=='localhost'&&!$_SESSION['web_user']){
			$_SESSION['web_user'] = unserialize('a:7:{s:2:"id";s:1:"5";s:5:"fb_id";s:15:"100004077843297";s:8:"fb_email";s:21:"the_sniglet@yahoo.com";s:7:"fb_data";s:284:"{"id":"100004077843297","name":"Jerome Lee","first_name":"Jerome","last_name":"Lee","link":"http://www.facebook.com/jerome.lee.98892","username":"jerome.lee.98892","gender":"male","email":"the_sniglet@yahoo.com","timezone":8,"locale":"en_US","updated_time":"2012-07-11T10:27:49 0000"}";s:10:"fb_friends";s:1316:"{"data":[{"name":"Sasha Fox","id":"100000505245095"},{"name":"Mikee Dela Peña Guarino","id":"100000629589263"},{"name":"Carla Villa","id":"100000851593945"},{"name":"Faye Santos","id":"100002110669999"},{"name":"Romnick Edullantes","id":"100002143982649"},{"name":"Szophisticated Rhoze Genuiztah","id":"100002518556374"},{"name":"Ingrid Mendoza Rivera","id":"100002938532983"},{"name":"Rendell Paulo","id":"100002974236892"},{"name":"Jeany Masangkay","id":"100003194877986"},{"name":"Muniquinn Doll","id":"100003516535179"},{"name":"Shäina Rose Besa IV","id":"100003549304942"},{"name":"Shiela Marie Echavez","id":"100003569125646"},{"name":"Yandii Olid III","id":"100003574885667"},{"name":"Jullian Delrosario","id":"100003588335313"},{"name":"Lyra Farro","id":"100004101694332"},{"name":"Marjorie Orbase","id":"100004191425468"},{"name":"Junaina Gon","id":"100004307443721"},{"name":"Samantha Moh","id":"100004431932704"},{"name":"Ann Sarap","id":"100004483902375"},{"name":"Ganda MaLdita","id":"100004629572460"},{"name":"Mahal Khani Khate","id":"100004682401219"},{"name":"Arnie Samonte","id":"100004688465647"}],"paging":{"next":"https://graph.facebook.com/100004077843297/friends?access_token=AAAB7W3LmGYIBACvqZCfHc5VqzaN0QlzmQ657WBhjDEvgojWZCyUBgnSfVScl6vaTdcaQKOhrAMemv97aVsM2YFQPXU8ypwmqdB3P1q3kvuPVc5RNX8";s:9:"dateadded";s:19:"2012-12-04 14:21:52";s:11:"dateupdated";s:19:"2012-12-06 13:20:50";}');
		}
		if(!$_SESSION['web_user']&&!$_SESSION['user']){
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url());
			exit();
		}
		if(!$userid){
			$userid = $_SESSION['web_user']['id'];
		}
		if($userid){
			$sql = "select * from `web_users` where `id`='".mysql_real_escape_string($userid)."'";
			$q = $this->db->query($sql);
			$web_user = $q->result_array();
			$web_user = $web_user[0];
			if($web_user['id']){
				$data['user'] = getWebUser($web_user);
			}
		}
		
		
		
		
		$sql = "select * from `revisions` where `web_user_id`='".mysql_real_escape_string($web_user['id'])."' order by `dateupdated_ts` desc limit 20";
		$q = $this->db->query($sql);
		$revisions = $q->result_array();
		$data['revisions'] = $revisions;
		
		$sql = "select * from `contributions` where `web_user_id`='".mysql_real_escape_string($web_user['id'])."' order by `dateupdated_ts` desc limit 20";
		$q = $this->db->query($sql);
		$contributions = $q->result_array();
		$data['contributions'] = $contributions;
		
		$data['content'] = $this->load->view('startuplist/account', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function editcompany($companyid="", $part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$data = array();
		$data = $this->company("", $companyid, true);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		if($part=='revisions'){
			$sql = "select * from `revisions` where `table`='companies' and `ipc_id`='".mysql_real_escape_string($companyid)."' order by `dateupdated_ts` desc";
			$q = $this->db->query($sql);
			$revisions = $q->result_array();
		}
		$data['revisions'] = $revisions;
		$data['data'] = $data;
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editcompany', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function editperson($personid="", $part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$data = array();
		$data = $this->person("", $personid, true);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		if($part=='revisions'){
			$sql = "select * from `revisions` where `table`='people' and `ipc_id`='".mysql_real_escape_string($personid)."' order by `dateupdated_ts` desc";
			$q = $this->db->query($sql);
			$revisions = $q->result_array();
		}
		$data['revisions'] = $revisions;
		$data['data'] = $data;
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editperson', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function editinvestment_org($investment_orgid="", $part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$data = array();
		$data = $this->investment_org("", $investment_orgid, true);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		if($part=='revisions'){
			$sql = "select * from `revisions` where `table`='investment_orgs' and `ipc_id`='".mysql_real_escape_string($investment_orgid)."' order by `dateupdated_ts` desc";
			$q = $this->db->query($sql);
			$revisions = $q->result_array();
		}
		$data['revisions'] = $revisions;
		$data['data'] = $data;
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editinvestment_org', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function addcompany($part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$sql = "select * from `categories`";
		$q = $this->db->query($sql);
		$categories = $q->result_array();	
		$sql = "select * from `countries`";
		$q = $this->db->query($sql);
		$countries = $q->result_array();
		$sql = "select distinct `code`, `currency` from `currencies` where `currency` not like 'uses%'";
		$q = $this->db->query($sql);
		$currencies = $q->result_array();
		$sql = "select * from `funding_rounds`";
		$q = $this->db->query($sql);
		$funding_rounds = $q->result_array();
			
		$data = array();
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		$data['categories'] = $categories;
		$data['countries'] = $countries;
		$data['currencies'] = $currencies;
		$data['funding_rounds'] = $funding_rounds;
		
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editcompany', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function addperson($part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$sql = "select * from `countries`";
		$q = $this->db->query($sql);
		$countries = $q->result_array();
		$sql = "select distinct `code`, `currency` from `currencies` where `currency` not like 'uses%'";
		$q = $this->db->query($sql);
		$currencies = $q->result_array();
			
		$data = array();
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		$data['categories'] = $categories;
		$data['countries'] = $countries;
		$data['currencies'] = $currencies;
		$data['funding_rounds'] = $funding_rounds;
		
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editperson', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function addinvestment_org($part=""){
		if(!$_SESSION['web_user']){
			$ref = urlencode(site_url().ltrim($_SERVER['REQUEST_URI'],"/"));
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."userlogin/?ref=".$ref);
			exit();
		}
		$sql = "select * from `categories`";
		$q = $this->db->query($sql);
		$categories = $q->result_array();	
		$sql = "select * from `countries`";
		$q = $this->db->query($sql);
		$countries = $q->result_array();
		$sql = "select distinct `code`, `currency` from `currencies` where `currency` not like 'uses%'";
		$q = $this->db->query($sql);
		$currencies = $q->result_array();
		$sql = "select * from `funding_rounds`";
		$q = $this->db->query($sql);
		$funding_rounds = $q->result_array();
			
		$data = array();
		$data['categories'] = $categories;
		$data['countries'] = $countries;
		$data['currencies'] = $currencies;
		$data['funding_rounds'] = $funding_rounds;
		
		$data['part'] = $part;
		$data['layout2'] = true;
		$data['content'] = $this->load->view('startuplist/editinvestment_org', $data, true);
		$this->load->view('startuplist/main', $data);
	}
	
	function getAccountKarma($id){
		$goodkarma = 0;
		$badkarma = 0;
		$pending = 0;
		
		$sql = "select count(`id`) as `cnt` from `revisions` where `approved`=1 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$goodkarma += $cnt[0]['cnt'];
		
		$sql = "select count(`id`) as `cnt` from `contributions` where `approved`=1 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$goodkarma += $cnt[0]['cnt'];
		
		$sql = "select count(`id`) as `cnt` from `revisions` where `approved`=-1 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$badkarma += $cnt[0]['cnt'];
		
		$sql = "select count(`id`) as `cnt` from `contributions` where `approved`=-1 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$badkarma += $cnt[0]['cnt'];
		
		$sql = "select count(`id`) as `cnt` from `revisions` where `approved`=-0 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$pending += $cnt[0]['cnt'];
		
		$sql = "select count(`id`) as `cnt` from `contributions` where `approved`=0 and `web_user_id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$cnt = $q->result_array();	
		$pending += $cnt[0]['cnt'];
		
		$r = array();
		$r['approved'] = $goodkarma;
		$r['rejected'] = $badkarma;
		$r['pending'] = $pending;
		return $r;
	}
	
	
	
	
}





















