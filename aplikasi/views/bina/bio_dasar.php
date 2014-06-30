<script type="text/javascript">
$(document).ready(function() {
	<?php if ($hal == 'Mentee'): ?>
	$("a.mentee").click(function(){
		$("#detail").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr('id');
        $("#detail").load('<?php echo site_url('info/detail/mentee') ?>',{npm: id},function(response, status, xhr) {});
    });
    <?php else: ?>
    $("a.mentor").click(function(){
		$("#detail").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr('id');
        $("#detail").load('<?php echo site_url('info/detail/mentor') ?>',{npm: id},function(response, status, xhr) {});
    });
	$("a#tambah").click(function() {
		$(this).after('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" class="load" />');
		event.preventDefault();
		Boxy.ask("Pilih opsi penambahan untuk Mentor baru:", ["Tambah Baru", "Ambil dari Mentee"], function(val) {
			$("a#tambah").after('&nbsp;<img src="<?php echo base_url().'aset/load2.gif'; ?>" class="load" />');
			if (val == "Tambah Baru") {
				Boxy.load('<?php echo site_url('info/tambah/mentor'); ?>',{closeable: false, modal: true, title: 'Tambah Mentor', afterShow: function() {$("a#tambah").next().remove();}});
			} else {
				Boxy.load('<?php echo site_url('info/tambah/mentor-lama'); ?>',{closeable: false, modal: true, title: 'Tambah Mentor', afterShow: function() {$("a#tambah").next().remove();}});
			}
		;}, {title: "Opsi Penambahan", closeable: true, closeText: 'x'});
		$("a#tambah").next().remove();
	});
    <?php endif;?>
});
</script>
<div class="in-content">
	<table width="100%">
		<tr>
			<td width="20%" style="text-align:left; vertical-align:top;">
				<div id="daftar" style="border-right:1px solid black;">
				<h3 style="display:inline;">Daftar <?php echo $hal ?></h3><br />
				<?php if ($hal === 'Mentor'): ?><a href="#" id="tambah">Tambah Mentor?</a><?php endif;?>
				<?php
					echo $daftar;
				?>
				</div>
			</td>
			<td style="text-align:left; vertical-align:top">
				<h3>Detail <?php echo $hal ?></h3>
				<div id="detail">
				<?php
					echo $detail;
				?>
				</div>
			</td>
		</tr>
	</table>
</div>
