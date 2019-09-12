<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="col-tab">
<ul class="tabBut cu-li">
     <li id="tab_setting_1" class="" onclick="SwapTab('setting','','',1,1);"><a href="?app=weixin&controller=reply&view=editkeyword&id=<?php echo $id; ?>" >图文列表</a></li>
     <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=reply&view=addarticle&id=<?php echo $id; ?>" >添加图文</a></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<form action="?app=weixin&controller=reply&view=addarticle&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
 <tr>
  <th width="100">标题：</th>
  <td><input type="text" name="weixin[title]" id="title" size="50" class="input-text"></td>
 </tr>
     <tr>
  <th width="100">图片链接地址：</th>
  <td><?php echo form::images('weixin[thumb]', 'thumb', '', 'weixin')?></td>  
 </tr>
 <tr>
  <th width="80">描述：</th>
  <td>
  <textarea  name="weixin[description]" rows="2" cols="100"  /> </textarea>
  </td>
 </tr>
    <tr>
  <th width="80">内容：</th>
  <td>
  <textarea  name="weixin[content]" id="content" style="width:60%;height:300px;" /> </textarea><?php echo form::editor('content','full','','','',1);?>
  </td>
 </tr>
<tr>
  <th></th>
  <td>
        <input name="weixin[replyid]" type="hidden" value="<?php echo $id?>" />
         <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> "></td>
 </tr>
</table>
</form>
</div>
</div>
</div>
</div>
</body>
</html> 