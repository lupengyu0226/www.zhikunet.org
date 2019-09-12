<?php defined('IN_ADMIN') or exit('The resource access forbidden.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<div class="bk15"></div>
<fieldset>
<legend>【<?php echo $data['name'] ?>】<?php echo L('publish_the_list')?></legend>
<div class="bk15"></div>
<?php
foreach($program_list as $k=>$v) {
	echo form::radio(array($v['id']=>$cat[$v['catid']]['catname']), '', 'name="programid"', 150);
?>                                        
<span style="margin-right:10px;"><a href="?app=collection&controller=node&view=import_program_del&nodeid=<?php echo $v['id'] ?>" style="color:#ccc"><?php echo L('delete')?></a>  
	<a href="?app=collection&controller=node&view=import_program_edit&id=<?php echo $v['id'] ?>&nodeid=<?php echo $v['nodeid'] ?>" style="color:#ccc"><?php echo L('edit')?></a></span>
<?php
	}

?>
</div>
</body>
</html>