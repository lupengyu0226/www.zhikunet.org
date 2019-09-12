<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=weixin&controller=usermanage&view=sent_xzh_message&openid=<?php echo $openid; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="message[content]" rows="20" cols="80"  /></textarea>
		</td>
	</tr>
<tr>
		<th width="100">注意：</th>
		<td>本消息直接发送到用户微信上，切勿滥用</td>
	</tr>
    <tr>
		<td>
		<input type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>                   
</table>
</form>
</div>
</body>
</html> 