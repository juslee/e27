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
				lower(`fb_email`) like '%".mysql_real_escape_string(strtolower($search))."%' or 
				lower(`in_name`) like '%".mysql_real_escape_string(strtolower($search))."%' or
				lower(`business_email`) like '%".mysql_real_escape_string(strtolower($search))."%'
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

	public function editwebuser($id){
		$sql = "select * from `web_users` where `id`='".mysql_real_escape_string($id)."'";
		$q = $this->db->query($sql);
		$web_user = $q->result_array();
		$web_user = $web_user[0];
		if($web_user['id']){
			$data['web_user'] = $web_user;
			$data['content'] = $this->load->view('webusers/edit', $data, true);
			$this->load->view('layout/main', $data);
		}
		else{
			header ('HTTP/1.1 301 Moved Permanently');
			header("Location: ".site_url()."webusers");
			exit();
		}
	}
	
	public function ajax_editwebuser(){
		if(!$_SESSION['user']){
			return false;
		}
		$sqlvalues = "";
		$vals = array();
		foreach($_POST as $key=>$value){
			if($key=='password'){
				$vals[] = " `".$key."` = '".mysql_real_escape_string(md5($value))."' ";
				$vals[] = " `plain_password` = '".mysql_real_escape_string(($value))."' ";
			}
			else{
				$vals[] = " `".$key."` = '".mysql_real_escape_string($value)."' ";
			}
		}
		$sqlvalues = implode(", ", $vals);
		
		$sql = "update `web_users` set $sqlvalues where `id`='".mysql_real_escape_string($_GET['id'])."'";
		$q = $this->db->query($sql);
		?>
		alertX("Successfully updated web user.");
		jQuery("#savebutton").val("Save");
		jQuery("#webuser_form *").attr("disabled", false);
		<?php
	}
	
	function sendWelcome(){
		/*
		$sql = "select * from `web_users` where `id`='".$userid."'";
		$q = $this->db->query($sql);
		$web_user = $q->result_array();
		$web_user = $web_user[0];
		$user = getWebUser($web_user);
		
		$name = $user['name'];
		$zemail = trim(strtolower($web_user['email']));
		$business_email = trim(strtolower($web_user['business_email']));
		$fb_email = trim(strtolower($web_user['fb_email']));
		$emails = array();
		if($zemail){
			if(!in_array($zemail, $emails)){
				$email = array();
				$email['name'] = $name;
				$email['email'] = $zemail;
				$emailtos[] = $email;
				$emails[] = $zemail;
			}
			
		}
		if($business_email){
			if(!in_array($business_email, $emails)){
				$email = array();
				$email['name'] = $name;
				$email['email'] = $business_email;
				$emailtos[] = $email;
				$emails[] = $business_email;
			}
		}
		if($fb_email){
			if(!in_array($fb_email, $emails)){
				$email = array();
				$email['name'] = $name;
				$email['email'] = $fb_email;
				$emailtos[] = $email;
				$emails[] = $fb_email;
			}
		}
		*/
		
		
		/*test send*/
		$emailtos = array();
		

		$email = array();
		$email['name'] = "jairus@e27.sg";
		$email['email'] = "jairus@e27.sg";
		$emailtos[] = $email;

		/*
		$email = array();
		$email['name'] = "mohan@e27.sg";
		$email['email'] = "mohan@e27.sg";
		$emailtos[] = $email;
		*/
		echo "Nothing here last log 20130124_1737.htm last id 586";
		exit();
		$sql = "select `id`, `name`, `email_address`, `slug`, status, active from `companies` where id>586 order by `id` asc limit 50";
		$q = $this->db->query($sql);
		$companies = $q->result_array();
		$t = count($companies);
		for($i=0; $i<$t; $i++){
			$emailtos = array();
			$email = array();
			
			
			$email['name'] = $companies[$i]['name'];
			$email['email'] = $companies[$i]['email_address'];
			$emailtos[] = $email;
			
			//skip of no email
			if(
				trim(strtolower($companies[$i]['email_address']))==""||
				trim(strtolower($companies[$i]['email_address']))=="closed@closed.com" ||
				trim(strtolower($companies[$i]['email_address']))=="unknown@unknown.com"
			){
				echo "<pre>";
				//echo $from, "\n", $fromname, "\n", print_r($emailtos, 1), "\n", $subject, "\n", $message, "\n", print_r($template, 1), "\n";
				echo $companies[$i]['id']."\n";
				echo print_r($emailtos, 1);
				echo "skipped";
				echo "</pre>";
				echo "<hr>";
				continue;
			}
			
			
			
			
			if(count($emailtos)){
				$from = "feedback@27x.co";
				$fromname = "27x";
				$to = $user['email'];
				if(!$to){
					$to = $user['business_email'];
				}
				$subject = "[e27] Sneak peek of 27x (formerly Startuplist)";
				$template = array();
				$template['data'] = array();
				$template['data']['name'] = $toname;
				/*
				$template['data']['content'] = "Hi $name,
	
				Welcome to 27x Startup List.
				
				You are now able to edit and create company and people profiles with your user account.  Other users will be able to see that you're the contributor who made these edits. Please note that all edits and contributions are still subjected to admin approval to ensure the accuracy of the data.
				
				Thanks and hope to see your contribution on StartupList.
				
				- 27x Team
				<a href='http://27x.co'>27x.co</a>
				";
				*/
				$email_content = "Hi ".$companies[$i]['name'].",
				
	We recently rebuilt Startuplist and we're excited to give you a sneak peek since your company was previously listed.
	
	Here's the link to your company profile: 
	
	<a href='http://27x.co/company/".$companies[$i]['slug']."'>http://27x.co/company/".$companies[$i]['slug']."</a>
	
	Could you do us a favour and please verify that all the information about your company is correct? You can add and edit the information if something is not right. 
	
	We are going to be launching the site soon, and Investors/partners around the region will be looking at this content on a regular basis to discover interesting companies to invest in and to work with. 
	
	It won't look good on both of us if the information is incorrect or incomplete. 
	
	The content in 27x will form the basis of all our information for startups/investors/incubators in the region. So you're bound to get some exposure from it, and we will be heavily pushing it in the near future.
	
	We are open to feedback as well, if you have any suggestions for improvements, let me know!
	
	Thanks so much for your support.
					
					- 27x Team
					(part of e27)
					<a href='http://27x.co'>27x.co</a>
					";
				$template['data']['content'] = $email_content;
				$template['data']['content'] = nl2br($template['data']['content']);
				
				//$template['data'] = json_encode($template['data']);
				$template['slug'] = "startuplist-wrap"; 
				send_email($from, $fromname, $emailtos, $subject, $message, $template);
				
				//sleep(1);
				echo "<pre>";
				//echo $from, "\n", $fromname, "\n", print_r($emailtos, 1), "\n", $subject, "\n", $message, "\n", print_r($template, 1), "\n";
				echo $companies[$i]['id']."\n";
				echo print_r($emailtos, 1);
				echo "</pre>";
				echo "<hr>";
				//flush();
			}
		}
		
	}
	
	
}
