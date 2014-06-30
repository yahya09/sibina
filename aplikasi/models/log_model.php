<?php if ( ! defined('BASEPATH')) exit('Akses langsung tidak diperkenankan');

class Log_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function get_log_detail($lid = '',$kid = '') {
		$hasil = $this->db->get_where('log_mentoring',array('id'=>$lid));
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
	
	public function get_keg_detail($kegid = '') {
		$hasil = $this->db->get_where('kegiatan_mentor',array('id'=>$kegid));
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return FALSE;
		}
	}
	
	public function get_log_num($kid = '') {
		$hasil = $this->db->get_where('log_mentoring',array('kid'=>$kid));
		return $hasil->num_rows();
	}
	
	public function get_keg_num() {
		return $this->db->count_all('kegiatan_mentor');
	}
	
	public function tambah_log($data = array(), $daftar = array()) {
		$this->db->insert('log_mentoring', $data);
		foreach ($daftar as $npm) {
			$this->update_kehadiran($npm,TRUE);
		}
	}
	
	public function edit_log($logid = '', $data = array(), $daftar = array()) {
		$this->db->where('id', $data['id']);
		$this->db->update('log_mentoring', $data);
		foreach ($daftar as $npm) {
			$this->update_kehadiran($npm);
		}
	}
	
	public function tambah_keg($data = array(), $orang = array()) {
		$this->db->insert('kegiatan_mentor', $data);
		$batch = array();
		foreach ($orang as $row) {
			$batch[] = array('kmid'=>$data['id'],'npm'=>$row);
		}
		$this->db->insert_batch('terlibat_dalam', $batch);
	}
	
	public function edit_keg($idkeg = '', $data = array(), $orang = array()) {
		$this->db->select('npm');
		$this->db->where('kmid', $idkeg);
		$has = $this->db->get('terlibat_dalam');
		$temp = $has->result();
		$awal = array();
		foreach ($temp as $row) {
			$awal[] = $row->npm;
		}
		foreach ($orang as $baru) {
			if (!in_array($baru,$awal))
				$this->db->insert('terlibat_dalam',array('npm'=>$baru,'kmid'=>$idkeg));
		}
		foreach ($awal as $ada) {
			if (!in_array($ada,$orang))
				$this->db->delete('terlibat_dalam',array('npm'=>$ada,'kmid'=>$idkeg));
		}
		$this->db->where('id', $idkeg);
		$this->db->update('kegiatan_mentor', $data);
	}
	
	public function get_terlibat($idkeg) {
		$hasil = $this->db->get_where('terlibat_dalam',array('kmid'=>$idkeg));
		return $hasil->result();
	}
	
	public function get_total_log ($idkel = '') {
		if (isset($idkel)) {
			$this->db->where('kid', $idkel);
			$this->db->from('log_mentoring');
			//echo $this->db->count_all_results();
			//$this->db->get_where('log_mentoring',array('kid'=>$idkel));
			return $this->db->count_all_results();
		}
		return FALSE;
	}
	
	public function get_kehadiran ($npm = '') {
		if (isset($npm)) {
			$hasil = $this->db->get_where('mentee',array('npm'=>$npm));
			$hasil = $hasil->row();
			return $hasil->presentasi_kehadiran;
		}
		return FALSE;
	}
	
	private function update_kehadiran($npm,$nambah = FALSE) {
		if (!$nambah) {
			$hasil = $this->db->get_where('has_kelompok',array('npm'=>$npm,'peran'=>'mentee'));
			$hasil = $hasil->result();
			$orang = $this->db->get_where('orang',array('npm'=>$npm));
			$orang = $orang->result();
			$orang = $orang[0];
			$name = $orang->fname.' '.$orang->lname;
			$total = 0;
			foreach ($hasil as $kel) {
				$this->db->select('absen');
				$this->db->where('kid',$kel->kid);
				$this->db->like('absen',$name);
				$cek = $this->db->get('log_mentoring');
				$total += $cek->num_rows();
			}
			$this->db->where('npm',$npm);
			$this->db->update('mentee',array('presentasi_kehadiran'=>$total));
		} else {
			$hasil = $this->db->get_where('mentee',array('npm'=>$npm));
			$hasil = $hasil->result();
			$hasil = $hasil[0];
			$total = $hasil->presentasi_kehadiran + 1;
			$this->db->where('npm',$npm);
			$this->db->update('mentee',array('presentasi_kehadiran'=>$total));
		}
	}
}

?>