<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
	var $_admin_view = "";
	
	public function __construct() {
		parent::__construct();
		//$this->load->library('tinyauth');
		$this->tinyauth->restrict();
		$this->_admin_view = $this->config->item('admin_view');
	}
	
	public function restrict_level($level) {
		return $this->tinyauth->restrict_level($level);
	}
	
	public function check_level($level = 'administrator') {
		return $this->tinyauth->check_level($level);
	}
}


/* End of file sip.php */
/* Location: ./aplikasi/config/sip.php */
?>