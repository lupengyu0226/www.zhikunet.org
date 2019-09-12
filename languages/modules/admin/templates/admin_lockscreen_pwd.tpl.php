<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;include $this->admin_tpl('header');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#old_lockscreen").formValidator({empty:false,onshow:"<?php echo L('input').L('old_password')?>",onfocus:"<?php echo L('lockscreen').L('between_6_to_20')?>",oncorrect:"<?php echo L('old_password_right')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('lockscreen').L('between_6_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"app=admin&controller=admin_manage&view=public_lockscreen_ajx",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('old_password_wrong')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#new_lockscreen").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('lockscreen').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('lockscreen').L('between_6_to_20')?>"});
	$("#new_lockscreenconfirm").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"new_lockscreen",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
  })
</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?app=admin&controller=admin_manage&view=public_lockscreen_pw" method="post" id="myform">
<input type="hidden" name="info[userid]" value="<?php echo $userid?>"></input>
<input type="hidden" name="info[username]" value="<?php echo $username?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td width="80"><?php echo L('username')?></td> 
<td><?php echo $username?> (<?php echo L('realname')?> <?php echo $realname?>)</td>
</tr>

<tr>
<td><?php echo L('email')?></td>
<td>
<?php echo $email?>
</td>
</tr>
<tr>
<td><?php echo L('oldlockscreen')?></td> 
<td><input type="password" name="old_lockscreen" id="old_lockscreen" class="input-text"></input></td>
</tr>

<tr>
<td><?php echo L('newlockscreen')?></td> 
<td><input type="password" name="new_lockscreen" id="new_lockscreen" class="input-text"></input></td>
</tr>
<tr>
<td><?php echo L('lockscreenconfirm')?></td> 
<td><input type="password" name="new_lockscreenconfirm" id="new_lockscreenconfirm" class="input-text"></input></td>
</tr>
</table>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
