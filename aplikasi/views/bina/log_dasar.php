<script type="text/javascript">
$(document).ready(function() {
	$("a.kel").click(function(){
		$("#daflog").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).html();
        $("#daflog").load('<?php echo site_url('data/mentoring/daftar') ?>',{idkel: id},function(response, status, xhr) {});
		$("#detlog").html('<p>Pilih kelompok lalu pilih log mentoring.</p>');
    });
    $("a.mentor").click(function(){
		$("#daflog").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr('id');
        $("#daflog").load('<?php echo site_url('data/kegiatan/daftar') ?>',{npm: id},function(response, status, xhr) {});
		$("#detlog").html('<p>Pilih mentor lalu pilih log kegiatan.</p>');
    });
});
</script>
<div class="in-content">
	<table width="100%">
		<tr>
			<td width="20%" style="text-align:left; vertical-align:top;">

				<h3>Daftar Kelompok</h3>
				<?php
					echo $daftar;
				?>
			</td>
			<td style="text-align:left; vertical-align:top">
				<h3>Daftar <?php echo $hal ?></h3>
				<div id="daflog">
				<?php
					if (!isset($dafkeg)) {
						echo '<p>Pilih kelompok.</p>';
					} else {
						echo '<p>'.$dafkeg.'</p>';
					}
				?>
				</div>

				<h3>Detail <?php echo $hal ?></h3>
				<div id="detlog">
				<?php
					if ($hal !== 'Kegiatan') {
						echo '<p>Pilih kelompok lalu pilih log mentoring.</p>';
					} else {
						echo '<p>Pilih mentor lalu pilih log kegiatan.</p>';
					}
				?>
				</div>
			</td>
		</tr>
	</table>
</div>
