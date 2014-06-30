<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Risalah extends CI_Controller {
	var $_team_view;
    var $_public_view;
    var $_page_view;
	var $_uname;
	public function __construct() {
		parent::__construct();
		$this->load->model('Log_model','lmodel');
        $this->load->library(array('table'));
		$this->_public_view = $this->config->item('public_view');
        $this->_team_view = $this->config->item('team_view');
        $this->_page_view = $this->_team_view.$this->_public_view;
		$this->_uname = $this->session->userdata('logged_user');
	}

	public function index() {
        $this->tinyauth->restrict_level('pembinaan');
        $this->mentoring();
	}

	public function mentoring($mode = 'awal', $idlog = '') {
        if ($mode === 'awal') {
            $detil = "Pilih kelompok.";
            $data = array('page_title'=>'Data Kelompok','page_content'=>$this->_team_view.'log_dasar',
                        'daftar'=>$this->daftar->get_all_kelompok(),'detil'=>$detil,'hal'=>'Log Mentoring');
            $this->load->view($this->_page_view,$data);
        } elseif ($mode === 'daftar') {
            $idkel = $this->input->post('idkel');
            $daftar = $this->daftar->get_log_ajax($idkel);
            $data = array('daftar'=>$daftar);
            $this->load->view($this->_team_view.'log_daftar',$data);
        } else {
            $detil = $this->log_detail($this->input->post('idlog'));
            if ($detil !== FALSE) 
                $data = array('detil'=>$detil);
            else
                $data = array('salah'=>'Ada kesalahan.');
            $this->load->view($this->_team_view.'log_detail',$data);
        }
	}
    
    public function kegiatan($mode = 'awal', $idkeg = '') {
        if ($mode === 'awal') {
            $detil = "Pilih mentor.";
            $data = array('page_title'=>'Data Kegiatan','page_content'=>$this->_team_view.'log_dasar',
                        'daftar'=>$this->daftar->get_all_mentor(),'detil'=>$detil,'hal'=>'Kegiatan');
            $this->load->view($this->_page_view,$data);
        } elseif ($mode === 'daftar') {
            $npm = $this->input->post('npm');
            $daftar = $this->daftar->get_kegiatan($npm);
            $data = array('daftar'=>$daftar);
            $this->load->view($this->_team_view.'log_daftar',$data);
        } else {
            $detil = $this->keg_detail($this->input->post('idkeg'));
            if ($detil !== FALSE) 
                $data = array('detil'=>$detil);
            else
                $data = array('salah'=>'Ada kesalahan.');
            $this->load->view($this->_team_view.'log_detail',$data);
        }
	}
    
    public function evaluasi($npm = '') {
        $dafmentor = $this->daftar->get_all_mentor();
		$data = array('page_title'=>'Evaluasi Mentoring','page_content'=>'bina/eval_dasar',
					'dafmentor'=>$dafmentor);
		$this->load->view($this->_page_view,$data);
	}
	
	public function kelompok() {
		$npm = $this->input->post('npm');
		if ($npm) {
			$data = $this->daftar->get_kelompok_ajax($npm);
		} else {
			$data = 'Ada kesalahan, coba di-refresh halamannya.';
		}
		$this->load->view($this->_team_view.'eval_kel',array('daftar'=>$data));
	}
	
	public function eval_detil() {
		$idkel = $this->input->post('idkel');
		if ($idkel) {
			$this->table->clear();
			$total = $this->lmodel->get_total_log($idkel);
			if ($total > 0) {
				$pesan = '<p>Total log mentoring&nbsp;:&nbsp;'.$total.'</p>';
				$mentee = $this->daftar->get_daftar_mentee($idkel);
				
				$this->table->set_heading('NPM','Nama Mentee','Kehadiran','Presentase');
				foreach ($mentee as $npm => $name) {
					$hadir = $this->lmodel->get_kehadiran($npm);
					$persen = (100*$hadir) / $total;
					$this->table->add_row($npm,$name,$hadir,number_format($persen,2,',','').' %');
				}
				$data = $pesan.$this->table->generate();
			} else {
				$data = 'Belum ada data log tersimpan untuk kelompok '.$idkel.'.';	
			}			
		} else {
			$data = "Ada kesalahan rikues data, hayo jangan maen-maen ya! ^^.";
		}
		$this->load->view($this->_team_view.'eval_detil',array('data'=>$data));
	}
    
    private function log_detail($idlog = '') {
        $hasil = $this->lmodel->get_log_detail($idlog);
        if ($hasil === FALSE) {
            return $hasil;
        } else {
            $data = $hasil[0];
            $this->table->clear();
            $this->table->add_row('Kelompok',':',$data->kid);
            $this->table->add_row('ID Log',':',$data->id);
            $this->table->add_row('Waktu',':',date("j F Y, G:i",strtotime($data->waktu)));
            $this->table->add_row('Tempat',':',$data->tempat);
            $this->table->add_row('Absensi',':',$data->absen);
            $this->table->add_row('Materi',':',$data->materi);
            $this->table->add_row('Deskripsi',':',$data->deskripsi);
            $this->table->add_row('Keterangan',':',$data->keterangan);

            return $this->table->generate();
        }
	}
    
    public function keg_detail($idkeg = '') {
        $hasil = $this->lmodel->get_keg_detail($idkeg);
        if ($hasil === FALSE) {
            return $hasil;
        } else {
            $data = $hasil[0];
            $this->table->clear();
            $this->table->add_row('ID Kegiatan',':',$data->id);
            $this->table->add_row('Tanggal',':',date("j F Y",strtotime($data->tanggal)));
            $this->table->add_row('Tempat',':',$data->tempat);
            $this->table->add_row('Kehadiran',':',$data->absen);
            $this->table->add_row('Jenis',':',$data->jenis);
            $this->table->add_row('Deskripsi',':',$data->deskripsi);

            return $this->table->generate();
        }
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
