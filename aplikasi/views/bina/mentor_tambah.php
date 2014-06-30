<script type="text/javascript">
function kirim(isi) {
	$("input[value=Simpan]").after('<img src="<?php echo base_url().'aset/loads.gif'; ?>" />');
	var data = new Array();
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
	$(".boxy-content").load('<?php echo site_url("info/tambah/mentor"); ?>',{newnpm: data[1],fname: data[2],mname: data[3],lname: data[4],ang: data[5],fak: data[6],jur: data[7],email: data[8],hape: data[9],riw: data[10],mentee: false,submit: true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('info/tambah/mentee',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="tambah">' );
	$this->table->set_template($tmpl); 
	$this->table->add_row(form_label('NPM*','newnpm'),form_input(array('name'=>'newnpm','size'=>10)).'&nbsp;'.form_label('Ang.*','ang').'&nbsp;'.form_input(array('name'=>'ang','size'=>4,'class'=>'required')));
	$this->table->add_row(form_error('newnpm'),form_error('ang'));
	$this->table->add_row(form_label('Nama*','fname'),form_input('fname').'*&nbsp;'.form_input('mname').'&nbsp;'.form_input('lname').'*');
	$this->table->add_row(form_error('fname'),form_error('mname'),form_error('lname'));
	$this->table->add_row(form_label('Fakultas*','fak'),form_dropdown('fak',$pilihan).form_error('fak'));
	$this->table->add_row(form_label('Jurusan*','jur'),form_input('jur').form_error('jur'));
	$this->table->add_row(form_label('E-Mail','email'),form_input('email').form_error('email'));
	$this->table->add_row(form_label('No. HP','hape'),form_input(array('name'=>'hape','size'=>15)).form_error('hape'));
	$this->table->add_row(form_label('Riwayat','riw'),form_textarea(array('name'=>'riw','rows'=>10,'cols'=>40)));
	$this->table->add_row(form_error('riw'));
	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>
