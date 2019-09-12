<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#type_name").formValidator({onshow:"<?php echo L("input").L('分类名称')?>",onfocus:"<?php echo L("input").L('分类名称')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('分类名称')?>"}).ajaxValidator({type : "get",url : "",data :"app=collection&controller=node&view=public_check_name",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('分类名称').L('exists')?>",onwait : "<?php echo L('connecting')?>"});
	 
	})
//-->
</script>
<div class="pad-lr-10">
<form action="?app=collection&controller=node&view=add_type" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	<tr>
		<th width="100"><?php echo L('分类名称')?>：</th>
		<td><input type="text" name="type[name]" id="type_name"
			size="30" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100"><?php echo L('分类排序')?>：</th>
		<td><input type="text" name="type[listorder]" id="listorder"
			size="5" class="input-text" value="0"></td>
	</tr>
	
	<tr>
		<th><?php echo L('分类说明')?>：</th>
		<td><textarea name="type[description]" id="description" cols="50"
			rows="6"></textarea></td>
	</tr>

	<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?app=collection&controller=node&view=add_type"> <input
		type="submit" name="dosubmit" id="dosubmit" class="button"
		value=" <?php echo L('submit')?> "></td>
	</tr>

</table>
</form>
</div>
</body>
</html>
