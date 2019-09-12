if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/i.test(navigator.userAgent))){
	if(window.location.href.indexOf("?mobile")<0){
		try{
			if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
				window.location.href="http://wap.05273.com/";
			}else if(/iPad/i.test(navigator.userAgent)){
			}else{
				window.location.href="http://wap.05273.com/"
			}
		}catch(e){}
	}
}
(function($){
	$.fn.slide=function(options){
		$.fn.slide.deflunt={
		effect : "fade", //效果 || fade：渐显； || top：上滚动；|| left：左滚动；|| topLoop：上循环滚动；|| leftLoop：左循环滚动；|| topMarquee：上无缝循环滚动；|| leftMarquee：左无缝循环滚动；
		autoPlay:false, //自动运行
		delayTime : 500, //效果持续时间
		interTime : 2500,//自动运行间隔。当effect为无缝滚动的时候，相当于运行速度。
		defaultIndex : 0,//默认的当前位置索引。0是第一个
		titCell:".bds li",//导航元素
		mainCell:".bd",//内容元素的父层对象
		trigger: "mouseover",//触发方式 || mouseover：鼠标移过触发；|| click：鼠标点击触发；
		scroll:1,//每次滚动个数。
		vis:1,//visible，可视范围个数，当内容个数少于可视个数的时候，不执行效果。
		titOnClassName:"on",//当前位置自动增加的class名称
		autoPage:false,//系统自动分页，当为true时，titCell则为导航元素父层对象，同时系统会在titCell里面自动插入分页li元素(1.2版本新增)
		prevCell:".prev",//前一个按钮元素。
		nextCell:".next"//后一个按钮元素。
		};

		return this.each(function() {
			var opts = $.extend({},$.fn.slide.deflunt,options);
			var index=opts.defaultIndex;
			var prevBtn = $(opts.prevCell, $(this));
			var nextBtn = $(opts.nextCell, $(this));
			var navObj = $(opts.titCell, $(this));//导航子元素结合
			var navObjSize = navObj.size();
			var conBox = $(opts.mainCell , $(this));//内容元素父层对象
			var conBoxSize=conBox.children().size();
			var slideH=0;
			var slideW=0;
			var selfW=0;
			var selfH=0;
			var autoPlay = opts.autoPlay;
			var inter=null;//setInterval名称 
			var oldIndex = index;

			if(conBoxSize<opts.vis) return; //当内容个数少于可视个数，不执行效果。

			//处理分页
			if( navObjSize==0 )navObjSize=conBoxSize;
			if( opts.autoPage ){
				var tempS = conBoxSize-opts.vis;
				navObjSize=1+parseInt(tempS%opts.scroll!=0?(tempS/opts.scroll+1):(tempS/opts.scroll)); 
				navObj.html(""); 
				for( var i=0; i<navObjSize; i++ ){ navObj.append("<li>"+(i+1)+"</li>") }
				var navObj = $("li", navObj);//重置导航子元素对象
			}

			conBox.children().each(function(){ //取最大值
				if( $(this).width()>selfW ){ selfW=$(this).width(); slideW=$(this).outerWidth(true);  }
				if( $(this).height()>selfH ){ selfH=$(this).height(); slideH=$(this).outerHeight(true);  }
			});

			switch(opts.effect)
			{
				case "top": conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:'+opts.vis*slideH+'px"></div>').css( { "position":"relative","padding":"0","margin":"0"}).children().css( {"height":selfH} ); break;
				case "left": conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:'+opts.vis*slideW+'px"></div>').css( { "width":conBoxSize*slideW,"position":"relative","overflow":"hidden","padding":"0","margin":"0"}).children().css( {"float":"left","width":selfW} ); break;
				case "leftLoop":
				case "leftMarquee":
					conBox.children().clone().appendTo(conBox).clone().prependTo(conBox); 
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:'+opts.vis*slideW+'px"></div>').css( { "width":conBoxSize*slideW*3,"position":"relative","overflow":"hidden","padding":"0","margin":"0","left":-conBoxSize*slideW}).children().css( {"float":"left","width":selfW}  ); break;
				case "topLoop":
				case "topMarquee":
					conBox.children().clone().appendTo(conBox).clone().prependTo(conBox); 
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:'+opts.vis*slideH+'px"></div>').css( { "height":conBoxSize*slideH*3,"position":"relative","padding":"0","margin":"0","top":-conBoxSize*slideH}).children().css( {"height":selfH} ); break;
			}

			//效果函数
			var doPlay=function(){
				switch(opts.effect)
				{
					case "fade": case "top": case "left": if ( index >= navObjSize) { index = 0; } else if( index < 0) { index = navObjSize-1; } break;
					case "leftMarquee":case "topMarquee": if ( index>= 2) { index=1; } else if( index<0) { index = 0; } break;
					case "leftLoop": case "topLoop":
						var tempNum = index - oldIndex; 
						if( navObjSize>2 && tempNum==-(navObjSize-1) ) tempNum=1;
						if( navObjSize>2 && tempNum==(navObjSize-1) ) tempNum=-1;
						var scrollNum = Math.abs( tempNum*opts.scroll );
						if ( index >= navObjSize) { index = 0; } else if( index < 0) { index = navObjSize-1; }
					break;
				}
				switch (opts.effect)
				{
					case "fade":conBox.children().stop(true,true).eq(index).fadeIn(opts.delayTime).siblings().hide();break;
					case "top":conBox.stop(true,true).animate({"top":-index*opts.scroll*slideH},opts.delayTime);break;
					case "left":conBox.stop(true,true).animate({"left":-index*opts.scroll*slideW},opts.delayTime);break;
					case "leftLoop":
						if(tempNum<0 ){
								conBox.stop(true,true).animate({"left":-(conBoxSize-scrollNum )*slideW},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().last().prependTo(conBox); }
								conBox.css("left",-conBoxSize*slideW);
							});
						}
						else{
							conBox.stop(true,true).animate({"left":-( conBoxSize + scrollNum)*slideW},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().first().appendTo(conBox); }
								conBox.css("left",-conBoxSize*slideW);
							});
						}break;// leftLoop end

					case "topLoop":
						if(tempNum<0 ){
								conBox.stop(true,true).animate({"top":-(conBoxSize-scrollNum )*slideH},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().last().prependTo(conBox); }
								conBox.css("top",-conBoxSize*slideH);
							});
						}
						else{
							conBox.stop(true,true).animate({"top":-( conBoxSize + scrollNum)*slideH},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().first().appendTo(conBox); }
								conBox.css("top",-conBoxSize*slideH);
							});
						}break;//topLoop end

					case "leftMarquee":
						var tempLeft = conBox.css("left").replace("px",""); 

						if(index==0 ){
								conBox.animate({"left":++tempLeft},0,function(){
									if( conBox.css("left").replace("px","")>= 0){ for(var i=0;i<conBoxSize;i++){ conBox.children().last().prependTo(conBox); }conBox.css("left",-conBoxSize*slideW);}
								});
						}
						else{
								conBox.animate({"left":--tempLeft},0,function(){
									if(  conBox.css("left").replace("px","")<= -conBoxSize*slideW*2){ for(var i=0;i<conBoxSize;i++){ conBox.children().first().appendTo(conBox); }conBox.css("left",-conBoxSize*slideW);}
								});
						}break;// leftMarquee end

						case "topMarquee":
						var tempTop = conBox.css("top").replace("px",""); 
							if(index==0 ){
									conBox.animate({"top":++tempTop},0,function(){
										if( conBox.css("top").replace("px","") >= 0){ for(var i=0;i<conBoxSize;i++){ conBox.children().last().prependTo(conBox); }conBox.css("top",-conBoxSize*slideH);}
									});
							}
							else{
									conBox.animate({"top":--tempTop},0,function(){
										if( conBox.css("top").replace("px","")<= -conBoxSize*slideH*2){ for(var i=0;i<conBoxSize;i++){ conBox.children().first().appendTo(conBox); }conBox.css("top",-conBoxSize*slideH);}
									});
							}break;// topMarquee end


				}//switch end
					navObj.removeClass(opts.titOnClassName).eq(index).addClass(opts.titOnClassName);
					oldIndex=index;
			};
			//初始化执行
			doPlay();

			//自动播放
			if (autoPlay) {
					if( opts.effect=="leftMarquee" || opts.effect=="topMarquee"  ){
						index++; inter = setInterval(doPlay, opts.interTime);
						conBox.hover(function(){if(autoPlay){clearInterval(inter); }},function(){if(autoPlay){clearInterval(inter);inter = setInterval(doPlay, opts.interTime);}});
					}else{
						 inter=setInterval(function(){index++; doPlay() }, opts.interTime); 
						$(this).hover(function(){if(autoPlay){clearInterval(inter); }},function(){if(autoPlay){clearInterval(inter); inter=setInterval(function(){index++; doPlay() }, opts.interTime); }});
					}
			}

			//鼠标事件
			var mst;
			if(opts.trigger=="mouseover"){
				navObj.hover(function(){ clearTimeout(mst); index=navObj.index(this); mst = window.setTimeout(doPlay,200); }, function(){ if(!mst)clearTimeout(mst); });
			}else{ navObj.click(function(){index=navObj.index(this);  doPlay(); })  }
			nextBtn.click(function(){ index++; doPlay(); });
			prevBtn.click(function(){  index--; doPlay(); });

    	});//each End

	};//slide End

})(jQuery);

