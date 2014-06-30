<script src="<?php echo base_url() ?>aset/date/datetimepicker_css.js"></script>
<script type="text/javascript">
function kirim(isian) {
	var isi = new Array();
	var npm = new Array();
	$("input[name=absen]").filter(':checked').each(function(ind) {
			isi[ind] = $(this).val();
			npm[ind] = $(this).attr('id');
		});
	var data = new Array();
	data[0] = $("input[name=kid]").val();
	data[1] = $("input[name=logid]").val();
	data[2] = $("input[name=tgl]").val();
	data[3] = $("input[name=tempat]").val();
	data[4] = $("input[name=materi]").val();
	data[5] = $("[name=deskripsi]").val();
	data[6] = $("[name=ket]").val();
	//alert("npm: "+npm.toString());
	$(".boxy-content").load('<?php echo site_url("log/tambah_log") ?>',{kid:data[0], logid:data[1], tgl:data[2], tempat:data[3], materi:data[4], deskripsi:data[5], ket:data[6], absen:isi.toString(), daftar:npm, submit:true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	$absen = '';
	foreach ($mentees as $npm => $mentee) {
		$data = array(
				'name' => 'absen',
				'id' => $npm,
				'value' => $mentee
				);
		$absen .= form_checkbox($data).$mentee.'<br />';
	}
	echo form_open('log/tambah_log',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	echo form_hidden('kid',$kid);
	echo form_hidden('logid',$logid);
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="mytable">' );
	$this->table->set_template($tmpl);
	$image_properties = array(
          'src' => 'aset/date/images/cal.gif',
          'onclick' => "javascript:NewCssCal ('waktu','yyyyMMdd','arrow',true,'24')",
		  'style' => "cursor:pointer");
	$this->table->add_row(form_label('Tanggal','tgl'),form_input(array('name'=>'tgl','id'=>'waktu','class'=>'show-tooltip','title'=>'Klik tombol di samping')).'&nbsp;'.img($image_properties),form_error('tgl'));
	$this->table->add_row(form_label('Tempat','tempat'),form_input(array('name'=>'tempat')),form_error('tempat'));
	$this->table->add_row(form_label('Kehadiran','absen'),$absen,form_error('absen'));
	$this->table->add_row(form_label('Materi','materi'),form_input(array('name'=>'materi')),form_error('materi'));
	$this->table->add_row(form_label('Deskripsi','deskripsi'),form_textarea(array('name'=>'deskripsi','rows'=>7,'cols'=>40)),form_error('deskripsi'));
	$this->table->add_row(form_label('Keterangan','ket'),form_textarea(array('name'=>'ket','rows'=>5,'cols'=>40)),form_error('ket'));

	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();" >Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>
