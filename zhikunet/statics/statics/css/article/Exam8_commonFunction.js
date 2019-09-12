//滑动门
function setTab(name,cursel,n,currentClass,otherClass){
	for(i=1;i<=n;i++){
		var menu=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		menu.className=i==cursel? currentClass:otherClass;
		con.style.display=i==cursel?"block":"none";
	}
}

//滑动门不同样式
function setTabDifferentCss(name,cursel,n,currentClass,parentClass){
	for(i=1;i<=n;i++){
		var menu=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		//if(menu.className==currentClass){
			menu.className=document.getElementById(name+i).lang;
			con.style.display="none";
		//}
	}
	document.getElementById(name+cursel).className=currentClass;
	document.getElementById("con_"+name+"_"+cursel).style.display="";
	if(parentClass!=null && parentClass!=""){
		document.getElementById("parent_"+name).className=parentClass;
	}
}

//复制页面地址
function copy(ob){
	var obj=findObj(ob);
	if (obj){
		obj.select();
		js=obj.createTextRange();
		js.execCommand("Copy");
		alert("复制成功，您可以粘贴（Ctrl+V）到QQ或MSN上推荐给好友了。")
	}
}

function findObj(n, d) { 
  document.getElementById('txtUrl').value= document.location.href;
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

//内容页评论
function Check(){
  if (document.form1.Name.value==''){
    alert('请输入昵称！');
	document.form1.Name.focus();
	return false;
  }
  if (document.form1.Content.value==''){
    alert('请输入评论内容！');
	document.form1.Content.focus();
	return false;
  }
  return true;  
}

//栏目首页滚动
function Marquee()
{
	this.ID = document.getElementById(arguments[0]);
	if(!this.ID)
	{
		alert("您要设置的\"" + arguments[0] + "\"初始化错误\r\n请检查标签ID设置是否正确!");
		this.ID = -1;
		return;
	}
	this.Direction = this.Width = this.Height = this.DelayTime = this.WaitTime = this.CTL = this.StartID = this.Stop = this.MouseOver = 0;
	this.Step = 1;
	this.Timer = 30;
	this.DirectionArray = {"top":0 , "up":0 , "bottom":1 , "down":1 , "left":2 , "right":3};
	if(typeof arguments[1] == "number" || typeof arguments[1] == "string")this.Direction = arguments[1];
	if(typeof arguments[2] == "number")this.Step = arguments[2];
	if(typeof arguments[3] == "number")this.Width = arguments[3];
	if(typeof arguments[4] == "number")this.Height = arguments[4];
	if(typeof arguments[5] == "number")this.Timer = arguments[5];
	if(typeof arguments[6] == "number")this.DelayTime = arguments[6];
	if(typeof arguments[7] == "number")this.WaitTime = arguments[7];
	if(typeof arguments[8] == "number")this.ScrollStep = arguments[8];
	this.ID.style.overflow = this.ID.style.overflowX = this.ID.style.overflowY = "hidden";
	this.ID.noWrap = true;
	this.IsNotOpera = (navigator.userAgent.toLowerCase().indexOf("opera") == -1);
	if(arguments.length >= 7)this.Start();
}

Marquee.prototype.Start = function()
{
	if(this.ID == -1)return;
	if(this.WaitTime < 800)this.WaitTime = 800;
	if(this.Timer < 20)this.Timer = 20;
	if(this.Width == 0)this.Width = parseInt(this.ID.style.width);
	if(this.Height == 0)this.Height = parseInt(this.ID.style.height);
	if(typeof this.Direction == "string")this.Direction = this.DirectionArray[this.Direction.toString().toLowerCase()];
	this.HalfWidth = Math.round(this.Width / 2);
	this.HalfHeight = Math.round(this.Height / 2);
	this.BakStep = this.Step;
	this.ID.style.width = this.Width + "px";
	this.ID.style.height = this.Height + "px";
	if(typeof this.ScrollStep != "number")this.ScrollStep = this.Direction > 1 ? this.Width : this.Height;
	var templateLeft = "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;display:inline;'><tr><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td></tr></table>";
	var templateTop = "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;'><tr><td>MSCLASS_TEMP_HTML</td></tr><tr><td>MSCLASS_TEMP_HTML</td></tr></table>";
	var msobj = this;
	msobj.tempHTML = msobj.ID.innerHTML;
	if(msobj.Direction <= 1)
	{
		msobj.ID.innerHTML = templateTop.replace(/MSCLASS_TEMP_HTML/g,msobj.ID.innerHTML);
	}
	else
	{
		if(msobj.ScrollStep == 0 && msobj.DelayTime == 0)
		{
			msobj.ID.innerHTML += msobj.ID.innerHTML;
		}
		else
		{
			msobj.ID.innerHTML = templateLeft.replace(/MSCLASS_TEMP_HTML/g,msobj.ID.innerHTML);
		}
	}
	var timer = this.Timer;
	var delaytime = this.DelayTime;
	var waittime = this.WaitTime;
	msobj.StartID = function(){msobj.Scroll()}
	msobj.Continue = function()
				{
					if(msobj.MouseOver == 1)
					{
						setTimeout(msobj.Continue,delaytime);
					}
					else
					{	clearInterval(msobj.TimerID);
						msobj.CTL = msobj.Stop = 0;
						msobj.TimerID = setInterval(msobj.StartID,timer);
					}
				}

	msobj.Pause = function()
			{
				msobj.Stop = 1;
				clearInterval(msobj.TimerID);
				setTimeout(msobj.Continue,delaytime);
			}

	msobj.Begin = function()
		{
			msobj.ClientScroll = msobj.Direction > 1 ? msobj.ID.scrollWidth / 2 : msobj.ID.scrollHeight / 2;
			if((msobj.Direction <= 1 && msobj.ClientScroll <= msobj.Height + msobj.Step) || (msobj.Direction > 1 && msobj.ClientScroll <= msobj.Width + msobj.Step))			{
				msobj.ID.innerHTML = msobj.tempHTML;
				delete(msobj.tempHTML);
				return;
			}
			delete(msobj.tempHTML);
			msobj.TimerID = setInterval(msobj.StartID,timer);
			if(msobj.ScrollStep < 0)return;
			msobj.ID.onmousemove = function(event)
						{
							if(msobj.ScrollStep == 0 && msobj.Direction > 1)
							{
								var event = event || window.event;
								if(window.event)
								{
									if(msobj.IsNotOpera)
									{
										msobj.EventLeft = event.srcElement.id == msobj.ID.id ? event.offsetX - msobj.ID.scrollLeft : event.srcElement.offsetLeft - msobj.ID.scrollLeft + event.offsetX;
									}
									else
									{
										msobj.ScrollStep = null;
										return;
									}
								}
								else
								{
									msobj.EventLeft = event.layerX - msobj.ID.scrollLeft;
								}
								msobj.Direction = msobj.EventLeft > msobj.HalfWidth ? 3 : 2;
								msobj.AbsCenter = Math.abs(msobj.HalfWidth - msobj.EventLeft);
								msobj.Step = Math.round(msobj.AbsCenter * (msobj.BakStep*2) / msobj.HalfWidth);
							}
						}
			msobj.ID.onmouseover = function()
						{
							if(msobj.ScrollStep == 0)return;
							msobj.MouseOver = 1;
							clearInterval(msobj.TimerID);
						}
			msobj.ID.onmouseout = function()
						{
							if(msobj.ScrollStep == 0)
							{
								if(msobj.Step == 0)msobj.Step = 1;
								return;
							}
							msobj.MouseOver = 0;
							if(msobj.Stop == 0)
							{
								clearInterval(msobj.TimerID);
								msobj.TimerID = setInterval(msobj.StartID,timer);
							}
						}
		}
	setTimeout(msobj.Begin,waittime);
}

Marquee.prototype.Scroll = function()
{
	switch(this.Direction)
	{
		case 0:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollTop += this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollTop >= this.ClientScroll)
				{
					this.ID.scrollTop -= this.ClientScroll;
				}
				this.ID.scrollTop += this.Step;
			}
		break;

		case 1:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollTop -= this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollTop <= 0)
				{
					this.ID.scrollTop += this.ClientScroll;
				}
				this.ID.scrollTop -= this.Step;
			}
		break;

		case 2:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollLeft += this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollLeft >= this.ClientScroll)
				{
					this.ID.scrollLeft -= this.ClientScroll;
				}
				this.ID.scrollLeft += this.Step;
			}
		break;

		case 3:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollLeft -= this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollLeft <= 0)
				{
					this.ID.scrollLeft += this.ClientScroll;
				}
				this.ID.scrollLeft -= this.Step;
			}
		break;
	}
}