(function($){
$.fn.extend({
        Scroll:function(opt,callback){
                //参数初始化
                if(!opt) var opt={};
                var _this=this.eq(0).find("ul:first");
                var        lineH=_this.find("li:first").height(), //获取行高
                        line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度
                        speed=opt.speed?parseInt(opt.speed,10):3000, //卷动速度，数值越大，速度越慢（毫秒）
                        timer=opt.timer?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒）
                if(line==0) line=1;
                var upHeight=0-line*lineH;
                //滚动函数
                scrollUp=function(){
                        _this.animate({
                                marginTop:upHeight
                        },speed,function(){
                                for(i=1;i<=line;i++){
                                        _this.find("li:first").appendTo(_this);
                                }
                                _this.css({marginTop:0});
                        });
                }
                //鼠标事件绑定
                _this.hover(function(){
                        clearInterval(timerID);
                },function(){
                        timerID=setInterval("scrollUp()",timer);
                }).mouseout();
        }        
})
})(jQuery);
$(document).ready(function(){
        $("#scrollDiv").Scroll({line:1,speed:3000,timer:3000});
		$(".tabmenue .lefth2 h2:eq(1)").css("border-left","none");
		$(".tabmenue .lefth2 h2").hover(
								 function(){
								   $(this).addClass("select").siblings().removeClass("select");
								   var index = $(".tabmenue h2").index(this);
								   $("div.commonlist > div").eq(index).show().siblings().hide();
								 },
								 function(){
							       
								 }
			                 );			 				 
});

