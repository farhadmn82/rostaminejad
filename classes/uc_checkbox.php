<?php

//////////////////////////////////
// Author : Farhad Mohammadian ///
// Date : 961029               ///
// uc_checkbox.js file must be included in main page //
//////////////////////////////////


if(isset($name))
{
	//$name = $_GET['name'];
	
	$default_checked="false";
	$default_fontsize='12px';
	$default_boxsize='10px';
	
	if(!isset($checked))
		$checked=$default_checked;
	if(!isset($fontsize))
		$fontsize=$default_fontsize;
	if(!isset($boxsize))
		$boxsize=$default_boxsize;
?>


<style>
.uc_checkbox{
	cursor:pointer; 
	display:inline-block;
	color:#303030;
	vertical-align: top;
}
.uc_checkbox:hover{
	color:black;
}

.uc_checkbox_box{
	display:table-cell;
	height: <?php echo $boxsize; ?>;
	width: <?php echo $boxsize; ?>;
	border:1px solid gray;
	border-radius:20%; 
	vertical-align:top;
	background-color:white;
}	
.uc_checkbox_boxchecked{ 
	background: url(data:image/gif;base64,R0lGODlhEAAQAMQAAORHHOVSKudfOulrSOp3WOyDZu6QdvCchPGolfO0o/XBs/fNwfjZ0frl3/zy7////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAkAABAALAAAAAAQABAAAAVVICSOZGlCQAosJ6mu7fiyZeKqNKToQGDsM8hBADgUXoGAiqhSvp5QAnQKGIgUhwFUYLCVDFCrKUE1lBavAViFIDlTImbKC5Gm2hB0SlBCBMQiB0UjIQA7);
    background-repeat: no-repeat;
    background-position: center;
    background-size: <?php echo $boxsize; ?>;
	background-color:white; 
}
.uc_checkbox_boxunchecked{ background-color:white;	 }

.uc_checkbox_text{
	display: table-cell;
	vertical-align:middle;
	line-height: <?php echo $boxsize; ?>;
	font-size: <?php echo $fontsize; ?>;
	padding-right:5px;
}

</style>


<div id="<?php echo $name ?>" class="uc_checkbox" onclick="CheckedChange('<?php echo $name ?>')"  checked="<?php echo $checked ?>">	
	<div id="<?php echo $name ?>_Box" 
		class="uc_checkbox_box uc_checkbox_box<?php if($checked=="true") echo "checked"; else echo "unchecked"; ?>">
	</div>
	<div id="<?php echo $name ?>_Text" class="uc_checkbox_text"><?php echo $text ?></div>
</div>

<?php 
}
?>


