<?php if ( ! defined('BASEPATH')) exit('Akses langsung tidak diperkenankan');

class Login_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function buat_query($npm = '', $pwd = '') {
		$kueri = "SELECT npm, pwd FROM akun_login WHERE npm=".$this->db->escape($npm)." AND $pwd=".$this->db->escape($pwd);
		if (!is_null($npm)) {
			$hasil = $this->db->query($kueri);
		}
		if ($hasil->num_rows() == 1) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
}

?>