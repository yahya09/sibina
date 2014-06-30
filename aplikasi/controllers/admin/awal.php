<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Awal extends Admin_Controller {
	var $_tampak_publik;
	public function __construct() {
		parent::__construct();
		$this->_tampak_publik = $this->config->item('admin_view').'wrapper';
	}
	
	public function index() {
        $this->restrict_level('administrator');
		$level = substr($this->session->userdata('logged_user_level'),3);
		$data = array('page_title'=>'SIP | Homepage','page_content'=>'awal',
				'level'=>$level);
		$this->load->view($this->_tampak_publik,$data);
	}
}

/* End of file awal.php */
/* Location: ./application/controllers/admin/awal.php */