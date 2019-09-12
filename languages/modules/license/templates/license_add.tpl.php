<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<form method="post" action="?app=license&controller=admin_license&view=add" name="myform" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<tr>
		<th width="90"><?php echo L('license_domain')?>：</th>
		<td><input name="license[domain]" id="domain" class="input-text" type="text" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('license_content')?>：</th>
		<td><input name="license[content]" id="content" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('webname')?>：</th>
		<td><input name="license[webname]" id="webname" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('type')?>：</th>
		<td><select name="license[typeid]" id="">
		<?php
		  $i=0;
		  foreach($types as $typeid=>$type){
		  $i++;
		?>
		<option value="<?php echo $type['typeid'];?>"><?php echo $type['name'];?></option>
		<?php }?>
		</select></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('shouquanstart')?>：</th>
		<td><?php echo form::date('license[shouquanstart]', date('Y-m-d H:i:s'), 1)?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('shouquanend')?>：</th>
		<td><?php echo form::date('license[shouquanend]', $an_info['shouquanend'], 1);?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('startdate')?>：</th>
		<td><?php echo form::date('license[starttime]', date('Y-m-d H:i:s'), 1)?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('enddate')?>：</th>
		<td><?php echo form::date('license[endtime]', $an_info['endtime'], 1);?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('icd')?>：</th>
		<td><input name="license[icd]" id="icd" value="<?php echo code::create_guid();?>" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('license_status')?></th>
		<td><input name="license[passed]" type="radio" value="1" checked>&nbsp;<?php echo L('pass')?>&nbsp;&nbsp;<input name="license[passed]" type="radio" value="0">&nbsp;<?php echo L('unpass')?></td>
	</tr>
	</tbody>
</table>
<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="dialog">&nbsp;<input type="reset" class="dialog" value=" <?php echo L('clear')?> ">
</form>
</div>
</body>
</html>
<script type="text/javascript">
function load_file_list(id) {
	if (id=='') return false;
	$.getJSON('?app=admin&controller=category&view=public_tpl_file_list&style='+id+'&module=license&templates=show&name=license&safe_edi='+safe_edi, function(data){$('#show_template').html(data.show_template);});
}

$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#domain').formValidator({onshow:"<?php echo L('input_license_domain')?>",onfocus:"<?php echo L('domain_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('domain_cannot_empty')?>"}).ajaxValidator({type:"get",url:"",data:"app=license&controller=admin_license&view=public_check_domain",datatype:"html",cached:false,async:'true',success : function(data) {
        if( data == "1" )
		{
            return true;
		}
        else
		{
            return false;
		}
	},
	error: function(){alert("<?php echo L('server_no_data')?>");},
	onerror : "<?php echo L('license_exist')?>",
	onwait : "<?php echo L('checking')?>"
	});
	$('#starttime').formValidator({onshow:"<?php echo L('select_stardate')?>",onfocus:"<?php echo L('select_stardate')?>",oncorrect:"<?php echo L('right_all')?>"});
	$('#endtime').formValidator({onshow:"<?php echo L('select_downdate')?>",onfocus:"<?php echo L('select_downdate')?>",oncorrect:"<?php echo L('right_all')?>"});
	$("#content").formValidator({autotip:true,onshow:"",onfocus:"<?php echo L('licensements_cannot_be_empty')?>"}).functionValidator({
	    fun:function(val,elem){
	    //获取编辑器中的内容
		var oEditor = CKEDITOR.instances.content;
		var data = oEditor.getData();
        if(data==''){
		    return "<?php echo L('licensements_cannot_be_empty')?>"
	    } else {
			return true;
		}
	}
	});
	$('#style').formValidator({onshow:"<?php echo L('select_style')?>",onfocus:"<?php echo L('select_style')?>",oncorrect:"<?php echo L('right_all')?>"}).inputValidator({min:1,onerror:"<?php echo L('select_style')?>"});
});
</script>
