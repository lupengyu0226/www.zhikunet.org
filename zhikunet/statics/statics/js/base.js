/*
var allowCopy=false;
 if (window["allowCopy"] != null && window["allowCopy"] != undefined && !window["allowCopy"]) {
        document.oncontextmenu = function () { return false }; 
		document.onkeydown = function () { 
		if (event.ctrlKey|| window.event.keyCode == 67) {
			 return false 
			 } 
		}; 
		document.body.oncopy = function () { return false }; 
		document.onselectstart = function () { return false };
 }
*/ 
//複製網頁時產生原文連結(Tynt)==========================================

var Tynt=Tynt||[];Tynt.push('bGee2M3Q0r4iaCacwqm_6r');Tynt.i={"ap":"转载请注明出处与链接，原文网址:","st":true,"ss":"fpt"};
 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();


	
try{document.execCommand('BackgroundImageCache',false,true);}catch(e){}
var isIE=!-[1,];
var isGecko=(navigator.userAgent.indexOf("Gecko")>-1)&&(navigator.userAgent.indexOf("KHTML")==-1);

function $_(o){if(document.getElementById&&document.getElementById(o)){return document.getElementById(o);}else if (document.all&&document.all(o)){return document.all(o);}else if (document.layers&&document.layers[o]){return document.layers[o];}else{return false;}} 



function setCls(o,c,f){if(!o)return;var oc=o.className=o.className.replace(new RegExp('( ?|^)'+c+'\\b'),'');if(!f)o.className=oc.length>0?(oc+' '+c):c}
String.prototype.trim= function(){return this.replace(/(^\s*)|(\s*$_)/g,"");}
if(!Array.prototype.indexOf)Array.prototype.indexOf=function(item,i){i||(i=0);var l=this.length;if(i<0)i=l+i;for(;i<l;i++)if(this[i]===item)return i;return -1}
function isEmail(s){var p=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;return p.test(s)}
function isUrl(s){var p=new RegExp("((^http)|(^https)):\/\/(\\w)+\.(\\w)+");return p.test(s)}
function onEvent(A,B,C){B=B.replace(/^on/,'').toLowerCase();if(A.attachEvent){A[B+C]=function(){C.call(A,window.event)};A.attachEvent('on'+B,A[B+C])}else A.addEventListener(B,C,false);return A}
function unEvent(A,B,C){B=B.replace(/^on/,'').toLowerCase();if(A.attachEvent){A.detachEvent('on'+B,A[B+C]);A[B+C]=null}else A.removeEventListener(B,C,false);return A}
function show(){this.style.display='block'}
function hide(){this.style.display='none'}
function setVisibile(A,B){if(typeof A=='string')A=$_(A);if(A)A.style.display=B?'block':'none'}
function bytes(s){if(typeof(s)!="string"){s=s.value}var l=0;for(var i=0;i<s.length;i++){if(s.charCodeAt(i)>127){l++}l++}return l}
function preloadImage(){var args = preloadImage.arguments;if(!document.preloadImageArray)document.preloadImageArray=[];for(var i=0,len=args.length;i<args;i++){document.preloadImageArray.push(new Image());document.preloadImageArray[document.preloadImageArray.length].src=args[i]}}
function Extend(A,B){for(var C in B){A[C]=B[C]}return A}
function CurrentStyle(A){return A.currentStyle||document.defaultView.getComputedStyle(A,null)}
function Bind(A,B){var C=Array.prototype.slice.call(arguments).slice(2);return function(){return B.apply(A,C.concat(Array.prototype.slice.call(arguments)))}}
function forEach(A,B,C){if(A.forEach){A.forEach(B,C)}else{for(var i=0,len=A.length;i<len;i++)B.call(C,A[i],i,A)}}
var Tween={Quart:{easeOut:function(t,b,c,d){return-c*((t=t/d-1)*t*t*t-1)+b}},Back:{easeOut:function(t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b}},Bounce:{easeOut:function(t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b}}}}

function inittab(o,t,n,e,c){
	var tab = $_(o);
	if(tab.isinit) return ;
	tab.isinit = true;
	var ul = $_(o + '-body');
	if(!tab || !ul)return;
	var tabs = tab.getElementsByTagName(t||'li');
	if(!tabs || tabs.length == 0)return;
	tab = tabs[0].parentNode;
	tab.uls = [];
	if(n && n.indexOf('.') > 0){
		var t = n.split('.');
		var els = ul.getElementsByTagName(t[0]);
		for(var i=0,len=els.length;i<len;i++){
			if(els[i].className.split(' ').indexOf(t[1]) >= 0) tab.uls.push(els[i]);
		}
	}else{
		n = n || 'ul';
		for(var i=0,len=ul.childNodes.length;i<len;i++){
			if(ul.childNodes[i].tagName && ul.childNodes[i].tagName.toLowerCase() == n) tab.uls.push(ul.childNodes[i]);
		}
	}
	if(!tab.uls)return;
	var cls=c||'current';
	e = e ? e : 'onmouseover';
	tab.lis = tabs;
	for(var i=0;i<tabs.length;i++){
		tabs[i].i=i;
		if(i > 0 && tab.uls[i]) tab.uls[i].style.display = 'none';
		tabs[i][e] = function(){
			var u = this.parentNode;
			var idx = u.act ? u.act : 0;
			setCls(u.lis[idx], cls, true);
			if(u.uls[idx])u.uls[idx].style.display = 'none';
			u.act = this.i;
			setCls(this, cls);
			if(u.uls[this.i])u.uls[this.i].style.display = '';
		}
	}
}