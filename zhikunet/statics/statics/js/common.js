function hid(id) {
	return document.getElementById(id);
}

// 焦点轮换图片
function addLoadEvent(func){
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function(){
			oldonload();
			func();
		}
	}
}


function moveElement(elementID,final_x,final_y,interval) {
  if (!document.getElementById) return false;
  if (!document.getElementById(elementID)) return false;
  var elem = document.getElementById(elementID);
  if (elem.movement) {
    clearTimeout(elem.movement);
  }
  if (!elem.style.left) {
    elem.style.left = "0px";
  }
  if (!elem.style.top) {
    elem.style.top = "0px";
  }
  var xpos = parseInt(elem.style.left);
  var ypos = parseInt(elem.style.top);
  if (xpos == final_x && ypos == final_y) {
		return true;
  }
  if (xpos < final_x) {
    var dist = Math.ceil((final_x - xpos)/10);
    xpos = xpos + dist;
  }
  if (xpos > final_x) {
    var dist = Math.ceil((xpos - final_x)/10);
    xpos = xpos - dist;
  }
  if (ypos < final_y) {
    var dist = Math.ceil((final_y - ypos)/10);
    ypos = ypos + dist;
  }
  if (ypos > final_y) {
    var dist = Math.ceil((ypos - final_y)/10);
    ypos = ypos - dist;
  }
  elem.style.left = xpos + "px";
  elem.style.top = ypos + "px";
  var repeat = "moveElement('"+elementID+"',"+final_x+","+final_y+","+interval+")";
  elem.movement = setTimeout(repeat,interval);
}

function changeclass(focus_turn_btn,focus_turn_tx, n){
	var focusBtnList = hid(focus_turn_btn).getElementsByTagName('li');
	var focusTxList = hid(focus_turn_tx).getElementsByTagName('li');
	for(var i=0; i<focusBtnList.length; i++) {
		if(i == n) {
			focusBtnList[n].className='current';
			focusTxList[n].className='current';
		} else {
			focusBtnList[i].className='normal';
			focusTxList[i].className='normal';
		}
	}
}


