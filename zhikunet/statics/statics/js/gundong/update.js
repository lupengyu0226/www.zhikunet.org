//定义首更新时间，单位为秒, 一小时为3600，一天为24*3600,取 0 则不启用更新
i_time = 900;
//获取当前时间
var mydate=new Date();
var t_time=Math.floor(mydate.getTime()/1000);  
//获取URL参数
 var scriptargs = document.getElementById('htmlscript').src;
function request(paras){
	var url = scriptargs;
	var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
	var paraObj = {}
	for (i=0; j=paraString[i]; i++){
		paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length);
	}
	var returnValue = paraObj[paras.toLowerCase()];
	if(typeof(returnValue)=="undefined"){
		return "";
	}else{
		return returnValue;
	}
}
var l_time = request('u_time');											  //页面上次更新时间
var b_time =t_time-l_time;										          //已经更新时间
var r_url = window.location.pathname;
if(i_time <= b_time && i_time>0){				//如果过期就提交更新
    $.post("update.php",{url:r_url,c_time:i_time},function(date){
    	 	if(date == 'true'){					//更新成功刷新一次页面
    		location.reload(true);			
    	}});	 
}