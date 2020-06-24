<?php
require "../classes/cls_database.php";

if(isset($_POST['method']))
	$method = $_POST['method'];
if(isset($_GET['method']))
	$method = $_GET['method'];

switch($method)
{
	case "AddSpecType":
		$name = $_GET['name'];
		require "../classes/cls_spectype.php";
		SpecType::AddSpecType($name);
	break;
	
	case "GetSpecTypesTable":
		require "../classes/cls_spectype.php";
		$res = SpecType::GetSpecTypesTable();
		echo $res;
	break;
	
	case "AddProductGroup":
		$name = $_GET['name'];
		require "../classes/cls_group.php";
		ProductGroup::AddGroup($name);
	break;
	
	case "GetGroupsTable":
		require "../classes/cls_group.php";
		$res = ProductGroup::GetGroupsTable();
		echo $res;
	break;
	
	case "AddProductImage":
		require "../classes/cls_product.php";
		echo "SaveImage";
		echo $_POST['productId'];
		$prod = new Product($_POST['productId']);
		$prod->AddProductImage();
	break;

	case "SaveProduct":
		require "../classes/cls_product.php";
		$prod = new Product($_GET['id']);
		$prod->Active = False;
		if($_GET['act']=="true")
			$prod->Active = True;
		$prod->Name = $_GET['name'];
		$prod->GroupID = $_GET['gid'];
		$prod->Save();
	break;
	
	case "SetCoverImage":
		require "../classes/cls_product.php";
		Product::SetCoverImage($_GET['pid'], $_GET['iid']);
	break;
	
	case "SetProductActive":
		require "../classes/cls_product.php";
		$res = Product::SetProductActive($_GET['pid'], $_GET['act']);
		echo $res;
	break;
	
	case "DeleteProduct":
		require "../classes/cls_product.php";
		$res = Product::DeleteProduct($_GET['pid']);
		echo $res;
	break;
	
	case "GetProductsTable":
		require "../classes/cls_product.php";
		$res = Product::GetProductsTable($_GET['search'], $_GET['act'], $_GET['deact']);
		echo $res;
	break;
	
	case "GetProductImagesTable":
		require "../classes/cls_product.php";
		$prod = new Product($_GET['pid']);
		$res = $prod->GetProductImagesTable();
		echo $res;
	break;
	
	case "DeleteImage":
		require "../classes/cls_product.php";
		Product::DeleteImage($_GET['iid']);
	break;
	
	case "GetProducts":
		require "../classes/cls_group.php";
		require "../classes/cls_product.php";
		if($_GET['gid'] == "0")
		    $res = Product::GetAllActiveProductsWithCategory();
		else
		    $res = Product::GetProducts($_GET['gid']);

		echo $res;
	break;
	
	case "GetProductAlbum":
		require "../classes/cls_product.php";
		$res = Product::GetProductAlbum($_GET['pid']);
		echo $res;
	break;
	
	case "GetMainImage":
		require "../classes/cls_product.php";
		$res = Product::GetMainImage($_GET['iid']);
		echo $res;
	break;
}

?>