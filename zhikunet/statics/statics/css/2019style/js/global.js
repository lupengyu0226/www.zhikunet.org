// JavaScript Document

$(function(){
    $(".sech_keyword").css("color", '#C0C0C0');
    $(".sech_keyword").val("wps office");
    $('.sech_keyword').focus(function(){
        if($(".sech_keyword").val()=='wps office'){
            $(".sech_keyword").val('');
        }
    })

    //导航划过样式
    $('.top_phone').hover(
        function(){$(this).addClass('top_phone_hover');},
        function(){$(this).removeClass('top_phone_hover');}
    );
    //
    $('.zdyz-list li,.sf-list li,.qt-version,.cysoft li,.pc-zhuanti .con li').hover(
        function(){$(this).addClass('hover');},
        function(){$(this).removeClass('hover');}
    );
    // 列表
    $(".c-news li").hover(function(){
        $(this).find(".c-item").addClass("bg");
        $(this).find(".a-link").animate({height:50},200);
    },function(){
        $(this).find(".c-item").removeClass("bg");
        $(this).find(".a-link").animate({height:0},200);
    });
    $("#links a").live('click', function(event) {
        $("#links a").removeClass('current');
        $(this).addClass('current');
        var local=$(this).html();
        local=$("#"+local);
        $('html, body').animate({ scrollTop:local.offset().top-65+"px"}, 500);
    });

    //执行兼容placeholder代码
    //JPlaceHolder.init();
});
// 二级导航菜单
function isNeeded(selectors){
    var selectors = (typeof selectors == 'string') ? [selectors] : selectors,
        isNeeded;
    for(var i=0;i<selectors.length;i++){
        var selector = selectors[i];
        if( $(selector).length > 0 ) {
            isNeeded = true;
            break;
        }
    };
    return isNeeded ;
};
$(function(){
    // 二级菜单
    if(isNeeded('#j_main_nav')){
        var navTimer;
        var hideNav = function(){
            if(navTimer) clearTimeout(navTimer);
            navTimer = setTimeout(function(){
                $('.sub-nav').hide();
            }, 200);
        }
        $('#j_main_nav').find('li').each(function(){
            $(this).bind('mouseover',function(){
                if(navTimer) clearTimeout(navTimer);
                var rel = $(this).attr('rel');
                $('.sub-nav').hide();
                $('.j-sub-nav-'+rel).show();
            });
            $(this).bind('mouseleave', hideNav);

            $('.sub-nav').bind('mouseover',function(){
                if(navTimer) clearTimeout(navTimer);
            });
            $('.sub-nav').bind('mouseleave', hideNav);
        });
    }
});

//ivtab


//选项卡切换
function onSelect(obj,ch)
{
    var parentNodeObj= obj.parentNode;
    var s=0;
    for(i=0;i<parentNodeObj.childNodes.length;i++)
    {
        // alert("第" +i +"次")
        if (parentNodeObj.childNodes[i].nodeName=="#text")
        {
            continue;
        }
        parentNodeObj.childNodes[i].className="tab_1";
        var newObj=document.getElementById(ch + "_" + s);

        if(newObj!=null)
        {

            newObj.style.display='none';
            if(parentNodeObj.childNodes[i]==obj)
            {
                newObj.style.display='';
            }
        };

        var new1Obj=document.getElementById(ch+"_more_" + s);
        if(new1Obj!=null)
        {
            new1Obj.style.display='none';
            if(parentNodeObj.childNodes[i]==obj)
            {
                new1Obj.style.display='';
            }
        }
        s +=1;
    }
    obj.className="tab_2";
}

//简单返回顶部


$(document).ready(function(){
    $(".head-user input").click(function(){
        $(".user_name").css("color","#a7a7a7");
        $(".head-user input").blur(function(){
            $(".user_name").css("color","#666");
        });
    });

    //手机   

   



})
$(document).ready(function(){
    $(".complain-form .form-txt textarea,.post-wrap-w .textarea-fw").click(function(){
        $(this).css("color","#333");
    });
})

//preview softimg



//热门切换
$.fn.lazyLoadImg = function(setting){}
/*切换*/
var cTab=function(opt){
    //settings
    var settings=jQuery.extend(true,{
        tabHandleList:"#tabHnadle > li",//标签头
        tabBodyList:"#tabBody > li",//标签内容体序列
        //isAutoPlay:{time:3000},//是否自动播放
        isAutoPlay:false,
        bind:"mouseover",//标签绑定事件
        defIndex:0,//默认选中标签下标tabHnadle
        //tabOnCssList:"#tabHnadle > li",//标签on样式添加点
        tabOnCssName:"on"//选中标签样式
    },opt);
    var isAutoPlay=settings.isAutoPlay,
        bind=settings.bind,
        defIndex=settings.defIndex,
        $tabHandleList=$(settings.tabHandleList),
        tabOnCssName=settings.tabOnCssName,
        $tabOnCssList=$(settings.tabHandleList),
        $tabBodyList=$(settings.tabBodyList);
    var maxSize=$tabHandleList.size();
    var gotoIndex=function(i){
        if(i>=maxSize){i=0;}else if(i<0){i=maxSize-1;}
        $tabOnCssList.eq(defIndex).removeClass(tabOnCssName);
        $tabOnCssList.eq(i).addClass(tabOnCssName);
        $tabBodyList.eq(defIndex).hide();
        $tabBodyList.eq(i).show().find("img").lazyLoadImg();
        defIndex=i;
        return false;
    };
    gotoIndex(defIndex);
    $tabHandleList.each(function(i){
        $(this).bind(bind,function(){gotoIndex(i);});
    });
    //auto
    var timerID;
    var autoPlay=function(){
        timerID=window.setInterval(function(){
            var temp=defIndex+1;
            gotoIndex(temp);
        },isAutoPlay.time);
    };
    var autoStop=function(){
        window.clearInterval(timerID);
    };
    if(isAutoPlay){
        autoPlay();
        $tabHandleList.hover(autoStop,autoPlay);
        $tabBodyList.hover(autoStop,autoPlay);
    }
    //return
    return {gotoIndex:gotoIndex,defIndex:defIndex};
};
$(document).ready(function(){
    cTab({tabHandleList:"#tabHnadle5 > li",tabBodyList:"#tabBody5 > ul"});
});

//收藏本站
function AddFavorite(sTitle, sURL) {
    var sURL = window.location.href, sTitle = document.title;
    try {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
};






