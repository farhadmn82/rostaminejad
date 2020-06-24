<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>ذخیره عکس</title>
</head>
<?php 
try{
session_start();
if(!isset($_SESSION['user']))
{
header('Location: adminhome.php');
}
}
catch(Exception $e){}

function resize_image($file,$new_file,$new_width) 
{ 
    $new_height = $new_width;
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
    $new_ratio=(float)$new_height/$new_width; 
    if($new_ratio>$ratio)$new_height=round($new_width*$ratio); 
    else $new_width=round($new_height/$ratio); 
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

<body style="font-size:18px;">

<?php

include 'adminmenu.php';
//echo '<img src="../images/load1.gif" /><br>';
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
	if ($_POST['newcat']=="") 
	{$cat=$_POST['cat'];}
	else
	{
		$cat=$_POST['newcat'];
		$selq="SELECT * FROM category WHERE catname='".$cat."'"; 
		echo $selq;
		$cresult = mysqli_query($con,$selq);
		$cnt=0;
		while($row = mysqli_fetch_array($cresult)){$cnt=1;}
		if($cnt==0){
			$cat=$_POST['newcat'];
			$insq="INSERT INTO category (catname) VALUES ('".$cat."')"; 
			mysqli_query($con,$insq);
		}
	}
	
	
	$filepath="../images/gallery/".$_FILES['file']['name'];
	$filename=$_FILES['file']['name'];
	if(file_exists("../images/gallery/".$_FILES['file']['name'])) 
	{
		$r=rand(1000,9999);
		//echo $r.'RAND<br>';
		$tf=settype($r,"string");
		$a= '_'.$r.'.';
		$pos=strrpos($filename,'.');
		$filename = substr_replace($filename,$a,$pos,1);
		echo "<script type='text/javascript'>alert('عکس با موفقیت ذخیره شدفایلی با این نام از قبل موجود بوده است. <br>فایل با نام ".$filename." ذخیره شد.')</script>";
	}
	
	$filepath="../images/gallery/".$filename;
	$preloadtmb="../images/gallery/preload/".$filename;
	$tumbnail="../images/gallery/tmbn/".$filename;
	$highres = "../images/gallery/hr/".$filename;
//echo 'فایل قبلا موجود بوده است. فقط در گالری ثبت شد';
	$title=$_POST['title'];
	//if ($title=="") $title='م';
	//move_uploaded_file($_FILES['file']['tmp_name'],$filepath);
	resize_image($_FILES['file']['tmp_name'],$highres,1280);
	resize_image($_FILES['file']['tmp_name'],$filepath,800);
	//echo $_FILES['file']['tmp_name']."\b";
	resize_image($filepath,$tumbnail,40);
	resize_image($filepath,$preloadtmb,200);

	
//	echo '<span style="color:red">عکس با موفقیت ذخیره شد</span>';

//	resize_image($filepath,$tumbnail);
	$insq="INSERT INTO gallery (filename,descr,category) VALUES ('".$filename."','".$title."','".$cat."')";
	//echo $insq;
	mysqli_query($con,$insq);	
	
	$msg = $_POST['title'];
	$lnk = "http://www.rostaminejad.com/images/gallery/hr/".$filename;
	mail("farhadmn@gmail.com","ثبت محصول جدید - ".$msg,$lnk,'From: kwinfo@rostaminejad.com');	
		
	echo "<script type='text/javascript'>alert('عکس با موفقیت ذخیره شد')</script>";
	
	mysqli_close($con);

}
	?>

</body>

</html>
