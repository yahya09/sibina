<script type="text/javascript">
	$(document).ready(function() {
        $("a.mentor").click(function(){
			$("#dafkel").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
			var id = $(this).attr('id');
            $("#dafkel").load('<?php echo site_url('data/kelompok') ?>',{npm: id},function(response, status, xhr) {});
			$("#detail").html('<p>Pilih mentor lalu pilih kelompok.</p>');
        });
	});
</script>
<div class="in-content">
<table width="100%">
<tr>
	<td width="20%" style="text-align:left; vertical-align:top;">
		<h3>Daftar Mentor</h3>
		<?php
		    echo $dafmentor;
		?>
		<h3>Daftar Kelompok</h3>
		<div id="dafkel">
			<p>Pilih mentor dulu.</p>
		</div>
	</td>
	<td style="text-align:left; vertical-align:top">
		<h3>Evaluasi Kehadiran</h3>
		<div id="detail">
			<p>Pilih mentor lalu pilih kelompok.</p>
		</div>
	</td>
</tr>
</table>
</div>