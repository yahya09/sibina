<script type="text/javascript">
    $(document).ready(function() {
        $("a#log").click(function(event){
            event.preventDefault();
			Boxy.load('<?php echo site_url("log/edit_log/{$id}/{$kid}") ?>',{closeable: false, modal: true, title: 'Ubah Data Log'});
		});
		$("a#keg").click(function(event){
            event.preventDefault();
			Boxy.load('<?php echo site_url("log/edit_keg/{$kid}") ?>',{closeable: false, modal: true, title: 'Ubah Data Log'});
		});
	});
 </script>
 
<?php
if (isset($detail)) {
	echo '<a href="#" id="'.$jenis.'" title="Edit" rel="boxy">Ubah</a>';
	echo $detail;
} else {
	echo $error;
}
?>