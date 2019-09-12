$(function()
{	
	//顶部菜单导航鼠标滑过效果
    $('.navList li, .editShare li').hover(function()
    {
        var listTwo =  $(this).children().hasClass('two');
        if( listTwo == true)
        {
            $(this).toggleClass('hover');
        };
    });

    //tabSlideBar tab选项卡
    $('.tabSlideBar').each(function()
    {
        var _this = $(this);
        $(this).find('.titleMain .txt').hover(function()
        {
            var _t = $(this);
            var slide = _this.find('.tabState');//获取滑块
            var width = slide.width();//获取滑块宽度
            var curNub = $(this).parent().find('.cur').index();//当前显示所引值
            var indexNub = $(this).index();//鼠标滑过的所引值
            trigger = setTimeout(function()
            {
                if(indexNub > curNub)
                {
                    _t.addClass('cur').siblings().removeClass('cur');
                    _this.find('.newsRankBar').children().eq(indexNub).addClass('current').siblings().removeClass('current');
                    slide.animate({'left':'+=' + (indexNub-curNub)*width },400);   
                } 
                else if( indexNub < curNub)
                {
                    _t.addClass('cur').siblings().removeClass('cur');
                    _this.find('.newsRankBar').children().eq(indexNub).addClass('current').siblings().removeClass('current');
                    slide.animate({'left':'-=' + -(indexNub-curNub)*width },400);   
                }    
            },400);
        },
        function()
        {
            clearTimeout(trigger);    
        }); 
    });

    //listsTabBar 选项卡
   $('.listsTabBar').each(function()
   {
        var _this = $(this);
        _this.find('.listsTabNav li').hover(function()
        {
            var indexNub = $(this).index();
            $(this).addClass('current').siblings().removeClass('current');
            _this.find('.newsListBox').children().eq(indexNub).addClass('current').siblings().removeClass('current');     
        });
   });   

   //newsBarLayout滑块效果
   $('.newsBarLayout').each(function()
   {
        var _t = $(this);
        _t.find('.numberState span').hover(function()
        {
            var _this = $(this);
            var slide = _t.find('.imgListLayout .imgList');//获取滑块标签
            var width = slide.parent().width()-12;//获取滑块宽度
            var len = Math.ceil(slide.children('li').length/4);
            var current = _this.parent().find('.current').html();
            var cur = _this.html();
            sTiggle = setTimeout(function()
            {
                if( cur > current)
                {
                    _this.addClass('current').siblings().removeClass('current');
                    slide.animate({'left':'-=' + (cur-current)*width},400);
                }
                else if(cur < current)
                {
                    _this.addClass('current').siblings().removeClass('current');
                    slide.animate({'left':'+=' + -(cur-current)*width},400);
                }

            },300);
        },
        function()
        {
            clearTimeout(sTiggle);    
        });
   });

    //baseHover背景变色
    $('.baseHover').hover(function()
    {
        $(this).toggleClass('lightBlueBg');
    });

    //aloneTabBar 选项卡
    $('.aTabLayout').each(function()
    {
        var t = $(this);
        // hideLi();
        var navMenu = t.find('.aTabNav');
        var last = t.parent().parent().next('.mainLayout');
        var offset = navMenu.offset();
        var lastOffset = last.offset();
        var menuTop = offset.top;
        var lastTop;
        t.find('.aTabNav .twoMenu').hover(function()
        {
            $(this).find('.m').show();
        },
        function()
        {
            $(this).find('.m').hide();   
        });
        t.find('.aTabNav>li> a').click(function()
        {
            var tLen = $(this).parent().index();
			var curUl = $(this).parent().parent().siblings('.aTabMain').children('ul').eq(tLen);
			//curUl.html(curUl.next('textarea').val());
			if(tLen == 0){
			}else{	
				curUl.html($('.areaval').eq(tLen - 1).val());
			}
			
            $(this).parent().addClass('current').siblings().removeClass('current').parent().siblings('.aTabMain').children('ul').eq(tLen).show().siblings().hide();
            t.find('.aTabMain').children('ul').eq(tLen).addClass('aTabActive').siblings().removeClass('aTabActive');
            $('html,body').animate({scrollTop: menuTop}, 400);
             lastTop = (lastOffset.top)-52;//52为,加载更多32px加上布局间距20px
			 $('.loadingMore').children('a').text('点击加载更多');
        });
        t.find('.aTabNav>li>.m>a').click(function(e)
        {
			//e.stopPropagation();
            var tLen = $(this).parent().parent().index();
            var mLen = $(this).index();
			var curUl = $(this).parent().parent().parent().siblings('.aTabMain').children('ul').eq(tLen+mLen);
			curUl.addClass('aTabActive').siblings().removeClass('aTabActive');
			//curUl.html(curUl.next('textarea').val());
			curUl.html($('.areaval').eq(tLen + mLen - 1).val());
			$('html,body').animate({scrollTop: menuTop}, 400);
            $(this).addClass('current').siblings().removeClass('current').parent().parent().addClass('current').siblings().removeClass('current').parent().siblings('.aTabMain').children('ul').eq(tLen+mLen).show().siblings().hide(); 
			$('.loadingMore').children('a').text('点击加载更多');
        });
        if(!t.find('.aTabActive').children('ul').hasClass('showList') == true)
        {
            lastTop = (lastOffset.top)-52;//52为,加载更多32px加上布局间距20px
        }
        else
        {
            var sl = 15; //默认显示数目
            var sh = t.find('.aTabMain li').height()+41; //单个列表默认高度(41为上下边距跟border)
            var len = t.find('.aTabMain').children('.aTabActive').children('li').length;
            lastTop = ((lastOffset.top)-(len-sl)*sh)-32;
        }
        var rightBoxH = t.parent().siblings('.tabRight').height();//右侧容器高度
        $(window).scroll(function()
        {
            var wThis = $(this).scrollTop();
            if(wThis>menuTop && wThis<lastTop)
            {
                navMenu.css({'position':'fixed','top':0}); 
                if(wThis-menuTop<lastTop-menuTop-rightBoxH )
                {
                    var _top = wThis-menuTop;
                    t.parent().siblings('.tabRight').css({'position':'absolute','bottom':'auto','right':0,'top':_top});
                }
                else if(wThis-menuTop>=lastTop-menuTop-rightBoxH)
                {
                    t.parent().siblings('.tabRight').css({'bottom':0,'top':'auto'});
                }
            }
            else
            {
                navMenu.css({'position':'relative'});
                if(wThis>lastTop)
                {
                    t.parent().siblings('.tabRight').css({'bottom':0,'top':'auto'});        
                }
                else
                {
                    t.parent().siblings('.tabRight').css({'top':0});    
                }  
            }
        }); 
        function hideLi()
        {
            t.find('.aTabMain').children('.imgTxtBar').each(function()
            {
                $(this).children('li').each(function()
                {
                    var list = 15;
                    if(!$(this).parent().hasClass('showList') == true)
                    {
                        if($(this).index()>=list)
                        {
                            $(this).hide();
                        }  
                    }
                    else
                    {
                        if($(this).index()>=list)
                        {
                            $(this).show();
                        }     
                    }  
                });
            });
        };
        
        $('.loadingMore').each(function()
        {
            $(this).click(function()
            {
                var idx = $('.imgTxtBar').index($('ul.aTabActive'));
				
                $('.aTabMain').children('ul').eq(idx).toggleClass('showList');
				
                hideLi();
                var rightBarTop = $(window).scrollTop()-menuTop;
                var nextOffset = last.offset();
                var nextTop = nextOffset.top;
                lastTop = nextTop-52; //52为,加载更多32px加上布局间距20px
                var aTxt = $(this).find('a');
                t.parent().siblings('.tabRight').css({'position':'absolute','bottom':0,'right':0,'_top':0});
				$(window).trigger('scroll');
                if(aTxt.text() == '点击加载更多')
                {
                    aTxt.text('点击隐藏更多');
                }
                else
                {
                    aTxt.text('点击加载更多');    
                }
            });
        });    
    });
    
    //窗口滚动
    $(window).scroll(function()
    {   
        var _this = $(this);
        var h = $(window).height();
        var top = _this.scrollTop();
        //返回顶部显隐
        function returnTop()
        {
            if(top>=h)
            {
                $('div.returnTop').fadeIn(600);    
            }
            else
            {
                $('div.returnTop').fadeOut(600);  
            }
        };
        returnTop();
    });
    //返回顶部滑块
    $('div.returnTop .topIcon').click(function()
    {
        $('html,body').animate({scrollTop: 0}, 400);
         return false;
    });
    

});