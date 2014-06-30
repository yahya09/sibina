
<script type="text/javascript">

	function tes(elem) {
		//var val = $("input[name=npm]").val();
		//if(val  '' )
		//alert("isi: " + elem.value +".");
		var isian = document.getElementById('isian');
		alert("tipe: "+isian.elements[0].type+". isi:"+isian.elements[0].value);
		//var rah = isian.element[0];
		//alert("kid: "+rah.value);
	}
	function kirim(isi) {
		var data = new Array();
		data[0] = $("input[name=kid]").val();
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
		//alert("kel: "+data[1]);
		$(".boxy-content").load('<?php echo site_url("profil/tambah_mentee") ?>',{kid: data[0],newnpm: data[1],fname: data[2],mname: data[3],lname: data[4],ang: data[5],fak: data[6],jur: data[7],email: data[8],hape: data[9],riw: data[10],submit: true},function(response, status, xhr) {});
		return false;
	}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('profil/tambah_mentee',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	echo form_hidden('kid',$kid);
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="mytable">' );
	$this->table->set_template($tmpl); 
	$this->table->add_row(form_label('NPM*','npm'),form_input(array('name'=>'newnpm','size'=>10)),form_error('newnpm'));
	$this->table->add_row(form_label('Nama Depan*','fname'),form_input('fname'),form_error('fname'));
	$this->table->add_row(form_label('Nama Tengah','mname'),form_input('mname'),form_error('mname'));
	$this->table->add_row(form_label('Nama Belakang*','lname'),form_input('lname'),form_error('lname'));
	$this->table->add_row(form_label('Angkatan*','ang'),form_input(array('name'=>'ang','size'=>4,'class'=>'required')),form_error('ang'));
	$this->table->add_row(form_label('Fakultas*','fak'),form_dropdown('fak',$pilihan),form_error('fak'));
	$this->table->add_row(form_label('Jurusan*','jur'),form_input('jur'),form_error('jur'));
	$this->table->add_row(form_label('E-Mail','email'),form_input('email'),form_error('email'));
	$this->table->add_row(form_label('No. HP','hape'),form_input(array('name'=>'hape','size'=>15)),form_error('hape'));
	$this->table->add_row(form_label('Riwayat','riw'),form_textarea(array('name'=>'riw','rows'=>10,'cols'=>40)));
	$this->table->add_row(form_error('riw'));
	$js = 'onClick="kirim(this)"';
	//echo form_button('mybutton', 'Click Me', $js); 
	//$this->table->add_row(form_button('submit','Simpan',$js),'<a href="#" onclick="Boxy.get(this).hide();">Batal</a>');
	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>
