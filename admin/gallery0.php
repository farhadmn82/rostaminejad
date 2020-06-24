<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="../mystyle1.css" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>عکس ها</title>
</head>

<body dir="rtl" style="background-color:#6666FF">

<?php
session_start();
if(!isset($_SESSION['user']))
{
header('Location: adminhome.php');
}

include 'adminmenu.php';
include 'connect.php';
	//mysqli_query($con,"INSERT INTO services (id, servtitle, stylistname, is_active) VALUES ('','ناخن', 'امینی',1)");
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
			
			echo '<tr><td><img style="width:50px;" src="../images/gallery/tmbn/'.$gallfile[$i].'"></td>';
			echo '<td>'.$gallfile[$i].'</td>';
			echo '<td>'.trim($galltitle[$i]).'</td>';
			echo '<td>'.trim($category[$i]).'</td>';
			echo '<td><a href="dataaccess.php?act=del&table=gallery&id='.$gallid[$i].'">حذف</a></td>';
			echo '<td><a href="dataaccess.php?act=edit&table=gallery&id='.$gallid[$i].'">ویرایش</a></td>';
			echo '</tr>';
		}
		echo '</table>';
	?>

</body>

</html>
