<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<form method="post" action="?app=book&controller=book&view=setting">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form"> 
	<tr>
		<th width="20%"><?php echo L('is_check');?></th>
		<td><input type='radio' name='setting[is_check]' value='1' <?php if($is_check == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[is_check]' value='0' <?php if($is_check == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('enablecheckcode');?></th>
		<td><input type='radio' name='setting[enablecheckcode]' value='1' <?php if($enablecheckcode == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcode]' value='0' <?php if($enablecheckcode == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	 	<tr>
		<th><?php echo L('telnotice');?></th>
		<td><input type='radio' name='setting[telnotice]' value='1' <?php if($telnotice == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[telnotice]' value='0' <?php if($telnotice == 0) {?>checked<?php }?>> <?php echo L('no')?>
	  &nbsp;&nbsp;&nbsp;&nbsp;<?php if ($sms['1']['sms_enable'] !=1) echo L('no_sms');?></td>
	</tr>
		<tr>
		<th><?php echo L('mailnotice');?></th>
		<td><input type='radio' name='setting[mailnotice]' value='1' <?php if($mailnotice == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[mailnotice]' value='0' <?php if($mailnotice == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<td>　</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="button">&nbsp;</td>
	</tr>
</table>
</form>
</body>
</html>
