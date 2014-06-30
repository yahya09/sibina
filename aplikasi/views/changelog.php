<?php
echo doctype('xhtml1-trans');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Change Log</title>
	<?php
		echo link_tag('aset/icon.ico', 'SHORTCUT ICON', 'image/ico');
	?>
	<script src="<?php echo base_url() ?>aset/jquery-1.6.1.min.js"></script>
	<script src="<?php echo base_url() ?>aset/date/datetimepicker_css.js"></script>
	<script src="<?php echo base_url() ?>aset/boxy/javascripts/jquery.boxy.js"></script>
	<style>
	body {
		background:#bfd682;
		color:#444;
	}
	body > a {
		text-decoration: none;
		font-style: bold;
		color: #542807;
	}
	h1 {
	    margin:0;
	    font-weight:normal;
	    font-size:2.4em;
	    letter-spacing:-2px;
	    color:#666;
	    padding:14px 0 7px 0;
	}
	h3 {
		font-size:1.5em;
		margin:20px 0 5px 0;
		color:olivedrab;
	}
	thead {
		background-color: #542807;
		color: #ffffff;
	}
	td.separate {
		border-left: 1px solid;
		border-right: 1px solid;
		padding: auto 2px;
	}
	.laporan tr.first {
		background-color: #F6FFB0;
	}
	.laporan tr.second {
		background-color: #E5F297;
	}
	table.laporan {
		border-left: #542807 1px solid;
		border-right: #542807 1px solid;
		border-bottom: #542807 1px solid;
		border-collapse:collapse;
	}
	table.tambah {
		background-color: #E5F297;
	}
	.changelog {
		border-right: 1px solid;
		padding-right: 5px;
		width: 65%;
		height:100%;
		float:left;
		margin-bottom: 20px;
	}
	.tambah {
		margin: auto 10px;
		width: 20%;
		float:left;
	}
	.clear {
		clear:both;
		margin-bottom:20px;
	}
	</style>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {
	$("input[value=pilih]").click();
	$("[name=time]").click(function() {
		if ($(this).val() != 'pilih' ) {
			$("input[name=waktu]").attr("disabled","disabled");
			$("td > img").removeAttr("onclick");
		} else {
			$("input[name=waktu]").removeAttr("disabled");
			$("td > img").attr("onclick","javascript:NewCssCal ('wkt','yyyyMMdd','arrow',true,'24')");
		}
	});
});
</script>
<?php echo anchor('depan','<< Kembali ke Beranda'); ?>
<h1>Laporan Sistem Website</h1>
<div class="changelog">
<h3 style="display:inline">Laporan Tersimpan</h3><span style="float:right;"><?php echo $page; ?></span>
<?php
	$opsi = array(
                  'bug'  => 'New Bug',
                  'fixed'    => 'Bug Fixed',
                  'update'   => 'Update',
                  'feedback' => 'Feedback',
                );
	$this->table->clear();
	if ($data !== FALSE) {
		$tmpl = array (
                    'table_open'          => '<table class="laporan" cellpadding="5">',
                    'row_start'           => '<tr class="first">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td class="separate">',
                    'cell_end'            => '</td>',
                    'row_alt_start'       => '<tr class="second">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td class="separate">',
                    'cell_alt_end'        => '</td>',
              );
		$this->table->set_template($tmpl);
		$this->table->set_heading('#','Tipe','Deskripsi','Waktu','Oleh');
		foreach ($data as $row) {
			$deskripsi = str_replace("\n","<br />",$row->deskripsi);
			$this->table->add_row('#'.$row->id,$opsi[$row->tipe],$deskripsi,date("d/M/y H:i",strtotime($row->waktu)),$row->oleh);
		}
		echo $this->table->generate();
	} else {
		echo 'Tidak ada data laporan tersimpan.';
	}
?>
</div>

<div class="tambah">
<h3>Tambah Laporan</h3>
<?php
	echo form_open('change_log/tambah',array('id'=>'nambah'));
	$data = array(
              'name'        => 'files',
              'maxlength'   => '100',
              'size'        => '40'
            );
	$image_properties = array(
          'src' => 'aset/date/images/cal.gif',
          'onclick' => "javascript:NewCssCal ('wkt','yyyyMMdd','arrow',true,'24')",
		  'style' => "cursor:pointer");
	$this->table->clear();
	$this->table->add_row(form_label('Tipe','tipe'),form_dropdown('tipe',$opsi,'bug'));
	$data = array(
          'name'        => 'deskripsi',
          'maxlength'   => '1000',
          'cols'        => '35',
		  'rows'		=> '10'
        );
	$this->table->add_row(form_label('Deskripsi','deskripsi'),form_textarea($data));
	$this->table->add_row(form_submit('submit','Laporkan!'),form_reset('reset','Reset'));
	$tmpl = array (
                    'table_open'          => '<table class="tambah">',
                    'row_start'           => '<tr class="first">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',
                    'row_alt_start'       => '<tr class="second">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',
              );
	$this->table->set_template($tmpl);
	echo $this->table->generate();
	echo form_close();
?>
</div>
<div class="clear"></div>
</body>
</html>