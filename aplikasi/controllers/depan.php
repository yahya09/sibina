<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depan extends CI_Controller {
	var $_tampak_publik;
    var $_team_view;
	public function __construct() {
		parent::__construct();
		$this->_tampak_publik = $this->config->item('public_view');
        $this->_team_view = $this->config->item('team_view').$this->_tampak_publik;
	}
	
	public function index($offset = NULL) {
        $this->tinyauth->restrict();
        if ($this->tinyauth->check_level('pembinaan')) {
            $this->load->view($this->_team_view,array('page_title'=>'Beranda','page_content'=>'hal_depan'));
        } else {
            $this->load->view($this->_tampak_publik,array('page_title'=>'Beranda','page_content'=>'hal_depan'));
        }
	}
}

/* End of file depan.php */
/* Location: ./application/controllers/depan.php */
