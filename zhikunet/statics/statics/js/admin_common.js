function confirmurl(url,message) {
	url = url+'&safe_edi='+safe_edi;
	if(confirm(message)) redirect(url);
}
function redirect(url) {
	location.href = url;
}
//滚动条
$(function(){
	$(":text").addClass('input-text');
})
//格式化时间
Date.prototype.format =function(format)
{
var o = {
"M+" : this.getMonth()+1, //month
"d+" : this.getDate(), //day
"h+" : this.getHours(), //hour
"m+" : this.getMinutes(), //minute
"s+" : this.getSeconds(), //second
"q+" : Math.floor((this.getMonth()+3)/3), //quarter
"S" : this.getMilliseconds() //millisecond
}
if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
(this.getFullYear()+"").substr(4- RegExp.$1.length));
for(var k in o)if(new RegExp("("+ k +")").test(format))
format = format.replace(RegExp.$1,
RegExp.$1.length==1? o[k] :
("00"+ o[k]).substr((""+ o[k]).length));
return format;
}

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").is(":checked")==true) {
		$("input[name='"+name+"']").each(function() {
  			$(this).attr("checked","checked");
		});
	} else {
		$("input[name='"+name+"']").each(function() {
  			$(this).removeAttr("checked");
		});
	}
}

function openwinx(url,name,w,h) {
	if(!w) w=screen.width-4;
	if(!h) h=screen.height-95;
	url = url+'&safe_edi='+safe_edi;
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}
//弹出对话框
function omnipotent(id,linkurl,title,close_type,w,h) {
	if(!w) w=700;
	if(!h) h=500;
	art.dialog({id:id,iframe:linkurl, title:title, width:w, height:h, lock:true},
	function(){
		if(close_type==1) {
			art.dialog({id:id}).close()
		} else {
			var d = art.dialog({id:id}).data.iframe;
			var form = d.document.getElementById('dosubmit');form.click();
		}
		return false;
	},
	function(){
			art.dialog({id:id}).close()
	});void(0);
}
//全角转换半角函数
	function ToCDB(str) {
		var tmp = "";
		for (var i = 0; i < str.length; i++) {
			if (str.charCodeAt(i) > 65248 && str.charCodeAt(i) < 65375&&str.charCodeAt(i)!=65292&&str.charCodeAt(i)!=65306&&str.charCodeAt(i)!=65311&&str.charCodeAt(i)!=65307) {
				tmp += String.fromCharCode(str.charCodeAt(i) - 65248);
				} else {
				tmp += String.fromCharCode(str.charCodeAt(i));
			}
		}
		var myDate = new Date();
		var reg=/(\((陕西日报|\s*香港文汇网)?(实习记者|见习记者|记者|作者|通讯员|评论员)(.*?)(分析(报道)?)??\))/;
		//var reg=/(\((实习记者|见习记者|记者|作者|通讯员)(.*)(分析(报道)?)?\))/;
		
		var rs=reg.exec(tmp);
		if(rs!=null&&$("input[name='info[author]']").val()=='') $("input[name='info[author]']").val(rs[4].trim().replace(/(：|:|　|记者|作者|实习生|实习记者|见习|通讯员|((浙江|重庆|福州|昆明|北京|内蒙古|常州|南京|天津|西安|兰州|成都|上海|重庆|郑州|深圳|沈阳|哈尔滨|综合)报道))/g," ").replace(/(<\/?[^>]*>)/gi,'').trim());
		
		var reg_hsw=/(<p([^>]*)>((华商(报)?记者)(.+?)?)<\/p>)/;
		
		var rs_h=reg_hsw.exec(tmp);
		if(rs_h!=null&&$("input[name='info[author]']").val()==''){
			$("input[name='info[author]']").val(rs_h[6].trim().replace(/(：|:|　|记者|作者|实习生|实习记者|见习|通讯员|((浙江|重庆|福州|昆明|北京|内蒙古|常州|南京|天津|西安|兰州|成都|上海|重庆|郑州|深圳|沈阳|哈尔滨|综合|编译)报道))/g," ").replace(/(<\/?[^>]*>)/gi,'').replace(/((\()|(\))|（|）|\[page\]|\/)/g,"").trim());
			if($("input[name='info[copyfrom]']").val()=='')$("input[name='info[copyfrom]']").val('华商报');
		}		
		//获取原标题
		var reg_title=/(<p([^>]*)>(\()?原标题(:|：)(.+)<\/p>)/;
		var r_title=reg_title.exec(tmp);
		//alert(r_title[0]);
		if(r_title!=null){
			tmp=tmp.replace(/(<p([^>]*)>(\()?原标题(:|：)(.+)<\/p>)/g,"");		
		}
		//将原标题替换为空
		
		var reg_source=/(<p>(\(|（)?来源(:|：)(.*?)?(\)|）)?<\/p>)/;
		var rss=reg_source.exec(tmp);

		
		if(rss!=null&&$("input[name='info[copyfrom]']").val()==''&&rss[4]) {
					rss[4]=rss[4].replace(/(<\/?a[^>]*>)/gi,'').replace(/(\(|\))/ig,'')
					if(rss[4]!=""||!rss[4]) rss[4]=rss[4].trim(); 
					$("input[name='info[copyfrom]']").val(rss[4]);
		}
		if(tmp.search(/沭阳网/)!=-1){
			if($("input[name='info[copyfrom]']").val()=='中国新闻网') $("input[name='info[copyfrom]']").val('沭阳网');
			if($("input[name='info[copyfrom]']").val()=='宿迁网') $("input[name='info[copyfrom]']").val('沭阳网');
		}
		
		
		tmp=tmp.replace(/(<p>(\(|（)?来源(:|：)(.*?)?(\)|）)?<\/p>)/g,"");
		
		var reg_source=/(\((.*?)?(政府办)\))/;
		var rss=reg_source.exec(tmp);
		if(rss!=null&&$("input[name='info[copyfrom]']").val()=='') $("input[name='info[copyfrom]']").val(rss[0].replace(/(\(|\))/ig,'').trim());
		
		var reg_zps=/(中\s*评\s*社(.+)?((\d+)月(\d+)日电(\/)?)?\((记者|实习记者|特约评论员|评论员))/;
		var rss_zps=reg_zps.exec(tmp);
		if(rss_zps!=null&&$("input[name='info[copyfrom]']").val()=='')$("input[name='info[copyfrom]']").val('中评社');
		tmp=tmp.replace(/(中\s*评\s*社(.+)?((\d+)月(\d+)日电(\/)?)?\((记者|实习记者|特约评论员|评论员))/g,"中评社($7");
		
		
		
		tmp=tmp.replace(/(\((.*?)?(政府办)\))/g,"");		
		
		if(tmp.search(/\[page\]/)>0){
			if($('#paginationtype').val()) {
			$('#paginationtype').val(2);
			$('#paginationtype').css("color","red");
			}
		}
		tmp=tmp.replace(/(「|﹃)/g,"“").replace(/(」|﹄)/g,"”").replace(/(俄新网RUSNEWS.CN(莫斯科|明斯克|基辅)?)/ig,'沭阳网').replace(/(宿迁网)/ig,'沭阳网').replace(/(中\s*评\s*社[\u4e00-\u9fa5]{2,4}((\d+)月(\d+)日电(\/)?))/ig,'沭阳网'+(myDate.getMonth()+1)+'月'+myDate.getDate()+'日讯  ').replace(/(中新网(\d+)月(\d+)日电)/ig,'沭阳网'+(myDate.getMonth()+1)+'月'+myDate.getDate()+'日讯  ').replace(/(Yes娱乐\s(\d+)月(\d+)日综合报导)/ig,'').replace(/((“(“+)?)?中央社(”(”+)?)?)/g,"“中央社”").replace(/((“(“+)?)?(苹果日报|苹果日报)(”(”+)?)?)/g,"“苹果日报”").replace(/((“(“+)?)?(中国时报|中国时报)(”(”+)?)?)/g,"“中国时报”").replace(/((“(“+)?)?(今日新闻网|今日新闻网)(”(”+)?)?)/g,"“今日新闻网”").replace(/((“(“+)?)?(东森|东森)(”(”+)?)?)/g,"“东森”").replace(/(安倍(晋三(晋三+)?)?)/g,"安倍晋三").replace(/(三秦都市报\s*-\s*三秦网讯)/g,"三秦网讯").replace(/(阿帕契)/g,"阿帕奇").replace(/(産|產)/g,"产").replace(/(长程)/g,"远程").replace(/(<b>大\s*公\s*网<\/b>)/g,'沭阳网').replace(/(大\s*公\s*财\s*经)/g,'汉台财经').replace(/(大\s*公\s*娱乐讯)/g,'沭阳娱乐讯').replace(/(本\s*报讯)/g,'沭阳网讯').replace(/(飞弹)/g,"导弹").replace(/(圜)/g,"元").replace(/(布希|布殊)/g,"布什").replace(/(陕西传媒网(-陕西日报)?讯)/g,'陕西传 媒网讯').replace(/(駡)/g,"骂").replace(/(萨尔科齐)/g,"萨科齐").replace(/(啓|啟)/g,"启").replace(/(艾博特)/g,"阿博特").replace(/(马国)/g,"马来西亚").replace(/(土国)/g,"土耳其").replace(/(菲国)/g,"菲律宾").replace(/(敍)/g,"叙").replace(/(儷)/g,"俪").replace(/(传媒)/g,"媒体").replace(/(叙国)/g,"叙利亚").replace(/(沙国|沙乌地阿拉伯)/g,"沙特阿拉伯").replace(/(闆)/g,"板").replace(/(杜特蒂)/g,"杜特尔特").replace(/(吉爾吉斯|吉尔吉斯)(斯坦)?/g,"吉尔吉斯斯坦").replace(/(柯林顿)/g,"克林顿").replace(/(卡麦隆)/g,"卡梅伦").replace(/(郁)/g,"郁").replace(/(陞)/g,"升").replace(/(颱)/g,"台").replace(/(欧巴马|歐巴馬)/g,"奥巴马").replace(/(短讯)/g,"短信").replace(/(巴士)/g,"公交").replace(/(机械人)/g,"机器人").replace(/(内地)/g,'国内').replace(/(南韩海难|韩国海难)/g,'“世越”号客轮沉没').replace(/(纽西兰)/g,"新西兰").replace(/(北韩|北朝鲜|北韓)/g,"朝鲜").replace(/(加国)/g,"加拿大").replace(/(意国)/g,"意大利").replace(/(南韩|南朝鲜|南韓)/g,"韩国").replace(/(着名)/g,'知名').replace(/(閒)/g,'闲').replace(/(渖|瀋)/g,'沈').replace(/(衞)/g,'卫').replace(/(準)/g,'准').replace(/(盡)/g,'尽').replace(/(讯息)/g,'消息').replace(/(讯号)/g,'信号').replace(/(畿)/g,"几").replace(/(眾|衆)/g,'众').replace(/(佈)/g,'布').replace(/(澳洲)/g,'澳大利亚').replace(/(蜜雪儿)/g,'米歇尔').replace(/(英禄)/g,'英拉').replace(/(川普)/g,'特朗普').replace(/(翁山苏姬|翁山蘇姬|昂山淑姬)/g,'昂山素季').replace(/(普丁)/g,'普京').replace(/(欧兰德|歐蘭德)/g,'奥朗德').replace(/(梅克爾|梅克尔)/g,'默克尔').replace(/(戈巴契夫)/g,'戈尔巴乔夫').replace(/(义大利)/g,'意大利').replace(/(兇)/g,'兄').replace(/(黑盒)/g,'黑匣子').replace(/(盧安達|卢安达)/g,'卢旺达').replace(/(指摘)/g,'指责').replace(/(並)/g,'并').replace(/(衝)/g,'冲').replace(/(蓝宝坚尼)/g,'兰博基尼').replace(/(占|佔)/g,'占').replace(/(製)/g,'制').replace(/(僞)/ig,'伪').replace(/(回教)/g,'伊斯兰').replace(/(比坚尼)/g,'比基尼').replace(/(刀锋跑手|刀锋跑者)/g,'刀锋战士').replace(/(作业系统)/g,'操作系统').replace(/(裏|裡)/g,'里').replace(/(爲|為)/g,'为').replace(/(後)/g,'后').replace(/(複|復)/g,'复').replace(/(加萨)/g,'加沙').replace(/(證)/g,'证').replace(/(隻)/g,'只').replace(/(拚)/g,'拼').replace(/(臟)/g,'脏').replace(/(侄)/g,'侄').replace(/(遊)/g,'游').replace(/(姦)/g,'奸').replace(/(強)/g,'强').replace(/(髮)/g,'发').replace(/(誌)/g,'志').replace(/(洩慾)/g,'泄欲').replace(/(萤幕)/g,'屏幕').replace(/(寧)/g,'宁').replace(/(爱滋)/g,'艾滋').replace(/(余|馀|餘)/g,'余').replace(/(钓岛)/g,'钓鱼岛').replace(/(杜拜)/g,'迪拜').replace(/(警员)/g,'警察').replace(/(台湾时间)/g,'北京时间').replace(/(希拉妮|希拉蕊|希拉莉)/ig,'希拉里').replace(/(俄國|俄国)/ig,'俄罗斯').replace(/(馬利|马利)/ig,'马里').replace(/(三藩)/ig,'旧金山').replace(/(史丹福)/ig,'斯坦福').replace(/(网际网路|网路)/g,'互联网').replace(/(香港新闻网)/ig,'沭阳网 ').replace(/(寳)/g,'宝').replace(/(系|繫|系|係)/g,'系').replace(/(崑)/g,'昆').replace(/(崙)/g,'仑').replace(/(采)/g,'采').replace(/(枪)/g,'枪').replace(/(盃)/g,'杯').replace(/(锺|鐘)/g,'钟').replace(/(妳)/g,'你').replace(/(糰)/g,'团').replace(/(历|歷)/g,'历').replace(/(勳)/g,'勋').replace(/(麽|麼)/g,'么').replace(/(艳|艶)/g,'艳').replace(/(嘆)/g,'叹').replace(/(【on.cc\s*东网专讯】|本报沭阳讯|【环球时报综合报道】|【本报两岸组报道】|【本报国际组报道】)/ig,'沭阳网专讯 ').replace(/(【文\s*汇网讯】)/ig,'沭阳网'+(myDate.getMonth()+1)+'月'+myDate.getDate()+'日讯 ').replace(/(\(本网讯\))/ig,'').replace(/(\(美联社\)|國際中心\/綜合報導|国际中心\/综合报导|大陸中心\/綜合報導|大陆中心\/综合报导)/ig,'').replace(/(\(完\))/ig,'').replace(/(\(美联社\)|\(互联网\)|\(微博\)|▲|▼)/ig,'').replace(/<p[^>]*?class=["\'](narrow1|narrow)["\']>(.*)<\/p>/ig,"<p style=\"text-align:center\">$2</p>").replace(/(<p\s*class=["\'](dropcap)["\'][^>]*>(.*)<\/p>)/ig,'<p style=\"TEXT-INDENT:2em\">$3</p>').replace(/(<img\b[^>]*src\s*=\s*"[^>"]*\/(right|end|favicon|Logo|bigger|Android2015summer_300x250-fixed|gaokaocon|U412P4T47D33289F968DT20150915144117|transparent|3|2|end_news|C3iG-fxmueaa3689830|icon_logo|ad_4|204c433878d5cf9size1_w16_h16)\.(?:gif|jpg|png|ico)"[^>]*>)/ig,'').replace(/(返回腾讯网首页&gt;&gt;|放大图片|放大图片|\(点击图片翻页\)|\(<font color="red">点击图片翻页<\/font>\)|\(汉中日报\)|<p style="text-align: center;color:#F00;font-size:12px">点击图片进入下一页<\/p>)/g,'').replace(/(\(陕西广播电视台《新闻联播》\)|\(图片来源：Yes娱乐\)|\(陕西广播电视台《都市快报》\)|\(陕西广播电视台《第一新闻》\))/g,'  ').replace(/(<div[^>]*?align=["\'](left|right)["\'][^>]*>)/ig,'<p style=\"TEXT-INDENT:2em\">').replace(/(<p\s*align=["\'](left|right)["\'][^>]*>(.*)<\/p>)/ig,'<p style=\"TEXT-INDENT:2em\">$3</p>').replace(/(thumb_(\d+)_(\d+)_|_200x200_0|_116x86_0)/ig,'').replace(/(<p>((\d+)-)?((\d+)-)?(\d+):(\d+)<\/p>)/ig,'').replace(/(<p>((\d+)|我要分享)<\/p>)/ig,'').replace(/(<p>(\d+)\/(\d+)<\/p>)/ig,'<p>[page]</p>').replace(/(<p>\/(\d+)<\/p>)/ig,'').replace(/((jpg|JPG|JPEG|jpeg|gif)\?.*(["|']))/ig,'$2$3').replace(/((\s)?(\d)(\s)?)/g,"$3").replace(/(判囚)/g,"判刑").replace(/(女大生)/g,"女大学生").replace(/(男大生)/g,"男大学生").replace(/(荷里活)/g,"好莱坞").replace(/(蒲美蓬)/g,"普密蓬").replace(/(葉門)/g,"也门").replace(/(麵)/g,"面").replace(/(馊水油)/g,"地沟油").replace(/(猫熊)/g,"大熊猫").replace(/(寸)/g,"寸").replace(/(华府)/g,"华盛顿").replace(/(【本图文由中国日报网湖北频道娱乐编辑整理】)/g,"【本图文由沭阳网娱乐频道编辑整理】").replace(/(\(\s*香港文汇网)/gi,"(").replace(/(<h1([^>]*)>(.*)<\/h1>)/gi,"").replace(/(<h(\d+)([^>]*)><\/h(\d+)>)/gi,"").replace(/(\(中评社(.+)(摄|资料相|资料图)\))/gi,"").replace(/(中\s*评\s*社快评\/)/gi,"");
		
		if(r_title!=null){
			tmp=tmp+r_title[0];		
		}
		
		
		//再次判断 第一页和最后一页内容是否相同
		if(tmp.search(/\[page\]/)>0){
		 _s=tmp.split("<p>[page]</p>");
		 //console.log(_s[0]);
		 //console.log(_s[_s.length-1]);
		 if(_s[0].trim()==_s[_s.length-1].trim()){
			 //console.log('==');
			 _s.pop();
			 //_s[_s.length-1]='';
			 //tmp=_s.join("<p>[page]</p>");
			}
		  else{
			//最后一页空位，则删除最后一页
			if(!_s[_s.length-1].trim().length) _s.pop();
			
			 // console.log(_s[0].length+'%'+_s[_s.length-1].length);
			}	
		tmp=_s.join("<p>[page]</p>");	  	
		}
		
		
		//再次判断 第一页和第二页内容是否相同
		if(tmp.search(/\[page\]/)>0){
		 _s=tmp.split("<p>[page]</p>");
		 console.log(_s[0]);
		 console.log(_s[1]);
		 if(_s[0].trim()==_s[1].trim()){
			 console.log('==');
			 _s.shift();
			}
		  else{
			  if(!_s[0].trim().length)  _s.shift();
			  console.log(_s[0].length+'%'+_s[1].length);
			}
			tmp=_s.join("<p>[page]</p>");	  	
		}
		if(tmp.search(/\[page\]/)>0){
			_s=tmp.split("<p>[page]</p>");	
			if(!_s[0].trim().length && _s.length==2 ){
				 _s.shift();
				tmp=_s.join(''); 
			}else{
				// _s.shift();
				tmp=_s.join("<p>[page]</p>");
			}
		}
		
		
		
		
		return tmp;
		
		
		myDate=null; 
	}	//

function formatword(data){
	data=gettitle(data);/*replace(/(<[^>]+>\[page\]<\/[^>]+>)/ig,'[page]').*/
	data=data.replace(/(　)/g, '').replace(/(「)/g,"“").replace(/(」)/g,"”").replace(/( 俄新社)/g," 沭阳网").replace(/(欧巴马|歐巴馬)/g,"奥巴马").replace(/(宝鸡新闻网|法晚|深读|每经小编|观海解局|每日人物)/g,"互动沭阳").replace(/(todaytopic|gcxxjgzh|fzwb_52165216|shenduzhongguo|boyangcongpeople|btime007|nbdnews|guanhaijieju|meirirenwu)/g,"hudongshuyang").replace(/(北韩)/g,"朝鲜").replace(/(南韩)/g,"韩国").replace(/(企鹅答主)/g,"沭阳网友").replace(/(企鹅问答)/g,"沭阳网友").replace(/(lang="1" )/g,"").replace(/(lang="0" )/g,"").replace(/(<a[^>]*?)href=["\'](?!http:\/\/(.*)?05273.com).*?>(.*?)<\/a>/ig,"$3").replace(/<!--(.*)-->/gi,'').replace(/<br\/><br\/>/gi,'<br/>').replace(/<h4><img/ig,"<p><img").replace(/(<p\s*class=["\'](summary|p0|ct_p|p_center)["\'][^>]*>)/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/(<label([^>]*)>(.+?)<\/label>)/ig,'').replace(/(_fcksavedurl="([^>]*)" alt)/ig,'alt').replace(/(<i class="a-p-s-play">(.+?)<\/i>)/ig,'').replace(/(data(.+)src=)/ig,'src=').replace(/(copyright(.+)src=)/ig,'src=').replace(/(<p>)/ig,'<p style="TEXT-INDENT:2em">').replace(/(<a[^>]*?class=["\'](pageMark)["\'][^>]*>([\s\S]*?)<\/a>)/ig,'[page]').replace(/((<p>(<p>+)?)?\[page\](<\/p>(<\/p>+)?)?)/g,"<p>[page]</p>").replace(/(<strong>\[page\]<\/strong>)/ig,'[page]').replace(/(<p><strong><p>\[page\]<\/p><\/strong><\/p>)/ig,'[page]').replace(/(<a[^>]*?name=["\']page(\d)["\'][^>]*><\/a>)/ig,'[page]').replace(/((<p>\[page\]<\/p>(\r|\n)?){2,})/gi,"<p>[page]</p>").replace(/(<b>\[page\]<\/b>)/ig,'[page]').replace(/(<p><b><p>\[page\]<\/p><\/b><\/p>)/ig,'[page]').replace(/(<p style=["\']text-align:( |)center(;|)(font-size:12px)?["\']>\[page\]<\/p>)/ig,'<p>[page]</p>').replace(/((<div[^>]*?)align=["\'](left|right)["\'][^>]*>(.*)<\/div>)/ig,'$4').replace(/(<p\s*align=["\']justify["\'][^>]*>)/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/(<p\s*class=["\']split["\'])>/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/(<p\s*class=["\']titdd-Article["\'])>/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/(<td\s*align=["\']center["\'])>/ig,"<p style=\"text-align:center\">").replace(/(<font[^>]*?class=["\'](sub_fr14)["\'][^>]*>(.+?)<\/font>)/ig,"").replace(/((<font[^>]*?)color=["\']#FEFEFE["\'][^>]*>(.*)<\/font>)/ig,'').replace(/((<font[^>]*?)FONT-SIZE[^>]*>(.*)<\/font>)/ig,'$3').replace(/((<font[^>]*?)size=["\'](\d)["\'][^>]*>(.*)<\/font>)/ig,'$4').replace(/((<font[^>]*?)face=["\']宋体["\'][^>]*>(.*)<\/font>)/ig,'$3').replace(/<div style="text-align:center">(.+?)<\/div>/ig,"<p style=\"text-align:center\">$1</p>").replace(/(<div[^>]*?class=["\'](left_pt|pictext)["\'][^>]*>(.+?)<\/div>)/ig,"<p style=\"text-align:center\">$3</p>").replace(/(<span[^>]*?class=["\'](img_descr|a-p-s-txt)["\'][^>]*>(.+?)<\/span>)/ig,"<p style=\"text-align:center\">$3</p>").replace(/((<span[^>]*?)class=["\'](article-time|r all-number-comment)["\'][^>]*>(.*)<\/span>)/ig,'$4').replace(/((<span[^>]*?)id=["\'](J_Video_Source)["\'][^>]*>(.*)<\/span>)/ig,'').replace(/((<span[^>]*?)class=["\'](ad-span)["\'][^>]*>(.*)<\/span>)/ig,'<p>[page]</p>').replace(/(<p[^>]*?class=["\'](left_pt|pictext)["\'][^>]*>(.+?)<\/p>)/ig,"<p style=\"text-align:center\">$3</p>").replace(/(<p[^>]*?class=["\'](article-editor)["\'][^>]*>(.+?)<\/p>)/ig,"").replace(/<div\s*id=["\']infoNum["\'][^>]*>(.*)<\/div>/ig,'').replace(/(<div\s*style=["\'](font-size:12px;margin:5px 0;float:left|width:150px;)["\'])>/ig,"<p style=\"text-align:center\">").replace(/(<h4 style=["\']margin-top:10px;["\']>)/ig,"<h4>").replace(/(<div\s*class=["\']block["\'][^>]*>(.*)<\/div>)/,'').replace(/(<p><a[^>]*?class=["\'](shareBtn-hd)["\'][^>]*>我要分享<\/a><\/p>)/ig,"").replace(/(<div[^>]*?class=["\'](imgmask|imageList|bd|col(\d)|section(\d)|gplus|operate_(\d)|scrollbar(\d)|fb_like_(fans|news) xfb|article-content fontSizeSmall|ad-box|line|detail-img|image-select mt10 clearfix|p0|lightbox-target|about clearfix|gallery(.*)|hysy_content_con|content_con|left_text_p|image-zone clearfix|content|image-box clearfix|mbArticleSharePic(\s*)|cursor-right|cursor-left|moreContent|more|some-class-name2|xwzx_content1_box_con|xwzx_content1_box_con|breakingNewsContent|image-text clearfix|TRS_Editor|story|article-text|imgBg imgBgL|imgBg imgBgR|show_text)["\'][^>]*>)/ig,"").replace(/(<div[^>]*?id=["\'](some-class-name2|ozoom|p_content|gallery(.*)|info(.*)|vsb_(news)?content|nbody|content(_text)?|ctrlfscont|newsText|Cnt-Main-Article-QQ|left_04|zoom|Main-D|xwzx_content1_box_con)["\'][^>]*>)/ig,"").replace(/(<div class=["\']page_no["\']>(.*)<\/div>)/ig,"").replace(/(<img[^>]*?)align="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(height)="[^"]*"/ig,"$1").replace(/(<img[^>]*?)(onclick)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(onload)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(onmousemove)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(width)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(name)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(data-cke-saved-src|data-mcesrc|data-src|oldsrc|sourcedescription|md5|onerror)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(data-bd-imgshare-binded)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(id)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(class)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)(border)="[^"]*"/ig, "$1").replace(/(<img[^>]*?)title="[^"]*"/ig,"$1").replace(/(<img[^>]*?)style="[^"]*"/ig,"$1").replace(/(?:<p[^>]*>)*(<img[^>]*>)/ig,"<p style=\"text-align:center\">$1<br />").replace(/<div>([\s\S]*?)<\/div>/gi,"<p style=\"TEXT-INDENT:2em\">$1</p>").replace(/<br[^>]*\/?>/gi,'</p><p style=\"TEXT-INDENT:2em\">').replace(/(<p>(\n|\r|&nbsp;|&emsp;|&ensp;|)<\/p>)/gi,'').replace(/<img((?:(?!alt="[^"]*")[^>])*)>/ig,"<img alt=\""+document.getElementById('title').value+"\" $1>").replace(/(alt=["\']\\?["\'])/ig," alt=\""+document.getElementById('title').value+"\" ").replace(/(<img[^>]*?)p="[^"]*"/ig,"$1").replace(/(&nbsp;|&emsp;|&ensp;)/gi,'').replace(/<\/?table[^>]*>/ig,"").replace(/(<p class="text" style="TEXT-INDENT( |):( |)2em(;|)">(\n|\r|&nbsp;|)<\/p>)/gi, "").replace(/(<p style="TEXT-INDENT( |):( |)2em(;|)">(\n|\r|&nbsp;|)<\/p>)/gi, "").replace(/( class="text")/gi, "").replace(/( class="text image_desc")/gi, "").replace(/( abs_visibility="true")/gi, "").replace(/( class="pictext")/gi, "").replace(/((<p[^>]*?)(justify|normal)[^>]*>)/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/((<p[^>]*?)line-height[^>]*>)/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/((<p[^>]*?)>(<span>文章关键词：<\/span>(.+)(保存网页)?)<\/p>)/ig,"").replace(/(<p[^>]*?><b[^>]*?>相关专题：<\/b>.*?<\/p>)/ig,"").replace(/((<p[^>]*?)>(视频加载中，请稍候...|\s*向前\s*向后|)<\/p>)/ig,"").replace(/(\(约(新)?台币(.+)元\))/ig,"")/*.replace(/<\/?span[^>]*>/ig," ")*/.replace(/<\/?hr[^>]*>/ig,"").replace(/(<a>)/ig,"").replace(/<\/?(dl|dd|dt|ul|li)[^>]*>/ig,"<p style=\"TEXT-INDENT:2em\">").replace(/<\/?center[^>]*>/gi,' ').replace(/(<p style=["\']text-align:( |)center(;|)(font-size:12px)?["\']><\/p>)/gi,"").replace(/(<p align=["\']center["\']><\/p>)/gi,"").replace(/(<div([^>]*)>)/gi,"<p style=\"TEXT-INDENT:2em\">").replace(/((<p([^>]*)>)<strong([^>]*)>(<p([^>]*)>))/gi,"$5").replace(/(<p><\/strong><\/p>)/gi,"").replace(/(<\/div>)/gi,"</p>").replace(/(<style[^>]*?>[\s\S]*?<\/style>)/gi,"").replace(/(<script[^>]*?>[\s\S]*?<\/script>)/gi,"").replace(/(<\/?iframe[^>]*>)/gi,"").replace(/(<\/?(section|article)[^>]*>)/gi,"");
	return data;
	}
	
function gettitle(str){
	//alert(str);.replace(/<\/?em[^>]*>/gi,"")
	var _reg_h1=/(<h1([^>]*)>(.*)<\/h1>)/;
	var rss=_reg_h1.exec(str);
	if(rss!=null&&$("input[name='info[title]']").val()==''){
		$("input[name='info[title]']").val(rss[3].replace(/(\s(\s+)?)/g,"  ").replace(/(&middot;|&bull;)/ig,'•').replace(/(&mdash;)/ig,'——').replace(/((")(.+)?("))/ig,'“$3”').replace(/((&quot;)(.+)(&quot;))/ig,'“$3”').replace(/(&lt;)/ig,'《').replace(/(&gt;)/ig,'》').replace(/((\s{2,}|、|，|,))/g," ").trim());		
		if($("input[name='info[keywords]']").val()=='') $("input[name='info[title]']").blur();
	}	
	return str;
}	