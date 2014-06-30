<script src="<?php echo base_url() ?>aset/jquery.tooltip.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#foto').tooltip({ 
		delay: 0,
		showURL: false, 
		bodyHandler: function() {
			return $("<img/>").attr("src", $("a.preview").attr('href')); 
		}
	});
	$("a#edit-mentor").click(function(event){
		$(this).after('<img src="<?php echo base_url().'aset/load2.gif'; ?>" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url("info/edit/mentor/".$npm); ?>',{closeable: false, modal: true, title: 'Ubah Biodata',afterShow: function() {$("a#edit-mentor").next().remove();}});
	});
});
</script>
<div id="left-cont">
<?php $path = 'poto/'.$npm.'.jpg'; 
?>
<?php if(file_exists($path)) : ?>
<a class="preview" href="<?php echo base_url().$path; ?>"><img id="foto" src="<?php echo base_url().'poto/'.$npm.'_thumb.jpg'; ?>" alt="Ini harusnya foto mentor" /> </a><br />
<?php else : ?>
<p>Belum ada Foto yang diunggah.</p>
<?php endif;?>
<!-- <input type="button" id="unggah" value="Unggah Foto" /> -->
</div>
<div class="bio">
<h4 style="display:inline;">Biodata</h4>&nbsp;&nbsp;<a href="#" id="edit-mentor" title="Edit" >Ubah</a><br />
<?php
	if(isset($bio))
		echo $bio;
?>
</div>
<br />
<div id="daf-kelompok">
<h4 style="display:inline;">Daftar Kelompok</h4>
<br />
<?php echo $daftar ?>
</div>
<br />
<div id="akun-info">
<h4 style="display:inline;">Informasi Akun untuk Login</h4>
<br />
Username : <?php echo $npm; ?> <br />
Password : <?php echo $pwd; ?>
</div>