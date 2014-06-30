<div id="submenu">
<?php
    if ($this->tinyauth->check_level('mentor')) {
        echo anchor('profil/biodata','Biodata');
        echo anchor('profil/kelompok','Kelompok');
    }
?>
</div>
 <script type="text/javascript">
    $(document).ready(function() {
        $("a.kel").click(function(){
			var id = $(this).html();
            $("#detil").load('<?php echo site_url('profil/kel_detail') ?>',{idkel: id},function(response, status, xhr) {});
			$("#biomentee").html('');
        });
	});
 </script>
<h3>Daftar Kelompok</h3>
<?php echo $daftar ?>

<h3>Profil Kelompok</h3>
<div id="detil">
<?php echo $detil ?>
</div>

<div id="biomentee">
</div>