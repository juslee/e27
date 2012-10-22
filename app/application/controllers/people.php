<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class people extends CI_Controller {

	public function index(){
		$data = array();
		$data['content'] = $this->load->view('people/main', "", true);
		$this->load->view('layout/main', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */