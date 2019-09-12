﻿/*不要乱动，edi留*/
var iTemplate = (function(){
	var template = function(){};
	template.prototype = {
		makeList: function(tpl, json, fn){
			var res = [], $10 = [], reg = /{(.+?)}/g, json2 = {}, index = 0;
			for(var el in json){
				if(typeof fn === "function"){
					json2 = fn.call(this, el, json[el], index++)||{};
				}
				res.push(
					 tpl.replace(reg, function($1, $2){
					 	return ($2 in json2)? json2[$2]: (undefined === json[el][$2]? json[el]:json[el][$2]);
					})
				);
			}
			return res.join('');
		}
	}
	return new template();
})();
var num = Math.round((Math.random(3)+ 1)*20);
var snows = new Array(num);
snows = snows.join(",").split(",");
var Tpl = '<div style="top: {top}; left: {left}; -webkit-animation: fade {t1} {t2}, drop {t1} {t2};_display:none">\
			<img src="{url}" style="-webkit-animation: counterclockwiseSpinAndFlip {t5};width:{width}; max-width:{maxHeight};">\
			</div>';
var snowsHTML = iTemplate.makeList(Tpl, snows, function(k,v){
	var obj = {
		top: "-100px",
		left: Math.random()*100 +"%",
		t1:Math.random()*(11-5)+5 +"s",
		t2:Math.random()*4 +"s",
		//t3:Math.random()*(11-5)+5 +"s",
		//t4:Math.random()*4 +"s",
		t5:Math.random()*(11-5)+5 +"s",
		url: urls[0],
		width: Math.round(Math.random()*(60-30)+30) + "px",
		maxHeight:"60px"
	}
	return obj;
});
document.write(snowsHTML);