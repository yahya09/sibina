<br />
 <script type="text/javascript">
$(document).ready(function() {
    $("a#edit").click(function(event){
        event.preventDefault();
		Boxy.load('<?php echo site_url("profil/edit_mentee/{$npm}") ?>',{closeable: false, modal: true, title: 'Ubah Data Mentee'});
	});
});
 </script>
<h3 style="display:inline;">Biodata Mentee</h3>&nbsp;&nbsp;
<a href="#" id="edit" title="Edit">Ubah</a> <br />
<?php
	if(isset($bio))
		echo $bio;
	else
		echo "Ada kesalahan: ".$error;
?>
<br />
