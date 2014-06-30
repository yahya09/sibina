<?php
if (isset($stat)) {
		echo form_hidden('idkel',$idkel);
		$radio = form_radio('status','aktif',($stat == 'aktif')).'Aktif<br/>';
		$radio .= form_radio('status','menunggu',($stat == 'menunggu')).'Menunggu persetujuan<br/>';
		$radio .= form_radio('status','pindah',($stat == 'pindah')).'Pindah';
		$this->table->add_row(form_label('Status','status'),$radio);
	}
?>