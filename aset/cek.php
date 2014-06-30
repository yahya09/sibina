<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistem Informasi Pembinaan | Masuk</title>
	<meta name="author" content="Yahya Muhammad" />
<meta name="description" content="SOROT: Situs Tinjauan Film dan Kumpulan Lirik Lagu" />
<meta name="keywords" content="movie,lyric,indonesia" />
<meta name="description" content="noindex,follow" />
<meta http-equiv="Content-type" content="text-html; charset=utf-8" />
<link href="http://localhost/sip/aset/login.css" rel="stylesheet" type="text/css" /><link href="http://localhost/sip/aset/icon.ico" rel="SHORTCUT ICON" type="image/ico" />	<script type="text/javascript">
window.onload = function() { document.getElementById("u").focus(); };
function z(v, m) {
	if (v.value.replace(/\s+/g, '') == '') {
		alert('Silakan masukkan '+m+' Anda');
		v.focus();
		return false;
	}
	return true;
}
function c(f) {
	f.action = 'Index';
	return (z(f.u, 'username') && z(f.p, 'password')); 
}
</script>
</head>
<body>
	<div id="wrapper"><div id="main_page">

	<div class="content">
	<table align="center" class="tes" cellpadding="0" cellspacing="0" name="login_form">
	<tr><td colspan="2"><div id="header">Universitas Indonesia</div></td></tr>
	<tr height="10%"><td valign="top">
	<h1>Sistem Informasi Pembinaan</h1>
	<div id="login">
	<h3>Login</h3>

	<p>Silakan masukkan <em>NPM</em> dan <em>password</em> sesuai dengan <em>akun</em> SIP Anda.</p>
	</div></td></tr>
	<tr><td valign="top">
		<form action="http://localhost/sip/index.php/depan/form" method="post" accept-charset="utf-8" onsubmit="return c(this)">
		<label for="u">Username (NPM)</label>
		<input type="text" name="u" value="" class="num" size="25" maxlength="25" id="u"  />
		<br />
		<label for="p">Password</label>
		<input type="password" name="p" value="" class="num" size="25" maxlength="32"  />
		<br />
		<input type="submit" name="submit_login" value="Masuk"  />
		</form>		<!--
		<form action="http://localhost/sip//form" method="post" onsubmit="return c(this)">
			<p align="center">
				<label for="u">NPM</label>
				<input type="text" class="num" name="u" size="25" maxlength="10" id="u" value="" />
			</p>
			<p align="center">
				<label for="p">Password</label>
				<input type="password" class="num" name="p" size="25" maxlength="100" />
			</p>
			<p id="submit" align="center"><input type="submit" value="Login" /></p>
		</form>
		-->

	</td></tr>
</table>	</div>
	<div class="clear" />
</div>	<div id="footer">
		SIP : Sistem Informasi Pembinaan powered by <a href="http://www.codeigniter.com" id="powered">CodeIgniter</a>
		<br />
		Created by <span id="author">yahyaman and <a href="http://fuki.cs.ui.ac.id">FUKI Fasilkom UI</a> &copy; 2011</span>

		</div>
	</div>
</body>
</html>