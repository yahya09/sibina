<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {
	var $_tampak_publik;
	var $_uname;
	public function __construct() {
		parent::__construct();
		$this->load->model('Log_model','lmodel');
        $this->load->library(array('table','form_validation'));
		$this->_tampak_publik = $this->config->item('public_view');
		$this->_uname = $this->session->userdata('logged_user');
	}

	public function index($kid = '') {
        $this->tinyauth->restrict();
        $daftar = $this->daftar->get_kelompok_ajax($this->_uname);
		$data = array('page_title'=>'Log Kegiatan','page_content'=>'log_dasar',
				'daftar'=>$daftar,'hal'=>'Log');
		$this->load->view($this->_tampak_publik,$data);
	}

	public function daftar_log() {
		$kid = $this->input->post('idkel');
		$daftar = '';
		$salah = '';
		if ($kid != '') {
			$daftar = $this->daftar->get_log_ajax($kid);
		} else {
			$salah = 'Ada kesalahan, coba refresh deh.';
		}
		$data = array('idkel'=>$kid,'daftar'=>$daftar,'salah'=>$salah);

		$this->load->view('log_daftar',$data);
	}

	public function log_detail() {
		$idlog = $this->input->post('idlog');
		if ($idlog != '') {
			$hasil = $this->lmodel->get_log_detail($idlog);
			if ($hasil === FALSE) {
				$data = array('error'=>'Data tidak ditemukan!','id'=>'false','kid'=>'false');
			} else {
				$data = $hasil[0];
				$this->table->add_row('Kelompok',':',$data->kid);
				$this->table->add_row('ID Log',':',$data->id);
				$this->table->add_row('Waktu',':',date("j F Y, G:i",strtotime($data->waktu)));
				$this->table->add_row('Tempat',':',$data->tempat);
				$this->table->add_row('Absensi',':',$data->absen);
				$this->table->add_row('Materi',':',$data->materi);
				$this->table->add_row('Deskripsi',':',$data->deskripsi);
				$this->table->add_row('Keterangan',':',$data->keterangan);

				$data = array('detail'=>$this->table->generate(),'id'=>$data->id,'kid'=>$data->kid,'jenis'=>'log');
				$this->table->clear();
			}
		} else {
			$data = array('error'=>'Data POST tidak ada.','id'=>'false','kid'=>'false');
		}
		$this->load->view('log_detail',$data);
	}

	public function kegiatan() {
		$this->tinyauth->restrict();
        $dafkeg = $this->daftar->get_kegiatan($this->_uname);
		$data = array('page_title'=>'Log Kegiatan','page_content'=>'log_dasar',
				'dafkeg'=>$dafkeg,'hal'=>'Kegiatan');
		$this->load->view($this->_tampak_publik,$data);
	}


	public function keg_detail() {
		$idkeg = $this->input->post('idkeg');
		if ($idkeg != '') {
			$hasil = $this->lmodel->get_keg_detail($idkeg);
			if ($hasil === FALSE) {
				$data = array('error'=>'Data tidak ditemukan!');
			} else {
				$data = $hasil[0];
				$this->table->add_row('ID Kegiatan',':',$data->id);
				$this->table->add_row('Tanggal',':',date("j F Y",strtotime($data->tanggal)));
				$this->table->add_row('Tempat',':',$data->tempat);
				$this->table->add_row('Kehadiran',':',$data->absen);
				$this->table->add_row('Jenis',':',$data->jenis);
				$this->table->add_row('Deskripsi',':',$data->deskripsi);

				$data = array('detail'=>$this->table->generate(),'jenis'=>'keg','kid'=>$idkeg,'id'=>'false');
				$this->table->clear();
			}
		} else {
			$data = array('error'=>'Data POST tidak ada.');
		}
		$this->load->view('log_detail',$data);
	}
	
	public function tambah_log($idkel = '') {
		if ($this->input->post('submit')) {
			if ($this->form_validation->run('log')) {
				$data = $this->make_data('log');
				$this->lmodel->tambah_log($data,$this->input->post('daftar'));
				$this->load->view('tambah_sukses',array('pesan'=>'Penambahan log berhasil!', 'alamat'=>'log'));
				return;
			} else {
				$this->load->view('tambah_sukses',array('pesan'=>'Ada yang salah!', 'alamat'=>'log'));
				return;
			}
		}
		$id = $this->lmodel->get_log_num($idkel) + 1;
		$newid = $idkel.'-'.$id;
		$mentees = $this->daftar->get_daftar_mentee($idkel);
		$data = array('kid'=>$idkel,'logid'=>$newid,'mentees'=>$mentees);
		$this->load->view('log_tambah',$data);
	}
	
	public function tambah_keg() {
		if ($this->input->post('submit')) {
			if ($this->form_validation->run('kegiatan')) {
				$data = $this->make_data('kegiatan');
				$orang = $this->input->post('ids');
				$orang[] = $this->_uname;
				$this->lmodel->tambah_keg($data,$orang);
				$this->load->view('tambah_sukses',array('pesan'=>'Harusnya berhasil!', 'alamat'=>'log/kegiatan'));
				return;
			} else {
				$this->load->view('tambah_sukses',array('pesan'=>'Ada yg salah!', 'alamat'=>'log/kegiatan'));
				return;
			}
		}
		$id = $this->lmodel->get_keg_num() + 1;
		$newid = 'km-'.$id;
		$mentees = $this->daftar->get_all_mentee($this->_uname);
		$data = array('kegid'=>$newid,'mentees'=>$mentees);
		$this->load->view('keg_tambah',$data);
	}

	public function edit_keg($idkeg = '') {
		if ($this->input->post('submit')) {
			if ($this->form_validation->run('kegiatan')) {
				$data = $this->make_data('keg');
				$orang = $this->input->post('ids');
				$orang[] = $this->_uname;
				$this->lmodel->edit_keg($data['id'],$data,$orang);
				$this->load->view('tambah_sukses',array('pesan'=>'Data log berhasil diubah!', 'alamat'=>'log/kegiatan'));
				return;
			} else {
				$this->load->view('tambah_sukses',array('pesan'=>'Ada kesalahan! <br />coba ulangi lagi..<br />', 'alamat'=>'log/kegiatan'));
				return;
				//$idkeg = $this->input->post('kegid');
			}
		}
		$hasil = $this->lmodel->get_keg_detail($idkeg);
		$info = $hasil[0];
		$mentees = $this->daftar->get_all_mentee($this->_uname);
		$hasil = $this->lmodel->get_terlibat($idkeg);
		$ceklis = array();
		foreach ($hasil as $row) {
			$ceklis[$row->npm] = true;
		}
		$data = array('mentees'=>$mentees,'info'=>$info,'ceklis'=>$ceklis);
		$this->load->view('keg_edit',$data);
	}
	
	public function edit_log($idlog = '', $kid = '') {
		if ($this->input->post('submit')) {
			if ($this->form_validation->run('log')) {
				$data = $this->make_data('log');
				$this->lmodel->edit_log($data['id'],$data,$this->input->post('daftar'));
				$this->load->view('tambah_sukses',array('pesan'=>'Data log berhasil diubah!', 'alamat'=>'log'));
				return;
			} else {
				$this->load->view('tambah_sukses',array('pesan'=>'Ada kesalahan! <br />coba ulangi lagi..<br />', 'alamat'=>'log'));
				return;
			}
		}
		$hasil = $this->lmodel->get_log_detail($idlog);
		$info = $hasil[0];
		$mentees = $this->daftar->get_daftar_mentee($kid);
		$cek = explode(",",$info->absen);
		$ceklis = array();
		foreach ($mentees as $key => $men) {
			if (in_array($men,$cek))
				$ceklis[$key] = true;
			else
				$ceklis[$key] = false;
		}
		$data = array('kid'=>$kid,'logid'=>$idlog,'mentees'=>$mentees,'data'=>$info,'ceklis'=>$ceklis);
		$this->load->view('log_edit',$data);
	}

	private function make_data($tipe = ''){
		if ($tipe == 'log') {
			$data = array(
						'id' => $this->input->post('logid'),
						'kid' => $this->input->post('kid'),
						'absen' => $this->input->post('absen'),
						'deskripsi' => $this->input->post('deskripsi'),
						'keterangan' => $this->input->post('ket'),
						'waktu' => $this->input->post('tgl'),
						'tempat' => $this->input->post('tempat'),
						'materi' => $this->input->post('materi')
					);
		} else {
			$data = array(
						'id' => $this->input->post('kegid'),
						'absen' => $this->input->post('absen'),
						'deskripsi' => $this->input->post('deskripsi'),
						'tanggal' => $this->input->post('tgl'),
						'tempat' => $this->input->post('tempat'),
						'jenis' => $this->input->post('jenis')
					);
		}
		return $data;
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
