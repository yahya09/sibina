<script type="text/javascript">
$(document).ready(function() {
	$("a.logitem").click(function(){
		$("#detlog").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr("name");
        $("#detlog").load('<?php echo site_url('data/mentoring/detil') ?>',{idlog: id},function(response, status, xhr) {});
    });
    $("a.kegitem").click(function(event) {
		$("#detlog").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).attr('name');
		$("#detlog").load('<?php echo site_url('data/kegiatan/detil') ?>',{idkeg: id},function(response, status, xhr) {});
	});
});
</script>
<?php
	echo $daftar;
?>
