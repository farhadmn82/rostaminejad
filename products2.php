<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="fa" http-equiv="Content-Language">
	

<style>

#products_div {
    width: fit-content;
    margin: 10px auto;
    min-width: 890px;
}
.prods_row {
    padding: 10px 0px;
    border-bottom: 2px ridge darkorange;
}

.product_frame_div {
    display: inline-block;
	vertical-align: top;
    cursor: pointer;    
	width: 222px;
    height: 260px;
}

.product_div{
	margin: 17px 10px 5px 10px;
    border: 1px solid white;
    border-radius: 5px;
    background-color: white;
    max-height: 238px;
    min-height: 100px;
    box-shadow: 2px 2px 2px grey;
}
.product_div:hover {
	box-shadow: 0px 0px 15px lightyellow;
}

.product_name_div {
    text-align: center;
    padding: 8px;
    background-color: darkred;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    color: white;
    font-family: MyFont1;
	min-height: 20px;
	max-height: 20px;
}
.product_image_div {
	position: relative;
}
.product_image_img{
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    max-height: 200px;
    max-width: 200px;
	display: block;
    margin: 0px auto;
}
.product_grouplogo_div{
    position: absolute;
	top: 0px;
    left: 0px;
}
.product_grouplogo_div img{
    height:64px;
}

.album_page_div{
	width: 100%;
    height: 100%;
    background-color: white;
    margin: 0%;
    border-radius: 5px;
    box-shadow: 4px 4px 10px 5px;
}

.album_tumbnails_div
{
width: 150px;
    overflow: scroll;
    margin: 2%;
    position: relative;
    display: inline-block;
    height: 94%;
	vertical-align: top;
}
.album_tumbnail_img
{
	width: 128px;
    margin-bottom: 5px;
    border-bottom: 1px solid #404040;
    padding-bottom: 5px;
	cursor:pointer;
}
.album_tumbnail_img:hover
{
	width: 130px;
}

.album_main_image_div
{
	display: inline-block;
    width: calc(92% - 150px);
    max-height: 90%;
    vertical-align: top;
    margin: 5% 1% 5% 3%;
    height: 86%;
}
.album_main_image_img{
	top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-repeat: no-repeat;
    background-size: contain;
    width: 100%;
    height: 100%;
    background-position: center;
}
.album_main_image_div img{
	width:100%;
}
</style>


<style>
#showimage {
	position:fixed;
	visibility:hidden;
	transition:width 1s, height 3s, transform 2s; 
	top:0px;
	left:0px;
	-webkit-transition:width 1s, height 3s, -webkit-transform 2s; /* Safari */
	overflow:hidden;
	background-color:black;
	width:100%;
	height:100%;
	margin:auto;
	opacity:0.8;	
}

#bigimage_div{
    position: fixed;
    top: 0px;
    right: 0px;
    padding: 30px;
    visibility:hidden;
    z-index:10;
}
#loading{
	font-size: x-large;
    font-family: Tahoma;
    color: white;
    z-index: 7;
    /* padding-right: 200px; */
    padding-top: 100px;
    visibility: hidden;
    text-align: center;
    position: absolute;}
#imgBig{
	z-index: 8;
    opacity: 1;
    position: absolute;	
}
#imgBig img{
	height: -webkit-fill-available;
	max-height: 500px;
    border-radius: 10px;
    box-shadow: 0px 0px 15px lightyellow;
    border: 3px solid burlywood;
}
#close{
	position: absolute;
    z-index: 11;
    top: 35px;
    right: 35px;
    cursor:pointer;
    
}
#close img:hover{
	width:52px;
	height:52px;
}
.group_title{
border: 1px solid gray;
    margin: 10px 2% 10px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    border-radius: 5px;
    background-color: tan;
    box-shadow: 0px 0px 5px 0px lightgrey;
    font-family: MyFont1;
    font-size: 28px;
}
</style>

<script>
function showpic(imgfile)
{
	document.getElementById('showimage').style.visibility="visible";
	//document.getElementById('close').style.visibility="visible";
	document.getElementById('bigimage_div').style.visibility="visible";
	document.getElementById("imgBig").innerHTML="<img id='b0' width=auto height=auto src='"+imgfile+"'>";
	//document.getElementById('loading').style.visibility="visible";
}

function hidepic()
{
	document.getElementById('showimage').style.visibility="hidden";
	//document.getElementById('close').style.visibility="hidden";
	document.getElementById('bigimage_div').style.visibility="hidden";
	//document.getElementById('loading').style.visibility="hidden";
}
function hideLoading()
{
	document.getElementById('loading').style.visibility="hidden";
}

</script>
</head>

<?php
//require "classes/cls_database.php";
require "classes/cls_product.php";
require 'classes/cls_group.php';
?>

<div id="divProductAlbumBackGroundShadow" class="product_album_bg_shadow_div" onclick="jsCloseProductAlbum()">
</div>

<div id="divProductAlbum" class="product_album_div">
</div>

<div id="divProductGroups">
	<?php echo ProductGroup::GetGroupsButtons();  ?>
</div>

<div id="divProducts">
	<?php
	    //echo Product::GetProducts(0);
	    echo Product::GetAllActiveProductsWithCategory();
	?>
</div>





