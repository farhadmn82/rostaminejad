<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
session_start();
if(!isset($_SESSION['user']))
{
header('Location: adminhome.php');
}
include 'adminmenu.php';
?>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>مدیریت</title>
</head>

<body>
<div style="width:600px; margin:0px auto;font-family:Tahoma;font-size:x-large;clear:both;border:2px black solid;padding:10px;height:200px" >
<?php

if (!isset($_GET['confirm'])){
echo "<br>آیا از حذف عکس مطمئن هستید؟<br>";
echo '<a class="yesno" href="dataaccess.php?act='.$_GET['act'].'&table='.$_GET['table'].'&id='.$_GET['id'].'&confirm=1">بلی</a>';
echo '<a class="yesno" href="adminhome.php" target="_parent">خیر</a><br>';
}
else
{
// Create connection
include 'connect.php';
if($_GET['act']=="del")
{
	$selq="SELECT * FROM ".$_GET['table']." WHERE ID=".$_GET['id']; 
	$result = mysqli_query($con,$selq);
	$row = mysqli_fetch_array($result);
	$t=unlink('../images/gallery/tmbn/'.$row['filename']);
	try{
	if($t) echo "فایل نمای کوچک حذف شد<br>";
	$t=unlink('../images/gallery/'.$row['filename']);
	if($t) echo "فایل تصویر اصلی حذف شد<br>";	
	$t=unlink('../images/gallery/preload/'.$row['filename']);
	if($t) echo "فایل تصویر گالری حذف شد<br>";	
	
	$msg = $row['descr'].chr(10).$row['filename'];
	mail("farhadmn@gmail.com","حذف محصول - ".$row['descr'],$msg,'From: kwinfo@rostaminejad.com');	
	}
	catch(Exception $e){echo 'فایل موجود نیست<br>';}
	$delq="DELETE FROM ".$_GET['table']." WHERE ID=".$_GET['id'];
	$result = mysqli_query($con,$delq);
	
	//echo $delq;
	
	//echo $result;
	echo '<div><a href="forward.php">بازگشت به لیست تصاویر</a></div>';
}
if($_GET['act']=="edit"){
	
	//mysqli_query($con,"INSERT INTO services (id, servtitle, stylistname, is_active) VALUES ('','ناخن', 'امینی',1)");	
}	
if($_GET['act']=="dis"){
	
	$disq="UPDATE ".$_GET['table']." SET active='0' WHERE id=".$_GET['id'];
	//echo $disq;
	$result = mysqli_query($con,$disq);

}	
if($_GET['act']=="ena"){
	
	$disq="UPDATE ".$_GET['table']." SET active='1' WHERE id=".$_GET['id'];
	//echo $disq;
	$result = mysqli_query($con,$disq);

}	

	mysqli_close($con);
}
?>
</div>
</body>

</html>
