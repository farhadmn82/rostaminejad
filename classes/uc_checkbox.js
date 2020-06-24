function CheckedChange(name)
{
	var chk = document.getElementById(name);
	var box = document.getElementById(name+'_Box');
	var checked = chk.getAttribute("checked");
	box.className="uc_checkbox_box";
	
	if(checked=="false")
	{
		box.classList.add("uc_checkbox_boxchecked");
		chk.setAttribute('checked',"true");
	}
	else
	{
		box.classList.add("uc_checkbox_boxunchecked");
		chk.setAttribute('checked',"false");
	}
				
	
	
}