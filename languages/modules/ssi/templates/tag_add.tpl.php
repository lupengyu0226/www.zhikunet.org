<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L('input').L('name')?>",onfocus:"<?php echo L('input').L('name')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('name')?>"}).ajaxValidator({type : "get",url : "",data :"app=ssi&controller=ssi&view=public_name",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('name').L('exists')?>",onwait : "<?php echo L('connecting')?>"});
		$("#tag").formValidator({onshow:"<?php echo L("请输入ID")?>",onfocus:"<?php echo L("请输入ID")?>",empty:false}).regexValidator({regexp:"username",datatype:'enum',param:'i',onerror:"<?php echo L("请输入正确的ID")?>"});
		$("#cache").formValidator({onshow:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",onfocus:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",empty:false}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L("cache_time_can_only_be_positive")?>"});
	})
	
//-->
</script>
<div class="pad-10">
<form action="?app=ssi&controller=ssi&view=add" method="post" id="myform">
<div>
<fieldset>
	<legend><?php echo L('ssi_call_setting')?></legend>
	<table width="100%"  class="table_form">
      <tr>
            <th valign="top"><?php echo L('block').L('name')?>：</th>
            <td class="y-bg"><input type="text" name="name" size="25" id="name"><script type="text/javascript">$(function(){$("#name").formValidator({onshow:"<?php echo L('please_input_block_name')?>",onfocus:"<?php echo L('please_input_block_name')?>"}).inputValidator({min:1, onerror:'<?php echo L('please_input_block_name')?>'});});</script></td>
      </tr>
	<tr>
		<th width="20%"><?php echo L('分类')?>：</th>
		<td><select name="typeid" id="">
		<option value="0">默认分类</option>
		<?php
		  $i=0;
		  foreach($types as $typeid=>$type){
		  $i++;
		  //var_dump($type);
		?>
		<option value="<?php echo $type['typeid'];?>"><?php echo $type['name'];?></option>
		<?php }?>
		</select></td>
	</tr>
      <tr>
            <th valign="top"><?php echo L('block').L('id')?>：</th>
            <td class="y-bg"><input type="text" name="tag" size="25" id="tag"></td>
      </tr>

    <tr>
		<th valign="top"><?php echo L('custom_sql')?>：</th>
		<td class="y-bg"><textarea name="data" id="data" style="width:500px;height:200px;"></textarea></td>
  </tr>


	<tr>
		<th width="80"><?php echo L('cache_times')?>：</th>
		<td class="y-bg"><input type="text" name="cache" id="cache" size="30" value="" /></td>
	</tr>

</table>
</fieldset>
<div class="bk15"></div>
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="" />
</div>
</form>
</div>
</body>
</html>
