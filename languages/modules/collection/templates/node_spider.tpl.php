<?php defined('IN_ADMIN') or exit('The resource access forbidden.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script type="text/javascript">
function dataTrans(str)
{
	var obj = {};
	str = str.replace( /^Array\s*\(/,'' ).replace( /\)\s*$/,'' );
	str.replace( /\[(\w+)\]\s+=>((?:[\S\s](?!\[(\w+)\]\s+=>))+)/g,function( m,$1,$2 )
	{
		obj[$1] = $2;
	});
	return obj;
}
function trim(str){
return str.replace(/(^\s*)|(\s*$)/g, "");
}

function IsURL (str_url) {
	var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{2,15}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
	var re=new RegExp(strRegex);
//re.test()
	if (re.test(str_url)) {
		return (true);
	} else {
		return (false);
	}
}

$(function(){
$("#check_spider").bind("click",function(){
		//if (!$('#nodeid').val() || !$('#url').val()||!IsURL($('#url').val())) {
		//alert('您忘了选择站点规则还是没有填写目标网址?');
		///return false;
		//}
		if (!$('#nodeid').val() || !$('#url').val()) {
		alert('您忘了选择站点规则还是没有填写目标网址?');
		return false;
		}
	$('#check_spider').val('正在抓取…');
	$('#check_spider').attr('disabled', true);
	
	$.getJSON('?app=collection&controller=node&view=public_test_content&sid=' + Math.random() * 5+'&jsoncallback=?', {url: $('#url').val(),nodeid: $('#nodeid').val()},function(json) {

		if(typeof(json) == 'object'){
			 var data=json.items;
			 for(i in data){

				 switch(i){
					case 'title': 
						window.top.document.title=data[i];
						if(!window.top.$('#title').val()&&data[i]!='') window.top.$('#title').val(data[i]);;
					break; 
					case 'comeform':
						if(data[i]!='') window.top.$("input[name='info[copyfrom]']").val(data[i].replace(/(<a[^>]*>)/ig,'').replace(/(<\/a>)/ig,''));
					break; 
					case 'description':
						if(data[i]!='') window.top.$('#description').val(data[i]);
					break; 
					case 'daodu':
						window.top.CKEDITOR.instances.daodu.setData(data[i].replace(/\\"/g,'"'));
					break; 
					case 'content':
						window.top.CKEDITOR.instances.content.setData(data[i].replace(/\\"/g,'"'));
					break; 
					case 'jieshuyu': 
						window.top.CKEDITOR.instances.jieshuyu.setData(data[i].replace(/\\"/g,'"'));
					break; 
					case 'spider_image':
						var images=data[i]._url;
						window.top.$('#pictureurls_tips').css('display','none');
						var str = window.top.$('#pictureurls').html();
						//pictureurls
							$.each(images, function(i, n) {
								var ids = parseInt(Math.random() * 10000 + 10*i); 
								str += "<li id='image"+ids+"' style='margin:2px;float:left;background: #eef2f2;border: 1px solid #dce6ea;zoom: 1;padding: 1px;width: 180px;height: 180px;text-align: center;overflow: hidden;'><input type='hidden' name='pictureurls_url[]' value='"+n+"' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'> <img src='"+n+"' id='thumb_preview' width='135' height='113' style='cursor:pointer;'> <br> <br> <input type='text' name='pictureurls_alt[]' value='' style='width:160px;' class='input-text' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"> <a href=\"javascript:remove_div('image"+ids+"')\">移除</a> </li>";
							});
						window.top.$('#pictureurls').append(str);	
					break;
					default:
					
					break;
				}
				
			 }
		   $('#check_spider').val('成功抓取');	
		} else {
			alert('你确定你的目标地址是标准的http格式或者目标网址可以访问?');
			$('#check_spider').val('抓取失败');
		}
		$('#check_spider').attr('disabled', false)
	})	
	
})

})
function _parseURL(obj) {
	var url=obj.value;
	var string = new Array(); 
	var mobileSietList={news:"news",photo:"photo",video:"video",view:"huati",finance:"finance",ent:"ent",sports:"sports",digi:"digi",mil:"mil",lady:"lady",auto:"auto",games:"games",house:"house",astro:"astro",cul:"cul",fashion:"fashion","2014":"shijiebei","edu":"edu"};
	if((url!== null || url!== "undefined" || url!== '')&&url.indexOf(".qq.com") > 0){
		//string=parseURL(url);
		if(url.indexOf("/a/")>0){
			try{
				$(obj).val(reWriteUrl(url));
			}catch(e){}
			
			}
		
	}
}

var reWriteUrl = function(url){
	if(url){
		if(url.indexOf("/a/")>0 ){
			var Splits = url.split("/"),siteName=Splits[2].split("qq.com")[0].split(".").length==3?siteName=Splits[2].split("qq.com")[0].split(".")[0]+"_"+Splits[2].split("qq.com")[0].split(".")[1]:siteName=Splits[2].split("qq.com")[0].split(".")[0],aids=url.split("/a/")[1].split(".htm")[0].replace(/[^0-9]/g, ""),site="";
			if(typeof siteName!=="undefined" && typeof aids!=="undefined"){
				if(siteName.split(".").length>2){
					var len = siteName.split(".").length;
					for(var i=0;i<len;i++){
							site+=siteName.split(".")[i];
							if(i<len-2){
								site+="_";
							}
					}
				}else{
					site=siteName.split(".")[0];
				}
				return "http://xw.qq.com/"+siteName+"/"+aids;
			}
		}
	}
};
</script>
<div style="width:600px;padding-left:20px;">
<input type="text" id="url" name="url" onblur="javascript:_parseURL(this)" style="width:50%;" class="measure-input">
<?php echo $buttons;?>
<input type="button" class="button" id="check_spider" value="开始抓取" />
</div>
</body>
</html>