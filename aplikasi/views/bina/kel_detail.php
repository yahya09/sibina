<script language="javascript">
$(document).ready(function() {
	$("a.mentee").click(function(){
		$("#biomentee").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr("name");
        //$("#biomentee").load('<?php echo site_url('info/detail/mentee') ?>',{npm: id},function(response, status, xhr) {});
		window.location.href = "<?php echo site_url('info/mentee') ?>/"+id;
    });
	$("a#tambah").css('text-decoration','none');
	$("a[rel=boxy]").click(function(event) {
		$(".boxy").append('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url('info/tambah/mentee/'.$idkel); ?>',{closeable: false, modal: true, title: 'Tambah Mentee', afterShow: function() {$(".boxy img").remove();}});
	});
	
	$("a#editkel").click(function(event){
        $(this).after('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" class="load" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url("info/edit/kelompok/{$idkel}"); ?>',{closeable: false, modal: true, title: 'Tambah Kelompok', afterShow: function() {$("a#editkel").next().remove();}});
	});
});
</script>

<a href="#" id="editkel" title="Edit">Ubah</a> <br />
<?php
	if (!isset($error)) {
		echo '<span id="mentor">NPM - Nama mentor: ';
		if ($npm) {
			echo $npm.' - '.$mentor;
		} else {
			echo '<span style="font-style:italic">'.$mentor.'</span>';
		}
		echo '</span><br />';
		echo '<span id="idkel">ID Kelompok&nbsp;:&nbsp;'.$idkel.'</span><br />';
		echo '<span id="tglkel">Tanggal terbentuk&nbsp;:&nbsp;'.$tglkel.'</span>';
	} else {
		echo 'Ada kesalahan: '.$error;
		echo '<br />';
		echo 'kid: '.$idkel;
	}
?>
<br />

<script type="text/javascript">

</script>
<h3>Daftar Mentee</h3>
<?php
	echo '<div class="boxy">';
	echo anchor('info/kelompok','Tambah mentee?',array('id'=>'tambah','rel'=>'boxy','title'=>'Tambah'));
	echo '</div>';
	if(isset($mentee))
		echo $mentee;
	else
		echo "Ada kesalahan.";
?>