//Javascript Document

Box = {//登录积分提示

	show: function( m ){
		jQuery("#fcn_box_bg").remove();
		var str = '<div id="fcn_box_bg" style="position:absolute;top:0;left:0;width:100%;height:' + Math.max(document.documentElement.scrollHeight, window.screen.availHeight) + 'px;background-color:#000;opacity:0.6;filter(opacity=60);filter:alpha(opacity=60);z-index:9999;"></div>';
		jQuery(document.body).append(str);
		if(m && m!=""){ jQuery(document.body).append(m); }
	},
		close: function(t){
		if(arguments.length==0){
			return;
		}
		var bid = "";
		switch(t){
			case "login":
				bid = "#fcn_login";
			break;
			case "show_login":
				bid = "#login_frame";
			break;
		}
		jQuery("#fcn_box_bg, " + bid).remove();
	}
}

Cookie = {
	find: function(key){
		var cookArr = document.cookie.split(";"), item;
		for(var i=0,l=cookArr.length; i<l; i++){
			item = cookArr[i].split("=");
			if(item[0].trim() == key){
				return item[1].trim();
			}
		}
		return false;
	},
	set: function(k, v){
		if(arguments.length!=2){
			return;
		}
		if(k=="" || v==""){
			return;
		}
		var str = k + "=" + escape(v), d, f;
		d = new Date();
		f = (23 - d.getHours()) * 60 * 60 * 1000 + (59 - d.getMinutes()) * 60 * 1000 + (59 - d.getSeconds()) * 1000;
		d.setTime(d.getTime() + f);
		str += ";expires="+d.toGMTString();
		document.cookie = str;
	},
	del: function(k){}
}

jQuery(".valuation_con #black li.color3 a").click(function(e){
	if( Cookie.find("KKM__userid")===false ){
		show_login();
		return;
	}
	jQuery(".valuation_con .text_area_one").find("textarea").val("");
	jQuery(".valuation_con .text_area_one").show();
	var p = jQuery(this).parents("ul"), l = jQuery(this).parent().index(), _this = this;
	p.find("li").each(function(i, n){
		if( i == l ){
			jQuery(n).removeClass().addClass("color3_" + signs[i]);
		}else{
			jQuery(n).removeClass().addClass("color3 co" + (signs[i] + 1));
		}
	});
	jQuery(".text_area_one #name").val( jQuery(_this).attr("tid") );
});


jQuery(".valuation_con #white li a").click(function(e){
	if( Cookie.find("KKM__userid")===false ){
		show_login();
		return;
	}
	jQuery(".valuation_con .text_area_one").find("textarea").val("");
	jQuery(".valuation_con .text_area_one").show();
	var p = jQuery(this).parents("li"), l = jQuery(this).parent().index(), _this = this;
	p.siblings().removeClass();
	p.removeClass().addClass("color3_" + signs[l]);
	jQuery(".text_area_one #name").val( jQuery(_this).attr("tid") );
});


