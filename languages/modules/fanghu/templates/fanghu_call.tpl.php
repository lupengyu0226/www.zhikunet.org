<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="90"><?php echo L('ttime')?>:</th>
		<td><?php echo $an_info['ttime']?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('ip')?>:</th>
		<td><?php echo $an_info['ip']?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('iparea')?>:</th>
		<td><?php echo $ip_area->get($an_info['ip']); ?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('wangzhi')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['wangzhi'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('page')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['page'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('method')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['method'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('rkey')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['rkey'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('user_agent')?>:</th>
		<td><?php echo L(addslashes(htmlspecialchars($an_info['user_agent'])))?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('request_url')?>:</th>
                 <td><textarea readonly/disabled name="fanghu[request_url]" id="request_url" rows=12 cols=65><?php echo L(addslashes(htmlspecialchars($an_info['request_url'])))?></textarea></td>

	</tr>
	<tr>
		<th width="90"><?php echo L('rdata')?>:</th>
		<td><textarea readonly/disabled name="fanghu[rdata]" id="rdata" rows=12 cols=65><?php echo L(addslashes(htmlspecialchars($an_info['rdata'])))?></textarea></td>
	</tr>
    </tbody>
</table>
</div>
</body>
</html>