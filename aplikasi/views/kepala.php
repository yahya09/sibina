<?php
echo doctype('xhtml1-trans');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $page_title ?></title>
	<?php
		$meta = array(array("name" => "author", "content" => "Yahya Muhammad"),
						array('name' => 'description', 'content' => 'SIP: Sistem Informasi Pembinaan (Halaqah)'),
						array('name' => 'keywords', 'content' => 'halaqah,mentoring,pembinaan'),
						array('name' => 'description', 'content' => 'noindex,follow'),
						array('name' => 'Content-type', 'content' => 'text-html; charset=utf-8', 'type' => 'equiv'));
		echo meta($meta);
		echo link_tag('aset/public.css');
		echo link_tag('aset/boxy/stylesheets/boxy.css');
		echo link_tag('aset/icon.ico', 'SHORTCUT ICON', 'image/ico');
	?>
	<script src="<?php echo base_url() ?>aset/jquery-1.6.1.min.js"></script>
	<script src="<?php echo base_url() ?>aset/boxy/javascripts/jquery.boxy.js"></script>
	
	
</head>
<body>
    <div id="header">
        <h1 style="color:#FFFFFF">Sistem Informasi Pembinaan</h1>
    </div>
    
    <div id="topmenu">
    <?php
        if($this->tinyauth->logged_in()) {
            echo anchor('depan','Beranda');
            echo '&nbsp';
            echo anchor('profil','Profil');
            echo '&nbsp';
            echo anchor('log','Risalah');
            echo '&nbsp';
            echo anchor('depan/logout','Logout');
        }
    ?>
    </div>
    
	<div id="wrapper">
    
