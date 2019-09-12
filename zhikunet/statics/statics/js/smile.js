function AddOnPos(obj, charvalue)
{
	//非IE内核浏览器
	if(window.getSelection){
		obj.value = obj.value + charvalue;
	}
	//IE内核浏览器
	else if(document.selection)
	{
	obj.focus();
	var r = document.selection.createRange();
	var ctr = obj.createTextRange();
	var i;
	var s = obj.value;
	var ivalue = "&^asdjfls2FFFF325%$^&";
	r.text = ivalue;
	i = obj.value.indexOf(ivalue);
	r.moveStart("character", -ivalue.length);
	r.text = "";
	obj.value = s.substr(0,i) + charvalue + s.substr(i,s.length);
	ctr.collapse(true);
	ctr.moveStart("character", i + charvalue.length);
	ctr.select();
    }
}