<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrators extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function create($email, $password, $name)
    {
    	$salt=rand(10000,99999);
    	
    	$email=strtolower($email);
    
		$data = array(
					'email' => $email,
					'password' => md5($password.$salt),
					'salt' => $salt,
					'name' => $name,
					'status' => 'active'
				);
    
    	$this->db->insert('administrators', $data); 
        
        return true;
    }
    
    function update($id, $email, $password, $name)
    {
    	$email=strtolower($email);
    
    	$data = array(
					'email' => $email,
					'name' => $name
				);
		
		// Retrieve salt and process password change if not empty
		if(!empty($password))
		{
			$query = $this->db->get_where('administrators', array('id'=>$id, 'status'=>'active'));
			$row=$query->row();
			
			$password=md5($password.$row->salt);
			$data['password']=$password;
		}
    	
    	$this->db->where('id', $id);
    	$this->db->update('administrators', $data); 
        
        return true;
    }
    
    function delete($id)
    {
    	$this->db->where('id', $id);
    	$this->db->update('administrators', array('status' => 'deleted')); 
    	
    	return true;
    }
    
    function authenticate($email, $password)
    {
    	$email=strtolower($email);
    
    	$query = $this->db->get_where('administrators', array('email'=>$email, 'status'=>'active'));

    	if ($query->num_rows() > 0)
    	{
    		$row=$query->row();
    		$password=md5($password.$row->salt);
    		
    		$query = $this->db->get_where('administrators', array('email'=>$email, 'status'=>'active', 'password'=>$password));
    		
    		if ($query->num_rows() > 0)
    		{
    			$data=array('last_login'=>date('Y-m-d H:i:s'), 'last_login_ip'=>$this->input->ip_address());
    		
    			$this->db->where('id', $row->id);
    			$this->db->update('administrators', $data); 
    	
    			return $row->id;
    		}
    		else
    			return false;
    	}
    	
    	return false;
    }
    
    function get_name($id)
    {
    	$query = $this->db->get_where('administrators', array('id'=>$id, 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		$row=$query->row();
    		return $row->name;
    	}
    	
    	return false;
    }
    
    function get_all()
    {
    	$query = $this->db->get_where('administrators', array('status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->result_array();
    	}
    	
    	return false;
    }
    
    function get_user($id)
    {
    	$query = $this->db->get_where('administrators', array('id'=>$id, 'status'=>'active'));
    	
    	if ($query->num_rows() > 0)
    	{
    		return $query->row_array();
    	}
    	
    	return false;
    }

}

/* End of file administrators.php */
/* Location: ./application/models/administrators.php */