<?php
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=zhuanlan&controller=zhuanlan&view=edit&id=<?php echo $id; ?>" method="post" id="myform" class="form-horizontal layer">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100"><?php echo L('username')?>：</th>
		<td><?php echo $data['username']?></td>
	</tr>
	
	<tr>
		<th width="100"><?php echo L('zhuanlan_name')?>：</th>
		<td><input type="text" name="info[name]" id="name" size="30" class="input-text" value="<?php echo $data['name']?>"></td>
	</tr>
	<tr>
		<th width="100"><?php echo L('zhuanlan_domain')?>：</th>
		<td><input type="text" name="info[domain]" id="domain" size="30" class="input-text" value="<?php echo $data['domain']?>">.shuyanghao.com</td>
	</tr>
	<tr>
		<th><?php echo L('zhuanlan_thumb')?>：</th>
		<td><?php echo form::images('info[thumb]', 'thumb', $data['thumb'], 'zhuanlan',$id);?></td>
	</tr>

 
	<tr>
		<th><?php echo L('authors')?>：</th>
		<td><textarea name="info[authors]" class="form-control" style="width:90%;height: 100px"><?php echo $data['authors']?></textarea></td>
	</tr>
	 
	<tr>
		<th><?php echo L('status')?>：</th>
		<td><input name="info[status]" type="radio" value="1" <?php if($data['status']==1){echo "checked";}?> onclick="$('#cause').hide()">&nbsp;<?php echo L('status_on')?>&nbsp;&nbsp;<input name="info[status]" type="radio" value="0" <?php if($data['status']==0){echo "checked";}?> style="border:0" onclick="$('#cause').show()">&nbsp;<?php echo L('status_off')?>&nbsp;&nbsp;<input name="info[status]" type="radio" value="2" <?php if($data['status']==2){echo "checked";}?> style="border:0" onclick="$('#cause').show()">&nbsp;<?php echo L('拒绝')?></td>
	</tr>
		<?php if($data['status']!=1){?>
	<tr id="cause">
		<th>拒绝原因：</th>
		<td><textarea name="info[cause]" class="form-control" style="width:90%;height: 20px"><?php echo $data['cause']?></textarea></td>
	</tr>
		<?php }	?>
    <tr>
		<th></th>
		<td><input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" /></td>
	</tr>
</table>
</form>
</div>
</body>
</html>

