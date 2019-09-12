function getStyle(obj,attr){
	return obj.currentStyle?obj.currentStyle[attr]:getComputedStyle(obj,false)[attr];	
}
function tanMove(obj,value){
	var left = obj.offsetLeft;
	var speed = 0;
	clearInterval(obj.timer);
	obj.timer = setInterval(function(){
		speed+=(value-left)/5;
		speed*=0.7;
		left+=speed;
		obj.style.left=Math.round(left)+'px';
		if(Math.round(left)==value && Math.abs(speed)<1){
			clearInterval(obj.timer);	
		}	
	},30)	
}
function move(obj,json,options){
	var options = options||{};
	options.type = options.type||'ease-out';
	options.time = options.time||700;
	
	var start = {};
	var dis = {};
	
	for(var attr in json){
		if(attr=='opacity'){
			start[attr] = parseFloat(getStyle(obj,attr));	
		}else{
			start[attr] = parseInt(getStyle(obj,attr));
		}
		dis[attr] = json[attr] - start[attr];	
	}
	
	var count = Math.round(options.time/30);
	var n = 0;
	
	clearInterval(obj.timer);
	obj.timer = setInterval(function(){
		n++;
		for(var attr in json){
			switch(options.type){
				case 'linear':
					var cur = start[attr]+dis[attr]*n/count;
					break;
				case 'ease-in':
					var a = n/count;
					var cur = start[attr]+dis[attr]*a*a*a;
					break;
				case 'ease-out':
					var a = 1-n/count;
					var cur = start[attr]+dis[attr]*(1-a*a*a); 
					break;	
			}	
			
			if(attr=='opacity'){
				obj.style.opacity = cur;
				//obj.style.filter = 'alpha(opacity:'+cur*100+')'
			}else{
				obj.style[attr] = cur+'px';
			}
			
			if(n==count){
				clearInterval(obj.timer);
				options.fn && options.fn();	
			}
		}	
	},30)
}
function rnd(n,m){
	return parseInt(Math.random()*(m-n+1))+n;	
}
function addEvent(obj,sEv,fn){
	if(obj.addEventListener){
		obj.addEventListener(sEv,fn,false);	
	}else{
		obj.attachEvent('on'+sEv,fn);
	}	
}