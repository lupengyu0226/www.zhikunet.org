<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#kuaixun_name").formValidator({onshow:"<?php echo L("input").L('kuaixun_name')?>",onfocus:"<?php echo L("input").L('kuaixun_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('kuaixun_name')?>"});
 	$("#kuaixun_url").formValidator({onshow:"<?php echo L("input").L('url')?>",onfocus:"<?php echo L("input").L('url')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('url')?>"}).regexValidator({regexp:"^[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&]*([^<>])*$",onerror:"<?php echo L('kuaixun_onerror')?>"})
	})
//-->
</script>
<div class="pad_10">
<form action="?app=kuaixun&controller=kuaixun&view=add" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">	
	<tr>
		<th width="20%">所属类型：</th>
		<td><select name="kuaixun[lx]" id="">
				<option value="快讯" >快讯</option>
				<option value="大事" >大事</option>
				<option value="美图" >美图</option>
				<option value="预告" >预告</option>
				<option value="直播" >直播</option>
				<option value="论坛" >论坛</option>
				<option value="回放" >回放</option>
					 
		</select></td>
	</tr>
	<tr>
		<th width="100"><?php echo L('kuaixun_name')?>：</th>
		<td><input type="text" name="kuaixun[name]" id="kuaixun_name" size="30" class="input-text"></td>
	</tr>
	<tr>
		<th width="100"><?php echo L('url')?>：</th>
		<td><input type="text" name="kuaixun[url]" id="kuaixun_url" size="30" class="input-text"></td>
	</tr>
 
	<tr>
		<th><?php echo L('elite')?>：</th>
		<td><input name="kuaixun[elite]" type="radio" value="1" >&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input
			name="kuaixun[elite]" type="radio" value="0" checked>&nbsp;<?php echo L('no')?></td>
	</tr>
	<tr>
		<th><?php echo L('passed')?>：</th>
		<td><input name="kuaixun[passed]" type="radio" value="1" checked>&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input
			name="kuaixun[passed]" type="radio" value="0">&nbsp;<?php echo L('no')?></td>
	</tr>
<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?app=kuaixun&controller=kuaixun&view=add"> <input
		type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>
</table>
</form>
</div>
</body>
</html> 
