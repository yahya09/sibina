
<div id="submenu">
<?php
    if ($this->tinyauth->check_level('mentor')) {
        echo anchor('profil/biodata','Biodata');
        echo anchor('profil/kelompok','Kelompok');
    }
?>
</div>

<div class="in-content">
 
 <script type="text/javascript">
    $(document).ready(function() {
        $("a.kel").click(function(){
			$("#detil").html('<img src="<?php echo base_url().'aset/load.gif'; ?>" />');
			var id = $(this).html();
            $("#detil").load('<?php echo site_url('profil/kel_detail') ?>',{idkel: id},function(response, status, xhr) {});
			$("#biomentee").html('');
        });
	});
 </script>

	<table width="100%">
      <tr>
        <td width="20%" style="text-align:left; vertical-align:top;">
        	<h3>Daftar Kelompok</h3>
		  	<?php echo $daftar ?>
        </td>
        <td style="text-align:left; vertical-align:top">
		    <h3>Profil Kelompok</h3>
		    <div id="detil">
	  		<?php echo $detil ?>
  			</div>

			<div id="biomentee">
  			</div>
        </td>
      </tr>
    </table>


</div>