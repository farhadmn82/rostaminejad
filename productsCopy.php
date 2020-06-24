<?php include 'category.php'; ?>
<!--a style="text-align:center;display:block; margin:10px auto; " href="https://www.dropbox.com/sh/egvdkxlv75df47e/9n_urWLE0g" >مشاهده آخرین عکس ها</a-->

<?php 
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
        case 2:$img=imagecreatefromjpeg($file);echo 'create';break; 
        case 3:$img=imagecreatefrompng($file);break; 
        default:die('Unknown file! : '.$img.'\b'); 
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

include 'connect.php';
	//mysqli_query($con,"INSERT INTO services (id, servtitle, stylistname, is_active) VALUES ('','ناخن', 'امینی',1)");
	mysqli_set_charset($con, "utf8");
	$query="SELECT * FROM gallery";
	if(isset($_GET['cat']))
	{ 
		$query="SELECT * FROM gallery WHERE category='".trim(htmlspecialchars($_GET['cat']))."'";
	}
	$result = mysqli_query($con,$query);
	$c=-1;
	//echo $result;
if(!($result==null)){
	while($row = mysqli_fetch_array($result))
	  {
	    $c++;
	    //$imgid[$c]=$row['ID'];
		$descr[$c]=$row['descr'];
		$img[$c]=$row['filename'];
		
		
		$filepath="images/gallery/".$img[$c];
		$preloadtmb="images/gallery/preload/".$filename;
		echo $preloadtmb;
		resize_image($filepath,$preloadtmb,150);
		
	$category[$c]=$row['category'];
	  }
	//mysqli_close($con);

	$cquery="SELECT * FROM category";
	$cresult = mysqli_query($con,$cquery);
	$cc=-1;
	$sid=-1;
	while($crow = mysqli_fetch_array($cresult))
	  {
		for($f=0;$f<=$c;$f++)
		{
			if($crow['catname']==$category[$f])
			{
				$sid++;
				$s[$sid]=$f;
			}
		}
			
	  }
	mysqli_close($con);
	

for($i=0;$i<count($img);$i=$i+4){ ?>

<table border="1"  style="border-color:black; border-style:solid; color:white" align="center">
<tr bgcolor="teal">
	<?php 
		if(count($img)<$i+4) $l=count($img); else $l=$i+4;
		for($j=$i;$j<$l;$j++){ ?>
		<td align="center" onclick="">
	<?php echo $descr[$s[$j]]; ?>
		</td>
	<?php } ?>
</tr>
<tr bgcolor="white">
<?php for($k=$i;$k<$l;$k++){ ?>
	<td style="text-align:center">
<img src="images/gallery/preload/<?php echo htmlspecialchars($img[$s[$k]]); ?>" width="200" align="middle" alt="" />
	</td>
<?php }  ?>
</tr>
</table>
<hr/>
<?php }} ?>


