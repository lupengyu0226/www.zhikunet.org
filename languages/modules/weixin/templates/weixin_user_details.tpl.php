<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table class="table_form" width="100%">
<tbody>
    <tr>
		<th width="100">头像：</th>
		<td><img name="head" src="<?php echo $infos['headimgurl'];?>" width="120" height="120" alt="<?php echo $infos['nickname'];?>" /></td>
	</tr>
	<tr>
		<th width="100">昵称：</th>
		<td><?php echo $infos['nickname'];?></td>
	</tr>
     <tr>
		<th width="100">性别：</th>
		<td><?php if($infos['sex']==1){echo '男';}elseif($infos['sex']==2){echo '女';}else{echo '保秘';}?></td>
	</tr>
     <tr>
		<th width="100">地区：</th>
		<td><?php echo $infos['country'].'-'.$infos['province'].'-'.$infos['city'];?></td>
	</tr>
     <tr>
		<th width="100">关注时间:</th>
		<td><?php echo date("Y-m-d H:i:s",$infos['subscribe_time']);?></td>
	</tr>
    <tr>
		<th width="100">openid:</th>
		<td><?php echo rtrim($infos['openid'],"\@");?></td>
	</tr>
	<tr>
		<th width="100">平台:</th>
		<td><?php echo $infos['platform'];?></td>
	</tr>
	<tr>
		<th width="80">备注：</th>
		<td>
		<?php echo $infos['remark'] ?>
		</td>
	</tr>
	<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'details'}).close();"/>
</table>
</div>
</body>
</html> 