<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="col-tab">
<ul class="tabBut cu-li">
     <li id="tab_setting_1" class="on" onclick="SwapTab('setting','','',3,1);"><a href="#" >图文</a></li>
     <li id="tab_setting_2" class="" onclick="SwapTab('setting','on','',3,2);"><a href="?app=weixin&controller=reply&view=addtext" >文本</a></li>
     <li id="tab_setting_3" class="" onclick="SwapTab('setting','on','',3,3);"><a href="?app=weixin&controller=reply&view=bandingcat" >绑定栏目</a></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<form action="?app=weixin&controller=reply&view=addkeyword&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<div class="explain-col"> 
		提示：微信公号自动回复支持八条以下图文消息
		</div>
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


 <tr>
  <th width="100">关键词：</th>
  <td>
        <input type="text" name="weixin[keyword]" id="keyword" size="50" class="input-text"><span style="color:#999;">多个关键词，请用空格隔开</span>
        
  
        </td>
 </tr>
     <tr>
  <th width="100">标题：</th>
  <td><input type="text" name="weixin[title]" id="title" size="50" class="input-text"><span style="color:#999;">图文标题</span></td>
 </tr>
     <tr>
  <th width="100">图片链接地址：</th>
  <td><?php echo form::images('weixin[thumb]', 'thumb', '', 'weixin')?></td>
        
 </tr>
 <tr>
  <th width="80">描述：</th>
  <td>
  <textarea name="weixin[description]" rows="2" cols="115" /> </textarea>
  </td>
 </tr>
    <tr>
  <th width="80">内容：</th>
  <td>
  <textarea name="weixin[content]" id="content" style="width:60%;height:300px;" /> </textarea><?php echo form::editor('content','full','','','',1);?>
  </td>
 </tr>
</table>
 <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
</form>
</div>
</div>
</div>
<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
            
		}
        
	}
}
</script>
</body>
</html> 