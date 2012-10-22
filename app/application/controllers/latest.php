<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class latest extends CI_Controller {

	public function index(){
		$data = array();
		$data['content'] = $this->load->view('latest/main', "", true);
		$this->load->view('layout/main', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */