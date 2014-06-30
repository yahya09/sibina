<?php
$config =
	array(
		'biodata' => array(
						array('field' => 'newnpm','label' => 'NPM','rules' => 'required|exact_length[10]|numeric'),
						array('field' => 'fname','label' => 'Nama depan','rules' => 'required|alpha'),
						array('field' => 'mname','label' => 'Nama tengah','rules' => 'alpha'),
						array('field' => 'lname','label' => 'Nama belakang','rules' => 'alpha'),
						array('field' => 'ang','label' => 'Angkatan','rules' => 'required|numeric|exact_length[4]'),
						array('field' => 'fak','label' => 'Fakultas','rules' => 'required|alpha'),
						array('field' => 'jur','label' => 'Jurusan','rules' => 'required'),
						array('field' => 'email','label' => 'Email','rules' => 'valid_email'),
						array('field' => 'hape','label' => 'No.HP','rules' => 'numeric|max_length[12]'),
						array('field' => 'riw','label' => 'Riwayat','rules' => 'trim|xss_clean')
						),
		'log' => array(
						array('field' => 'tempat','label' => 'Tempat','rules' => 'required'),
						array('field' => 'tgl','label' => 'Waktu','rules' => 'required'),
						array('field' => 'absen','label' => 'Kehadiran','rules' => 'required'),
						array('field' => 'deskripsi','label' => 'Deskripsi','rules' => 'trim|xss_clean|required'),
						array('field' => 'materi','label' => 'Materi','rules' => 'trim|xss_clean|required'),
						array('field' => 'ket','label' => 'Keterangan','rules' => 'trim|xss_clean|required')
						),
		'kegiatan' => array(
						array('field' => 'tempat','label' => 'Tempat','rules' => 'required'),
						array('field' => 'tgl','label' => 'Waktu','rules' => 'required'),
						array('field' => 'absen','label' => 'Kehadiran','rules' => 'required'),
						array('field' => 'deskripsi','label' => 'Deskripsi','rules' => 'trim|xss_clean|required'),
						array('field' => 'jenis','label' => 'Jenis Kegiatan','rules' => 'trim|xss_clean|required')
						),
		'kelompok' => array (
						array('field' => 'id','label' => 'ID','rules' => 'required|max_length[6]'),
						array('field' => 'tgl','label' => 'Tanggal','rules' => 'required'),
						array('field' => 'mentor','label' => 'Mentor','rules' => 'required|max_length[10]')
						)
	   );
?>
