<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<form method="post" action="?app=license&controller=admin_license&view=notice_add" name="myform" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<tr>
		<th width="90"><?php echo L('title')?>：</th>
		<td><input name="notice[title]" id="title" class="input-text" type="text" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('content')?>：</th>
		<td><input name="notice[content]" id="content" size="50" >  只能发布50字内</td>
	</tr>
	<tr>
		<th width="90"><?php echo L('url')?>：</th>
		<td><input name="notice[url]" id="url" size="50" ></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('notice_starttime')?>：</th>
		<td><?php echo form::date('notice[starttime]', date('Y-m-d H:i:s'), 1)?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('notice_endtime')?>：</th>
		<td><?php echo form::date('notice[endtime]', $an_info['endtime'], 1);?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('license_tui')?></th>
		<td><input name="notice[tui]" type="radio" value="1" checked>&nbsp;<?php echo L('tui')?>&nbsp;&nbsp;<input name="notice[tui]" type="radio" value="0">&nbsp;<?php echo L('untui')?></td>
	</tr>
	<tr>
		<th width="90"><?php echo L('xiaoxishenhe')?></th>
		<td><input name="notice[passed]" type="radio" value="1" checked>&nbsp;<?php echo L('pass')?>&nbsp;&nbsp;<input name="notice[passed]" type="radio" value="0">&nbsp;<?php echo L('unpass')?></td>
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
	$('#title').formValidator({onshow:"<?php echo L('input_license_domain')?>",onfocus:"<?php echo L('domain_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('domain_cannot_empty')?>"}).ajaxValidator({type:"get",url:"",data:"app=license&controller=admin_license&view=public_check_notice",datatype:"html",cached:false,async:'true',success : function(data) {
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
});
</script>
