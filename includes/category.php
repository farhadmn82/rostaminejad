<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>
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
	echo '<a class="catmenu" href="index.php?pid=products2&cat='.$catname[$ci].'">'.$catname[$ci].'</a>&nbsp';

}
?>

</body>

</html>
