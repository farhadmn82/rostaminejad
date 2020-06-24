<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" href="mainstyle.css" />
	
	<script src="../js/jquery-2.0.3.min.js"></script>
	<script src="../js/js_mainscripts.js"></script>
	<script src="../classes/uc_checkbox.js"></script>
	
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>مدیریت</title>
</head>

<body dir="rtl">
<?php
	session_start(); 
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if($_POST['username']=='farhadmin' & $_POST['password']=='farhadmin')
		{
			$_SESSION['user']=$_POST['username'];
		}
	}
	if(isset($_SESSION['user']))
	{
		if($_SESSION['user']=="farhadmin")
		{
			include 'adminmenu.php';
		}
	}
	else
	{
	?>
	<div>
	<div style="margin:50px auto;">
	<form action="adminhome.php" method="post">
	<table><tr><td>
	نام کاربری</td><td><input type="text" name="username"/></td></tr>
	<tr><td>رمز عبور</td><td><input type="password" name="password" /></td></tr>
	<tr><td colspan="2" align="center">
	<input type="submit" name="Login" value="ورود" style="width:100px;"/></td></tr>
	</table>
	</form>
	</div></div>



	<?php
	}
	?>
	<div id="divContent"></div>
	<div id="divShadow" class="shadow_div"></div>
</body>

</html>

