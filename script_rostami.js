function showpic(imgfile)
{
	document.getElementById('showimage').style.visibility="visible";
	document.getElementById("showimage").innerHTML="<img id='b0' width=800px src='".imgfile."'>";
}

function hidepic()
{
	document.getElementById('showimage').style.visibility="hidden";

}
