<script type="text/javascript">
	$(document).ready(function() {
		//alert("masuk!");
		$("a.logitem").click(function(){
			var id = $(this).attr("name");
            $("#detlog").load('<?php echo site_url('log/log_detail') ?>',{idlog: id},function(response, status, xhr) {});
        });
		$("a[id=tambah]").click(function(event) {
			event.preventDefault();
			Boxy.load('<?php echo site_url("log/tambah_log/{$idkel}") ?>',{closeable: false, modal: true, title: 'Tambah Log Mentoring', dragable: true});
		});
	});
</script>
<?php
echo anchor('log','Tambah log mentoring?',array('id'=>'tambah','rel'=>'boxy','title'=>'Tambah'));
if (isset($daftar))
	echo $daftar;
else
	echo $salah;
?>
