<?php
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=weixin&controller=usermanage&view=editgroup&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="20%">分组名称：</th>
		<td><input type="text" name="group[name]" value="<?php echo $name?>" size="30"></td>
	</tr>

<tr>
		<th></th>
		<td>
        <input name="group[id]" type="hidden" value="<?php echo $id; ?>" />
        <input type="hidden" name="forward" value="?app=weixin&controller=usermanage&view=editgroup"> 
        <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
        </td>
		
		
	</tr>

</table>
</form>
</div>
</body>
</html>

