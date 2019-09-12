/**
 * By wpzheng@tencent.com
 * date 2014.5.20
 * v  1.0
 * 听新闻
 */
/*
 * AddMore-第一次加载 IfHave-是否还有数据 ism-设定列表ID 
 * currentSrcIndex-新闻索引值 currentSrc-新闻地址 
 * currentSrc-新闻标题 firstTime-新闻时间 channelName-新闻名称
 * changeclass()-进度条闪烁状态 
 * playList()-点击下一条播放
 * formatTime-格式化时间
 **/
var txw = {	
	AddMore : 1 ,
	IfHave: 0 ,
	myAudio : $('audio')[0] ,
	currentSrcIndex : 0 ,
	currentSrc : '' ,
	currentText : '' ,
	firstTime : '' ,
	channelName : '' ,
	setTimeout : '' ,
	ism : 0 ,
	startnum: 0 ,
	gundxishu : 1 ,
	todo : function(){
		txw.playList();
	},
	autoplay : function(){
		txw.myAudio.play();
		if(txw.AddMore){txw.setdoTime();txw.AddMore = 0;}
	},
	setdoTime : function(){
		var userAgentInfo = navigator.userAgent;  
    var Agents = new Array("iPhone", "iPad", "iPod");  
    var flag = false;
		var v=0
		for ( v = 0; v < Agents.length; v++) 
		{  
	    if (userAgentInfo.indexOf(Agents[v]) >= 0) 
	    { 
	    	flag = true;
	    	break; 
	    }  
	  }  
		if(!flag){
			$('.txwPlay').attr('id','go');
		}else{
			// if(txw.AddMore == 1){$(".txwPlay").attr('id','');}
			$(".txwPlay").attr('id','');
		}
	},
	cutstring: function(str) {
		if (str.length > 27) {
      _new = str.substr(0, 26) + "...";
    } else {
      _new = str;
    };
    return _new;
	},
	gethrefid : function() {
		var _href = window.location.href.indexOf('id=');
		if(_href > 0){
			return window.location.href.split('id=')[1];
		}else{
			return 0 ;
		}
	},
	changebacbg : function() {
		var _num = Math.floor(Math.random()*3);
		switch(_num)
		{
			case 0 :
			$('#inner').css('background-position','0 0');
			break;
			case 1 :
			$('#inner').css('background-position','0 -135px');
			break;
			case 2 :
			$('#inner').css('background-position','0 -269px');
			break;
			case 3 :
			$('#inner').css('background-position','0 -402px');
			break;
			default:
			break;
		}
	},
	changeclass : function() {
		var _this = $('.Playbar a'); 
		var a = _this.attr('class');
		if(a == 'slider')
		{
			_this.removeClass('slider');
		}else{
			_this.addClass('slider');
		}
	},
	getWqlist : function(num){
		//数据加载
		if(txw.AddMore == 1){ txw.startnum = txw.gethrefid();}
		window.txwlist=function(data){
	    var newlist = data.data;
	    var _len = data.data.length;
	    if(_len < 10){_len = _len;txw.IfHave = 1;}else{_len = 10;}
	    var f_num = 0; 
    	var _news = '' ;
	    var tmp = '' ;
	    for (var i = 0 ; i < _len; i++,txw.ism++) {
	    	if(newlist[i].id == txw.startnum){f_num = i}
		    if (newlist[i].name.length > 18) {
		      _news = newlist[i].name.substr(0, 17) + "...";
		    } else {
		      _news = newlist[i].name;
		    };
		    tmp += '<li id="list'+txw.ism+'" data-name="'+newlist[i].name+'" data-src="http://qingting.u.qiniudn.com'+newlist[i].mediainfo.transcode.http+'"><p>'+_news+'</p><div><span class="txwChannel">新闻</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txwTime">'+txw.formatTime(newlist[i].duration)+'</span></div><i></i></li>';
	    }
	    $(".txwlist ul").append(tmp);
	    $('.txwlist .more').html('<a href="javascript:void(0)"><span class="gochannel">点击查看更多</span></a>');
	    if(txw.IfHave){$('.txwlist .more').hide();}
	    $('.loads').hide();
	    //加载第一屏和预备第一条新闻
	    if(txw.AddMore == 1){
		    _index = $('.wrap .txwlist ul li').eq(f_num);
				txw.currentSrc = 'http://qingting.u.qiniudn.com'+newlist[f_num].mediainfo.transcode.http;
				txw.currentText = newlist[f_num].name;
				txw.firstTime = txw.formatTime(newlist[f_num].duration);
				_index.addClass('off');
				txw.myAudio.src = txw.currentSrc;
				txw.channelName = '新闻';
				// $(".txwPlay").attr('id','go');
				$('#inner .totalTime').text(txw.firstTime);
				$('#inner .currentName').text(txw.channelName);
				$("#inner .intro").text(txw.cutstring(txw.currentText));
				$("#inner .intro").attr('data-id','list0');
				txw.autoplay();
			}

			//新闻列表点击
			$('.txwlist ul li').each(function(index,obj){
				$(this).click(function(){
					txw.changebacbg();
					txw.currentSrcIndex = index;
					var curClass = $(this).attr('class');
					if(curClass !== 'off')
					{
						$(this).addClass('off').siblings().removeClass('off');
					}
					txw.currentText = $(this).find('p').text();
					var on_src = $(this).attr("data-src");
					var _thisId = $(this).attr('id');
					txw.myAudio.src = on_src;
					$(".txwPlay").attr('id','go');
					$("#inner .intro").text(txw.cutstring(txw.currentText));
					$("#inner .intro").attr('data-id',_thisId);
					// $(this).find('i').addClass('start');
					txw.setTimeout = window.setInterval(txw.changeclass,2000);
					txw.autoplay();
				})
			})
			//监听是否结束
			txw.myAudio.addEventListener('ended',function(){
				$(".Playbar .progressPlay").css("width","0%");
				$(".Playbar a").css("left","0%");	
				$('.txwPlay').attr('id','');
				$('.txwlist ul').find('li.off i').removeClass('start');
				$('#inner .totalTime').html('0:0');
				window.clearInterval(txw.setTimeout);
				if(txw.myAudio.paused){
					txw.todo();
				}
				$(".txwPlay").attr('id','go');
			})
	  }
	  $.getScript("http://qq.api.qingting.fm/api/qq/qtradiov4/programs?curpage="+num+"&id=70220&pagesize=10&jsoncallback=txwlist&deviceid=df");
	},
	playList:function(){
		var sourceList = $('.txwlist ul li');
		txw.changebacbg();
		++txw.currentSrcIndex > sourceList.length - 1 && (txw.currentSrcIndex = 0);
		var _index = $(".wrap .txwlist ul li").eq(txw.currentSrcIndex);
		txw.currentSrc = _index.attr("data-src");
		txw.currentText = _index.find('p').text();
		txw.myAudio.src = txw.currentSrc;
		_index.addClass('off').siblings().removeClass('off');
		$(".txwPlay").attr('id','go');
		$("#inner .intro").text(txw.cutstring(txw.currentText));
		$("#inner .intro").attr('data-id',_index.attr('id'));
		txw.setTimeout = window.setInterval(txw.changeclass,2000);
		txw.myAudio.play();
	},
	formatTime:function(time){
		var minutes = parseInt(time/60);
		var seconds = parseInt(time%60);
		seconds<10 && (seconds = "0" + seconds);
		return minutes + ":" + seconds;			
	}
}
$(function(){
	//统计点击量
    if(typeof pgvMain == "function") {
    	// _href = window.location.href.split('?')[0];
    	pvCurDomain = location.hostname;
			pvCurUrl = location.pathname;
      pgvMain();
    }
	//解决加载时出现满屏的纯色进度条
	$(".Playbar .progressPlay").css("width","0%");
	$(".Playbar a").css("left","0%");
	$(".Playbar .progressPlay").css("background-color","#42e7ff");
	var n = 1;
	txw.getWqlist(n);

	//向上移动定位
	$(window).scroll(function () {
		var scrtop = document.body.scrollTop;
		if(scrtop > 35 && txw.gundxishu == 1){
			txw.gundxishu = 0;
			$('#inner').css({'top' : -90});
			$('#inner').css({'position' : 'fixed'});
			$("#inner").animate({
				"top" : '-35px',
				"opacity" : .95
			},1000);
			$('#inner').css({'opacity' : .95});
		}else if(scrtop <= 35 && txw.gundxishu == 0){
			$('#inner').css({'top' : -5});
			$('#inner').css({'position' : 'relative'});
			$("#inner").animate({
				"top" : "0",
				"opacity" : 1,
			},800);
			txw.gundxishu = 1;
		}
	})

	//点击播放按钮
	$(".txwPlay").click(function(){
		if (txw.myAudio.paused) {
			txw.autoplay();
			$(this).attr('id','go');
			txw.setTimeout = window.setInterval(txw.changeclass,2000);
		} else {
			$(this).attr('id','');
			$('.txwlist ul').find('li.off i').removeClass('start');
			txw.myAudio.pause();
		}
	});
	
	//点击播放下一条如果是最后一条循环播放
	$(".nextPlay").click(function(){
		txw.playList();
	});

	//WindowsPhone点击BUG
	$('#inner').click(function(){
		window.event.returnvalue = false; 
	})

	//时间和进度条的计算
	$(txw.myAudio).bind("timeupdate",function(){
		var duration = this.duration;
		var curTime = this.currentTime;
		if(curTime != '0' && $('.txwPlay').attr('id') == 'go'){$('.txwlist ul').find('li.off i').addClass('start');}
		if(isNaN(duration) || isNaN(duration)){
		}else{
			var shengyutime = txw.formatTime(duration*1-curTime*1);
			if(shengyutime != '0:00' && shengyutime != '100:00' && shengyutime != '0:0-13'){
			$('#inner .totalTime').text(shengyutime);	
			var percentage = curTime/duration * 100;
			$(".Playbar a").css("left",percentage + "%");	
			$(".Playbar .progressPlay").css("width",percentage + "%");
			}
		}				
	});

	//定位新闻
	$('#inner .intro').click(function(){
		var t_id = $(this).attr('data-id');
		var t_val = $('#inner').offset().top;
		if(t_val == 30){$(document).scrollTop($('#'+t_id).offset().top - 231);}else{
			$(document).scrollTop($('#'+t_id).offset().top - 98);
		}
	})
	$(".gotop").click(function() {
	    window.scroll(0, 0);
	  
	});
	//点击加载更多
	$('.txwlist .more').click(function(){
		$(this).html('<p>正在加载...</p>');
		txw.AddMore = 0;
		n = n+1;
		txw.getWqlist(n);
	})
	// 顶部导航统计代码
	$(".channels li").each(function(i) {
	  $(this).bind("click", function() {
	  })
	});
	$(".footnav li").each(function(i) {
	  $(this).bind("click", function() {
	  })
	});

	//公共头顶部跳转
	$('.global_mobi_header h1 a').attr('rel', 'external').attr('target', '_blank');
	$('#global_mobi_channels ul li').each(function(index,obj){
		$(this).find('a').attr('rel','external').attr('target','_blank');
	})
	$('.global_mobi_footnav ul li').each(function(index,obj){
		$(this).find('a').attr('rel','external').attr('target','_blank');
	})
});/*  |xGv00|0403b253e2bd881e4be8b392125e3dcc */