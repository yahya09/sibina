<div id="submenu">
<?php
    if ($this->tinyauth->check_level('mentor')) {
        echo anchor('log','Mentoring');
        echo anchor('log/kegiatan','Kegiatan');
    }
?>
</div>

<div class="in-content">

<script type="text/javascript">
	$(document).ready(function() {
		$("a.kel").click(function(){
			var id = $(this).html();
            $("#daflog").load('<?php echo site_url('log/daftar_log') ?>',{idkel: id},function(response, status, xhr) {});
			$("#detlog").html('<p>Pilih kelompok lalu pilih log mentoring.</p>');
        });
		$("a#tambahkeg").click(function(event) {
			event.preventDefault();
			Boxy.load('<?php echo site_url("log/tambah_keg") ?>',{closeable: false, modal: true, title: 'Tambah Log Kegiatan', fixed: false});
		});
		$("a.kegitem").click(function(event) {
			var id = $(this).attr('name');
			$("#detlog").load('<?php echo site_url('log/keg_detail') ?>',{idkeg: id},function(response, status, xhr) {});
		});
	});
</script>
	
    <table width="100%">
      <tr>
        <td width="20%" style="text-align:left; vertical-align:top;">
			<?php if (isset($daftar)) {
				echo '<h3>Daftar Kelompok</h3>';
				echo $daftar;
				}
			?>        
        </td>
        <td style="text-align:left; vertical-align:top">
			<h3>Daftar <?php echo $hal ?></h3>
			<div id="daflog">
			<?php
				if (!isset($dafkeg)) {
					echo '<p>Pilih kelompok.</p>';
				} else {
					echo anchor('kegiatan','Tambah log kegiatan?',array('id'=>'tambahkeg','title'=>'Tambah Kegiatan'));
					echo '<p>'.$dafkeg.'</p>';
				}
			?>
			</div>

			<h3>Detail <?php echo $hal ?></h3>
			<div id="detlog">
				<?php
				if (!isset($dafkeg)) {
					echo '<p>Pilih kelompok lalu pilih log mentoring.</p>';
				} else {
					echo '<p>Pilih log kegiatan.</p>';
				}
				?>
			</div>
        </td>
      </tr>
    </table>

</div>