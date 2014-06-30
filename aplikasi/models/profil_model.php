<?php if ( ! defined('BASEPATH')) exit('Akses langsung tidak diperkenankan');

class Profil_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function buat_kueri($from = '',$data = array()) {
		if ($from == 'kelompok') {
			$kueri = "SELECT * FROM kelompok WHERE id=".$this->db->escape($data[0]);
		} else {
			$kueri = "SELECT * FROM orang WHERE npm=".$this->db->escape($data[0]);
		}
		return $kueri;
	}
	
	public function get_mentors() {
		$kueri = $this->get('mentor');
		if ($kueri->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
	
	public function get_bio_mentor($uname = '') {
		$kueri = $this->buat_kueri('orang',array($uname));
		$hasil = $this->db->query($kueri);
		
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
	
	public function get_kel_detail($kid = '') {
		$kueri = $this->buat_kueri('kelompok',array($kid));
		$hasil = $this->db->query($kueri);
		
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
	
	public function get_bio_mentee($uname = '') {
		$kueri = $this->buat_kueri('orang',array($uname));
		$hasil = $this->db->query($kueri);
		
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}

    public function tambah_mentee($data = array(), $kid = '') {
		$this->db->insert('orang', $data);
		$baru = array('npm'=>$data['npm'],'kid'=>$kid,'tgl_bergabung'=>date("Y/m/d"),'peran'=>'menunggu');
		$this->db->insert('has_kelompok', $baru);
		$this->db->insert('mentee',array('npm'=>$data['npm'],'presentasi_kehadiran'=>0));
	}
	
	public function edit_mentee($data = array(), $npm = '') {
		$this->db->where('npm', $npm);
		$this->db->update('orang', $data);
	}
	
	public function cek_npm($npm) {
		$hasil = $this->db->get_where('orang',array('npm'=>$npm));
		if ($hasil->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

?>