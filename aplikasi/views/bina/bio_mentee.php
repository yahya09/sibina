<script type="text/javascript">
$(document).ready(function() {
	$("a#edit-mentee").click(function(event){
		$(this).after('&nbsp;&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url("info/edit/mentee/".$npm); ?>',{closeable: false, modal: true, title: 'Ubah Biodata',afterShow: function() {$("a#edit-mentee").next().remove();}});
	});
	$("a#edit-status").click(function(event){
		$(this).after('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url("info/ubah/status/".$npm); ?>',{closeable: false, modal: true, title: 'Ubah Biodata',afterShow: function() {$("a#edit-status").next().remove();}});
	});
});
</script>
<div class="bio">
<h4 style="display:inline;">Biodata</h4>&nbsp;&nbsp;<a href="#" id="edit-mentee" title="Edit" >Ubah</a><br />
<?php
	if(isset($bio))
		echo $bio;
?>
</div>
<br />
<div id="info-kelompok">
<h4 style="display:inline;">Informasi Kelompok</h4>
<br />
Tergabung di kelompok&nbsp;:&nbsp;<?php echo anchor('info/kelompok/'.$idkel,$idkel) ?>
<br />
Mentor&nbsp;:&nbsp;<?php echo anchor('info/mentor/'.$mentor,$mentorname) ?>
<br />
Status&nbsp;:&nbsp;<span id="stat"><?php echo $status ?></span>.&nbsp;&nbsp;<a href="#" id="edit-status" title="Edit" >Ubah</a><br />
<br />
Presentase kehadiran&nbsp;:&nbsp;<?php echo $rekap ?>
</div>
