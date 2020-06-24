<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="../mystyle1.css" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>عکس ها</title>
<style>
.deletebutton{
	padding:5px 10px;
	border:2px black ridge;
	text-decoration:none;
	background-color:khaki;
	color:red;
}
</style>
</head>

<body dir="rtl" style="background-color:#6666FF">
<div style="width:1000px; margin:0px auto; font-family:Tahoma;font-size:x-large;" >
<?php
session_start();
if(!isset($_SESSION['user']))
{
header('Location: adminhome.php');
}

function resize_image($file,$new_file,$new_height) 
{ 
    echo $file;
    if(!extension_loaded('gd')&&!extension_loaded('gd2'))  { 
        die("GD is not installed!"); 
    } 
    list($width,$height,$type)=getimagesize($file); 
//    $new_width=(int)($width/$height)*40; 
    switch($type) 
    { 
        case 1:$img=imagecreatefromgif($file);break; 
        case 2:$img=imagecreatefromjpeg($file);echo 'create';break; 
        case 3:$img=imagecreatefrompng($file);break; 
        default:die('Unknown file! : '); 
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
        case 2:imagejpeg($new_img,$new_file);echo 'OK';break; 
        case 3:imagepng($new_img,$new_file);break; 
        default:die('Failed resize image!'); 
    } 
}

include 'adminmenu.php';
include 'connect.php';

	$result = mysqli_query($con,"SELECT * FROM gallery");
	$c=0;
	while($row = mysqli_fetch_array($result))
	  {
	    $c++;
	    $gallid[$c]=$row['ID'];
		$galltitle[$c]=$row['descr'];
		$gallfile[$c]=$row['filename'];
		$category[$c]=$row['category'];
	  }
	mysqli_close($con);

		echo '<table border="1" bgcolor="silver">';
		for($i=$c;$i>=1;$i--)
		{					
					$filepath="../images/gallery/".$gallfile[$i];
					$preloadtmb="../images/gallery/preload/".$filename;
					//echo $preloadtmb;
					//resize_image("c:/gallery/".$gallfile[$i],$preloadtmb,150);

			echo '<tr><td style="padding:5px 20px;"><a href="dataaccess.php?act=del&table=gallery&id='.$gallid[$i].'" class="deletebutton">حذف</a></td>';
			echo '<td><img style="width:90px;" src="../images/gallery/tmbn/'.$gallfile[$i].'"></td>';			
			echo '<td>'.trim($galltitle[$i]).'</td>';
			echo '<td>'.trim($category[$i]).'</td>';
			echo '<td>'.$gallfile[$i].'</td>';
			echo '<td><a href="dataaccess.php?act=edit&table=gallery&id='.$gallid[$i].'">ویرایش</a></td>';
			echo '</tr>';
		}
		echo '</table>';
	?>
</div>
</body>

</html>
