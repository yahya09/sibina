<script type="text/javascript">
function kirim(isi) {
	$("input[value=Simpan]").after('<img src="<?php echo base_url().'aset/loads.gif'; ?>" />');
	var name = $("[name=nama]").val();
	$(".boxy-content").load('<?php echo site_url("info/tambah/mentor"); ?>',{newnpm: name, mentee: true,submit: true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('info/tambah/mentor',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="tambah">' );
	$this->table->add_row(form_label('Nama Mentor*','nama'),form_dropdown('nama',$pilihan));
	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>