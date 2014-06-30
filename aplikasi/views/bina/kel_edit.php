<script src="<?php echo base_url() ?>aset/date/datetimepicker_css.js"></script>
<script type="text/javascript">	
function kirim(isi) {
	var data = new Array();
	data[0] = $("input[name=oldid]").val();
	data[1] = $("input[name=id]").val();
	data[2] = $("input[name=tgl]").val();
	data[3] = $("[name=mentor]").val();
	//alert(data.toString());
	$(".boxy-content").load('<?php echo site_url("info/edit/kelompok"); ?>',{oldid: data[0],id: data[1],tgl: data[2],mentor: data[3],submit: true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('info/edit/kelompok',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	echo form_hidden('oldid',$info->id);
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="tambah">' );
	$image_properties = array(
          'src' => 'aset/date/images/cal.gif',
          'onclick' => "javascript:NewCssCal ('waktu','yyyyMMdd','arrow',false,'24')",
		  'style' => "cursor:pointer");
	$this->table->set_template($tmpl); 
	$this->table->add_row(form_label('ID* (maks. 6 karakter)','id'),form_input(array('name'=>'id','size'=>6,'maxlength'=>6,'value'=>$info->id)),form_error('id'));
	$this->table->add_row(form_label('Tanggal Terbentuk*','tgl'),form_input(array('name'=>'tgl','id'=>'waktu','class'=>'show-tooltip','title'=>'Klik tombol di samping','value'=>$info->tgl_terbentuk)).'&nbsp;'.img($image_properties),form_error('tgl'));
	$mentors['belum'] = '-belum ada-';
	$this->table->add_row(form_label('Mentor','tgl'),form_dropdown('mentor',$mentors,$mentor),form_error('mentor'));

	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>