"use strict";!function(){var i={Tab:function(i){var t=i.el,e=i.callback||function(){},n=i.tabTitle||"li",s=i.triggerType||"mouseenter",a=i.switchCur||"cur";this.tabList=$(t).find(".hd").find(n),this.pannel=$(t).find(".bd-list");for(var m=this,c=0;c<this.tabList.length;c++)this.tabList[c].index=c,$(this.tabList[c]).on(s,function(){m.clickTab(this);var i=this.index;$(this).addClass(a),m.pannel[i].style.display="block",e($(this))})}};i.Tab.prototype.clickTab=function(i){for(var t=0;t<this.tabList.length;t++)$(this.tabList[t]).removeClass(this.switchCur),this.pannel[t].style.display="none"},window.M=i,$(".box").superSlider({prevBtn:".friendly-lt",nextBtn:".friendly-rt",listCont:"#friendly",speed:300,amount:1,showNum:1}),$(".arrow .arrow-right.do").each(function(i,t){t.page=Math.ceil($(t).parent().siblings(".tutorial-list-nav").children("a").length/7),t.curPage=0,t.i=$(t).parent().siblings(".tutorial-list-nav").css("left").slice(0,-2)-0,$(t).bind("click",function(){0==t.i&&(t.curPage=0),t.curPage<t.page-1&&($(t).parent().siblings(".tutorial-list-nav").css("left",t.i-770+"px"),t.curPage++)}),$(".arrow .arrow-left.do").each(function(i,e){$(e).bind("click",function(){e.Ri=$(e).parent().siblings(".tutorial-list-nav").css("left").slice(0,-2)-0,e.Ri<0&&($(e).parent().siblings(".tutorial-list-nav").css("left",e.Ri+770+"px"),t.curPage--)})})}),$(".to-reply").each(function(i,t){$(t).on("click",function(){if("取消回复"==$(t).text())return $(this).parent(".rt-reply").parent(".replay-head").parent(".reply").find(".re-reply").length?$(this).parent(".rt-reply").parent(".replay-head").parent(".reply").find(".reply-commert").remove():$(this).parent(".rt-reply").parent(".replay-head").parent(".reply").children(".re-reply-lists").remove(),void $(this).html("回复");$(".comment-main").find(".re-reply-lists").find(".reply-commert").remove(),$(".to-reply").each(function(i,t){$(t).html("回复")});var i='<div class="re-reply-lists">';i+='<i class="triangle"></i>',i+='<div class="reply-commert">',i+='<div class="comment-textarea" contenteditable="true"></div>',i+='<div class="publish">',i+='<a class="expression" href="javascript:;">',i+="添加表情",i+='<div class="biaoq_ico" style="display: none;">',i+="<span>",i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/1.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/2.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/3.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/4.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/5.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/6.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/7.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/8.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/9.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/10.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/11.gif" sn="0">',i+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/12.gif" sn="0">',i+="</span>",i+="<i></i>",i+="</div>",i+="</a>",i+='<input type="button" value="发表评论" class="comm-btn" name="cmtbtn" onclick="subComment(this)">',i+="</div>",i+="</div>",i+="</div>";var e='<div class="reply-commert">';e+='<div class="comment-textarea" contenteditable="true"></div>',e+='<div class="publish">',e+='<a class="expression" href="javascript:;">',e+="添加表情",e+='<div class="biaoq_ico" style="display: none;">',e+="<span>",e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/1.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/2.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/3.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/4.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/5.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/6.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/7.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/8.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/9.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/10.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/11.gif" sn="0">',e+='<img height="24" width="24" src="http://img1.2345.com/duoteimg/zhuanti/comment/images/12.gif" sn="0">',e+="</span>",e+="<i></i>",e+="</div>",e+="</a>",e+='<input type="button" value="发表评论" class="comm-btn" name="cmtbtn" onclick="subComment(this)">',e+="</div>",e+="</div>","回复"==$(this).html()&&($(this).parent(".rt-reply").parent(".replay-head").parent(".reply").find(".re-reply-lists").length?$(this).parent(".rt-reply").parent(".replay-head").siblings(".re-reply-lists").prepend(e):$(this).parent(".rt-reply").parent(".replay-head").parent(".reply").append(i),$(".re-reply-lists").each(function(i,t){0==$(t).find(".reply-commert").length&&0==$(t).find(".re-reply").length&&$(t).remove()}),$(this).html("取消回复"))})}),$(".comment").on("click",".comm-btn",function(){if(""!=$(this).parent(".publish").siblings(".comment-textarea").val()){var i='<div class="re-reply">';i+='<div class="replay-head" netid="0">',i+='<span class="net-name">2345石家庄网友</span>',i+='<span class="time">2017-06-15</span>',i+='<span class="rt-reply">',i+='<a class="like" href="javascript:;">2345</a>',i+="</span>",i+=" </div>",i+=' <div class="replay-info">',i+=$(this).parent(".publish").siblings(".comment-textarea").val(),i+="</div>",i+="</div>",$(this).parent(".publish").parent(".reply-commert").parent(".re-reply-lists").append(i),$(this).parent(".publish").siblings(".comment-textarea").html("")}}),1==$(".page .num.cur").html()?$(".go-left").addClass("focus").css("pointer-events","none"):$(".go-left").addClass("focus").css("pointer-events","default");new i.Tab({el:".comment-main-trig",triggerType:"click",tabTitle:".tab-mod a",callback:function(){}}),new i.Tab({el:".hot-comment-trig",triggerType:"click",tabTitle:".tab-mod a",callback:function(){}});$(".comment").on("mouseenter",".expression",function(){clearTimeout(t),$(this).find(".biaoq_ico").show()});var t=null;$(".comment").on("mouseleave",".expression",function(){var i=this;t=setTimeout(function(){$(i).find(".biaoq_ico").hide()},1e3)}),$(".comment").on("mouseenter",".biaoq_ico",function(){return clearTimeout(t),$(this).show(),!1}),$(".comment").on("mouseleave",".biaoq_ico",function(){clearTimeout(t);var i=this;return t=setTimeout(function(){$(i).hide()},100),!1}),$(".comment").on("click",".biaoq_ico img",function(i){i=i||window.event;var t=$(i.target).clone(),e=$(this).parent("span").parent(".biaoq_ico").parent(".expression").parent(".publish").siblings(".comment-textarea");e.focus(),e.append(t),e.append('<input type="text" class="testIpt"/>'),e.find(".testIpt").focus(),$(".testIpt").remove(),e.focus()}),$(".show-hide-lists").each(function(i,t){$(t).find(".rank-list li").each(function(i,t){$(t).hover(function(){$(t).parent(".rank-list").find(".hide-rank-info").hide(),$(this).find(".hide-rank-info").show()},function(){})})}),$(".tutorial-main").each(function(i,t){$(t).find("li").length>20&&($(t).find(".txt-dot-links-b").append('<a class="tutorial-fold" href="javascript:;">展开<i class="icon-up"></i></a>'),$(this).find("ul").css({height:"300px",width:"900px",position:"relative",overflow:"hidden",marginLeft:"0px"}),$(this).find("ul li").css("marginLeft","50px"),$(this).find(".tutorial-fold").on("click",function(){"展开"==$(this).text()?($(this).html('收起<i class="icon-down"></i>'),$(this).siblings("ul").css("height","auto")):($(this).siblings("ul").css("height","300px"),$(this).html('展开<i class="icon-up"></i>'))}))}),$(".analog-select").click(function(){$(this).toggleClass("focus");var i=this;$(this).find(".option").click(function(){$(i).find(".val-sel").html($(this).html())})})}();
//# sourceMappingURL=.map/index.js.map