<script src="<?php echo base_url() ?>aset/date/datetimepicker_css.js"></script>
<script type="text/javascript">
	function kirim(borang) {
		var isi = new Array();
		var mid = new Array();
		$("input[name=absen]").filter(':checked').each(function(ind) {
				isi[ind] = $(this).val();
				mid[ind] = $(this).attr('id');
			});
		var data = new Array();
		data[0] = $("input[name=kegid]").val();
		data[1] = $("input[name=tgl]").val();
		data[2] = $("input[name=tempat]").val();
		data[3] = $("input[name=jenis]").val();
		data[4] = $("[name=deskripsi]").val();
		//alert("deskripsi: "+data[6]);
		$(".boxy-content").load('<?php echo site_url("log/edit_keg") ?>',{kegid:data[0], tgl:data[1], tempat:data[2], jenis:data[3], deskripsi:data[4], absen:isi.toString(), ids:mid, submit:true},function(response, status, xhr) {});
		return false;
	}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	$absen = '';
	foreach ($mentees as $key => $mentee) {
		$data = array(
				'name' => 'absen',
				'value' => $mentee,
				'id' => $key,
				'checked' => (array_key_exists($key,$ceklis) ? 'checked' : '')
				);
		$absen .= form_checkbox($data).$mentee.'<br />';
	}
	echo form_open('log/tambah_keg',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	echo form_hidden('kegid',$info->id);
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="mytable">' );
	$this->table->set_template($tmpl);
	$image_properties = array(
          'src' => 'aset/date/images/cal.gif',
          'onclick' => "javascript:NewCssCal ('waktu','yyyyMMdd','dropdown',false,'24')",
		  'style' => "cursor:pointer");
	$this->table->add_row(form_label('Tanggal','tgl'),form_input(array('name'=>'tgl','id'=>'waktu','class'=>'show-tooltip','title'=>'Klik tombol di samping','value'=>$info->tanggal)).'&nbsp;'.img($image_properties),form_error('tgl'));
	$this->table->add_row(form_label('Tempat','tempat'),form_input(array('name'=>'tempat','value'=>$info->tempat)),form_error('tempat'));
	$this->table->add_row(form_label('Kehadiran','absen'),$absen,form_error('absen'));
	$this->table->add_row(form_label('Jenis Kegiatan','jenis'),form_input(array('name'=>'jenis','value'=>$info->jenis)),form_error('jenis'));
	$this->table->add_row(form_label('Deskripsi','deskripsi'),form_textarea(array('name'=>'deskripsi','rows'=>7,'cols'=>40,'value'=>$info->deskripsi)),form_error('deskripsi'));

	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();" >Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>
