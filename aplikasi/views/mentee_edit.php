
<script type="text/javascript">
function kirim(isi) {
	var data = new Array();
	data[0] = $("input[name=npm]").val();
	data[1] = $("input[name=newnpm]").val();
	data[2] = $("input[name=fname]").val();
	data[3] = $("input[name=mname]").val();
	data[4] = $("input[name=lname]").val();
	data[5] = $("input[name=ang]").val();
	data[6] = $("[name=fak]").val();
	data[7] = $("input[name=jur]").val();
	data[8] = $("input[name=email]").val();
	data[9] = $("input[name=hape]").val();
	data[10] = $("[name=riw]").val();
	$(".boxy-content").load('<?php echo (isset($mentor) ? site_url("profil/edit_bio") : site_url("profil/edit_mentee")) ?>',{npm: data[0],newnpm: data[1],fname: data[2],mname: data[3],lname: data[4],ang: data[5],fak: data[6],jur: data[7],email: data[8],hape: data[9],riw: data[10],submit: true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('profil/edit_mentee',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="mytable">' );
	echo form_hidden('npm',$data->npm);
	$this->table->set_template($tmpl);
	$konfig = array('name'=>'newnpm','size'=>10,'value'=>$data->npm);
	if (isset($mentor) && $mentor)
		$konfig['readonly'] = 'readonly';
	$this->table->add_row(form_label('NPM*','newnpm'),form_input($konfig),form_error('newnpm'));
	$this->table->add_row(form_label('Nama Depan*','fname'),form_input(array('name'=>'fname','value'=>$data->fname)),form_error('fname'));
	$this->table->add_row(form_label('Nama Tengah','mname'),form_input(array('name'=>'mname','value'=>$data->mname)),form_error('mname'));
	$this->table->add_row(form_label('Nama Belakang*','lname'),form_input(array('name'=>'lname','value'=>$data->lname)),form_error('lname'));
	$this->table->add_row(form_label('Angkatan*','ang'),form_input(array('name'=>'ang','size'=>4,'value'=>$data->angkatan)),form_error('ang'));
	$this->table->add_row(form_label('Fakultas*','fak'),form_dropdown('fak',$pilihan,$data->fakultas),form_error('fak'));
	$this->table->add_row(form_label('Jurusan*','jur'),form_input(array('name'=>'jur','value'=>$data->jurusan)),form_error('jur'));
	$this->table->add_row(form_label('E-Mail','email'),form_input(array('name'=>'email','value'=>$data->email)),form_error('email'));
	$this->table->add_row(form_label('No. HP','hape'),form_input(array('name'=>'hape','size'=>15,'value'=>$data->no_hp)),form_error('hape'));
	$this->table->add_row(form_label('Riwayat','riw'),form_textarea(array('name'=>'riw','rows'=>10,'cols'=>40,'value'=>$data->riwayat)));
	$this->table->add_row(form_error('riw'));
	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>
