
function jsLoadPhpPage(page, targetdiv, secondpage, secondtargetdiv)
{
	document.getElementById('divShadow').style.display="block";

    var p = page;
	//alert(p);
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   
			document.getElementById(targetdiv).innerHTML=xmlhttp.responseText;	
			document.getElementById('divShadow').style.display="none";
			_jsSetShadowMessage(' ');
			
			if(secondpage!="")
			{
				jsLoadPhpPage(secondpage, secondtargetdiv, "", "");
			}
        }
    }

    xmlhttp.open("POST", p, true);
    xmlhttp.send();
}

function jsAddSpec()
{
	var targetdiv="divSpecsTable";
	var specName = document.getElementById("txtSpecName").value;
	var page = "phpmethods.php?method=AddSpecType&name="+specName;
	var tblpage = "phpmethods.php?method=GetSpecTypesTable";
	jsLoadPhpPage(page, targetdiv, tblpage, targetdiv);
}

function jsAddGroup()
{
	var targetdiv="divGroupsTable";
	var specName = document.getElementById("txtSpecName").value;
	var page = "phpmethods.php?method=AddProductGroup&name="+specName;
	var tblpage = "phpmethods.php?method=GetGroupsTable";
	jsLoadPhpPage(page, targetdiv, tblpage, targetdiv);
}


function jsShowProduct(pid)
{
	_jsSetShadowMessage('در حال دریافت اطلاعات محصول');
	var targetdiv="divContent";
	var page = "../admin/page_product.php?pid="+pid;
		
	jsLoadPhpPage(page, targetdiv, "", "");
}

function _jsSetShadowMessage(mes)
{
	var tag = '<div class="shadow_content_div">';
	if(mes == ' ')
		tag = '<div class="shadow_content_div" style="width:150px;">';
	tag += '<div class="shadow_text_div">'+mes+'</div>';
	tag += '<div class="shadow_loading_image_div"></div>';
	tag += '</div>';
	document.getElementById('divShadow').innerHTML=tag;	
}

function jsSaveProduct()
{
	_jsSetShadowMessage('در حال ذخیره اطلاعات محصول');
	
	var targetdiv="divContent";
	var prodId = document.getElementById("lblProductID").value;
	var prodActive = document.getElementById("chkProdActive").getAttribute("checked");
	var prodName = document.getElementById("txtProductName").value;
	var e = document.getElementById("ProductGroup_Select");
	var prodGroup = e.options[e.selectedIndex].value;
	
	var page = "phpmethods.php?method=SaveProduct&id="+prodId+"&name="+prodName+"&act="+prodActive+"&gid="+prodGroup;
	
	var pid = prodId;
	if(pid==0)
		pid=-1;//-1 mean that last record must be extracted from DB

	var tblpage = "page_product.php?pid="+pid;
	jsLoadPhpPage(page, targetdiv, tblpage, targetdiv);
}

function jsSetCoverImage(imageId)
{
	var targetdiv="divContent";
	var prodId = document.getElementById("lblProductID").value;
	var page = "phpmethods.php?method=SetCoverImage&pid="+prodId+"&iid="+imageId;
	
	if(prodId==0)
		prodId=-1;//-1 mean that last record must be extracted from DB

	var tblpage = "phpmethods.php?method=GetProductImagesTable&pid="+prodId;
	jsLoadPhpPage(page, "RESULT", tblpage, "divProductImagesTable");
}

function jsDeleteImage(imageId)
{
	_jsSetShadowMessage('در حال حذف تصویر محصول');
	var targetdiv="divContent";
	var prodId = document.getElementById("lblProductID").value;
	
	var dr = confirm("آیا از حذف تصویر مطمئن هستید؟");
	if(!dr)
		return;
	
	var page = "phpmethods.php?method=DeleteImage&iid="+imageId;
	var tblpage = "phpmethods.php?method=GetProductImagesTable&pid="+prodId;
	jsLoadPhpPage(page, "RESULT", tblpage, "divProductImagesTable");
}

function jsSetActiveProduct(prodId, active)
{
	var targetdiv = "cellProdActive"+prodId;
	var page = "phpmethods.php?method=SetProductActive&pid="+prodId+"&act="+active;

	jsLoadPhpPage(page, targetdiv, "", "");
}

function jsDeleteProduct(prodId)
{
	var result = confirm("آیا از حذف محصول مطمئن هستید؟?"); 
	if(result == true) 
	{ 
		var targetdiv = "rowProduct"+prodId;
		var page = "phpmethods.php?method=DeleteProduct&pid="+prodId;

		jsLoadPhpPage(page, targetdiv, "", "");
	}
}

function jsFilterProductsTable()
{
	_jsSetShadowMessage('در حال دریافت لیست محصولات');
	var targetdiv="divContent";
	var txt = document.getElementById('txtSearch').value;
	var act = document.getElementById('chk1').getAttribute("checked");
	var deact = document.getElementById('chk2').getAttribute("checked");
	
	var page = "../admin/page_products_list.php?search="+txt+"&act="+act+"&deact="+deact;
	
	jsLoadPhpPage(page, targetdiv, "", "");
}

function jsLoadGroupProducts(gid)
{
	_jsSetShadowMessage('در حال دریافت لیست محصولات');
	var page = "admin/phpmethods.php?method=GetProducts&gid="+gid;
	jsLoadPhpPage(page, "divProducts", "", "");
}

function jsShowProductAlbum(pid)
{
	_jsSetShadowMessage('در حال دریافت تصاویر محصول');
	document.getElementById('divProductAlbumBackGroundShadow').style.display="block";
	document.getElementById('divProductAlbum').style.display="block";	
	
	var page = "admin/phpmethods.php?method=GetProductAlbum&pid="+pid;

	jsLoadPhpPage(page, "divProductAlbum", "", "");
}

function jsShowAlbumMainImage(iid)
{
	_jsSetShadowMessage('در حال دریافت تصویر محصول');
	var page = "admin/phpmethods.php?method=GetMainImage&iid="+iid;

	jsLoadPhpPage(page, "divAlbumMainImage", "", "");
}

function jsCloseProductAlbum()
{
	document.getElementById('divProductAlbumBackGroundShadow').style.display="none";
	document.getElementById('divProductAlbum').style.display="none";	
	
	document.getElementById('divProductAlbum').innerHTML="";	
}

$(document).on("click", "#upload", function() {
	_jsSetShadowMessage('در حال ذخیره تصویر محصول');
	document.getElementById('divShadow').style.display="block";
	var file_data = $("#avatar").prop("files")[0];   // Getting the properties of file from file field
	var prodId = $("#lblProductID").prop("value");   // Getting the property
	var form_data = new FormData();                  // Creating object of FormData class
	form_data.append("file", file_data) ;             // Appending parameter named file with properties of file_field to form_data
	form_data.append("method", "AddProductImage");                // Adding extra parameters to form_data
	form_data.append("productId", prodId); 
	$.ajax({
			url: "../admin/phpmethods.php",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         // Setting the data attribute of ajax with file_data
			type: 'post',
			success:function(response)
					{
						var page = "phpmethods.php?method=GetProductImagesTable&pid="+prodId;
						document.getElementById('divShadow').style.display="none";
						_jsSetShadowMessage('در حال دریافت لیست تصاویر محصول');
						jsLoadPhpPage(page, "divProductImagesTable", "", "");
					}
       })
})