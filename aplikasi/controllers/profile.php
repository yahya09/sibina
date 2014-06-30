<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	var $_team_view;
    var $_public_view;
    var $_page_view;
	var $_uname;
	public function __construct() {
		parent::__construct();
		$this->load->model('Profile_model','pmodel');
        $this->load->library(array('table'));
		$this->_public_view = $this->config->item('public_view');
        $this->_team_view = $this->config->item('team_view');
        $this->_page_view = $this->_team_view.$this->_public_view;
		$this->_uname = $this->session->userdata('logged_user');
		$this->tinyauth->restrict_level('pembinaan');
	}

	public function index() {
        $this->tinyauth->restrict_level('pembinaan');
        $this->kelompok();
	}

	public function kelompok($idkel = '') {
        $detail = ($idkel === '' ? "Pilih kelompok." : $this->detail('kelompok', $idkel, TRUE));
		$data = array('page_title'=>'Data Kelompok','page_content'=>'bina/kel_dasar',
					'daftar'=>$this->daftar->get_all_kelompok(),'detil'=>$detail);
		$this->load->view($this->_page_view,$data);
	}
	
	public function mentor($npm = '') {
        $detail = ($npm === '' ? "Pilih mentor." : $this->detail('mentor',$npm,TRUE));
        $mentors = $this->daftar->get_all_mentor();
		$data = array('page_title'=>'Data Mentor','page_content'=>'bina/bio_dasar',
					'daftar'=>$mentors,'detail'=>$detail,'hal'=>'Mentor');
		$this->load->view($this->_page_view,$data);
	}
    
    public function mentee($npm = '') {
        $detail = ($npm === '' ? "Pilih mentee." : $this->detail('mentee',$npm,TRUE));
        $mentees = $this->pmodel->get_all_mentee();
		$mentees .= '* menunggu persetujuan.';
		$data = array('page_title'=>'Data Mentee','page_content'=>'bina/bio_dasar',
					'daftar'=>$mentees,'detail'=>$detail,'hal'=>'Mentee');
		$this->load->view($this->_page_view,$data);
	}
    
	public function detail($apa = '', $id = '', $teks = FALSE) {
		if ($apa === 'kelompok') {
			$idkel = ( $id === '' ? $this->input->post('idkel') : $id);
			if ($idkel !== '') {
				$hasil = $this->pmodel->get_kel_detail($idkel);
				$npm = $this->pmodel->get_mentor($idkel);
				$mentor = ($npm ? $this->daftar->get_nama($npm) : '-belum ada data mentor-');
				if (!$hasil) {
					$data = array('error'=>'Data tidak ditemukan','idkel'=>$idkel);
				} else {
					$data = array('idkel'=>$hasil->id,'tglkel'=>date("d M Y",strtotime($hasil->tgl_terbentuk)),
						'mentee'=>$this->daftar->get_mentee_ajax($hasil->id),'npm'=>$npm,'mentor'=>$mentor);
				}
			} else {
				$data = array('pesan'=>'Data ID kelompok tidak ada!');
				return $this->load->view($this->_team_view.'pesan',$data,$teks);
			}
			return $this->load->view($this->_team_view.'kel_detail',$data,$teks);
		} elseif ($apa === 'mentor') {
			$npm = ( $id === '' ? $this->input->post('npm') : $id);
			if ($npm != '' && $this->pmodel->is_mentor($npm)) {
				$hasil = $this->pmodel->get_bio($npm);
				$daftar = $this->daftar->get_kelompok($npm,'info/kelompok');
				if (!$hasil) {
					$data = array('error'=>'Data tidak ditemukan!');
				} else {
					$login = $this->pmodel->get_login($npm);
					$pwd = ($login->pwd == md5($npm) ? 'default (npm)' : '(user defined)');
					$data = array('bio'=>$this->get_bio($hasil),'npm'=>$hasil->npm,'daftar'=>$daftar,'pwd'=>$pwd);
				}
			} else {
				$data = array('pesan'=>'Data yang dikirim tidak cocok dengan data Mentor yang ada.','alamat'=>'info/mentor');
				return $this->load->view($this->_team_view.'pesan',$data,$teks);
			}
			return $this->load->view($this->_team_view.'bio_mentor',$data,$teks);
		} elseif ($apa === 'mentee') {
			$npm = ( $id === '' ? $this->input->post('npm') : $id);
			if ($npm != '') {
				$hasil = $this->pmodel->get_bio($npm);
				if (!$hasil) {
					$data = array('pesan'=>'Data tidak ditemukan!','alamat'=>'info/mentee');
					return $this->load->view($this->_team_view.'pesan',$data,$teks);
				} else {
					$data = array('bio'=>$this->get_bio($hasil),'npm'=>$hasil->npm);
				}
				$idkel = $this->pmodel->get_kelompok($npm,'mentee');
				$idkel = ($idkel ? $idkel : $this->pmodel->get_kelompok($npm,'menunggu'));
				$hasil = $this->pmodel->get_mentor($idkel);
				$mentor = ($hasil ? $hasil : 0);
				$data['mentorname'] = $this->daftar->get_nama($mentor);
				$stat = $this->pmodel->get_status($npm,$idkel);
				$rekap = ($stat == 'mentee' ? $this->pmodel->get_presensi($npm,$idkel,TRUE) : false);
				if (is_numeric($rekap)) {
					$data['status'] = ($rekap >= 0.5 ? 'Aktif' : 'Pasif');
					$data['rekap'] = ($rekap*100)."%";
				} else {
					$data['status'] = ($stat == 'menunggu' ? 'Menunggu persetujuan' : 'Baru bergabung/disetujui');
					$data['rekap'] = 'Belum ada data.';
				}
				$data['idkel'] = $idkel;
				$data['mentor'] = $mentor;
			} else {
				$data = array('pesan'=>'Data tidak ditemukan!','alamat'=>'info/mentee');
				return $this->load->view($this->_team_view.'pesan',$data,$teks);
			}
			return $this->load->view($this->_team_view.'bio_mentee',$data,$teks);
		}
	}
	
	public function tambah($apa = '', $idkel = '', $stat = TRUE) {
		if ($this->input->post('submit') && $stat) {
			$this->load->library('form_validation');
			if ($apa == 'mentee') {
				$this->tambah_mentee($idkel);
			} elseif ($apa == 'mentor') {
				$this->tambah_mentor();
			} elseif ($apa == 'kelompok') {
				$this->tambah_kelompok();
			}
			return;
		} else {
			if ($apa == 'mentee') {
				$this->load->view($this->_team_view.'mentee_tambah',array('idkel'=>$idkel,'pilihan'=>$this->config->item('fakultas')));
			} elseif ($apa == 'mentor') {
				$this->load->view($this->_team_view.'mentor_tambah',array('pilihan'=>$this->config->item('fakultas')));
			} elseif ($apa == 'mentor-lama') {
				$mentees = $this->pmodel->get_calon_mentor(TRUE);
				$this->load->view($this->_team_view.'mentor_tambah_lama',array('pilihan'=>$mentees));
			} elseif ($apa == 'kelompok') {
				$this->load->view($this->_team_view.'kel_tambah',array('mentors'=>$this->daftar->get_all_mentor(TRUE)));
			}
			return;
		}
		$this->load->view($this->_team_view.'pesan',array('pesan'=>'<p>Eh, mau nakal ya.. (^_^)</p>'));
	}
	
	public function edit($apa = '', $id = '', $stat = TRUE) {
		if ($this->input->post('submit') && $stat) {
			$this->load->library('form_validation');
			if ($apa == 'mentee') {
				$this->edit_mentee($id);
			} elseif ($apa == 'mentor') {
				$this->edit_mentor();
			} elseif ($apa == 'kelompok') {
				$this->edit_kelompok();
			}
			return;
		} else {
			if ($apa == 'mentee') {
				$info = $this->pmodel->get_bio($id);
				$stat = $this->pmodel->get_status($id);
				$this->load->view($this->_team_view.'bio_edit',array('data'=>$info,'pilihan'=>$this->config->item('fakultas')));
			} elseif ($apa == 'mentor') {
				$info = $this->pmodel->get_bio($id);
				$this->load->view($this->_team_view.'bio_edit',array('data'=>$info,'mentor'=>true,'pilihan'=>$this->config->item('fakultas')));
			} elseif ($apa == 'kelompok') {
				$info = $this->pmodel->get_kel_detail($id);
				$mentor = $this->pmodel->get_mentor($id);
				$npm = (!$mentor ? 'belum' : $mentor);
				$data = array('mentors'=>$this->daftar->get_all_mentor(TRUE),'info'=>$info,'mentor'=>$npm);
				$this->load->view($this->_team_view.'kel_edit',$data);
			}
			return;
		}
		$this->load->view($this->_team_view.'pesan',array('pesan'=>'<p>Eh, mau nakal ya.. (^_^)</p>'));
	}
	
	public function ubah($apa = '', $npm = '') {
		if ($apa = 'status') {
			if ($this->input->post('submit')) {
				$status = ($this->input->post('status') == 'setuju' ? 'mentee' : 'pindah');
				$idkel = $this->pmodel->get_kelompok($npm,'menunggu');
				$idkel = ($idkel !== false ? $idkel : $this->pmodel->get_kelompok($npm,'mentee') );
				$this->pmodel->update_status($npm,$idkel,$status);
				$data = array('pesan'=>'Pengubahan status mentee berhasil!','alamat'=>'info/mentee/'.$npm);
				$this->load->view($this->_team_view.'pesan',$data);
			} else {
				$pilihan = array('setuju'=>'Disetujui','pindah'=>'Pindah');
				$data = array('pilihan'=>$pilihan,'npm'=>$npm);
				$this->load->view($this->_team_view.'status',$data);
			}
		} else {
			$data = array('pesan'=>'Menu tidak ditemukan, hati-hati sama URL nya!','alamat'=>'info/mentee/'.$npm);
			$this->load->view($this->_team_view.'pesan',$data);
		}
	}
	
	private function ceknpm($npm) {
		if ($this->pmodel->cek_npm($npm)) {
			$this->form_validation->set_message('ceknpm', '%s yang dimasukkan sudah ada dalam database.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	private function cekIdKel($idkel) {
		if ($this->pmodel->cek_id_kel($idkel)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	private function tambah_mentee($idkel = '') {
		if ($this->form_validation->run('biodata') && $this->ceknpm($this->input->post('newnpm'))) {
			$data = array(
					'npm' => $this->input->post('newnpm'),
					'no_hp' => $this->input->post('hape'),
					'email' => $this->input->post('email'),
					'fakultas' => $this->input->post('fak'),
					'jurusan' => $this->input->post('jur'),
					'angkatan' => $this->input->post('ang'),
					'riwayat' => $this->input->post('riw'),
					'fname' => $this->input->post('fname'),
					'mname' => $this->input->post('mname'),
					'lname' => $this->input->post('lname')
				);
			$this->pmodel->tambah_mentee($data,$idkel);
			$data = array('pesan'=>'Penambahan mentee berhasil!','alamat'=>'info/kelompok/'.$idkel);
			$this->load->view($this->_team_view.'pesan',$data);
		} else {
			$this->tambah('mentee',$idkel,FALSE);
		}
	}
	
	private function tambah_mentor() {
		$npm = $this->input->post('newnpm');
		$mentee = $this->input->post('mentee');
		if ($mentee == 'false') {
			if ($this->form_validation->run('biodata') && $this->ceknpm($npm)) {
				$data = array(
					'npm' => $this->input->post('newnpm'),
					'no_hp' => $this->input->post('hape'),
					'email' => $this->input->post('email'),
					'fakultas' => $this->input->post('fak'),
					'jurusan' => $this->input->post('jur'),
					'angkatan' => $this->input->post('ang'),
					'riwayat' => $this->input->post('riw'),
					'fname' => $this->input->post('fname'),
					'mname' => $this->input->post('mname'),
					'lname' => $this->input->post('lname')
				);
				$this->pmodel->tambah_mentor($data,TRUE);
			} else {
				$this->tambah('mentor',$npm,FALSE);
				return;
			}
		} else {
			return 'mentee true';
			$this->pmodel->tambah_mentor($npm);
		}
		$data = array('pesan'=>"Penambahan Mentor berhasil!",'alamat'=>'info/mentor/'.$npm);
		$this->load->view($this->_team_view.'pesan',$data);
	}
	
	private function edit_mentor() {
		$oldnpm = $this->input->post('oldnpm');
		$newnpm = $this->input->post('newnpm');
		if ($oldnpm == $newnpm) {
			$stat = true;
		} else {
			$stat = $this->ceknpm($newnpm);
		}
		if ($this->form_validation->run('biodata') && $stat) {
			$data = array(
					'npm' => $this->input->post('newnpm'),
					'no_hp' => $this->input->post('hape'),
					'email' => $this->input->post('email'),
					'fakultas' => $this->input->post('fak'),
					'jurusan' => $this->input->post('jur'),
					'angkatan' => $this->input->post('ang'),
					'riwayat' => $this->input->post('riw'),
					'fname' => $this->input->post('fname'),
					'mname' => $this->input->post('mname'),
					'lname' => $this->input->post('lname')
				);
			$this->pmodel->edit_bio($data,$oldnpm);
			$data = array('pesan'=>"Pengubahan data mentor berhasil!",'alamat'=>'info/mentor/'.$newnpm);
			$this->load->view($this->_team_view.'pesan',$data);
		} else {
			$this->edit('mentor',$oldnpm,FALSE);
		}
	}
	
	private function tambah_kelompok() {
		$idkel = $this->input->post('id');
		if ($this->form_validation->run('kelompok') && $this->cekIdKel($idkel)) {
			$data = array(
						'id' => $this->input->post('id'),
						'tgl_terbentuk' => $this->input->post('tgl')
					);
			$mentor = ($this->input->post('mentor') === 'belum' ? null : $this->input->post('mentor'));
			$this->pmodel->tambah_kelompok($data,$mentor);
			$data = array('pesan'=>"Penambahan Kelompok $idkel berhasil!",'alamat'=>'info/kelompok/'.$idkel);
			$this->load->view($this->_team_view.'pesan',$data);
		} else {
			$this->tambah('kelompok',$idkel,FALSE);
		}
	}
	
	private function edit_kelompok() {
		$oldid = $this->input->post('oldid');
		$idkel = $this->input->post('id');
		if ($oldid == $idkel) {
			$stat = true;
		} else {
			$stat = $this->cekIdKel($idkel);
		}
		if ($this->form_validation->run('kelompok') && $stat) {
			$data = array(
						'id' => $idkel,
						'tgl_terbentuk' => $this->input->post('tgl')
					);
			$mentor = ($this->input->post('mentor') === 'belum' ? FALSE : $this->input->post('mentor'));
			$this->pmodel->edit_kelompok($oldid,$data,$mentor);
			$data = array('pesan'=>"Pengubahan data kelompok {$idkel} berhasil!",'alamat'=>'info/kelompok/'.$idkel);
			$this->load->view($this->_team_view.'pesan',$data);
		} else {
			$this->edit('kelompok',$oldid,FALSE);
		}
	}
	
	private function get_bio($data,$cap = '') {
		$this->table->clear();
		if (isset($cap)) 
			$this->table->set_caption($cap);
		$faks = $this->config->item('fakultas');
		$name = $this->daftar->buat_nama($data->fname,$data->mname,$data->lname);
		$this->table->add_row('NPM',':',$data->npm);
		$this->table->add_row('Nama',':',$name);
		$this->table->add_row('Angkatan',':',$data->angkatan);
		if (array_key_exists($data->fakultas,$faks))
			$fak = 'Fakultas&nbsp;'.$faks[$data->fakultas];
		else
			$fak = '<span style="font-style:italic;">Belum ada data</span>';
		$this->table->add_row('Fakultas',':',$fak);
		$this->table->add_row('Jurusan',':',$data->jurusan);
		$this->table->add_row('E-mail',':',$data->email);
		$this->table->add_row('No. Hape',':',$data->no_hp);
		$this->table->add_row('Riwayat',':',$data->riwayat);
		return $this->table->generate();
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
