<?php
require "../classes/cls_database.php";
require '../classes/cls_spectype.php';
?>

<div class="main_page data_page">
	<span>عنوان ویژگی</span>
	<input id="txtSpecName" class="input_box" />
	<button name="AddSpec" onclick="jsAddSpec()">افزودن</button>
	
	<div id="divSpecsTable" style="margin:30px auto;width:300px;">
		<?php 
			$st = new SpecType();
			echo $st->GetSpecTypesTable();
			//echo KW_DataBase::GetColorsTable();
		?>
	</div>
</div>



<div id="RESULT" onchanged=""></div>


