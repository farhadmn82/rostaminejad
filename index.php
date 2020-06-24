<?php header("Content-Type:text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fa">

<head>

	<link rel="icon" type="image/x-icon" href="images/kw.ico" />
<style>
#div1
{
background-color:black;
position:relative;

height:20px;
background:red;
transition:width 1s, height 1s, transform 2s;
-webkit-transition:width 1s, height 1s, -webkit-transform 2s; /* Safari */
float:left;

}
</style>
<meta  http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
	<link rel="stylesheet" href="mystyle.css" />
	<script src="js/jquery-2.0.3.min.js"></script>
	<script src="js/js_mainscripts.js"></script>
</head>

<body class="bg" dir="rtl">

<div id="divShadow" class="shadow_div"></div>

<div id="header">
	<?php require 'includes/header.php' ?>
</div>

<div id="menu">
	<?php require 'includes/hmenu.php' ?>
</div>


<?php

require "classes/cls_database.php";

$con = KW_DataBase::Connect();
$selq = "SELECT * FROM message WHERE ID=1";
$result = mysqli_query($con,$selq);

$active = false;
if($row = mysqli_fetch_array($result))
{
    $res = $row['Message'];
    $active = $row['Active'];
}

mysqli_close($con);

if($active == "1"){
?>

<div>
<marquee class="scrolling_div" behavior="scroll" direction="Right">
<?php echo $res ?>
</marquee>
</div>

<?php } ?>

<div id="content">
	<?php
		if(isset($_REQUEST['pid']))
		{ 
			$path=$_REQUEST['pid'].".php";
		}
		else
		{
			$path='aboutus.php';
		}
		require $path;
	?>
</div>

<div id="footer">
	<?php require 'includes/footer.php' ?>
</div>
	<!-- Begin WebGozar.com Counter code -->
<script type="text/javascript" language="javascript" src="http://www.webgozar.ir/c.aspx?Code=3300038&amp;t=counter" ></script>
<noscript><a href="http://www.webgozar.com/counter/stats.aspx?code=3300038" target="_blank">&#1570;&#1605;&#1575;&#1585;</a></noscript>
<!-- End WebGozar.com Counter code -->


<div id="telegramBox"><a id="telegramLink" href="https://telegram.me/rostaminejadwheels1"><img src="images/telegram.png" width="50px"/><br/>برای مشاهده جدیدترین رینگ ها <br/>در کانال تلگرام ما عضو شوید</a></div>
</body>


</html>
