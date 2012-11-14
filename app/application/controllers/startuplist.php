<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
class startuplist extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
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
			$html = $this->load->view("startuplist/company_block", $data, true);
			$html = str_replace("\n", "", $html);
			$html = str_replace("\r", "", $html);
			$companies[$i]['html'] = $html;
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
		while(htmls[htmli]){
			html = "<tr>";
			for(i=0; i<4; i++){
				html += "<td width='25%'>";
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
	
	function company($name="", $id=""){
		
	}
}
