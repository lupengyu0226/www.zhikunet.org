<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
</table>
<form action="?app=weixin&controller=usermanage&view=sent_togroup_news&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="weixin[title]" id="title" size="30" class="input-text"></td>
	</tr>
    <tr>
		<th width="100">发送者：</th>
		<td><input type="text" name="weixin[author]" id="author" size="30" class="input-text"></td>
	</tr>
    <tr>
		<th width="80">描述：</th>
		<td>
		<textarea  name="weixin[digest]" rows="10" cols="60"  /> </textarea>
		</td>
	</tr>
	<tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="weixin[content]" rows="10" cols="60"  /> </textarea>
		</td>
	</tr>
    
    <tr>
		<th width="100">图文外链地址：</th>
		<td><?php echo form::images('weixin[picurl]', 'picurl', '', 'weixin')?></td>       
	</tr>
	<tr>
		<th width="100">链接网址：</th>
		<td><input type="text" name="weixin[content_source_url]" id="content_source_url"  size="30" class="input-text"></td>
	</tr>
    <tr>
		<th width="100">是否显示封面：</th>
		<td>是<input name="weixin[show_cover_pic]" type="radio" value="1" checked="checked"/>&nbsp;&nbsp;&nbsp;否<input name="show_cover_pic" type="radio" value="0" /></td>
	</tr>
<tr>
		<th></th>
		<td>                
         <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> "></td>
	</tr>
</table>
</form>
</div>
</body>
</html> 