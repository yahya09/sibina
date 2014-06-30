<?php if ( ! defined('BASEPATH')) exit('Akses langsung tidak diperkenankan');

$admin = $this->config->item('admin_view');
$this->load->view($admin.'kepala');
$this->load->view($admin.'badan');
$this->load->view($admin.'kaki');

?>