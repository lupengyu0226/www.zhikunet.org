<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="col-tab">
<ul class="tabBut cu-li">
     <li id="tab_setting_1" class="" onclick="SwapTab('setting','','',3,1);"><a href="?app=weixin&controller=reply&view=addkeyword" >图文</a></li>
      <li id="tab_setting_2" class="" onclick="SwapTab('setting','on','',3,2);"><a href="?app=weixin&controller=reply&view=addtext" >文本</a></li>
     <li id="tab_setting_3" class="on" onclick="SwapTab('setting','on','',3,3);"><a href="?app=weixin&controller=reply&view=bandingcat" >绑定栏目</a></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<form action="?app=weixin&controller=reply&view=bandingcat&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<div class="explain-col"> 
		提示：关键词绑定栏目后，回复关键词将调用该栏目最新的5条图文，点击栏目链接后，会进入该栏目的列表。
		</div>
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
 <tr>
  <th width="100">关键词：</th>
  <td>
        <input type="text" name="weixin[keyword]" id="keyword" size="50" class="input-text"><span style="margin-left:10px;color:#999;">多个关键词，请用空格隔开</span>
        </td>
 </tr>
 <tr>
  <th width="100">标题：</th>
  <td>
        <input type="text" name="weixin[name]" id="name" size="50" class="input-text">
        </td>
 </tr>
 <tr>
  <th width="100">栏目链接：</th>
  <td>
        <input type="text" name="weixin[url]" id="url" size="50" class="input-text"> <span style="margin-left:10px;color:#999;">此处可以留空，会自动生成绑定栏目的链接</span>
        </td>
 </tr>
      <tr>
  <th width="100">缩略图：</th>
  <td><?php echo form::images('weixin[picurl]', 'picurl', '', 'weixin')?></td>
 </tr>
 <tr>
  <th width="100"><?php echo L('绑定栏目')?>：</th>
  <td>
        <?php echo form::select_category('', $catid, 'name="catid"', L('please_select'), '', 0, 1)?>
        </td>
 </tr>
 <tr>
  <th width="100"><?php echo L('文章条数')?>：</th>
  <td>
        <?php echo form::select(array(''=>'请选择', '1'=>'1', '2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9'), $num, 'name="num"')?><span style="margin-left:10px;color:#999;">默认是3条图文</span>
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