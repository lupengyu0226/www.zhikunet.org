$(function(){if("undefined"!=typeof c_kuaixun){var x_kx_obj=c_kuaixun[0];if(x_kx_obj.t!==""&&x_kx_obj.u.indexOf(".htm")>0&&pd_kxtitle(x_kx_obj)==1){var t_a=x_kx_obj.st;var x_kx='<a target="_blank" href="'+c_url(x_kx_obj.u)+'">'+x_kx_obj.t+'</a>';var tit_kx='<span class="tit">'+t_a+'</span>';$("#kx_text").html(x_kx);$("#kx_text").parent().prepend(tit_kx);setTimeout(function(){$(".kx").slideDown(500);},3000);setTimeout(function(){if($(".kx").is(":visible")==true){$(".kx").slideUp(500);}},20000);}};function pd_kxtitle(kx_obj){var a=0;var b=["快讯","回放","论坛","直播","预告","美图","大事"];var c=kx_obj.st;for(var i=0;i<b.length;i++){if(c==b[i]){a=1;break}}
return a;}
function c_url(a){return a;}
$(".kx .close").click(function(){$(".kx").slideUp(500);return false;});(function(){Hr=function(){if(key.length<57){throw new Error('the key is too short.');}
for(var _i=0;_i<41;++_i){this._k41[_i]=_hexCHS.charAt(key[_i+16]);this._t41[this._k41[_i]]=_i;}};Hr.prototype.ca=function(s){var _k16=this._k16,_k41=this._k41,_ks=this._ks,_sz=this._sz,_cnt=0;return s.replace(/[^\s\n\r]/g,function(ch){var _n=ch.charCodeAt(0);return(_n<=0xff)?_k16[parseInt(_n/16)]+_k16[_n%16]:_k41[parseInt(_n/1681)]+_k41[parseInt(_n%1681/41)]+_k41[_n%41]}).replace(/[0-9A-Za-z]/g,function(ch){return _hexCHS.charAt((_hexTBL[ch]+_ks[_cnt++%_sz])%62);});};})();});