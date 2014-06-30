<div id="main_page">
	<div class="content">
	<?php
		if(isset($page_content)) {
			$admin = $this->config->item('admin_view');
			$this->load->view($admin.$page_content);
		}
		echo "<br />Mau ";
		echo anchor('login/logout','keluar');
		echo " ?";
	?>
	</div>
	<div class="clear" />
</div>