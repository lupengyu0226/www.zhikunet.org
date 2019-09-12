<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="50"><?php echo L('ID')?>:</th>
		<td><?php echo $infos['id']?></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('username')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($infos['username'])))?> userid:<?php echo $infos['userid']==0 ? L('游客') : $infos['userid']?> </td>
	</tr>
	<tr>
		<th width="50">标题:</th>
		<td><?php echo L(addslashes(htmlspecialchars($infos['title'])))?></td>
	</tr>

	<tr>
		<th width="50">网址:</th>
		<td><a href="<?php echo L(addslashes(htmlspecialchars($infos['url'])))?>" target="_blank"><?php echo L(addslashes(htmlspecialchars($infos['url'])))?></a></td>
	</tr>
	<tr>
		<th width="50">说明:</th>
                 <td><textarea readonly/disabled name="jubao[content]" id="content" rows=12 cols=60><?php echo L(addslashes(htmlspecialchars($infos['content'])))?></textarea></td>

	</tr>
	<tr>
		<th width="50">处理意见:</th>
    <td width="20%" ><a href="?app=member&controller=admin_press&view=public_status&id=<?php echo $infos['id']?>&passed=<?php echo $infos['passed']==0 ? 1 : 0?>"><?php echo $infos['passed']==0 ? L('status_0') : L('status_1')?></a></td>
	</tr>
	<tr>
		<th width="50">提交时间:</th>
		<td><?php echo date('Y-m-d H:i:s', $infos['addtime'])?></td>
	</tr>
    </tbody>
</table>
</div>
</body>
</html>