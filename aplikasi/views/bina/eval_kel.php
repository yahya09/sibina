<script type="text/javascript">
$(document).ready(function() {
	$("a.kel").click(function(){
		$("#detail").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
		var id = $(this).html();
        $("#detail").load('<?php echo site_url('data/eval_detil') ?>',{idkel: id},function(response, status, xhr) {});
		//alert("idkel: "+id);
    });
});
</script>
<?php
	echo $daftar;
?>