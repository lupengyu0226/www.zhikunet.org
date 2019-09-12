	$(function(){
		//select 模拟框
		$("#options").hover(function(){
			$("#options dd,#options b").show();
		}, function() {
			$("#options dd").hide();
		});
		
		$("#options ,#options div a").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		});
		
		$("#keyType").val(this.id);
		
		$("#options div a").click(function(){
			$("#text").val($(this).html());
			$("#keyType").val(this.id);
			$("#text").val($("#").html());
			$("#options dd").hide();
		});
	});
	//最后获取 text 文本框的值
	$("#text").val($("#").html());