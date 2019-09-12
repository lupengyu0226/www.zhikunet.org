<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#phone_name").formValidator({onshow:"<?php echo L("input").L('phone_name')?>",onfocus:"<?php echo L("input").L('phone_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('phone_name')?>"});
 	$("#phone_url").formValidator({onshow:"<?php echo L("input").L('url')?>",onfocus:"<?php echo L("input").L('url')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('url')?>"}).regexValidator({regexp:"^[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&]*([^<>])*$",onerror:"<?php echo L('phone_onerror')?>"})
	})
//-->
</script>
<div class="pad_10">
<form action="?app=phone&controller=phone&view=add" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">	
	<tr>
		<th width="100"><?php echo L('phone_name')?>：</th>
		<td><input type="text" name="phone[name]" id="phone_name"
			size="30" class="input-text"></td>
	</tr>
	<tr>
		<th width="100"><?php echo L('url')?>：</th>
		<td><input type="text" name="phone[url]" id="phone_url"
			size="30" class="input-text"></td>
	</tr>
	<tr>
		<th width="100"><?php echo L('username')?>：</th>
		<td><input type="text" name="phone[username]" id="phone_username"
			size="30" class="input-text"></td>
	</tr>
 
	<tr>
		<th><?php echo L('web_description')?>：</th>
		<td><textarea name="phone[introduce]" id="introduce" cols="50"
			rows="6"></textarea></td>
	</tr>
 
	<tr>
		<th><?php echo L('elite')?>：</th>
		<td><input name="phone[elite]" type="radio" value="1" >&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input
			name="phone[elite]" type="radio" value="0" checked>&nbsp;<?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('passed')?>：</th>
		<td><input name="phone[passed]" type="radio" value="1" checked>&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input
			name="phone[passed]" type="radio" value="0">&nbsp;<?php echo L('no')?></td>
	</tr>
<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?app=phone&controller=phone&view=add"> <input
		type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>
</table>
</form>
</div>
</body>
</html> 
