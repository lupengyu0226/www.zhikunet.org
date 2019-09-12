$(function(){
    //ICO列表滚动
    var ullength=$(".app-top .app-list").length;
    var ulheight=$(".app-top .app-list").height();
    var i=0;
    $(".arrow01 a.down").click(function(){
        meshowpic()
    })
    $(".arrow01 a.up").click(function(){
        if(i>0){
            i--;
            $(".app-top-in").animate({"top":-ulheight*i+"px"},600);
        }
        else{
            i=ullength-1;
            $(".app-top-in").animate({"top":-ulheight*i+"px"},600);
        }
    })

    $(".app-top").hover(function(){
        clearInterval(pictime);

    },function(){
        pictime=setInterval(meshowpic,6000)

    }).trigger("mouseleave")
    function meshowpic(){
        if( (i+1) < ullength){
            i++;
            $(".app-top-in").animate({"top":-ulheight*i+"px"},600);
        }else{
            $(".app-top-in").animate({"top":"0px"},600);
            i=0;
        }
    }
})

// JavaScript Document
$(document).ready(function() {
    (function($){
        $.fn.slider=function(arg){
            var me = $(this),opt = $.extend({inteval:5000,auto:true,loop:false,prev:me.find(".prev"),next:me.find(".next"),pageBtns:"",finish:function(){},start:function(){}}, arg),pageBtns,scrollable = me.find(".scrollable"),ori_items = me.find(".items"),total_num = me.find(".item").length,cur_page = 0,mov_w = me.find(".item").outerWidth(),move_left=0,interval;
            var startIndex = total_num;
            var navDot = me.find('.nav-dot');
            var dotList = $('a', navDot);

            opt.start();
            if (opt.loop) {
                ori_items.append(ori_items.find(".item").clone());
                ori_items.prepend(ori_items.find(".item").clone());
                scrollable.scrollLeft(getCurScroLeft());
            }
            opt.prev.length&&opt.prev.bind("click",move).hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover")});
            opt.next.length&&opt.next.bind("click",move).hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover")});
            function moveTo(e){
                pageBtns.unbind("click",moveTo);
                var cur_li=$(e.target).closest("li"),num=cur_li.index();
                pageBtns.removeClass("select");cur_li.addClass("select");
                var cur_scrollLeft=num*mov_w;
                scrollable.animate({scrollLeft:cur_scrollLeft},{duration:'normal',easing:'swing',complete:function(){pageBtns.bind("click",moveTo);opt.finish(num)},queue:false});
            }
            function move(e){
                opt.prev.length&&opt.prev.unbind("click",move);
                opt.next.length&&opt.next.unbind("click",move);
                if(e){
                    clearInterval(interval);
                    var cur_btn=$(e.target);
                    if(cur_btn.hasClass("prev")){
                        move_left=1;
                        --startIndex < 0 ? Math.abs(startIndex) : '';
                    };
                    if(cur_btn.hasClass("next")){
                        move_left=0;
                        ++startIndex < 0 ? Math.abs(startIndex) : '';
                    };
                }
                var cur_scrollLeft=move_left ? getCurScroLeft()-mov_w:getCurScroLeft()+mov_w;
                scrollable.stop().animate({scrollLeft:cur_scrollLeft},{duration:'normal',easing:'swing',complete:complate,queue:false});
            }
            function complate(){
                cur_page=move_left?cur_page-1:cur_page+1;
                if(cur_page<= -total_num+2){cur_page+=total_num;resetscroll()}
                if(cur_page>=2*total_num-2){cur_page-=total_num;resetscroll()}
                opt.prev.length&&opt.prev.bind("click",move);
                opt.next.length&&opt.next.bind("click",move);
                opt.finish();
                var currentDotIndex = startIndex % total_num;
                navDot.find('.current-dot').removeClass();
                dotList.eq(currentDotIndex).addClass('current-dot');
            }
            function resetscroll(){
                scrollable.scrollLeft(getCurScroLeft());
            }
            function getCurScroLeft(){
                return opt.loop?total_num * mov_w+cur_page*mov_w:cur_page*mov_w;
            }
        }
    })(jQuery);
    $("#banner-slide").slider({
        interval:5000,
        loop:true,
        auto:true
    });
});

$(function(){ //设置自动滚动
    setInterval(function(){
        $('.slide-pics .next').click();
    },5000);
});


/* focus flash */
var flash_i = 0;
var c = setInterval('goIndexFlash()',5000);
function goIndexFlash(){
    if(flash_i >= 4)
    {
        flash_i=0;
    } else {
        flash_i++;
    }
    setIndexFlash(flash_i);
}
function setIndexFlash(j){
    $("#eye_img").animate({
        left: -(j*360)
    }, 500 );
    $('.eye_pag li').removeClass('current').eq(j).addClass('current');
    $('.eye_tit a').eq(j).show().siblings('a').hide();
}
//big img
$('.eye_lbtn').click(function(){
    clearInterval(c);
    if(!$('#eye_img').is(":animated")){

        if (flash_i <= 0) {
            flash_i = 4
        } else {
            flash_i--;
        }
        setIndexFlash(flash_i);
    }
    c = setInterval('goIndexFlash()',5000);
});
$('.eye_rbtn').click(function(){
    clearInterval(c);
    if(!$('#eye_img').is(":animated")){

        if (flash_i >= 4) {
            flash_i = 0
        } else {
            flash_i++;
        }
        setIndexFlash(flash_i);
    }
    c = setInterval('goIndexFlash()',5000);
});
//pag
$('.eye_pag li').click(function(){
    var index = $(this).index();
    flash_i = index;
    $('.eye_pag li').removeClass('current').eq(index).addClass('current');
    clearInterval(c);
    if(!$('#eye_img').is(":animated")){
        setIndexFlash(flash_i);
    }
    c = setInterval('goIndexFlash()',5000);
});

$("#ivtab .tab-bar a").each(function(index){
    $(this).mouseover(function(){
        var liNode = $(this);
        timoutid = setTimeout(function(){
            $("#ivtab .tab-con").removeClass("tab-on");
            $("#ivtab .tab-bar .cur").removeClass("cur");
            $("#ivtab .tab-con:eq(" + index + ")").addClass("tab-on");
            liNode.addClass("cur");
        },100);
    }).mouseout(function(){
        clearTimeout(timoutid);
    });
});
$('.refresh').click(function(){	
    var str=$('.wbody .wlist:lt(1)').clone();		
    $('.wbody .wlist:lt(1)').remove();
    $('.wbody').append(str);
});

$(".links_click .r_bottom").click(function(){		
        i=1;
        var ah=32;
        var c=parseInt(parseInt($("#links_box").height())+32)/ah-4;
        var t=parseInt(-ah*i)+'px';		
        if(i<c){
            $("#links_box").stop(true).animate({top:t},300);
            i++;
        }else{return}
    }
);
$(".links_click .r_top").click(function(){
    var ah=32;
    var c=parseInt($("#links_box").height())/ah-4;
    var t=parseInt(-ah*i+ah*2)+'px';
        if(i>1){
            $("#links_box").stop(true).animate({top:t},300);
            i--;
        }else{return}
    }
);

