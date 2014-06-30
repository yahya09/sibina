<script type="text/javascript">
$(document).ready(function() {
    $("a.kel").click(function(){
		$("#detil").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).html();
        $("#detil").load('<?php echo site_url('info/detail/kelompok'); ?>',{idkel: id},function(response, status, xhr) {});
		$("#biomentee").html('');
    });
	$("a#tambah-kelompok").click(function(event) {
		$(this).after('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" class="load" />');
		event.preventDefault();
		Boxy.load('<?php echo site_url('info/tambah/kelompok'); ?>',{closeable: false, modal: true, title: 'Tambah Kelompok', afterShow: function() {$("a#tambah-kelompok").next().remove();}});
	});
});
</script>
<div class="in-content">
	<table width="100%">
		<tr>
			<td width="20%" style="text-align:left; vertical-align:top;">
				<h3 style="display:inline;">Daftar Kelompok</h3><br/>
				<a href="#" id="tambah-kelompok">Tambah kelompok?</a>
				<?php echo $daftar ?>
			</td>
			<td style="text-align:left; vertical-align:top">
				<h3 style="display:inline;">Profil Kelompok</h3>&nbsp;&nbsp;
				<div id="detil">
				<?php echo $detil ?>
				</div>

				<div id="biomentee">
				</div>
			</td>
		</tr>
	</table>
</div>
