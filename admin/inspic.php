<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<style>
#loading{
	width:100%;
	height:100%;
	background-color:black;
	font-size:xx-large;
	color:white;
	opacity:.6;
	Text-align:center;
	vertical-align:middle;
	position:fixed;
	visibility:hidden;
	top:0px;
	z-index:1001;
	padding-top:300px;
}

#main{
	width:600px;
	margin:0px auto;
}

table td{
	padding:20px 10px;
}

</style>
<script>
function showload(){
	document.getElementById('loading').style.visibility='visible';
}
</script>
<title>درج عکس</title>
</head>
<?php 
try
{
	session_start();
	if(!isset($_SESSION['user']))
	{
		header('Location: adminhome.php');
	}
}
catch(Exception $e){}

function resize_image($file,$new_file,$new_height) 
{ 
    
    if(!extension_loaded('gd')&&!extension_loaded('gd2'))  { 
        die("GD is not installed!"); 
    } 
    list($width,$height,$type)=getimagesize($file);     
//    $new_width=(int)($width/$height)*40; 
    switch($type) 
    { 
        case 1:$img=imagecreatefromgif($file);break; 
        case 2:$img=imagecreatefromjpeg($file);break; 
        case 3:$img=imagecreatefrompng($file);break; 
        default:die('Unsknown file!'); 
    } 
    $ratio=(float)$height/$width; 
    //$new_ratio=(float)$new_height/$new_width; 
    //if($new_ratio>$ratio)$new_height=round($new_width*$ratio); 
    //else $new_width=round($new_height/$ratio); 
    $new_width=round($new_height/$ratio);
	
	$new_img=imagecreatetruecolor($new_width,$new_height); 
    if(($type==1)||($type==3)){ 
        imagealphablending($new_img,false); 
        imagesavealpha($new_img,true); 
        $tmp=imagecolorallocatealpha($new_img,255,255,255,127); 
        imagefilledrectangle($new_img,0,0,$new_width,$new_height,$tmp); 
    } 
    imagecopyresampled($new_img,$img,0,0,0,0,$new_width,$new_height,$width,$height); 
    switch($type) 
    { 
        case 1:imagegif($new_img,$new_file);break; 
        case 2:imagejpeg($new_img,$new_file);break; 
        case 3:imagepng($new_img,$new_file);break; 
        default:die('Failed resize image!'); 
    } 
}
?>
<body dir="rtl" style="background-color:teal; font-family:Tahoma;">
<div id="main">
<?php
include 'adminmenu.php';

// Create connection
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
	if ($_POST['newcat']=="") 
	{$cat=$_POST['cat'];}
	else
	{
	$cat=$_POST['newcat'];
	$insq="INSERT INTO category (catname) VALUES ('".$cat."')"; 
	mysqli_query($con,$insq);
	}
	
	$insq="INSERT INTO gallery (filename,descr,category) VALUES ('".$_FILES['file']['name']."','".$_POST['title']."','".$cat."')";
	//echo $insq;
	mysqli_query($con,$insq);
	
	$filename=$_FILES['file']['name'];
	if(file_exists("../images/gallery/".$filename)) 
	{
		$r=rand(1000,9999);
		$tf=settype($r,"string");
		$a= $r.'.';
		$pos=strrpos($filepath,'.');
		str_replace(".",$a,$filepath);
		//echo $filepath;
	}
	
	$filepath="../images/gallery/".$filename;
	$preloadtmb="../images/gallery/preload/".$filename;
	$tumbnail="../images/gallery/tmbn/".$filename;
	
//echo 'فایل قبلا موجود بوده است. فقط در گالری ثبت شد';
		//move_uploaded_file($_FILES['file']['tmp_name'],$filepath);
		
		resize_image($_FILES['file']['tmp_name'],$filepath,1200);
		resize_image($filepath,$tumbnail,40);
		resize_image($filepath,$tumbnail,100);
		
		mysqli_close($con);
		
		
		
		echo '<span style="color:red">عکس با موفقیت ذخیره شد</span>';
		
}
	?>

<form action="savepic.php" method="post" enctype="multipart/form-data" style="font-family:Tahoma;">
<table style="font-size:xx-large;font-family:Tahoma;">
<tr><td>عنوان عکس  </td><td><input type="text" name="title" maxlength="80" style="width:400px;height:50px;font-size:xx-large;font-family:Tahoma;" /></td></tr>
<tr><td>فایل عکس  </td><td><input type="file" name="file" id="file" size="50px"  style="width:400px;height:50px;font-size:xx-large;font-family:Tahoma;" /></td></tr>
<tr><td>گروه جدید  </td><td><input type="text" name="newcat" id="newcat" style="width:400px;height:50px;font-size:x-large;font-family:Tahoma;" /></td></tr>
<tr><td>گروه بندی  </td><td><select  name="cat" id="cat" style="width:400px;height:50px;font-size:x-large;font-family:Tahoma;" />
<?php
	include 'connect.php';
	$query="SELECT * FROM category";	
	$result = mysqli_query($con,$query);
	$c=-1;
	while($row = mysqli_fetch_array($result))
	  {
	    $c++;
		$catname[$c]=$row['catname'];
	  }
	mysqli_close($con);

for($ci=0;$ci<count($catname);$ci++)
{
	echo '<option>'.$catname[$ci].'</option>';
}
?>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="submit" value="ذخیره عکس" onclick="showload()" style="width:400px;height:80px;font-size:xx-large;margin-top:50px;font-family:Tahoma;" /></td></tr>

</table>
</form>
</div>
<div id="loading">
	<img src="../images/load1.gif"/>
	<div>در حال ذخیره سازی...</div>
</div>

</body>

</html>
