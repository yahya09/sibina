<html> 
<head>
<?php echo link_tag('aset/tambah.css') ?>

</head>
<body>
<div id="tabel"> 
<?php
$this->load->library('table');
$pilihan = array(
                'fk' => 'Kedokteran',
                'fkg' => 'Kedokteran Gigi',
				'fmipa' => 'Matematika & Ilmu Pengetahuan Alam',
				'ft' => 'Teknik',
				'fh' => 'Hukum',
				'fe' => 'Ekonomi',
				'fib' => 'Ilmu Pengetahuan Budaya',
                'fpsi' => 'Psikologi',
				'fisip' => 'Ilmus Sosial dan Ilmu Politik',
				'fkm' => 'Kesehatan Masyarakat',
				'fasilkom' => 'Ilmu Komputer',
				'fik' => 'Ilmu Keperawatan'
           );
	echo form_open('profil/tambah_mentee');
	echo form_hidden('kid',$kid);
	$this->table->add_row(form_label('NPM','npm'),form_input('npm'));
	$this->table->add_row(form_label('Nama Depan','fname'),form_input('fname'));
	$this->table->add_row(form_label('Nama Tengah','mname'),form_input('mname'));
	$this->table->add_row(form_label('Nama Belakang','lname'),form_input('lname'));
	$this->table->add_row(form_label('Angkatan','ang'),form_input(array('name'=>'ang','length'=>4)));
	$this->table->add_row(form_label('Fakultas','fak'),form_dropdown('fak',$pilihan));
	$this->table->add_row(form_label('Jurusan','jur'),form_input('jur'));
	$this->table->add_row(form_label('E-Mail','email'),form_input('email'));
	$this->table->add_row(form_label('No. HP','hape'),form_input(array('name'=>'hape','length'=>15)));
	$this->table->add_row(form_label('Riwayat','riw'),form_textarea(array('name'=>'riw','rows'=>10,'cols'=>40)));
	$this->table->add_row(form_submit('submit','Simpan'));
	echo $this->table->generate();
	echo form_close();
?>
</div>
</body>
</html>
