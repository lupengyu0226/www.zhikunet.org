var n=0;
var showsTab = document.getElementById("focus_tabsbg");
var m=showsTab.getElementsByTagName("div").length;
function Mea(value){
	n=value;
	setBg(value);
	plays(value);
	cons(value);
	}
function setBg(value){
	for(var i=0;i<m;i++)
   if(value==i){
		showsTab.getElementsByTagName("div")[i].className='tabs_on';
		var pp = 236-59*i;
		showsTab.style.backgroundPosition = '0 -'+pp+'px';
		} 
	else{	
		showsTab.getElementsByTagName("div")[i].className='';
		}  
	} 
function plays(value){
	try
	{
		with (focus_bigpic){
			filters[0].Apply();
			for(i=0;i<m;i++)i==value?children[i].className="dis":children[i].className="undis"; 
			filters[0].play(); 		
			}
	}
	catch(e)
	{
		var d = document.getElementById("focus_bigpic").getElementsByTagName("div");
		for(i=0;i<m;i++)i==value?d[i].className="dis":d[i].className="undis"; 
	}
}
function cons(value){
try
	{
		with (focus_txt){

		for(i=0;i<m;i++)i==value?children[i].className="dis":children[i].className="undis"; 
 		
		}
	}
	catch(e)
	{
		var d = document.getElementById("focus_txt").getElementsByTagName("div");
		for(i=0;i<m;i++)i==value?d[i].className="dis":d[i].className="undis"; 
	}
}

function clearAuto(){clearInterval(autoStart)}
function setAuto(){autoStart=setInterval("auto(n)", 3000)}
function auto(){
	n++;
	if(n>=m)n=0;
	Mea(n);
} 
function sub(){
	n--;
	if(n<0)n=m-1;
	Mea(n);
} 
setAuto(); 