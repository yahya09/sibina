<script type="text/javascript">
function kirim(isi) {
	$("input[value=Simpan]").after('&nbsp;<img src="<?php echo base_url().'aset/loads.gif'; ?>" />');
	var stat = $("[name=status]").val();
	$(".boxy-content").load('<?php echo site_url("info/ubah/status/".$npm); ?>',{status: stat, submit: true},function(response, status, xhr) {});
	return false;
}
</script>
<div id="tabel">
<?php
	$this->load->library('table');
	echo form_open('info/tambah/mentor',array('id' => 'isian','onsubmit'=>"return kirim(this)"));
	//echo form_hidden('npm',$npm);
	$tmpl = array ( 'table_open'  => '<table style="text-align:left;" class="tambah">' );
	$this->table->add_row(form_label('Status','status'),form_dropdown('status',$pilihan));
	$this->table->add_row(form_submit('submit','Simpan'),'<a href="#" onclick="Boxy.get(this).hideAndUnload();">Batal</a>');
	echo $this->table->generate();
	echo form_close();
?>
</div>