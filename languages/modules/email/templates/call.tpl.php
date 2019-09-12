<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="90"><?php echo L('id')?>:</th>
		<td><?php echo $an_info['id']?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('接收邮箱')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['ids'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('邮件标题')?>:</th>
        <td><?php echo L(addslashes(htmlspecialchars($an_info['emailetitle'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('邮件内容')?>:</th>
		<td><textarea readonly/disabled name="an_info[emailcontent]" id="emailcontent" rows=12 cols=65><?php echo L(addslashes(htmlspecialchars($an_info['emailcontent'])))?></textarea></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('回信时间')?>:</th>
		<td><?php echo date('Y-m-d H:i', $an_info['addtime'])?></td>
	</tr>
    </tbody>
</table>
</div>
</body>
</html>