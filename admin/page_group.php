<?php
require "../classes/cls_database.php";
require '../classes/cls_group.php';
?>

<div class="main_page data_page">
	<span>عنوان گروه</span>
	<input id="txtSpecName" class="input_box" />
	<button name="AddSpec" onclick="jsAddGroup()">افزودن</button>
	
	<div id="divGroupsTable" style="margin:30px auto;">
		<?php 
			$st = new ProductGroup();
			echo $st->GetGroupsTable();
			//echo KW_DataBase::GetColorsTable();
		?>
	</div>
</div>

