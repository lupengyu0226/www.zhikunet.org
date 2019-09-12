<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?app=mips&controller=mips_admin&view=add" method="post" id="myform">
<input type="hidden" value='<?php echo $siteid?>' name="siteid">
<fieldset>
	<legend><?php echo L('basic_config')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="120"><?php echo L('mips_sel_site')?></th>
    <td class="y-bg"><?php echo form::select($sitelist,self::get_siteid(),'name="siteid"')?></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('mips_sitename')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="sitename" id="sitename" size="30" value=""/></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('mips_logo')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="logo" id="logo" size="30" value=""/></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('mips_domain')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="domain" id="domain" size="30" value=""/> </td>
    </tr>
    </table> 
  </fieldset>
</table>
 <div class="bk10"></div>
 <fieldset>
    <legend><?php echo L('parameter_config')?></legend>  
    <table width="100%"  class="table_form">   
     <tr>
    <th width="120"><?php echo L('公众号名称')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[wxname]" id="wxname" size="20" value=""/></td>
    </tr>             
     <tr>
    <th width="120"><?php echo L(' APPID')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[wxappid]" id="wxappid" size="20" value=""/></td>
    </tr>             
     <tr>
    <th width="120"><?php echo L('APPSECRET')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[wxappsecret]" id="wxappsecret" size="20" value=""/></td>
    </tr>    
</table>
<div class="bk15"></div>
<input type="submit" id="dosubmit" name="dosubmit" class="dialog" value="<?php echo L('submit')?>" />
</fieldset>
</form>
</div>
</body>
</html>