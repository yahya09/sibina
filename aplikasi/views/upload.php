<script type="text/javascript">
    function kirim() {
		//alert("masuk submit");
		var foto = $("input[name=userfile]").attr("value");
		$(".boxy-content:first").html("file: "+foto);
		$(".boxy-content:last").load('<?php echo site_url("profil/upload/foto") ?>',{userfile: foto, submit: true});
		//alert("isinya: "+foto);
		return false;
	}
</script>

<h3>Pilih foto baru untuk diunggah:</h3>
<?php echo form_open_multipart('profil/upload/foto',array("id"=>"unggah"));?>
<input type="file" name="userfile" size="20" />
<br />
<input type="submit" id="upload" value="Unggah" />
<input type="button" id="cancel" value="Batal" onclick="Boxy.get(this).hideAndUnload();" />
</form>