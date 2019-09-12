(function(){

})();

$(function(){

	//hm_banner 轮播图
	new FadeAdver({
		btns : $(".hm_banner .btns span"),
		divs : $(".hm_banner .pics li"),
		speed : 5000	
	});		
	
	//hmb_slide 滚动
	if($(".hmb_slide li").length >= 5){
		new TextSlider({
			outer : $(".hmb_slide"),
			inner : $(".hmb_slide ul"),
			direction : "left"	
		});	
	}
	
	new ChangeDiv({
		btns : $(".hm_tabs .handle a"),
		divs : $(".hm_tabs .con")	
	});	

});	