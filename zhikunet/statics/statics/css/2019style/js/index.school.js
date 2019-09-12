/*
 * IDP首页
 * mr.sheak@gmail.com 20141124
 */
;$(function(){
//$('.otherBrand li').eq(2).css("display","none");

/*************************************************/
	clearTxt($('#headSearchBox'), '美国TOP60');
    // 搜索框
    $("#idp_search").hover(function(){
        $(this).stop(false , false).animate({"width" : "270px"} , 200);
    }, function(){
        $(this).stop(false , false).animate({"width" : "42px"} , 200);
		$(this).children().first().blur();	
    });


    // 轮播通用
    var idpSlide = function(ele){
        $(ele).find(".slide_nav li").hover(function(){
            var _index = $(this).index();
            $(this).addClass("cur").siblings().removeClass("cur");

            $(this).closest(ele).find(".slide_img  li").eq(_index).addClass("cur").siblings().removeClass("cur");
        });
    }

    // 主体tab切换
    $(".sub_tabs li , .sub_hd_tabs li").hover(function(){
        var _index = $(this).index();
        $(this).addClass("cur").siblings().removeClass("cur");

        $(this).closest(".idp_main_item").find(".sub_tabs_item").eq(_index).addClass("cur").siblings().removeClass("cur");
    });

    // 首页轮播
    idpSlide("#idp_index_slide");

    // 留学资讯快递轮播
    idpSlide("#idp_lxzx_slide");

    // 主体模块轮播
    idpSlide(".mid_slide");

    // 品牌故事轮播
    idpSlide("#idp_story");

    // 返回顶部
    $(".back2top").click(function(){
        $('body,html').animate({scrollTop:0},200); 
    });

	//讲座面试
		var cw=$(".mians_xl > ul >li").width();
	var j=$(".mians_xl > ul >li").index();
	$(".diquaCont > div:not(':first')").hide();
	$(".mians_xl > ul >li").hover(function(){
		$(this).addClass("active").siblings().removeClass("active");
		w=$(".mians_xl > ul >li").width();
		j=$(this).index();
		$(this).parent().siblings("span").stop().animate({left:j*w},300);
		
		$(this).closest(".mians_xl").siblings(".diquaCont").children("div").eq(j).show().siblings().hide();
		
		});	
	
	//讲座面试select
    $(".mians_xl ul li").hover(function(){$(this).toggleClass("sex");});
    $('.mians_xl input').click(function(){
        if($(this).hasClass('sex')){
            $(this).removeClass('sex').siblings('ul').hide();
        }else{
            $(this).addClass('sex').siblings('ul').slideDown(300);
        }
        
        $(this).siblings('ul').each(function(){

            $(this).children('li').click(function(){
                var temps= $(this).text();
                $(this).parent('ul').hide().siblings('input').val(temps);
                $(this).parent('ul').siblings('input').removeClass('sex');
            })
        })
    })
	$(".mians_xl").click(function(event){
        if(event.stopPropagation)
        event.stopPropagation();
        else if(window.event)
        window.event.cancelBubble = true;       
    })
    $(document).click(function(event) {
        $('.mians_xlList').hide();
        $('.mians_xl input').removeClass('sex')
    });

    // 模拟下拉菜单
    var divselect = function(divselectid) {
        var inputselect = $(divselectid).find(".inputselect");

        $(divselectid+" div").click(function(event){
            event.stopPropagation();

            var ulAll = $(divselectid+"> ul"),
                ul = $(this).closest(divselectid).find("ul");

            if(ul.css("display")=="none"){
                ulAll.hide();
                $(".divselect").css("zIndex" , "1");
                $(this).closest(".divselect").css("zIndex" , "1986");
                ul.slideDown("fast");
            }else{
                ul.slideUp("fast");
            }
        });

        $(divselectid+"> ul li a").click(function(){
            var txt = $(this).text(),
                _divSelect = $(this).closest(divselectid).find("div"),
                _divUl = $(this).closest(divselectid).find("ul"),
                _inputselect = $(this).closest(divselectid).find(".inputselect");

            _divSelect.html(txt);
            var value = $(this).attr("selectid");
            _inputselect.val(value);
            _divUl.hide();
        });

        $(document).click(function(){
            $(divselectid+" ul").hide();
        });

    };

    divselect(".divselect");


/*************************************************/
});



	//focus清空文本框
	function clearTxt(target, txt) {
		$(target).on('focus', function() {
			var value = $(this).val();
			if(value == txt) {
				$(this).val('');
			}
		});
		$(target).on('blur', function() {
			var value = $(this).val();
			if(value == '') {
				$(this).val(txt);
			}
		});
	}
