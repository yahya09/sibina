<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	var $_tampak_publik;
	public function __construct() {
		parent::__construct();
		//$this->load->library('tinyauth');
		$this->_tampak_publik = $this->config->item('public_view');
	}
	
	public function index($offset = NULL) {
		$this->form();
	}
	
	public function form() {
		$this->tinyauth->login($this->_tampak_publik);
	}
	
	public function logout() {
		$this->tinyauth->logout();
	}
}

/* End of file depan.php */
/* Location: ./application/controllers/depan.php */