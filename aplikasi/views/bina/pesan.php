<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
	<div id="utama">
    <p><?php echo $pesan; ?></p>
	</div>
	<div class="nav">
	<?php
		if (isset($alamat))
			echo anchor($alamat,'Kembali');
		else
			echo anchor(uri_string(),'Kembali');
	?>
	</div>
</body>
</html>