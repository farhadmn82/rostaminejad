<?php

class Product
{
	var $ID=0;
	var $Active=true;
	var $Name="";
	var $GroupID=0;
	var $Description="";
	var $Price="";

	function Product($id)
	{	
		$this->Load($id);
	} 
	
	function Save()
	{
		
		$con = KW_DataBase::Connect();
		$act="False";
		if($this->Active)
			$act="True";
		
		if($this->ID==0)
		{
			$q="INSERT INTO products (Active, Name,GroupID) VALUES (".$act.",'".$this->Name."',".$this->GroupID.")";
			
			$subject="New Product - ".$this->Name;
			$body = '<img src="" /><br/>';
			$body .= '<div style="color:#3366FF;font-size:14px;">'.$this->Name.'</div>';
			Product::SendMail($subject,$body);		
		}
		else
			$q="UPDATE products SET Active=".$act.", Name='".$this->Name."', GroupID=".$this->GroupID." WHERE ID=".$this->ID;

		mysqli_query($con,$q);
		
		mysqli_close($con);	
	}
	
	function Load($id)
	{
		$pid=$id;
		if($id==0)//Empty Product
			return;
		if($id==-1)//Last Record
			$pid = KW_DataBase::GetLastRecordID('products');
		
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM products WHERE ID=".$pid;
		$result = mysqli_query($con,$selq);
		
		$res=false;
		if($row = mysqli_fetch_array($result))
		{
			$this->ID = $row['ID'];
			$this->Active = $row['Active'];
			$this->Name = $row['Name'];
			$this->GroupID = $row['GroupID'];
			$this->Description = $row['Description'];
			$this->Price = $row['Price'];
			
			$res = true;
		}
		
		mysqli_close($con);	
		
		return $res;	
	}
	
	function AddProductImage()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$currDate = strval($this->ID).'_'.date("Ymd")."_".date("His"); 
			
			$filename=$currDate.".jpg";
						
			$filepath="../images/gallery/".$filename;
			$cover="../images/gallery/cover/".$filename;
			$tumbnail="../images/gallery/tmbn/".$filename;
				
			Product::resize_image($_FILES['file']['tmp_name'],$filepath,1280);
			Product::resize_image($filepath,$cover,200);
			Product::resize_image($filepath,$tumbnail,64);
			
			$isCover="True";
			if($this->_hasCoverImage())
				$isCover="False";
			
			$con = KW_DataBase::Connect();
			$insq="INSERT INTO images (Active, ProductID, FilePath,IsCover) VALUES (TRUE,".$this->ID.",'".$filename."',".$isCover.")";
			mysqli_query($con,$insq);
			mysqli_close($con);	

			//F->Send Notification Email			
			$msg = $this->Name;
			$lnk = "http://www.rostaminejad.com/images/gallery/hr/".$filename;
			//mail("farhadmn@gmail.com","ثبت محصول جدید - ".$msg,$lnk,'From: kwinfo@rostaminejad.com');	
			//==========================
			
