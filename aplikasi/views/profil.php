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
        $("input#unggah").click(function(){
			Boxy.load('<?php echo site_url("profil/upload") ?>',{closeable: false, modal: true, title: 'Unggah Foto'});
        });
		$("a#foto").hover(function() {
			$("a#foto > img").attr('src','<?php echo base_url().$img.'.jpg'; ?>');
        }, function() {
			$("a#foto > img").attr('src','<?php echo base_url().$img.'_thumb.jpg'; ?>');
        });
		$("a#edit").click(function(event){
            event.preventDefault();
			Boxy.load('<?php echo site_url("profil/edit_bio/{$uname}") ?>',{closeable: false, modal: true, title: 'Ubah Biodata'});
		});
	});
</script>
<div class="in-content">
	<h3>Profil</h3>
    <div id="left-cont">
	<a id="foto" href="<?php echo base_url().$img.'.jpg'; ?>"><img src="<?php echo base_url().$img.'_thumb.jpg'; ?>" alt="Ini harusnya foto mentor" /> </a><br />
	<input type="button" id="unggah" value="Unggah Foto" />
    </div>
	<h3 style="display:inline;">Biodata</h3>&nbsp;&nbsp;<a href="#" id="edit" title="Edit">Ubah</a><br />
	<?php echo $data ?>

    <h3>Daftar Kelompok</h3>
	<?php echo $daftar ?>
</div>