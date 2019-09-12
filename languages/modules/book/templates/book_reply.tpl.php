<?php
defined('IN_SHUYANG') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<div class="col-tab">
<fieldset>
	<legend><?php echo L('reply');?></legend>
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<?php
if (is_array($infos)){
	foreach ($infos as $info){
?>

	<tr>
		<th width="20%"><?php echo L('username');?></th>
		<td><?php echo $info['realname'];?></td>
	</tr>
	<tr>
		<th width="20%">E-mail</th>
		<td><?php echo $info['email'];?></td>
	</tr>    
	<tr>
		<th width="20%"><?php echo L('mobile');?></th>
		<td><?php echo $info['mobile'];?></td>
	</tr>
	<tr>
		<th><?php echo L('title');?></th>
		<td><?php echo $info['title'];?></td>
	</tr>
	<tr>
		<th><?php echo L('content');?></th>
		<td><?php echo $info['content'];?></td>
	</tr>
 	<tr>
        
			<th>发布者</th>
			<td>发布内容</td>
			<td>管理操作</td>
 </tr>
<?php }}?>
<?php
if (is_array($infos_reply)){
	foreach ($infos_reply as $info){
		if ($info['role'] == 1){
?>
 	<tr>
		<th><?php echo L('user_reply');?></th>
		<td><?php echo $info['reply'];?></td>
		<td width="20%"><a href='?app=book&controller=book&view=delete_d&id=<?php echo $info['id'];?>' onClick="return confirm('<?php echo L('confirm', array('message' => L('user_reply')))?>')"><?php echo L('delete')?></a></td>
	</tr>
<?php }else{ ?>
 <tr>

		<th><?php echo L('admin_reply');?></th>
		<td><?php echo $info['reply'];?></td>
		<td width="20%"><a href='?app=book&controller=book&view=delete_d&id=<?php echo $info['id'];?>' onClick="return confirm('<?php echo L('confirm', array('message' => L('admin_reply')))?>')"><?php echo L('delete')?></a></td>
	</tr>
<?php } ?>
<?php }}?>
	<tr>
	<form action="?app=book&controller=book&view=reply&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
	  <th><?php echo L('reply');?></th>
	  <td> 
	    <textarea name="reply" id="reply" cols="45" rows="5"></textarea><?php echo form::editor('reply');?>
		<div class="bk15"></div>
		<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
		</form>
		</tr>
</table>
</fieldset>
</div>
</body>
</html>
