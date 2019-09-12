// JavaScript Document
$(function(){

//   
    $(".interviewList .interviewCon interviewCona").not(':first').hide();
    $(".interviewList .interviewTitle span").hover(function(){

        $(this).addClass("se").siblings().removeClass("se");
        $(this).parent().siblings().children().eq($(this).index()).show().siblings().hide();
    });

   $("#mysubmit").on("click", function () {
        $("#Remark").val($(".OptionBox .ConBox .playChooseResult .chooseResult").text());
    });

})