<?php if ( ! defined('BASEPATH')) exit('Akses langsung tidak diperkenankan');

class Profile_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_kel_detail($idkel = '') {
		$hasil = $this->db->get_where('kelompok',array('id'=>$idkel));
		if ($hasil->num_rows() > 0) {
			return $hasil->row();
		} else {
			return FALSE;
		}
	}
	
	public function get_kelompok($npm = '', $peran = '') {
		$hasil = $this->db->get_where('has_kelompok',array('npm'=>$npm,'peran'=>$peran));
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->kid;
		} else {
			return FALSE;
		}
	}
	
	public function get_presensi($npm = '', $idkel = '', $persen = FALSE) {
		$mentee = $this->db->get_where('has_kelompok',array('npm'=>$npm,'peran'=>'mentee'));
		$tgl = $mentee->row()->tgl_bergabung;
		$this->db->where('kid', $idkel);
		$this->db->where('waktu >', $tgl); 
		$this->db->from('log_mentoring');
		$total = $this->db->count_all_results();
		if ($total > 0) {
			$hasil = $this->db->get_where('mentee',array('npm'=>$npm));
			$rekap = $hasil->row()->presentasi_kehadiran;
			return ($rekap / $total);
		} else {
			return FALSE;
		}
	}
	
	public function get_all_mentee($array = FALSE) {
		$mentee = $this->db->get('mentee');
		foreach ($mentee->result_array() as $row) {
			$npm[] = $row['npm'];
		}
		$this->db->select('orang.npm, orang.fname, orang.mname, orang.lname, has_kelompok.peran');
		$this->db->distinct();
		$this->db->from('orang');
		$this->db->join('has_kelompok', 'orang.npm = has_kelompok.npm');
		$this->db->where('has_kelompok.peran !=', 'mentor');
		$this->db->where_in('orang.npm', $npm);
		$this->db->order_by('fname','asc');
		$this->db->order_by('mname','asc');
		$this->db->order_by('lname','asc');
		$hasil = $this->db->get();
		$data = array();
		$mentee = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $orang) {
				if (!$array) {
					$data[] = '<a href="#" class="mentee" id="'.$orang->npm.'">'.$this->daftar->buat_nama($orang->fname,$orang->mname,$orang->lname).'</a>'.($orang->peran == 'menunggu'? '*' : '&nbsp;');
				} else {
					$mentee[$orang->npm] = $this->daftar->buat_nama($orang->fname,$orang->mname,$orang->lname);
				}
			}
			return ($array ? $mentee : ul($data,array('id'=>'daf-mentee')) );
		} else {
			return "Tidak ada data mentee tersimpan.";
		}
	}
	
	public function get_calon_mentor($array = FALSE) {
		$mentor = $this->db->get('mentor');
		foreach ($mentor->result_array() as $row) {
			$npm[] = $row['npm'];
		}
		$this->db->select('orang.npm, orang.fname, orang.mname, orang.lname, has_kelompok.peran');
		$this->db->distinct();
		$this->db->from('orang');
		$this->db->join('has_kelompok', 'orang.npm = has_kelompok.npm');
		$this->db->where('has_kelompok.peran', 'mentee');
		$this->db->where_not_in('orang.npm', $npm);
		$this->db->order_by('fname','asc');
		$this->db->order_by('mname','asc');
		$this->db->order_by('lname','asc');
		$hasil = $this->db->get();
		$data = array();
		$mentee = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $orang) {
				if (!$array) {
					$data[] = '<a href="#" class="mentee" id="'.$orang->npm.'">'.$this->daftar->buat_nama($orang->fname,$orang->mname,$orang->lname).'</a>';
				} else {
					$mentee[$orang->npm] = $this->daftar->buat_nama($orang->fname,$orang->mname,$orang->lname);
				}
			}
			return ($array ? $mentee : ul($data,array('id'=>'daf-mentee')) );
		} else {
			return ($array ? array('0' => '-tidak ada data-') : 'Tidak ada data mentee yang belum menjadi mentor.' );
		}
	}
	
	public function get_mentor($idkel = '') {
		$hasil = $this->db->get_where('has_kelompok',array('kid'=>$idkel,'peran'=>'mentor'));
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->npm;
		} else {
			return FALSE;
		}
	}
	
	public function get_login($npm = '') {
		$hasil = $this->db->get_where('akun_login',array('npm'=>$npm));
		if ($hasil->num_rows() > 0) {
			return $hasil->row();
		} else {
			return FALSE;
		}
	}
	
	public function is_mentor($npm = '') {
		$hasil = $this->db->get_where('mentor',array('npm'=>$npm));
		if ($hasil->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function set_mentor($idkel = '', $mentor) {
		if ($idkel !== '') {
			if ($this->get_mentor($idkel)) {
				if ($mentor !== FALSE) {
					$this->db->where('kid',$idkel);
					$this->db->update('has_kelompok',array('npm'=>$mentor));
				} else {
					$this->db->delete('has_kelompok',array('kid'=>$idkel,'peran'=>'mentor'));
				}
			} else {
				$this->db->insert('has_kelompok', array('npm'=>$mentor,'kid'=>$idkel,'tgl_bergabung'=>date("Y/m/d"),'peran'=>'mentor'));
			}
		}
	}
	
	public function get_bio($npm = '') {
		$hasil = $this->db->get_where('orang',array('npm'=>$npm));
		if ($hasil->num_rows() > 0) {
			return $hasil->row();
		} else {
			return FALSE;
		}
	}
	
	public function get_status($npm = '', $idkel = '') {
		$hasil = $this->db->get_where('has_kelompok',array('npm'=>$npm,'kid'=>$idkel));
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->peran;
		} else {
			return FALSE;
		}
	}
	
	public function update_status($npm = '', $idkel = '', $status = '') {
		if ($this->get_status($npm,$idkel) != $status) {
			$this->db->where('npm',$npm);
			$this->db->where('kid',$idkel);
			$this->db->update('has_kelompok',array('peran'=>$status));
		} else {
			return FALSE;
		}
	}
	
	public function tambah_mentor($data, $new = FALSE) {
		if ($new) {
			$this->db->insert('orang', $data);
			$this->db->insert('mentor',array('npm'=>$data['npm']));
			$this->db->insert('akun_login', array('npm'=>$data['npm'],'pwd'=>md5($data['npm']),'level'=>1));
		} else {
			$this->db->insert('mentor',array('npm'=>$data));
			$this->db->insert('akun_login', array('npm'=>$data,'pwd'=>md5($data),'level'=>1));
		}
	}
	
	public function tambah_mentee($data = array(), $kid = '') {
		$this->db->insert('orang', $data);
		$baru = array('npm'=>$data['npm'],'kid'=>$kid,'tgl_bergabung'=>date("Y/m/d"),'peran'=>'mentee');
		$this->db->insert('has_kelompok', $baru);
		$this->db->insert('mentee',array('npm'=>$data['npm'],'presentasi_kehadiran'=>0));
	}
	
	public function tambah_kelompok($data = array(),$mentor) {
		$this->db->insert('kelompok', $data);
		if (isset($mentor)) {
			$this->db->insert('has_kelompok', array('npm'=>$mentor,'kid'=>$data['id'],'tgl_bergabung'=>$data['tgl_terbentuk'],'peran'=>'mentor'));
		}
	}
	
	public function edit_bio($data = array(), $npm = '') {
		$this->db->where('npm', $npm);
		$this->db->update('orang', $data);
	}
	
	public function edit_kelompok($idkel = '', $data = array(), $mentor) {
		$this->db->where('id', $idkel);
		$this->db->update('kelompok', $data);
		$oldmentor = $this->get_mentor($data['id']);
		if ($oldmentor !== $mentor) {
				$this->set_mentor($data['id'], $mentor);
		}
	}

	public function cek_npm($npm) {
		$hasil = $this->db->get_where('orang',array('npm'=>$npm));
		if ($hasil->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function cek_id_kel($idkel) {
		$hasil = $this->db->get_where('kelompok',array('id'=>$idkel));
		if ($hasil->num_rows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
