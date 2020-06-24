<?php
require "../classes/cls_database.php";
require '../classes/cls_product.php';
//require '../classes/cls_checkbox.php';
?>

<?php
	$search='';
	if(isset($_GET['search']))
		$search = $_GET['search'];
	
	$actProds = "true";
	if(isset($_GET['act']))
		$actProds = $_GET['act'];
	
	$deactProds = "true";
	if(isset($_GET['deact']))
		$deactProds = $_GET['deact'];
?>

<div class="main_page data_page">
	
	<?php
		$boxsize="20px"; $fontsize="16px";
		$name='chk1';	$text="محصولات فعال";   $checked=$actProds;
		require '../classes/uc_checkbox.php';	
		$name='chk2';	$text="محصولات غیرفعال"; $checked=$deactProds; 
		require '../classes/uc_checkbox.php';	
	?>
	<input type="text" id="txtSearch" class="input_search" value="<?php echo $search; ?>" ></input>
	<div class="gbutton search_gbutton" onclick="jsFilterProductsTable()">جستجو</div>
	
	<div id="divProductsTable" style="margin:30px auto;	">
		<?php 
			echo Product::GetProductsTable($search, $actProds, $deactProds);
		?>
	</div>
</div>