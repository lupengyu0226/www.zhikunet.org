<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="col-tab">
<ul class="tabBut cu-li">
     <li id="tab_setting_1" class="on" onclick="SwapTab('setting','','',1,1);"><a href="#" >修改关键词</a></li>      
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<form action="?app=weixin&controller=service&view=editkeyword&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
 <tr>
  <th width="100">关键词：</th>
  <td>
        <input type="text" name="weixin[keyword]" id="keyword" size="50" class="input-text" value="<?php echo $infos['keyword'];?>"><span style="color:#999;"> </span>
        </td>
 </tr>
</table>
 <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
</form>
</div>
</div>
</div>
</body>
</html> 