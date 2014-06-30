<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {
	var $_tampak_publik;
	var $_uname;
	public function __construct() {
		parent::__construct();
		$this->load->model('Profil_model','pmodel');
        $this->load->library(array('table'));
		$this->_tampak_publik = $this->config->item('public_view');
		$this->_uname = $this->session->userdata('logged_user');
	}

	public function index($offset = NULL) {
        $this->tinyauth->restrict_level('mentor');
        $hasil = $this->pmodel->get_bio_mentor($this->_uname);
		if (!$hasil) {
			$data = array('page_title'=>'Profil','page_content'=>'profil','data'=>'Data tidak ditemukan!');
		} else {
			$data = $hasil[0];
			$data = array('page_title'=>'Profil','page_content'=>'profil','data'=>$this->get_bio($data),
				'daftar'=>$this->daftar->get_kelompok($this->_uname), 'img' => 'poto/'.$this->_uname,
				'uname'=>$this->_uname);
		}
		$this->load->view($this->_tampak_publik,$data);
	}

	public function kelompok($kid = '') {
		$this->tinyauth->restrict();
		if ($kid != '') {
			$hasil = $this->pmodel->get_kel_detail($kid);
			if (!$hasil) {
				$detail = 'Data kelompok tidak ditemukan';
			} else {
				$hasil = $hasil[0];
				$detail = $this->load->view('kel_detail',array('idkel'=>$hasil->id,'tglkel'=>$hasil->tgl_terbentuk,
					'mentee'=>$this->daftar->get_mentee_ajax($hasil->id)),TRUE);
			}
		} else {
			$detail = 'Pilih kelompok';
		}
		$data = array('page_title'=>'Profil Kelompok','page_content'=>'kel_dasar',
					'daftar'=>$this->daftar->get_kelompok_ajax($this->_uname),'detil'=>$detail);
		$this->load->view($this->_tampak_publik,$data);
	}
	
	public function kel_detail() {
		$kid = $this->input->post('idkel');
		if ($kid != '') {
			$hasil = $this->pmodel->get_kel_detail($kid);
			if (!$hasil) {
				$data = array('error'=>'Data tidak ditemukan','kid'=>$kid);
			} else {
				$hasil = $hasil[0];
				$data = array('idkel'=>$hasil->id,'tglkel'=>date("d M Y",strtotime($hasil->tgl_terbentuk)),
					'mentee'=>$this->daftar->get_mentee_ajax($hasil->id));
			}
		} else {
			$data = array('error'=>'Data POST tidak ada');
		}
		$this->load->view('kel_detail',$data);
	}
	
	public function mentee_detail($teks = FALSE) {
		$mname = $this->input->post('mname');
		if ($mname != '') {
			$hasil = $this->pmodel->get_bio_mentee($mname);
			if (!$hasil) {
				$data = array('error'=>'Data tidak ditemukan!');
			} else {
				$data = $hasil[0];
				$data = array('bio'=>$this->get_bio($data),'npm'=>$data->npm);
			}
		} else {
			$data = array('error'=>'Data POST tidak ada');
		}
		if (!$teks)
			$this->load->view('mentee_bio',$data);
		else
			return $this->load->view('mentee_bio',$data,TRUE);
	}
	
	public function tambah_mentee($kid = '') {
		$this->load->library('form_validation');
		if ($kid === '') {
			$kid = $this->input->post('kid');
		}
		if ($this->input->post('submit') == TRUE && $this->form_validation->run('biodata') == TRUE && $this->ceknpm($this->input->post('newnpm'))) {
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
			$this->pmodel->tambah_mentee($data,$this->input->post('kid'));
			$data = array('pesan'=>'Penambahan mentee berhasil!','alamat'=>'profil/kelompok/'.$this->input->post('kid'));
			$this->load->view('tambah_sukses',$data);
			return;
		}
		$this->load->view('mentee_tambah',array('kid'=>$kid,'pilihan'=>$this->config->item('fakultas')));
	}
	
	public function edit_mentee($npm = '') {
		if($this->input->post('submit') == FALSE) {
			$hasil = $this->pmodel->get_bio_mentee($npm);
			$data = $hasil[0];
			$this->load->view('mentee_edit',array('kid'=>$data->npm,'data'=>$data,'pilihan'=>$this->config->item('fakultas')));
		} else {
			if ($this->form_validation->run('biodata') === TRUE) {
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
				$this->pmodel->edit_mentee($data,$this->input->post('npm'));
				$alamat = 'profil/kelompok';
				$this->load->view('tambah_sukses',array('pesan'=>'Pengubahan data berhasil!','alamat'=>$alamat));
			} else {
				$hasil = $this->pmodel->get_bio_mentee($this->input->post('npm'));
				$data = $hasil[0];
				$this->load->view('mentee_edit',array('kid'=>$this->input->post('npm'),'data'=>$data,'pilihan'=>$this->config->item('fakultas')));
			}
		}
	}
	
	public function edit_bio($npm = '') {
		if($this->input->post('submit') == FALSE) {
			$hasil = $this->pmodel->get_bio_mentee($npm);
			$data = $hasil[0];
			$this->load->view('mentee_edit',array('kid'=>$data->npm,'data'=>$data,'pilihan'=>$this->config->item('fakultas'),'mentor'=>true));
		} else {
			if ($this->form_validation->run('biodata') === TRUE) {
				$data = array(
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
				$this->pmodel->edit_mentee($data,$this->input->post('npm'));
				$alamat = 'profil';
				$this->load->view('tambah_sukses',array('pesan'=>'Pengubahan data berhasil!','alamat'=>$alamat));
			} else {
				$hasil = $this->pmodel->get_bio_mentee($this->input->post('npm'));
				$data = $hasil[0];
				$this->load->view('mentee_edit',array('kid'=>$this->input->post('npm'),'data'=>$data,'pilihan'=>$this->config->item('fakultas'),'mentor'=>true));
			}
		}
	}
	
	private function get_bio($data,$cap = '') {
		$this->table->clear();
		$this->table->set_caption($cap);
		$faks = $this->config->item('fakultas');
		$name = $data->fname.' '.($data->mname != '' ? $data->mname.' ' : '').$data->lname;
		$this->table->add_row('NPM',':',$data->npm);
		$this->table->add_row('Nama',':',$name);
		$this->table->add_row('Angkatan',':',$data->angkatan);
		if (array_key_exists($data->fakultas,$faks))
			$fak = 'Fakultas&nbsp;'.$faks[$data->fakultas];
		else
			$fak = '<span>Belum ada data</span>';
		$this->table->add_row('Fakultas',':',$fak);
		$this->table->add_row('Jurusan',':',$data->jurusan);
		$this->table->add_row('E-mail',':',$data->email);
		$this->table->add_row('No. Hape',':',$data->no_hp);
		$this->table->add_row('Riwayat',':',$data->riwayat);
		return $this->table->generate();
	}
	
	public function ceknpm($npm) {
		if ($this->pmodel->cek_npm($npm)) {
			$this->form_validation->set_message('ceknpm', '%s yang dimasukkan sudah ada dalam database.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function upload($tipe = '') {
		if ($tipe === 'foto') {
			$config['upload_path'] = './poto/';
			$config['allowed_types'] = 'jpg';
			$config['max_size']	= '1024';
			$config['file_name'] = $this->_uname;
			$config['overwrite'] = TRUE;

			$this->load->library('upload', $config);
			//$nama = $this->input->post('userfile');
			if (!$this->upload->do_upload()) {
				$error = array('pesan' => 'Ada kesalahan: <br />'.$this->upload->display_errors(), 'alamat'=>'profil');
				$this->load->view('tambah_sukses', $error);
			} else {
				$pesan = $this->upload->data();
				//$data = array('pesan' => $nama.' Foto telah ditambahkan dengan nama '.$pesan['file_name'], 'alamat'=>'profil');
				$config['image_library'] = 'gd2';
				$config['source_image']	= $pesan['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				$config['height'] = 300;
				$this->load->library('image_lib', $config); 
				$this->image_lib->resize();
				//$this->load->view('tambah_sukses', $data);
				redirect('profil','refresh');
			}
		} else {
			$this->load->view('upload');
		}
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
