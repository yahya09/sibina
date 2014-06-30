<?php
echo doctype('xhtml1-trans');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $page_title ?></title>
	<?php
		$meta = array(array("name" => "author", "content" => "Yahya Muhammad"),
						array('name' => 'description', 'content' => 'SIP: Sistem Informasi Pembinaan'),
						array('name' => 'keywords', 'content' => 'halaqah,mentoring,murabbi,tarbiyah'),
						array('name' => 'description', 'content' => 'noindex,follow'),
						array('name' => 'Content-type', 'content' => 'text-html; charset=utf-8', 'type' => 'equiv'));
		echo meta($meta);
		echo link_tag('aset/login.css');
		echo link_tag('aset/icon.ico', 'SHORTCUT ICON', 'image/ico');
	?>
</head>
<body>
	<div id="wrapper">