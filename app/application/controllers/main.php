<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class main extends CI_Controller {

	public function index(){
		$this->load->view('layout/main');
	}
	
	public function logout(){
		unset($_SESSION['user']);
		redirect_to(site_url());
	}
	
	public function login(){
		if($_POST['login_email']=='admin'&&$_POST['password']=='admin'){
			$_SESSION['user'] = 'admin';
			redirect_to(site_url());
		}
		else{
			redirect_to(site_url()."?error=Invalid Login");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */