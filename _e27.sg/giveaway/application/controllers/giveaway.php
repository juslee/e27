<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Giveaway extends CI_Controller {

	protected $data, $giveaway_referrer;

	public function __construct()
    {
		parent::__construct();
		
		// Load required libraries
		$this->load->library('form_validation');
		
		// Load models
		$this->load->model('giveaways');
		$this->load->model('logs');
        
        $this->data = array(
					'giveaway' => '',
					'content'=>'',
					'winner'=>''
				);
    }
       
	public function index()
	{
	
		// Set giveaway_id from URI
		
		
	

		$giveaway_permalink=$this->uri->segment(1);
		
		if($this->uri->segment(2)=='')
			$this->giveaway_referrer=0;
		else
			$this->giveaway_referrer=$this->uri->segment(2);
		
		$form_stage=$this->uri->segment(3);
		

		
		// Checks for valid giveaway_permalink and returns giveaway data
		if(empty($giveaway_permalink) || !$giveaway_data=$this->giveaways->get_by_permalink($giveaway_permalink)){
			show_404();
		}
			
		// Check whether start_date is later then current date
		if(strtotime($giveaway_data['start_date'])>time()){
			show_404();
		}
			
		// Check whether end_date is earlier then current date
		if(strtotime($giveaway_data['end_date'])<=time())
		{
			// Set view variables
			$this->data['giveaway']=$giveaway_data;
			
			$this->show_winner();
		}
		else
		{	
			
			// Log visit
			$ip = $_SERVER['REMOTE_ADDR'];
			$browser = $_SERVER['HTTP_USER_AGENT'];

			if(isset($_SERVER['HTTP_REFERER']))
				$http_referrer = $_SERVER['HTTP_REFERER']; 
			else
				$http_referrer = "";
			
			$page_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
			if($this->session->userdata('session')=="")
			{
				$this->session->set_userdata(array('session'=>md5($ip.time())));
				$this->giveaways->add_visit($this->giveaway_referrer);	
			}
		
			$this->logs->log_visit($ip,$browser,$http_referrer,$page_url,$this->session->userdata('session'),$giveaway_data['id'],$this->giveaway_referrer);
			
			// Set view variables
			$this->data['giveaway']=$giveaway_data;
			$this->data['referrer_id']=$this->giveaway_referrer;
		
			// Checks for stage of form processing
			if(strtolower($form_stage)=='process')
			{
				$this->process_details();
			}
			elseif(strtolower($form_stage)=='completed')
			{
				$this->process_completed();
			}
			elseif(strtolower($form_stage)=='check')
			{
				$this->process_check();
			}
			else
			{
				$this->process_landing();
			}
		}
	}
	
	// Process Landing Page data
	private function process_landing()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required|callback_answer_check');
	
		if ($this->form_validation->run() == FALSE)
		{
			// Load view
			$this->data['content']=$this->load->view('giveaway/form_landing', $this->data, TRUE);
			$this->load->view('giveaway/theme',$this->data);
		}
		else
		{
			$registration_id=$this->giveaways->register($this->data['giveaway']['id'],$this->giveaway_referrer, $this->input->post('email'));
			$this->session->set_userdata(array('registration_id'=>$registration_id));
			
			redirect(''.$this->data['giveaway']['permalink'].'/'.$this->giveaway_referrer.'/process');
		}
	}
	
	// Get additional registration data
	private function process_details()
	{
		// Check for valid registration id
		if($this->session->userdata('registration_id')=='')
			redirect(''.$this->data['giveaway']['permalink'].'/'.$this->giveaway_referrer);
	
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
	
		if ($this->form_validation->run() == FALSE)
		{
			// Load view
			$this->data['content']=$this->load->view('giveaway/form_register', $this->data, TRUE);
			$this->load->view('giveaway/theme',$this->data);
		}
		else
		{
			$this->giveaways->update_registration(
										$this->session->userdata('registration_id'),
										$this->input->post('first_name'),
										$this->input->post('last_name'),
										$this->input->post('company'),
										$this->input->post('title'),
										$this->input->post('profile')
									);
									
			redirect(''.$this->data['giveaway']['permalink'].'/'.$this->giveaway_referrer.'/completed');						
			
		}
	}
	
	// Show unique URL and social sharing icons
	private function process_completed()
	{
		// Check for valid registration id
		if($this->session->userdata('registration_id')=='')
			redirect(''.$this->data['giveaway']['permalink'].'/'.$this->giveaway_referrer);
			
		$this->giveaways->add_signup($this->giveaway_referrer);
		
		$this->data['registration']=$this->giveaways->get_registration($this->session->userdata('registration_id'));
		$this->data['content']=$this->load->view('giveaway/form_completed', $this->data, TRUE);
		$this->load->view('giveaway/theme',$this->data);
		
		$this->session->unset_userdata(array('registration_id'=>''));
	
	}
	
	// Allow user to check current score
	private function process_check()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_registered_email_check');
	
		if ($this->form_validation->run() == FALSE)
		{
			// Load view
			$this->data['content']=$this->load->view('giveaway/form_check', $this->data, TRUE);
			$this->load->view('giveaway/theme',$this->data);
		}
		else
		{
			// Get Registration Details and Statistics
			$this->data['registration']=$this->giveaways->get_registration_by_email($this->input->post('email'),$this->data['giveaway']['id']);
			$this->data['rank']=$this->giveaways->get_registration_rank($this->input->post('email'),$this->data['giveaway']['id']);
			$this->data['stats']=$this->giveaways->get_stats($this->data['giveaway']['id']);
			
			
			// Load view
			$this->data['content']=$this->load->view('giveaway/form_results', $this->data, TRUE);
			$this->load->view('giveaway/theme',$this->data);
		}
	}
	
	// Show winner
	private function show_winner()
	{
		// Retrieve winner data
		$this->data['winner']=$this->giveaways->get_winner($this->data['giveaway']['id']);
		
		// Load view
		$this->data['content']=$this->load->view('giveaway/message_winner', $this->data, TRUE);
		$this->load->view('giveaway/theme',$this->data);
	}
	
	// Check for duplicate email
	public function email_check($str)
	{
		if ($this->giveaways->check_email($this->data['giveaway']['id'],$str))
		{
			$this->form_validation->set_message('email_check', 'You have already registered for this giveaway');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// Check for registered email
	public function registered_email_check($str)
	{
		if (!$this->giveaways->check_email($this->data['giveaway']['id'],$str))
		{
			$this->form_validation->set_message('registered_email_check', 'This email is currently not registered with us');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// Check for correct answer
	public function answer_check($answer)
	{
		if (!$this->giveaways->check_answer($this->data['giveaway']['id'],$answer))
		{
			$this->form_validation->set_message('answer_check', 'The selected answer is incorrect');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

/* End of file giveaway.php */
/* Location: ./application/controllers/giveaway.php */