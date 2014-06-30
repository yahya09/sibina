<table align="center" class="tes" cellpadding="0" cellspacing="0" name="login_form">
	<!--<tr><td colspan="2"><div id="header-login">Universitas Indonesia</div></td></tr>-->
	<tr height="10%"><td valign="top">
	<!--<h1>Sistem Informasi Pembinaan</h1>-->
	<div id="login">
	<h3>Login</h3>
	<p>Silakan masukkan <em>NPM</em> dan <em>password</em> sesuai dengan <em>akun</em> SIP Anda.</p>
	</div></td></tr>
	<tr><td valign="top">
		<?php 
			echo '<div id="login-form">';
			echo form_open('login/form',array('name'=>'login_form'));
			echo "<p>";
			echo form_label('Username (NPM) ','u');
			echo "<br/>";
			echo form_input(array('class'=>'num','name'=>'u','size'=>'25','maxlength'=>'25','id'=>'u','value'=>''));
			echo "</p>";
			echo "<p>";
			echo form_label('Password ','p');
			echo "<br/>";
			echo form_password(array('class'=>'num','name'=>'p','size'=>'25','maxlength'=>'32'));
			echo "</p>";
			echo '<div id="error">';
			echo $error;
			echo '</div>';
			echo '</div>';
			echo '<p id="submit">';
			echo form_submit('submit_login','Masuk');
			echo "</p>";
			echo form_close();
		?>
	</td></tr>
</table>