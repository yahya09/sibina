<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_log extends CI_Controller {
	var $_tampak_publik;
	var $_uname;
	public function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->library(array('table','pagination'));
		$this->_tampak_publik = $this->config->item('public_view');
		$this->_uname = $this->session->userdata('logged_user');
	}

	public function index($offset = 0) {
		$this->tinyauth->restrict();
		$config['base_url'] = site_url('change_log/index');
		$config['total_rows'] = "{$this->get_total_log()}";
		$config['per_page'] = '10';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['data'] = $this->get_log($offset);
		$data['page'] = $this->pagination->create_links();
        $this->load->view('changelog',$data);
	}
	
	public function tambah() {
		$this->tinyauth->restrict();
		if ($this->input->post('submit')) {
			$waktu = date("Y-m-j H:i");
			$data = array(
						'waktu'=>$waktu,
						'tipe'=>$this->input->post('tipe'),
						'deskripsi'=>$this->input->post('deskripsi'),
						'oleh'=>$this->_uname
					);
			$this->db->insert('change_log', $data);
		}
		redirect('change_log/index');
	}
	
	private function get_log($offset = NULL) {
		$this->db->order_by("id", "desc");
		$this->db->limit(10,$offset);
		$kueri = $this->db->get('change_log');
		if ($kueri->num_rows > 0) {
			return $kueri->result();
		}
		return FALSE;
	}
	
	private function get_total_log() {
		$hasil = $this->db->get('change_log');
		return $hasil->num_rows;
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
