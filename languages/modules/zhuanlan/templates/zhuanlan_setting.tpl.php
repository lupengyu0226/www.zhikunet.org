<?php
defined('IN_ADMIN') or exit('The resource access forbidden.');
include $this->admin_tpl('header', 'admin');?>
<script type="text/javascript">
    <!--
    $(function(){
     $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.layer.alert(msg, {icon: 5,end: function(){ $(obj).focus();}})}});
     $("#domain").formValidator({onshow:" ",onfocus:"<?php echo L('domain_name_format');?>",tipcss:{width:'300px'}, empty:true}).inputValidator({onerror:"<?php echo L('domain_name_format');?>"}).regexValidator({regexp:"^(http(s)?:)?\/\/([a-z0-9\\-\\.]+)\/$",onerror:"<?php echo L('domain_end_string');?>"});
    })
    //-->
</script>
<form method="post" action="?app=zhuanlan&controller=zhuanlan&view=setting">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form"> 
	<tr>
		<th width="20%"><?php echo L('enable_status')?></th>
		<td><input name="setting[status]" value="1" type="radio" <?php if($status == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	 <input name="setting[status]" value="0" type="radio" <?php if($status == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>

		<tr>
	      <th><?php echo L('index_urlruleid')?></th>
	      <td><?php	echo form::urlrule('zhuanlan','index',0,$index_urlruleid,'name="setting[index_urlruleid]"');?></td>
       </tr>
		<tr>
	      <th><?php echo L('show_urlruleid')?></th>
	      <td><?php	echo form::urlrule('zhuanlan','list',0,$show_urlruleid,'name="setting[show_urlruleid]"');?></td>
       </tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" value="<?php echo L('submit')?>" class="button">&nbsp;</td>
	</tr>
</table>
</form>
</body>
</html>