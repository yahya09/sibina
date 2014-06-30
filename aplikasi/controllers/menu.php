<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depan extends CI_Controller {
	var $_tampak_publik;
	public function __construct() {
		parent::Controller();
		$this->load->model('Login_model','lmodel');
		$this->_public_view = 'wrapper';
	}

	public function index($offset = NULL) {
		$data = array('page_title' => 'Sistem Informasi Pembinaan',
						'page_content' => 'login');
		$this->load->view($this->_public_view,$data);
	}
}

/* End of file depan.php */
/* Location: ./application/controllers/depan.php */