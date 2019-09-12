function $(obj){return document.getElementById(obj);};function $N(obj){return document.getElementsByName(obj);};function $T(obj){return document.getElementsByTagName(obj);};function $V(str){document.write(str);};function addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func;}else{window.onload=function(){oldonload();func();}}};function addObjectEvent(ele,evt,func){var oldonevent=ele['on'+evt];if(typeof ele['on'+evt]!='function'){ele['on'+evt]=func;}else{ele['on'+evt]=function(event){oldonevent(event);func(event);}}};function addKeyEvent(key,func){if(!VeryIDE.tmpKey){VeryIDE.tmpKey=[];};VeryIDE.tmpKey["k"+key]=func;};addKeyEvent.Listener=function(e,test){var event=e||window.event;if(VeryIDE.tmpKey["k"+event.keyCode]){VeryIDE.tmpKey["k"+event.keyCode](event);};if(test){alert(event.keyCode);}};function getObject(o){if(typeof(o)!="object"){var o=$(o);};return o;};String.prototype.Trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");};String.prototype.LTrim=function(){return this.replace(/(^\s*)/g,"");};String.prototype.Rtrim=function(){return this.replace(/(\s*$)/g,"");};String.prototype.long=function(){var i;var l=this.length;var len;len=0;for(i=0;i<l;i++){if(this.charCodeAt(i)>255)len+=2;else  len++;};return len;};function inArray(a,v){var l=a.length;for(var i=0;i<=l;i++){if(a[i]==v)return true;};return false;};document.getElementsByClassName=function(){var children=document.getElementsByTagName('*')||document.all;var elements=new Array();var len=children.length;for(var i=0;i<len;i++){var child=children[i];var classNames=child.className.split(' ');for(var j=0;j<classNames.length;j++){for(var k=0;k<arguments.length;k++){if(classNames[j]==arguments[k]){elements.push(child);break;}}}};return elements;};function getPosition(obj){var obj=getObject(obj);this.width=obj.offsetWidth;this.height=obj.offsetHeight;this.top=obj.offsetTop;this.left=obj.offsetLeft;while(obj=obj.offsetParent){this.top+=obj.offsetTop;this.left+=obj.offsetLeft;}};function getSelect(obj){var obj=getObject(obj);this.value="";this.text="";this.index="";if(obj.length>0){this.value=obj[obj.selectedIndex].value;this.text=obj[obj.selectedIndex].text;this.index=obj.selectedIndex;};this.getAtt=function(att){return obj[obj.selectedIndex].getAttribute(att);}};function getRadio(obj){var obj=$N(obj);var len=obj.length;this.value="";for(var i=0;i<len;i++){if(obj[i].checked==true){this.value=obj[i].value;break;}}};function setSelect(obj,v){var obj=$(obj);var len=obj.length;for(var i=0;i<len;i++){if(obj[i].value==v){obj.selectedIndex=i;break;}}};function setRadio(o,v){var obj=$N(o);var len=obj.length;for(var i=0;i<len;i++){if(obj[i].value==v){obj[i].checked=true;break;}}};function setDisabled(obj,b){var obj=getObject(obj);if(obj){obj.disabled=b;}};function setClass(obj,Class,Type){var obj=getObject(obj);if(obj){switch(Type){case"+":obj.className+=" "+Class;break;case"-":obj.className=obj.className.replace(Class,"");break;case"":obj.className=Class;break;}}};function delElement(obj){var obj=getObject(obj);var p=obj.parentNode;p.removeChild(obj);};function inputAutoClear(ipt){ipt.onfocus=function(){if(this.value==this.defaultValue){this.value='';}};ipt.onblur=function(){if(this.value==''){this.value=this.defaultValue;}};if(ipt.value==ipt.defaultValue){ipt.value='';}} ;function getRnd(len,vUpper,vLower,vNum){var seed_array=new Array();var seedary;seed_array[0]="";seed_array[1]="a b c d e f g h i j k l m n o p q r s t u v w x y z";seed_array[2]="a b c d e f g h i j k l m n o p q r s t u v w x y z";seed_array[3]="0 1 2 3 4 5 6 7 8 9";if(!vUpper&&!vLower&&!vNum){vUpper=true;vLower=true;vNum=true;};if(vUpper){seed_array[0]+=seed_array[1];};if(vLower){seed_array[0]+=" "+seed_array[2];};if(vNum){seed_array[0]+=" "+seed_array[3];};seed_array[0]=seed_array[0].split(" ");seedary="";for(var i=0;i<len;i++){seedary+=seed_array[0][Math.round(Math.random()*(seed_array[0].length-1))];};return(seedary);};function getTime(){var isnMonths=new Array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");var isnDays=new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六","星期日");today=new Date();hrs=today.getHours();min=today.getMinutes();sec=today.getSeconds();clckh=""+((hrs>12)?hrs-12:hrs);clckm=((min<10)?"0":"")+min;clcks=((sec<10)?"0":"")+sec;clck=(hrs>=12)?"下午":"上午";var stnr="";var ns="0123456789";var a="";document.write(today.getFullYear()+"年"+isnMonths[today.getMonth()]+""+today.getDate()+"日  "+isnDays[today.getDay()]);};var VeryIDE={} ;VeryIDE.TabOption=function(e){this.Event=e;this.Cur=-1;this.Inter=null;this.Speed=0;this.Array=new Array();this.TClass=["",""];this.BClass=["",""];this.TabClass=function(ActClass,DefClass){this.TClass=[ActClass,DefClass];};this.BoxClass=function(ActClass,DefClass){this.BClass=[ActClass,DefClass];};this.Add=function(obj,target){if(obj&&target){this.Array[this.Array.length]=[obj,target];}};this.onChange=function(){};this.Change=function(tab){for(var n=0;n<this.Array.length;n++){this.Array[n][0].className=this.TClass[1];if(this.BClass[0]||this.BClass[1]){this.Array[n][1].className=this.BClass[1];}else{this.Array[n][1].style.display="none";}};}}
function VeryIDE_Hello(){
	var hour = new Date().getHours();
	if (hour < 4) {
		hello = "夜深了！";
	}else if (hour < 7) {
		hello = "早安！";
	}else if (hour < 9) {
		hello = "早上好！"; 
	}else if (hour < 12) {
		hello = "上午好！";
	}else if (hour < 14) {
		hello = "中午好！";
	}else if (hour < 17) {
		hello = "下午好！";
	}else if (hour < 19) {
		hello = "您好！";
	}else if (hour < 22) {
		hello = "晚上好！";
	}else {
		hello = "夜深了！";
	}
	$V(hello);
}

function VeryIDE_Hello(){
	var hour = new Date().getHours();
	if (hour < 4) {
		hello = "夜深了！";
	}else if (hour < 7) {
		hello = "早安！";
	}else if (hour < 9) {
		hello = "早上好！"; 
	}else if (hour < 12) {
		hello = "上午好！";
	}else if (hour < 14) {
		hello = "中午好！";
	}else if (hour < 17) {
		hello = "下午好！";
	}else if (hour < 19) {
		hello = "您好！";
	}else if (hour < 22) {
		hello = "晚上好！";
	}else {
		hello = "夜深了！";
	}
	$V(hello);
}

addLoadEvent(function(){
	
	var nav=$("leftnav");
	var dl=leftnav.getElementsByTagName("dl");
	for(var i=0;i<dl.length;i++){
		
		(function(){
			var dt=dl[i].getElementsByTagName("dt")[0];
			var dd=dl[i].getElementsByTagName("dd")[0];
			
			if(!dl[i].getAttribute("rel")){
				dt.className="";
				dd.style.display="none";
			}
			dt.onclick=function(){
				if(this.className=="active"){
					this.className="";
					dd.style.display="none";
				}else{
					this.className="active";
					dd.style.display="";
				}
			}
		})();
	}
});