//网校学员登录判断
function check(){
	if(logform.username.value==""){
		alert ("用户名不能为空！");
		return false;
	}
	if(logform.psw.value==""){
		alert ("密码不能为空！");
		return false;
	}
	if(logform.rnd.value==""){
		alert ("验证码不能为空！");
		return false;
	}
}

//加入收藏
function addBookmark(title) {
                     var url=parent.location.href;
                     if (window.sidebar) { 
                            window.sidebar.addPanel(title, url,""); 
                     } else if( document.all ) {
                     window.external.AddFavorite( url, title);
                     } else if( window.opera && window.print ) {
                     return true;
                     }
       }
function SetHome(obj,vrl){
        try{
                obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
        }
        catch(e){
                if(window.netscape) {
                        try {
                                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
                        }  
                        catch (e) 
 { 
                                alert("抱歉！您的浏览器不支持直接设为首页。请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为“true”，点击“加入收藏”后忽略安全提示，即可设置成功。");  
                        }
                        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                        prefs.setCharPref('browser.startup.homepage',vrl);
                 }
        }
}

//新老学员登录切换
function ChangeLogin(id){
		if(id==0){
			document.logform.action = "http://www.exam8.com/User/User_ChkLogin.asp";
			document.logform.psw.style.display = "none";
			document.logform.UserPassword.style.display = "block";
		}
		else{
			document.logform.action = "http://kc.exam8.com/user_center/index.asp";
			document.logform.psw.style.display = "block";
			document.logform.UserPassword.style.display = "none";
		}
	}
	
