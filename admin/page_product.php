<?php
require "../classes/cls_database.php";
require "../classes/cls_product.php";
require '../classes/cls_group.php';
?>

<?php
	$pid = 0;
	if(isset($_GET['pid']))
	{
		$pid = $_GET['pid'];
	}
	
	$prod = new Product($pid);
?>

<div id="divProductData">
	<div class="section_title_div">اطلاعات محصول</div>
	<div class="main_page data_page">
		
		<input type="hidden" id="lblProductID" value="<?php echo $prod->ID; ?>" />
		
		<div class="gbutton edit_gbutton" style="display: inline-block;" onclick="jsShowProduct(<?php echo ($prod->ID - 1); ?>)">محصول قبلی</div>
		<div class="gbutton edit_gbutton" style="display: inline-block;" onclick="jsShowProduct(<?php echo ($prod->ID + 1); ?>)">محصول بعدی</div>
		<div style="padding:10px;"></div>
		<?php
		$boxsize="40px"; $fontsize="32px";
		$checked="false";
		if($prod->Active)
			$checked="true";
		
		$name='chkProdActive';	$text="فعال";
		require '../classes/uc_checkbox.php';	
		?>
		
		<div class="fieldrow_div">
			<div class="fieldtitle_div">شناسه</div>
			<div id="txtProductId" class="fieldtitle_div"><?php echo strval($prod->ID); ?></div>
		</div>
		<div class="fieldrow_div">
			<div class="fieldtitle_div">عنوان محصول</div>
			<input id="txtProductName" class="input_box" value="<?php echo $prod->Name; ?>" />
		</div>
		<div class="fieldrow_div">
			<div class="fieldtitle_div">گروه</div>
			<?php echo ProductGroup::GetGroupsComboBox($prod->GroupID);	?>
		</div>
		<div class="fieldrow_div">
			<div class="gbutton save_gbutton" name="SaveProduct" onclick="jsSaveProduct()">ذخیره</div>
		</div>
	</div>

	<?php if($prod->ID>0) { ?>
	<div class="section_title_div">تصاویر محصول</div>
	<div class="main_page data_page">
		
		<div style="margin-bottom: 3%;   border-bottom: 2px solid #606060;">
			<div class="fieldtitle_div">انتخاب تصویر</div>
			<input id="avatar" type="file" name="avatar" style="display:inline-block;    width: 180px;"/>
			<div class="gbutton save_gbutton" style="display:inline-block;" id="upload" value="Upload" >ذخیره تصویر</div>
		</div>
		
		<div id="divProductImagesTable">
			<?php echo $prod->GetProductImagesTable();	?>
		</div>
	</div>
	<?php } ?>
	<div id="RESULT" class="hidden_result"></div>
</div>
