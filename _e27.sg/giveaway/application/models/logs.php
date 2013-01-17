<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
 	function log_visit($ip_address, $user_agent, $http_referrer, $page_visited, $session_id, $giveaway_id, $giveaway_referrer)
 	{
 	
 		$data = array(
    			'ip_address'=>$ip_address,
    			'user_agent'=>$user_agent,
    			'http_referrer'=>$http_referrer,
    			'page_visited'=>$page_visited,
    			'session_id'=>$session_id,
    			'giveaway_id'=>$giveaway_id,
    			'giveaway_referrer'=>$giveaway_referrer,
    			'created_on'=>date( 'Y-m-d H:i:s' )
    		);
    		
    	$this->db->insert('logs', $data); 
    	
    	return true;

 	}
 	
 	function get_log($ip, $session_id)
 	{
 		$query = $this->db->get_where('logs', array('ip_address'=>$ip, 'session_id'=>$session_id));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
 	}
}

/* End of file logs.php */
/* Location: ./application/models/logs.php */