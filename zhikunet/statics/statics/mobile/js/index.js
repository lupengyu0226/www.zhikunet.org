document.domain = "05273.com";
	function getCookie(name) {  
		var nameEQ = name + "=";  
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {  
			 var c = ca[i];                      
			 while (c.charAt(0)==' ') {c = c.substring(1,c.length);}  
			 if (c.indexOf(nameEQ) == 0) {return unescape(c.substring(nameEQ.length,c.length));}  
		}  
		return false;  
	}
	function setCookie(name, value, seconds) {  
	 seconds = seconds || 0;  
	 var expires = "";  
	 if (seconds != 0 ) {
		 var date = new Date();  
		 date.setTime(date.getTime()+(seconds*1000));  
		 expires = "; expires="+date.toGMTString();  
	 }  
	 document.cookie = name+"="+escape(value)+expires+"; path=/";   
	}  
	function clearCookie(name) {setCookie(name, "", -1);}  
var www05273comIndex={
	iphoneTip:function(){
		if(/iPhone/i.test(navigator.userAgent)){
			if(getCookie("iphoneTips")!= undefined && getCookie("iphoneTips") == false){
				$(".footer").css("padding-bottom","65px");
				setTimeout(function(){
					$(".iphoneTips").show();
					$(".iphoneTips").html("<div class=\"bd\"><div class=\"img\"><\/div><div class=\"txt\">更快捷进入沭阳网，请点击<span><\/span>后选择“添加至主屏幕”。<\/div><div class=\"close\"><\/div><i><\/i><\/div>");
					$(".iphoneTips .close").bind("click",function(){
						setCookie("iphoneTips","ture",3600*12*30);
						$(".iphoneTips").hide();
						$(".footer").css("padding-bottom","0");
					});
				},500);
			}
		}
	},
	init:function() {
		/* 频道跳转 */
		$(".gochannel").each(function(i){
			$(this).bind("click",function(){
				var _than=$(this);
				$(this).addClass("boxon");
				setTimeout(function(){_than.removeClass("boxon");},500);
				setTimeout(function(){window.location.href=_than.attr("date-url");},500);
			});
		});
		
		$(".topBtn").bind("click",function(){
			setTimeout(function(){
				window.scroll(0,0)
			},500);
			
			
		});
		
		$(".qiehuan span").eq(1).bind("click",function(){
			setTimeout(function(){
				window.location.href="http://www.05273.com/?mobile"
			},500);
		});
		
		$(".backChannel").bind("click",function(){
			$(this).addClass("on");
			var _than=$(this)
			setTimeout(function(){
				_than.removeClass("on");
			},500);
			$(".blackBg").show();
			$(".backTip").show();
		});
		
		$(".backTip .btnQx").bind("click",function(){
			setTimeout(function(){
				$(".blackBg").hide();
				$(".backTip").hide();
			},500);
			
		});
		
		$(".backTip .btnTz").bind("click",function(){
			setTimeout(function(){
				window.location.href="http://www.05273.com/?mobile";
			},500);
		});
		
		
	}
	
}
www05273comIndex.init();
window.onload=function(){
	$("li").each(function(){
				$(this).bind("click",function(){
					if($(this).attr("date-url")){
						var _than=$(this);
						$(this).addClass("boxon");
						setTimeout(function(){_than.removeClass("boxon");},500);
						setTimeout(function(){window.location.href=_than.attr("date-url");},500);
					}
				});
	});
	www05273comIndex.iphoneTip();
	$(".topNews a").each(function(){
		$(this).bind("click",function(){
		})
	});
	$(".news  li").each(function(){
		$(this).bind("click",function(){
		})
	});
	
	$(".focus  li").each(function(){
		$(this).bind("click",function(){
		})
	});
	
	$(".finance li").each(function(){
		$(this).bind("click",function(){
		})
	});
	//  修复头条4个连接bug
	$(".topNews li").find("a").bind("click",function(event){
		event.preventDefault();
		window.location.href=this.href;
	});
	
	$(".qiehuan span").eq(0).bind("click",function(){
		window.location.href="http://www.05273.com/index.php?m=wap";
	});
	
	//  切换按钮点击态优化
	$(".backChannel").bind("click",function(){
		
	});
	$(".header-button").bind("click",function(){
		$(this).addClass("on");
		var _than=$(this)
		setTimeout(function(){
			_than.removeClass("on");
		},500);
	});
	
}