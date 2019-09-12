<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="50"><?php echo L('ID')?>:</th>
		<td><?php echo $an_info['id']?></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('username')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['username'])))?> userid:<?php echo $an_info['userid']==0 ? L('游客') : $an_info['userid']?> </td>
	</tr>
	<tr>
		<th width="50"><?php echo L('email')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['email'])))?></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('title')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['title'])))?></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('type')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['type'])))?></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('url')?>:</th>
		<td><a href="<?php echo L(addslashes(htmlspecialchars($an_info['url'])))?>" target="_blank"><?php echo L(addslashes(htmlspecialchars($an_info['url'])))?></a></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('content')?>:</th>
                 <td><textarea readonly/disabled name="onlines[content]" id="content" rows=12 cols=60><?php echo L(addslashes(htmlspecialchars($an_info['content'])))?></textarea></td>

	</tr>
	<tr>
		<th width="50"><?php echo L('jianyi')?>:</th>
		<td><textarea readonly/disabled name="onlines[jianyi]" id="jianyi" rows=5 cols=60><?php echo L(addslashes(htmlspecialchars($an_info['jianyi'])))?></textarea></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('status')?>:</th>
    <td width="20%" ><a href="?app=onlines&controller=onlines&view=public_status&id=<?php echo $an_info['id']?>&status=<?php echo $an_info['status']==0 ? 1 : 0?>"><?php echo $an_info['status']==0 ? L('status_0') : L('status_1')?></a></td>
	</tr>
	<tr>
		<th width="50"><?php echo L('adddate')?>:</th>
		<td><?php echo date('Y-m-d H:i:s', $an_info['adddate'])?></td>
	</tr>
    </tbody>
</table>
</div>
</body>
</html>