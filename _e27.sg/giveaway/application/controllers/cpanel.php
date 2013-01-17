<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel extends CI_Controller {

	protected $data;

	public function __construct()
    {
		parent::__construct();
		
		// Load models
		$this->load->model('administrators');
		$this->load->model('giveaways');
        
        $this->data = array(
					'user_id' => $this->session->userdata('user_id'),
					'website_title' => 'E27 Giveaway Engine',
					'user_name' => $this->administrators->get_name($this->session->userdata('user_id')),
					'breadcrumbs' => '',
					'content' => ''
				);
    }
       
	public function index()
	{
		// Define variables
		$email="";
		$error_message="";
	
		// Logout user if already logged in
		if($this->session->userdata('user_id')!='')
		{
			$this->session->unset_userdata(array('user_id'=>''));
		}
		
		// Process authentication if login form is posted
		if($_POST)
		{
			$this->load->helper('email');
			
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			
			if(valid_email($email))
			{
				if($user_id=$this->administrators->authenticate($email,$password))
				{
					$this->session->set_userdata(array('user_id'=>$user_id));
					redirect('cpanel/giveaways');
				}
				else
					$error_message="Invalid email and/or password. Please try again.";
			}
			else
			{
				$error_message="Please enter a valid email address.";
			}
		}
		
		// Set view variables
		$this->data['email']=$email;
		$this->data['error_message']=$error_message;
		
		// Load view
		$this->load->view('cpanel/login', $this->data);
		
	}
	
	// Display all giveaways
	public function giveaways()
	{
		// Check if user is logged in
		$this->check_login();
	
		// Set view variables
		$this->data['breadcrumbs']='Manage Giveaways';
		$data=array('giveaways'=>$this->giveaways->get_all(),'message_id'=> $this->uri->segment(3));
		
		// Load view
		$this->data['content']=$this->load->view('cpanel/giveaways', $data, true);
		$this->load->view('cpanel/theme', $this->data);
	}
	
	// Create a new giveaway
	public function create_giveaway()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Set file upload restrictions
		$config['upload_path'] = 'banners/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '2000';
		$config['max_height'] = '1000';
		$config['file_name'] = '';
		$config['is_image'] = '1';
		
		// Load required libraries
		$this->load->library('form_validation');
		$this->load->library('upload', $config);

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$this->form_validation->set_rules('invalid_answer_1', 'Invalid Answer #1', 'trim|required');
		$this->form_validation->set_rules('invalid_answer_2', 'Invalid Answer #2', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		
		if ($this->form_validation->run() == FALSE || !$this->upload->do_upload('banner'))
		{
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/giveaways').'">Giveaways</a> \ Create';
			$data=array('upload_errors'=>$this->upload->display_errors());	
			// Load view
			$this->data['content']=$this->load->view('cpanel/giveaways_create', $data, true);
			$this->load->view('cpanel/theme', $this->data);
		}
		else
		{	
			$upload_data=$this->upload->data();
			$banner_file=$upload_data['file_name'];
			
			$this->giveaways->create(
									$this->input->post('title'),
									$this->input->post('start_date'),
									$this->input->post('end_date'),
									$this->input->post('question'),
									$this->input->post('answer'),
									$this->input->post('invalid_answer_1'),
									$this->input->post('invalid_answer_2'),
									$banner_file,
									$this->input->post('description'),
									$this->input->post('legal'),
									$this->input->post('admin_notes')
								);
								
			redirect('cpanel/giveaways/create_success');
		}
	}
	
	// Giveaway Stats
	public function giveaway_stats()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Set giveaway_id from URI
		$giveaway_id=$this->uri->segment(3);
		
		if(empty($giveaway_id) || !($giveaway_data=$this->giveaways->get_giveaway($giveaway_id)))
			show_404();
		
		$stats=$this->giveaways->get_stats($giveaway_id);
		$registrations=$this->giveaways->get_registrations($giveaway_id);
		
		// Set view variables
		$this->data['breadcrumbs']='<a href="'.site_url('cpanel/giveaways').'">Giveaways</a> \ Stats';
		$data=array('giveaway'=>$giveaway_data,'stats'=>$stats, 'registrations'=>$registrations,'message_id'=> $this->uri->segment(4));
		
		// Load view
		$this->data['content']=$this->load->view('cpanel/giveaways_stats', $data, true);
		$this->load->view('cpanel/theme', $this->data);
		
	}
	
	// Modify giveaway
	public function modify_giveaway()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Set file upload restrictions
		$config['upload_path'] = 'banners/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '2000';
		$config['max_height'] = '1000';
		$config['file_name'] = '';
		$config['is_image'] = '1';
		
		// Load required libraries
		$this->load->library('form_validation');
		$this->load->library('upload', $config);
		
		// Set giveaway_id from URI
		$giveaway_id=$this->uri->segment(3);
		
		if(empty($giveaway_id) || !($giveaway_data=$this->giveaways->get_giveaway($giveaway_id)))
			show_404();
		
		if($this->input->post('submit')=='Delete Giveaway')
		{
			redirect('cpanel/delete_giveaway/'.$giveaway_id);
		}
		else
		{
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
			$this->form_validation->set_rules('question', 'Question', 'trim|required');
			$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
			$this->form_validation->set_rules('invalid_answer_1', 'Invalid Answer #1', 'trim|required');
			$this->form_validation->set_rules('invalid_answer_2', 'Invalid Answer #2', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
		}
		
		if (isset($_FILES['banner']) && $_FILES['banner']['size']!="")
		{
			$file_success=$this->upload->do_upload('banner');
		}
		else
		{
			$file_success=true;
		}
		
		$stats=$this->giveaways->get_stats($giveaway_id);
		$registrations=$this->giveaways->get_registrations($giveaway_id);
	
		if ($this->form_validation->run() == FALSE || !$file_success)
		{
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/giveaways').'">Giveaways</a> \ Modify';
			$data=array('giveaway'=>$giveaway_data,'message_id'=>'');
			
			$data=array(
					'giveaway'=>$giveaway_data,
					'stats'=>$stats, 
					'registrations'=>$registrations, 
					'upload_errors'=>$this->upload->display_errors(), 
					'message_id'=>''
				);
		
			// Load view
			$this->data['content']=$this->load->view('cpanel/giveaways_modify', $data, true);
			$this->load->view('cpanel/theme', $this->data);
		}
		else
		{
			$upload_data=$this->upload->data();
			$banner_file=$upload_data['file_name'];
			
			$this->giveaways->update(
									$giveaway_id,
									$this->input->post('start_date'),
									$this->input->post('end_date'),
									$this->input->post('question'),
									$this->input->post('answer'),
									$this->input->post('invalid_answer_1'),
									$this->input->post('invalid_answer_2'),
									$banner_file,
									$this->input->post('description'),
									$this->input->post('legal'),
									$this->input->post('admin_notes')
								);
								
			$giveaway_data=$this->giveaways->get_giveaway($giveaway_id);
			
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/giveaways').'">Giveaways</a> \ Modify';
			$data=array(
					'giveaway'=>$giveaway_data,
					'stats'=>$stats, 
					'registrations'=>$registrations, 
					'upload_errors'=>'', 
					'message_id'=>'modify_success'
				);
		
			// Load view
			$this->data['content']=$this->load->view('cpanel/giveaways_modify', $data, true);
			$this->load->view('cpanel/theme', $this->data);
		}
	}

	// Delete giveaway
	public function delete_giveaway()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Set user_id from URI
		$giveaway_id=$this->uri->segment(3);
		
		if(empty($giveaway_id) || !($giveaway_data=$this->giveaways->get_giveaway($giveaway_id)))
			show_404();
		
		$this->giveaways->delete($giveaway_id);
		
		redirect('cpanel/giveaways/delete_success');
		
	}
	
	// Delete registration
	public function delete_registration()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Set user_id from URI
		$giveaway_id=$this->uri->segment(3);
		$registration_id=$this->uri->segment(4);
		
		if(empty($giveaway_id) || !($giveaway_data=$this->giveaways->get_giveaway($giveaway_id)))
			show_404();
		
		$this->giveaways->delete_registration($registration_id);
		
		redirect('cpanel/giveaway_stats/'.$giveaway_id.'/delete_success');
		
	}

	// Display all users
	public function users()
	{
		// Check if user is logged in
		$this->check_login();
	
		// Set view variables
		$this->data['breadcrumbs']='Manage Users';
		$data=array('users'=>$this->administrators->get_all(),'message_id'=> $this->uri->segment(3));
		
		// Load view
		$this->data['content']=$this->load->view('cpanel/users', $data, true);
		$this->load->view('cpanel/theme', $this->data);
	}
	
	// Modify user
	public function modify_user()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Set user_id from URI
		$user_id=$this->uri->segment(3);
		
		if(empty($user_id) || !($user_data=$this->administrators->get_user($user_id)))
			show_404();
		
		if($this->input->post('submit')=='Delete User')
		{
			redirect('cpanel/delete_user/'.$user_id);
		}
		else
		{
			$required_if = $this->input->post('password') ? '|required' : '' ;
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]');
			$this->form_validation->set_rules('passwconf', 'Password Confirmation', 'trim'.$required_if.'|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		}
	
		if ($this->form_validation->run() == FALSE)
		{
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/users').'">Users</a> \ Modify';
			$data=array('user'=>$user_data,'message_id'=>'');
		
			// Load view
			$this->data['content']=$this->load->view('cpanel/users_modify', $data, true);
			$this->load->view('cpanel/theme', $this->data);
		}
		else
		{
			$this->administrators->update($user_id,$this->input->post('email'),$this->input->post('password'),$this->input->post('name'));
			$user_data=$this->administrators->get_user($user_id);
			
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/users').'">Users</a> \ Modify';
			$data=array('user'=>$user_data,'message_id'=>'modify_success');
		
			// Load view
			$this->data['content']=$this->load->view('cpanel/users_modify', $data, true);
			$this->load->view('cpanel/theme', $this->data);
		}
	}
	
	// Delete user
	public function delete_user()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Set user_id from URI
		$user_id=$this->uri->segment(3);
		
		if(empty($user_id) || !($user_data=$this->administrators->get_user($user_id)))
			show_404();
		
		$this->administrators->delete($user_id);
		
		if($this->session->userdata('user_id')==$user_id)
			redirect('cpanel');
		else
			redirect('cpanel/users/delete_success');
		
	}
	
	// Create a new user
	public function create_user()
	{
		// Check if user is logged in
		$this->check_login();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('passwconf', 'Password Confirmation', 'trim|min_length[8]|required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			// Set view variables
			$this->data['breadcrumbs']='<a href="'.site_url('cpanel/users').'">Users</a> \ Create';
		
			// Load view
			$this->data['content']=$this->load->view('cpanel/users_create', '', true);
			$this->load->view('cpanel/theme', $this->data);
		}
		else
		{
			$this->administrators->create($this->input->post('email'),$this->input->post('password'),$this->input->post('name'));
			redirect('cpanel/users/create_success');
		}
	

	}
	
	// Check whether a user is currently logged in
	private function check_login()
	{
		if($this->session->userdata('user_id')=="")
		{
			redirect('cpanel');
			return false;
		}
		else
		{
			return true;
		}
	}
	
}

/* End of file cpanel.php */
/* Location: ./application/controllers/cpanel.php */