function newsfocusChange() {
	if(!hid('news_focus_turn')||!hid('news_focus_turn_btn')) return;
	var focusBtnList = hid('news_focus_turn_btn').getElementsByTagName('li');
	if(!focusBtnList||focusBtnList.length==0) return;
	var listLength = focusBtnList.length;
		focusBtnList[0].onmouseover = function() {
			moveElement('news_focus_turn_picList',0,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',0)
		}
	if (listLength>=2) {
		focusBtnList[1].onmouseover = function() {
			moveElement('news_focus_turn_picList',-400,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',1)
		}
	}
	if (listLength>=3) {
		focusBtnList[2].onmouseover = function() {
			moveElement('news_focus_turn_picList',-800,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',2)
		}
	}
	if (listLength>=4) {
		focusBtnList[3].onmouseover = function() {
			moveElement('news_focus_turn_picList',-1200,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',3)
		}
	}
}

function indexfocusChange() {
	if(!hid('index_focus_turn')||!hid('index_focus_turn_btn')) return;
	var focusBtnList = hid('index_focus_turn_btn').getElementsByTagName('li');
	if(!focusBtnList||focusBtnList.length==0) return;
	var listLength = focusBtnList.length;
		focusBtnList[0].onmouseover = function() {
			moveElement('index_focus_turn_picList',0,0,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',0);
		}
	if (listLength>=2) {
		focusBtnList[1].onmouseover = function() {
			moveElement('index_focus_turn_picList',0,-227,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',1);
		}
	}
	if (listLength>=3) {
		focusBtnList[2].onmouseover = function() {
			moveElement('index_focus_turn_picList',0,-452,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',2);
		}
	}
	if (listLength>=4) {
		focusBtnList[3].onmouseover = function() {
			moveElement('index_focus_turn_picList',0,-679,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',3);
		}
	}
}

var newstimer;
function newsautoFocusChange() {
	if(!hid('news_focus_turn_btn')) return;
	var atuokey = false;
	hid('news_focus_turn').onmouseover = function(){atuokey = true};
	hid('news_focus_turn').onmouseout = function(){atuokey = false};
	var focusBtnList = hid('news_focus_turn_btn').getElementsByTagName('li');
	var listLength = focusBtnList.length;
	if(newstimer) {
		clearInterval(newstimer);
		timer = null;
	}
	newstimer= setInterval(function(){
		if(atuokey) return false;
		for(var i=0; i<focusBtnList.length; i++) {
			if (focusBtnList[i].className == 'current') var currentNum = i;
		}
		if (currentNum==0&&listLength!=1 ){
			moveElement('news_focus_turn_picList',-400,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',1)
		}else if (currentNum==1&&listLength!=2 ){
			moveElement('news_focus_turn_picList',-800,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',2)
		}else if (currentNum==2&&listLength!=3 ){
			moveElement('news_focus_turn_picList',-1200,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',3)
		}else {
			moveElement('news_focus_turn_picList',0,0,5);
			changeclass('news_focus_turn_btn','news_focus_turn_tx',0)
		}
	},5000);
}
var indextimer;
function indexautoFocusChange() {
	if(!hid('index_focus_turn')||!hid('index_focus_turn_btn')) return;
	var atuokey = false;
	hid('index_focus_turn').onmouseover = function(){atuokey = true};
	hid('index_focus_turn').onmouseout = function(){atuokey = false};
	var focusBtnList = hid('index_focus_turn_btn').getElementsByTagName('li');
	var listLength = focusBtnList.length;
	if(indextimer) {
		clearInterval(timer);
		indextimer = null;
	}
	indextimer= setInterval( function(){
		if(atuokey) return;
		for(var i=0; i<listLength; i++) {
			if (focusBtnList[i].className == 'current') var currentNum = i;
		}
		if (currentNum==0&&listLength!=1 ){
			moveElement('index_focus_turn_picList',0,-227,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',1);
		}else if (currentNum==1&&listLength!=2 ){
			moveElement('index_focus_turn_picList',0,-452,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',2);
		}else if (currentNum==2&&listLength!=3 ){
			moveElement('index_focus_turn_picList',0,-679,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',3);
		}else{
			moveElement('index_focus_turn_picList',0,0,5);
			changeclass('index_focus_turn_btn','index_focus_turn_tx',0);
		}
	},5000);
}

addLoadEvent(indexfocusChange);
addLoadEvent(indexautoFocusChange);
addLoadEvent(newsfocusChange);
addLoadEvent(newsautoFocusChange);
addLoadEvent(nav);

// 导航效果改进
function nav(){
	//var mainNav = hid('nav').getElementsByTagName('li');
	var currentNum = -1;
	//for(var i=0; i<mainNav.length; i++){
		//if (mainNav[i].className == 'current') var currentNum = i;

	//}
	if(currentNum == -1){
		//mainNav[0].getElementsByTagName('a')[0].style.background='none';
	}
	//if(mainNav[currentNum+1] != null) mainNav[currentNum+1].getElementsByTagName('a')[0].style.background='none';
	if(!currentNum==0){
		//mainNav[0].getElementsByTagName('a')[0].style.background='none';
	}	
}
// 幻灯片下方滑动门
function setDivNavigate11(num)
    { 
	    var obj = document.getElementById("u0_" + num)  ;
		var obj_m = document.getElementById("n01_" + num);
		document.getElementById('u0_0').style.display = "none";
 		document.getElementById('u0_1').style.display = "none";
		document.getElementById('u0_2').style.display = "none";
	    if(obj != null)
	    {
	        if(obj.style.display == "none")
	        {
	            obj.style.display = "block";
				obj_m.className='menuOn'; 
				for(var i=0;i<3; i++)
				{
					if ( num !=i )
					{
						document.getElementById("n01_" + i).className='menuOff'; 
					}
				}
				
 	        }
	    }
    }

