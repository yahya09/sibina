<head><?php echo link_tag('aset/boxy/stylesheets/boxy.css'); ?></head>
<?php
	if (isset($idkel)) {
		echo '<span id="idkel">ID Kelompok&nbsp;:&nbsp;'.$idkel.'</span><br />';
		echo '<span id="tglkel">Tanggal terbentuk&nbsp;:&nbsp;'.$tglkel.'</span>';
	} else {
		echo 'Ada kesalahan: '.$error;
		echo '<br />';
		echo 'kid: '.$kid;
	}
?>
<br />

<script type="text/javascript">
$(document).ready(function() {
	$("a.mentee").click(function(){
		$("#biomentee").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr("name");
        $("#biomentee").load('<?php echo site_url('profil/mentee_detail') ?>',{mname: id},function(response, status, xhr) {});
    });
	$("a#tambah").css('text-decoration','none');
	$("a[rel=boxy]").click(function(event) {
		event.preventDefault();
		Boxy.load('<?php echo site_url("profil/tambah_mentee/{$idkel}") ?>',{closeable: false, modal: true, title: 'Tambah Mentee'});
	});
});
</script>
<h3>Daftar Mentee</h3>
<?php
	echo anchor('profil/kelompok','Tambah mentee?',array('id'=>'tambah','rel'=>'boxy','title'=>'Tambah'));
	echo '<br />';
	if(isset($mentee))
		echo $mentee;
	else
		echo "Ada kesalahan.";
?>
