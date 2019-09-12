<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=weixin&controller=usermanage&view=sent_xzh_news&openid=<?php echo $openid; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="weixin[title]" id="title" size="30" class="input-text"></td>
	</tr>
	<tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="weixin[content]" rows="10" cols="60"  /></textarea>
		</td>
	</tr>
	<tr>
		<th width="100">链接网址：</th>
		<td><input type="text" name="weixin[url]" id="url"  size="30" class="input-text"></td>
	</tr>
<tr>
		<th width="100">注意：</th>
		<td>本消息直接发送到用户微信上，切勿滥用</td>
	</tr>
	 <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
</table>
</form>
</div>
</body>
</html> 