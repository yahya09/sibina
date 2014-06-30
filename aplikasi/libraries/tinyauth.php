<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tinyauth {
	var $CI = NULL;
	var $_valid = NULL;
	var $wrapper = '';

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');
		$this->CI->load->library('form_validation');
		$this->_valid = $this->CI->form_validation;
		$this->wrapper = $this->CI->config->item('public_view');
	}

	public function login($page) {
		$this->restrict(TRUE);
		if ($page == '') {
			$page = $this->wrapper;
		}
		$error = '';
		$config = array (
					array (
						'field' => 'u',
						'label' => 'NPM',
						'rules' => 'trim|required',
					),
					array (
						'field' => 'p',
						'label' => 'Password',
						'rules' => 'trim|required',
					)
				  );
		$this->_valid->set_rules($config);
		
		if ($this->_valid->run() != FALSE AND $this->CI->input->post('submit_login') != FALSE) {
			$login = array('npm'=>$this->CI->input->post('u'),
						'pwd'=>$this->CI->input->post('p'));
			if ($this->_validate_login($login)) {
				$this->redirect();
			} else {
				$error = "Username atau password Anda salah. Ulangi lagi.";
			}
		}
		$data = array('page_title'=>'Sistem Informasi Pembinaan | Masuk',
				'page_content'=>'login','error'=>$error);
		$this->CI->load->view($page,$data);
	}
	
	private function _validate_login($login = NULL) {
		$this->CI->load->helper('array');
		if (!isset($login) && ! is_array($login)) {
			return FALSE;
		}

		if (count($login) != 2) {
			return FALSE;
		}

		$query = $this->CI->db->query("SELECT npm,level FROM akun_login WHERE npm= ? AND pwd= ?;",
									array($login['npm'],md5($login['pwd'])));

		if ($query->num_rows == 1) {
			$hasil = $query->result(); 
			$unpm = $hasil[0]->npm;
			$ulevel = $hasil[0]->level;
			$this->CI->session->set_userdata('logged_user',$unpm);
			$this->CI->session->set_userdata('logged_user_level','is_'.element($ulevel,$this->CI->config->item('user_level')));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function logged_in() {
		if ($this->CI->session->userdata('logged_user') == "") {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function logout() {
		$this->CI->session->sess_destroy();
		redirect(base_url());
	}

	public function redirect() {
        $prev = $this->CI->session->userdata('redirector');
		if ($prev == "") {
            if ($this->check_level('administrator')) {
                redirect('cpanel/depan');
            } else {
                redirect('depan');
            }
        } else {
            redirect($prev);
        }
	}

	public function restrict($logged_out = FALSE) {
		if ($logged_out AND $this->logged_in()) {
			$this->redirect();
		}

		if (!$logged_out AND !$this->logged_in()) {
			$this->CI->session->set_userdata('redirector',$this->CI->uri->uri_string());
			redirect('login','location');
		}
	}

	public function restrict_level($level) {
		if ($level == 'administrator' && $this->check_level($level)) {
			return TRUE;
		} elseif ($level == 'pembinaan' && $this->check_level($level)) {
            return TRUE;
        } elseif ($level == 'mentor' && $this->check_level($level)){
            return TRUE;
        } else {
            redirect('depan');
        }
	}

	public function check_level($level = 'administrator') {
		$cookie = substr($this->CI->session->userdata('logged_user_level'),3);
		if ($cookie != $level) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function get_level() {
		return substr($this->CI->session->userdata('logged_user_level'),3);
	}
}


/* End of file tinyauth.php */
/* Location: ./aplikasi/library/tinyauths.php */
?>