//内容页右侧老师切换
t_u = null;
	t_u_old = null;
	maxPic = 4;
	showPic = 0;

	function switchPic(curPic){ 
		if(curPic == maxPic){ 
			showPic = 1;
		}else{ 
			showPic = showPic + 1;
		}
		for(i=1; i <= maxPic; i++){ 
			if(i == showPic){ 
				document.getElementById("picA"+i).className = "currON";
				document.getElementById("picUL"+i).style.display = "";
			}else{ 
				document.getElementById("picA"+i).className = "";
				document.getElementById("picUL"+i).style.display = "none";
			}
		}
	}
	function reSwitchPic() { 
		clearTimeout(t_u);
		switchPic(showPic);
		t_u = setTimeout('reSwitchPic();', 5000);
	}
	function pauseSwitch() { 
		clearTimeout(t_u);
		t_u_old = t_u;
	}
	function selectSwitch(num) { 
		showPic = num;
		for(i=1; i <= maxPic; i++){ 
			if(i == num){ 
				document.getElementById("picA"+i).className = "currON";
				document.getElementById("picUL"+i).style.display = "";
			}else{ 
				document.getElementById("picA"+i).className = "";
				document.getElementById("picUL"+i).style.display = "none";
			}
		}
	}
	function goonSwitch() {
		clearTimeout(t_u);
		t_u = setTimeout('reSwitchPic();', 5000);
	}
	
	
	//图画校园
	var myART=new Object();
