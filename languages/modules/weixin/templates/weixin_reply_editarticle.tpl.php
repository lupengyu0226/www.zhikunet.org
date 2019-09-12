<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=weixin&controller=reply&view=editarticle&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="weixin[title]" id="title" value="<?php echo $infos['title'] ?>" size="50" class="input-text"></td>
	</tr>
     <tr>
		<th width="100">图片地址：</th>
		<td><?php echo form::images('weixin[thumb]', 'thumb', $infos['thumb'], 'weixin')?></td>
	</tr>
    <tr>
		<th width="100">图文链接网址：</th>
		<td><input type="text" name="weixin[url]" id="url" value="<?php echo $infos['url'] ?>" size="100" class="input-text"></td>
	</tr>
	<tr>
		<th width="80">描述：</th>
		<td>
		<textarea  name="weixin[description]" rows="2" cols="100"  /><?php echo $infos['description'] ?></textarea>
		</td>
	</tr>
    <tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="weixin[content]" id="content"  /><?php echo $infos['content'] ?></textarea><?php echo form::editor('content','full');?>
		</td>
	</tr>
<tr>
<td><input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> " ></td>
</tr>
</table>
</form>
<table  width="100%">
<tr>
<td align="center">
 <a href="javascript:history.go(-1);" class="back" ><span style="font-size:26px;" class="icon-arrow-left">返回</span></a>
</td>
</tr>
</table>
</div>
</body>
</html> 