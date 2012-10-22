<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class companies extends CI_Controller {

	public function index(){
		$data = array();
		$data['content'] = $this->load->view('companies/main', "", true);
		$this->load->view('layout/main', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */