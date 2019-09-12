<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<form action="?app=weixin&controller=reply&view=noreply" method="post" id="myform">
<fieldset>
	<legend><?php echo L('回答不上来配置')?></legend>
    
	<table width="100%"  class="table_form">
    
  <tr>
    <th width="120">回复内容：</th>
    <td class="y-bg"><textarea name="reply" cols="70" rows="10"><?php echo $setting['noreply']?></textarea> <?php echo L('输入要显示的内容')?></td>
  </tr>
 
 
  
</table>

<div class="bk15"></div>
<input type="submit" id="dosubmit" name="dosubmit" class="button" value="<?php echo L('submit')?>" />
</fieldset>
</form>
</body>
</html>
 