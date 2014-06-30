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
<script src="<?php echo base_url() ?>aset/boxy/javascripts/jquery.boxy.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("a.mentee").click(function(){
			var id = $(this).attr("name");
            $("#biomentee").load('<?php echo site_url('profil/mentee_detail') ?>',{mname: id},function(response, status, xhr) {});
        });
		$("a#tambah").css('text-decoration','none');
		$(function() {
			$("a[rel=boxy]").boxy({closeText: 'x', modal: true});
		});
	});
</script>
<h4>Daftar Mentee</h4>
<?php
	echo anchor('profil/tambah_mentee/'.$idkel,'Tambah mentee?',array('id'=>'tambah','rel'=>'boxy','title'=>'Tambah'));
	if(isset($mentee))
		echo $mentee;
	else
		echo "Ada kesalahan.";
?>
