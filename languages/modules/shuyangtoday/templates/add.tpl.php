<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>shuyangadmin/shuyangtoday.css"/>
<form method="post" action="?app=shuyangtoday&controller=manages&view=add">
<div class="pad-lr-10">
<div class="shuyangtoday">
<div class="top" id="top">
<img id="top_1_thumb_img" src="<?php echo IMG_PATH?>shuyangtoday/top.png" onclick="getli('top',1)" width="616" height="300" />
<h3 contenteditable="true" id="top_1_txt" onkeypress="ontop();" oninput="ontop();">标题</h3>
<em onclick="getli('top',1)">选择</em>
<span>添加一条</span>
<input type="hidden" name="top[title]" id="top_1_title"  value="">
<input type="hidden" name="top[thumb]" id="top_1_thumb"  value="">
<input type="hidden" name="top[catid]" id="top_1_catid"  value="">
<input type="hidden" name="top[url]" id="top_1_url"  value="">
<input type="hidden" name="top[id]" id="top_1_id"  value="">
</div>
<ul id="list">
</ul>
</div>

<div class="bk15"></div>
<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('提交')?>" class="button">&nbsp;<input type="reset" value=" <?php echo L('重写')?> " class="button">
</div>
</form>
<script type="text/javascript">
window.top.$("#display_center_id").css("display","none");

$("#top span").click(function(){
	var n = parseInt($('#list li:last input:last').val())+1;
	if(n){
		n = n;
	}else{
		n = 1;
	}
	var str = '<li><h3 contenteditable="true"  id="list_'+n+'_txt" onkeypress="onlist('+n+');" oninput="onlist('+n+');">文章标题</h3>'+
		    '<img id="list_'+n+'_thumb_img" name="" src="<?php echo IMG_PATH?>shuyangtoday/img.png" width="100" height="100" alt="" />'+
			'<em onclick="getli(\'list\','+n+')">选择</em>'+
            '<span onclick="$(this).parent().remove();">移除</span>'+
			'<input type="hidden" name="list['+n+'][title]" id="list_'+n+'_title"  value="">'+
			'<input type="hidden" name="list['+n+'][thumb]" id="list_'+n+'_thumb"  value="">'+
			'<input type="hidden" name="list['+n+'][id]" id="list_'+n+'_id"  value="">'+
			'<input type="hidden" name="list['+n+'][catid]" id="list_'+n+'_catid"  value="">'+
			'<input type="hidden" name="list['+n+'][url]" id="list_'+n+'_url"  value="">'+
			'<input type="hidden" name="list['+n+'][listorder]" id="list_'+n+'_listorder"  value="'+n+'">'+
			'</li>';
	$("#list").append(str);
});
function getli(did,n){
	window.top.art.dialog(
	{
		id:'get_content',
		iframe:'index.php?app=shuyangtoday&controller=manages&modelid=1&view=getlist&type='+did,
		title:'选择文章', 
		width:'720', 
		height:'460'
	}, 
	function(){
		var d = window.top.art.dialog({id:'get_content'}).data.iframe; 
		var str=d.$('#listdata').val();
		var arr = str.split("|");
		
		$("#"+did+"_"+n+"_txt").html(arr[0]);
		$("#"+did+"_"+n+"_thumb_img").attr('src',arr[4]);
		$("#"+did+"_"+n+"_title").val(arr[0]);
		$("#"+did+"_"+n+"_id").val(arr[1]);
		$("#"+did+"_"+n+"_catid").val(arr[2]);
		$("#"+did+"_"+n+"_url").val(arr[3]);
		$("#"+did+"_"+n+"_thumb").val(arr[4]);
	}, 
	function(){
		window.top.art.dialog({id:'get_content'}).close()
	});
}

function onlist(n){
	$("#list_"+n+"_title").val($("#list_"+n+"_txt").html());
}

function ontop(){
	$("#top_1_title").val($("#top_1_txt").html());
}
</script>
</body>
</html>
