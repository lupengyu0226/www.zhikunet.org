/*
 *	Shuyang Sgallery With jQuery
 *	made by edi 2009-12-15
 *	作者：edi  2009-12-15
 * http://www.zhoutao.org/
 */
(function($){$.fn.sGallery=function(o){return new $sG(this,o);};var settings={thumbObj:null,titleObj:null,botLast:null,botNext:null,thumbNowClass:'now',slideTime:800,autoChange:true,changeTime:5000,delayTime:100};$.sGalleryLong=function(e,o){this.options=$.extend({},settings,o||{});var _self=$(e);var set=this.options;var thumb;var size=_self.size();var nowIndex=0;var index;var startRun;var delayRun;_self.eq(0).show();function fadeAB(){if(nowIndex!=index){if(set.thumbObj!=null){$(set.thumbObj).removeClass().eq(index).addClass(set.thumbNowClass);}
_self.eq(nowIndex).stop(false,true).fadeOut(set.slideTime);_self.eq(index).stop(true,true).fadeIn(set.slideTime);$(set.titleObj).eq(nowIndex).hide();$(set.titleObj).eq(index).show();nowIndex=index;if(set.autoChange==true){clearInterval(startRun);startRun=setInterval(runNext,set.changeTime);}}}
function runNext(){index=(nowIndex+1)%size;fadeAB();}
if(set.thumbObj!=null){thumb=$(set.thumbObj);thumb.eq(0).addClass(set.thumbNowClass);thumb.bind("mousemove",function(event){index=thumb.index($(this));fadeAB();delayRun=setTimeout(fadeAB,set.delayTime);clearTimeout(delayRun);event.stopPropagation();})}
if(set.botNext!=null){var botNext=$(set.botNext);botNext.mousemove(function(){runNext();return false;});}
if(set.botLast!=null){var botLast=$(set.botLast);botLast.mousemove(function(){index=(nowIndex+size-1)%size;fadeAB();return false;});}
if(set.autoChange==true){startRun=setInterval(runNext,set.changeTime);}}
var $sG=$.sGalleryLong;})(jQuery);function slide(Name,Class,Width,Height,fun){$(Name).width(Width);$(Name).height(Height);if(fun==true){$(Name).append('<div class="title-bg"></div><div class="title"></div><div class="change"></div>')
var atr=$(Name+' div.changeDiv a');var sum=atr.length;for(i=1;i<=sum;i++){var title=atr.eq(i-1).attr("title");var href=atr.eq(i-1).attr("href");$(Name+' .change').append('<i>'+i+'</i>');$(Name+' .title').append('<a href="'+href+'">'+title+'</a>');}
$(Name+' .change i').eq(0).addClass('cur');}
$(Name+' div.changeDiv a').sGallery({titleObj:Name+' div.title a',thumbObj:Name+' .change i',thumbNowClass:Class});$(Name+" .title-bg").width(Width);}
jQuery.fn.LoadImage=function(scaling,width,height,loadpic){if(loadpic==null)loadpic="//statics.05273.cn/statics/images/msg_img/loading.gif";return this.each(function(){var t=$(this);var src=$(this).attr("src")
var img=new Image();img.src=src;var autoScaling=function(){}
if(img.complete){autoScaling();return;}
$(this).attr("src","");var loading=$("<img alt=\"加载中...\" title=\"图片加载中...\" src=\""+loadpic+"\" />");t.hide();t.after(loading);$(img).load(function(){autoScaling();loading.remove();t.attr("src",this.src);t.show();});});}
function startmarquee(elementID,h,n,speed,delay){var t=null;var box='#'+elementID;$(box).hover(function(){clearInterval(t);},function(){t=setInterval(start,delay);}).trigger('mouseout');function start(){$(box).children('ul:first').animate({marginTop:'-='+h},speed,function(){$(this).css({marginTop:'0'}).find('li').slice(0,n).appendTo(this);})}}
function SwapTab(name,title,content,Sub,cur){$(name+' '+title).mouseover(function(){$(this).addClass(cur).siblings().removeClass(cur);$(content+" > "+Sub).eq($(name+' '+title).index(this)).show().siblings().hide();});}