function reset(){
	if(jQuery("#page").length>0){
		jQuery("#page").width( document.documentElement.clientWidth ).height( document.documentElement.clientHeight );
	}
	if(jQuery("#single_full_one").length>0){
		jQuery("#single_full_one").width( jQuery("#single_full_one img").width() ).height( jQuery("#single_full_one img").height() );
	}
}

function show_login(){
	var str_code = "";//var str_code = get_code();
	if( jQuery("#login_frame").length > 0 ){
		jQuery("#login_frame, #fcn_box_bg").show();
	}else{
		var str = "", red;
		red = location.href.indexOf("#") > 0 ? location.href.replace("#", "") : location.href;
		str = '<div class="login_content" id="login_frame" style="position:absolute; top:' + ( ( document.documentElement.scrollTop || document.body.scrollTop) + 200 ) + 'px; left:50%; margin-left:-140px; display:block;z-index:9999;"><div class="login_f1"><span class="title1">登录沭阳网</span><a href="javascript:;" onclick="Box.close(\'show_login\')" class="click1"></a></div><form name="form" id="form" action="http://passport.05273.com/member-login.html" method="post"><div class="user_login"><span><input name="username" id="username" type="text" class="name3" value="请输入您的用户名" /></span><em>输入正确的邮箱/用户名</em><span><input type="password"  class="password" name="password" id="password"/></span><em>您的帐号和密码不匹配</em><ul class="rem_login"><li><input type="checkbox" checked class="check"><span>记住账户名</span></li><li><input type="checkbox"><span>自动登录</span></li></ul><ul class="item"><li class="login_f2"><input class="login_f3" name="dosubmit" id="dosubmit" value="登录" type="submit"/><a href="http://passport.05273.com/member-register.html" class="register_f2">注册帐号</a></li><li class="forget"><a href="http://passport.05273.com/member-public_forget_password.html">忘记密码了?</a></li></ul><ul class="login_list">合作账号登录：<a href="http://passport.05273.com/member-public_qq_loginnew.html" target="_blank"><img src="//statics.05273.cn/statics/images/login/qq_icon_16.png" /></a></ul></div><input type="hidden" name="referer" id="referer" value="'+red+'" /></form></div>';
		Box.show(str);
	}
}


jQuery(function(){

	jQuery("#footer #state1").html(decodeURIComponent(""));
	if(jQuery("a.top").length==0){
		jQuery(document.body).append('<a class="top" href="javascript:scroll(0,0);"></a>');
	}
	if(jQuery("a.awm").length==0){
		jQuery(document.body).append('<a class="awm" href="javascript:;"></a><div class="ewm_block"><img class="ewm_pic" alt="拿起你的微信扫一扫" src="//statics.05273.cn/statics/images/erweima/weixin290.jpg" height="290" width="290"><span class="add_fre">拿起你的微信扫一扫</span></div>');
	}
	if(jQuery("a.full_upload").length==0){
		if(Cookie.find("KKM__userid")){
			jQuery(document.body).append('<a class="full_upload" href="http://passport.05273.com/member-index.html" target="_blank"></a><div class="keke_dianji"><a href="javascript:;" class="keke_dianji1"></a></div>');
		}else{
			jQuery(document.body).append('<a class="full_upload" href="javascript:;" onclick="show_login()"></a><div class="keke_dianji"><a href="javascript:;" class="keke_dianji1"></a></div>');
		}
		jQuery("a.full_upload, .keke_dianji").mouseenter(function(e){ jQuery(".keke_dianji").show(); }).mouseleave(function(e){ jQuery(".keke_dianji").hide(); });
		jQuery("a.keke_dianji1").click(function(e){ jQuery(".keke_dianji").hide(); });
	}

	jQuery("a.awm").hover(function(){
		jQuery(".ewm_block").show();
	},function(){
		jQuery(".ewm_block").hide();
	});
	
	jQuery(".ewm_block").mouseover(function(){
		jQuery(this).show();
	}).mouseout(function(){
		jQuery(this).hide();
	});

	jQuery(".user_login #username").live("focus", function(e){
	jQuery(this).removeClass().addClass("name1");
	jQuery(this).val().trim() == "请输入您的用户名" ? jQuery(this).val("") : null;
}).live("blur", function(e){
	jQuery(this).removeClass().addClass("name3");
	jQuery(this).val().trim() == "" ? jQuery(this).val("请输入您的用户名") : null;
});
	
});
window.onresize=function(){	reset(); }
