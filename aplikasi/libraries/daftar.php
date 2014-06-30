<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daftar {
	var $CI = NULL;
	var $wrapper = '';

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper(array('html','url'));
		$this->wrapper = $this->CI->config->item('public_view');
	}

	/** mengambil daftar kelompok yang dimiliki seorang mentor.
	*	untuk ditampilkan di halaman biodata mentor.
	*/
	public function get_kelompok($mentor = '', $alamat = 'profil/kelompok') {
		$hasil = $this->CI->db->get_where('has_kelompok',array('npm'=>$mentor,'peran'=>'mentor'));
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$data[] = anchor($alamat.'/'.$row->kid,$row->kid);
			}
			return ul($data,array('id'=>'dafkel'));
		} else {
			return "Tidak ada kelompok.";
		}
	}
	
	
	/** mengambil daftar kelompok yang dimiliki seorang mentor.
	*	Dipakai untuk ajax.
	*/
	public function get_kelompok_ajax($mentor = '') {
		$hasil = $this->CI->db->get_where('has_kelompok',array('npm'=>$mentor,'peran'=>'mentor'));
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$data[] = '<a href="#" class="kel">'.$row->kid.'</a>';
			}
			return ul($data,array('id'=>'dafkel'));
		} else {
			return "Tidak ada data kelompok tersimpan untuk mentor ".$this->get_nama($mentor).".";
		}
	}
    
	
	/** mengambil daftar semua kelompok.*/
    public function get_all_kelompok() {
		$hasil = $this->CI->db->get('kelompok');
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$data[] = '<a href="#" class="kel">'.$row->id.'</a>';
			}
			return ul($data,array('id'=>'dafkel'));
		} else {
			return "Tidak ada kelompok.";
		}
	}
	
    
	/** mengambil daftar semua mentor.*/
    public function get_all_mentor($array = FALSE) {
		$hasil = $this->CI->db->get('mentor');
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
                $temp = $this->CI->db->get_where('orang',array('npm'=>$row->npm));
                $orang = $temp->row();
				if (!$array) {
					$data[] = '<a href="#" class="mentor" id="'.$orang->npm.'">'.$this->buat_nama($orang->fname,$orang->mname,$orang->lname).'</a>';
				} else {
					$mentor[$orang->npm] = $this->buat_nama($orang->fname,$orang->mname,$orang->lname);
				}
			}
			return ($array ? $mentor : ul($data,array('id'=>'dafmen')) );
		} else {
			return "Tidak ada kelompok.";
		}
	}
	
	/** mengembalikan daftar mentee berdasar kelompok ID*/
	public function get_daftar_mentee($kid = '') {
		$hasil = $this->CI->db->get_where('has_kelompok',array('kid'=>$kid,'peran'=>'mentee'));
		$data = array();
		$mentee = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$orang = $this->CI->db->get_where('orang',array('npm'=>$row->npm));
				$orang = $orang->row();
				$mentee[$orang->npm] = $this->buat_nama($orang->fname,$orang->mname,$orang->lname);
			}
			return $mentee;
		} else {
			return FALSE;
		}
	}
	
	/** mengembalikan daftar semua mentee dari semua kelompok yang dipegang seorang mentor*/
	public function get_all_mentee($npm = '') {
		$hasil = $this->CI->db->get_where('has_kelompok',array('npm'=>$npm,'peran'=>'mentor'));
		$mentee = array();
		if ($hasil->num_rows > 0) {
			$kel = array();
			foreach ($hasil->result() as $row) {
				$kel[] = $row->kid;
			}
			$this->CI->db->select('npm');
			$this->CI->db->where('peran','mentee');
			$this->CI->db->where_in('kid',$kel);
			$this->CI->db->from('has_kelompok');
			$hasil = $this->CI->db->get();
			
			foreach ($hasil->result() as $row) {
				$orang = $this->CI->db->get_where('orang',array('npm'=>$row->npm));
				$orang = $orang->row();
				$mentee[$orang->npm] = $this->buat_nama($orang->fname,$orang->mname,$orang->lname);
			}
			return $mentee;
		} else {
			return FALSE;
		}
	}
	
	/** mengembalikan daftar mentee berupa html list berdasar kelompok ID*/
	public function get_mentee_ajax($kelompok = '') {
		$hasil = $this->CI->db->get_where('has_kelompok',array('kid'=>$kelompok,'peran !='=>'mentor'));
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$orang = $this->CI->db->get_where('orang',array('npm'=>$row->npm));
				$orang = $orang->row();
				if ($row->peran == 'mentee') {
					$data[] = '<a href="#" class="mentee" name="'.$row->npm.'">'.$this->buat_nama($orang->fname,$orang->mname,$orang->lname).'</a>';
				} else {
					$data[] = $this->buat_nama($orang->fname,$orang->mname,$orang->lname).'<em>.&nbsp;Status : menunggu konfirmasi.</em>';
				}
			}
			return ul($data,array('id'=>'dafmentee'));
		} else {
			return "Belum ada mentee terdaftar.";
		}
	}
	
	/** Mengambil daftar semua log mentoring suatu kelompok.
	*	Digunakan untuk ajax.
	*/
	public function get_log_ajax($kelompok = '') {
		$hasil = $this->CI->db->get_where('log_mentoring',array('kid'=>$kelompok));
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$data[] = '<a href="#" class="logitem" name="'.$row->id.'">'.$row->id.'</a>&nbsp;('.date("j F Y, G:i",strtotime($row->waktu)).')';
			}
			return ul($data);
		} else {
			return "Belum ada log tersimpan untuk kelompok {$kelompok}.";
		}
	}
	
	/** mengambil daftar semua kegiatan yang dibuat mentor.*/
	public function get_kegiatan($npm = '') {
		$hasil = $this->CI->db->get_where('terlibat_dalam',array('npm'=>$npm));
		$data = array();
		if ($hasil->num_rows > 0) {
			foreach ($hasil->result() as $row) {
				$data[] = '<a href="#" class="kegitem" name="'.$row->kmid.'">'.$row->kmid.'</a>&nbsp;';
			}
			return ul($data);
		} else {
            $row = $this->CI->db->get_where('orang',array('npm'=>$npm))->row();
			return "Belum ada data kegiatan tersimpan untuk mentor ".$this->buat_nama($row->fname,$row->mname,$row->lname).".";
		}
	}
    
	public function get_nama($npm = '') {
		if (isset($npm)) {
			$orang = $this->CI->db->get_where('orang',array('npm'=>$npm));
			$orang = $orang->row();
			return $this->buat_nama($orang->fname,$orang->mname,$orang->lname);
		}
	}
	
	/** Untuk membentuk string nama dari data terpisah.*/
    public function buat_nama($fname = '', $mname = '', $lname = '') {
        if($mname == '') {
            return $fname.' '.$lname;
        } else {
            return $fname.' '.$mname.' '.$lname;
        }
    }
}


/* End of file tinyauth.php */
/* Location: ./aplikasi/library/tinyauths.php */
?>
