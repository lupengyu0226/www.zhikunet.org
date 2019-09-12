<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<form method="post" action="?app=kuaixun&controller=kuaixun&view=setting">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form"> 
 
	<tr>
		<th width="20%"><?php echo L('是否开启')?>：</th>
		<td><input type='radio' name='setting[is_post]' value='1' <?php if($is_post == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[is_post]' value='0' <?php if($is_post == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>	 
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="button">&nbsp;</td>
	</tr>
</table>
</form>
</body>
</html>
 
