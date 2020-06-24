<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Untitled 1</title>
</head>

<body dir="rtl">
<div style="margin:0px auto;" >
	<a class="amenu" onclick="jsLoadPage('page_product.php')">درج محصول جدید</a>
	<a class="amenu" onclick="jsLoadPage('page_products_list.php?search=&act=true&deact=true')" target="_parent">ویرایش محصولات</a>
	<a class="amenu"  onclick="jsLoadPage('page_scrollmsg.php')"  target="_parent">پیام</a>
	<!--a class="amenu"  onclick="jsLoadPage('page_group.php')"  target="_parent">گروه ها</a-->
</div>


<script>
function jsLoadPage(path)
{
	var targetdiv="divContent";
	jsLoadPhpPage(path, targetdiv, "", "");
}

</script>
</body>

</html>