myART.Browser={ie:/msie/.test(window.navigator.userAgent.toLowerCase()),moz:/gecko/.test(window.navigator.userAgent.toLowerCase()),opera:/opera/.test(window.navigator.userAgent.toLowerCase()),safari:/safari/.test(window.navigator.userAgent.toLowerCase())};
var myArticl=new Object();
var ZT,liNum=4,liWidth=144,stepTime=3*1000,stepSpeed=100,step=50;
myArticl={
	$:function(v){return document.getElementById(v)},
	getEles:function(id,ele){return this.$(id).getElementsByTagName(ele);},
	tabId:"sildPicBar",tabDot:"dot",tabBox:"cnt-wrap",tabSilder:"cnt",tabSilderSon:"li",rightBorder:"silidBarBorder",
	Count:function(){return this.getEles(this.tabSilder,this.tabSilderSon).length},
	Now:0,isCmt:true,isSild:true,timer:null,site:'news',cmtId:'21572303',cmtBase:'comment5',AuToPlay:true,
	sideTab:{heads:'tabTit',heads_ele:'span',bodys:'tabBody',bodys_ele:'ol'},
	SildTab:function(now){
		this.Now=Number(now);
		if(this.Now>Math.ceil(this.Count()/liNum)-1){
			this.Now=0;
		}
		else if(this.Now<0){
			this.Now=Math.ceil(this.Count()/liNum)-1;
		}
		if(parseInt(this.$(this.tabSilder).style.left)>-liWidth*parseInt(this.Now*liNum)){
			this.moveR();
		}
		else{
			this.moveL();
		}
		for(var i=0;i<Math.ceil(this.Count()/liNum);i++){
			if(i==this.Now){
				this.getEles(this.tabId,"li")[this.Now].className="select";
			}
			else{
				this.getEles(this.tabId,"li")[i].className="";
			}
		}
	},
	moveR:function(setp){
		var _curLeft=parseInt(this.$(this.tabSilder).style.left);
		var _distance=stepSpeed;
		if(_curLeft>-liWidth*parseInt(this.Now*liNum)){
			clearTimeout(ZT);
			this.$(this.tabSilder).style.left=(_curLeft-_distance)+step+"px";
			window.setTimeout("myArticl.moveR('next')",1);
		}
		else if(_curLeft=-liWidth*parseInt(this.Now*liNum)){
		    if(myArticl.AuToPlay){ZT = setTimeout("myArticl.pagePe('next')",stepTime);}
		}
		else{
			if(myArticl.AuToPlay){ZT = setTimeout("myArticl.pagePe('pre')",stepTime);}
		}
	},
	moveL:function(setp){
		var _curLeft=parseInt(this.$(this.tabSilder).style.left);
		var _distance=stepSpeed;
		if(_curLeft<-liWidth*parseInt(this.Now*liNum)){
			this.$(this.tabSilder).style.left=(_curLeft+_distance)-step+"px";
			clearTimeout(ZT);
			window.setTimeout("myArticl.moveL('pre')",1);
		}
		else if(_curLeft=-liWidth*parseInt(this.Now*liNum)){
			if(myArticl.AuToPlay){ZT = setTimeout("myArticl.pagePe('pre')",stepTime);}
		}
		else{
			if(myArticl.AuToPlay){ZT = setTimeout("myArticl.pagePe('next')",stepTime);}
		}
	},
	pagePe:function(way){
		if(way=="next"){
			this.Now+=1;
			this.SildTab(this.Now);
		}
		else{
			this.Now-=1;
			this.SildTab(this.Now);
		}
	},
	smallCk:function(){
		for(var i=0;i<Math.ceil(this.Count()/liNum);i++){
			if(i==0){
				this.$(this.tabDot).innerHTML+="<li class='select' onclick='myArticl.SildTab("+i+")'></li>";
			}
			else{
				this.$(this.tabDot).innerHTML+="<li onclick='myArticl.SildTab("+i+")'></li>";
			}
		}
	},
	onload:function(){
		if(myART.Browser.moz){
			document.addEventListener("DOMContentLoaded",function(){myArticl.ints()},null);
		}
		else{
			if(document.readyState=="complete"){
				myArticl.ints();
			}
			else{
				document.onreadystatechange=function(){
					if(document.readyState=="complete"){
						myArticl.ints();
					}
				}
			}
		}
	},
	ints:function(){
		if(this.isSild){
			this.$(this.tabBox).style.position="relative";
			this.$(this.tabBox).onmouseover=function(){clearTimeout(ZT)};
			this.$(this.tabBox).onmouseout=function(){ZT = setTimeout("myArticl.pagePe('next')",stepTime)};
			this.$(this.tabSilder).style.position="absolute";
			this.$(this.tabSilder).style.left=0+"px";
			this.getEles(this.tabId,"span")[1].onclick=function(){myArticl.pagePe("next");}
			this.getEles(this.tabId,"span")[0].onclick=function(){myArticl.pagePe("pre");}
			this.smallCk();
			if(myArticl.AuToPlay){window.onload = function(){ZT = setTimeout("myArticl.pagePe('next')",stepTime)};}
		}
	}
}		