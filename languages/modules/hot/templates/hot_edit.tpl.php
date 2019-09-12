<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript" src="//statics.05273.cn/statics/js/swfupload/swf2ckeditor.js"></script>
<script type="text/javascript">
<!--
  var charset = 'utf-8';
  var uploadurl = 'http://upload.05273.cn/';
//-->
</script>
<script language="javascript" type="text/javascript" src="//statics.05273.cn/statics/js/content_addtop.js"></script>
<div class="pad-lr-10">
<form action="?app=hot&controller=hot&view=edit&tagid=<?php echo $_GET['tagid']?>" method="post" id="myform">
	<table width="100%"  class="table_form">
	<tr>
    <th width="120">关键字：</th>
    <td class="y-bg"><input type="text" name="info[tag]" value="<?php echo $data['tag']?>" /></td>
  </tr>
    <tr>
      <th width="80"> 标签图   </th>
      <td><?php echo form::images('info[thumb]', 'thumb', $data['thumb'], 'hot')?></td>
    </tr>
  <tr>
      <th width="80"> 标签介绍    </th>
      <td><textarea name='info[content]' id='content' style='width:50%;height:46px;'   onkeyup="strlen_verify(this, 'content_len', 330)"><?php echo new_html_special_chars($data['content'])?></textarea>
      还可输入<B><span id="content_len">330</span></B> 个字符  </td>
    </tr>
  <tr>
    <th width="120">使用次数</th>
    <td class="y-bg"><input type="text" name="info[usetimes]" value="<?php echo $data['usetimes']?>" /></td>
  </tr>
    <tr>
    <th>最后使用时间</th>
    <td class="y-bg"><?php echo form::date("info[lastusetime]",date('Y-m-d H:i:s', $data['lastusetime']),1,1)?></td>
  </tr>
  <tr>
    <th>点击量</th>
    <td class="y-bg"><input type="text" name="info[hits]" value="<?php echo $data['hits']?>" /></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('灰色')?></th>
    <td class="y-bg">
      <input name="info[die]" value="1"  type="radio"  <?php echo ($data['die']=='1') ? ' checked' : ''?>> <?php echo L('灰色')?>&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="info[die]" value="0" type="radio"  <?php echo ($data['die']=='0') ? ' checked' : ''?>> <?php echo L('不灰')?>
  </td>
  </tr> 
  <tr>
    <th>最后点击时间</th>
    <td class="y-bg"><?php echo form::date("info[lasthittime]",date('Y-m-d H:i:s', $data['lasthittime']),1,1)?></td>
  </tr>
  <tr>
  <th><input type="hidden"  name="tagid" value="<?php echo $_GET['tagid']?>" /></th>
  <td> <input type="submit" id="dosubmit" class="button" name="dosubmit" value="<?php echo L('submit')?>" /></td>
  </tr>
</table>


   
</form>

</div>
</body>
</html>