			echo "<script type='text/javascript'>alert('عکس با موفقیت ذخیره شد')</script>";	
		}
	}


	function _hasCoverImage()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM images WHERE Active=True AND ProductID=".$this->ID." AND IsCover=True";
		$result = mysqli_query($con,$selq);
		
		$hasCover=false;
		//echo mysqli_num_rows($result);
		if(mysqli_num_rows($result) > 0)
			$hasCover=true;
		
		mysqli_close($con);	
		
		return $hasCover;	
	}
		
	private static function resize_image($file,$new_file,$new_width) 
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

	function GetProductImagesTable()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM images WHERE ProductID=".$this->ID;
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<table border="0" class="data_table">';
		$htmlTag .=  '<thead class="table_header product_table_header">';
		$htmlTag .=  '<th>شناسه</th><th>تصویر</th><th>وضعیت</th><th>حذف</th></thead>';
		
		while($row = mysqli_fetch_array($result))
		{
			$htmlTag .= '<tr style="height:30px;text-align:center;">';
			$htmlTag .= '<td>'.trim($row['ID']).'</td>';
			$htmlTag .= '<td><img src="../images/gallery/cover/'.trim($row['FilePath']).'" /></td>';
			if($row['IsCover'])
				$htmlTag .= '<td><div class="gbutton switch_gbutton enable_switch_gbutton">تصویر اصلی</div></td>';
			else
				$htmlTag .= '<td><div onclick="jsSetCoverImage('.$row['ID'].')" class="gbutton switch_gbutton disable_switch_gbutton">تصویر اصلی</div></td>';
			
			$htmlTag .= '<td><div class="gbutton delete_gbutton" onclick="jsDeleteImage('.$row['ID'].')">حذف</div></td>';
			$htmlTag .= '</tr>';
		}
		$htmlTag .= '</table>';
	
		mysqli_close($con);	
		
		return $htmlTag;	
		
	}
	
	

	static function SetCoverImage($pid, $iid)
	{
		$con = KW_DataBase::Connect();
		
		$q="UPDATE images SET IsCover=False WHERE ProductID=".$pid;
		mysqli_query($con,$q);

		$q="UPDATE images SET IsCover=True WHERE ID=".$iid;
		mysqli_query($con,$q);
		
		mysqli_close($con);	
		
		echo "Image Cover Changed To ".$iid."!";
	}

	
	static function GetCoverImage($pid)
	{
		$con = KW_DataBase::Connect();
				
		$q="SELECT * FROM images WHERE ProductID=".$pid." AND IsCover=True";
		$img='';
		if($result = mysqli_query($con,$q))
		{
			if($row = mysqli_fetch_array($result))
			{
				$img = $row['FilePath'];
			}		
		}
		
		mysqli_close($con);		
		
		return $img;
	}
	
	static function DeleteImage($iid)
	{
		$con = KW_DataBase::Connect();
		$selq="SELECT * FROM images WHERE ID=".$iid; 
		try
		{
			if($result = mysqli_query($con,$selq))
			{
				$rep='';
				$row = mysqli_fetch_array($result);
				$t=unlink('../images/gallery/tmbn/'.$row['FilePath']);
				if($t) $rep.= "فایل نمای کوچک حذف شد<br>";
				$t=unlink('../images/gallery/'.$row['FilePath']);
				if($t) $rep.= "فایل تصویر اصلی حذف شد<br>";	
				$t=unlink('../images/gallery/cover/'.$row['FilePath']);
				if($t) $rep.= "فایل تصویر گالری حذف شد<br>";	
			}
		}
		catch(Exception $e)
		{				
			$rep.='فایل موجود نیست<br>';
		}
		
		$delq="DELETE FROM images WHERE ID=".$iid;
		$result = mysqli_query($con,$delq);
		
		mysqli_close($con);	
		
		echo $rep;
	}
	
	static function GetProductsTable($nameFilter, $activeProds, $deactiveProds)
	{
		$con = KW_DataBase::Connect();

		$selq = "SELECT * FROM products";
		$filterq = '';
		if($nameFilter!="")
			$filterq .= "Name LIKE '%".$nameFilter."%'";
		if($activeProds!=$deactiveProds)
		{
			if($filterq != '') $filterq .= " AND ";
			$filterq .= "Active=".$activeProds."";
		}
		if($filterq != '') $selq .= " WHERE ".$filterq;
				
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '';
		$htmlTag .=  '<table class="data_table" border="0">';
		$htmlTag .=  '<thead class="table_header product_table_header">';
		$htmlTag .=  '<th>شناسه</th><th>تصویر</th><th>عنوان محصول</th><th>وضعیت</th><th>ویرایش</th><th>حذف</th>	</thead>';
		
		while($row = mysqli_fetch_array($result))
		{
			if($row['Deleted'] == 0)
			{
				$htmlTag .= '<tr style="height:30px;text-align:center;" id="rowProduct'.$row['ID'].'">';
				$htmlTag .= '<td>'.$row['ID'].'</td>';
				$img = Product::GetCoverImage($row['ID']);
				if($img!='')
					$htmlTag .= '<td><img src="../images/gallery/tmbn/'.trim($img).'" /></td>';
				else
					$htmlTag .= '<td></td>';
				$htmlTag .= '<td>'.$row['Name'].'</td>';
				$htmlTag .= '<td id="cellProdActive'.$row['ID'].'">'.Product::GetActiveButton($row['ID'],$row['Active']).'</td>';
				$htmlTag .= '<td><div class="gbutton edit_gbutton" onclick="jsShowProduct('.$row['ID'].')">ویرایش</div></td>';
				$htmlTag .= '<td id="cellProdDelete'.$row['ID'].'">'.Product::GetDeleteButton($row['ID']).'</td>';
				$htmlTag .= '</tr>';
			}
		}
		
		$htmlTag .= '</table>';
	
		mysqli_close($con);	
		
		return $htmlTag;			
	}
	
	static function GetActiveButton($pid, $act)
	{
		if($act)
			$htmlTag = '<div onclick="jsSetActiveProduct('.$pid.',0)" class="gbutton switch_gbutton enable_switch_gbutton">فعال</div>';
		else
			$htmlTag = '<div onclick="jsSetActiveProduct('.$pid.',1)" class="gbutton switch_gbutton disable_switch_gbutton">غیرفعال</div>';
							
		return $htmlTag;	
	}
	
	static function GetDeleteButton($pid)
	{
		$htmlTag = '<div onclick="jsDeleteProduct('.$pid.')" class="gbutton delete_gbutton">حذف</div>';
							
		return $htmlTag;	
	}
	
	static function SetProductActive($pid, $act)
	{
		$con = KW_DataBase::Connect();
		
		$ret = '';
		if($act)
			$q="UPDATE products SET Active=True WHERE ID=".$pid;
		else
			$q="UPDATE products SET Active=False WHERE ID=".$pid;
		
		mysqli_query($con,$q);
		
		$selq = "SELECT * FROM products WHERE ID=".$pid;
		if($result = mysqli_query($con,$selq))
		{
			if($row = mysqli_fetch_array($result))
			{
				if($row['Active'])
				{	
					$ret=Product::GetActiveButton($pid,true);
					$subject="Product Activated - ".$row['Name'];
				}
				else
				{
					$ret=Product::GetActiveButton($pid,false);
					$subject="Product Dectivated - ".$row['Name'];
				}
					
				$fp = 'http://www.rostaminejad.com/images/gallery/cover/'.Product::GetCoverImage($row['ID']);
				$body = '<img src="'.$fp.'" /><br/>';
				$body .= '<div style="color:#3366FF;font-size:14px;">'.$row['Name'].'</div>';
				$body .= '<div>'.$fp.'</div>';
				
				Product::SendMail($subject,$body);
				
			}		
		}	
		
		if($ret=='')
			echo '<script>alert("خطا در بروز رسانی در پایگاه داده")</script>';
		
		mysqli_close($con);	
		
		return $ret;		
	}	

	static function DeleteProduct($pid)
	{
		$con = KW_DataBase::Connect();
		echo '<script>alert("آیا از حذف مطمئن هستید؟")</script>';
		
		$ret = '';
		
		$q="UPDATE products SET Deleted=1 WHERE ID=".$pid;
		
		mysqli_query($con,$q);
		
		$selq = "SELECT * FROM products WHERE ID=".$pid;
		if($result = mysqli_query($con,$selq))
		{
			if($row = mysqli_fetch_array($result))
			{
				
				$ret="";
				$subject="Product DELETED! - ".$row['Name'];
					
				$fp = 'http://www.rostaminejad.com/images/gallery/cover/'.Product::GetCoverImage($row['ID']);
				$body = '<img src="'.$fp.'" /><br/>';
				$body .= '<div style="color:#3366FF;font-size:14px;">'.$row['Name'].'</div>';
				$body .= '<div>'.$fp.'</div>';
				
				Product::SendMail($subject,$body);
				
			}		
		}			
		
		mysqli_close($con);	
		
		return $ret;		
	}	
	
	static function SendMail($subj, $body)
	{
		$to = "farhadmn@gmail.com";
				
		$from = 'kwinfo@rostaminejad.com';
		$htmlTag = '<html><body>'.$body."</body></html>";

		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $$from \r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n".
					'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

		mail($to, $subj, $htmlTag, $headers);
	}

	static function GetProducts($groupId)
	{
		$glogos = ProductGroup::GetGroupsImages();
		
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM products WHERE Active=True AND Deleted=0";
		if($groupId>0)
			$selq .= " AND GroupID=".$groupId;
		
		$result = mysqli_query($con,$selq);
		
		$htmlTag ='';
		while($row = mysqli_fetch_array($result))
		{
			$htmlTag .= '<div id="Product_'.$row['ID'].'" class="product_frame_div" onclick="jsShowProductAlbum('.$row['ID'].')">';
			$htmlTag .= '<div class="product_div">';
			$name = $row['Name'];
			$title = $name;
			//$name.=strlen($name);
			if(strlen($name)>38)
				$title='<span style="font-size:90%;">'.$name.'</span>';
			if(strlen($name)>50)
				$title='<span style="font-size:80%;">'.$name.'</span>';
			
			$htmlTag .= '<div class="product_name_div">'.$title.'</div>';
			
			$img = Product::GetCoverImage($row['ID']);
			$htmlTag .= '<div class="product_image_div">';
			$imgpath = "images/gallery/cover/".$img;
			if($img!='')
				$htmlTag .= '<img class="product_image_img" src="images/gallery/cover/'.trim($img).'" align="middle" alt="" />';
				//$htmlTag .= '<div class="product_image_img" style="background-image: url(\''.$imgpath.'\')"></div>';	

			if($glogos[$row['GroupID']]!='')
				$htmlTag .= '<div class="product_grouplogo_div"><img src="images/'.$glogos[$row['GroupID']].'" /></div>';

			$htmlTag .= '</div>';
						$htmlTag .= '</div>';
			$htmlTag .= '</div>';
		}
		
		mysqli_close($con);	
		
		return $htmlTag;	
	}

	static function GetAllActiveProductsWithCategory()
	{

		//Order Products According to GroupID
		$groupOrder=array(1,2,3,4,5,7,8,6);

        $htmlTags = "";
        foreach($groupOrder as $gr)
        {
            //Get Name of Group to show in Title
            $htmlTags .= '<br><div class="group_title">' . ProductGroup::GetGroupName($gr) . '</div>';

            //Get List of products in given Group
            $htmlTags .= Product::GetProducts($gr);
        }

		return $htmlTags;
	}

	static function GetProductAlbum($pid)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM images WHERE ProductID=".$pid;
		
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<div class="album_page_div">';
		$htmlTag .= '<div class="album_tumbnails_div">';
		$mainImageTag = '';
		
		while($row = mysqli_fetch_array($result))
		{
			$htmlTag .='<img class="album_tumbnail_img" 
					src="images/gallery/cover/'.$row["FilePath"].'" 
					onclick="jsShowAlbumMainImage('.$row["ID"].')" />';	
			if($row['IsCover'])
			{	$img = "images/gallery/".$row['FilePath'];
				$mainImageTag = '<div class="album_main_image_img" style="background-image: url(\''.$img.'\')"><div>';
			}
		}
		
		$htmlTag .= '</div>';
		
		$htmlTag .= '<div id="divAlbumMainImage" class="album_main_image_div">'.$mainImageTag.'</div>';
		$htmlTag .= '</div>';
		return $htmlTag;
	}
	
	static function GetMainImage($imageId)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM images WHERE ID=".$imageId;
		
		if($result = mysqli_query($con,$selq))
		{
			if($row = mysqli_fetch_array($result))
			{
				//$htmlTag='<img src="images/gallery/main_'.$row['FilePath'].'" />';
				$img = "images/gallery/".$row['FilePath'];
				$htmlTag = '<div class="album_main_image_img" style="background-image: url(\''.$img.'\')"></div>';
				return $htmlTag;
			}
		}
	}
	
}

?>