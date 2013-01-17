<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Giveaways extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all()
    {
    	$query = $this->db->query("SELECT * FROM giveaways WHERE status='active' ORDER BY title ASC");

    	if ($query->num_rows() > 0)
    	{
    		$data=array();
    		$i=0;
    		
    		foreach($query->result_array() AS $row)
    		{
    			$data[$i]=$row;
    			
    			$leader=$this->get_leader($row['id']);
    			
    			if(!empty($leader))
    			{
    				$data[$i]['leader']=$leader['first_name'].' '.$leader['last_name'];
    				$data[$i]['signups']=$leader['signups'];
    				$data[$i]['visits']=$leader['visits'];
    			}
    			
    			$i++;
    		}
    		
    		return $data;
    	}
    	
    	return false;
    }
    
    function get_giveaway($id)
    {
    	$query = $this->db->get_where('giveaways', array('id'=>$id, 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function get_by_permalink($permalink)
    {
    	$query = $this->db->get_where('giveaways', array('permalink'=>strtolower($permalink), 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function get_stats($id)
    {
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$id' and status='active'");
    	
    	$stats['total_signups']=$query->num_rows();
    	
    	$query = $this->db->query("SELECT * FROM logs WHERE giveaway_id='$id' GROUP BY session_id ");
    	
    	$stats['total_visits']=$query->num_rows();
    	
    	return $stats;
    }
    
    function get_registrations($id)
    {
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$id' and status='active' ORDER BY signups DESC");
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->result_array();
    	}
    	
    	return false;
    }
    
    function get_registration($id)
    {
    	$query = $this->db->query("SELECT * FROM registrations WHERE id='$id' and status='active' LIMIT 1");
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function get_registration_by_email($email,$giveaway_id)
    {
    	$email=strtolower($email);
    
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$giveaway_id' AND email='$email' and status='active' LIMIT 1");
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function get_registration_rank($email, $giveaway_id)
    {
    	$email=strtolower($email);
    
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$giveaway_id' and status='active' ORDER BY signups DESC");
    	
    	if ($query->num_rows() > 0)
    	{
    		$i=1;
    		
    		foreach($query->result_array() as $row)
    		{
    			if($row['email']==$email)
    				break;
    			else
    				$i++;
    		}
    		
    		return $i;
    	}
    	
    	return false;
    	
    }
    
    function get_winner($giveaway_id)
    {
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$giveaway_id' and status='active' ORDER BY signups DESC LIMIT 1");
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function register($giveaway_id,$referral_id,$email)
    {
    	$email=strtolower($email);
    
    	$data = array(
    			'giveaway_id' => $giveaway_id,
    			'referral_id' => $referral_id,
    			'email' => $email,
    			'created_on' => date( 'Y-m-d H:i:s' ),
    			'unique_code' =>md5($email.$giveaway_id.time().rand(0,999)),
    			'status' => 'active'
    		);
    		
    	$this->db->insert('registrations', $data); 
    	
    	return  $this->db->insert_id() ;
    }
    
    function update_registration($id, $first_name,$last_name,$company,$title,$profile)
    {
    	if(is_array($profile))
	    	$profile=implode(', ',$profile);
	    	
	    if(empty($profile))
	    	$profile=" ";
    	
    	$data = array(
    			'first_name'=>$first_name,
    			'last_name'=>$last_name,
    			'company'=>$company,
    			'title'=>$title,
    			'profile'=>$profile
    		);
    	
    	$this->db->where('id', $id);
    	$this->db->update('registrations', $data); 
    	
    	return true;
    }
    
    function add_visit($referral_code)
    {
    	$this->db->query("UPDATE registrations SET visits = visits+1 WHERE unique_code = '$referral_code'");
    	
    	return true;
    }
    
    function add_signup($referral_code)
    {
    	$this->db->query("UPDATE registrations SET signups = signups+1 WHERE unique_code = '$referral_code'");
    	
    	return true;
    }
    
    function get_leader($id)
    {
    	$query = $this->db->query("SELECT * FROM registrations WHERE giveaway_id='$id' and status='active' ORDER BY signups DESC LIMIT 1");
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }
    
    function create($title,$start_date,$end_date,$question,$answer,$invalid_answer_1,$invalid_answer_2,$banner_file,$description,$legal,$admin_notes)
    {
    	$start_date=substr($start_date,6,4).'-'.substr($start_date,3,2).'-'.substr($start_date,0,2);
    	$end_date=substr($end_date,6,4).'-'.substr($end_date,3,2).'-'.substr($end_date,0,2);
    
    
		$permalink=url_title($title);
    	$query = $this->db->get_where('giveaways', array('permalink'=>$permalink, 'status'=>'active'));
		
		$i=0;
    	while ($query->num_rows() > 0)
    	{
    		$i++;
    		$permalink=url_title($title)."-".$i;
    		$query = $this->db->get_where('giveaways', array('permalink'=>$permalink, 'status'=>'active'));
    	}
    
    	$data = array(
    			'permalink' => strtolower($permalink),
    			'title' => $title,
    			'start_date' => $start_date,
    			'end_date' => $end_date,
    			'question' => $question,
    			'answer' => $answer,
    			'invalid_answer_1' => $invalid_answer_1,
    			'invalid_answer_2' => $invalid_answer_2,
    			'banner_file' => $banner_file,
    			'description' => $description,
    			'legal' => $legal,
    			'admin_notes' => $admin_notes,
    			'status' => 'active'
    		);
    		
    	$this->db->insert('giveaways', $data); 
    	
    	return true;
    }
    
    function update($id,$start_date,$end_date,$question,$answer,$invalid_answer_1,$invalid_answer_2,$banner_file,$description,$legal,$admin_notes)
    {
    	$start_date=substr($start_date,6,4).'-'.substr($start_date,3,2).'-'.substr($start_date,0,2);
    	$end_date=substr($end_date,6,4).'-'.substr($end_date,3,2).'-'.substr($end_date,0,2);
    
    	$data = array(
    			'start_date' => $start_date,
    			'end_date' => $end_date,
    			'question' => $question,
    			'answer' => $answer,
    			'invalid_answer_1' => $invalid_answer_1,
    			'invalid_answer_2' => $invalid_answer_2,
    			'description' => $description,
    			'legal' => $legal,
    			'admin_notes' => $admin_notes,
    			'status' => 'active'
    		);
    		
    	if(!empty($banner_file))
    		$data['banner_file']=$banner_file;
    	
    	$this->db->where('id', $id);
    	$this->db->update('giveaways', $data); 
    	
    	return true;
    }

    
    function delete($id)
    {
    	$this->db->where('id', $id);
    	$this->db->update('giveaways', array('status' => 'deleted')); 
    	
    	return true;
    }
    
    function delete_registration($id)
    {
    	$this->db->where('id', $id);
    	$this->db->update('registrations', array('status' => 'deleted')); 
    	
    	return true;
    }
    
    function check_answer($id,$answer)
    {
    	$query = $this->db->get_where('giveaways', array('id'=>$id, 'answer'=>$answer, 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return true;
    	}
    	
    	return false;
    }
    
    function check_email($id,$email)
    {
    	$email=strtolower($email);
    
    	$query = $this->db->get_where('registrations', array('giveaway_id'=>$id, 'email'=>$email, 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return true;
    	}
    	
    	return false;
    }

}

/* End of file giveaways.php */
/* Location: ./application/models/giveaways.php */