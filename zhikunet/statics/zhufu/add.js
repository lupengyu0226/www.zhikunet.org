function FaceChoose(n){
	var ClassName = "Face"+n;
	document.getElementById("Peview").setAttribute("class",ClassName);
	document.getElementById("Peview").setAttribute("className",ClassName);
	frmAdd.face.value = n;
}
function IconChange(n){
	var IconUrl = "http://statics.05273.cn/zhufu/images/icon"+n+".gif";
	document.getElementById("IconImg").src = IconUrl;	
	frmAdd.icon.value = n;	
}
function InputName(OriInput, GoalArea){
	document.getElementById(GoalArea).innerHTML = OriInput.value;
}
function strCounter(field){
	if (field.value.length > 30)
		field.value = field.value.substring(0, 30);
	else{
		document.getElementById("Char").innerHTML = 30 - field.value.length;
		document.getElementById("AreaText").innerHTML = field.value;
	}
}
function getTime(){
	var ThisTime = new Date();
	document.write(ThisTime.getFullYear()+"-"+(ThisTime.getMonth()+1)+"-"+ThisTime.getDate()+" "+ThisTime.getHours()+":"+ThisTime.getMinutes()+":"+ThisTime.getSeconds()); 
}