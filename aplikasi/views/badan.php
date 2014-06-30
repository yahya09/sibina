<div id="main-page">
	<div class="content">
	<?php
		if(isset($page_content)) {
			$this->load->view($page_content);
		} else {
            echo 'Ada kesalahan pemanggilan halaman.';
        }
	?>
    
	</div>
	<div class="clear" />
</div>
