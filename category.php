<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<style>
.catmenu{
	background-color: slateblue;
	border:thin white solid;
	/* width:100px; */
	color:white;
	margin:5px;
	padding: 10px;
	text-decoration:none;
	border-radius: 5px;
	box-shadow: 2px 2px 2px gray;
	font-family:MyFont1;
}


.catmenu:hover{
	background-color: darkslateblue;
	border:thin black solid;
	color: white;
}

.catmenu:visited{
	color:white;
}
a.catmenu {
    display: inline-block;
}

</style>


</head>

<body>
<?php

	if(!isset($linkpath))
		$linkpath = 'index.php?pid=products2';
		
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
	
echo '<a class="catmenu" href="'.$linkpath.'">همه رینگ ها</a>&nbsp';
for($ci=0;$ci<count($catname);$ci++)
{
	echo '<a class="catmenu" href="'.$linkpath.'&cat='.trim($catname[$ci]).'">'.$catname[$ci].'</a>&nbsp';

}

?>
<br />
</body>

</html>
