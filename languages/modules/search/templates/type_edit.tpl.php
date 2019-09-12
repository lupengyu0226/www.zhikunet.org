<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L("input").L('type_name')?>",onfocus:"<?php echo L("input").L('type_name')?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('type_name')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('type_name').L('format_incorrect', '','member')?>"});
	})
//-->
</script>
<div class="pad-lr-10">
<form action="?app=search&controller=search_type&view=edit" method="post" id="myform">
	<table width="100%"  class="table_form">
	<tr>
    <th width="120"><?php echo L('select_module_name')?>：</th>
    <td class="y-bg"><?php
	if($modelid && $typedir == 'yp') {
		$module = 'yp';
	} elseif($modelid && $typedir != 'yp') {
		$module = 'content';
	} else {
		$module = $module;
	}
	echo form::select($module_data,$module,'name="module" onchange="change_module(this.value)" disabled')?></td>
	<input name="module" type="hidden" value="<?php echo $module?>"><input name="typedir" type="hidden" value="<?php echo $typedir?>">
  </tr>

  <?php if($modelid && $typedir != 'yp') {?>
  <tr id="modelid_display">
    <th width="120"><?php echo L('select_model_name')?>：</th>
    <td class="y-bg"><?php echo form::select($model_data,$modelid,'name="info[modelid]"')?></td>
  </tr>
  <?php }?>

  <?php if($modelid && $typedir == 'yp') {?>
  <tr id="yp_modelid_display">
    <th width="120"><?php echo L('select_model_name')?>：</th>
    <td class="y-bg"><?php echo form::select($yp_model_data,$modelid,'name="info[yp_modelid]"')?></td>
  </tr>
  <?php }?>

  <tr>
    <th width="120"><?php echo L('type_name')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="info[name]" id="name" size="30" value="<?php echo $name?>"/></td>
  </tr>
    <tr>
    <th><?php echo L('description')?>：</th>
    <td class="y-bg"><textarea name="info[description]" maxlength="255" style="width:300px;height:60px;"><?php echo $description?></textarea></td>
  </tr>
  <tr>
      <th><strong><?php echo L('可用风格')?>：</strong></th>
        <td><?php echo form::select($template_list, $r['style'], 'name="info[style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?></td>
  </tr>
  <tr>
    <th><?php echo L('template_select')?>：</th>
    <td  id="template"><?php if ($r['style']) echo '<script type="text/javascript">$.getJSON(\'?app=search&controller=search_type&view=public_tpl_file_list&style='.$r['style'].'&id='.$r['template'].'&module=search&templates=list&name=search&safe_edi=\'+safe_edi, function(data){$(\'#template\').html(data.template);});</script>'?></td>
  </tr>
</table>

<div class="bk15"></div>
	<input type="hidden" name="typeid" value="<?php echo $typeid?>"> 
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>

</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function change_module(module) {
		redirect('?app=search&controller=search_type&view=edit&typeid=<?php echo $typeid?>&module='+module+'&safe_edi=<?php echo $_SESSION['safe_edi']?>');
	}
  function load_file_list(id) {
    $.getJSON('?app=search&controller=search_type&view=public_tpl_file_list&style='+id+'&module=search&templates=list&name=search&safe_edi='+safe_edi, function(data){$('#template').html(data.template);});
  }
//-->
</SCRIPT>
</body>
</html>
